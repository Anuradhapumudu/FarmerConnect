<?php

class M_Marketplace{

      private $db;
    public function __construct($database) {
        $this->db = $database;
    }

//checks seller exist
    public function sellerExists($seller_id) {
        $this->db->query("SELECT COUNT(*) AS count FROM sellers WHERE seller_id = :seller_id");
        $this->db->bind(':seller_id', $seller_id);
        $row = $this->db->single();
        return $row->count > 0;
    }

    //create
    public function createProduct($data) {

        // Insert product
        $this->db->query("INSERT INTO products
            (item_name, seller_id, category, description,province, region, unit_type, price_per_unit, available_quantity, image_url, status)
            VALUES (:name, :seller_id, :category, :description, :province, :region, :unit_type, :price, :available, :image, :status)");
        
        $this->db->bind(':name', $data['name']);
        $this->db->bind(':seller_id', $data['seller_id']);
        $this->db->bind(':category', $data['category']);
        $this->db->bind(':description', $data['description']);
        $this->db->bind(':province', $data['province']);
        $this->db->bind(':region', $data['region']);
        $this->db->bind(':unit_type', $data['unit_type']);
        $this->db->bind(':price', $data['price']);
        $this->db->bind(':available', $data['available']);
        $this->db->bind(':image', $data['image']);
        $this->db->bind(':status', $data['status']);

        return $this->db->execute();
  
}



//read

public function getProductByInternalId($item_id) {
    $this->db->query("
        SELECT 
            p.*, 
            CONCAT(s.first_name, ' ', s.last_name) AS seller_name,
            s.phone_no AS seller_telNo,
            s.address AS seller_address,
            s.company_name AS seller_company
        FROM products AS p
        INNER JOIN sellers AS s ON p.seller_id = s.seller_id
        WHERE p.item_id = :item_id
        LIMIT 1
    ");
    
    $this->db->bind(':item_id', $item_id);
    
    return $this->db->single();
}



public function getProductById($item_id) {
    $this->db->query("SELECT * FROM products WHERE item_id = :item_id");
    $this->db->bind(':item_id', $item_id);

    return $this->db->single(); // Fetch one product record
}


    // Get products by seller for 
    public function getProductsBySeller($seller_id) {
        $this->db->query("SELECT * FROM products WHERE seller_id = :seller_id");
        $this->db->bind(':seller_id', $seller_id);
        return $this->db->resultSet();
    }
       public function getProductsByCategory($category) {
    $this->db->query("
        SELECT 
            p.*, 
            p.unit_type,
            p.province,
            p.region,
            CONCAT(s.first_name, ' ', s.last_name) AS seller_name, 
            s.company_name,
            s.phone_no AS seller_telNo,
            s.email,
            s.address AS seller_address
        FROM products p
        JOIN sellers s ON p.seller_id = s.seller_id
        WHERE p.category = :category
    ");

    $this->db->bind(':category', $category);
    return $this->db->resultSet();
}




    //update
public function updateProduct($item_id, $data) {
    $this->db->query("UPDATE products SET 
        item_name = :item_name,
        category = :category,
        description = :description,
        status = :status,
        province = :province,
        region = :region,
        unit_type = :unit_type,
        price_per_unit = :price_per_unit,
        available_quantity = :available_quantity,
        image_url = :image_url
        WHERE item_id = :item_id
    ");

    $this->db->bind(':item_name', $data['item_name']);
    $this->db->bind(':category', $data['category']);
    $this->db->bind(':description', $data['description']);
    $this->db->bind(':status', $data['status']);
    $this->db->bind(':province', $data['province']);
    $this->db->bind(':region', $data['region']);
    $this->db->bind(':unit_type', $data['unit_type']);
    $this->db->bind(':price_per_unit', $data['price_per_unit']);
    $this->db->bind(':available_quantity', $data['available_quantity']);
    $this->db->bind(':image_url', $data['image_url']);
    $this->db->bind(':item_id', $item_id);

    return $this->db->execute();
}



    //delete
    public function deleteProduct($item_id) {
        $this->db->query('DELETE FROM products WHERE item_id = :item_id');
        $this->db->bind(':item_id', $item_id);
        return $this->db->execute();
    }


    //buy product
// Place an order
        public function createOrder($buyer_id, $item_id, $seller_id, $quantity, $total_price, $payment_method) {
            $this->db->query("INSERT INTO orders (item_id, seller_id, buyer_id, quantity, total_price, payment_method) 
                            VALUES (:item_id, :seller_id, :buyer_id, :quantity, :total_price, :payment_method)");
            
            $this->db->bind(':item_id', $item_id);
            $this->db->bind(':seller_id', $seller_id);
            $this->db->bind(':buyer_id', $buyer_id);
            $this->db->bind(':quantity', $quantity);
            $this->db->bind(':total_price', $total_price);
            $this->db->bind(':payment_method', $payment_method);

            return $this->db->execute();
        }

        // Update product stock
        public function updateStock($item_id, $newQty) {
            $this->db->query("UPDATE products SET available_quantity = :qty WHERE item_id = :item_id");
            $this->db->bind(':qty', $newQty);
            $this->db->bind(':item_id', $item_id);
            return $this->db->execute();
        }


    //get all products
public function getAllProducts() {
    $this->db->query("
        SELECT p.*, 
               s.first_name AS seller_name,
               s.company_name AS seller_company,
               s.address AS seller_address,
               s.phone_no AS seller_telNo
        FROM products p
        LEFT JOIN sellers s ON p.seller_id = s.seller_id
    ");

    return $this->db->resultSet();
}



}
?>