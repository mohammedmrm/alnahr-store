<?php
session_start();
//error_reporting(0);
header('Content-Type: application/json');
require_once("_access.php");
access([1,2,5,10,4]);
require_once("dbconnection.php");
require_once("_crpt.php");
require_once("../config.php");

use Violin\Violin;
require_once('../validator/autoload.php');
$v = new Violin;


$success = 0;
$id    = $_REQUEST['id'];
$error = [];
$v->addRuleMessages([
    'required' => ' الحقل مطلوب',
    'int'      => ' فقط الارقام مسموح بها',
]);

$v->validate([
    'id'=> [$id,    'required|int'],
    ]);

if($v->passes()) {
  $sql = 'update basket set status = 1 where id=? and staff_id=?';
  $result = setData($con,$sql,[$id,$_SESSION['userid']]);
  if($result > 0){
    $success = 1;
  }
}else{
  $error = [
           'id'=> implode($v->errors()->get('id')),
           ];
}
echo json_encode(['success'=>$success, 'error'=>$error]);
?>