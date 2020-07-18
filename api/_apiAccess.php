<?php
if(!isset($_SESSION)){
 session_start();
}
header('Content-Type: application/json');
$username = $_REQUEST['username'];
$password = $_REQUEST['password'];
require_once("../script/dbconnection.php");
if(!empty($password) && !empty($username)){
  $sql = 'select * from staff where phone=?';
  $loginres  = getData($con,$sql,[$username]);
  if(count($loginres) == 1 && password_verify($password,$loginres[0]['password'])){
     $msg = 1;
  }else{
     $msg ="incorrect username or password";
  }
}else{
     $msg ="username and password required";
}

function access(){
  if($GLOBALS['msg']!=1){
     die(json_encode(['message'=>$GLOBALS['msg']]));
  }
}
?>