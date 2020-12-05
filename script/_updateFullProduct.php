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
$imgs   = $_FILES['e_img'];

//====configrable
$c_id  = $_REQUEST['c_id'];
$c_img  = $_FILES['c_img'];
$c_qty  = $_REQUEST['c_qty'];
$c_name = $_REQUEST['c_name'];
$c_sku  = $_REQUEST['c_sku'];
$c_price= $_REQUEST['c_price'];
$c_buy_price= $_REQUEST['c_buy_price'];
$c_location = $_REQUEST['c_location'];

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
$a = 0;
foreach($c_id as $cid){
  $v->validate([
      'id'         => [$id,         'required|int'],
      'name'       => [$name,       'required|min(2)|max(250)'],
      'des'        => [$des,        'max(3000)'],
      'simple_des' => [$simple_des, 'max(250)'],
      'price'      => [$price,      'required|isPrice'],
      'c_price'    => [$c_price[$a],    'required|isPrice'],
      'c_buy_price'=> [$c_buy_price[$a],'isPrice'],
      'c_name'     => [$c_name[$a],     'required|max(250)'],
      'c_sku'      => [$c_sku[$a],      'required|max(250)'],
      'c_location' => [$c_location[$a], 'max(250)'],
      'c_qty'      => [$c_qty[$a],      'int'],
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

///------configrable
if(count($c_img['tmp_name']) > 0 && $c_img['size'][0] > 0){
  $i = 0;
  foreach($c_img["tmp_name"] as $val){
       if($c_img['size'][$i] == 0 || $c_img['size'][$i] >= "5088000"){
        $c_img_err =  " يجب تحميل صورة صالحة بحجم اقل من 5MB - (" . ($i+1).")";
        break;
       }else{
         $ext = strrchr($c_img["name"][$i], ".");
         if(in_array($ext, $valid_file_extensions) && @getimagesize($c_img["tmp_name"][$i]) !== false){
           $c_img_err =  "";
         }else{
          $c_img_err =  "صورة غير صالحة ". ($i+1);
          break;
         }
       }
    $i++;
  }
  }else{
     $img_err =  "";
  }
  if(!$v->passes() || $img_err !="" || $c_img_err !="") {
    break;
  }
$a++;
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
      if($res){
       $success=1;
      }
      $a=0;
      foreach($c_id as $cid){
        $sql = "select * from configurable_product where id=?";
        $res = getData($con,$sql,[$cid]);
          if(count($c_img['tmp_name']) > 0 && $c_img['size'][$a] > 0){
                unlink('../img/product/'.$res[0]['img']);
                $imgid = uniqid();
                mkdir("../img/product/".$id."/", 0777);
                $ext = strrchr($c_img["name"][$a], ".");
                $destination = "../img/product/".$id."/".$imgid.$ext;
                $imgPath = $id."/".$imgid.$ext;
                if(move_uploaded_file($c_img["tmp_name"][$a], $destination)){
                  $sql ="update configurable_product set img = ? where id=?";
                  setData($con,$sql,[$imgPath,$cid]);
                  $x = 1;
                }
           }
            $sql = "update configurable_product set price=? , buy_price=?, sku=? , sub_name=? ,location=? , qty=? where id=?";
            $result = setData($con,$sql,[$c_price[$a],$c_buy_price[$a],$c_sku[$a],$c_name[$a],$c_location[$a],$c_qty[$a],$cid]);
            if($result){
              $success=1;
            }
        $a++;
      }
  }catch(PDOException $ex) {
   $msg=["error"=>$ex];
   $success="0";
  }
}else{
  $error = [
           "count"=>$a,
           'id'=> implode($v->errors()->get('id')),
           'name'=> implode($v->errors()->get('name')),
           'des'=> implode($v->errors()->get('dea')),
           'simple_des'=>implode($v->errors()->get('simple_des')),
           'price'=>implode($v->errors()->get('price')),
           'c_price'=>implode($v->errors()->get('c_price')),
           'c_buy_price'=>implode($v->errors()->get('c_buy_price')),
           'c_name'=>implode($v->errors()->get('c_name')),
           'c_sku'=>implode($v->errors()->get('c_sku')),
           'c_qty'=>implode($v->errors()->get('c_qty')),
           'c_location'=>implode($v->errors()->get('c_location')),
           'img'=>$img_err,
           'c_img'=>$c_img_err,
           ];
}
echo json_encode([$_REQUEST,$msg,'success'=>$success, 'error'=>$error]);
?>