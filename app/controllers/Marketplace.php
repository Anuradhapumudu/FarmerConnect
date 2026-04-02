<?php
class Marketplace extends Controller {
    private $marketplaceModel;

    public function __construct() {
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
        $this->marketplaceModel = $this->model('M_Marketplace/M_Marketplace', new Database());
    }


private function generatePayHereHash($order_id, $amount, $currency = "LKR") {
    return strtoupper(
        md5(
            PAYHERE_MERCHANT_ID .
            $order_id .
            number_format($amount, 2, '.', '') .
            $currency .
            strtoupper(md5(PAYHERE_MERCHANT_SECRET))
        )
    );
}

public function buyProduct($id = null) {

    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        $product = $this->marketplaceModel->getProductByInternalId($id);
        $this->view('marketplace/V_buyProduct', ['product' => $product]);
        return;
    }

    $product  = $this->marketplaceModel->getProductByInternalId($id);
    $quantity = (int) $_POST['quantity'];
    $method   = $_POST['payment_method'];

    $total = $product->price_per_unit * $quantity;

    // ---------------- CASH PAYMENT ----------------
    if ($method === 'cash') {

        $this->marketplaceModel->createOrder(
            $_SESSION['nic'],
            $product->item_id,
            $product->seller_id,
            $quantity,
            $total,
            'cash',
            'completed',
            null
        );

        $this->marketplaceModel->updateStock(
            $product->item_id,
            $product->available_quantity - $quantity
        );

        header("Location: " . URLROOT . "/Marketplace/paymentSuccess");
        exit;
    }

    // ONLINE PAYMENT 
    $order_id = uniqid("ORD_");
    $amount   = number_format($total, 2, '.', '');
    $hash     = $this->generatePayHereHash($order_id, $amount);

    // SAVE ORDER AS PENDING (CRITICAL)
    $this->marketplaceModel->createOrder(
        $_SESSION['nic'],
        $product->item_id,
        $product->seller_id,
        $quantity,
        $amount,
        'online',
        'pending',
        $order_id
    );

    $payhere = [
        "sandbox"     => true,
        "merchant_id" => PAYHERE_MERCHANT_ID,
        "return_url"  => URLROOT . "/Marketplace/paymentSuccessOnline",
        "cancel_url"  => URLROOT . "/Marketplace/paymentCancel",
        "notify_url"  => "https://YOUR-NGROK-URL/FarmerConnect/Marketplace/paymentNotification",

        "order_id" => $order_id,
        "items"    => $product->item_name,
        "amount"   => $amount,
        "currency" => "LKR",
        "hash"     => $hash,

        "first_name" => "Farmer",
        "last_name"  => "User",
        "email"      => "farmer@example.com",
        "phone"      => "0771234567",
        "address"    => "Sri Lanka",
        "city"       => $product->region,
        "country"    => "Sri Lanka"
    ];

    $this->view('marketplace/V_onlinePayment', ['payhere' => $payhere]);
}


public function paymentNotification() {

    // LOG (debug)
    file_put_contents(
        APPROOT . '/payhere.log',
        print_r($_POST, true),
        FILE_APPEND
    );

    $merchant_id      = $_POST['merchant_id'] ?? '';
    $order_id         = $_POST['order_id'] ?? '';
    $payhere_amount   = $_POST['payhere_amount'] ?? '';
    $payhere_currency = $_POST['payhere_currency'] ?? '';
    $status_code      = $_POST['status_code'] ?? '';
    $md5sig           = $_POST['md5sig'] ?? '';

    $local_md5 = strtoupper(
        md5(
            $merchant_id .
            $order_id .
            $payhere_amount .
            $payhere_currency .
            $status_code .
            strtoupper(md5(PAYHERE_MERCHANT_SECRET))
        )
    );

    // Verify payment
    if ($local_md5 === $md5sig && $status_code == 2) {

        $order = $this->marketplaceModel->getOrderByOrderId($order_id);

        if ($order && $order->status !== 'completed') {

            // Mark order paid
            $this->marketplaceModel->updateOrderStatus($order_id, 'completed');

            // Update stock
            $this->marketplaceModel->updateStock(
                $order->item_id,
                $order->available_quantity - $order->quantity
            );
        }
    }

    http_response_code(200);
}




    public function paymentSuccess() {
        $this->view('marketplace/V_paymentSuccess');
    }

    public function paymentCancel() {
        $_SESSION['error'] = "Payment was cancelled";
        $this->view('marketplace/V_paymentCancel');
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

        //  Validation 
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

        // Image Validation 
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

        // Add product if no errors
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


    //  Add Success
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

    //  Handle POST
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

    //create rate array
    $ratedOrders = [];
     foreach ($orders as $order) {
    $ratedOrders[$order->order_id] =
        $this->marketplaceModel->isOrderRated($order->order_id);
    }

     $this->view('marketplace/V_FarmerTrackOrders', [
    'orders' => $orders,
    'history' => $history,
    'ratedOrders' => $ratedOrders
    ]);

}


public function viewOrderTracking($orderId) {
    // Get order details
    $order = $this->marketplaceModel->getOrderById($orderId);
    
    // Get order history
    $history = $this->marketplaceModel->getOrderHistory($orderId);
    
    // Get rated status if exists
    $rated = $this->marketplaceModel->isOrderRated($orderId);
    
    $data = [
        'order' => $order,
        'history' => $history,
        'rated' => $rated
    ];
    
    $this->view('marketplace/V_viewTracking', $data);
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
    
    public function submitRating() {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $order_id = $_POST['order_id'] ?? '';
        $rating   = $_POST['rating'] ?? '';

        if (!empty($order_id) && !empty($rating)) {
            // Check if order is already rated
            $existing = $this->marketplaceModel->isOrderRated($order_id);
            if ($existing) {
                $_SESSION['error'] = "You have already rated this order.";
            } else {
                $success = $this->marketplaceModel->addRating($order_id, $rating);
                if ($success) {
                    $_SESSION['success'] = "Thank you! Your rating has been submitted ⭐";
                } else {
                    $_SESSION['error'] = "Something went wrong. Please try again.";
                }
            }
        } else {
            $_SESSION['error'] = "Invalid rating submission.";
        }

        // Redirect back to farmer track orders page
        header("Location: " . URLROOT . "/Marketplace/trackOrdersFarmer");
        exit;
    } else {
        // Not a POST request
        header("Location: " . URLROOT . "/Marketplace/trackOrdersFarmer");
        exit;
    }
}



}
?>
