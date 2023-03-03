<?php
session_start();
error_reporting(0);
header('Content-Type: application/json');
require("_access.php");
access([1]);
$id = $_REQUEST['id'];
$success = 0;
$msg = "";
require("dbconnection.php");

use Violin\Violin;

require_once('../validator/autoload.php');
$v = new Violin;

$v->validate([
   'id'    => [$id, 'required|int']
]);

if ($v->passes()) {
   try {
      $sql = "delete from companies where id = ? and company_id=?";
      $result = setData($con, $sql, [$id, $_SESSION['company_id']]);
      if ($result > 0) {
         $success = 1;
      } else {
         $msg = "فشل الحذف";
      }
   } catch (PDOException $e) {
      $success = $e;
   }
} else {
   $msg = "فشل الحذف";
   $success = 0;
}
echo json_encode(['success' => $success, 'msg' => $msg]);
