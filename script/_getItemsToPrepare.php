<?php
session_start();
header('Content-Type: application/json');
error_reporting(0);
require_once("_access.php");
access([1,5,3]);
$success="0";
$sub_name = $_REQUEST['name'];
$client = $_REQUEST['client'];
$store = $_REQUEST['store'];
$status = $_REQUEST['status'];
$limit = $_REQUEST['limit'];
if(empty($limit)){
  $limit =10;
}
if(empty($status)){
  $status =0;
}
$start = $_REQUEST['start'];
$end = $_REQUEST['end'];
if(!empty($end)) {
  $end =  new DateTime($end);
  $end->modify('+1 day');
  $end = $end->format('Y-m-d');
}else{
  $end =  new DateTime(date('Y-m-d'));
  $end->modify('+2 day');
  $end = $end->format('Y-m-d');
}
$page = trim($_REQUEST['p']);
if(empty($page) || $page <=0){
  $page =1;
}
require_once("dbconnection.php");
try{
   $count ="select count(*) as count from basket_items
            left join basket on basket.id = basket_items.basket_id
            left join configurable_product on configurable_product.id = basket_items.configurable_product_id
            left join (
                     select  max(path) as path,product_id from images
                     group by images.product_id
            ) a on a.product_id = configurable_product.product_id
            where basket.status=2 and ";

   $query ="select *,
             basket_items.qty as r_qty,basket_items.id as bi_id,configurable_product.id as c_id,
             configurable_product.qty as a_qty,basket_items.status as item_status
            from basket_items
            left join basket on basket.id = basket_items.basket_id
            left join configurable_product on configurable_product.id = basket_items.configurable_product_id
            left join (
                     select  max(path) as path,product_id from images
                     group by images.product_id
            ) a on a.product_id = configurable_product.product_id
            where  basket.status=2 and";
            $where = "";
            if($status >= 0){
             $filter .= " and basket_items.status = ".$status;
            }
            if($clinet >= 1){
             $filter .= " and clinet_id =".$clinet;
            }
            if($store >= 1){
             $filter .= " and store_id =".$store;
            }
            if(!empty($sub_name)){
             $filter .= " and configurable_product.sub_name like '%".$sub_name."%' ";
            }
            function validateDate($date, $format = 'Y-m-d'){
                  $d = DateTime::createFromFormat($format, $date);
                  return $d && $d->format($format) == $date;
            }
            if(validateDate($start) && validateDate($end)){
              $filter .= " and  basket_items.date between '".$start."' AND '".$end."'";
            }
            $sort = " order by basket_items.date DESC ";
            if($filter != ""){
              $filter = preg_replace('/^ and/', '', $filter);
              $filter = $where." ".$filter;
              $count .= " ".$filter;
              $query .= " ".$filter;
            }
            $count = getData($con,$count);
            $orders = $count[0]['count'];
            $pages= ceil($count[0]['count'] / $limit);
            $lim = " limit ".(($page-1) * $limit).",".$limit;
            $data = getData($con,$query.$lim);
            $success="1";
} catch(PDOException $ex) {
   $data=["error"=>$ex,'q'=>$count];
   $success="0";
}
echo (json_encode(array($query,"success"=>$success,"data"=>$data,"pages"=>$pages,"page"=>$page)));
?>