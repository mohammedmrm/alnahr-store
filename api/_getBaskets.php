<?php
session_start();
header('Content-Type: application/json');
require_once("_apiAccess.php");
access();
require_once("../script/dbconnection.php");
try{
  $query = "select * from basket where staff_id=?";
  $data = getData($con,$query,[$userid]);
  $success="1";
} catch(PDOException $ex) {
   $data=["error"=>$ex,'q'=>$query];
   $success="0";
}
echo (json_encode(array('code'=>200,'message'=>$msg,"success"=>$success,"data"=>$data)));
?>