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
$flag =$_REQUEST['flag'];
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
    'id'      => [$userid,  'required|int'],
]);
if($v->passes()) {
  $sql = 'insert into list_items (product_id,list_id) values(?,?)';
  $data = setData($con,$sql,[$product,$flag]);
  if($data){
   $success = 1;
  }
}else{
  $error = [
           'user'=>implode($v->errors()->get('id')),
           ];
}
echo json_encode(["code"=>200,"message"=>$msg,'data'=>$data,'success'=>$success,'error'=>$error]);
?>