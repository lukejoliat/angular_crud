<?php

  include_once('config/database.php');
  include_once('config/product.php');

  $database = new Database();
  $db = $database->getConnection();
  $product = new Product($db);

  //read json data to get id.
  $data = json_decode(file_get_contents("php://input"));     

  $product->id = $data->id;

  $product->deleteProduct();

  echo '{"records":[ { "id" : "' . $data->id . '"}]}'; 

?>