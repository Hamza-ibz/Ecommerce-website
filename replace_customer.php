<?php
include('common.php'); // Include the PHP functions to be used on the page
outputHeader("Login Page"); // outputs the head, title and link. with the $Tab_title of "Home Page"
?>
	<section class="H_main">
		<?php
    Navigation("Login"); // outputs the banner and the navigation bar along side a number of images. contains the $Page_title of "Home".
?>
<?php
//Include libraries
require __DIR__ . '/vendor/autoload.php';
    
//Create instance of MongoDB client
$mongoClient = (new MongoDB\Client);

//Select a database
$db = $mongoClient->ecommerce;

//Extract the customer details 
$firstname= filter_input(INPUT_POST, 'firstname', FILTER_SANITIZE_STRING);
$email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_STRING);
$password = filter_input(INPUT_POST, 'password', FILTER_SANITIZE_STRING);
$userid = filter_input(INPUT_POST, 'userid', FILTER_SANITIZE_STRING);
$phone = filter_input(INPUT_POST, 'phone', FILTER_SANITIZE_STRING);
$id = filter_input(INPUT_POST, 'id', FILTER_SANITIZE_STRING);

//Criteria for finding document to replace
$replaceCriteria = [
    "_id" => new MongoDB\BSON\ObjectID($id)
];

//Data to replace
$customerData = [
    "firstname" => $firstname,
    "email" => $email,
    "password" => $password,
    "userid" => $userid,
    "phone" => $phone
];

//Replace customer data for this ID
$updateRes = $db->customer->replaceOne($replaceCriteria, $customerData);
    
//Echo result back to user
if($updateRes->getModifiedCount() == 1)
    // echo 'Customer document successfully replaced.';
    echo "<h1 id=edit-item>Customer document successfully replaced.</h1>";
else
    echo 'Customer replacement error.';


