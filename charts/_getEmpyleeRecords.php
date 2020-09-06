<?php
session_start();
//error_reporting(0);
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

$inserted = "select staff.name as name , count(orders.mandop_id) as inserted,
              sum((if(earnings_fix is null,0,earnings_fix)) + ((if(earnings_total is null,0,earnings_total/100)) * orders.total_price)) as mandop_earnings
              from staff
              left join orders orders on orders.mandop_id = staff.id and orders.confirm =1
              left join stores on  stores.id = orders.store_id
              left join mandop_stores on  mandop_stores.store_id = stores.id
              where staff.company_id=? and (orders.date between '".$start."' and '".$end."')
              GROUP by staff.id order by count(orders.mandop_id) DESC limit 10";
}else{
$inserted = "select staff.name as name , count(orders.mandop_id) as inserted,
              sum((if(earnings_fix is null,0,earnings_fix)) + ((if(earnings_total is null,0,earnings_total/100)) * orders.total_price)) as mandop_earnings
              from staff
              left join orders orders on orders.mandop_id = staff.id and orders.confirm =1
              left join stores on  stores.id = orders.store_id
              left join mandop_stores on  mandop_stores.store_id = stores.id
              where staff.company_id=? and (orders.date between '".$start."' and '".$end."') and staff.id = '".$_SESSION['userid']."'
              GROUP by staff.id order by count(orders.mandop_id) DESC limit 10";
}
$result = getData($con,$inserted,[$_SESSION['company_id']]);
echo json_encode(['data'=>$result]);
?>