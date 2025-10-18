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
        $data = [
            'name' => '',
            'seller_id' => $_SESSION['seller_id'] ?? '',
            'category' => '',
            'description' => '',
            'region' => '',
            'unit_type' => '',
            'price' => '',
            'available' => '',
            'status' => '',
            'errors' => [],
            'success' => ''
        ];

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // Trim POST data
            $data['name'] = trim($_POST['name']);
            $data['category'] = trim($_POST['category']);
            $data['description'] = trim($_POST['description']);
            $data['status'] = trim($_POST['status']);
            $data['region'] = trim($_POST['region']);
            $data['unit_type'] = trim($_POST['unit_type']);
            $data['price'] = trim($_POST['price']);
            $data['available'] = trim($_POST['available']);

            // --- Validation ---
            if(empty($data['name'])) {
                $data['errors']['name'] = "Product name is required.";
            } elseif(strlen($data['name']) < 3) {
                $data['errors']['name'] = "Product name must be at least 3 characters.";
            } elseif(!preg_match("/^[a-zA-Z0-9\s\-_]+$/", $data['name'])) {
                $data['errors']['name'] = " Product name can only contain letters, numbers, spaces, hyphens (-), and underscores (_).";
            }

            if(empty($data['category'])) {
                $data['errors']['category'] = " Please select a category.";
            }

            if(empty($data['status'])) {
                $data['errors']['status'] = "Please select a status.";
            }

            if(empty($data['region'])) {
                $data['errors']['region'] = " Please select a region.";
            }

            if(empty($data['unit_type'])) {
                $data['errors']['unit_type'] = " Please select a unit type.";
            }

            if(empty($data['price'])) {
                $data['errors']['price'] = " Price is required.";
            } elseif(!is_numeric($data['price']) || $data['price'] <= 0) {
                $data['errors']['price'] = " Price must be a number greater than 0.";
            }

            if(empty($data['available'])) {
                $data['errors']['available'] = " Quantity is required.";
            } elseif(!is_numeric($data['available']) || $data['available'] < 0) {
                $data['errors']['available'] = " Quantity must be a positive number.";
            }elseif(!filter_var($data['available'], FILTER_VALIDATE_INT)) {
                 $data['errors']['available'] = " Quantity must be a whole number.";
             }


            // Image upload validation
            if(isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
                $filename = basename($_FILES['image']['name']);
                $target = 'uploads/' . $filename;
                if(move_uploaded_file($_FILES['image']['tmp_name'], $target)) {
                    $data['image'] = $filename;
                } else {
                    $data['errors']['image'] = " Failed to upload image.";
                }
            } else {
                $data['errors']['image'] = " Please upload an image.";
            }

            $allowedTypes = ['image/jpeg', 'image/png', 'image/jpg', 'image/gif'];
            if(isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
                $fileType = $_FILES['image']['type'];
                if(!in_array($fileType, $allowedTypes)) {
                    $data['errors']['image'] = " Only JPG, JPEG, PNG, GIF files are allowed.";
                }
            }

            $maxSize = 2 * 1024 * 1024; // 2MB
            if($_FILES['image']['size'] > $maxSize) {
                $data['errors']['image'] = "Image size must be less than 5MB.";
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

        $this->view('marketplace/V_addProduct', $data);
    }

    // ✅ Add Success
    public function addSuccess() {
        $this->view('marketplace/V_addsucess');
    }

    // 🛠 Manage Products (Seller)
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
    if (!$product) die("Product not found");

    // Convert object to array for easier use in view
    $product = (array) $product;
    $errors = [];

    // 2️⃣ Handle POST
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $data = $_POST;
        $data['item_id'] = $id;

        // 3️⃣ Handle image upload
        if (!empty($_FILES['image']['name'])) {
            $targetDir = APPROOT . "/../public/uploads/";
            $image_name = basename($_FILES['image']['name']);
            $targetFile = $targetDir . $image_name;

            if (move_uploaded_file($_FILES['image']['tmp_name'], $targetFile)) {
                $data['image_url'] = $image_name;
            } else {
                $errors['image'] = "Failed to upload image.";
            }
        } else {
            // Keep current image if no new upload
            $data['image_url'] = $_POST['current_image'] ?? $product['image_url'];
        }

        // 4️⃣ Validation
        if (empty($data['item_name'])) $errors['name'] = "⚠ Product name required.";
        if (empty($data['category'])) $errors['category'] = "⚠ Please select a category.";
        if (empty($data['status'])) $errors['status'] = "⚠ Please select status.";
        if (empty($data['region'])) $errors['region'] = "⚠ Please select region.";
        if (empty($data['unit_type'])) $errors['unit_type'] = "⚠ Please select unit type.";
        if (!isset($data['price_per_unit']) || !is_numeric($data['price_per_unit']) || $data['price_per_unit'] <= 0)
            $errors['price'] = "⚠ Enter valid price.";
        if (!isset($data['available_quantity']) || !is_numeric($data['available_quantity']) || $data['available_quantity'] < 0)
            $errors['available'] = "⚠ Enter valid quantity.";

        // 5️⃣ If no errors, update product
        if (empty($errors)) {
            if ($this->marketplaceModel->updateProduct($data)) {
                header("Location: " . URLROOT . "/Marketplace/manageProduct");
                exit;
            } else {
                $errors['general'] = "Failed to update product.";
            }
        }

        // Reload form with errors and entered values
        $product = $data;
    }

    // 6️⃣ Load view
    $this->view('marketplace/V_editProduct', [
        'product' => $product,
        'errors' => $errors
    ]);
}




    // ❌ Delete Product
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

    // 👁️ View Products by Category
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

    // 💳 Payment
    public function payment() {
        $this->view('marketplace/V_paymentGetway');
    }

    // 🚜 Track Orders (Farmer / Seller)
    public function trackOrdersFarmer() {
        $this->view('marketplace/V_FarmerTrackOrders');
    }

    public function trackOrdersSeller() {
        $this->view('marketplace/V_SellerTrackOrders');
    }

    // 📦 Buy Product
    public function buyProduct($id) {
        $product = $this->marketplaceModel->getProductById($id);
        if (!$product) die("Product not found");

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $quantity = $_POST['quantity'] ?? 1;
            $farmer_id = $_SESSION['farmer_id'] ?? 1;
            $total_price = $product->price_per_unit * $quantity;

            $this->marketplaceModel->createOrder($farmer_id, $id, $quantity, $total_price);
            $this->marketplaceModel->updateStock($id, $product->available_quantity - $quantity);

            header("Location: " . URLROOT . "/Marketplace/trackOrdersFarmer");
            exit;
        }

        $this->view('marketplace/V_buyProduct', ['product' => $product]);
    }
}
?>
