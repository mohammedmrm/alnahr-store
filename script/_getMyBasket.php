<?php
session_start();
header('Content-Type: application/json');
require("_access.php");
require("dbconnection.php");
try{
  $query = "select * from basket where staff_id=? and status > 0";
  $data = getData($con,$query,[$_SESSION['userid']]);
  $success="1";
  $i=0;
  foreach($data as $v){
    $sql ="select *,if(sub_name is null or sub_name = '',product.name,sub_name) as sub_name, basket_items.qty as bi_qty from basket_items
            left join configurable_product on configurable_product.id = basket_items.configurable_product_id
            left join product on product.id = configurable_product.product_id
            left join (
                     select  max(path) as path,product_id from images
                     group by images.product_id
            ) a on a.product_id = configurable_product.product_id
            where basket_id=?";
    $res = getData($con,$sql,[$v['id']]);
    $data[$i]['items'] = $res;
    $i++;
  }
} catch(PDOException $ex) {
   $data=["error"=>$ex,'q'=>$query];
   $success="0";
}
echo (json_encode(array("success"=>$success,"data"=>$data)));
?>