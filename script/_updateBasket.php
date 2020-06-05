<?php
session_start();
error_reporting(0);
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
$id    = $_REQUEST['e_basket_id'];
$customer_name    = $_REQUEST['e_customer_name'];
$customer_phone   = $_REQUEST['e_customer_phone'];
$city= $_REQUEST['e_city'];
if(empty($city)){
  $city = 0;
}
$town   = $_REQUEST['e_town'];
if(empty($town)){
  $town = 0;
}
$address = $_REQUEST['e_address'];
$note = $_REQUEST['e_note'];
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
    'id'              => [$id,    'required|int'],
    'customer_name'   => [$customer_name,    'min(3)|max(100)'],
    'customer_phone'  => [$customer_phone,   'required|isPhoneNumber'],
    'city'            => [$city,'required|int'],
    'town'            => [$town,"required|int"],
    'address'         => [$address,'max(250)'],
    'note'            => [$note,  'max(250)'],
]);

if($v->passes()) {
  $password = hashPass($password);
  $sql = 'update basket set customer_name=?,customer_phone=?,city_id=?,town_id=?,address=?,note=? where id=? and staff_id=?';
  $result = setData($con,$sql,[$customer_name,$customer_phone,$city,$town,$address,$note,$id,$_SESSION['userid']]);
  if($result > 0){
    $success = 1;
  }
}else{
  $error = [
           'id'=> implode($v->errors()->get('id')),
           'customer_name'=> implode($v->errors()->get('customer_name')),
           'customer_phone'=>implode($v->errors()->get('customer_phone')),
           'city'=>implode($v->errors()->get('city')),
           'town'=>implode($v->errors()->get('town')),
           'address'=>implode($v->errors()->get('address')),
           'note'=>implode($v->errors()->get('note')),
           ];
}
echo json_encode(['success'=>$success, 'error'=>$error]);
?>