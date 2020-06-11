<?php
session_start();
error_reporting(0);
header('Content-Type: application/json');
require_once("_access.php");
require_once("dbconnection.php");
require_once("_crpt.php");
require_once("../config.php");

use Violin\Violin;
require_once('../validator/autoload.php');
$v = new Violin;


$success = 0;
$id    = $_REQUEST['id'];
$discount = $_REQUEST['discount'];
$error = [ ];
$v->addRuleMessages([
    'required' => ' الحقل مطلوب',
    'int'      => ' فقط الارقام مسموح بها',
]);
$v->addRuleMessage('isPrice', 'المبلغ غير صحيح');
$v->addRule('isPrice', function($value, $input, $args) {
  if(preg_match("/^[+-]?(0|[1-9]\d*)(\.\d{2})?$/",$value)){
    $x=(bool) 1;
  }
  return   $x;
});
$v->validate([
    'id'=> [$id,    'required|int'],
    'discount'=> [$discount,'isPrice'],
    ]);

if($v->passes()) {
  $sql = 'update basket set status = 2 , discount=? where id=? and staff_id=?';
  $result = setData($con,$sql,[$discount,$id,$_SESSION['userid']]);
  if($result > 0){
    $success = 1;
  }
}else{
  $error = [
           'id'=> implode($v->errors()->get('id')),
           'discount'=> implode($v->errors()->get('discount')),
           ];
}
echo json_encode([$_REQUEST,'success'=>$success, 'error'=>$error]);
?>