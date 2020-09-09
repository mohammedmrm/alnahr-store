<?php
session_start();
header('Content-Type: application/json');
require("_access.php");
access([1,2,3,4,5,6,10]);
require("dbconnection.php");
try{
  $query = "select * from basket where staff_id=? and user_type=0";
  if($_SESSION['role'] == 10){
        $query = "select * from basket where staff_id=? and user_type=1";
  }
  $data = getData($con,$query,[$_SESSION['userid']]);
  $success="1";
} catch(PDOException $ex) {
   $data=["error"=>$ex,'q'=>$query];
   $success="0";
}
print_r(json_encode(array("success"=>$success,"data"=>$data)));
?>