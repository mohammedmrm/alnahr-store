<?php
session_start();
error_reporting(0);
header('Content-Type: application/json');
require("../script/_access.php");
access([1,2,5,3]);
require("../script/dbconnection.php");
$start = trim($_REQUEST['start']);
$end = trim($_REQUEST['end']);
if(empty($end)) {
  $end = date('Y-m-d h:i:s', strtotime($end. ' + 1 day'));
}else{
   $end =date('Y-m-d', strtotime($end. ' + 1 day'));
   $end .=" 00:00:00";
}
if(empty($start)) {
  $start = date('Y-m-d h:i:s',strtotime($start. ' - 7 day'));
}else{
   $start .=" 00:00:00";
}
if($_SESSION['user_details']['role_id'] == 1){
  $sql = 'select  orders.* , cites.name as city_name,towns.name as town_name from orders
           left join cites on cites.id = orders.city_id
           left join towns on towns.id = orders.town_id
           where orders.company_id=? and  date between "'.$start.'" and "'.$end.'" limit 25';
}else{
   $sql = 'select orders.* , cites.name as city_name,towns.name as town_name from orders
           left join cites on cites.id = orders.city_id
           left join towns on towns.id = orders.town_id
           where  orders.company_id=? and mandop_id="'.$_SESSION['userid'].'" and date between "'.$start.'" and "'.$end.'" limit 25';
}

$data =  getData($con,$sql,[$_SESSION['company_id']]);
echo json_encode(['data'=>$data]);
?>
