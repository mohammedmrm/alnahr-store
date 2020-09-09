<?php
session_start();
header('Content-Type: application/json');
require_once("_access.php");
access([1,2,3,4,5,6,10]);
require_once("dbconnection.php");
$ids = $_REQUEST['attributes'];
$data=[];
try{
  foreach ($ids as $id){
    $query1 = "select * from attribute where id=?";
    $data1 = getData($con,$query1,[$id]);
    $query2 = "select * from attribute_config where attribute_id=?";
    $data2 = getData($con,$query2,[$id]);
    $data[] = ['attribute'=>$data1[0],'config'=>$data2];
    $success="1";
  }
} catch(PDOException $ex) {
   $data=["error"=>$ex];
   $success="0";
}
echo (json_encode(array("success"=>$success,"data"=>$data)));
?>