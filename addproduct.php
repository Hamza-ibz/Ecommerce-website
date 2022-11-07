<?php

//Include libraries
require __DIR__ . '/vendor/autoload.php';

//Create instance of MongoDB client
$mongoClient = (new MongoDB\Client);

//Select a database
$db = $mongoClient->ecommerce;

//Select a collection 
$collection = $db->products;


//Get name and address strings - need to filter input to reduce chances of SQL injection etc.
header('Access-Control-Allow-Origin: *');

header('Access-Control-Allow-Methods: GET, POST, OPTIONS');

header('Access-Control-Allow-Headers: Origin, Content-Type, Accept, 
    Authorization, X-Request-With');

header('Access-Control-Allow-Credentials: true');

$name = filter_input(INPUT_POST, 'name', FILTER_SANITIZE_STRING);
$description = filter_input(INPUT_POST, 'description', FILTER_SANITIZE_STRING);
$Image_url= filter_input(INPUT_POST, 'Image_url', FILTER_SANITIZE_STRING);
$width = filter_input(INPUT_POST, 'width', FILTER_SANITIZE_STRING);
$height = filter_input(INPUT_POST, 'height', FILTER_SANITIZE_STRING);
$price = filter_input(INPUT_POST, 'price', FILTER_SANITIZE_STRING);
$stock_count = filter_input(INPUT_POST, 'stock_count', FILTER_SANITIZE_STRING);

// foreach($collection->find() as $cust){
//     if($name==$cust['name']){
//         echo 'userid exists';
//         return;
//     }
// }

if ($name != "" && $description != "" && $Image_url != "" && $width != "" && $height != "" && $price != "" && $stock_count != "") { //Check query parameters 
    //STORE REGISTRATION DATA IN MONGODB
    $dataArray = [
        "name" => $name,
        "description" => $description,
        "Image_url" => $Image_url,
        "width" => $width ,
        "height" => $height,
        "price" => (int)$price,
        "stock_count" => (int)$stock_count
    ];
    // echo json_encode($dataArray);
    $insertResult = $collection->insertOne($dataArray);

    //Output message confirming registration
    echo 'Item added ' . $name;

} else { //A query string parameter cannot be found
    echo 'Data missing';
}
