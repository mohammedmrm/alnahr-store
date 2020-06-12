<?php
session_start();
error_reporting(0);
header('Content-Type: application/json');
require_once("_access.php");
access([1,3,5]);
require_once("dbconnection.php");
require_once("_crpt.php");
require_once("../config.php");

use Violin\Violin;
require_once('../validator/autoload.php');
$v = new Violin;


$success = 0;
$id       = $_REQUEST['id'];
$company = $_REQUEST['company'];
if(empty($company) || !($company>=0)){
  $company = 0;
}
$error = [];
$v->addRuleMessages([
    'required' => ' الحقل مطلوب',
    'int'      => ' فقط الارقام مسموح بها',
    'regex'    => ' فقط الارقام مسموح بها',
    'min'      => ' قصير جداً',
    'max'      => ' ( {value} ) قيمة كبيرة جداً غير مسموح بها ',
    'email'    => ' البريد الالكتروني غيز صحيح',
]);

$v->validate([
    'id'=> [$id,    'required|int'],
    ]);
$msg = "";

if($v->passes()) {
  $sql = 'SELECT * from basket where id=?';
  $res = getData($con,$sql,[$id]);
  if(count($res) == 1){
    //--- check if all items are prepared by the storage_manager;

       $sql = "SELECT max(store_id) as stores FROM `basket_items`
                          left join `configurable_product` on configurable_product_id = configurable_product.id
                          left join `product` on configurable_product.product_id = product.id
                          where basket_id = ? GROUP by product.store_id";
        $stores = getData($con,$sql,[$id]);
        $required_receipts=count($stores);


        $sql = "SELECT sum((to_receipt-from_receipt)+1) as receipts FROM `receipts` where company_id = 0";
        $receipts = getData($con,$sql,[$id]);
        $receipts=$receipts[0];

    if($receipts >= $required_receipts){
      $sql = "select * from basket_items where basket_id=?";
      $res2 = getData($con,$sql,[$id]);
      if(count($res2) >= 1){
          foreach($res2 as $val){
            $sql = "select * from configurable_product where id=?";
            $res6 = getData($con,$sql,[$val['configurable_product_id']]);
            $a_qty = $res6[0]['qty'];
            if($a_qty <  $val['qty']){
              $msg = "يوجد منتج واحد  على الاقل  بكمية غير كافية";
              break;
            }else if($val['status'] == 0){
              $msg = "يوجد منتجات بالسلة لم  يتم تجهيزها";
              break;
            }else{
               $msg = "";
            }
          }
      }
      if($msg == ""){
              foreach($stores as $store){
              //--- prepare the order
              $sql ="SELECT * FROM `basket_items`
                                  left join `configurable_product` on configurable_product_id = configurable_product.id
                                  left join `product` on configurable_product.product_id = product.id
                                  where basket_id = ? and store_id=?";
              $items = getData($con,$sql,[$id]);
              $total = 0;
              foreach($items as $item){
                 $total += $item['price'];
              }
              $sql="select * from receipts where company_id=? and (to_receipt - from_receipt ) >= ? limit 1";
              $order_no = getData($con,$sql,[$company,$required_receipts]);
              $order_no = $order_no[0]['from_receipt'];

              $sql = "insert into orders (order_no,total_price,customer_name,customer_phone,city_id,town_id,address,note,staff_id,manager_id) values(?,?,?,?,?,?,?,?,?,?)";
              $order_id = setDataWithLastID($con,$sql,[$order_no,$total,$res[0]['customer_name'],$res[0]['customer_phone'],$res[0]['city_id'],$res[0]['town_id'],$res[0]['address'],$res[0]['note'],$res[0]['staff_id'],$_SESSION['userid']]);
              foreach($items as $item){
                $sql = "insert into order_items (order_id,configurable_product_id,qty,staff_id,storage_manager_id,price)
                       values (?,?,?,?,?,?)";
                $res4 = setData($con,$sql,[$order_id,
                                          $item['configurable_product_id'],
                                          $item['qty'],
                                          $item['storage_manager_id'],
                                          $item['price'],
                                          $item['staff_id'],
                                          ]);
                if($res4 > 0){
                  $sql = "update configurable_product set qty = qty - ? where id=?";
                  $res4 = setData($con,$sql,[$item['qty'],$item['configurable_product_id']]);
                  $sql = "delete from basket_items where basket_id=?";
                  $res5 = setData($con,$sql,[$id]);
                }
              }

              $sql = "update receipts set from_receipt = from_receipt +1 where id=?";
              $order_no = getData($con,$sql,[$company,$required_receipts]);
              }
              $sql = "delete from basket where id=?";
              $res6 = setData($con,$sql,[$id]);
      }else{
          $success = 0;
      }
    }else{
      $msg = "الوصولات المتبقية غير كافية";
    }
  }else {
    $msg = "السلة غير موجودة";
  }
}else{
  $error = [
           'id'=> implode($v->errors()->get('id')),
           ];
  $success = 0;
}
echo json_encode(['success'=>$success,'error'=>$error,'msg'=>$msg]);
?>