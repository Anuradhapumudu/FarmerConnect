<?php
    class M_Announcements {
        private $db;

        public function __construct() {
            $this->db = new Database;
        }

        public function createAnnouncement($data) {
            // Initialize both IDs as NULL
            $officer_id = null;
            $admin_id = null;

            // Check the user type from session
            if(isset($_SESSION['user_type'])) {
                if($_SESSION['user_type'] == 'officer') {
                    $officer_id = $_SESSION['user_id'];
                } elseif($_SESSION['user_type'] == 'admin') {
                    $admin_id = $_SESSION['user_id'];
                }
            }
            $this->db->query('INSERT INTO announcements (officer_id, admin_id, title, category, content, attachment_path) VALUES (:officer_id, :admin_id, :title, :category, :content, :attachment_path)');
            $this->db->bind(':officer_id', $officer_id);
            $this->db->bind(':admin_id', $admin_id);
            $this->db->bind(':title', $data['title']);
            $this->db->bind(':category', $data['category']);
            $this->db->bind(':content', $data['content']);
            $this->db->bind(':attachment_path', $data['attachment_path']);

            if($this->db->execute()) {
                return true;
            } else {
                return false;
            }
        }

        public function editAnnouncement($data) {
            
            $officer_id = null;
            $admin_id = null;

            // Check the user type from session
            if(isset($_SESSION['user_type'])) {
                if($_SESSION['user_type'] == 'officer') {
                    $officer_id = $_SESSION['user_id'] ?? null;;
                } elseif($_SESSION['user_type'] == 'admin') {
                    $admin_id = $_SESSION['user_id'] ?? null;;
                }
            }
            $this->db->query('UPDATE announcements SET officer_id = :officer_id, admin_id = :admin_id, title = :title, category = :category, content = :content, attachment_path = :attachment_path WHERE announcement_id = :id');
            $this->db->bind(':id', $data['announcement_id']);
            $this->db->bind(':officer_id', $officer_id);
            $this->db->bind(':admin_id', $admin_id);
            $this->db->bind(':title', $data['title']);
            $this->db->bind(':category', $data['category']);
            $this->db->bind(':content', $data['content']);
            $this->db->bind(':attachment_path', $data['attachment_path']);

            if($this->db->execute()) {
                return true;
            } else {
                return false;
            }
        }

        // Delete announcements
        public function deleteAnnouncement($id) {
            $this->db->query("UPDATE announcements SET is_deleted = 1 WHERE announcement_id = :id");
            $this->db->bind(':id', $id);
            return $this->db->execute();
        }

        public function getAnnouncements() {
            // Latest announcements (past 7 days)
            $this->db->query("
                SELECT a.*, 
                    CASE 
                        WHEN a.officer_id IS NOT NULL THEN CONCAT('Officer - ', o.first_name, ' ', o.last_name)
                        WHEN a.admin_id IS NOT NULL THEN 'Admin'
                        ELSE 'Unknown'
                    END AS posted_by
                FROM announcements a
                LEFT JOIN officers o ON a.officer_id = o.officer_id
                LEFT JOIN admins ad ON a.admin_id = ad.admin_id
                WHERE a.created_at >= DATE_SUB(NOW(), INTERVAL 7 DAY)
                AND a.is_pinned = 0
                AND a.is_deleted = 0
                ORDER BY a.created_at DESC
            ");
            $latest = $this->db->resultSet();

            // Previous announcements (older than 7 days)
            $this->db->query("
                SELECT a.*, 
                    CASE 
                        WHEN a.officer_id IS NOT NULL THEN CONCAT('Officer - ', o.first_name, ' ', o.last_name)
                        WHEN a.admin_id IS NOT NULL THEN 'Admin'
                        ELSE 'Unknown'
                    END AS posted_by
                FROM announcements a
                LEFT JOIN officers o ON a.officer_id = o.officer_id
                LEFT JOIN admins ad ON a.admin_id = ad.admin_id
                WHERE a.created_at < DATE_SUB(NOW(), INTERVAL 7 DAY)
                AND a.is_pinned = 0
                AND a.is_deleted = 0
                ORDER BY a.created_at DESC
            ");
            $previous = $this->db->resultSet();

            return ['latest' => $latest, 'previous' => $previous];
        }

        // Get pinned announcements
        public function getPinnedAnnouncements() {
            $this->db->query("
                SELECT a.*, 
                    CASE 
                        WHEN a.officer_id IS NOT NULL THEN CONCAT('Officer - ', o.first_name, ' ', o.last_name)
                        WHEN a.admin_id IS NOT NULL THEN 'Admin'
                        ELSE 'Unknown'
                    END AS posted_by
                FROM announcements a
                LEFT JOIN officers o ON a.officer_id = o.officer_id
                LEFT JOIN admins ad ON a.admin_id = ad.admin_id
                WHERE a.is_pinned = 1 AND a.is_deleted = 0
                ORDER BY a.created_at DESC
            ");
            return $this->db->resultSet();
        }

        // Toggle pin
        public function togglePin($announcement_id) {
            // First, get current pin status
            $this->db->query("SELECT is_pinned FROM announcements WHERE announcement_id = :id");
            $this->db->bind(':id', $announcement_id);
            $announcement = $this->db->single();

            $new_status = $announcement->is_pinned ? 0 : 1;

            // Update pin status
            $this->db->query("UPDATE announcements SET is_pinned = :status WHERE announcement_id = :id");
            $this->db->bind(':status', $new_status);
            $this->db->bind(':id', $announcement_id);

            return $this->db->execute();
        }
        // Search announcements in the search section
        public function searchAnnouncements($term = '', $category = '', $date = '') {
            $query = "
                SELECT a.*, 
                    CASE 
                        WHEN a.officer_id IS NOT NULL THEN CONCAT('Officer - ', o.first_name, ' ', o.last_name)
                        WHEN a.admin_id IS NOT NULL THEN 'Admin'
                        ELSE 'Unknown'
                    END AS posted_by
                FROM announcements a
                LEFT JOIN officers o ON a.officer_id = o.officer_id
                LEFT JOIN admins ad ON a.admin_id = ad.admin_id
                WHERE 1=1 AND a.is_deleted = 0
            ";

            if(!empty($term)) {
                $query .= " AND (title LIKE :term OR content LIKE :term)";
            }
            if(!empty($category)) {
                $query .= " AND category = :category";
            }
            if(!empty($date)) {
                if($date == 'today') $query .= " AND DATE(created_at) = CURDATE()";
                if($date == 'week') $query .= " AND YEARWEEK(created_at, 1) = YEARWEEK(CURDATE(), 1)";
                if($date == 'month') $query .= " AND MONTH(created_at) = MONTH(CURDATE()) AND YEAR(created_at) = YEAR(CURDATE())";
            }

            $query .= " ORDER BY created_at DESC";

            $this->db->query($query);

            if(!empty($term)) $this->db->bind(':term', "%$term%");
            if(!empty($category)) $this->db->bind(':category', $category);

            return $this->db->resultSet();
        }
        // Get announcement using id
        public function getAnnouncementById($id) {
            $this->db->query("SELECT * FROM announcements WHERE announcement_id = :id AND is_deleted = 0");
            $this->db->bind(':id', $id);
            return $this->db->single();
        }
    }

?>