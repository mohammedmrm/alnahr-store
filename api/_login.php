<?php
header("Access-Control-Allow-Origin: *");
header('Content-type:application/json');
error_reporting(0);
session_start();
$username = $_REQUEST['username'];
$password = $_REQUEST['password'];

if(empty($username) || empty($password)){
  $msg = "جميع الحقول مطلوبة";
  $code = 300;
}else{
  require_once("../script/dbconnection.php");
  $sql = "select * from staff where phone = ? and status=1";
  $result = getData($con,$sql,[$username]);
  if(count($result) != 1 || !password_verify($password,$result[0]['password']) ){
    $msg = "اسم المستخدم او كلمة المرور غير صحيحة";
    $code = 300;
  }else{
    $msg = 1;
    $code = 200;
    $data['login']=1;
    $data['username']=$result[0]['phone'];
    $data['userid']=$result[0]['id'];
    $data['role']=$result[0]['role_id'];
    $data['user_details']=$result[0];
  }
}
echo json_encode(['data'=>$data,'code'=>$code,'msg'=>$msg,"redirect"=>$_REQUEST['redirect']]);
?>