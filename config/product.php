<?php

class Product {
  
  private $conn;
  private $table_name = 'products';
  
  public $id;
  public $name;
  public $description;
  public $price;
  public $created;
  
  public function __construct($db) {
    $this->conn = $db;
  }
  
  function readAll() {
    $query = "SELECT id, name, description, price, created FROM " . $this->table_name . " ORDER BY id DESC";
    $stmt = $this->conn->prepare( $query );
    $stmt->execute();
    return $stmt;
  }
  
  function readOne() {
    $query = "SELECT id, name, description, price, created FROM " . $this->table_name . " WHERE id = " .  $this->id . "";
    $stmt = $this->conn->prepare( $query );
    $stmt->execute();
    return $stmt;
  }
  
  function deleteProduct() {
    $query = "DELETE FROM ". $this->table_name ." WHERE id = " . $this->id . "";
    $stmt = $this->conn->prepare( $query );
    $stmt->execute();
    return $stmt;
  }
  
  function createProduct() {
    $query = "INSERT INTO " . $this->table_name . "(name, description, price) VALUES (:name, :description, :price)";
    $stmt = $this->conn->prepare( $query );
    $stmt->bindParam(':name', $this->name, PDO::PARAM_STR, 100);
    $stmt->bindParam(':description', $this->description, PDO::PARAM_STR, 100);
    $stmt->bindParam(':price', $this->price, PDO::PARAM_STR, 100);
    $stmt->execute();
    return $stmt;
  }
  
  function updateProduct(){

      // update query
      $query = "UPDATE 
                  " . $this->table_name . "
              SET 
                  name = :name, 
                  price = :price, 
                  description = :description 
              WHERE
                  id = :id";

      // prepare query statement
      $stmt = $this->conn->prepare($query);

      // bind new values
      $stmt->bindParam(':name', $this->name);
      $stmt->bindParam(':price', $this->price);
      $stmt->bindParam(':description', $this->description);
      $stmt->bindParam(':id', $this->id);

      // execute the query
      if($stmt->execute()){
          return true;
      }else{
          return false;
      }
  }
}

?>