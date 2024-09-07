<?php
include_once 'db_handler.php';

class Item {
    private $db;
    private $table_name = "Products";

    public function __construct() {
        $database = new DbHandler();
        $this->db = $database->getConnection();
    }

    public function getItems() {
        $query = "SELECT product_id, product_name, price, product_url, instock 
				  FROM " . $this->table_name;
        $stmt = $this->db->prepare($query);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
	
	public function getItemDetails($itemId) {
        $query = "SELECT * FROM " . $this->table_name . " WHERE product_id = :itemId";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':itemId', $itemId);
        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function fetchByCategory($category) {
        $query = "
            SELECT product_id, product_name, price, product_url, instock
            FROM " . $this->table_name . " 
            WHERE category = :category OR :category = ''";
        
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':category', $category);
        $stmt->execute();
        
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
	
	public function searchItems($searchTerm) {
        $query = "
            SELECT product_id, product_name, price, product_url, instock
            FROM " . $this->table_name . " 
            WHERE product_name LIKE :searchTerm";

        $searchTerm = "%" . $searchTerm . "%";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':searchTerm', $searchTerm);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
?>
