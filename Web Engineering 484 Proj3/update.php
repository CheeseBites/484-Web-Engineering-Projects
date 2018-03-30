<?php
include("connect.php");
$sql = "UPDATE orders SET completed='1' WHERE order_id='".$_POST['orderid']."' AND product_id='".$_POST['productid']."'";

if($conn->query($sql) == TRUE){
	header("Location:pendingOrders.php");
}
?>