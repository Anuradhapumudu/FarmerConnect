<?php
class PaymentGateway extends Controller {
    private $paypal;

    public function __construct() {
        parent::__construct();
        
        // PayPal configuration
        $this->configurePayPal();
    }

    private function configurePayPal() {
        require_once APPROOT . '/vendor/autoload.php'; // If using Composer
        
        $apiContext = new \PayPal\Rest\ApiContext(
            new \PayPal\Auth\OAuthTokenCredential(
                'YOUR_SANDBOX_CLIENT_ID',     // Replace with your sandbox client ID
                'YOUR_SANDBOX_SECRET'         // Replace with your sandbox secret
            )
        );

        $apiContext->setConfig([
            'mode' => 'sandbox', // sandbox or live
            'log.LogEnabled' => true,
            'log.FileName' => APPROOT . '/logs/PayPal.log',
            'log.LogLevel' => 'DEBUG'
        ]);

        $this->paypal = $apiContext;
    }

    public function onlinePayment() {
        // Get product details from query parameters
        $product_id = $_GET['product_id'] ?? null;
        $quantity = $_GET['quantity'] ?? 1;

        if (!$product_id) {
            header("Location: " . URLROOT . "/Marketplace/farmer");
            exit;
        }

        // Fetch product details
        $marketplaceModel = $this->model('M_Marketplace/M_Marketplace', new Database());
        $product = $marketplaceModel->getProductByInternalId($product_id);

        if (!$product) {
            $_SESSION['error'] = "Product not found";
            header("Location: " . URLROOT . "/Marketplace/farmer");
            exit;
        }

        $total_price = $product->price_per_unit * $quantity;

        $data = [
            'product' => $product,
            'quantity' => $quantity,
            'total_price' => $total_price,
            'paypal_client_id' => 'YOUR_SANDBOX_CLIENT_ID' // Your PayPal sandbox client ID
        ];

        $this->view('marketplace/V_onlinePayment', $data);
    }

    public function createPayment() {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            echo json_encode(['success' => false, 'message' => 'Invalid request']);
            return;
        }

        $product_id = $_POST['product_id'] ?? null;
        $quantity = intval($_POST['quantity'] ?? 1);

        if (!$product_id) {
            echo json_encode(['success' => false, 'message' => 'Product ID required']);
            return;
        }

        // Fetch product
        $marketplaceModel = $this->model('M_Marketplace/M_Marketplace', new Database());
        $product = $marketplaceModel->getProductByInternalId($product_id);

        if (!$product) {
            echo json_encode(['success' => false, 'message' => 'Product not found']);
            return;
        }

        $total_price = $product->price_per_unit * $quantity;

        try {
            $payer = new \PayPal\Api\Payer();
            $payer->setPaymentMethod('paypal');

            $amount = new \PayPal\Api\Amount();
            $amount->setTotal(number_format($total_price, 2, '.', ''))
                   ->setCurrency('LKR'); // Or 'USD' if preferred

            $transaction = new \PayPal\Api\Transaction();
            $transaction->setAmount($amount)
                       ->setDescription("Purchase: {$product->item_name}")
                       ->setInvoiceNumber(uniqid());

            $redirectUrls = new \PayPal\Api\RedirectUrls();
            $baseUrl = URLROOT;
            $redirectUrls->setReturnUrl("{$baseUrl}/PaymentGateway/executePayment")
                        ->setCancelUrl("{$baseUrl}/PaymentGateway/paymentCancel");

            $payment = new \PayPal\Api\Payment();
            $payment->setIntent('sale')
                   ->setPayer($payer)
                   ->setTransactions([$transaction])
                   ->setRedirectUrls($redirectUrls);

            $payment->create($this->paypal);

            // Store payment info in session for verification
            $_SESSION['paypal_payment_id'] = $payment->getId();
            $_SESSION['product_id'] = $product_id;
            $_SESSION['quantity'] = $quantity;
            $_SESSION['total_price'] = $total_price;

            echo json_encode([
                'success' => true, 
                'approvalUrl' => $payment->getApprovalLink()
            ]);

        } catch (Exception $e) {
            error_log("PayPal Error: " . $e->getMessage());
            echo json_encode([
                'success' => false, 
                'message' => 'Payment creation failed: ' . $e->getMessage()
            ]);
        }
    }

    public function executePayment() {
        $paymentId = $_GET['paymentId'] ?? $_SESSION['paypal_payment_id'] ?? null;
        $payerId = $_GET['PayerID'] ?? null;

        if (!$paymentId || !$payerId) {
            $_SESSION['error'] = "Payment failed: Invalid parameters";
            header("Location: " . URLROOT . "/Marketplace/farmer");
            exit;
        }

        try {
            $payment = \PayPal\Api\Payment::get($paymentId, $this->paypal);
            $execution = new \PayPal\Api\PaymentExecution();
            $execution->setPayerId($payerId);

            $result = $payment->execute($execution, $this->paypal);

            if ($result->getState() === 'approved') {
                // Payment successful - create order
                $this->createOrderAfterPayment();
                
                // Clear session
                unset($_SESSION['paypal_payment_id'], $_SESSION['product_id'], 
                      $_SESSION['quantity'], $_SESSION['total_price']);
                
                header("Location: " . URLROOT . "/Marketplace/paymentSuccess");
                exit;
            } else {
                throw new Exception('Payment not approved');
            }

        } catch (Exception $e) {
            error_log("Payment Execution Error: " . $e->getMessage());
            $_SESSION['error'] = "Payment failed: " . $e->getMessage();
            header("Location: " . URLROOT . "/PaymentGateway/paymentCancel");
            exit;
        }
    }

    private function createOrderAfterPayment() {
        $product_id = $_SESSION['product_id'] ?? null;
        $quantity = $_SESSION['quantity'] ?? null;
        $total_price = $_SESSION['total_price'] ?? null;
        $buyer_id = $_SESSION['farmer_id'] ?? $_SESSION['user_id'] ?? null;

        if (!$product_id || !$buyer_id) {
            throw new Exception('Missing order information');
        }

        $marketplaceModel = $this->model('M_Marketplace/M_Marketplace', new Database());
        $product = $marketplaceModel->getProductByInternalId($product_id);

        if (!$product) {
            throw new Exception('Product not found');
        }

        // Create order
        $marketplaceModel->createOrder(
            $buyer_id,
            $product->item_id,
            $product->seller_id,
            $quantity,
            $total_price,
            'online'
        );

        // Update stock
        $newQty = $product->available_quantity - $quantity;
        $marketplaceModel->updateStock($product->item_id, $newQty);
    }

    public function paymentCancel() {
        // Clear session
        unset($_SESSION['paypal_payment_id'], $_SESSION['product_id'], 
              $_SESSION['quantity'], $_SESSION['total_price']);
        
        $_SESSION['error'] = "Payment was cancelled";
        $this->view('marketplace/V_paymentCancel');
    }
}
?>