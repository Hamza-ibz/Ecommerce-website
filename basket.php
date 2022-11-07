<?php

include('common.php'); // Include the PHP functions to be used on the page
outputHeader("Basket Page"); // outputs the head, title and link. with the $Tab_title of "Home Page"
?>
<section class="main">
    <?php
    Navigation("Basket"); // outputs the banner and the navigation bar along side a number of images. contains the $Page_title of "Home".
    ?>

    <!------basket items details------->
    <div class="small-container basket-page" id="check">
        <table>
            <tr>
                <th>Product</th>
                <th>Price</th>
                <th>Image</th>
            </tr>
        </table>
        <p id="p"></p>
        <button onclick=emptyBasket()>Empty Basket</button>
        <button type="button" class="checkout" onclick=checkout()>Checkout</button>
    </div>
    <script>
        function displayProducts(jsonProducts) {
            //Convert JSON to array of product objects
            let prodArray = JSON.parse(jsonProducts);

            //Create HTML table containing product data
            let htmlStr = "<table>";
            for (let i = 0; i < prodArray.length; ++i) {
                htmlStr += "<tr>";
                htmlStr += "<td>" + prodArray[i].name + "</td>";
                htmlStr += "<td>£" + prodArray[i].price + "</td>";
                htmlStr += "<td><img width=50 height=50 src='" + prodArray[i].Image_url + "'></td>";
                htmlStr += "</tr>";
            }
            //Finish off table and add to document
            htmlStr += "</table>";
            document.getElementById("p").innerHTML = htmlStr;
        }

        displayProducts(sessionStorage.getItem("basket"));
        console.log(JSON.parse(sessionStorage.getItem("basket")));

        function emptyBasket() {
            sessionStorage.clear();
            location.reload();
            // loadBasket();
        }

        function checkout() {
            let basket = JSON.parse(sessionStorage.basket);
            let htmlStr = "<form >";
            htmlStr += "<h1>Order has been executed:-<br></h1>";
            for (let i = 0; i < basket.length; ++i) {
                // htmlStr += "<h1>Order has been executed:-<br></h1>";
                htmlStr += "Product name: " + basket[i].name + "<br>";
                htmlStr += "Price: " + basket[i].price + "<br>";
            }
            //Add checkout and empty basket buttons
            htmlStr += "</form>";
            document.getElementById("check").innerHTML = htmlStr;
        }
    </script>
    <?php
    outputFooter(); // Output the footer