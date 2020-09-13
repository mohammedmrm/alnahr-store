<?php
session_start();
error_reporting(0);
header('Content-Type: application/json');
require_once("_access.php");
access([1,2,3,5,7,8]);
require_once("dbconnection.php");
require_once("../config.php");

use Violin\Violin;
require_once('../validator/autoload.php');
$v = new Violin;
function validateDate($date, $format = 'Y-m-d')
{
    $d = DateTime::createFromFormat($format, $date);
    return $d && $d->format($format) == $date;
}

$v->addRuleMessage('isPhoneNumber', 'رقم هاتف غير صحيح ');

$v->addRule('isPhoneNumber', function($value, $input, $args) {
  if(preg_match("/^[0-9]{10,15}$/",$value) || empty($value)){
    $x=(bool) 1;
  }
    return $x;
});

$v->addRuleMessage('isPrice', 'المبلغ غير صحيح');

$v->addRule('isPrice', function($value, $input, $args) {
  if(preg_match("/^(0|\-\d*|\d*)(\.\d{2})?$/",$value)){
    $x=(bool) 1;
  }
  return   $x;
});

$v->addRuleMessage('unique', 'القيمة المدخلة مستخدمة بالفعل ');

$v->addRule('unique', function($value, $input, $args) {
    $value  = trim($value);
    $exists = getData($GLOBALS['con'],"SELECT * FROM orders WHERE order_no ='".$value."' and id <> '".$GLOBALS['id']."'");
    return ! (bool) count($exists);
});
$v->addRuleMessages([
    'required' => 'الحقل مطلوب',
    'int'      => 'فقط الارقام مسموع بها',
    'regex'      => 'فقط الارقام مسموع بها',
    'min'      => 'قصير جداً',
    'max'      => 'تم ادخال بيانات اكثر من الحد المسموح',
    'email'      => 'البريد الالكتروني غيز صحيح',
]);
$error = [];
$success = 0;
$manger = $_SESSION['userid'];

$id = $_REQUEST['e_Orderid'];
$number = $_REQUEST['e_order_no'];
$order_type = 'multi';
$order_price = $_REQUEST['e_price'];
$order_discount= $_REQUEST['e_discount'];
$client = $_REQUEST['e_client'];
$store = $_REQUEST['e_store'];
$client_phone = $_REQUEST['e_client_phone'];
$customer_name = $_REQUEST['e_customer_name'];
$customer_phone = $_REQUEST['e_customer_phone'];
$city_to = $_REQUEST['e_city'];
$town_to = $_REQUEST['e_town'];
$order_note= $_REQUEST['e_order_note'];
$date= $_REQUEST['e_date'];
if(!validateDate($date)){
  $date_err = "تاريخ غير صالح";
}else{
  $date_err = "";
}
if(empty($number)){
  $number = "1";
}
$v->validate([
    'id'            => [$id,    'required|int'],
    'order_no'      => [$number,'required|min(1)|max(100)'],
    'order_price'   => [$order_price,   "isPrice"],
    'order_discount'=> [$order_discount,"isPrice"],
    'store'         => [$store,  'int'],
    'customer_name' => [$customer_name, 'required|min(2)|max(200)'],
    'customer_phone'=> [$customer_phone,'isPhoneNumber'],
    'city'          => [$city_to,  'int'],
    'town'          => [$town_to,  'int'],
    'order_note'    => [$order_note,'max(250)'],
]);

$response = [];
$sql ="select * from orders where id = ?";
$order = getData($con,$sql,[$id]);
if($v->passes() && $date_err =="" ) {

  $sql = 'update orders set order_no="'.$number.'"';
  $up = "";
  if(!empty($weight) && $weight > 0){
    $up .= ' , weight='.$weight;
  }
  if(!empty($qty) && $qty > 0){
    $up .= ' , qty='.$qty;
  }
  if(!empty($branch_to)  && $branch_to > 0){
    $up .= ' , to_branch='.$branch_to;
  }
  if(!empty($branch)  && $branch > 0){
    $up .= ' , from_branch='.$branch;
  }
  if(!empty($city_to) && $city_to > 0){
    $up .= ' , city_id='.$city_to;
  }
  if(!empty($town_to) && $town_to > 0){
    $up .= ' , town_id='.$town_to;
  }
  if(!empty($order_price)){
    $up .= ' , total_price="'.$order_price.'"';
  }
  if(!empty($order_iprice)){
    $up .= ' , discount="'.$order_discount.'"';
  }
  if(!empty($store) && $store > 0){
    $up .= ' , store_id="'.$store.'"';
  }
  if(!empty($client) && $client > 0){
    $up .= ' , client_id="'.$client.'"';
  }
  if(!empty($customer_phone)){
    $up .= ' , customer_phone="'.$customer_phone.'"';
  }
  if(!empty($customer_name)){
    $up .= ' , customer_name="'.$customer_name.'"';
  }
  if(!empty($order_note)){
    $up .= ' , note="'.$order_note.'"';
  }
  if(!empty($date)){
    $up .= ' , date="'.$date.'"';
  }
  $where = " where id =".$id."  and invoice_id=0";
  $sql .= $up.$where;
  $result = setData($con,$sql);
  if($result > 0){
    $success = 1;
    if($city_to == 1){
     $price = $order_price - $order_discount + $config['dev_b'];
    }else{
     $price = $order_price - $order_discount + $config['dev_o'];
    }
    if($order[0]['bar_code'] > 0){
      $sql ="select * from companies where id=".$order[0]['delivery_company_id'];
      $res= getData($con,$sql);
      $response = httpPost($res[0]['dns'].'api/updateOrder.php',['token'=>$res[0]['token'],'order'=>$_REQUEST,'price'=>$price,'barcode'=>$order[0]['bar_code']]);
      $response = json_decode(substr($response, 3));
    }
  }
}else{
$error = [
           'id'=> implode($v->errors()->get('id')),
           'order_no'=>implode($v->errors()->get('order_no')),
           'order_price'=>implode($v->errors()->get('order_price')),
           'order_discount'=>implode($v->errors()->get('v')),
           'store'=>implode($v->errors()->get('store')),
           'customer_name'=>implode($v->errors()->get('customer_name')),
           'customer_phone'=>implode($v->errors()->get('customer_phone')),
           'city'=>implode($v->errors()->get('city')),
           'town'=>implode($v->errors()->get('town')),
           'order_note'=>implode($v->errors()->get('order_note')),
           'date'=>$date_err,
           'premission'=>$premission
           ];
}
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
echo json_encode([$order_discount,$res[0]['dns'].'api/updateOrder.php','success'=>$success, 'error'=>$error,'response'=>$response]);
?>