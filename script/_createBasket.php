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

if($_SESSION['role']==10){
  $userType =1;
}else{
  $userType =0;
}
$success = 0;
$customer_name    = $_REQUEST['customer_name'];
$customer_phone   = $_REQUEST['customer_phone'];
$city= $_REQUEST['city'];
if(empty($city)){
  $city = 0;
}
$town   = $_REQUEST['town'];
if(empty($town)){
  $town = 0;
}
$address = $_REQUEST['address'];
$note = $_REQUEST['note'];
$type = $_REQUEST['replace'];
if(empty($type)){
  $type = 1;
}
$oldOrder = $_REQUEST['oldOrder'];
if($type == 2){
  if(empty($oldOrder)){
      $oldOrder_err = "يجب تحديد الطلب السابق";
  }else if($oldOrder > 0){
      $sql = "select * from orders where id=?";
      $res = getData($con,$sql,[$oldOrder]);
      if(count($res) == 1){
        $oldOrder_err = "";
      }else{
        $oldOrder_err = "الطلب المحدد غير صحيح";
      }
  }else{
     $oldOrder_err = "الطلب المحدد غير صحيح";
  }

}else if($type == 1){
  $oldOrder_err = "";
  $oldOrder = 0;
}
$error = [];

$v->addRuleMessage('isPhoneNumber', ' رقم هاتف غير صحيح ');

$v->addRule('isPhoneNumber', function($value, $input, $args) {
  if(preg_match("/^[0-9]{10,15}$/",$value) || empty($value)){
    return   (bool) 1;
  }else{
    return   (bool) 0;
  }

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
    'customer_name'   => [$customer_name,    'required|min(3)|max(100)'],
    'customer_phone'  => [$customer_phone,   'required|isPhoneNumber'],
    'city'            => [$city,'required|int'],
    'town'            => [$town,"required|int"],
    'address'         => [$address,'max(250)'],
    'note'            => [$note,  'max(250)'],
]);
$sql = "select count(*) as count from basket where staff_id=?";
$res =getData($con,$sql,[$_SESSION['userid']]);
if($res[0]['count'] > 150){
  $max = "تم انشاء الحد الاعلى من السلات";
}else{
  $max = "";
}
if($v->passes() && $max == "" && $oldOrder_err == "") {
  try{
      $sql = 'insert into basket (customer_name,customer_phone,city_id,town_id,address,note,staff_id,type,oldOrder_id,company_id,user_type) values
                                  (?,?,?,?,?,?,?,?,?,?,?)';
      $result = setData($con,$sql,[$customer_name,$customer_phone,$city,$town,$address,$note,$_SESSION['userid'],$type,$oldOrder,$_SESSION['company_id'],$userType]);
      if($result > 0){
        $success = 1;
      }
  } catch(PDOException $ex) {
    $data=["error"=>$ex];
    $success="0";
  }
}else{
  $error = [
           'customer_name'=> implode($v->errors()->get('customer_name')),
           'customer_phone'=>implode($v->errors()->get('customer_phone')),
           'city'=>implode($v->errors()->get('city')),
           'town'=>implode($v->errors()->get('town')),
           'address'=>implode($v->errors()->get('address')),
           'note'=>implode($v->errors()->get('note')),
           'type'=>implode($v->errors()->get('type')),
           'oldOrder'=>$oldOrder_err,
           ];
}
echo json_encode([$ex,'success'=>$success,'max'=>$max,'error'=>$error]);
?>