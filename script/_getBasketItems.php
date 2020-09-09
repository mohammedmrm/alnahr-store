<?php
session_start();
header('Content-Type: application/json');
error_reporting(0);
require_once("_access.php");
access([1,2,3,10]);
$id = $_REQUEST['id'];
$success="0";
require_once("dbconnection.php");
try{
   $sql ="select *,basket_items.qty as qty,basket_items.id as bi_id from basket_items
            left join configurable_product on configurable_product.id = basket_items.configurable_product_id
            left join (
                     select  max(path) as path,product_id from images
                     group by images.product_id
            ) a on a.product_id = configurable_product.product_id
            where basket_id=?";
    $data = getData($con,$sql,[$id]);
    $success="1";
} catch(PDOException $ex) {
   $data=["error"=>$ex,'q'=>$query];
   $success="0";
}
echo (json_encode(array("success"=>$success,"data"=>$data)));
?>