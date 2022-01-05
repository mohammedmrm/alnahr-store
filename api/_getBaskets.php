<?php
session_start();
header('Content-Type: application/json');
require_once("_apiAccess.php");
access();
require_once("../script/dbconnection.php");
require_once("../config.php");
function correct_encoding($text) {
  $current_encoding = mb_detect_encoding($text, 'auto');
  $text = iconv($current_encoding, 'UTF-8', $text);
  return $text;
}
try{
  $query = "select basket.*,a.*,cites.name as city_name,towns.name as town_name,
             if(basket.city_id = 1,".$config['dev_b'].",".$config['dev_o'].") as dev_price
            from basket
            left join staff on staff.id = basket.staff_id
            left join (
                   select count(*) as items,basket_id from basket_items group by basket_id
            ) a on a.basket_id = basket.id
            left join cites on cites.id = basket.city_id
            left join towns on towns.id = basket.town_id
            where basket.staff_id = ?";
  $data = getData($con,$query,[$userid]);
  $i=0;
  foreach($data as $v){
  $sql = "select *,basket_items.id as bi_id from basket_items
   inner join configurable_product
   on configurable_product.id = basket_items.configurable_product_id
   where basket_items.basket_id = ?";
    $res = getData($con,$sql,[$data[$i]['id']]);
    $data[$i]['items'] = $res;
    $data[$i]['customer_name'] = correct_encoding($data[$i]['customer_name']);
    foreach($res as $it){
      $data[$i]['total_price'] += $it['price'];
    }
    $data[$i]['total_price'] += $data[$i]['dev_price'];

    $i++;
  }
  $success="1";
} catch(PDOException $ex) {
   $data=["error"=>$ex,'q'=>$query];
   $success="0";
}
echo (json_encode(array('code'=>200,'message'=>$msg,"success"=>$success,"data"=>$data)));
?>