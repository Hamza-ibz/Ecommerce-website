<?php
    //Start session management
    session_start();
    
    if( array_key_exists("loggedInUseruserid", $_SESSION) ){
        echo "ok";
    }
    else{
        echo 'Not logged in.';
    }

