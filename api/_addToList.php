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
$error = [];
$product = $_REQUEST['id'];
$user = $_SESSION['userid'];
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
    'id'      => [$user,  'required|int'],
]);
if($v->passes()) {
  $sql = 'insert into list (product_id,mandop_id) values (?,?)';
  $result = setData($con,$sql,[$product,$user]);
  $success = 1;
}else{
  $error = [
           'product'=> implode($v->errors()->get('product')),
           'user'=>implode($v->errors()->get('id')),
           ];
}
echo json_encode(["code"=>200,"message"=>$msg,'success'=>$success,'error'=>$error]);
?>