<?php
session_start();
error_reporting(0);
header('Content-Type: application/json');
require_once("_access.php");
access([1,2,5]);
require_once("dbconnection.php");
require_once("../config.php");
require_once('../validator/autoload.php');
use Violin\Violin;
$v = new Violin;


$success = 0;
$mandop    = $_REQUEST['mandop_id'];
$store   = $_REQUEST['store'];

$v->addRuleMessages([
    'required' => ' الحقل مطلوب',
    'int'      => ' فقط الارقام مسموح بها',
    'regex'    => ' فقط الارقام مسموح بها',
    'min'      => ' قصير جداً',
    'max'      => ' ( {value} ) قيمة كبيرة جداً غير مسموح بها ',
    'email'    => ' البريد الالكتروني غيز صحيح',
]);

$v->validate([
    'mandop' => [$mandop,'required|int'],
    'store'   => [$store,  'required|int'],
]);
$msg = "";
if($v->passes() ) {
  $sql = "select * from mandop_stores where store_id=?";
  $res = getData($con,$sql,[$store]);
  if(count($res) < 1){
      $sql = 'insert into mandop_stores (mandop_id,store_id,manager_id) values (?,?,?)';
      $result = setData($con,$sql,[$mandop,$store,$_SESSION['userid']]);
      if($result > 0){
        $success = 1;
        $msg = "تم الاضافة";
      }else{
         $msg = "!خطأ";
      }
  }else{
    $msg = "تم تحديد مندوب للبيج مسبقاً";
  }

}else{
  $error = [
           'driver_err'=> implode($v->errors()->get('driver')),
           'town_err'=>implode($v->errors()->get('town')),
           ];
 $msg = "خطأ";
}
echo json_encode(['success'=>$success, 'error'=>$error,'msg'=>$msg]);
?>