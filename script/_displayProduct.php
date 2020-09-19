<?php
session_start();
//error_reporting(0);
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
$id    = $_REQUEST['id'];

if($id > 0) {
  $sql = 'update product set display = 1 where id=?';
  $result = setData($con,$sql,[$id]);
  if($result > 0){
    $success = 1;
  }
}
echo json_encode(['success'=>$success]);
?>