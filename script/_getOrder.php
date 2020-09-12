<?php
session_start();
header('Content-Type: application/json');
require_once("_access.php");
access([1,2,3,5,7]);
require_once("dbconnection.php");
$id = $_REQUEST['id'];
try{
  $query = "select *, date_format(orders.date,'%Y-%m-%d') as date from orders where id = ?";
  $data = getData($con,$query,[$id]);
  $sql = " select * from order_items
  inner join configurable_product on configurable_product.id = order_items.configurable_product_id
  where order_id=?";
  $items=getData($con,$sql,[$id]);
  $data[0]["items"]=$items;
  $success="1";
} catch(PDOException $ex) {
   $data=["error"=>$ex];
   $success="0";
}
echo json_encode(array("success"=>$success,"data"=>$data));
?>