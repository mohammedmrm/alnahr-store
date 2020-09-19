<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
session_start();
error_reporting(0);
require_once("_apiAccess.php");
access();
require_once("../script/dbconnection.php");
$limit = trim($_REQUEST['limit']);
if(empty($limit) || $limit <=0){
  $limit=10;
}
$page = trim($_REQUEST['page']);
if(empty($page) || $page <=0){
  $page=1;
}

$search= trim($_REQUEST['search']);
if(!empty($search)){
$search  = str_replace(" "," * ",$search);
$search  .= " *";
}
$cat = trim($_REQUEST['category']);
$store = trim($_REQUEST['store']);
try{
  $count = "select count(*) as count from product ";
  $query = "select product.*,category.title as category_name,
            MATCH (product.name,product.simple_des) AGAINST ('".$search."' IN NATURAL LANGUAGE MODE) AS score ,
            stores.name as store_name,image.img as img
            from product
            left join stores on stores.id = product.store_id
            left join category on category.id = product.category_id
            left join (
                select max(path) as img,product_id from images group by product_id
            ) image on image.product_id = product.id
            ";
  $where = "where ";
  if($userrole == 4){
    $filter .= " and product.store_id in (SELECT store_id from mandop_stores where mandop_stores.mandop_id=".$userid.")";
  }
  $filter .= " and product.display=1 and product.company_id=?";

  if ($cat >= 1) {
        $filter .=' and product.category_id='.$cat;
   }
  if ($store >= 1) {
        $filter .=' and product.store_id='.$store;
  }
  if ($search != "") {
        $filter .= ' and (MATCH (product.name,product.simple_des) AGAINST ("'.$search.'" IN NATURAL LANGUAGE MODE))';
  }
  if($filter != ""){
    $filter = preg_replace('/^ and/', '', $filter);
    $filter = $where." ".$filter;
    $count .= " ".$filter;
    $query .= " ".$filter;
  }
  $lim = " limit ".(($page-1) * $limit).",".$limit;
  $query .= " ORDER BY  score,product.name DESC ". $lim;
  $data = getData($con,$query,[$head_company_id]);
  $ps = getData($con,$count,[$head_company_id]);
  $pages= ceil($ps[0]['count']/$limit);
  $j=0;
  foreach($data as $product){
    $id = $product['id'];
    $sql = "SELECT attribute.* FROM configurable_product
            left join product on product.id = configurable_product.product_id
            left join sub_option on sub_option.configurable_product_id = configurable_product.id
            left join attribute on sub_option.attribute_id = attribute.id
            where product.id =? group by attribute.id";
    $res = getData($con,$sql,[$id]);
    $i = 0;
    foreach($res as $attr){
      $sql = "select attribute_config.*, attribute.id as attribute_id,configurable_product.qty as qty from attribute
              LEFT JOIN attribute_config on attribute_config.attribute_id = attribute.id
              left join sub_option on sub_option.attribute_config_id = attribute_config.id
              left join configurable_product on configurable_product.id = sub_option.configurable_product_id
              where attribute.id = ? and configurable_product.product_id = ? GROUP by attribute_config.id";
      $config = getData($con,$sql,[$attr['id'],$id]);
      $res[$i]['config'] = $config;
      $i++;
    }

    $data[$j]['attribute'] = $res;
    $sql = "select * from images where product_id=?";
    $images = getData($con,$sql,[$id]);
    $data[$j]['images']= $images;
    $j++;
  }
  $success="1";
} catch(PDOException $ex) {
   $data=["error"=>$ex];
   $success="0";
}

echo (json_encode(array($search,'code'=>200,'message'=>$msg,"success"=>$success,"data"=>$data,'pages'=>$pages,'page'=>$page),JSON_PRETTY_PRINT));
?>