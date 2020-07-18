<?php
session_start();
header('Content-Type: application/json');
error_reporting(0);
require_once("_access.php");
access([1,2,5]);
require_once("dbconnection.php");
require_once("../config.php");
$id = $_REQUEST['mandop'];
$data = [];
$end = $_REQUEST['end'];
$start = $_REQUEST['start'];
$statues = $_REQUEST['status'];
$success =0;
if(!empty($end)) {
   $end .=' 23:59:59';
}
if(!empty($start)) {
  $start .=" 00:00:00";
}
use Violin\Violin;
require_once('../validator/autoload.php');
$v = new Violin;
$v->validate([
    'id' => [$id,'required|int'],
]);
function validateDate($date, $format = 'Y-m-d H:i:s'){
    $d = DateTime::createFromFormat($format, $date);
    return $d && $d->format($format) == $date;
}
if($v->passes()) {
  $sql = "select orders.*,date_format(orders.date,'%Y-%m-%d') as dat,  order_status.status as status_name,
          cites.name as city_name,
          towns.name as town_name,
            total_price -
              (
                if(orders.city_id = 1,
                  ".$config['dev_b'].",
                  ".$config['dev_o']."
                 )
               ) - discount as price,
             if(orders.order_status_id=4 or order_status_id = 6,((if(earnings_fix is null,0,earnings_fix)) + ((if(earnings_total is null,0,earnings_total/100)) * orders.total_price)),0) as mandop_price
          from orders
          left join order_status on orders.order_status_id = order_status.id
          left join cites on orders.city_id = cites.id
          left join towns on orders.town_id = towns.id
          left join mandop_stores on  mandop_stores.store_id = orders.store_id
          where orders.mandop_id = '".$id."' and mandop_invoice_id = 0  and orders.confirm =1
          ";
  $filter = "";
    if(validateDate($start) && validateDate($end)){
      $sql .= " and orders.date between '".$start."' AND '".$end."' ";
    }
  if(count($statues) > 0){
    foreach($statues as $status){
      if($status > 0){
        $filter .= " or order_status_id=".$status;
      }
    }
  }
  $filter = preg_replace('/^ or/', '', $filter);
  if($filter != ""){
    $filter = " and (".$filter." )";
    $sql .= $filter;
  }
  $res3= getData($con,$sql,[]);
  if(count($res3) > 0){
    $success = 1;
  }
  $sql = "select
          sum(total_price) as income,
          sum(if(orders.order_status_id=4 or order_status_id = 6,((if(earnings_fix is null,0,earnings_fix)) + ((if(earnings_total is null,0,earnings_total/100)) * orders.total_price)),0)) as mandop_price,
          sum(total_price +
              (
                 if(order_status_id = 9,
                     0,
                     if(city_id = 1,
                           ".$config['dev_b'].",
                           ".$config['dev_o']."
                      )
                  )
              ) - orders.discount
          ) as price,
          sum(discount) as discount,
          count(*) as orders
          from orders
          left join mandop_stores on  mandop_stores.store_id = orders.store_id
          where orders.mandop_id = ?  and mandop_invoice_id = 0 and orders.confirm =1
          ";
        if(validateDate($start) && validateDate($end)){
          $sql .= " and date between '".$start."' AND '".$end."' ";
         }
        if($filter != ""){
          $sql .= $filter;
        }
          $res4= getData($con,$sql,[$id]);
          $res4= $res4[0];
$sql2 = "select mandop_invoice.*,date_format(mandop_invoice.date,'%Y-%m-%d') as in_date,
           staff.name as mandop_name, staff.phone as mandop_phone
           from mandop_invoice
           left join  staff on staff.id = mandop_invoice.mandop_id
           where mandop_invoice.mandop_id='".$id."'";
        if(validateDate($start) && validateDate($end)){
          $sql2 .= " order by mandop_invoice.date DESC limit 25";
         }
         $res2 = getData($con,$sql2);
if(count($res2) > 0){
    $success = 1;
}
}else{
 $success = 0;
 $error = [
           'id'=>  implode($v->errors()->get('id')),
];
}
echo json_encode(array($sql,"success"=>$success,"data"=>$res3,"invoice"=>$res2,'pay'=>$res4));
?>