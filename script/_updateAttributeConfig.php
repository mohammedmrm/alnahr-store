<?php
session_start();
//error_reporting(0);
header('Content-Type: application/json');
require_once("_access.php");
access([1,2]);
require_once("dbconnection.php");

use Violin\Violin;
require_once('../validator/autoload.php');
$v = new Violin;


$success = 0;
$error = [];

$name  = $_REQUEST['e_config'];
$id  = $_REQUEST['editAttributeConfigid'];
$v->addRuleMessages([
    'required' => 'الحقل مطلوب',
    'int'      => 'فقط الارقام مسموع بها',
    'min'      => 'قصير جداً',
    'max'      => 'مسموح ب {value} رمز كحد اعلى ',
]);

$v->validate([
    'name' => [$name,'required|min(2)|max(60)'],
    'id' => [$id,'required|int'],
]);

if($v->passes()) {
  $sql = 'update attribute_config set value = ? where id=?';
  $result = setData($con,$sql,[$name,$id]);
  if($result > 0){
    $success = 1;
  }
}else{
  $error = [
           'name'=>  implode($v->errors()->get('name')),
           ];
}
echo json_encode([$_REQUEST,'success'=>$success, 'error'=>$error]);
?>