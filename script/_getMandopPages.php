<?php
session_start();
header('Content-Type: application/json');
error_reporting(0);
require("dbconnection.php");
require("../config.php");
$id= $_REQUEST['id'];
$success=0;
$i=0;
try{
  $query = "select mandop_stores.*,stores.name as store_name, clients.name as client_name
            from mandop_stores
            left join stores on stores.id = mandop_stores.store_id
            left join clients on stores.client_id = clients.id
            where mandop_id =?";
  $data = getData($con,$query,[$id]);
  $sql = "select * from staff where id=?";
  $res = getData($con,$sql,[$id]);
  $res =$res[0];
  $success = 1;
} catch(PDOException $ex) {
   $data=["error"=>$ex];
   $success="0";
}
echo json_encode(array($id,"success"=>$success,"data"=>$data,'mandop_info'=>$res));
?>