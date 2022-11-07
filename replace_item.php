<?php 

    include('common.php'); // Include the PHP functions to be used on the page
	outputHeader("Home Page"); // outputs the head, title and link. with the $Tab_title of "Home Page"
	?>
	<section class="H_main">
		<?php
    Navigation("Product"); // outputs the banner and the navigation bar along side a number of images. contains the $Page_title of "Home".
?>
<?php
//Include libraries
require __DIR__ . '/vendor/autoload.php';
    
//Create instance of MongoDB client
$mongoClient = (new MongoDB\Client);

//Select a database
$db = $mongoClient->ecommerce;

//Extract the customer details 
$name= filter_input(INPUT_POST, 'name', FILTER_SANITIZE_STRING);
$description = filter_input(INPUT_POST, 'description', FILTER_SANITIZE_STRING);
$Image_url = filter_input(INPUT_POST, 'Image_url', FILTER_SANITIZE_STRING);
$width= filter_input(INPUT_POST, 'width', FILTER_SANITIZE_STRING);
$height= filter_input(INPUT_POST, 'height', FILTER_SANITIZE_STRING);
$price = filter_input(INPUT_POST, 'price', FILTER_SANITIZE_STRING);
$stock_count = filter_input(INPUT_POST, 'stock_count', FILTER_SANITIZE_STRING);
$id = filter_input(INPUT_POST, 'id', FILTER_SANITIZE_STRING);

//Criteria for finding document to replace
$replaceCriteria = [
    "_id" => new MongoDB\BSON\ObjectID($id)
];

//Data to replace
$customerData = [
    "name" => $name,
    "description" => $description,
    "Image_url" => $Image_url,
    "width" => $width,
    "height" => $height,
    "price" => (int)$price,
    "stock_count" => (int)$stock_count
];

//Replace customer data for this ID
$updateRes = $db->products->replaceOne($replaceCriteria, $customerData);
    
//Echo result back to user
if($updateRes->getModifiedCount() == 1)
echo "<h1 id=edit-item>item successfully edited.</h1>";
else
    echo "<h1 id=edit-item>item editing error.</h1>";


