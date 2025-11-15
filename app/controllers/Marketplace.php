<?php
class Marketplace extends Controller {
    private $marketplaceModel;

    public function __construct() {
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }

        // Common model for marketplace operations
        $this->marketplaceModel = $this->model('M_Marketplace/M_Marketplace', new Database());
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
        $this->view('marketplace/V_FarmerTrackOrders');
    }

    public function trackOrdersSeller() {
        $this->view('marketplace/V_SellerTrackOrders');
    }

    // Buy Product
public function buyProduct($id = null) {
    // $id is now numeric internal ID
    if ($id === null) {
        $_SESSION['error'] = "Product ID is required";
        header("Location: " . URLROOT . "/Marketplace/farmer");
        exit;
    }

    // Fetch product by numeric ID
    $product = $this->marketplaceModel->getProductByInternalId($id);
    if (!$product) {
        $_SESSION['error'] = "Product not found";
        header("Location: " . URLROOT . "/Marketplace/farmer");
        exit;
    }

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $quantity = $_POST['quantity'] ?? 1;
        $farmer_id = $_SESSION['farmer_id'] ?? 1;
        $total_price = $product->price_per_unit * $quantity;

        $this->marketplaceModel->createOrder($farmer_id, $product->item_id, $quantity, $total_price);
        $this->marketplaceModel->updateStock($id, $product->available_quantity - $quantity);

        header("Location: " . URLROOT . "/Marketplace/trackOrdersFarmer");
        exit;
    }

    $this->view('marketplace/V_buyProduct', ['product' => $product]);
}


    public function paymentSuccess() {
        $this->view('marketplace/V_paymentSucess');
    }



    public function adminViewProducts() {

        //fetch all products
        $products =$this->marketplaceModel->getAllProducts();
        $this->view('marketplace/V_AdminViewProducts', ['products' => $products]);
    } 

       public function adminViewOrders() {
        $this->view('marketplace/V_AdminViewOrders');
    } 
}
?>
