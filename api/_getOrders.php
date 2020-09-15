<?php
session_start();
header('Content-Type: application/json');
require_once("_apiAccess.php");
access();
error_reporting(0);
require_once("../script/dbconnection.php");

$city = $_REQUEST['city'];
$money_status = $_REQUEST['money_status'];
$store = $_REQUEST['citystore'];
$invoice = $_REQUEST['invoice'];
$customer = $_REQUEST['customer'];
$order = $_REQUEST['order'];
$status = $_REQUEST['status'];
$where = "";
$filter = "";
$success = 0 ;
$limit = trim($_REQUEST['limit']);
if(empty($limit) || $limit <=0){
  $limit=10;
}
$page = trim($_REQUEST['page']);
if(empty($page) || $page <=0){
  $page=1;
}


require_once("../config.php");
$query = "select orders.*, date_format(orders.date,'%Y-%m-%d') as date,
                            ((if(earnings_fix is null,0,earnings_fix)) + ((if(earnings_total is null,0,earnings_total/100)) * orders.total_price)) as mandop_earnings,
                            cites.name as city,towns.name as town,clients.phone as client_phone,mandop.name as mandop_name,
                            order_status.status as status_name,staff.name as staff_name,stores.name as store_name
                            from orders
                            left join cites on  cites.id = orders.city_id
                            left join towns on  towns.id = orders.town_id
                            left join staff on  staff.id = orders.manager_id
                            left join stores on  stores.id = orders.store_id
                            left join clients on  clients.id = stores.client_id
                            left join staff  mandop on  mandop.id = orders.mandop_id
                            left join order_status on  order_status.id = orders.order_status_id
                            left join mandop_stores on  mandop_stores.store_id = stores.id and  mandop_stores.mandop_id = orders.mandop_id
                            ";
                    $where = "where";
                    $filter = "orders.confirm = 1 and orders.mandop_id =" . $userid;
                    $sort = " order by orders.date DESC ";
                    if (city >= 1) {
                        $filter .= " and orders.city_id=" + city;
                    }
                    if (($money_status == 1 || $money_status == 0) && $money_status != "") {
                        $filter .= " and money_status='" . $money_status . "'";
                    }
                    if ($store >= 1) {
                        $filter += " and orders.store_id=" . $store;
                    }
                    if ($invoice == 1) {
                        $filter .= " and ((orders.invoice_id ='' or orders.invoice_id =0) or ((order_status_id=6 or order_status_id=5) and (orders.invoice_id2 ='' or orders.invoice_id2 =0)))";
                    } else if ($invoice == 2) {
                        $filter .= " and ((orders.invoice_id !='' and orders.invoice_id != 0))";
                    }
                    if ($customer) {
                        $filter .= " and (customer_name like '%" . $customer . "%' or customer_phone like '%" . $customer . "%') ";
                    }
                    if ($order) {
                        $filter .= " and orders.order_no like '%" . $order . "%'";
                    }
                    ///-----------------status
                    if ($status == 4) {
                        $filter .= " and (order_status_id =" . $status . " or order_status_id = 6 or order_status_id = 5)";
                    } else if ($status == 9) {
                        $filter .= " and (order_status_id =" . $status .  " or order_status_id =11 or order_status_id = 6 or order_status_id = 5)";
                    } else if ($status >= 1) {
                        $filter .= " and order_status_id =". $status ;
                    }
                    if ($filter != "") {
                        $filter = $where . " " . $filter;
                        $query .= " " . $filter;
                    }
                    $page = ($page - 1) * $limit;
                    $query .= ' limit ' .$page .','. $limit;
                    $data = getData($con,$query);
if(count($data) > 0){
    $success = 1;
}
echo (json_encode(array('code'=>200,'message'=>$msg,"success"=>$success,"data"=>$data),JSON_PRETTY_PRINT));
?>