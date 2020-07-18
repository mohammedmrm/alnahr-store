<?php
if(!isset($_SESSION)){
 session_start();
}
header('Content-Type: application/json');
$username = $_REQUEST['username'];
$password = $_REQUEST['password'];
require_once("../script/dbconnection.php");
if(!empty($_REQUEST['username']) && !empty($_REQUEST['username'])){
  $sql = 'select * from staff where phone=?';
  $res  = getData($con,$sql,[$_REQUEST['username']]);
  if(count($result) != 1 || !password_verify($password,$result[0]['password'])){
     $msg = 1;
  }else{
     $msg ="incorrect username or password";
  }
}else{
    $msg ="username and password required";
}

function access(){
  if(!$GLOBALS['msg']){
     die(json_encode(['message'=>$msg]));
  }
}
?>