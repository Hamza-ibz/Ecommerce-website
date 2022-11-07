<?php
//Include libraries
require __DIR__ . '/vendor/autoload.php';
    
//Create instance of MongoDB client
$mongoClient = (new MongoDB\Client);

//Select a database
$db = $mongoClient->ecommerce;

//Find all of the customers that match  this criteria
$cursor = $db->products->find();

$jsonStr = '['; //Start of array of customers in JSON

//Work through the customers
foreach ($cursor as $products){
    //var_dump($customer);
    $jsonStr .= json_encode($products);//Convert PHP representation of customer into JSON 
    $jsonStr .= ',';//Separator between customers
}

//Remove last comma
$jsonStr = substr($jsonStr, 0, strlen($jsonStr) - 1);

//Close array
$jsonStr .= ']';

//Echo final string
echo $jsonStr;




