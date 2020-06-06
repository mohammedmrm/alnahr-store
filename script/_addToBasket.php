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

if($v->passes()) {
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
           ];
}
echo json_encode([$_REQUEST,'success'=>$success,'error'=>$error]);
?>