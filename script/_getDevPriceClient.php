<?php
session_start();
header('Content-Type: application/json');
require_once("dbconnection.php");
require_once("../config.php");
$id = $_REQUEST['id'];
$success = 0;
$i = 0;
try {
   $query = "select * from cites";
   $data = getData($con, $query);
   if (count($data) > 0) {
      $success = "1";
      foreach ($data as $k => $v) {
         $sql = "select * from client_dev_price where client_id=? and city_id=?";
         $res = getData($con, $sql, [$id, $v['id']]);
         if (count($res) == 0 && $v['id'] == 1) {
            $dev = $config['dev_b'];
            $devTown = $config['dev_b'] + $config['countrysidePrice'];
         } else if (count($res) == 0 && $v['id'] != 1) {
            $dev = $config['dev_o'];
            $devTown = $config['dev_o'] + $config['countrysidePrice'];
         } else {
            $dev = $res[0]['price'];
            $devTown = $res[0]['town_price'];
         }
         $result[$i] = [
            'city' => $v['name'],
            'city_id' => $v['id'],
            'price' => $dev,
            'town_price' => $devTown,
         ];
         $i++;
      }
   }
} catch (PDOException $ex) {
   $data = ["error" => $ex];
   $success = "0";
}
echo json_encode(array("success" => $success, "data" => $result, $query));
