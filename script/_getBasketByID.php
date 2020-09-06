<?php
session_start();
error_reporting(0);
header('Content-Type: application/json');
require("_access.php");
access("");
require("dbconnection.php");
$id = $_REQUEST['id'];
try{
  $query = "select * from basket
            left join staff on staff.id = basket.staff_id
            left join (
                   select count(*) as items,basket_id from basket_items group by basket_id
            ) a on a.basket_id = basket.id
            where  basket.id=? and company_id=?";
  $data = getData($con,$query,[$id,$_SESSION['company_id']]);
  $success="1";
} catch(PDOException $ex) {
   $data=["error"=>$ex];
   $success="0";
}
echo (json_encode(array("success"=>$success,"data"=>$data)));
?>