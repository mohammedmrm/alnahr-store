<?php
session_start();
error_reporting(0);
header('Content-Type: application/json');
require_once("_access.php");
require_once("dbconnection.php");
$limit = trim($_REQUEST['limit']);
if(empty($limit) || $limit <=0){
  $limit=15;
}
$page = trim($_REQUEST['p']);
if(empty($page) || $page <=0){
  $page=1;
}
$search = trim($_REQUEST['search']);


try{
    $count = "select count(*) as count from product
              left join stores on stores.id = product.store_id
              left join category on category.id = product.category_id
              left join (select max(path) as img,product_id from images
              group by product_id) image on image.product_id = product.id
              where product.id <> 0 and product.company_id=? ";

    $query = 'select product.*,category.title as category_name,
              stores.name as store_name,image.img as img
              from product
              left join stores on stores.id = product.store_id
              left join category on category.id = product.category_id
              left join (select max(path) as img,product_id from images
              group by product_id) image on image.product_id = product.id
              where product.id <> 0 and product.company_id=?
              ';
    if ($category >= 1) {
        $query .=' and category.id='.$category;
        $count .=' and category.id='.$category;
    }
    if ($search != "") {
        $query .= ' and (MATCH (product.name) AGAINST ("'.$search.'" IN BOOLEAN MODE))';
        $count .= ' and (MATCH (product.name) AGAINST ("'.$search.'" IN BOOLEAN MODE))';
    }
    if($_SESSION['role'] == 4){
      $query .= ' and product.store_id in (SELECT store_id from mandop_stores where mandop_stores.mandop_id='.$_SESSION['userid'].')';
      $count .= ' and product.store_id in (SELECT store_id from mandop_stores where mandop_stores.mandop_id='.$_SESSION['userid'].')';
    }else if($_SESSION['role'] == 10){
      $query .= ' and stores.client_id='.$_SESSION['userid'];
      $count .= ' and stores.client_id='.$_SESSION['userid'];
    }
    $page = ($page - 1);
    $query .= ' limit '. ($page * $limit) .' ,'. $limit;

    $data = getData($con,$query,[$_SESSION['company_id']]);
    $ps = getData($con,$count,[$_SESSION['company_id']]);
    $pages= ceil($ps[0]['count']/$limit);
    $i=0;

    foreach($data as $v){
      $id = $v['id'];
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

echo (json_encode(array($_SESSION,$query,"success"=>$success,"data"=>$data,'pages'=>$pages,'page'=>($page+1),'role'=>$_SESSION['role'])));
?>