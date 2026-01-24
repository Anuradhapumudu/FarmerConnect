<?php
    class M_Knowledgecenter {
        private $db;

        public function __construct() {
            $this->db = new Database;
        }

        public function getCategories() {
            $this->db->query('SELECT * FROM knowledge_categories WHERE is_deleted = 0');
            return $this->db->resultSet();
        }
        public function getCategoryById($id) {
            $this->db->query('SELECT * FROM knowledge_categories WHERE id = :id AND is_deleted = 0');
            $this->db->bind(':id', $id);
            return $this->db->single();
        }
        public function getCategoryByName($name) {
            $this->db->query('SELECT * FROM knowledge_categories WHERE category_name = :name AND is_deleted = 0');
            $this->db->bind(':name', $name);
            return $this->db->single();
        }

        public function getArticlesByCategoryId($category_id) {
            $this->db->query('SELECT * FROM knowledge_articles WHERE category_id = :category_id AND is_deleted = 0');
            $this->db->bind(':category_id', $category_id);
            return $this->db->resultSet();
        }

        public function getArticleById($id) {
            $this->db->query('SELECT * FROM knowledge_articles WHERE id = :id AND is_deleted = 0');
            $this->db->bind(':id', $id);
            return $this->db->single();
        }

        public function addCategory($data) {
            if(isset($_SESSION['user_type'])) {
                if($_SESSION['user_type'] == 'officer') {
                    $officer_id = $_SESSION['user_id'];
                }
            }
            $this->db->query('INSERT INTO knowledge_categories (category_name,created_by, description, image_path) VALUES (:category_name, :created_by, :description, :image_path)');
            $this->db->bind(':category_name', $data['category_name']);
            $this->db->bind(':created_by', $officer_id);
            $this->db->bind(':description', $data['description']);
            $this->db->bind(':image_path', $data['image_path']);

            return $this->db->execute();
        }
        public function editCategory($data) {
            $this->db->query('UPDATE knowledge_categories SET category_name = :category_name, description = :description, image_path = :image_path WHERE id = :id AND is_deleted = 0');
            $this->db->bind(':id', $data['id']);
            $this->db->bind(':category_name', $data['category_name']);
            $this->db->bind(':description', $data['description']);
            $this->db->bind(':image_path', $data['image_path']);
            return $this->db->execute();
        }
        public function deleteCategory($id) {
            $this->db->query("UPDATE knowledge_categories SET is_deleted = 1 WHERE id = :id");
            $this->db->bind(':id', $id);
            return $this->db->execute();
        }
        public function addArticle($data) {
            $this->db->query('INSERT INTO knowledge_articles (article_name, description, category_id, image_path) VALUES (:article_name, :description, :category_id, :image_path)');
            $this->db->bind(':article_name', $data['article_name']);
            $this->db->bind(':description', $data['description']);
            $this->db->bind(':category_id', $data['category_id']);
            $this->db->bind(':image_path', $data['image_path']);
            return $this->db->execute();
        }
        public function editArticle($data) {
            $this->db->query('UPDATE knowledge_articles SET article_name = :article_name, description = :description, category_id = :category_id, image_path = :image_path WHERE id = :id');
            $this->db->bind(':id', $data['id']);
            $this->db->bind(':article_name', $data['article_name']);
            $this->db->bind(':description', $data['description']);
            $this->db->bind(':category_id', $data['category_id']);
            $this->db->bind(':image_path', $data['image_path']);
            return $this->db->execute();
        }
        public function deleteArticle($id) {
            $this->db->query("UPDATE knowledge_articles SET is_deleted = 1 WHERE id = :id");
            $this->db->bind(':id', $id);
            return $this->db->execute();
        }

        public function searchCategories($term) {
            $this->db->query("SELECT * FROM knowledge_categories WHERE (category_name LIKE :term OR description LIKE :term) AND is_deleted = 0");
            $this->db->bind(':term', '%' . $term . '%');
            return $this->db->resultSet();
        }
        public function searchArticlesInCategory($term, $category_id) {
            $this->db->query("SELECT * FROM knowledge_articles WHERE (article_name LIKE :term OR description LIKE :term) AND category_id = :category_id AND is_deleted = 0");
            $this->db->bind(':term', '%' . $term . '%');
            $this->db->bind(':category_id', $category_id);
            return $this->db->resultSet();
        }

    }
?>