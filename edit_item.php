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

//Extract the data that was sent to the server
$search_string = filter_input(INPUT_POST, 'search', FILTER_SANITIZE_STRING);

//Create a PHP array with our search criteria
$findCriteria = [
    '$text' => [ '$search' => $search_string ] 
 ];

//Find all of the customers that match  this criteria
$cursor = $db->products->find([ 'name' => $search_string ]);

//Output the results as forms
echo "<div id=edit-item>"; 
echo "<h1>Product</h1>";   
foreach ($cursor as $cust){
    echo '<form action="replace_item.php" method="post">';
    echo 'Name: <input type="text" name="name" value="' . $cust['name'] . '" required><br>';
    echo 'description: <input type="text" name="description" value="' . $cust['description'] . '" required><br>';
    echo 'Image_url: <input type="text" name="Image_url" value="' . $cust['Image_url'] . '" required><br>'; 
    echo 'width: <input type="text" name="width" value="' . $cust['width'] . '" required><br>';
    echo 'height: <input type="text" name="height" value="' . $cust['height'] . '" required><br>';
    echo 'price: <input type="number" name="price" value="' . $cust['price'] . '" required><br>';
    echo 'stock_count: <input type="number" name="stock_count" value="' . $cust['stock_count'] . '" required><br>';
    echo '<input type="hidden" name="id" value="' . $cust['_id'] . '" required>'; 
    echo '<input type="submit">';
    echo '</form><br>';
}
echo "</div>";

 