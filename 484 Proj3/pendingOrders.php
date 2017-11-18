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
            if ($_SESSION["userType"]!== "Barista")
      {
          header("Location: login.php");
          die();
      }
      ?>
     <ul>
      <li><h3 style="color:white"> Tsarbucks</h3></li>
      <li><a class="active" href="baristaHome.php" ><i class="fa fa-home fa-fw" aria-hidden="true"></i>&nbsp;Home</a></li>
           <li><a class="active" href="pendingOrders.php" ><i class="fa fa-book fa-fw" aria-hidden="true"></i>&nbsp;Pending Orders</a></li>
      <li class="loginbtn"><a href="logout.php"><i class="fa fa-arrow-circle-right" aria-hidden="true"></i>&nbsp;Logout</a></li>
    </ul>


<?php
    include("connect.php");

    $orders=array();

    $sql = "SELECT orders.order_id, orders.user_id, orders.product_id, orders.quantity, orders.completed, products.product_id, products.display_name, products.price, products.size
    FROM orders, products
    WHERE orders.product_id=products.product_id
    AND orders.completed =0";
    $query = $conn->query($sql);
     if ($query->num_rows > 0) {
                while($row = $query->fetch_assoc()) {
                  $item = array(
                    $row['order_id'],
                    $row['display_name'],
                    $row['size'],
                    $row['quantity'],
                    $row['price'],
                    $row['completed'],
                    $row['product_id']
                    );
                  array_push($orders, $item);
}
}
$groupedorders=array();
foreach($orders as $key => $val){
  if(!array_key_exists($val[0], $groupedorders)){
    $groupedorders[$val[0]]=array();
    array_push($groupedorders[$val[0]], $val);
  }else{
    array_push($groupedorders[$val[0]], $val);
  }
}
$ordernumber=0;
foreach($groupedorders as $index => $item){
  //item[0] is the first item with order id 
echo
"<div class='container' style='margin-top:5%'>
  <h1> Order". ++$ordernumber."</h1>        
  <table class='table table-hover'>
    <thead>
      <tr>
        <th>Product Name</th>
        <th>Size (oz)</th>
        <th>Quantity</th>
        <th>Price Per Unit</th>
        <th>Order Status</th>
      </tr>
    </thead>
    <tbody>";
    foreach($item as $nindex => $nitem){
      echo
    "<tr>
            <th scope='row'> ".$nitem[1]."</th>
            <td> ".$nitem[2]." </td>
            <td> ".$nitem[3]." </td>
            <td>$".$nitem[4]." </td>
            <form method='post' action='update.php'>"
                    ."<input type='hidden' name='productid' value='".$nitem[6]."'>"
                    ."<td> <button type='submit' name='orderid' class='btn btn-success btn-md active' role='button' value='".$nitem[0]."' aria-pressed='true'>Mark as Complete</a> </td>
                    </form>
            <tr>";
          }
          //}
            echo
"
            </tbody>
  </table>
</div>";
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

