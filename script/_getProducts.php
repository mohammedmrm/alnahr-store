<?php
session_start();
error_reporting(0);
header('Content-Type: application/json');
require_once("_access.php");

require_once("dbconnection.php");
$limit = trim($_REQUEST['limit']);
if(empty($limit) || $limit <=0){
  $limit=10;
}
$page = trim($_REQUEST['p']);
if(empty($page) || $page <=0){
  $page=1;
}
$name = trim($_REQUEST['name']);
try{
  $count = "select count(*) as count from configurable_product left join product on configurable_product.product_id = product.id  ";
  $query = "select *,a.path as path,configurable_product.id as c_id from configurable_product
            left join product on configurable_product.product_id = product.id
            left join (
             select  max(path) as path,product_id from images
             group by images.product_id
            ) a on a.product_id = product.id
            ";
   $where = "where ";
  if(!empty($name)){
   $filter .= " and name like '%".$name."%' ";
  }
  if($filter != ""){
    $filter = preg_replace('/^ and/', '', $filter);
    $filter = $where." ".$filter;
    $count .= " ".$filter;
    $query .= " ".$filter;
  }
  $lim = " limit ".(($page-1) * $limit).",".$limit;
  $query .=  $lim;
  $data = getData($con,$query);
  $ps = getData($con,$count);
  $pages= ceil($ps[0]['count']/$limit);
  $i=0;
  foreach($data as $v){
    $sql = 'select * from sub_option
            left join attribute_config on attribute_config.id = sub_option.attribute_config_id
            left join attribute on attribute.id = attribute_config.attribute_id
            where configurable_product_id=?';
    $res = getData($con,$sql,[$v['c_id']]);
    $data[$i]['attribute']=$res;
    $i++;
  }
  $success="1";
} catch(PDOException $ex) {
   $data=["error"=>$ex];
   $success="0";
}

echo (json_encode(array($query,"success"=>$success,"data"=>$data,'pages'=>$pages,'page'=>$page)));
?>