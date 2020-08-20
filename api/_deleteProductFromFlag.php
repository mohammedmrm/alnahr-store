<?php
session_start();
error_reporting(0);
header('Content-Type: application/json');
require_once("_apiAccess.php");
access();
require_once("../script/dbconnection.php");
require_once("../config.php");

use Violin\Violin;
require_once('../validator/autoload.php');
$v = new Violin;
$success = 0;
$product = $_REQUEST['product'];
$id =$_REQUEST['id'];
$error = [];
$v->addRuleMessages([
    'required' => ' الحقل مطلوب',
    'int'      => ' فقط الارقام مسموح بها',
    'regex'    => ' فقط الارقام مسموح بها',
    'min'      => ' قصير جداً',
    'max'      => '  قيمة كبيرة جداً غير مسموح بها ',
    'email'    => ' البريد الالكتروني غيز صحيح',
]);

$v->validate([
    'product'      => [$product,  'required|int'],
    'id'      => [$id,  'required|int'],
]);
if($v->passes()) {
  $sql = 'delete from list_items where id=? and product_id=?';
  $data = setData($con,$sql,[$id,$product]);
  if($data){
   $success = 1;
  }
}else{
  $error = [
           'product'=>implode($v->errors()->get('product')),
           'id'=>implode($v->errors()->get('id')),
           ];
}
echo json_encode(["code"=>200,"message"=>$msg,'data'=>$data,'success'=>$success,'error'=>$error]);
?>