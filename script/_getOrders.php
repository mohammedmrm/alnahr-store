<?php
session_start();
error_reporting(0);
header('Content-Type: application/json');
require_once("_access.php");
access([1,2,5,4,10]);
require_once("dbconnection.php");
require_once("../config.php");

//$branch = $_REQUEST['branch'];
$to_branch = $_REQUEST['to_branch'];
$city = $_REQUEST['city'];
$town = $_REQUEST['town'];
$customer = $_REQUEST['customer'];
$order = $_REQUEST['order_no'];
$store= $_REQUEST['store'];
$invoice= $_REQUEST['invoice'];
$status = $_REQUEST['orderStatus'];
$print = $_REQUEST['print'];
$driver = $_REQUEST['driver'];
$repated = $_REQUEST['repated'];
$assignStatus = $_REQUEST['assignStatus'];
$islimited = $_REQUEST['islimited'];
$start = trim($_REQUEST['start']);
$end = trim($_REQUEST['end']);
$limit = trim($_REQUEST['limit']);
if(empty($limit)){
  $limit = 10;
}
$sort ="";
$page = trim($_REQUEST['p']);
if(empty($page) || $page <=0){
  $page =1;
}
$total = [];
$money_status = trim($_REQUEST['money_status']);
if(!empty($end)) {
   $end =date('Y-m-d', strtotime($end. ' + 1 day'));
}else{
  $end =date('Y-m-d', strtotime(' + 1 day'));
}

try{
  $count = "select
              sum(total_price) as income,

              sum(
                     if(order_status_id = 9,
                         0,
                         if(orders.city_id = 1,
                               if(order_status_id=9,0,if(client_dev_price.price is null,(".$config['dev_b']." - discount),(client_dev_price.price - discount))),
                               if(order_status_id=9,0,if(client_dev_price.price is null,(".$config['dev_o']." - discount),(client_dev_price.price - discount)))
                          )
                      )
              ) as dev,

              sum(total_price -
                  (
                     if(order_status_id = 9,
                         0,
                         if(orders.city_id = 1,
                               if(order_status_id=9,0,if(client_dev_price.price is null,(".$config['dev_b']." - discount),(client_dev_price.price - discount))),
                               if(order_status_id=9,0,if(client_dev_price.price is null,(".$config['dev_o']." - discount),(client_dev_price.price - discount)))
                          )
                      )
                  )
              ) as client_price,
              sum(discount) as discount,
             count(*) as count
            from orders
            left join stores on  stores.id = orders.store_id
            left JOIN client_dev_price on client_dev_price.client_id = stores.client_id AND client_dev_price.city_id = orders.city_id
            left join (
             select order_no,count(*) as rep from orders
              GROUP BY order_no
              HAVING COUNT(orders.id) > 1
            ) b on b.order_no = orders.order_no";

  $query = "select orders.*,if(orders.city_id = 1,".$config['dev_b'].",".$config['dev_o'].") as dev_price, date_format(orders.date,'%Y-%m-%d') as date,if(companies.name is null,'غير محال',companies.name)as dev_comp_name,
            cites.name as city,towns.name as town,clients.phone as client_phone,mandop.name as mandop_name,
            order_status.status as status_name,staff.name as staff_name,b.rep as repated,stores.name as store_name
            from orders
            left join cites on  cites.id = orders.city_id
            left join towns on  towns.id = orders.town_id
            left join staff on  staff.id = orders.manager_id
            left join stores on  stores.id = orders.store_id
            left join clients on  clients.id = stores.client_id
            left join companies on  companies.id = orders.delivery_company_id
            left join staff  mandop on  mandop.id = orders.mandop_id
            left join order_status on  order_status.id = orders.order_status_id
            left join (
             select order_no,count(*) as rep from orders
              GROUP BY order_no
              HAVING COUNT(orders.id) > 1
            ) b on b.order_no = orders.order_no

            ";
  $where = "where";
  $filter = " and orders.confirm = 1 ";
  $filter = " and orders.company_id = ? ";
  if($branch >= 1){
   $filter .= " and from_branch =".$branch;
  }
  if($assignStatus == 1){
     $filter .= " and (bar_code = 0 or bar_code is NULL)";
  }else if($assignStatus == 2){
    $filter .= " and bar_code <> 0";
  }
  if($print == 1){
    $filter .= " and orders.print = 0";
  }else if($print == 2){
     $filter .= " and orders.print > 0";
  }
  if($to_branch >= 1){
   $filter .= " and to_branch =".$to_branch;
  }
  if($driver >= 1){
   $filter .= " and orders.driver_id =".$driver;
  }
  $sort = " order by orders.date DESC ";
  if($repated == 1){
   $filter .= " and b.rep >= 2";
  }else if($repated == 2){
   $filter .= " and b.rep < 2";

  }
  if($city >= 1){
    $filter .= " and orders.city_id=".$city;
  }
  if($town>= 1){
    $filter .= " and orders.town_id=".$town;
  }
  if(($money_status == 1 || $money_status == 0) && $money_status !=""){
    $filter .= " and orders.money_status='".$money_status."'";
  }
  if($store >= 1){
    $filter .= " and orders.store_id=".$store;
  }
  if($invoice == 1){
    $filter .= " and ((orders.invoice_id ='' or orders.invoice_id =0) or ((order_status_id=6 or order_status_id=5) and (orders.invoice_id2 ='' or orders.invoice_id2 =0)))";
  }else if($invoice == 2){
    $filter .= " and ((orders.invoice_id !='' and orders.invoice_id != 0))";
  }
  if(!empty($customer)){
    $filter .= " and (customer_name like '%".$customer."%' or
                      customer_phone like '%".$customer."%')";
  }
  if(!empty($order)){
    $filter .= " and orders.order_no like '%".$order."%'";
  }
  if($_SESSION['role'] == 10){
    $filter .= " and stores.client_id=".$_SESSION['userid'];
  }
  ///-----------------status
  if($status == 4){
    $filter .= " and (order_status_id =".$status." or order_status_id = 6 or order_status_id = 5)";
  }else if($status == 9){
    $filter .= " and (order_status_id =".$status." or order_status_id =11 or order_status_id = 6 or order_status_id = 5)";
  }else  if($status >= 1){
    $filter .= " and order_status_id =".$status;
  }
  //---------------------end of status
  function validateDate($date, $format = 'Y-m-d')
    {
        $d = DateTime::createFromFormat($format, $date);
        return $d && $d->format($format) == $date;
    }
  if(validateDate($start) && validateDate($end)){
      $filter .= " and orders.date between '".$start."' AND '".$end."'";
     }
  if($filter != ""){
    $filter = preg_replace('/^ and/', '', $filter);
    $filter = $where." ".$filter;
    $count .= " ".$filter;
    $query .= " ".$filter;
  }

  $count = getData($con,$count,[$_SESSION['company_id']]);
  $orders = $count[0]['count'];
  $pages= ceil($count[0]['count'] / $limit);
  $lim = " limit ".(($page-1) * $limit).",".$limit;

  $query .= $sort.$lim;
  $data = getData($con,$query,[$_SESSION['company_id']]);
  $success="1";
} catch(PDOException $ex) {
   $data=["error"=>$ex];
   $success="0";
}
try{

 $sqlt = "select

          sum(
                 if(order_status_id = 9,
                     0,
                     if(orders.city_id = 1,
                           if(client_dev_price.price is null,(".$config['dev_b']." - discount),(client_dev_price.price - discount)),
                           if(client_dev_price.price is null,(".$config['dev_o']." - discount),(client_dev_price.price - discount))
                      )
                  )
          ) as dev,
          sum(discount) as discount,
          count(orders.order_no) as orders
          from orders

          left JOIN stores on stores.id = orders.store_id
          left JOIN client_dev_price on client_dev_price.client_id = stores.client_id AND client_dev_price.city_id = orders.city_id
          left join (
             select order_no,count(*) as rep from orders
              GROUP BY order_no
              HAVING COUNT(orders.id) > 1
            ) b on b.order_no = orders.order_no
          ";

if($filter != ""){
    $filter = preg_replace('/^ and/', '', $filter);
    $sqlt .= " ".$filter;
}
 $total = getData($con,$sqlt,[$_SESSION['company_id']]);
 $total[0]['orders'] = $orders;
if($store >=1){
 $total[0]['store'] = $data[0]['store_name'];
}else{
 $total[0]['store'] = '<span class="text-danger">لم يتم تحديد صفحة</span>';
}
  $success="1";
} catch(PDOException $ex) {
   $total=["error"=>$ex];
   $success="0";
}
echo json_encode(array($query,"success"=>$success,"data"=>$data,'total'=>$count,"pages"=>$pages,"page"=>$page));
?>