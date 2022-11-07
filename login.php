<?php
include('common.php'); // Include the PHP functions to be used on the page
outputHeader("Login Page"); // outputs the head, title and link. with the $Tab_title of "Home Page"
?>
<section class="H_main">
    <?php
    Navigation("Login"); // outputs the banner and the navigation bar along side a number of images. contains the $Page_title of "Home".
    ?>

    <div class="L-main-img">
        <img src="images/main1.svg" alt="" width="850px" height="100%" />
    </div>

    <div class="form-box" id="form">
        <div class="button-box" id=buttons>
            <div id="btn"></div>
            <button type="button" class="toggle-btn" onclick="login()">login</button>
            <button type="button" class="toggle-btn" onclick="register()">register</button>
        </div>
        <!-- login form -->
        <form onsubmit="return false" id="login" class="input-group">
            <input type="text" class="input-field" placeholder="user id" id="username" required>
            <input type="password" class="input-field" placeholder="password" id="password" required>
            <button type="submit" class="submit-btn" onclick="donelogin()">log in</button>
            <p id="loginFailure" style="color:red;"></p>
        </form>

        <!-- register form -->
        <form onsubmit="return false" id="register" class="input-group">
            <p id="messages"></p>
            <input type="text" class="input-field" placeholder="Full name" id="name" required>
            <input type="text" class="input-field" placeholder="user id" id="newuser" required>
            <input type="text" class="input-field" placeholder="email" id="email" required>
            <input type="text" class="input-field" placeholder="phone number" id="phone" required>
            <input type="password" class="input-field" placeholder="password" id="newpassword" required>
            <button type="submit" class="submit-btn" onclick="doneregister()" id="sbt-register">register</button>
        </form>
    </div>

    <!-- animation on slider from login to register -->
    <script>
        var t = document.getElementById("login");
        var y = document.getElementById("register");
        var z = document.getElementById("btn");

        function register() {
            t.style.left = "100%";
            y.style.left = "5%";
            z.style.left = "50%";
        }

        function login() {
            t.style.left = "5%";
            y.style.left = "100%";
            z.style.left = "0%";
        }

        function doneregister() {
            //Create request object 
            let request = new XMLHttpRequest();
            let registered = true;

            //Create event handler that specifies what should happen when server responds
            request.onload = () => {
                //Check HTTP status code
                if (request.status === 200) {
                    //Get data from server
                    let responseData = request.responseText;

                    //Add data to page
                    document.getElementById("messages").innerHTML = responseData;
                    console.log(responseData);

                    if (responseData == 'Thank you for registering ' + usrName && registered == true) {
                        // document.getElementById("form").innerHTML = '<button  class="submit-btn" onclick="logout()" id="sbt-register" >logout</button>';
                    }
                } else
                    alert("Error communicating with server: " + request.status);
            };

            //Set up request with HTTP method and URL 
            request.open("POST", "registration.php");
            request.setRequestHeader("Content-type", "application/x-www-form-urlencoded");

            //Extract registration data
            let usrName = document.getElementById("name").value;
            let usremail = document.getElementById("email").value;
            let usrPassword = document.getElementById("newpassword").value;
            let usrid = document.getElementById("newuser").value;
            let usrphone = document.getElementById("phone").value;


            //Send request
            request.send("name=" + usrName + "&email=" + usremail + "&newpassword=" + usrPassword + "&usrid=" + usrid + "&phone=" + usrphone);
        }

        //Global variables 
        let loggedInStr = '<button class="submit-btn" onclick="logout()" id="sbt-login" >logout</button> <button class="submit-btn" onclick="editc()" id="edit">edit</button> <button class="submit-btn" id="order" onclick="orders()">orders</button>';
        // let loggedInStri = document.getElementById("username").value;
        let loginStr = document.getElementById("login").innerHTML;
        // let usrid = document.getElementById("username").value;
        let request = new XMLHttpRequest();
        window.onload = checkLogin();

        function editc() {
            // document.getElementById("form").innerHTML = '<form action="replace_customer.php" method="post"> Name: <input type="text" name="name" value= "name" required><br> Email: <input type="email" name="email" value="email" required><br> Password: <input type="password" name="password" value="password" required><br> <input type="text" name="id" value="_id" required> <input type="submit"> </form><br>';
            let reques = new XMLHttpRequest();
            reques.onload = () => {
                //Check HTTP status code
                if (reques.status === 200) {
                    //Get data from server
                    var responseData = reques.responseText;
                    document.getElementById("form").innerHTML = responseData;

                } else {
                    console.log(document.getElementById("usrnm").innerHTML);
                    document.getElementById("login").innerHTML = "Error communicating with server";
                }
            };

            //Set up and send request
            reques.open("POST", "customer_update_forms.php");
            reques.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
            reques.send("username=" + document.getElementById("usrnm").innerHTML);

        };

        //Logs the user out.
        function logout() {
            //Create event handler that specifies what should happen when server responds
            request.onload = function() {
                checkLogin();
            };
            //Set up and send request
            request.open("GET", "logout.php");
            request.send();
        }

        //Checks whether user is logged in.
        function checkLogin() {
            //Create event handler that specifies what should happen when server responds
            request.onload = function() {
                if (request.responseText === "ok") {
                    let usrid=window.localStorage.getItem('name');
                    document.getElementById("login").innerHTML = '<p id=usrnm>' + usrid + '</p>' + loggedInStr;
                    document.getElementById("buttons").style.visibility = 'hidden';

                } else {
                    console.log(request.responseText);
                    document.getElementById("login").innerHTML = loginStr;
                    document.getElementById("buttons").style.visibility = 'visible';
                }
            };
            //Set up and send request
            request.open("GET", "check_login.php");
            request.send();
        }

        function donelogin() {
            let usrid = document.getElementById("username").value;
            let usrPassword = document.getElementById("password").value;
            //Create event handler that specifies what should happen when server responds
            request.onload = function() {
                //Check HTTP status code
                if (request.status === 200) {
                    //Get data from server
                    var responseData = request.responseText;

                    //Add data to page
                    if (responseData === usrid) {
                        document.getElementById("login").innerHTML = '<p id=usrnm>' + usrid + '</p>' + loggedInStr;
                        window.localStorage.setItem('name', responseData);
                        document.getElementById("buttons").style.visibility = 'hidden';
                        // document.getElementById("loginFailure").innerHTML = ""; //Clear error messages
                    } else
                        document.getElementById("loginFailure").innerHTML = request.responseText;
                } else
                    document.getElementById("loginFailure").innerHTML = "Error communicating with server";
            };

            //Extract login data
            // let usrid = document.getElementById("username").value;
            // let usrPassword = document.getElementById("password").value;

            //Set up and send request
            request.open("POST", "customer_login.php");
            request.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
            request.send("username=" + usrid + "&password=" + usrPassword);
        }
    </script>


    <?php
    outputFooter(); // Output the footer
