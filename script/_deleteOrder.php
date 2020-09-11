<?php
session_start();
error_reporting(0);
header('Content-Type: application/json');
require("_access.php");
access([1,2,3,5]);
$id= $_REQUEST['id'];
$success = 0;
$msg="";
require("dbconnection.php");
use Violin\Violin;
require_once('../validator/autoload.php');
$v = new Violin;

$v->validate([
    'order_id'    => [$id,'required|int']
    ]);

if($v->passes()){
         $sql = "select * from orders where id=?";
         $order = getData($con,$sql,[$id]);
         $sql = "select * from order_items where order_id=?";
         $items = getData($con,$sql,[$id]);
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
  $msg = "فشل الحذف";
  $success = 0;
}
echo json_encode(['success'=>$success, 'msg'=>$msg]);
?>