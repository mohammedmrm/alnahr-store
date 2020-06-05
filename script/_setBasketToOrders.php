<?php
session_start();
error_reporting(0);
header('Content-Type: application/json');
require_once("_access.php");
access("");
require_once("dbconnection.php");
require_once("_crpt.php");
require_once("../config.php");

use Violin\Violin;
require_once('../validator/autoload.php');
$v = new Violin;


$success = 0;
$id       = $_REQUEST['id'];
$order_no = $_REQUEST['order_no'];
$error = [];
$v->addRuleMessages([
    'required' => ' الحقل مطلوب',
    'int'      => ' فقط الارقام مسموح بها',
    'regex'    => ' فقط الارقام مسموح بها',
    'min'      => ' قصير جداً',
    'max'      => ' ( {value} ) قيمة كبيرة جداً غير مسموح بها ',
    'email'    => ' البريد الالكتروني غيز صحيح',
]);

$v->validate([
    'id'=> [$id,    'required|int'],
    ]);
$msg = "";
if($v->passes()) {
  $sql = 'SELECT * from basket where id=?';
  $res = getData($con,$sql,[$id]);
  if(count($res) == 1){
    //--- check if all items are prepared by the storage_manager;
    $sql = "select * from basket_items where basket_id=?";
    $res2 = getData($con,$sql,[$id]);
    if(count($res2) >= 1){
        foreach($res2 as $val){
          if($val['status'] == 0){
            $msg = "يوجد منتجات بالسلة لم  يتم تجهيزها";
            break;
          }else{
             $msg = "";
          }
        }
    }else{
      $msg = "السلة فارغه لايمكن تجهيزها";
    }
    if($msg == ""){
      //--- prepare the order
      $sql = "insert into orders (order_no,total_price,customer_name,customer_phone,city_id,town_id,address,note,staff_id,manager_id) values(?,?,?,?,?,?,?,?,?,?)";
      $order_id = setDataWithLastID($con,$sql,[$order_no,$res[0]['total_price'],$res[0]['customer_name'],$res[0]['customer_phone'],$res[0]['city_id'],$res[0]['town_id'],$res[0]['address'],$res[0]['note'],$res[0]['staff_id'],$_SESSION['userid']]);

      //--- ternsfer basket_items to order_items
      foreach($res2 as $val){
        $sql = "insert into order_items (order_id,configurable_product_id,qty,staff_id,storage_manager_id,price)
               values (?,?,?,?,?,?)";
        $res4 = setData($con,$sql,[$order_id,
                                  $val['configurable_product_id'],
                                  $val['qty'],
                                  $val['storage_manager_id'],
                                  $val['price'],
                                  $val['staff_id'],
                                  ]);
      }

      //--- empty all items in the basket
      $sql = "delete from basket_items where basket_id=?";
      $res5 = setData($con,$sql,[$id]);
      //--- delete the basket
      $sql = "delete from basket where id=?";
      $res6 = setData($con,$sql,[$id]);
      $success = 1;
    }
  }else {
    $msg = "السلة غير موجودة";
  }
}else{
  $error = [
           'id'=> implode($v->errors()->get('id')),
           ];
  $success = 0;
}
echo json_encode(['success'=>$success,'error'=>$error,'msg'=>$msg]);
?>