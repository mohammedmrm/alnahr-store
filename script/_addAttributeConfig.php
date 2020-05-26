<?php
session_start();
error_reporting(0);
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
$name    = $_REQUEST['config'];
$id    = $_REQUEST['attribute_id'];

$v->addRuleMessages([
    'required' => 'الحقل مطلوب',
    'int'      => 'فقط الارقام مسموع بها',
    'min'      => 'قصير جداً',
    'max'      => 'مسموح ب {value} رمز كحد اعلى '
]);

$v->validate([
    'name'   => [$name, 'required|max(60)|min(1)'],
    'id'   => [$id, 'required|int'],
]);

if($v->passes()) {
  $sql = 'insert into attribute_config (attribute_id,value) values
                             (?,?)';
  $result = setData($con,$sql,[$id,$name]);
  if($result > 0){
    $success = 1;
  }
}else{
  $error = [
           'name'=> implode($v->errors()->get('name')),
           'id'=> implode($v->errors()->get('id')),
           ];
}
echo json_encode(['success'=>$success, 'error'=>$error,$_POST]);
?>