<?php
session_start();
//error_reporting(0);
header('Content-Type: application/json');
require("_access.php");
access([1,2,3]);
require("dbconnection.php");
require("_crpt.php");

use Violin\Violin;
require_once('../validator/autoload.php');
$v = new Violin;


$success = 0;
$error = [];
$id    = $_REQUEST['editCategoryid'];
$name  = $_REQUEST['e_name'];
$error = [];
$v->addRuleMessages([
    'required' => 'الحقل مطلوب',
    'int'      => 'فقط الارقام مسموع بها',
    'regex'      => 'فقط الارقام مسموع بها',
    'min'      => 'قصير جداً',
    'max'      => 'مسموح ب {value} رمز كحد اعلى ',
    'email'      => 'البريد الالكتروني غيز صحيح',
]);

$v->validate([
    'name' => [$name,'required|int'],
    'name' => [$name,'required|min(2)|max(20)'],
]);

if($v->passes()) {
  $sql = 'update category set title = ? where id=?';
  $result = setData($con,$sql,[$name,$id]);
  if($result > 0){
    $success = 1;
  }
}else{
  $error = [
           'id'=>  implode($v->errors()->get('id')),
           'name'=>implode($v->errors()->get('name')),
           ];
}
echo json_encode(['success'=>$success, 'error'=>$error,[$name,$id]]);
?>