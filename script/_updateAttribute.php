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

$name  = $_REQUEST['e_name'];
$id  = $_REQUEST['e_attribute_id'];
$v->addRuleMessages([
    'required' => 'الحقل مطلوب',
    'int'      => 'فقط الارقام مسموع بها',
    'min'      => 'قصير جداً',
    'max'      => 'مسموح ب {value} رمز كحد اعلى ',
]);

$v->validate([
    'name' => [$name,'required|min(2)|max(60)'],
]);

if($v->passes()) {
  $sql = 'update attribute set name = ? where id=?';
  $result = setData($con,$sql,[$name,$id]);
  if($result > 0){
    $success = 1;
  }
}else{
  $error = [
           'name'=>  implode($v->errors()->get('name')),
           ];
}
echo json_encode(['success'=>$success, 'error'=>$error]);
?>