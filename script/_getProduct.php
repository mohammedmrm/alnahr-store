<?php
session_start();
//error_reporting(0);
header('Content-Type: application/json');
require_once("_access.php");
access([1]);
require_once("dbconnection.php");
$id = $_REQUEST['id'];
try{
  $query = "select * from configurable_product where id=?";
  $data = getData($con,$query,[$id]);
  $success="1";
} catch(PDOException $ex) {
   $data=["error"=>$ex];
   $success="0";
}
echo (json_encode(array("success"=>$success,"data"=>$data)));
?>