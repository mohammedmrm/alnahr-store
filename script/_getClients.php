<?php
session_start();
header('Content-Type: application/json');
error_reporting(0);
require("_access.php");
access([1,2,3,4,5,6]);
$branch = $_REQUEST['branch'];
if(empty($branch)){
  $branch =1;
}
require("dbconnection.php");
try{
  $query = "select * from clients where branch_id=".$branch." and company_id=?";
  $data = getData($con,$query,[$_SESSION['company_id']]);
  $success="1";
} catch(PDOException $ex) {
   $data=["error"=>$ex];
   $success="0";
}
echo (json_encode(array("success"=>$success,"data"=>$data,"Q"=>$query)));
?>