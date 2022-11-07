<?php

//Include libraries
require __DIR__ . '/vendor/autoload.php';
    
//Create instance of MongoDB client
$mongoClient = (new MongoDB\Client);

//Select a database
$db = $mongoClient->ecommerce;

//Extract the data that was sent to the server
$search_string = filter_input(INPUT_POST, 'username', FILTER_SANITIZE_STRING);

//Create a PHP array with our search criteria
$findCriteria = [
    '$text' => [ '$search' => $search_string ] 
 ];

//Find all of the customers that match  this criteria
$cursor = $db->customer->find($findCriteria);

//Output the results as forms
echo "<h1>Customers</h1>";   
foreach ($cursor as $cust){
    echo '<form action="replace_customer.php" method="post">';
    echo 'Name: <input type="text" name="firstname" value="' . $cust['firstname'] . '" required><br>';
    echo 'Email: <input type="email" name="email" value="' . $cust['email'] . '" required><br>';
    echo 'Password: <input type="password" name="password" value="' . $cust['password'] . '" required><br>'; 
    echo 'userid: <input type="text" name="userid" value="' . $cust['userid'] . '" required><br>';
    echo 'phone: <input type="text" name="phone" value="' . $cust['phone'] . '" required><br>';
    echo '<input type="hidden" name="id" value="' . $cust['_id'] . '" required>'; 
    echo '<input type="submit">';
    echo '</form><br>';
}

 