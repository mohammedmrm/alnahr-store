<?php
session_start();
header('Content-Type: application/json');
require("_access.php");
access([1,2,3,4,5,6]);
$id = $_REQUEST['id'];
require("dbconnection.php");
try{
  $query = "select * from attribute_config where id =?";
  $data = getData($con,$query,[$id]);
  $success="1";
} catch(PDOException $ex) {
   $data=["error"=>$ex];
   $success="0";
}
echo (json_encode(array("success"=>$success,"data"=>$data)));
?>