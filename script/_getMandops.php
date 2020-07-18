<?php
session_start();
header('Content-Type: application/json');
error_reporting(0);
require_once("_access.php");
access([1,2,3,5,6,9]);
require_once("dbconnection.php");
try{
  $query = "select * from staff where role_id=4 order by name";
  $data = getData($con,$query);

  $success="1";
} catch(PDOException $ex) {
   $data=["error"=>$ex];
   $success="0";
}
echo (json_encode(array("success"=>$success,"data"=>$data)));
?>