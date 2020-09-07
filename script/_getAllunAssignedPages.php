<?php
session_start();
error_reporting(0);
header('Content-Type: application/json');
require("_access.php");
access([1,2,3]);
require("dbconnection.php");
$query = "select
           stores.name as store, stores.id as id,clients.name as client_name
           from stores
           left join clients on clients.id = stores.client_id
           where stores.company_id=?";

try{

  $data = getData($con,$query,[$_SESSION['company_id']]);
  $success="1";
} catch(PDOException $ex) {
   $data=["error"=>$ex,'q'=>$query];
   $success="0";
}
print_r(json_encode(array("success"=>$success,"data"=>$data,'P'=>$city)));
?>