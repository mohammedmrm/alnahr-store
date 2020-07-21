<?php
session_start();
error_reporting(0);
header('Content-Type: application/json');
require_once("_apiAccess.php");
//access();
require_once("../script/dbconnection.php");
$id = trim($_REQUEST['id']);

try{
  $sql = "select * from product where id=?";
  $data = getData($con,$sql,[$id]);
  foreach($data as $product){
    $sql = "SELECT attribute.* FROM configurable_product
            left join product on product.id = configurable_product.product_id
            left join sub_option on sub_option.configurable_product_id = configurable_product.id
            left join attribute on sub_option.attribute_id = attribute.id
            where product.id =? group by attribute.id";
    $res = getData($con,$sql,[$id]);
    $i = 0;
    foreach($res as $attr){
      $sql = "select attribute_config.*, attribute.id as attribute_id from attribute
              LEFT JOIN attribute_config on attribute_config.attribute_id = attribute.id
              left join sub_option on sub_option.attribute_config_id = attribute_config.id
              left join configurable_product on configurable_product.id = sub_option.configurable_product_id
              where attribute.id = ? and configurable_product.product_id = ? GROUP by attribute_config.id";
      $config = getData($con,$sql,[$attr['id'],$id]);
      $res[$i]['config'] = $config;
      $i++;
    }
    $data[0]['attribute'] = $res;
    $sql = "select * from images where product_id=?";
    $images = getData($con,$sql,[$id]);
    $data[0]['images']= $images;
  }
  $success="1";
} catch(PDOException $ex) {
   $data=["error"=>$ex];
   $success="0";
}
echo (json_encode(array('code'=>200,'message'=>$msg,"success"=>$success,"data"=>$data,'pages'=>$pages,'page'=>$page)));
?>