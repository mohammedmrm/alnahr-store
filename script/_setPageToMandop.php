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
$earnings_fix   = $_REQUEST['earnings_fix'];
$earnings_total   = $_REQUEST['earnings_total'];

$v->addRuleMessage('isPrice', 'المبلغ غير صحيح');

$v->addRule('isPrice', function($value, $input, $args) {
  if(preg_match("/^(0|[1-9]\d*)(\.\d{2})?$/",$value)){
    $x=(bool) 1;
  }
  return   $x;
});
$v->addRuleMessages([
    'required' => ' الحقل مطلوب',
    'int'      => ' فقط الارقام مسموح بها',
    'regex'    => ' فقط الارقام مسموح بها',
    'min'      => ' قصير جداً',
    'max'      => ' ( {value} ) قيمة كبيرة جداً غير مسموح بها ',
    'email'    => ' البريد الالكتروني غيز صحيح',
]);

$v->validate([
    'mandop'  => [$mandop,'required|int'],
    'store'   => [$store,  'required|int'],
    'earnings_total' => [$earnings_total,'int|min(1)|max(2)'],
    'earnings_fix'   => [$earnings_fix,  'isPrice'],
]);
$msg = "";
if($v->passes() ) {
  $sql = "select * from mandop_stores where store_id=? and mandop_id=?";
  $res = getData($con,$sql,[$store,$mandop]);
  if(count($res) < 1){
      $sql = 'insert into mandop_stores (mandop_id,store_id,manager_id,earnings_fix,earnings_total) values (?,?,?,?,?)';
      $result = setData($con,$sql,[$mandop,$store,$_SESSION['userid'],$earnings_fix,$earnings_total]);
      if($result > 0){
        $success = 1;
        $msg = "تم الاضافة";
      }else{
        $msg = "!خطأ";
      }
  }else{
    $msg = "تم تسجيل السوق مسبقأ";
  }

}else{
  $error = [
           'mandop'=> implode($v->errors()->get('mandop')),
           'store'=>implode($v->errors()->get('store')),
           'earnings_total'=>implode($v->errors()->get('earnings_total')),
           'earnings_fix'=>implode($v->errors()->get('earnings_fix')),
           ];
 $msg = "خطأ";
}
echo json_encode(['success'=>$success, 'error'=>$error,'msg'=>$msg]);
?>