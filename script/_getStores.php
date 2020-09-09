<?php
session_start();
header('Content-Type: application/json');
error_reporting(0);
require("_access.php");
access([1,2,3,4,5,6,10]);
$client = $_REQUEST['client'];
if($_SESSION['role'] == 10 ){
 $client = $_SESSION['userid'];
}
require("dbconnection.php");
try{
  if(empty($client)){
   $query = "select stores.*, clients.name as client_name , clients.phone as client_phone
   from stores inner join clients on clients.id = stores.client_id where stores.company_id=?";
    $data = getData($con,$query,[$_SESSION['company_id']]);

  }else {
   $query = "select stores.*, clients.name as client_name , clients.phone as client_phone
   from stores inner join clients on clients.id = stores.client_id";
   $query .= " where client_id=? and stores.company_id=?";
   $data = getData($con,$query,[$client,$_SESSION['company_id']]);
  }
  $success="1";
} catch(PDOException $ex) {
   $data=["error"=>$ex];
   $success="0";
}
print_r(json_encode(array("success"=>$success,"data"=>$data)));
?>