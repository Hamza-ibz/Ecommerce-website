<?php
function outputHeader($Tab_title){  // This is a function in which outputs the head, title and link. It has a variable "$Tab_title"
    echo '<!DOCTYPE html>';
    echo '<html>';    
    echo '<head>';      // within the <head> tag it contains title and link
    echo '<title>' . $Tab_title . '</title>'; // within the <title> tag it contains a argument of "$Tab_title" in which it differs for each page. the "title" is presented within the tab of the browser
    echo '<link rel="stylesheet" type="text/css" href="css/style.css" />'; // The <link> tag allows to link between pages of code. (allows relationship between the current document and an external resource.)
    echo '</head>'; // closeing for the <head> tag
    echo '<body>'; // opening of the body
}

function Navigation($Page_title){ // this function outputs the banner and the navigation bar along side a number of images.
    echo '<div class="logo"><img src="images/logo.png" alt="boosturtech" width="250" height="90"></div>';
    echo '<nav class="navigation">';
    echo '<ul>'; // unordered list for the navigation button

    if($Page_title == "Staff" || $Page_title == "Product"){
        $linkNames = array("Product", "Staff", "Home"); // array of the pages within the website
        $linkAddresses = array("s-products.php", "staff.php", "home.php");  // array of links to the pages
    }else{

        $linkNames = array("Home", "Products", "Login", "Basket", "Staff"); // array of the pages within the website
        $linkAddresses = array("home.php", "products.php", "login.php", "basket.php", "staff.php");  // array of links to the pages
    }

        $i = 0; // variable set to 0 for the while loop
        while($i < count($linkNames)){  //Output navigation using while loop. while loop only activates when variable i is less then the length of linkNames
            echo '<li><a id="snav"';   // <li> list containing the navigation buttons. The <a> tag is used to link from one page to another.
            if($linkNames[$i] == $Page_title){ // if element within linknames equals to page_title the page will have the class "selected"
                echo 'class="selected" ';
            }
            
            echo 'href="' . $linkAddresses[$i] . '">' . $linkNames[$i] . '</a> </li> '; //href attribute indicates the link's destination ($linkAddresses) for "$linkNames".
            $i++; // variable i incremented by 1 for the loop to continue
        }
    echo '</ul>'; // end of the unordered list (contains the list of navigation)
    echo '</nav>'; // closeing tag for navigation
    echo '</section>';
    
}


function outputFooter(){ // Outputs the footer, closing body tag and closing HTML tag
    echo '
          <footer> 
          <img src="images/logo.png" alt="boosturtech" width="250" height="90" />
          <ul class="footer-menu">
          <li><a href="">Privacy Policy</a></li>
          <li><a href="">Terms of Use</a></li>
          <li><a href="">Returns Policy</a></li>
          <li><a href="">Contact us</a></li>
      </ul>
          </footer>';
    echo '<a href="" class="copyright">Middlesex Copyright 2021. Website made by Alex, Hamza and Israr</a>';
    echo '</body>';
    echo '</html>';
}

