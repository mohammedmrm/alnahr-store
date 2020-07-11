<?php
session_start();
error_reporting(0);
header('Content-Type: application/json');
require("_access.php");
access([1,2,5]);
require("dbconnection.php");

$ids = $_REQUEST['ids'];
$statues = $_REQUEST['status'];
$items = $_REQUEST['items'];
$success="0";
if(isset($_REQUEST['ids'])){
      try{
         $query = "update orders set order_status_id=? where id=? and invoice_id=0";
         $query2 = "insert into tracking (order_id,order_status_id,date,staff_id) values(?,?,?,?)";
         $i = 0;
         foreach($ids as $v){
           if($statues[$i] >= 1){
             $data = setData($con,$query,[$statues[$i],$v]);
             setData($con,$query2,[$v,$statues[$i],date('Y-m-d H:i:s'),$_SESSION['userid']]);
               if($statues[$i] == 6 || $statues[$i] == 5){
                     foreach ($items[$v] as $item){
                       $sql = "update configurable_product
                                inner join order_items on order_items.configurable_product_id = configurable_product.id
                                set item_status = ?,
                                configurable_product.qty = if(
                                   item_status <> 5 and item_status <> 6 and item_status <> 9,
                                   configurable_product.qty + order_items.qty,
                                   if((item_status = 5 or item_status = 6 or item_status = 9) and ? <> 5 and ? <> 6 and ? <> 9 ,
                                     configurable_product.qty - order_items.qty,
                                     configurable_product.qty
                                    )
                                  )

                                where order_items.id = ?";
                       setData($con,$sql,[$statues[$i],$statues[$i],$statues[$i],$statues[$i],$item]);
                     }
               }else{
                   $sql = "update configurable_product
                            inner join order_items on order_items.configurable_product_id = configurable_product.id
                            set item_status = ?,
                            configurable_product.qty = if(
                               item_status <> 5 and item_status <> 6 and item_status <> 9,
                               configurable_product.qty + order_items.qty,
                               if((item_status = 5 or item_status = 6 or item_status = 9) and ? <> 5 and ? <> 6 and ? <> 9 ,
                                 configurable_product.qty - order_items.qty,
                                 configurable_product.qty
                                )
                              )

                            where order_items.order_id = ?";
                   setData($con,$sql,[$statues[$i],$statues[$i],$statues[$i],$statues[$i],$v]);
               }

             $success="1";
           }
           $i++;
         }
      } catch(PDOException $ex) {
          $data=["error"=>$ex];
          $success="0";
      }
 }else{
  $success="2";
}

echo json_encode([$_REQUEST,"success"=>$success,"data"=>$data]);
?>