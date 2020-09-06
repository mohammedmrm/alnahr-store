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
$name    = $_REQUEST['name'];

$v->addRuleMessages([
    'required' => 'الحقل مطلوب',
    'int'      => 'فقط الارقام مسموع بها',
    'min'      => 'قصير جداً',
    'max'      => 'مسموح ب {value} رمز كحد اعلى '
]);

$v->validate([
    'name'   => [$name, 'required|max(60)|min(2)'],
]);

if($v->passes()) {
  $sql = 'insert into attribute (name,company_id) values
                             (?,?)';
  $result = setData($con,$sql,[$name,$_SESSION['company_id']]);
  if($result > 0){
    $success = 1;
  }
}else{
  $error = [
           'name'=> implode($v->errors()->get('name')),
           ];
}
echo json_encode(['success'=>$success, 'error'=>$error,$_POST]);
?>