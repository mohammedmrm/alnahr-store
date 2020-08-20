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
$bgColor  =$_REQUEST['bgColor'];
$fontColor=$_REQUEST['fontColor'];
$name=$_REQUEST['name'];
$success = 0;
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
  $sql = 'insert into list (name,bg_color,font_color,mandop_id) values(?,?,?,?)';
  $data = getData($con,$sql,[$name,$bgColor,$fontColor,$userid]);
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