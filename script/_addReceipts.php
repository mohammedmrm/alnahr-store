<?php
session_start();
//error_reporting(0);
header('Content-Type: application/json');
require_once("_access.php");
access([1,2,3]);
$company = $_REQUEST['company'];
if(empty($company) || !($company>=0)){
  $company = 0;
}
$from = $_REQUEST['from'];
$to = $_REQUEST['to'];
$success = 0;
$msg="";
require_once("dbconnection.php");
require_once("_sendNoti.php");
require_once("../config.php");

use Violin\Violin;
require_once('../validator/autoload.php');
if(empty($from) || empty($to)){
  $msg = "جميع الحقول مطلوبة";
}else if($from > $to){
  $msg = "الارقام غير صحيحة، يجب ان تكون بداية الارقام اقل او يساوي نهاية الارقام";
}else if(!($company >= 0)){
   $msg = "معلومات الشركة غير صحيحة";
}else{
  $msg = "";
}
if($msg == ""){
  $sql = "insert into receipts (from_receipt,to_receipt,company_id,delivery_company_id) values(?,?,?,?)";
  $res = setData($con,$sql,[$from,$to,$_SESSION['company_id'],$company]);
  if($res > 0){
    $success = 1;
  }
}
echo json_encode([$_REQUEST,'success'=>$success,'msg'=>$msg]);
?>