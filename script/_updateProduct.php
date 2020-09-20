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
$id     = $_REQUEST['e_product_id'];
$name   = $_REQUEST['e_name'];
$des    = $_REQUEST['e_des'];
$simple_des= $_REQUEST['e_simple_des'];
$price  = $_REQUEST['e_price'];
$forall = $_REQUEST['e_price_forall'];
$imgs   = $_FILES['e_img'];



$v->addRuleMessage('isPrice', 'المبلغ غير صحيح');

$v->addRule('isPrice', function($value, $input, $args) {
  if(preg_match("/^(0|\d*)(\.\d{2})?$/",$value)){
    $x=(bool) 1;
  }
  return   $x;
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
    'des'        => [$des,        'max(3000)'],
    'simple_des' => [$simple_des, 'max(250)'],
    'price'      => [$price,      'required|isPrice'],
]);
$valid_file_extensions = array(".jpg", ".jpeg", ".png",".gif");
if(count($imgs['tmp_name']) > 0 && $imgs['size'][0] > 0){
$i = 0;
foreach($imgs["tmp_name"] as $val){
     if($imgs['size'][$i] == 0 || $imgs['size'][$i] >= "5088000"){
      $img_err =  " يجب تحميل صورة صالحة بحجم اقل من 5MB - (" . ($i+1).")";
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
   $img_err =  "";
}
if($v->passes() && $img_err =="") {
  try{
      if(count($imgs['tmp_name']) > 0 && $imgs['size'][0] > 0){
        $sql = "select * from images where product_id=?";
        $data = getData($con,$sql,[$id]);
        foreach($data as $oldimg){
           unlink('../img/product/'.$oldimg['path']);
        }
        $sql = "delete from images where product_id=?";
        $data = setData($con,$sql,[$id]);
        $i=0;
        foreach($imgs["tmp_name"] as $val){
            $imgid = uniqid();
            mkdir("../img/product/".$id."/", 0777);
            $ext = strrchr($imgs["name"][$i], ".");
            $destination = "../img/product/".$id."/".$imgid.$ext;
            $imgPath = $id."/".$imgid.$ext;
            if(move_uploaded_file($imgs["tmp_name"][$i], $destination)){
              $sql ="insert into images (product_id,path) values(?,?)";
              setData($con,$sql,[$id,$imgPath]);
              $x = 1;
            }

            $i++;
        }
      }
      $sql = "update product set name=? , des=? , simple_des=? , price=? where id=?";
      $res = setData($con,$sql,[$name,$des,$simple_des,$price,$id]);
      if($forall == "checked" || $forall == 1){
        $sql = "update configurable_product set price = ? where product_id=?";
        setData($con,$sql,[$price,$id]);
      }
      $success=1;
  }catch(PDOException $ex) {
   $msg=["error"=>$ex];
   $success="0";
  }
}else{
  $error = [
           'id'=> implode($v->errors()->get('id')),
           'name'=> implode($v->errors()->get('name')),
           'des'=> implode($v->errors()->get('dea')),
           'simple_des'=>implode($v->errors()->get('simple_des')),
           'price'=>implode($v->errors()->get('price')),
           'img'=>$img_err,
           ];
}
echo json_encode([$_POST,'success'=>$success, 'error'=>$error]);
?>