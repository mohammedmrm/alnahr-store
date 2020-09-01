<?php
session_start();
error_reporting(0);
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
require_once("_apiAccess.php");
access();
require_once("../script/dbconnection.php");
require_once("../script/_crpt.php");
require_once("../config.php");

use Violin\Violin;
require_once('../validator/autoload.php');
$v = new Violin;


$success = 0;
$error = [];
$product = $_REQUEST['product_id'];
$basket  = $_REQUEST['basket'];
$qty = $_REQUEST['qty'];
$option = $_REQUEST['option'];
$username = $_REQUEST['username'];
$password = $_REQUEST['password'];




if(empty($qty)){
  $qty = 1;
}
$v->addRuleMessages([
    'required' => ' الحقل مطلوب',
    'int'      => ' فقط الارقام مسموح بها',
    'regex'    => ' فقط الارقام مسموح بها',
    'min'      => ' قصير جداً',
    'max'      => ' ( {value} ) قيمة كبيرة جداً غير مسموح بها ',
    'email'    => ' البريد الالكتروني غيز صحيح',
]);

$v->validate([
    'product' => [$product,  'required|int'],
    'basket'  => [$basket,   'required|int'],
    'qty'     => [$qty,'required|int'],
]);
$sql = "select * from basket where id=?";
$basket2 = getData($con,$sql,[$basket2]);
$type = $basket2[0]['type'];
$oldOrder = $basket2[0]['oldOrder_id'];
if($type == 2){
 $sql = "select stores.name as store_name,stores.id as store_id from orders
         inner join stores on stores.id = orders.store_id
         where orders.id = ? limit 1
         ";
 $oldStore = getData($con,$sql,[$oldOrder]);
 $oldStore = $oldStore[0]['store_id'];

 $sql = "select stores.name as store_name,stores.id as store_id from configurable_product
        inner join product on product.id = configurable_product.product_id
        inner join stores on stores.id = product.store_id
        where configurable_product.id = ?";
 $newStore = getData($con,$sql,[$product]);
 $newStore = $newStore[0]['store_id'];
 if($oldStore != $newStore){
   $msg = "يجب اضافه منتجات تابعه لنفس منتج الاستبدال";
 }else{
   $msg="";
 }
}else{
   $msg = "";
}


if($v->passes() && $msg == "") {
 $sql = "select attribute_id from sub_option
                            left join configurable_product on configurable_product.id = sub_option.configurable_product_id
                            left join product on product.id = configurable_product.product_id
                            where product.id = ? GROUP by sub_option.attribute_id";
 $pro = getData($con,$sql,[$product]);
 $count = count($pro);
 $op = count($option);
 if($count = $op){
    foreach($option as $conf) {
        if ($i == 0) {
                $options += ' attribute_config_id=' + $conf;
            } else {
                $options += ' or attribute_config_id=' + $conf;
            }
        $i++;
    }
      $query = 'SELECT configurable_product_id as c_id,COUNT(configurable_product_id) as count
                FROM sub_option
                left join configurable_product on configurable_product.id = sub_option.configurable_product_id
                left join product on configurable_product.product_id = product.id
                where ( '.$options.' ) and product.id = '.$product.'
                GROUP by configurable_product_id
                order by COUNT(configurable_product_id) DESC
                limit 1';
     $configrabe_pro = getData($con,$query);
     $query = 'insert into basket_items (configurable_product_id,basket_id,qty,staff_id)
                values (?,?,?,?)';
     $addToBasket = setDataWithLastID($con,$query,[$configrabe_pro[0]['c_id'],$basket,$qty,$login['id']]);
     if($addToBasket>0){
        $success = 1;
        $sql = "update basket set status=1 where staff_id=? and id=?";
        setData($con,$sql,[$userid,$addToBasket]);
     }
 }

}else{
  $error = [
           'product'=> implode($v->errors()->get('product')),
           'basket'=>implode($v->errors()->get('basket')),
           'qty'=>implode($v->errors()->get('qty')),
           'msg'=>$msg
           ];
}

echo json_encode(["login"=>$login,'success'=>$success,'error'=>$error]);
?>