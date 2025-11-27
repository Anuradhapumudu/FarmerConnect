<?php
class Marketplace extends Controller {
    private $marketplaceModel;

    public function __construct() {
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
        $this->marketplaceModel = $this->model('M_Marketplace/M_Marketplace', new Database());
    }

    // Real PayPal Online Payment Page
    public function onlinePayment() {
        $product_id = $_GET['product_id'] ?? null;
        $quantity = $_GET['quantity'] ?? 1;

        if (!$product_id) {
            header("Location: " . URLROOT . "/Marketplace/farmer");
            exit;
        }

        $product = $this->marketplaceModel->getProductByInternalId($product_id);
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
            'paypal_client_id' => 'AZozDm3tasgL3JYrCFAR43HQBlu9v_mqlGqlxGd_NCnvTqScZ4zGbeqLp_QcxDUtTU1PGpyPeqZXQidB' 
        ];

        $this->view('marketplace/V_onlinePayment', $data);
    }

    // Handle PayPal Payment Success
    public function paypalSuccess() {
        // Get data from POST (PayPal webhook) or session
        $payment_id = $_POST['payment_id'] ?? $_SESSION['paypal_payment_id'] ?? null;
        $payer_id = $_POST['payer_id'] ?? $_SESSION['paypal_payer_id'] ?? null;
        
        $product_id = $_SESSION['product_id'] ?? null;
        $quantity = $_SESSION['quantity'] ?? null;
        $total_price = $_SESSION['total_price'] ?? null;
        $seller_id = $_SESSION['seller_id'] ?? null;
        $buyer_id = $_SESSION['farmer_id'] ?? $_SESSION['user_id'] ?? null;

        if (!$product_id || !$buyer_id) {
            $_SESSION['error'] = "Missing order information";
            header("Location: " . URLROOT . "/Marketplace/farmer");
            exit;
        }

        $product = $this->marketplaceModel->getProductByInternalId($product_id);
        if (!$product) {
            $_SESSION['error'] = "Product not found";
            header("Location: " . URLROOT . "/Marketplace/farmer");
            exit;
        }

        try {
            // Create order in database
            $this->marketplaceModel->createOrder(
                $buyer_id,
                $product->item_id,
                $seller_id,
                $quantity,
                $total_price,
                'online'
            );

            // Update stock
            $newQty = $product->available_quantity - $quantity;
            $this->marketplaceModel->updateStock($product->item_id, $newQty);

            // Clear session data
            unset($_SESSION['product_id'], $_SESSION['quantity'], 
                  $_SESSION['total_price'], $_SESSION['seller_id'],
                  $_SESSION['paypal_payment_id'], $_SESSION['paypal_payer_id']);

            $_SESSION['success'] = "Payment successful! Order placed. PayPal ID: " . ($payment_id ?? 'N/A');
            
            // Return success response for AJAX or redirect
            if (isset($_POST['payment_id'])) {
                echo json_encode(['success' => true, 'message' => 'Payment processed successfully']);
                exit;
            } else {
                header("Location: " . URLROOT . "/Marketplace/paymentSuccess");
                exit;
            }

        } catch (Exception $e) {
            error_log("PayPal Success Error: " . $e->getMessage());
            
            if (isset($_POST['payment_id'])) {
                echo json_encode(['success' => false, 'message' => 'Failed to process order: ' . $e->getMessage()]);
                exit;
            } else {
                $_SESSION['error'] = "Failed to process order: " . $e->getMessage();
                header("Location: " . URLROOT . "/Marketplace/paymentCancel");
                exit;
            }
        }
    }

    // Handle PayPal Payment Cancellation
    public function paypalCancel() {
        unset($_SESSION['product_id'], $_SESSION['quantity'], 
              $_SESSION['total_price'], $_SESSION['seller_id'],
              $_SESSION['paypal_payment_id'], $_SESSION['paypal_payer_id']);
        
        $_SESSION['error'] = "PayPal payment was cancelled";
        $this->view('marketplace/V_paymentCancel');
    }

    // Store order data before PayPal redirect (optional)
    public function preparePayPalOrder() {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            echo json_encode(['success' => false, 'message' => 'Invalid request']);
            exit;
        }

        $product_id = $_POST['product_id'] ?? null;
        $quantity = intval($_POST['quantity'] ?? 1);

        if (!$product_id) {
            echo json_encode(['success' => false, 'message' => 'Product ID required']);
            exit;
        }

        $product = $this->marketplaceModel->getProductByInternalId($product_id);
        if (!$product) {
            echo json_encode(['success' => false, 'message' => 'Product not found']);
            exit;
        }

        $total_price = $product->price_per_unit * $quantity;

        // Store in session for later use
        $_SESSION['product_id'] = $product_id;
        $_SESSION['quantity'] = $quantity;
        $_SESSION['total_price'] = $total_price;
        $_SESSION['seller_id'] = $product->seller_id;

        echo json_encode([
            'success' => true, 
            'amount' => number_format($total_price, 2, '.', ''),
            'currency' => 'USD'
        ]);
        exit;
    }

    // Keep your existing methods below...
    public function paymentSuccess() {
        $this->view('marketplace/V_paymentSuccess');
    }

    public function paymentCancel() {
        $_SESSION['error'] = "Payment was cancelled";
        $this->view('marketplace/V_paymentCancel');
    }

    // Buy Product
    public function buyProduct($id = null) {
        if ($id === null) {
            $_SESSION['error'] = "Product ID is required";
            header("Location: " . URLROOT . "/Marketplace/farmer");
            exit;
        }

        $product = $this->marketplaceModel->getProductByInternalId($id);
        if (!$product) {
            $_SESSION['error'] = "Product not found";
            header("Location: " . URLROOT . "/Marketplace/farmer");
            exit;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $buyer_id = $_SESSION['farmer_id'] ?? $_SESSION['user_id'] ?? null;

            if (!$buyer_id || $buyer_id == $product->seller_id) {
                $_SESSION['error'] = "You must be logged in as a farmer to buy this product.";
                header("Location: " . URLROOT . "/Users/login");
                exit;
            }

            $quantity = intval($_POST['quantity'] ?? 1);
            $payment_method = $_POST['payment_method'] ?? 'cash';

            if($quantity < 1 || $quantity > $product->available_quantity){
                $_SESSION['error'] = "Invalid quantity selected.";
                header("Location: " . URLROOT . "/Marketplace/buyProduct/".$id);
                exit;
            }

            $total_price = $product->price_per_unit * $quantity;

            if($payment_method === 'online'){
                header("Location: " . URLROOT . "/Marketplace/onlinePayment?product_id=".$product->item_id."&quantity=".$quantity);
                exit;
            } else {
                $this->marketplaceModel->createOrder(
                    $buyer_id,
                    $product->item_id,
                    $product->seller_id,
                    $quantity,
                    $total_price,
                    'cash'
                );

                $newQty = $product->available_quantity - $quantity;
                $this->marketplaceModel->updateStock($product->item_id, $newQty);

                header("Location: " . URLROOT . "/Marketplace/paymentSuccess");
                exit;
            }
        }

        $this->view('marketplace/V_buyProduct', ['product' => $product]);
    }


    //  Marketplace Home (Farmer / Seller)
    public function index() {
        $this->view('marketplace/V_marketplaceHome');
    }

    //  Farmer Marketplace View
    public function farmer() {
        $this->view('marketplace/V_marketplaceFarmer');
    }

    //  Seller Marketplace View
    public function seller() {
        $this->view('marketplace/V_markertplaceSeller');
    }

     //  admin Marketplace View
    public function admin() {
        $this->view('marketplace/V_AdminMarketplace');
    }

    //  Add Product
public function addProduct() {
    // Initialize data
    $data = [
        'name' => '',
        'seller_id' => $_SESSION['seller_id'] ?? '',
        'category' => '',
        'description' => '',
        'province' => '',
        'region' => '',
        'unit_type' => '',
        'price' => '',
        'available' => '',
        'status' => '',
        'image' => '',
        'errors' => [],
        'success' => ''
    ];

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // Trim and preserve form values
        $data['name'] = trim($_POST['name'] ?? '');
        $data['category'] = trim($_POST['category'] ?? '');
        $data['description'] = trim($_POST['description'] ?? '');
        $data['status'] = trim($_POST['status'] ?? '');
        $data['province'] = trim($_POST['province'] ?? '');
        $data['region'] = trim($_POST['region'] ?? '');
        $data['unit_type'] = trim($_POST['unit_type'] ?? '');
        $data['price'] = trim($_POST['price'] ?? '');
        $data['available'] = trim($_POST['available'] ?? '');

        // --- Validation ---
        if(strlen($data['name']) === 0) {
            $data['errors']['name'] = "Product name is required.";
        } elseif(strlen($data['name']) < 3) {
            $data['errors']['name'] = "Product name must be at least 3 characters.";
        } elseif(!preg_match("/^[a-zA-Z0-9\s\-_]+$/", $data['name'])) {
            $data['errors']['name'] = "Product name can only contain letters, numbers, spaces, hyphens, and underscores.";
        }

        if(strlen($data['category']) === 0) {
            $data['errors']['category'] = "Please select a category.";
        }

        if(strlen($data['status']) === 0) {
            $data['errors']['status'] = "Please select a status.";
        }

        if(strlen($data['province']) === 0) {
            $data['errors']['province'] = "Please select a province.";
        }

        if(strlen($data['region']) === 0) {
            $data['errors']['region'] = "Please select a district.";
        }

        if(strlen($data['unit_type']) === 0) {
            $data['errors']['unit_type'] = "Please select a unit type.";
        }

        if(strlen($data['price']) === 0) {
            $data['errors']['price'] = "Price is required.";
        } elseif(!is_numeric($data['price']) || floatval($data['price']) <= 0) {
            $data['errors']['price'] = "Price must be a number greater than 0.";
        }

        if(strlen($data['available']) === 0) {
            $data['errors']['available'] = "Quantity is required.";
        } elseif(strlen(!is_numeric($data['available']) || intval($data['available'])) < 0) {
            $data['errors']['available'] = "Quantity must be a positive number.";
        } elseif(strlen(!ctype_digit($data['available']))) {
            $data['errors']['available'] = "Quantity must be a whole number.";
        }

        // --- Image Validation ---
        if(isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
            $allowedExt = ['jpg','jpeg','png','gif'];
            $fileExt = strtolower(pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION));

            if(!in_array($fileExt, $allowedExt)) {
                $data['errors']['image'] = "Only JPG, JPEG, PNG, GIF files are allowed.";
            } elseif($_FILES['image']['size'] > 2*1024*1024) {
                $data['errors']['image'] = "Image size must be less than 5MB.";
            } else {
                $uploadsDir = 'uploads/';
                if(!is_dir($uploadsDir)) {
                    mkdir($uploadsDir, 0777, true);
                }
                $filename = time() . '_' . basename($_FILES['image']['name']);
                $target = $uploadsDir . $filename;

                if(move_uploaded_file($_FILES['image']['tmp_name'], $target)) {
                    $data['image'] = $filename;
                } else {
                    $data['errors']['image'] = "Failed to upload image.";
                }
            }
        } else {
            $data['errors']['image'] = "Please upload an image.";
        }

        // --- Add product if no errors ---
        if(empty($data['errors'])) {
            if($this->marketplaceModel->createProduct($data)) {
                header("Location: " . URLROOT . "/marketplace/addsuccess");
                exit();
            } else {
                $data['errors']['general'] = "Something went wrong. Please try again.";
            }
        }
    }

    // Load view
    $this->view('marketplace/V_addProduct', $data);
}


    // ✅ Add Success
    public function addSuccess() {
        $this->view('marketplace/V_addsucess');
    }

    //  Manage Products (Seller)
    public function manageProduct() {
        $seller_id = $_SESSION['seller_id'] ?? null;
        if (!$seller_id) {
            header("Location: " . URLROOT . "/Users/login");
            exit;
        }
        $products = $this->marketplaceModel->getProductsBySeller($seller_id);
        $this->view('marketplace/V_manageProduct', ['products' => $products]);
    }

    //  Edit Product

public function editProduct($id) {
    // 1️⃣ Fetch product
    $product = $this->marketplaceModel->getProductById($id);

    if (!$product) {
        $_SESSION['product_message'] = "Product not found ❌";
        header("Location: " . URLROOT . "/Marketplace/manageProduct");
        exit();
    }

    $data = [
        'product' => (array)$product,
        'errors' => []
    ];

    // 2️⃣ Handle POST
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // Get POST values
        $data['product']['item_name'] = trim($_POST['item_name'] ?? '');
        $data['product']['category'] = trim($_POST['category'] ?? '');
        $data['product']['description'] = trim($_POST['description'] ?? '');
        $data['product']['status'] = trim($_POST['status'] ?? '');
        $data['product']['province'] = trim($_POST['province'] ?? '');
        $data['product']['region'] = trim($_POST['region'] ?? '');
        $data['product']['unit_type'] = trim($_POST['unit_type'] ?? '');
        $data['product']['price_per_unit'] = trim($_POST['price_per_unit'] ?? '');
        $data['product']['available_quantity'] = trim($_POST['available_quantity'] ?? '');
        $currentImage = $_POST['current_image'] ?? '';

        // VALIDATION 
        // Product Name
        if(strlen($data['product']['item_name']) === 0) {
            $data['errors']['name'] = "Product name is required.";
        } elseif(strlen($data['product']['item_name']) < 3) {
            $data['errors']['name'] = "Product name must be at least 3 characters.";
        } elseif(!preg_match("/^[a-zA-Z0-9\s\-_]+$/", $data['product']['item_name'])) {
            $data['errors']['name'] = "Product name can only contain letters, numbers, spaces, hyphens, and underscores.";
        }

        // Category
        if(strlen($data['product']['category']) === 0) {
            $data['errors']['category'] = "Please select a category.";
        }

        // Status
        if(strlen($data['product']['status']) === 0) {
            $data['errors']['status'] = "Please select a status.";
        }

        // Province
        if(strlen($data['product']['province']) === 0) {
            $data['errors']['province'] = "Please select a province.";
        }

        // Region/District
        if(strlen($data['product']['region']) === 0) {
            $data['errors']['region'] = "Please select a district.";
        }

        // Unit Type
        if(strlen($data['product']['unit_type']) === 0) {
            $data['errors']['unit_type'] = "Please select a unit type.";
        }

        // Price
        if(strlen($data['product']['price_per_unit']) === 0) {
            $data['errors']['price'] = "Price is required.";
        } elseif(!is_numeric($data['product']['price_per_unit']) || floatval($data['product']['price_per_unit']) <= 0) {
            $data['errors']['price'] = "Price must be a number greater than 0.";
        }

        // Available Quantity
        if(strlen($data['product']['available_quantity']) === 0) {
            $data['errors']['available'] = "Quantity is required.";
        } elseif(!ctype_digit($data['product']['available_quantity']) || intval($data['product']['available_quantity']) < 0) {
            $data['errors']['available'] = "Quantity must be a whole positive number.";
        }

        // --- IMAGE UPLOAD ---
        if(isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
            $allowedExt = ['jpg','jpeg','png','gif'];
            $fileExt = strtolower(pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION));
            if(!in_array($fileExt, $allowedExt)) {
                $data['errors']['image'] = "Only JPG, JPEG, PNG, GIF allowed.";
            } else {
                $uploadsDir = 'uploads/';
                if(!is_dir($uploadsDir)) mkdir($uploadsDir, 0777, true);
                $filename = time().'_'.basename($_FILES['image']['name']);
                $target = $uploadsDir.$filename;
                if(move_uploaded_file($_FILES['image']['tmp_name'], $target)) {
                    $data['product']['image_url'] = $filename;
                } else {
                    $data['errors']['image'] = "Failed to upload image.";
                }
            }
        } else {
            // Keep existing image
            $data['product']['image_url'] = $currentImage;
        }

        // --- UPDATE PRODUCT ---
        if(empty($data['errors'])) {
            if($this->marketplaceModel->updateProduct($id, $data['product'])) {
                $_SESSION['product_message'] = "Product updated successfully ✅";
                header("Location: " . URLROOT . "/Marketplace/manageProduct");
                exit();
            } else {
                $data['errors']['general'] = "Something went wrong. Please try again.";
            }
        }
    }

    $this->view('marketplace/V_editProduct', $data);
}



    //  Delete Product
    public function deleteProduct($id) {
        // Only allow POST for deletion
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if ($this->marketplaceModel->deleteProduct($id)) {
                $_SESSION['product_message'] = "Product deleted successfully ✅";
            } else {
                $_SESSION['product_message'] = "Something went wrong ❌";
            }
            header("Location: " . URLROOT . "/Marketplace/manageProduct");
            exit();
        } else {
            // Show confirmation view
            $product = $this->marketplaceModel->getProductById($id);

            if (!$product) {
                $_SESSION['product_message'] = "Product not found ❌";
                header("Location: " . URLROOT . "/Marketplace/manageProduct");
                exit();
            }

            $this->view('marketplace/V_deleteProduct', $product);
        }
    }

    // View Products by Category
    public function viewProduct($categorySlug = null) {
        $categoryMap = [
            'fertilizer' => 'Fertilizer',
            'paddy-seeds' => 'Seeds',
            'agrochemicals' => 'Agrochemicals',
            'equipments' => 'Equipments',
            'machinery' => 'Rent Machinery',
            'others' => 'Others'
        ];

        $category = $categoryMap[strtolower($categorySlug ?? '')] ?? null;
        $products = $category ? $this->marketplaceModel->getProductsByCategory($category) : [];
        $this->view('marketplace/V_viewProduct', ['category' => $category, 'products' => $products]);
    }

    // Payment
    public function payment() {
        $this->view('marketplace/V_paymentGetway');
    }

    // Track Orders (Farmer / Seller)
public function trackOrdersFarmer() {
    // Get buyer NIC from session
    $buyer_nic = $_SESSION['user_id'] ?? null; // or $_SESSION['nic']

    if (!$buyer_nic) {
        $_SESSION['error'] = "You must be logged in as a farmer to view your orders.";
        header("Location: " . URLROOT . "/Users/login");
        exit;
    }

    $orders = $this->marketplaceModel->getOrdersByBuyer($buyer_nic);
    // Create history array indexed by order_id
    $history = [];
    foreach ($orders as $order) {
        $history[$order->order_id] = $this->marketplaceModel->getOrderHistory($order->order_id);
    }

    // Pass to view
    $this->view('marketplace/V_FarmerTrackOrders', [
        'orders' => $orders,
        'history' => $history
    ]);
}



    public function trackOrdersSeller() {
        $seller_id = $_SESSION['seller_id'] ?? null;
        if (!$seller_id) {
            $_SESSION['error'] = "You must be logged in to view orders.";
            header("Location: " . URLROOT . "/Users/login");
            exit;
        }
    $orders = $this->marketplaceModel->getOrdersBySeller($seller_id);
     $this->view('marketplace/V_SellerTrackOrders', ['orders' => $orders]);
    }


    public function updateOrderStatus() {
    $data = json_decode(file_get_contents("php://input"));

    $order_id = $data->order_id ?? '';
    $new_status = $data->status ?? '';
    $user_id = $_SESSION['seller_id'] ?? $_SESSION['user_id'] ?? 'system';

    if (!empty($order_id) && !empty($new_status)) {
        $order = $this->marketplaceModel->getOrderById($order_id);
        if (!$order) {
            echo json_encode(['success' => false, 'message' => 'Order not found']);
            return;
        }

        $old_status = $order->order_status;

        if ($this->marketplaceModel->updateOrderStatus($order_id, $new_status)) {
            $this->marketplaceModel->addOrderStatusHistory($order_id, $old_status, $new_status, $user_id);
            $history = $this->marketplaceModel->getOrderStatusHistory($order_id);

            echo json_encode(['success' => true, 'history' => $history]);
        } else {
            echo json_encode(['success' => false, 'message' => 'Failed to update status']);
        }
    } else {
        echo json_encode(['success' => false, 'message' => 'Invalid data']);
    }
}


    public function adminViewProducts() {

        //fetch all products
        $products =$this->marketplaceModel->getAllProducts();
        $this->view('marketplace/V_AdminViewProducts', ['products' => $products]);
    } 

       public function adminViewOrders() {

        $order =$this->marketplaceModel->getAllOrders();
        $this->view('marketplace/V_AdminViewOrders', ['orders' => $order]);
    } 
}
?>
