<?php
session_start();
error_reporting(0);
header("Access-Control-Allow-Origin: *");
header('Content-Type: application/json');
require_once("_apiAccess.php");
access();
require_once("../script/dbconnection.php");
$id = $_REQUEST['id'];
try{
  $query = "select * from basket
            left join staff on staff.id = basket.staff_id
            left join (
                   select count(*) as items,basket_id from basket_items group by basket_id
            ) a on a.basket_id = basket.id
            where  basket.id=? and basket.staff_id = ?";
  $data = getData($con,$query,[$id,$userid]);
  $sql = "select * from basket_items
   inner join configurable_product
   on configurable_product.id = basket_items.configurable_product_id
   where basket_items.basket_id = ?";
  $res = getData($con,$sql,[$id]);
  $data['items'] = $res;
  $success="1";
} catch(PDOException $ex) {
   $data=["error"=>$ex];
   $success="0";
}
echo (json_encode(array('code'=>200,'message'=>$msg,"success"=>$success,"data"=>$data)));
?>