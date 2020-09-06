<?php
session_start();
header('Content-Type: application/json');
require("_access.php");
access([1,2,3,4,5,6]);
if(empty($branch)){
  $branch =1;
}
require("dbconnection.php");
try{
  $query = "select * from clients where company_id=?";
  $data = getData($con,$query,[$_SESSION['company_id']]);
  $success="1";
} catch(PDOException $ex) {
   $data=["error"=>$ex];
   $success="0";
}
echo (json_encode(array("success"=>$success,"data"=>$data,"Q"=>$query)));
?>