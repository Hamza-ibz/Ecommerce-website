<?php

include('common.php'); // Include the PHP functions to be used on the page
outputHeader("Home Page"); // outputs the head, title and link. with the $Tab_title of "Home Page"
?>
<section class="H_main">
	<?php
	Navigation("Home"); // outputs the banner and the navigation bar along side a number of images. contains the $Page_title of "Home".
	?>

	<!---image of laptop with gadgets------>
	<div class="main-img">
		<img src="images/main1.svg" alt="" width="730px" height="100%" />
	</div>
	<!---main text------->
	<div class="main-text">
		<h1>Boost<span id="ur">UR</span> favourite gadgets.</h1>
		<!---btn--->
		<a href="products.php" class="main-btn">Browse</a>
	</div>

</section>
<!------products------->
<section class="product">
	<!-----heading----->
	<div class="p-heading">
		<h2>
			<font>Recommended</font> Products
		</h2>
		<p id="p"></p>
	</div>

	<div class="p-heading">
		<h2>
			<font>Valentine</font> Products
		</h2>
		<p id="v"></p>
	</div>


</section>
<!------our brand-------->
<section class="our-brand">
	<!----text------>
	<div class="brand-text">
		<h3>Why shopping with us?</h3>
	</div>
	<!------icon container---->
	<div class="icon-container">
		<div class="i-box">
			<!----icon----->
			<img src="images/customer service.png" alt="" />
			<!-----details------->
			<h1>Customer Service</h1>
			<p>We are very proud of our customer service, with staff who go above and beyond for our customers. The
				high number of positive feedback that we have as a business are a testament to this and our
				customers continue to trust us for the quality and the customer service provided.</p>
		</div>
		<div class="i-box">
			<!----icon----->
			<img src="images/delivery.png" alt="" />
			<!-----details------->
			<h1>Free, Fast Delivery</h1>
			<p>When you order an item from us we aim to give you the best delivery experience possible.You get to
				choose what type of delivery you prefer, standard or express.Not all items have the same delivery
				service due to size and weight but delivery options are presented to you when ordering an item.</p>
		</div>
		<div class="i-box">
			<!----icon----->
			<img src="images/recyclable.png" alt="" />
			<!-----details------->
			<h1>Eco-Friendly Packaging</h1>
			<p>We try to reduce our environmental impact wherever possible. We reuse cardboard boxes where we are
				able to do so, and our packing filler is an eco-friendly, biodegradable 'green-fill'. This can be
				reused, composted, or dissolved down the sink</p>
		</div>
		<div class="i-box">
			<!----icon----->
			<img src="images/returns.png" alt="" />
			<!-----details------->
			<h1>Easy Returns</h1>
			<p>We have a favourable, and easy way of returning a product.We're more than happy to help in the event
				of any issues with products that are damaged or faulty, or are simply unwanted. Just give us a call
				or send an email and our friendly team will be on hand to assist. </p>
		</div>
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
	// localStorage.setItem("recommended", JSON.stringify(sessionStorage.getItem("basket")))
	localStorage.setItem("Valentine", JSON.stringify([{
		name: "SHIELDON Galaxy S20 5G Case",
		price: 20,
		Image_url: "https://images-na.ssl-images-amazon.com/images/I/91ENb89jzcL._AC_SL1500_.jpg"
	}, {
		name: "SURITCH Case for iPhone",
		price: 4,
		Image_url: "https://images-na.ssl-images-amazon.com/images/I/71x5dHFDpdL._AC_SL1200_.jpg"
	}, {
		name: "Beats Solo3 Wireless On-Ear Headphones",
		price: 30.59,
		Image_url: "https://images-na.ssl-images-amazon.com/images/I/51QxA-98Q%2BL._AC_SL1000_.jpg"
	}]));

	window.onload = valentineProducts(localStorage.getItem("Valentine"));

	function displayProducts(jsonProducts) {
		//Convert JSON to array of product objects
		let prodArray = JSON.parse(jsonProducts);

		//Create HTML table containing product data
		let htmlStr = "<table>";
		for (let i = 0; i < prodArray.length; ++i) {
			htmlStr += "<tr>";
			htmlStr += "<td>" + prodArray[i].name + "</td>";
			htmlStr += "<td>£" + prodArray[i].price + "</td>";
			htmlStr += "<td><button onclick= 'addToBasket(" + prodArray[i].price + "," + "\"" + prodArray[i].Image_url + "\"" + ",\"" + prodArray[i].name + "\")'>Add to Bag</button></td>";
			htmlStr += "<td><img width=50 height=50 src='" + prodArray[i].Image_url + "'></td>";
			htmlStr += "</tr>";
		}
		//Finish off table and add to document
		htmlStr += "</table>";
		document.getElementById("p").innerHTML = htmlStr;


	}

	function valentineProducts(jsonProducts) {
		//Convert JSON to array of product objects
		let prodArray = JSON.parse(jsonProducts);

		//Create HTML table containing product data
		let htmlStr = "<table>";
		for (let i = 0; i < prodArray.length; ++i) {
			htmlStr += "<tr>";
			htmlStr += "<td>" + prodArray[i].name + "</td>";
			htmlStr += "<td>£" + prodArray[i].price + "</td>";
			htmlStr += "<td><button onclick= 'addToBasket(" + prodArray[i].price + "," + "\"" + prodArray[i].Image_url + "\"" + ",\"" + prodArray[i].name + "\")'>Add to Bag</button></td>";
			htmlStr += "<td><img width=50 height=50 src='" + prodArray[i].Image_url + "'></td>";
			htmlStr += "</tr>";
		}
		//Finish off table and add to document
		htmlStr += "</table>";
		document.getElementById("v").innerHTML = htmlStr;
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

	displayProducts(localStorage.getItem("recommended"));
	valentineProducts(localStorage.getItem("Valentine"));
</script>


<?php
outputFooter(); // Output the footer
?>