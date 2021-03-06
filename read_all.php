<?php

include_once('config/database.php');
include_once('config/product.php');

$database = new Database();
$db = $database->getConnection();
$product = new Product($db);

//this will run the query that selects all products and return a result
$result = $product->readAll();

//check if there are results by checking the row count
$num = $result->rowCount();

// check if more than 0 record found
if($num>0){
      
    $x=1;
      
    // retrieve our table contents
    // fetch() is faster than fetchAll()
    // http://stackoverflow.com/questions/2770630/pdofetchall-vs-pdofetch-in-a-loop
    while ($row = $result->fetch(PDO::FETCH_ASSOC)){
        // extract row
        // this will make $row['name'] to
        // just $name only
        extract($row);
      
        //data is manually json formatted    
        $data .= '{';
            $data .= '"id":"'  . $id . '",';
            $data .= '"name":"' . $name . '",';
            $data .= '"description":"' . html_entity_decode($description) . '",';
            $data .= '"price":"' . $price . '"';
        $data .= '}'; 
        
        //examine this bit: it looks like this ends with a comma or without depending on whether or not the array is going to continue
        $data .= $x<$num ? ',' : ''; $x++; } 
} 
 
// json format output 
echo '{"records":[' . $data . ']}'; 


?>