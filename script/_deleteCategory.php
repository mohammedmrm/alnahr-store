<?php
session_start();
error_reporting(0);
header('Content-Type: application/json');
require("_access.php");
access([1]);
$id= $_REQUEST['id'];
$success = 0;
$msg="";
require("dbconnection.php");

use Violin\Violin;
require_once('../validator/autoload.php');
$v = new Violin;

$v->validate([
    'id'    => [$id,'required|int']
    ]);

if($v->passes()){
         if($id == 1){
            $msg = "لايمكن حذف هذا التصنيف";
         }else{
         $sql = "select * from category where parent_id = ?";
         $result = getData($con,$sql,[$id]);
         foreach ($result as $val){
           $sql = "update product set category_id=1 where category_id=?";
           setData($con,$sql,[$val['id']]);

           $sql = "delete from category where id=?";
           setData($con,$sql,[$val['id']]);
         }

         $sql = "update product set category_id=1 where category_id=?";
         setData($con,$sql,[$id]);

         $sql = "delete from category where id=?";
         $result = setData($con,$sql,[$id]);
         if($result > 0){
            $success = 1;
         }else{
            $msg = "فشل الحذف";
         }
         }

}else{
  $msg = "فشل الحذف";
  $success = 0;
}
echo json_encode(['success'=>$success, 'msg'=>$msg]);
?>