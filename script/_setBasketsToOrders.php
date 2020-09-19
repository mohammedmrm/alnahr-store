<?php
session_start();
error_reporting(0);
header('Content-Type: application/json');
require_once("_access.php");
access([1,3,5]);
require_once("dbconnection.php");
require_once("_crpt.php");
require_once("../config.php");

use Violin\Violin;
require_once('../validator/autoload.php');
$v = new Violin;


$success = 0;
$add = 0;
$id      = $_REQUEST['id'];
$company = $_REQUEST['company'];
$order_nos = $_REQUEST['order_nos'];
if(empty($company) || !($company>=0)){
  $company = 0;
}
$sql = "select *
            from basket
            left join (
                   select count(*) as items,basket_id from basket_items group by basket_id
            ) a on a.basket_id = basket.id
            where  (basket.status = 2 || basket.status = 3)  and a.items > 0 and basket.company_id=?";
$allbaskets = getData($con,$sql,[$_SESSION['company_id']]);
foreach($allbaskets as $basket){
    $id = $basket['id'];
    $error = [];
    $msg = "";
    $manual = 0;
    foreach ($order_nos as $no){
      if( $no > 1){
        $msg = "";
        $manual++;
      }else if($no == ""){
        $msg = "";
      }else{
        $msg = "رقم الوصل -".$no. "- غير صالح";
        break;
      }
}

    if($v->passes() && $msg == "") {
     try{
        $sql = 'SELECT basket.*,COUNT(basket_items.id) as allitems,SUM(configurable_product.price * basket_items.qty) as total  from basket
                left join basket_items on basket_items.basket_id = basket.id
                left join configurable_product on configurable_product.id = basket_items.configurable_product_id
                where basket.id=? GROUP by basket.id';
        $res = getData($con,$sql,[$id]);
        if(count($res) == 1){
          //--- check if all items are prepared by the storage_manager;
             $discount = $res[0]['discount'];
             $total_price = $res[0]['total'];
             $sql = "SELECT max(store_id) as stores FROM `basket_items`
                                left join `configurable_product` on configurable_product_id = configurable_product.id
                                left join `product` on configurable_product.product_id = product.id
                                where basket_id = ? GROUP by product.store_id";
              $stores = getData($con,$sql,[$id]);
              $required_receipts=count($stores);


              $sql = "SELECT sum((to_receipt-from_receipt)+1) as receipts FROM `receipts` where company_id = 0";
              $receipts = getData($con,$sql,[$id]);
              $receipts=$receipts[0];

          if($receipts >= ($required_receipts-$manual)){
            $sql = "select * from basket_items where basket_id=?";
            $res2 = getData($con,$sql,[$id]);
            if(count($res2) >= 1){
                foreach($res2 as $val){
                  $sql = "select * from configurable_product where id=?";
                  $res6 = getData($con,$sql,[$val['configurable_product_id']]);
                  $a_qty = $res6[0]['qty'];
                  if($a_qty <  $val['qty']){
                    $msg = "يوجد منتج واحد  على الاقل  بكمية غير كافية";
                    break;
                  }else if($val['status'] == 0){
                    $msg = "يوجد منتجات بالسلة لم  يتم تجهيزها";
                    break;
                  }else{
                     $msg = "";
                  }
                }
            }
            if($msg == ""){
                    $i = 0;
                    foreach($stores as $store){
                        //--- prepare the order
                        $sqllll ="SELECT basket_items.*,configurable_product.price as p_price FROM basket_items
                                            left join configurable_product on configurable_product_id = configurable_product.id
                                            left join product on configurable_product.product_id = product.id
                                            where basket_id = ? and store_id=?";

                        $items = getData($con,$sqllll,[$id,$store['stores']]);
                        $iiii[]=$items;
                        $total = 0;
                        $dis = 0;
                        foreach($items as $it){
                           $total += ((float)$it['p_price'])*((int)$it['qty']);
                        }
                        $per =   $total/$total_price;
                        $dis = 250 * round(($discount * $per)/250);
                        if($order_nos[$i] == ""){
                          $sql="select * from receipts where delivery_company_id=? and (to_receipt - from_receipt ) >= ? and company_id=? limit 1";
                          $order = getData($con,$sql,[$company,($required_receipts-$manual),$_SESSION['company_id']]);
                          $order_no = $order[0]['from_receipt'];
                        }else{
                           $order_no = $order_nos[$i];
                        }
                        $mandop_id = $res[0]['staff_id'];
                        if($_SESSION['role'] == 10){
                         $mandop_id = -1;
                        }
                        $sql = "insert into orders (order_no,total_price,customer_name,customer_phone,city_id,town_id,address,note,mandop_id,manager_id,store_id,discount,type,oldOrder_id,company_id) values(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)";
                        $order_id = setDataWithLastID($con,$sql,[$order_no,$total,$res[0]['customer_name'],$res[0]['customer_phone'],$res[0]['city_id'],$res[0]['town_id'],$res[0]['address'],$res[0]['note'],$mandop_id,$_SESSION['userid'],$store['stores'],$dis,$res[0]['type'],$res[0]['oldOrder_id'],$_SESSION['company_id']]);
                        foreach($items as $item){
                          $sql = "insert into order_items (order_id,configurable_product_id,qty,mandop_id,storage_manager_id,price,company_id)
                                 values (?,?,?,?,?,?,?)";
                          $res4 = setData($con,$sql,[$order_id,
                                                    $item['configurable_product_id'],
                                                    $item['qty'],
                                                    $item['storage_manager_id'],
                                                    $item['price'],
                                                    $item['staff_id'],
                                                    $_SESSION['company_id'],
                                                    ]);

                           $sql = "update configurable_product set qty = qty - ".$item['qty']." where id=?";
                           $res6 = setData($con,$sql,[$item['configurable_product_id']]);
                           $sql = "delete from basket_items where basket_id=? and id=?";
                           $res7 = setData($con,$sql,[$id,$item['id']]);

                        }
                         $sql = "update receipts set from_receipt = (from_receipt + 1) where id=?";
                         setData($con,$sql,[$order[0]['id']]);
                         $i++;

                     }
                     $add++;
                    $sql = "delete from basket where id=?";
                    $res8 = setData($con,$sql,[$id]);
                    $success = 1;
            }else{
                $success = 0;
            }
          }else{
            $msg = "الوصولات المتبقية غير كافية";
          }
        }else {
          $msg = "السلة غير موجودة";
        }
        }catch(PDOException $ex) {
         $msg=["error"=>$ex];
         $success="0";
        }
      }else{
        $error = [
                 'id'=> implode($v->errors()->get('id')),
                 ];
        $success = 0;
      }
}
echo json_encode([$_POST,'success'=>$success,'error'=>$error,'msg'=>$msg,'added'=>$add]);
?>