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
      if($v['type'] == 2){
        $sql = 'SELECT attribute.* FROM configurable_product
                left join product on product.id = configurable_product.product_id
                left join sub_option on sub_option.configurable_product_id = configurable_product.id
                left join attribute on sub_option.attribute_id = attribute.id
                where product.id ='.$id.' group by attribute.id';
       $attr = getData($con,$sql);
       $j=0;
       foreach($attr as $at){
         $sql = 'select attribute_config.*, attribute.id as attribute_id from attribute
                  LEFT JOIN attribute_config on attribute_config.attribute_id = attribute.id
                  left join sub_option on sub_option.attribute_config_id = attribute_config.id
                  left join configurable_product on configurable_product.id = sub_option.configurable_product_id
                  where attribute.id = '.$at['id'].' and configurable_product.product_id ='.$id.' GROUP by attribute_config.id';
          $config = getData($con,$sql);
          $at['config'] = $config;
          $data[$i]['attribute'][$j] = $at;
          $j++;
       }
       $sql ="select * from images where product_id = ?";
       $img = getData($con,$sql,[$id]);
       $data[$i]['images'] = $img;
       $i++;
      }
    }
  $success="1";
} catch(PDOException $ex) {
   $data=["error"=>$ex];
   $success="0";
}

echo (json_encode(array("success"=>$success,"data"=>$data,'role'=>$_SESSION['role'])));
?>