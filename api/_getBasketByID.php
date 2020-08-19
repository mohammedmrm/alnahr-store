<?php
session_start();
error_reporting(0);
header('Content-Type: application/json');
require_once("_apiAccess.php");
access();
require("dbconnection.php");
$id = $_REQUEST['id'];
try{
  $query = "select * from basket
            left join staff on staff.id = basket.staff_id
            left join (
                   select count(*) as items,basket_id from basket_items group by basket_id
            ) a on a.basket_id = basket.id
            where  basket.id=? and basket.staff_id = ?";
  $data = getData($con,$query,[$id,$userid]);
  $success="1";
} catch(PDOException $ex) {
   $data=["error"=>$ex];
   $success="0";
}
echo (json_encode(array('code'=>200,'message'=>$msg,"success"=>$success,"data"=>$data)));
?>