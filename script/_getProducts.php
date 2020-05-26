<?php
session_start();
error_reporting(0);
header('Content-Type: application/json');
require("_access.php");

require("dbconnection.php");
$limit = 10;
try{
  $count = "select count(*) as count from product ";
  $query = "select * from product left join configurable_product on configurable_product.product_id = product.id";

  $data = getData($con,$query);
  $ps = getData($con,$count);
  $pages= ceil($ps[0]['count']/$limit);
  $success="1";
} catch(PDOException $ex) {
   $data=["error"=>$ex];
   $success="0";
}

echo (json_encode(array("success"=>$success,"data"=>$data,'pages'=>$pages,'page'=>$page+1)));
?>