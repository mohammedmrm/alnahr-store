<?php
session_start();
error_reporting(0);
header('Content-Type: application/json');
require_once("_access.php");
access([1,2,5]);
require_once("dbconnection.php");
require_once("_crpt.php");
require_once("_vaildFile.php");
require_once("../config.php");

use Violin\Violin;
require_once('../validator/autoload.php');
$v = new Violin;


$success = 0;
$name    = $_REQUEST['name'];
$phone    = $_REQUEST['phone'];
$note    = $_REQUEST['note'];
$mname   = $_REQUEST['m_name'];
$username   = $_REQUEST['username'];
$password = $_REQUEST['password'];
$error=[];


$v->addRuleMessage('isPhoneNumber', ' رقم هاتف غير صحيح ');

$v->addRule('isPhoneNumber', function($value, $input, $args) {
    return   (bool) preg_match("/^[0-9]{10,15}$/",$value);
});
$v->addRuleMessage('unique', ' القيمة المدخلة مستخدمة بالفعل ');

$v->addRule('unique', function($value, $input, $args) {
    $value  = trim($value);
    if(!empty($value)){
    $exists = getData($GLOBALS['con'],"SELECT * FROM staff WHERE phone =".$value);
    }else{
      $exists = 0;
    }
    return ! (bool) count($exists);
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
    'name'    => [$name, 'required|min(3)|max(100)'],
    'phone'   => [$phone,'required|isPhoneNumber'],
    'note'    => [$note, 'min(3)|max(200)'],
    'mname'   => [$mname, 'required|min(3)|max(100)'],
    'username'=> [$username, 'required|isPhoneNumber|unique'],
    'password'=> [$password, "required|min(4)|max(30)"],
]);
$logo_err = image($logo,[".jpg", ".jpeg", ".png"],1);
if($v->passes()) {
  try{
  $sql = 'insert into head_company (name,phone,note) values
                              (?,?,?)';
  $result = setDataWithLastID($con,$sql,[$name,$phone,$note]);
  if($result > 0){
    $success = 1;
    $pass = hashPass($password);
    $sql = "insert into staff (name,phone,password,company_id,role_id) values(?,?,?,?,?)";
    $data = setData($con,$sql,[$mname,$username,$pass,$result,1]);
  }
} catch(PDOException $ex) {
   $success="0";
   $error =["error"=>$ex];
}
}else{
  $error = [
           'name_err'=> implode($v->errors()->get('name')),
           'phone_err'=>implode($v->errors()->get('phone')),
           'note_err'=>implode($v->errors()->get('note')),
           'mname_err'=>implode($v->errors()->get('mname')),
           'username_err'=>implode($v->errors()->get('username')),
           'password_err'=>implode($v->errors()->get('password')),
           ];
}
echo json_encode(['success'=>$success, 'error'=>$error]);
?>