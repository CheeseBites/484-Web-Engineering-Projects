<!doctype html>
<html class="no-js" lang="">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="x-ua-compatible" content="ie=edge">
        <title></title>
        <meta name="description" content="">
        <meta name="viewport" content="width=device-width, initial-scale=1">
		
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.6/css/bootstrap.min.css" integrity="sha384-rwoIResjU2yc3z8GV/NPeZWAv56rSmLldC3R/AZzGRnGxQQKnKkoFVhFQhNUwEyJ" crossorigin="anonymous">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
        <link rel="manifest" href="site.webmanifest">
        <link rel="apple-touch-icon" href="icon.png">
        <!-- Place favicon.ico in the root directory -->
		<link rel="stylesheet" href="styles.css">
        <link rel="stylesheet" href="css/normalize.css">
        <link rel="stylesheet" href="css/main.css">
    </head>
    <body>
		<?php 
        session_start();
            if ($_SESSION["userType"]!== "Customer")
      {
          header("Location: login.php");
          die();
      }
      ?>
		 <ul>
		  <li><h3 style="color:white"> Tsarbucks</h3></li>
		  <li><a class="active" href="customerHome.php" ><i class="fa fa-home fa-fw" aria-hidden="true"></i>&nbsp;Home</a></li>
           <li><a class="active" href="menu.php" ><i class="fa fa-book fa-fw" aria-hidden="true"></i>&nbsp;Menu</a></li>
           <li><a class="active" href="myOrders.php" ><i class="fa fa-list-alt" aria-hidden="true"></i>&nbsp;My Orders</a></li>
           <li class="mycart"><a href="myCart.php"><i class="fa fa-shopping-cart" aria-hidden="true"></i>&nbsp;My Cart</a></li>
		  <li class="loginbtn"><a href="logout.php"><i class="fa fa-arrow-circle-right" aria-hidden="true"></i>&nbsp;Logout</a></li>
		</ul>

		<h1>Home</h1>

		<p>
		<h5><a href="menubackup.php"> Buy something</a> or <a href="logout.php"> get out </h3>
		</p>

        



        <script src="js/vendor/modernizr-3.5.0.min.js"></script>
        <script src="https://code.jquery.com/jquery-3.2.1.min.js" integrity="sha256-hwg4gsxgFZhOsEEamdOYGBf13FyQuiTwlAQgxVSNgt4=" crossorigin="anonymous"></script>
        <script>window.jQuery || document.write('<script src="js/vendor/jquery-3.2.1.min.js"><\/script>')</script>
        <script src="js/plugins.js"></script>
        <script src="js/main.js"></script>

        <!-- Google Analytics: change UA-XXXXX-Y to be your site's ID. -->
        <script>
            window.ga=function(){ga.q.push(arguments)};ga.q=[];ga.l=+new Date;
            ga('create','UA-XXXXX-Y','auto');ga('send','pageview')
        </script>
        <script src="https://www.google-analytics.com/analytics.js" async defer></script>
    </body>
</html>