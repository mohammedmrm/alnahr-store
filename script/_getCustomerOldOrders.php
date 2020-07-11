<?php
session_start();
header('Content-Type: application/json');
require_once("_access.php");
access([1,2,3,4,5,6]);
require_once("dbconnection.php");
$phone = $_REQUEST['phone'];
try{
  $query = "select * from orders where customer_phone  like '%".$phone."%' order by date DESC limit 20";
  $data = getData($con,$query);
  $success="1";
} catch(PDOException $ex) {
   $data=["error"=>$ex];
   $success="0";
}
print_r(json_encode(array("success"=>$success,"data"=>$data)));
?>