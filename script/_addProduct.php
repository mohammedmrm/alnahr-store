<?php
session_start();
error_reporting(0);
header('Content-Type: application/json');
require_once("_access.php");
access([1,2]);
require_once("dbconnection.php");
require_once("_crpt.php");
require_once("_sendNoti.php");

use Violin\Violin;
require_once('../validator/autoload.php');
$v = new Violin;


$success = 0;
$error = [];
$name    = $_REQUEST['Product_name'];
$cat   = $_REQUEST['cat'];
$store   = $_REQUEST['store'];
$simple_des   = $_REQUEST['simple_des'];
$des  = $_REQUEST['des'];
$buy_price  = $_REQUEST['buy_price'];
$price   = $_REQUEST['price'];
$sku  = $_REQUEST['sku'];
$qty  = $_REQUEST['qty'];
$type = $_REQUEST['type'];
$location = $_REQUEST['location'];
$attributes = $_REQUEST['attributes'];
$config_matrix = $_REQUEST['config_matrix'];


$imgs = $_FILES['imgs'];
$valid_file_extensions = array(".jpg", ".jpeg", ".png");


$v->addRuleMessage('isPhoneNumber', ' رقم هاتف غير صحيح  ');

$v->addRule('isPhoneNumber', function($value, $input, $args) {
    return   (bool) preg_match("/^[0-9]{10,15}$/",$value);
});


$v->addRuleMessages([
    'required' => 'الحقل مطلوب',
    'int'      => 'فقط الارقام مسموع بها',
    'regex'      => 'فقط الارقام مسموع بها',
    'min'      => 'قصير جداً',
    'max'      => 'مسموح ب {value} رمز كحد اعلى ',
    'email'      => 'البريد الالكتروني غيز صحيح',
]);

$v->validate([
    'name'      => [$name,    'required|min(4)|max(250)'],
    'simple_des'=> [$simple_des,'max(250)'],
    'des'       => [$des,   "max(3000)"],
    'buy_price' => [$buy_price,"required"],
    'price'     => [$price,  'required'],
    'cat'       => [$cat,  'required|int'],
    'store'     => [$store,  'required|int'],
    'sku'       => [$sku,  'required'],
    'type'      => [$type,  'required|int'],
]);
$i = 0;
$valid_file_extensions = array(".jpg", ".jpeg", ".png");
if(count($imgs["tmp_name"]) > 0){
foreach($imgs["tmp_name"] as $val){
     if($imgs['size'][$i] == 0 || $imgs['size'][$i] >= "2048000"){
      $img_err =  " يجب تحميل صورة صالحة بحجم اقل من 2M <br />(" . ($i+1).")";
      break;
     }else{
       $ext = strrchr($imgs["name"][$i], ".");
       if(in_array($ext, $valid_file_extensions) && @getimagesize($imgs["tmp_name"][$i]) !== false){
         $img_err =  "";
       }else{
        $img_err =  "صورة غير صالحة ". ($i+1);
        break;
       }
     }
  $i++;
}
}else{
   $img_err =  "يجب رفع صورة واحدة على الاقل";
}
if($v->passes() && $img_err ==""){
  $sql = 'insert into product (name,simple_des,des,type,category_id,store_id) values (?,?,?,?,?,?)';
  $result = setData($con,$sql,[$name,$simple_des,$des,$type,$cat,$store]);
  if($result > 0){
    $success = 1;
    $product = 'select * from product where name = ? and type = ? and category_id = ? order by id DESC limit 1';;
    $res = getData($con,$product,[$name,$type,$cat]);
    $res = $res[0];
    $i = 0;
    foreach($imgs["tmp_name"] as $val){
        $id = uniqid();
        mkdir("../img/product/".$res['id']."/", 0700);
        $ext = strrchr($imgs["name"][$i], ".");
        $destination = "../img/product/".$res['id']."/".$id.$ext;
        $imgPath = $res['id']."/".$id.$ext;
        move_uploaded_file($imgs["tmp_name"][$i], $destination);
        $sql ="insert into images (product_id,path) values(?,?)";
        setData($con,$sql,[$res['id'],$imgPath]);
        $i++;
    }
    if($type==2){
      foreach($config_matrix as $val){
        //---insert each config
        $sql =" insert into `configurable_product` (product_id,buy_price,price,qty,sku,location,stock,sub_name) values(?,?,?,?,?,?,?,?)";
        $res2 = setData($con,$sql,[$res['id'],$val['buy_price'],$val['price'],$val['qty'],$val['sku'],$val['location'],$val['stock'],$val['sub_name']]);
        //--get data of last inserted config
        $sql = "select * from `configurable_product` where product_id=? and buy_price=? and sku=? order by id DESC limit 1";
        $res3 = getData($con,$sql,[$res['id'],$val['buy_price'],$val['sku']]);
        $res3 = $res3[0];
        //-- insert config details
        $j = 0;
        foreach($val['config'] as $value){
          $sql = "insert into sub_option (configurable_product_id,attribute_id,attribute_config_id) values(?,?,?)";
          $res4 = setData($con,$sql,[$res3['id'],$attributes[$j],$value]);
          $j++;
        }
      }
    }else if($type == 1){
      $sql =" insert into `configurable_product` (product_id,buy_price,price,qty,sku,sub_name,location) values(?,?,?,?,?,?,?)";
      $res2 = setData($con,$sql,[$res['id'],$buy_price,$price,$qty,$sku,$name,$location]);
    }
 }

}else{
  $error = [
           'name'=> implode($v->errors()->get('name')),
           'cat'=>implode($v->errors()->get('cat')),
           'des'=>implode($v->errors()->get('des')),
           'simple_des'=>implode($v->errors()->get('simple_des')),
           'buy_price'=>implode($v->errors()->get('buy_price')),
           'price'=>implode($v->errors()->get('price')),
           'sku'=>implode($v->errors()->get('sku')),
           'qty'=>implode($v->errors()->get('qty')),
           'type'=>implode($v->errors()->get('type')),
           'imgs'=>$img_err,
           ];
}
echo json_encode([$_REQUEST,'success'=>$success, 'error'=>$error]);
?>