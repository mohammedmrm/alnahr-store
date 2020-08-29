<?php
session_start();
header("Access-Control-Allow-Origin: *");  
header('Content-Type: application/json');
require("_apiAccess.php");
access();
require_once("../script/dbconnection.php");
try{
  $query = "select cites.id as value, cites.name as label from cites";
  $data = getData($con,$query);
  $data2 = $data;
  $i = 0;
  foreach($data2 as $city){
    $sql = "select towns.id as value, towns.name as label from towns where city_id=?";
    $res = getData($con,$sql,[$city['value']]);
    $data[$i]['towns'] = $res;
    $i++;
  }
  $success="1";
} catch(PDOException $ex) {
   $data=["error"=>$ex];
   $success="0";
}
echo (json_encode(array('code'=>200,'message'=>$msg,"success"=>$success,"data"=>$data)));
?>