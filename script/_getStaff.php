<?php
session_start();
header('Content-Type: application/json');
require("_access.php");
access([1,2]);
require("dbconnection.php");
try{
  if($_SESSION['role'] == 1 ){
  $query = "select staff.*,
            role.name as role_name
            from staff inner join role on role.id = staff.role_id
            where staff.company_id=?";
  }else{
   $query = "select staff.*,
            role.name as role_name
            from staff inner join branches on branches.id = staff.branch_id
            inner join role on role.id = staff.role_id
             where staff.company_id=?";
  }
  $data = getData($con,$query,[$_SESSION['company_id']]);
  $success="1";
} catch(PDOException $ex) {
   $data=["error"=>$ex];
   $success="0";
}
print_r(json_encode(array("success"=>$success,"data"=>$data)));
?>