<?php
session_start();
error_reporting(0);
header('Content-Type: application/json');
require_once("_apiAccess.php");
access();
require_once("../script/dbconnection.php");
require_once("../script/_crpt.php");
require_once("../config.php");

use Violin\Violin;
require_once('../validator/autoload.php');
$v = new Violin;


$success = 0;
$id    = $_REQUEST['id'];
$discount    = $_REQUEST['discount'];
if(empty($discount)){
  $discount=0;
}
$error = [];
$v->addRuleMessage('isPrice', 'المبلغ غير صحيح');

$v->addRuleMessage('isPrice', 'المبلغ غير صحيح');

$v->addRule('isPrice', function($value, $input, $args) {
  $x=(bool) 0;
  if(preg_match("/^(0|\-\d*|\d*)(\.\d{2})?$/",$value)){
    if($value > 0){
       if(preg_match("/(000|500|250|750)$/",$value)){
         $x=(bool) 1;
       }
    }else{
        $x=(bool) 1;
    }
  }
  return   $x;
});
$v->addRuleMessages([
    'required' => ' الحقل مطلوب',
    'int'      => ' فقط الارقام مسموح بها',
]);

$v->validate([
    'id'=> [$id,    'required|int'],
    'discount'=> [$discount,'isPrice'],
    ]);

if($v->passes()) {
  $sql = 'update basket set status = 2, discount=? where id=? and staff_id=?';
  $result = setData($con,$sql,[$discount,$id,$userid]);
  if($result > 0){
    $success = 1;
  }
}else{
  $error = [
           'id'=> implode($v->errors()->get('id')),
           'discount'=> implode($v->errors()->get('discount')),
           ];
}
echo json_encode(['code'=>200,'message'=>$msg,'success'=>$success,'error'=>$error]);
?>