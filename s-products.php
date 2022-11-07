<?php 

    include('common.php'); // Include the PHP functions to be used on the page
	outputHeader("Products Page"); // outputs the head, title and link. with the $Tab_title of "Home Page"
	?>
	<section class="main">
		<?php
		    echo '<form class="side-box"  onsubmit="return false">';
    echo '<div class="search">';
    echo '<input placeholder="Search" type="text" id= "searc" />';
    echo '</div>';
    echo '<button type="submit" onclick= "search()"> search </button>';
    echo '</form>';
    Navigation("Product"); // outputs the banner and the navigation bar along side a number of images. contains the $Page_title of "Home".
?>

	<!------products box------->
	<section class="product">
		<!-----heading----->
		<div class="p-heading">
			<h2>
				<font>All</font> Products
			</h2>
		</div>
		<!--------product-box-container---->
		<div class="product-container" id="p-body">
           
			</div>
			<form onsubmit="return false" id=addform>
			<h1>add product</h1>
            <p id="messages"></p>
            <input type="text" class="input-field" placeholder="name" id="name" required>
            <input type="text" class="input-field" placeholder="description" id="description" required>
            <input type="text" class="input-field" placeholder="Image_url" id="Image_url" required>
            <input type="text" class="input-field" placeholder="width" id="width" required>
			<input type="text" class="input-field" placeholder="height" id="height" required>
			<input type="number" class="input-field" placeholder="price" id="price" required>
            <input type="number" class="input-field" placeholder="stock" id="stock_count" required>
			<button class="new-btn" onclick=addproduct()>Add New Products</button>
		</form>
		<form action="edit_item.php" method="POST" id=addform>
		<h1>Edit Item</h1>
            Item name: <input type="text" name="search" required><br>
            <input type="submit">
        </form>
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
			console.log(document.getElementById("searc").value);
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

			request.open("POST", "staff_search.php");
			request.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
			let search = document.getElementById("searc").value;
			request.send("product=" + search);
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
				htmlStr += "<td><img width=50 height=50 src='" + prodArray[i].Image_url + "'></td>";
				htmlStr += "</tr>";
			}
			//Finish off table and add to document
			htmlStr += "</table>";
			document.getElementById("p-body").innerHTML = htmlStr;
		}

		function edititem(){


		}

		function addproduct(){

			let request = new XMLHttpRequest();

            //Create event handler that specifies what should happen when server responds
            request.onload = () => {
                //Check HTTP status code
                if (request.status === 200) {
                    //Get data from server
                    let responseData = request.responseText;

                    //Add data to page
                    document.getElementById("messages").innerHTML = responseData;
                    console.log(responseData);

                    if (responseData == 'Item added ') {
                        // document.getElementById("form").innerHTML = '<button  class="submit-btn" onclick="logout()" id="sbt-register" >logout</button>';
                    }
                } else
                    alert("Error communicating with server: " + request.status);
            };

            //Set up request with HTTP method and URL 
            request.open("POST", "addproduct.php");
            request.setRequestHeader("Content-type", "application/x-www-form-urlencoded");

            //Extract registration data
            let pame = document.getElementById("name").value;
            let pdescription = document.getElementById("description").value;
            let pimage_url = document.getElementById("Image_url").value;
            let pwidth = document.getElementById("width").value;
			let pheight = document.getElementById("height").value;
			let pprice = document.getElementById("price").value;
			let pstock_count = document.getElementById("stock_count").value;

            //Send request
            request.send("name=" + pame+ "&description=" + pdescription + "&Image_url=" + pimage_url + "&width=" + pwidth + "&height=" + pheight + "&price=" + pprice  + "&stock_count=" + pstock_count );
		}
	</script>


	<?php 
	outputFooter(); // Output the footer