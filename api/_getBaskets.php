<?php
session_start();
header('Content-Type: application/json');
require_once("_apiAccess.php");
access();
require_once("../script/dbconnection.php");
try{
  $query = "select basket.*,cites.name as city_name,towns.name as town_name from basket
            inner join towns on towns.id = basket.town_id
            inner join cites on cites.id = basket.city_id
            where staff_id=?";
  $data = getData($con,$query,[$userid]);
  $success="1";
} catch(PDOException $ex) {
   $data=["error"=>$ex,'q'=>$query];
   $success="0";
}
echo (json_encode(array('code'=>200,'message'=>$msg,"success"=>$success,"data"=>$data)));
?>