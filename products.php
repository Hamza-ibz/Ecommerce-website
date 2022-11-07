<?php

include('common.php'); // Include the PHP functions to be used on the page
outputHeader("Products Page"); // outputs the head, title and link. with the $Tab_title of "Home Page"
?>
<section class="main">
	<?php
	echo '<form class="side-box"  onsubmit="return false">';
	echo '<div class="search">';
	// echo '<i class="fas fa-search"></i>';
	echo '<input placeholder="Search" type="text" id= "sear" />';
	echo '</div>';
	echo '<button type="submit" onclick= "search()"> search </button>';
	echo '</form>';
	Navigation("Products"); // outputs the banner and the navigation bar along side a number of images. contains the $Page_title of "Home".
	?>

	<!------product box------->
	<section class="product">
		<!-----heading----->
		<div class="p-heading">
			<h2>
				<font>All</font> Products
			</h2>
			<form onsubmit="return false">
				<h3>sort price:</h3>
				<button onclick="hightolow()">high-low</button>
				<button onclick="lowtohigh()">low-high</button>
			</form>
		</div>
		<!--------product-box-container---->
		<div class="product-container" id="p-body">

		</div>
		<!-- product pages buttons-->
		<div class="page-btn">
			<span class="selected-p">1</span>
			<span>2</span>
			<span>3</span>
			<span> &#8594; </span>
		</div>
	</section>

	<!----subscribe section---->
	<section class="subscribe-container">
		<!----heading----->
		<h3>Subscribe for New Product Releases</h3>
		<!--------input----->
		<div class="subscribe-input">
			<input type="email" placeholder="example@gmail.com" />
			<!-----btn----->
			<a href="#" class="subscribe-btn">Submit</a>
		</div>
	</section>

	<script>
		function search() {
			console.log(document.getElementById("sear").value);
			let request = new XMLHttpRequest();
			let registered = true;

			//Create event handler that specifies what should happen when server responds
			request.onload = () => {
				//Check HTTP status code
				if (request.status === 200) {
					//Get data from server
					let responseData = request.responseText;

					//Add data to page
					document.getElementById("p-body").innerHTML = responseData;

				} else
					alert("Error communicating with server: " + request.status);
			}

			request.open("POST", "find_customer_indexed_search.php");
			request.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
			let searc = document.getElementById("sear").value;
			request.send("product=" + searc);
		}

		//Download products when page loads
		window.onload = loadProducts;

		//Downloads JSON description of products from server
		function loadProducts() {
			//Create request object 
			let request = new XMLHttpRequest();

			//Create event handler that specifies what should happen when server responds
			request.onload = () => {
				//Check HTTP status code
				if (request.status === 200) {
					//Add data from server to page
					displayProducts(request.responseText);
				} else
					alert("Error communicating with server: " + request.status);
			};

			//Set up request and send it
			request.open("GET", "products_data.php");
			request.send();
		}

		//Loads products into page
		function displayProducts(jsonProducts) {
			//Convert JSON to array of product objects
			let prodArray = JSON.parse(jsonProducts);

			//Create HTML table containing product data
			let htmlStr = "<table>";
			for (let i = 0; i < prodArray.length; ++i) {
				htmlStr += "<tr>";
				htmlStr += "<td>" + prodArray[i].name + "</td>";
				htmlStr += "<td>£" + prodArray[i].price + "</td>";
				htmlStr += "<td><button onclick= 'addToBasket("  +prodArray[i].price+","+"\""+prodArray[i].Image_url+"\""+",\""+prodArray[i].name+"\")'>Add to Bag</button></td>";
				htmlStr += "<td><img width=50 height=50 src='" + prodArray[i].Image_url + "'></td>";
				htmlStr += "</tr>";
			}
			//Finish off table and add to document
			htmlStr += "</table>";
			document.getElementById("p-body").innerHTML = htmlStr;
		}

		function addToBasket(prodPrice, prodImage, prodName) {
			let basket = getBasket(); //Load or create basket

			//Add product to basket
			basket.push({
				name: prodName,
				price: prodPrice,
				Image_url: prodImage
			});

			//Store in local storage
			sessionStorage.basket = JSON.stringify(basket);
			localStorage.setItem("recommended", JSON.stringify(basket));

			//Display basket in page.
			// loadBasket();
		}

		function getBasket() {
			let basket;
			if (sessionStorage.basket === undefined || sessionStorage.basket === "") {
				basket = [];
			} else {
				basket = JSON.parse(sessionStorage.basket);
			}
			return basket;
		}

		function emptyBasket() {
			sessionStorage.clear();
			// loadBasket();
		}

		function hightolow() {
			//Create request object 
			let request = new XMLHttpRequest();

			//Create event handler that specifies what should happen when server responds
			request.onload = () => {
				//Check HTTP status code
				if (request.status === 200) {
					//Add data from server to page
					displayProducts(request.responseText);
				} else
					alert("Error communicating with server: " + request.status);
			};

			//Set up request and send it
			request.open("GET", "high_to_low.php");
			request.send();
		}

		function lowtohigh() {
			//Create request object 
			let request = new XMLHttpRequest();

			//Create event handler that specifies what should happen when server responds
			request.onload = () => {
				//Check HTTP status code
				if (request.status === 200) {
					//Add data from server to page
					displayProducts(request.responseText);
				} else
					alert("Error communicating with server: " + request.status);
			};

			//Set up request and send it
			request.open("GET", "low_to_high.php");
			request.send();
		}
		
	</script>

	<!-- <h2>Basket</h2>
	<div id="basketDiv"></div> -->

	<?php

	outputFooter(); // Output the footer