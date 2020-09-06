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
$sql = "SELECT
          SUM(IF (order_status_id = '1',1,0)) as  regiserd,
          SUM(IF (order_status_id = '2',1,0)) as  redy,
          SUM(IF (order_status_id = '3',1,0)) as  ontheway,
          SUM(IF (order_status_id = '4',1,0)) as  recieved,
          SUM(IF (order_status_id = '5',1,0)) as  chan,
          SUM(IF (order_status_id = '9',1,0)) as  returnd,
          SUM(IF (order_status_id = '7',1,0)) as  posponded,
          branches.name as branch_name
          FROM orders inner join branches on branches.id = orders.from_branch
          where orders.company_id=? and date between '".$start."' and '".$end."'
          GROUP BY from_branch";

$result = getData($con,$sql,[$_SESSION['company_id']]);
echo json_encode(['data'=>$result]);
?>