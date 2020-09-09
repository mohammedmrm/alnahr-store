<?php
session_start();
header('Content-Type: application/json');
error_reporting(0);
require("_access.php");
access([1,2,3,4,5,6,10]);
$branch = $_REQUEST['branch'];
if(empty($branch)){
  $branch =1;
}
require("dbconnection.php");
try{
  if($_SESSION['role'] == 10){
   $query = "select * from clients where branch_id=".$branch." and id=".$_SESSION['userid']." and  company_id=?";
  }else{
    $query = "select * from clients where branch_id=".$branch." and company_id=?";
  }

  $data = getData($con,$query,[$_SESSION['company_id']]);
  $success="1";
} catch(PDOException $ex) {
   $data=["error"=>$ex];
   $success="0";
}
echo (json_encode(array("success"=>$success,"data"=>$data,"Q"=>$query)));
?>