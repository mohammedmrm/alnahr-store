<?php
if(!isset($_SESSION)){
 session_start();
}
header("Access-Control-Allow-Origin: *");
header('Content-Type: application/json');
$username = $_REQUEST['username'];
$password = $_REQUEST['password'];
require_once("../script/dbconnection.php");
if(!empty($password) && !empty($username)){
  $sql = 'select * from staff where phone=?';
  $loginres  = getData($con,$sql,[$username]);
  if(count($loginres) == 1 && password_verify($password,$loginres[0]['password'])){
     $msg = 1;
     $code = 200;
     $userid = $loginres[0]['id'];
     $head_company_id= $loginres[0]['company_id'];
     $userrole= $loginres[0]['role_id'];
  }else{
     $msg ="incorrect username or password";
     $code = 300;
  }
}else{
     $msg ="username and password required";
     $code = 301;
}

function access(){
  if($GLOBALS['msg']!=1){
     die(json_encode(['message'=>$GLOBALS['msg'],'code'=>$GLOBALS['code']]));
  }
} 
?>