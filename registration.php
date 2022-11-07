<?php

//Include libraries
require __DIR__ . '/vendor/autoload.php';

//Create instance of MongoDB client
$mongoClient = (new MongoDB\Client);

//Select a database
$db = $mongoClient->ecommerce;

//Select a collection 
$collection = $db->customer;


//Get name and address strings - need to filter input to reduce chances of SQL injection etc.
header('Access-Control-Allow-Origin: *');

header('Access-Control-Allow-Methods: GET, POST, OPTIONS');

header('Access-Control-Allow-Headers: Origin, Content-Type, Accept, 
    Authorization, X-Request-With');

header('Access-Control-Allow-Credentials: true');

$name = filter_input(INPUT_POST, 'name', FILTER_SANITIZE_STRING);
$email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_STRING);
$newpassword = filter_input(INPUT_POST, 'newpassword', FILTER_SANITIZE_STRING);
$usrid = filter_input(INPUT_POST, 'usrid', FILTER_SANITIZE_STRING);
$usrphone = filter_input(INPUT_POST, 'phone', FILTER_SANITIZE_STRING);

foreach($collection->find() as $cust){
    if($usrid==$cust['userid']){
        echo 'userid exists';
        return;
    }
}

if ($name != "" && $email != "" && $newpassword != "" && $usrid != "" && $usrphone != "") { //Check query parameters 
    //STORE REGISTRATION DATA IN MONGODB
    $dataArray = [
        "firstname" => $name,
        "email" => $email,
        "password" => $newpassword,
        "userid" => $usrid,
        "phone" => $usrphone
    ];
    // echo json_encode($dataArray);
    $insertResult = $collection->insertOne($dataArray);

    //Output message confirming registration
    echo 'Thank you for registering ' . $name;

} else { //A query string parameter cannot be found
    echo 'Registration data missing';
}
