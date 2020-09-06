<?php
session_start();
error_reporting(0);
header('Content-Type: application/json');
require("_access.php");
access([1,5,3]);
require("dbconnection.php");
$store = $_REQUEST['store'];
try{
  $query = "select *,date_format(basket.date,'%Y-%m-%d') as date,
            cites.name as city,towns.name as town,staff.name as mandop_name
            from basket
            left join staff on staff.id = basket.staff_id
            left join cites on  cites.id = basket.city_id
            left join towns on  towns.id = basket.town_id
            left join (
                   select count(*) as items,basket_id from basket_items group by basket_id
            ) a on a.basket_id = basket.id
            where  (basket.status = 2 || basket.status = 3)  and a.items > 0 and basket.company_id=?";
  if($store > 0){
    $filter = " and store_id =".$store;
  }
  $data = getData($con,$query,[$_SESSION['company_id']]);
  $success="1";
} catch(PDOException $ex) {
   $data=["error"=>$ex];
   $success="0";
}
echo (json_encode(array("success"=>$success,"data"=>$data)));
?>