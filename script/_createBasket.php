<?php
session_start();
//error_reporting(0);
header('Content-Type: application/json');
require_once("_access.php");
access([1,2,5]);
require_once("dbconnection.php");
require_once("_crpt.php");
require_once("../config.php");

use Violin\Violin;
require_once('../validator/autoload.php');
$v = new Violin;


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
    'customer_name'   => [$customer_name,    'min(3)|max(100)'],
    'customer_phone'  => [$customer_phone,   'isPhoneNumber'],
    'city'            => [$city,'int'],
    'town'            => [$town,"int"],
    'address'         => [$address,'max(250)'],
    'note'            => [$note,  'max(250)'],
]);
$sql = "select count(*) from basket where staff_id=?";
$res =getData($con,$sql,[$_SESSION['userid']]);
if($res[0] > 6){
  $max = "تم انشاء الحد الاعلى من السلات";
}else{
  $max = (bool) 1;
}
if($v->passes() && $max) {
  $sql = 'insert into basket (customer_name,customer_phone,city_id,town_id,address,note,staff_id) values
                              (?,?,?,?,?,?,?)';
  $result = setData($con,$sql,[$customer_name,$customer_phone,$city,$town,$address,$note,$_SESSION['userid']]);
  if($result > 0){
    $success = 1;
  }
}else{
  $error = [
           'customer_name'=> implode($v->errors()->get('customer_name')),
           'customer_phone'=>implode($v->errors()->get('customer_phone')),
           'city'=>implode($v->errors()->get('city')),
           'town'=>implode($v->errors()->get('town')),
           'address'=>implode($v->errors()->get('address')),
           'note'=>implode($v->errors()->get('note')),
           ];
}
echo json_encode(['success'=>$success,'max'=>$max,'error'=>$error]);
?>