<?php
session_start();
error_reporting(0);
header('Content-Type: application/json');
require("_access.php");
access([1,2,3,5]);
$id= $_REQUEST['id'];
$success = 0;
$msg="";
$response=[];
require("dbconnection.php");
use Violin\Violin;
require_once('../validator/autoload.php');
$v = new Violin;

$v->validate([
    'order_id'    => [$id,'required|int']
    ]);
function httpPost($url, $data)
{
    $curl = curl_init($url);
    curl_setopt($curl, CURLOPT_POST, true);
    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query($data));
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    $response = curl_exec($curl);
    curl_close($curl);
    return $response;
}
if($v->passes()){
         $sql = "select * from orders where id=?";
         $order = getData($con,$sql,[$id]);
         $sql = "select * from order_items where order_id=?";
         $items = getData($con,$sql,[$id]);
         if($order[0]['bar_code'] > 0 ){
            $sql ="select * from companies where id=?";
            $res= getData($con,$sql,[$order[0]['delivery_company_id']]);
            $response = httpPost($res[0]['dns'].'api/deleteOrder.php',['token'=>$res[0]['token'],'barcode'=>$order[0]['bar_code']]);
            $response = json_decode($response, true);
            if($response['success'] == 1){
               if($_SESSION['role'] == 1){
                  $sql = "delete from orders where id = ?";
                  $result = setData($con,$sql,[$id]);
                  if($result > 0){
                    $i = 0;
                    foreach($items as $k=>$val){
                      $update = "update configurable_product set qty = qty + ? where id=?";
                      setData($con,$update,[$val['qty'],$val['configurable_product_id']]);
                      $i++;
                    }
                    $sql = "delete from order_items where order_id=?";
                    setData($con,$sql,[$id]);
                    $sql = "delete from tracking where order_id = ?";
                    $result = setData($con,$sql,[$id]);
                  }
                  $success = 1;
               }else{
                  $msg = "فشل الحذف";
               }
            }else{
               $msg = "لا يمكن حذف الطلب";
            }
         }else{
               if($_SESSION['role'] == 1){
                  $sql = "delete from orders where id = ?";
                  $result = setData($con,$sql,[$id]);
                  if($result > 0){
                    $i = 0;
                    foreach($items as $k=>$val){
                      $update = "update configurable_product set qty = qty + ? where id=?";
                      setData($con,$update,[$val['qty'],$val['configurable_product_id']]);
                      $i++;
                    }
                    $sql = "delete from order_items where order_id=?";
                    setData($con,$sql,[$id]);
                    $sql = "delete from tracking where order_id = ?";
                    $result = setData($con,$sql,[$id]);
                  }
                  $success = 1;
               }else{
                  $msg = "فشل الحذف";
               }
         }
}else{
  $msg = "فشل الحذف";
  $success = 0;
}
echo json_encode([$order[0]['barcode'],'success'=>$success, 'msg'=>$msg,'response'=>$response]);
?>