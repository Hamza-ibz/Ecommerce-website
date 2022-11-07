<?php
    //Start session management
    session_start();

    //Get name and address strings - need to filter input to reduce chances of SQL injection etc.
    $userid= filter_input(INPUT_POST, 'username', FILTER_SANITIZE_STRING);
    $password = filter_input(INPUT_POST, 'password', FILTER_SANITIZE_STRING);    

    //Connect to MongoDB and select database
	require __DIR__ . '/vendor/autoload.php';//Include libraries
	$mongoClient = (new MongoDB\Client);//Create instance of MongoDB client
	$db = $mongoClient->ecommerce;
	
    //Create a PHP array with our search criteria
    $findCriteria = [ "userid" => $userid ];

    //Find all of the customers that match  this criteria
    $resultArray = $db->customer->find($findCriteria)->toArray();

    //Check that there is exactly one customer
    if(count($resultArray) == 0){
        echo 'Customer userid not found';
        return;
    }
    else if(count($resultArray) > 1){
        echo 'Database error: Multiple customers have same userid.';
        return;
    }
   
    //Get customer and check password
    $customer = $resultArray[0];
    if($customer['password'] != $password){
        echo 'Password incorrect.';
        return;
    }
        
    //Start session for this user
    $_SESSION['loggedInUseruserid'] = $userid;
    
    //Inform web page that login is successful
    echo $userid;  
   
	
    