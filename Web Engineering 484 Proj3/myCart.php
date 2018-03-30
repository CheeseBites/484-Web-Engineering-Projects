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

    <div class="container">
  <h1>My Cart</h1>        
  <table class="table table-hover">
    <thead>
      <tr>
        <th>Product Name</th>
        <th>Price</th>
        <th>Size (oz)</th>
      </tr>
    </thead>
    <tbody>
      <?php
            include("connect.php");
            $total=0;
            $totalsize=0;
             if(isset($_POST['submit'])){ 
                 $removeindex=$_POST['item'];
                unset($_SESSION['cart'][$removeindex]);
            }
              if(isset($_SESSION['cart'])){
              foreach ($_SESSION['cart'] as $key => $value) {
                
               
                   echo 
                  "<tr>"
                    ."<th scope='row'>" . $value[1] . "</th>"
                    ."<td>$" . $value[2] . "</td>"
                    ."<td>" . $value[3] . "</td>"
                    ."<form method='post'>"
                    ."<input type='hidden' name='item' value='".$key."'>"
                    ."<td> <button type='submit' class='btn btn-danger btn-md active' value ='menu' role='button' aria-pressed='true' name='submit'>Remove from Cart</a> </td>
                    </form>
                </tr>";
                $total += $value[2];
                $totalsize += $value[3];
          }
            }
        ?>     

    </tbody>
  </table>
</div>
          <?php 
          $sql = "SELECT order_id FROM orders ORDER BY order_id DESC LIMIT 1";
            $nextOrderID;
            $result = $conn->query($sql);
            if($result->num_rows>0){
            $row = $result->fetch_assoc();
            $nextOrderID = $row["order_id"]+1;
            }
            echo
            "<div style='margin-left:10%'>
            <p><b> Total Cost:$". $total. "</b></p>" .
            "<p><b> Total Size:". $totalsize ." oz</b></p>
            
            <form method='post'>
            <button type='submit' class='btn btn-info btn-md active' role='button' aria-pressed='true' name='submit_order'>Submit Order</a>
            </form>
            </div>"
            ;
             if(isset($_POST['submit_order'])){ 
            if(!empty($_SESSION['cart'])){
              $o_id=$nextOrderID;
              $u_id=$_SESSION['userid'];
              $completed=0;
              $quantities = array("1"=>0, "2"=>0,"3"=>0,"4"=>0,"5"=>0,"6"=>0,"7"=>0,"8"=>0);
               foreach ($_SESSION['cart'] as $key => $value) {

                  $p_id=$value[0];
                  $quantities[$p_id]+=1;
                
                }  

                foreach($quantities as $key => $value){
                  if($value!=0){
                    $sql = "INSERT INTO orders (order_id, user_id, product_id, quantity, completed)
            VALUES ('$o_id', '$u_id', '$key', '$value', '$completed')";

            

            if (mysqli_query($conn, $sql)) {
            } else {
                echo "Error: " . $sql . "<br>" . mysqli_error($conn);
            }
                  }
                }
                unset($_SESSION['cart']);
                echo "<script type='text/javascript'>alert('Your order was submitted!')</script>";
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

