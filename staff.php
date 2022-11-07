<?php

include('common.php'); // Include the PHP functions to be used on the page
outputHeader("Staff Page"); // outputs the head, title and link. with the $Tab_title of "Home Page"
?>
<section class="H_main">
    <?php
    Navigation("Staff"); // outputs the banner and the navigation bar along side a number of images. contains the $Page_title of "Home".
    ?>
    <!---image of laptop with gadgets------>
    <div class="L-main-img">
        <img src="images/main1.svg" alt="" width="850px" height="100%" />
    </div>
    <!-- staff loggin form -->
    <div class="form-box">
        <p class="staff-login">Staff login</p>
        <form onsubmit="return false" id="login" class="input-group">
            <input type="text" class="input-field" placeholder="user id" id="username" required>
            <input type="password" class="input-field" placeholder="password" id="password" required>
            <button type="submit" class="submit-btn" onclick="slogin()">log in</button>
            <p id="loginFailure" style="color:red;"></p>
        </form>

    </div>
    <!-- javascript on animation from login to register -->
    <script>
        window.onload = document.getElementById("snav").style.visibility = 'hidden';
        let loggedInStr = "Logged in <button onclick='logout()'>Logout</button>";
        let loginStr = document.getElementById("login").innerHTML;
        let request = new XMLHttpRequest();
        window.onload = checkLogin;

        function slogin() {
            let request = new XMLHttpRequest();
            let usrid = document.getElementById("username").value;
            let usrPassword = document.getElementById("password").value;
            //Create event handler that specifies what should happen when server responds
            request.onload = function() {
                //Check HTTP status code
                if (request.status === 200) {
                    //Get data from server
                    var responseData = request.responseText;

                    //Add data to page
                    if (responseData === "ok") {
                        document.getElementById("login").innerHTML = loggedInStr;
                        document.getElementById("snav").style.visibility = 'visible';
                    } else
                        document.getElementById("loginFailure").innerHTML = request.responseText;
                } else
                    document.getElementById("loginFailure").innerHTML = "Error communicating with server";
            };

            //Extract login data
            // let usrid = document.getElementById("username").value;
            // let usrPassword = document.getElementById("password").value;

            //Set up and send request
            request.open("POST", "scustomer_login.php");
            request.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
            request.send("username=" + usrid + "&password=" + usrPassword);
        }

        function logout() {
            //Create event handler that specifies what should happen when server responds
            request.onload = function() {
                checkLogin();
            };
            //Set up and send request
            request.open("GET", "logout.php");
            request.send();
        }

        function checkLogin() {
            //Create event handler that specifies what should happen when server responds
            request.onload = function() {
                if (request.responseText === "ok") {
                    document.getElementById("login").innerHTML = loggedInStr;
                    // document.getElementById("buttons").style.visibility = 'hidden';
                    document.getElementById("snav").style.visibility = 'visible';
                } else {
                    console.log(request.responseText);
                    document.getElementById("login").innerHTML = loginStr;
                    document.getElementById("snav").style.visibility = 'hidden';
                    // document.getElementById("buttons").style.visibility = 'visible';
                }
            };
            //Set up and send request
            request.open("GET", "check_login.php");
            request.send();
        }
    </script>

    <?php

    outputFooter(); // Output the footer