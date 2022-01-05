<?php
session_start();
header("Access-Control-Allow-Origin: *");  
header('Content-Type: application/json');
require("_apiAccess.php");
access();
require_once("../script/dbconnection.php");
try{
  $query = "select * from category where company_id='".$head_company_id."'";
  $data = getData($con,$query);
  $success="1";
} catch(PDOException $ex) {
   $data=["error"=>$ex];
   $success="0";
}
print_r(json_encode(array('code'=>200,'message'=>$msg,"success"=>$success,"data"=>$data)));
?>