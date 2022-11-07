
<?php
//Include libraries
require __DIR__ . '/vendor/autoload.php';
    
//Create instance of MongoDB client
$mongoClient = (new MongoDB\Client);

//Select a database
$db = $mongoClient->ecommerce;

//Extract the data that was sent to the server
$search_string = filter_input(INPUT_POST, 'product', FILTER_SANITIZE_STRING);

//Create a PHP array with our search criteria
$findCriteria = [
    '$text' => ['$search' => $search_string] 
 ];

//Find all of the customers that match  this criteria
$cursor = $db->products->find($findCriteria);

//Output the results
echo "<table>";
foreach ($cursor as $cust){
   echo "<tr>";
   echo " <td> Products: " . $cust['name'] . "<td>";
   echo " <td>Price: £". $cust['price'] . "</td>";
   echo " <td><img width=100 height=100 src='" . $cust['Image_url'] .  "'> </td>";
   echo "</tr>";
}
echo "</table>";

