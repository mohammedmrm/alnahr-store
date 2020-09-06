<?php
session_start();
error_reporting(0);
header('Content-Type: application/json');
require("_access.php");
access([1,2,3]);
require("dbconnection.php");
require("_crpt.php");

use Violin\Violin;
require_once('../validator/autoload.php');
$v = new Violin;


$success = 0;
$error = [];
$name    = $_REQUEST['config'];
$id    = $_REQUEST['attribute_id'];
$img   = $_FILES['img'];
$img_err =  "";
$valid_file_extensions = array(".jpg", ".jpeg", ".png");
if(isset($img['tmp_name'])) {
   if($img['size'] >= "2048000"){
      $img_err =  "صورة ذات حجم كبير";
   }else{
     $ext = strrchr($img["name"], ".");
     if(in_array($ext, $valid_file_extensions) && @getimagesize($img["tmp_name"]) !== false){
       $img_err =  "";
     }else{
      $img_err =  "صورة غير صالحة";
     }
   }
}
$v->addRuleMessages([
    'required' => 'الحقل مطلوب',
    'int'      => 'فقط الارقام مسموع بها',
    'min'      => 'قصير جداً',
    'max'      => 'مسموح ب {value} رمز كحد اعلى '
]);

$v->validate([
    'name'   => [$name, 'required|max(60)|min(1)'],
    'id'   => [$id, 'required|int'],
]);

if($v->passes() && $img_err ==  "") {
  if($img['size'] <= 0) {
    $imgPath = "default.jpg";
  }else{
    $imgName = uniqid();
    $ext = strrchr($img["name"], ".");
    mkdir("../img/attribute_config/".$id."/", 0700);
    $destination = "../img/attribute_config/".$id."/".$imgName.".jpg";
    $imgPath = $id."/".$imgName.$ext;
    move_uploaded_file($img["tmp_name"], $destination);
  }

  $sql = 'insert into attribute_config (attribute_id,value,img,company_id) values
                             (?,?,?,?)';
  $result = setData($con,$sql,[$id,$name,$imgPath,$_SESSION['company_id']]);
  if($result > 0){
    $success = 1;
  }
}else{
  $error = [
           'name'=> implode($v->errors()->get('name')),
           'id'=> implode($v->errors()->get('id')),
           ];
}
echo json_encode([$_FILES,'success'=>$success, 'error'=>$error,$_POST]);
?>