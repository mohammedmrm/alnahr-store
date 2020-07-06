<?php
session_start();
error_reporting(0);
header('Content-Type: application/json');
require("_access.php");
access([1,2]);
require("dbconnection.php");
require("_crpt.php");

use Violin\Violin;
require_once('../validator/autoload.php');
$v = new Violin;
$success = 0;
$error = [];
$id        = $_REQUEST['e_product_id'];
$name      = $_REQUEST['e_name'];
$sku    = $_REQUEST['e_sku'];
$location     = $_REQUEST['e_location'];
$qty    = $_REQUEST['e_qty'];
$price  = $_REQUEST['e_price'];
$buy_price = $_REQUEST['e_buy_price'];



$v->addRuleMessage('unique', 'القيمة المدخلة مستخدمة بالفعل ');

$v->addRule('unique', function($value, $input, $args) {
    $exists = getData($GLOBALS['con'],"SELECT * FROM configurable_product WHERE sku ='".$value."' and id !='".$GLOBALS['id']."'");
    return  ! (bool) count($exists);
});
$v->addRuleMessages([
    'required' => 'الحقل مطلوب',
    'int'      => 'فقط الارقام مسموع بها',
    'regex'      => 'فقط الارقام مسموح بها',
    'min'      => 'قصير جداً',
    'max'      => 'مسموح ب 250 رمز كحد اعلى ',
    'email'      => 'البريد الالكتروني غيز صحيح',
]);

$v->validate([
    'id'         => [$id,         'required|int'],
    'name'       => [$name,       'required|min(2)|max(250)'],
    'sku'        => [$sku,        'required|unique|min(2)|max(250)'],
    'location'   => [$location,   "required|min(2)|max(250)"],
    'qty'        => [$qty,        "required|int"],
    'price'      => [$price,      'required'],
    'buy_price'  => [$buy_price,  'required']
]);
$valid_file_extensions = array(".jpg", ".jpeg", ".png");
if(isset($_FILES['e_img']['tmp_name']) && $_FILES['e_img']['size'] != 0) {
   if($_FILES['e_img']['size'] >= "2048000"){
    $img_err =  "يجب تحميل صورة صالحة بحجم اقل من 2M";
   }else{
     $ext = strrchr($_FILES['e_img']["name"], ".");
     if(in_array($ext, $valid_file_extensions) && @getimagesize($_FILES["e_img"]["tmp_name"]) !== false){
       $img_err =  "";
     }else{
      $img_err =  "صورة غير صالحة";
     }
   }
} else {
   $img_err =  "";
}

if($v->passes() && $img_err =="") {
    $sql = "select * from configurable_product where id=?";
    $data = getData($con,$sql,[$id]);
    $oldimg = $data[0]['img'];
    if(isset($_FILES['e_img']['tmp_name']) && $_FILES['e_img']['size'] != 0){
        $id1 = uniqid();
        mkdir("../img/product/".$id."/", 0700);
        $destination = "../img/product/".$id."/".$id1.$ext;
        $imgpath = $id."/".$id1.$ext;
        move_uploaded_file($_FILES['e_img']["tmp_name"], $destination);
        $sql = 'update configurable_product set  sub_name = ?, sku=?,qty=?,location=?,price=?,buy_price=?, img = ? where id=?';
        $result = setData($con,$sql,[$name,$sku,$qty,$location,$price,$buy_price,$imgpath,$id]);
        if($result > 0){
          $success = 1;
        }
     }else{
        $sql = 'update configurable_product set sub_name = ?, sku=?,qty=?,location=?,price=?,buy_price=? where id=?';
        $result = setData($con,$sql,[$name,$sku,$qty,$location,$price,$buy_price,$id]);
        if($result > 0){
          $success = 1;
        }
    }


}else{
  $error = [
           'id'=> implode($v->errors()->get('id')),
           'name'=> implode($v->errors()->get('name')),
           'sku'=> implode($v->errors()->get('sku')),
           'location'=>implode($v->errors()->get('location')),
           'qty'=>implode($v->errors()->get('qty')),
           'price'=>implode($v->errors()->get('price')),
           'buy_price'=>implode($v->errors()->get('buy_price')),
           'img'=>$img_err,
           ];
}
echo json_encode(['success'=>$success, 'error'=>$error,$_POST,$_FILES]);
?>