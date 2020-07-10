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
$id      = $_REQUEST['id'];
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
$sql = "SELECT max(store_id) as stores,COUNT(configurable_product.id) as items,
        SUM(configurable_product.price) as price,stores.name as store_name
        FROM `basket_items`
        left join `configurable_product` on configurable_product_id = configurable_product.id
        left join `product` on configurable_product.product_id = product.id
        left join stores on stores.id = product.store_id
        where basket_id = ? GROUP by product.store_id";
        $orders = getData($con,$sql,[$id]);
        if(count($orders) > 0){
          $success = 1;
        }
}else{
  $error = [
           'id'=> implode($v->errors()->get('id')),
           ];
  $success = 0;
}
echo json_encode(['success'=>$success,'data'=>$orders,'error'=>$error,'msg'=>$msg]);
?>