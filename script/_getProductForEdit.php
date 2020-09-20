<?php
session_start();
error_reporting(0);
header('Content-Type: application/json');
require_once("_access.php");
require_once("dbconnection.php");
$id = $_REQUEST['id'];

try{
    $query = 'select product.*,category.title as category_name,
              stores.name as store_name,image.img as img
              from product
              left join stores on stores.id = product.store_id
              left join category on category.id = product.category_id
              left join (select max(path) as img,product_id from images
              group by product_id) image on image.product_id = product.id
              where product.id = ?';

    $data = getData($con,$query,[$id]);
    $i=0;
    foreach($data as $v){
        $sql = 'SELECT * FROM configurable_product
               where product_id ='.$id;
       $config_pro = getData($con,$sql);
       $data[$i]["configurable_product"] = $config_pro;
       $j=0;
       foreach($config_pro as $at){
         $sql ="select * from sub_option
          left join attribute on attribute.id = sub_option.attribute_id
          left join attribute_config on attribute_config.id = sub_option.attribute_config_id
         where configurable_product_id=".$at['id'];
         $config  = getData($con,$sql);
         $data[$i]["configurable_product"][$j]['config'] = $config;
         $j++;
       }
       $sql ="select * from images where product_id = ?";
       $img = getData($con,$sql,[$id]);
       $data[$i]['images'] = $img;
       $i++;
    }
  $success="1";
} catch(PDOException $ex) {
   $data=["error"=>$ex];
   $success="0";
}

echo (json_encode(array("success"=>$success,"data"=>$data,'role'=>$_SESSION['role'])));
?>