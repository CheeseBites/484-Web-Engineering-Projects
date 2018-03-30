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


		
		 <ul>
		  <li><h3 style="color:white"> Tsarbucks</h3></li>
		  <li><a class="active" href="#home" ><i class="fa fa-home fa-fw" aria-hidden="true"></i>&nbsp;Home</a></li>
		  <li class="loginbtn"><a href="#login"><i class="fa fa-arrow-circle-right" aria-hidden="true"></i>&nbsp;Login</a></li>
		</ul>

		<h1>Login</h1>
		
        <div class="container">

        <form method="post">
  <div class="form-group row">
    <label for="inputUsername" class="col-sm-2 col-form-label" style="text-align:right">Username</label>
    <div class="col-sm-10">
      <input type="text" class="form-control" id="inputUsername" placeholder="Username" name="username">
    </div>
    </div>
  <div class="form-group row">
    <label for="inputPassword" class="col-sm-2 col-form-label" style="text-align:right">Password</label>
    <div class="col-sm-10">
      <input type="password" class="form-control" id="inputPassword" placeholder="Password" name="pwd" >
    </div>
  </div>
  <input name="submit" type="submit" class="btn btn-success btn-lg" value="Login" style="margin-left: 10%">
</form>

</div>
        
<?php
    if(isset($_POST['submit'])){

        include("connect.php");
        session_start();
        $username=$_POST['username'];
        $password=$_POST['pwd'];
        $_SESSION['login_user']=$username;
        $query = $conn->query("SELECT username, display_name, user_id FROM users WHERE username ='$username' and password='$password'");
        if ($query->num_rows != 0)
        {
            $row = $query->fetch_assoc();
            $_SESSION['user']=$row['user_id'];
        if($row["display_name"]=="Customer"){
            $_SESSION["userid"]=$row["user_id"];
            $_SESSION["userType"]=$row["display_name"];
     echo "<script language='javascript' type='text/javascript'> location.href='customerHome.php' </script>";  
        }else{
             $_SESSION["userid"]=$row["user_id"];
            $_SESSION["userType"]=$row["display_name"];
            echo "<script language='javascript' type='text/javascript'> location.href='baristaHome.php' </script>";  
        }
      }
      else
      {
    echo "<script type='text/javascript'>alert('User Name Or Password Invalid!')</script>";
    }
    }
?>


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