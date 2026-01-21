<?php

class Knowledgecenter extends Controller{
    public function __construct() {
        $this->knowledgeModel = $this->model('M_Knowledgecenter');
    }
    public function index(){
        // Get knowledge categories
        $categories = $this->knowledgeModel->getCategories();

        $category_name = $_GET['category_name'] ?? '';
        $description = $_GET['description'] ?? '';
        $data = [
            'categories' => $categories,
            'category_name' => $category_name,
            'description' => $description,

            // Defauls
            'searchResults' => [],
            'searchPerformed' => false
        ];

        $this->loadViewByRole('knowledgecenter', $data);
    }

    public function addcategory(){
        if (!isset($_SESSION['user_type']) || !in_array($_SESSION['user_type'], ['officer', 'admin'])) {
            die('Access Denied');
            exit();
        }
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
            $data = [
                'category_name' => trim($_POST['category_name']),
                'description' => trim($_POST['description']),
                'image_path' => '',
                'errors' => []
            ];
            if (isset($_FILES['category_image']) && $_FILES['category_image']['error'] != 4) { // 4 = no file
                $uploadDir = 'uploads/';
                $filename = basename($_FILES['category_image']['name']);
                $targetFile = $uploadDir . time() . '_' . $filename;

                if (move_uploaded_file($_FILES['category_image']['tmp_name'], $targetFile)) {
                    $data['image_path'] = $targetFile;
                } else {
                    $data['errors']['image'] = 'Failed to upload image.';
                }
            }

            // Validate
            /*if (empty($data['category_name'])) {
            }
            if (empty($data['description'])) {
            }*/

            // If no errors, save to database
            if (empty($data['errors'])) {
                if ($this->knowledgeModel->addCategory($data)) {
                    header('Location: ' . URLROOT . '/knowledgecenter');
                    exit();
                } else {
                    die('Something went wrong while adding the category.');
                }
            } else {
                $this->loadViewByRole('addcategory', $data);
            }

        } else {
            $data = [
                'category_name' => '',
                'description' => '',
                'image_path' => '',
                'errors' => []
            ];
            $this->loadViewByRole('addcategory', $data);
        }
    }

    public function editcategory($category_id){
        if (!isset($_SESSION['user_type']) || !in_array($_SESSION['user_type'], ['officer', 'admin'])) {
            die('Access Denied');
            exit();
        }
        $category = $this->knowledgeModel->getCategoryById($category_id);

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
            $data = [
                'id' => $category->id,
                'category_name' => trim($_POST['category_name']),
                'description' => trim($_POST['description']),
                'image_path' => $category->image_path,
                'errors' => []
            ];
            if (isset($_FILES['category_image']) && $_FILES['category_image']['error'] != 4) { // 4 = no file
                $uploadDir = 'uploads/';
                $filename = basename($_FILES['category_image']['name']);
                $targetFile = $uploadDir . time() . '_' . $filename;

                if (move_uploaded_file($_FILES['category_image']['tmp_name'], $targetFile)) {
                    $data['image_path'] = $targetFile;
                } else {
                    $data['errors']['image'] = 'Failed to upload image.';
                }
            }

            // If no errors, update
            if (empty($data['errors'])) {
                if ($this->knowledgeModel->editCategory($data)) {
                    header('Location: ' . URLROOT . '/knowledgecenter');
                    exit();
                } else {
                    die('Something went wrong while adding the category.');
                }
            } else {
                $this->loadViewByRole('editcategory', $data);
            }

        } else {
            $data = [
                'id' => $category->id,
                'category_name' => $category->category_name,
                'description' => $category->description,
                'image_path' => $category->image_path,
                'errors' => []
            ];
            $this->loadViewByRole('editcategory', $data);
        }
    }
    public function deletecategory($category_id) {
        if (!isset($_SESSION['user_type']) || !in_array($_SESSION['user_type'], ['officer', 'admin'])) {
            die('Access Denied');
            exit();
        }
        $category = $this->knowledgeModel->getCategoryById($category_id);
        if (!$category) {
            die('Category not found.');
        }
        $this->knowledgeModel->deleteCategory($category_id);
        header('Location: ' . URLROOT . '/Knowledgecenter');
        exit();
    }

    public function searchcategory() {
        $categories = $this->knowledgeModel->getCategories();

        $term = trim($_GET['term'] ?? '');
        $searchResults = [];
        $searchPerformed = false;

        if (!empty($term)) {
            $searchResults = $this->knowledgeModel->searchCategories($term);
            $searchPerformed = true;
        }

        $data = [
            'categories' => $categories,
            'searchResults' => $searchResults,
            'searchPerformed' => $searchPerformed
        ];

        $this->loadViewByRole('knowledgecenter', $data);
    }

    public function addarticle($category_id = null) {
        if (!isset($_SESSION['user_type']) || !in_array($_SESSION['user_type'], ['officer', 'admin'])) {
            die('Access Denied');
            exit();
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $_POST = filter_input_array(INPUT_POST, FILTER_DEFAULT);

            $category = $this->knowledgeModel->getCategoryByName($_POST['category_name']);
            if (!$category) {
                die('Invalid category.');
            }

            $data = [
                'article_name' => trim($_POST['article_name']),
                'description'  => trim($_POST['description']),
                'category_id'  => $category->id,
                'category_name'=> $category->category_name,
                'image_path'   => '',
                'errors'       => []
            ];

            if (isset($_FILES['category_image']) && $_FILES['category_image']['error'] != 4) {
                $uploadDir = 'uploads/knowledgecenter/';
                $filename = basename($_FILES['category_image']['name']);
                $targetFile = $uploadDir . time() . '_' . $filename;

                if (move_uploaded_file($_FILES['category_image']['tmp_name'], $targetFile)) {
                    $data['image_path'] = $targetFile;
                } else {
                    $data['errors']['image'] = 'Failed to upload image.';
                }
            }

            if (empty($data['article_name'])) {
                $data['errors']['article_name'] = 'Article name is required.';
            }
            if (empty($data['description'])) {
                $data['errors']['description'] = 'Description is required.';
            }

            if (empty($data['errors'])) {
                if ($this->knowledgeModel->addArticle($data)) {
                    header('Location: ' . URLROOT . '/Knowledgecenter/category/' . $data['category_id']);
                    exit();
                } else {
                    die('Something went wrong while adding the article.');
                }
            } else {
                $this->loadViewByRole('addarticle', $data);
            }

        } else {
            if (!$category_id) {
                die('Category ID is required.');
            }
            $category = $this->knowledgeModel->getCategoryById($category_id);
            if (!$category) {
                die('Category not found.');
            }

            $data = [
                'article_name'  => '',
                'description'   => '',
                'category_name' => $category->category_name,
                'category_id'   => $category->id,
                'image_path'    => '',
                'errors'        => []
            ];

            $this->loadViewByRole('addarticle', $data);
        }
    }

    public function editArticle($article_id = null) {
        if (!isset($_SESSION['user_type']) || !in_array($_SESSION['user_type'], ['officer', 'admin'])) {
            die('Access Denied');
            exit();
        }

        if (!$article_id) {
            die('Article ID is required.');
        }

        $article = $this->knowledgeModel->getArticleById($article_id);
        if (!$article) {
            die('Article not found.');
        }
        $category = $this->knowledgeModel->getCategoryById($article->category_id);
        if (!$category) {
            die('Category not found.');
        }
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $_POST = filter_input_array(INPUT_POST, FILTER_DEFAULT);

            $data = [
                'id'    => $article->id,
                'article_name'  => trim($_POST['article_name']),
                'description'   => trim($_POST['description']),
                'category_id'   => $article->category_id,
                'category_name' => $category->category_name,
                'image_path'    => $article->image_path,
                'errors'        => []
            ];

            if (isset($_FILES['category_image']) && $_FILES['category_image']['error'] != 4) {
                $uploadDir = 'uploads/knowledgecenter/';
                $filename = basename($_FILES['category_image']['name']);
                $targetFile = $uploadDir . time() . '_' . $filename;

                if (move_uploaded_file($_FILES['category_image']['tmp_name'], $targetFile)) {
                    $data['image_path'] = $targetFile;
                } else {
                    $data['errors']['image'] = 'Failed to upload image.';
                }
            }

            // Validation
            if (empty($data['article_name'])) {
                $data['errors']['article_name'] = 'Article name is required.';
            }
            if (empty($data['description'])) {
                $data['errors']['description'] = 'Description is required.';
            }
            if (empty($data['errors'])) {
                if ($this->knowledgeModel->editArticle($data)) {
                    header('Location: ' . URLROOT . '/Knowledgecenter/category/' . $data['category_id']);
                    exit();
                } else {
                    die('Something went wrong while updating the article.');
                }
            } else {
                $this->loadViewByRole('editarticle', $data);
            }

        } else {
            $data = [
                'id'    => $article->id,
                'article_name'  => $article->article_name,
                'description'   => $article->description,
                'category_id'   => $article->category_id,
                'category_name' => $category->category_name,
                'image_path'    => $article->image_path,
                'errors'        => []
            ];

            $this->loadViewByRole('editarticle', $data);
        }
    }
    public function viewarticle($article_id) {
        $article = $this->knowledgeModel->getArticleById($article_id);
        if (!$article) {
            die('Article not found.');
        }

        $data = [
            'article' => $article
        ];

        $this->loadViewByRole('viewarticle', $data);
    }
    public function searcharticle($category_id) {
        $category = $this->knowledgeModel->getCategoryById($category_id);
        $articles = $this->knowledgeModel->getArticlesByCategoryId($category_id);

        $term = trim($_GET['term'] ?? '');
        $searchResults = [];
        $searchPerformed = false;

        if (!empty($term)) {
            $searchResults = $this->knowledgeModel->searchArticlesInCategory($term, $category_id);
            $searchPerformed = true;
        }

        $data = [
            'category' => $category,
            'articles' => $articles,
            'searchResults' => $searchResults,
            'searchPerformed' => $searchPerformed
        ];

        $this->loadViewByRole('category', $data);
    }
    public function deletearticle($article_id) {
        if (!isset($_SESSION['user_type']) || !in_array($_SESSION['user_type'], ['officer', 'admin'])) {
            die('Access Denied');
            exit();
        }

        $article = $this->knowledgeModel->getArticleById($article_id);
        if (!$article) {
            die('Article not found.');
        }

        $this->knowledgeModel->deleteArticle($article_id);
        header('Location: ' . URLROOT . '/Knowledgecenter/category/' . $article->category_id);
        exit();
    }

    public function uploadInlineImage() {
        if (!isset($_SESSION['user_type']) || !in_array($_SESSION['user_type'], ['officer','admin'])) {
            die('Access Denied');
            exit;
        }

        $uploadDir = 'uploads/knowledgecenter/articles/';
        if (!file_exists($uploadDir)) {
            mkdir($uploadDir, 0777, true);
        }

        $file = $_FILES['image'];
        $filename = time() . '_' . basename($file['name']);
        $target = $uploadDir . $filename;

        if (move_uploaded_file($file['tmp_name'], $target)) {
            echo json_encode([
                'path' => URLROOT . '/' . $target
            ]);
        }
    }


    public function category($id) {
        // Get category details
        $category = $this->knowledgeModel->getCategoryById($id);
        if (!$category) {
            die('Category not found.');
        }

        // Get articles for this category
        $articles = $this->knowledgeModel->getArticlesByCategoryId($id);

        $data = [
            'category' => $category,
            'articles' => $articles,
            'searchResults' => [],
            'searchPerformed' => false
        ];

        $this->loadViewByRole('category', $data);
    }

    // Helper to load role-specific views in the same folder
    private function loadViewByRole($baseViewName, $data) {
        if (!isset($_SESSION['user_type'])) {
            header('Location: /users/login'); 
            exit;
        }
        switch ($_SESSION['user_type']) {
            case 'farmer':
                $this->view('knowledgecenter/farmer/v_farmer_' . $baseViewName, $data);
                break;
            case 'admin':
                $this->view('knowledgecenter/admin/v_admin_' . $baseViewName, $data);
                break;
            case 'seller':
                $this->view('knowledgecenter/seller/v_seller_' . $baseViewName, $data);
                break;
            case 'officer':
                $this->view('knowledgecenter/officer/v_officer_' . $baseViewName, $data);
                break;
            default:
                header('Location: /User/login');
                exit;
        }
    }

}


?>