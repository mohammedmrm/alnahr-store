<?php
session_start();
header('Content-Type: application/json');
require_once("_access.php");
//access([1,2,3,4,5,6]);
require_once("dbconnection.php");
try{
  $query = "select * from attribute";
  $data = getData($con,$query);
  $success="1";
} catch(PDOException $ex) {
   $data=["error"=>$ex];
   $success="0";
}
echo json_encode(["success"=>$success,"data"=>$data]);
?>