<?php
session_start();
error_reporting(0);
header('Content-Type: application/json');
require_once("_apiAccess.php");
//access();
require_once("../script/dbconnection.php");
$limit = trim($_REQUEST['limit']);
if(empty($limit) || $limit <=0){
  $limit=10;
}
$page = trim($_REQUEST['p']);
if(empty($page) || $page <=0){
  $page=1;
}
$name= trim($_REQUEST['name']);
$cat = trim($_REQUEST['category']);
try{
  $count = "select count(*) as count from product ";
  $query = "select product.*,category.title as category_name,
             stores.name as store_name,image.img as img
             from product
            left join stores on stores.id = product.store_id
            left join category on category.id = product.category_id
            left join (
                select max(path) as img,product_id from images group by product_id
            ) image on image.product_id = product.id
            ";
  $where = "where ";
  if(!empty($name)){
   $filter .= " and product.name like '%".$name."%' ";
  }
  $f1 = "";
  if($_SESSION['role'] == 4){
   $sql = "select * from mandop_stores where mandop_id=?";
   $res=getData($con,$sql,[$_SESSION['userid']]);
   if(count($res)>0){
     $f1 = " and ( ";
     foreach($res as $val){
         $f2 ="store_id =".$val['store_id']." or";
     }
     $last = strrpos($f2, 'or');
     $f2 = substr($f2, 0, $last);
     $f1 .= $f2." ) ";
   }else{
     $f1 = " and store_id = -1";
   }
  }
  $filter .= $f1;

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
  $success="1";
} catch(PDOException $ex) {
   $data=["error"=>$ex];
   $success="0";
}

echo (json_encode(array('code'=>200,'message'=>$msg,"success"=>$success,"data"=>$data,'pages'=>$pages,'page'=>$page)));
?>