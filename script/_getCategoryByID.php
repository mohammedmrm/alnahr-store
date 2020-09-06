<?php
session_start();
header('Content-Type: application/json');
require("_access.php");
access([1,2,3,4,5,6]);
$id = $_REQUEST['id'];
require("dbconnection.php");
try{
  $query = "select * from category where id =? and company_id=?";
  $data = getData($con,$query,[$id,$_SESSION['company_id']]);
  $success="1";
} catch(PDOException $ex) {
   $data=["error"=>$ex];
   $success="0";
}
echo (json_encode(array("success"=>$success,"data"=>$data)));
?>