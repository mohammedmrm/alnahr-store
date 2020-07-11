<?php
session_start();
error_reporting(0);
header('Content-Type: application/json');
require_once("_access.php");
require_once("dbconnection.php");
require_once("_crpt.php");
require_once("../config.php");

use Violin\Violin;
require_once('../validator/autoload.php');
$v = new Violin;


$success = 0;
$error = [];
$product = $_REQUEST['product_id'];
$basket  = $_REQUEST['basket'];
$qty = $_REQUEST['qty'];
if(empty($qty)){
  $qty = 1;
}

$v->addRuleMessages([
    'required' => ' الحقل مطلوب',
    'int'      => ' فقط الارقام مسموح بها',
    'regex'    => ' فقط الارقام مسموح بها',
    'min'      => ' قصير جداً',
    'max'      => ' ( {value} ) قيمة كبيرة جداً غير مسموح بها ',
    'email'    => ' البريد الالكتروني غيز صحيح',
]);

$v->validate([
    'product' => [$product,  'required|int'],
    'basket'  => [$basket,   'required|int'],
    'qty'     => [$qty,'required|int'],
]);
$sql = "select * from basket where id=?";
$basket2 = getData($con,$sql,[$basket2]);
$type = $basket2[0]['type'];
$oldOrder = $basket2[0]['oldOrder_id'];
if($type == 2){
 $sql = "select stores.name as store_name,stores.id as store_id from orders
         inner join stores on stores.id = orders.store_id
         where orders.id = ? limit 1
         ";
 $oldStore = getData($con,$sql,[$oldOrder]);
 $oldStore = $oldStore[0]['store_id'];

 $sql = "select stores.name as store_name,stores.id as store_id from configurable_product
        inner join product on product.id = configurable_product.product_id
        inner join stores on stores.id = product.store_id
        where configurable_product.id = ?";
 $newStore = getData($con,$sql,[$product]);
 $newStore = $newStore[0]['store_id'];
 if($oldStore != $newStore){
   $msg = "يجب اضافه منتجات تابعه لنفس منتج الاستبدال";
 }else{
   $msg="";
 }
}else{
   $msg = "";
}
if($v->passes() && $msg == "") {
  $sql = 'insert into basket_items (configurable_product_id,basket_id,qty,staff_id) values (?,?,?,?)';
  $result = setData($con,$sql,[$product,$basket,$qty,$_SESSION['userid']]);
  if($result > 0){
    $success = 1;
    $sql = "update basket set status=1 where staff_id=? and id=?";
    setData($con,$sql,[$_SESSION['userid'],$basket]);
  }
}else{
  $error = [
           'product'=> implode($v->errors()->get('product')),
           'basket'=>implode($v->errors()->get('basket')),
           'qty'=>implode($v->errors()->get('qty')),
           'msg'=>$msg
           ];
}
echo json_encode([$_REQUEST,'success'=>$success,'error'=>$error]);
?>