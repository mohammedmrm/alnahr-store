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
$id =$_REQUEST['id'];
$basket =$_REQUEST['basket'];
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
    'basket'  => [$basket,  'required|int'],
    'id'      => [$id,  'required|int'],
]);
if($v->passes()) {
  $sql = 'delete from basket_items where id=? and basket_id=?';
  $data = setData($con,$sql,[$id,$basket]);
  if($data){
   $success = 1;
  }
}else{
  $error = [
           'basket'=>implode($v->errors()->get('basket')),
           'id'=>implode($v->errors()->get('id')),
           ];
}
echo json_encode(["code"=>200,"message"=>$msg,'data'=>$data,'success'=>$success,'error'=>$error]);
?>