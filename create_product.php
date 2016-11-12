<?php

include_once('config/database.php');
include_once('config/product.php');

$database = new Database();
$db = $database->getConnection();
$product = new Product($db);

$data = json_decode(file_get_contents("php://input"));

$product->name = $data->name;
$product->description = $data->description;
$product->price = $data->price;

$product->createProduct();

?>