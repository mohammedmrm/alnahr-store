<?php
ob_start();
session_start();
error_reporting(0);
require("_access.php");
access([1,2,3,5]);
require_once("dbconnection.php");


require("../config.php");

$city = $_REQUEST['city'];
$customer = $_REQUEST['customer'];
$order = $_REQUEST['order_no'];
$client= $_REQUEST['client'];
$store= $_REQUEST['store'];
$driver = $_REQUEST['driver'];
$invoice= $_REQUEST['invoice'];
$status = $_REQUEST['orderStatus'];
$print = $_REQUEST['print'];
$ids = $_REQUEST['ids'];
$assignStatus = $_REQUEST['assignStatus'];
$islimited = $_REQUEST['islimited'];
$repated = $_REQUEST['repated'];
$limit = $_REQUEST['limit'];

if(empty($limit) || $limit > 100){
  $limit = 100;
}
$sort ="";
$page = trim($_REQUEST['p']);
if(empty($page) || $page <=0){
  $page =1;
}

$start = trim($_REQUEST['start']);
$end = trim($_REQUEST['end']);
if($city == 1){
  $dev_p = $config['dev_b'];
}else{
  $dev_p = $config['dev_o'];
}
$reportType = $_REQUEST['reportType'];
if($reportType != 1 && $reportType !=2 && $reportType!=3 ){
   $reportType = 1;
}
$pageDir = $_REQUEST['pageDir'];
if($pageDir != 'L' && $pageDir !='P' ){
   $pageDir = 'L';
}
$space = $_REQUEST['space'];
if($space < 0 || $space > 30 || empty($space)){
   $space = 10;
}
$fontSize = $_REQUEST['fontSize'];
if($fontSize < 5 || $fontSize > 100 || empty($fontSize)){
   $fontSize = 12;
}

$sty= <<<EOF
<style>
  .title {
    background-color: #ddd;
  }
  .head-tr {
   background-color: #ddd;
   color:#111;
  }
  .col-50 {
      position: relative;
      display: inline-block;
      width:180px;
  }
  .client {
        position: relative;
      display: inline-block;
      width:180px;
  }
  .albarq {
    color :red;

  }
</style>
EOF;
$total = [];
$money_status = trim($_REQUEST['money_status']);
if(!empty($end)) {
   $end =date('Y-m-d', strtotime($end. ' + 1 day'));
}else{
  $end =date('Y-m-d', strtotime(' + 1 day'));
}

try{
  $count = "select count(*) as count,
               SUM(IF (city_id = 1,1,0)) as  b_orders,
               SUM(IF (city_id > 1,1,0)) as  o_orders
            from orders
            left join stores on  stores.id = orders.store_id
            left join (
             select order_no,count(*) as rep from orders
              GROUP BY order_no
              HAVING COUNT(orders.id) > 1
            ) b on b.order_no = orders.order_no
           ";
  $query = "select orders.*,count(order_items.id) as items, date_format(orders.date,'%Y/%m/%d') as dat,
            stores.name as store_name, companies.logo as logo,
            cites.name as city ,towns.name as town,staff.name as driver_name,clients.phone as client_phone
            from orders
            left join cites on  cites.id = orders.city_id
            left join towns on  towns.id = orders.town_id
            left join staff on  staff.id = orders.mandop_id
            left join stores on  stores.id = orders.store_id
            left join clients on  stores.client_id = clients.id
            left join companies on  companies.id = orders.delivery_company_id
            left join order_items on  order_items.order_id = orders.id
            left join (
             select order_no,count(*) as rep from orders
              GROUP BY order_no
              HAVING COUNT(orders.id) > 1
            ) b on b.order_no = orders.order_no
            ";
   $where = "where";
   $filter = " and orders.confirm = 1 and orders.company_id=".$_SESSION['company_id'];

  if($driver >= 1){
   $filter .= " and driver_id =".$driver;
  }
  if($print == 1){
    $filter .= " and orders.print = 0";
  }else if($print == 2){
     $filter .= " and orders.print > 0";
  }
  ////---select orders olny
  if(count($ids) > 0){
      $a = 0;
      foreach($ids as $id){
        if($a==0){
          $f = " orders.id =".$id;
        }else{
          $f .= " or orders.id =".$id;
        }
        $a++;
     }
     $f = " and ( ".$f." )";
  }
  $filter .= $f;

  ///------if reparted
  if($repated == 1){
   $filter .= " and b.rep >= 2";
  }else if($repated == 2){
   $filter .= " and b.rep == null";
  }
  if($assignStatus == 1){
     $filter .= " and (bar_code = 0 or bar_code is NULL)";
  }else if($assignStatus == 2){
    $filter .= " and bar_code <> 0";
  }
  if($invoice == 1){
    $filter .= " and (orders.invoice_id ='' or orders.invoice_id =0)";
  }else if($invoice == 2){
    $filter .= " and (orders.invoice_id !='' and orders.invoice_id != 0)";
  }
  if($city >= 1){
    $filter .= " and city_id=".$city;
  }
  if(($money_status == 1 || $money_status == 0) && $money_status !=""){
    $filter .= " and money_status='".$money_status."'";
  }
  if($client >= 1){
    $filter .= " and stores.client_id=".$client;
  }
  if($store>= 1){
    $filter .= " and store_id=".$store;
  }
  if(!empty($customer)){
    $filter .= " and (customer_name like '%".$customer."%' or
                      customer_phone like '%".$customer."%')";
  }
  if(!empty($order)){
    $filter .= " and orders.order_no like '%".$order."%'";
  }
  if($status >= 1){
    $filter .= " and order_status_id =".$status;
  }
  if($status == 4 || $status == 9){
    $filter .= " or order_status_id = 6";
  }
  function validateDate($date, $format = 'Y-m-d')
    {
        $d = DateTime::createFromFormat($format, $date);
        return $d && $d->format($format) == $date;
    }
  if(validateDate($start) && validateDate($end)){
      $filter .= " and orders.date between '".$start."' AND '".$end."'";
     }
     if($islimited == 1){
       $limit = " limit ".(($page-1) * $limit).",".$limit;
     }else{
       $limit = "";
     }
  if($filter != ""){
    $filter = preg_replace('/^ and/', '', $filter);
    $filter = $where." ".$filter;
    $count .= " ".$filter;
    $query .= " ".$filter." group by orders.id order by city_id,town_id,orders.id" . $limit;
  }else{
    $query .=" group by orders.id order by orders.date DESC ". $limit;;
  }
  $count = getData($con,$count);
  $orders = $count[0]['count'];
  $total['b_orders'] = $count[0]['b_orders'];
  $total['o_orders'] = $count[0]['o_orders'];
  $datas = getData($con,$query);
  $success="1";

} catch(PDOException $ex) {
   $datas=["error"=>$ex];
   $success="0";
}

require_once("../tcpdf/tcpdf.php");
require_once("../tcpdf/tcpdf.php");
class MYPDF extends TCPDF {
    public function Footer() {
        // Position at 15 mm from bottom
        $this->SetY(-10);
        // Set font
        $this->SetFont('aealarabiya', 'I', 12);
        // Page number
        $this->writeHTML('<hr><span style="text-align: right;color:#444444;">يسقط حق المطالبة بالوصل بعد مرور شهر من تاريخ الوصل</span>');
    }
     public function Header() {
        // Set font

    }
}

$pdf = new MYPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
foreach($datas as $data){

$type = "";
$products="";
$sql = "select category.title as cat_name from order_items
LEFT join configurable_product on configurable_product.id = order_items.configurable_product_id
left join product on configurable_product.product_id = product.id
left join category on product.category_id = category.id where order_items.order_id = ? GROUP by category.id";
$cats = getData($con,$sql,[$data['id']]);
foreach($cats as $cat){
  $type .= $cat['cat_name'].",  ";
}
$sql  = "select * from order_items
LEFT join configurable_product on configurable_product.id = order_items.configurable_product_id
where order_items.order_id=?";
$items = getData($con,$sql,[$data['id']]);
$i=1;
foreach($items as $item){
  $products .= $i."-".$item['sub_name']."<br />";
  $i++;
}
$sql = "update orders set print = print +1 where orders.id=?";
setData($con,$sql,[$data['id']]);
// set document information
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('07822816693');
$pdf->SetTitle('وصل');
$pdf->SetSubject('Receipt');
// set some language dependent data:
$lg = Array();
$lg['a_meta_charset'] = 'UTF-8';
$lg['a_meta_dir'] = 'rtl';
$lg['a_meta_language'] = 'ar';
$lg['w_page'] = 'page';

// set some language-dependent strings (optional)
$pdf->setLanguageArray($lg);
// set font
$pdf->SetFont('aealarabiya', '', 12);

// set default header data

// set header and footer fonts
$pdf->setHeaderFont(Array('aealarabiya', '', 12));
//$pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));


// set margins
$pdf->SetMargins(10, 5,10,10);
$pdf->SetHeaderMargin(5);
//$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);
// set auto page breaks
$pdf->SetAutoPageBreak(TRUE, 5);

// set image scale factor
$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);



// ---------------------------------------------------------
//print_r($datas);
if($data['city_id'] == 1){
  $dev_p = $config['dev_b'];
}else{
  $dev_p = $config['dev_o'];
}
$pdf->SetFont('dejavusans', '', 12);
$pdf->setRTL(true);
// add a page
$pdf->AddPage('P', 'A5');

// Title
if($data['delivery_company_id'] != 0){
  $logo = '../img/logos/companies/'.$data['logo'];
}else{
  $logo = "../".$config['Company_logo'];
}
// Persian and English content
//<td width="209">هاتف العميل : '.$data['client_phone'].'</td>
$tbl = '<table >
           <tr>
                  <td align="right">
                  <br /><br /><br />   &nbsp;<b>'.$data['order_no'].'</b>
                  </td>
                  <td align="left">
                    <img src="'.$logo.'" height="80px"/>
                  </td>
           </tr>
          </table>
<table  cellpadding="5" >

  <tr>
    <td  colspan="2">اسم المتجر : '.$data['store_name'].'</td>
  </tr>
  <tr class="title">
    <td >رقم الوصل : '.$data['order_no'].'</td>
    <td>تاريخ : '.$data['dat'].'</td>
  </tr>
</table> <br /><br />
<table  border="1" cellpadding="5" style="border-color:gray;border-radius:10">
    <tr>
    <td class="title">اسم الزبون</td>
    <td align="center">'.$data['customer_name'].'</td>
  </tr>
  <tr>
    <td class="title">هاتف الزبون</td>
    <td align="center" >'.$data['customer_phone'].'</td>
  </tr>
</table>
<br /><br />
<table cellpadding="5" >
    <tr>
        <td  align="center" class="title">عنوان الزبون</td>
    </tr>
    <tr>
        <td colspan="1"  align="center">'.$data['city'].' - '.$data['town'].' - '.$data['address'].'</td>
    </tr>
    <tr>
        <td  align="center" class="title">المنتجات</td>
    </tr>
    <tr>
        <td colspan="1" height="150">'.$products.'</td>
    </tr>
</table>
<br /><br />
<table  border="1" cellpadding="5">
  <tr>
    <td colspan="1"  class="title">نوع المنتج</td>
    <td colspan="1" width="200" align="center" >'.$type.'</td>
    <td colspan="1" width="44" class="title">العدد</td>
    <td colspan="1" width="45" align="center" >'.$data['items'].'</td>
    <td colspan="1" width="44" class="title">الوزن</td>
    <td colspan="1" width="45" align="center" > 1</td>
  </tr>
  <tr>
    <td colspan="1" class="title">ملاحظات</td>
    <td colspan="5" align="center" >'.$data['note'].'</td>
  </tr>
  <tr>
    <td colspan="1" width="120"class="title">المبلغ مع التوصيل</td>
    <td colspan="4" align="center"><b>'.number_format($data['total_price']+$dev_p-$data['discount']).' دينار</b></td>
  </tr>
</table>
';


$pdf->writeHTML($sty.$tbl, true, false, false, false, '');
$htmlpersian = $hcontent;
$pdf->Ln();
$pdf->SetFont('aealarabiya', '', 10);
//$pdf->writeHTML($style.$comp, true, false, false, false, '');
// set LTR direction for english translation
$pdf->setRTL(true);

$pdf->SetFontSize(10);
$id =
'
{
    "data":{
      "id":'.'"'.$data['id'].'",'.
      '"order_no":'.'"'.$data['order_no'].'",'.
      '"city_id":'.'"'.$data['city_id'].'",'.
      '"town_id":'.'"'.$data['town_id'].'",'.
      '"city":'.'"'.$data['city'].'",'.
      '"town":'.'"'.$data['town'].'",'.
      '"address":'.'"'.$data['address'].'",'.
      '"customer_name":'.'"'.$data['customer_name'].'",'.
      '"customer_phone":'.'"'.$data['customer_phone'].'",'.
      '"price":'.'"'.$data['price']+$dev_p-$data['discount'].'",'.
      '"note":'.'"'.$data['note'].'"
    }
}
';
// print newline
$style = array(
    'position' => 'L',
    'align' => 'L',
    'stretch' => false,
    'fitwidth' => false,
    'cellfitalign' => '',
    'border' => false,
    'hpadding' => 'auto',
    'vpadding' => 'auto',
    'fgcolor' => array(0,0,0),
    'bgcolor' => "",
    'text' => true,
    'label' => $id,
    'font' => 'helvetica',
    'fontsize' => 12,
    'stretchtext' => 1
);
if($data['bar_code'] == null || empty($data['bar_code']) ){
  $data['bar_code'] = "00000";
}
$style2 = array(
    'position' => 'L',
    'align' => 'L',
    'stretch' => false,
    'fitwidth' => ture,
    'cellfitalign' => '',
    'border' => false,
    'hpadding' => '0',
    'vpadding' => '0',
    'fgcolor' => array(150,40,150),
    'bgcolor' => "",
    'text' => true,
    'label' => $data['bar_code'],
    'font' => 'helvetica',
    'fontsize' => 12,
    'stretchtext' => 1
);
// CODE 39 - ANSI MH10.8M-1983 - USD-3 - 3 of 9.
$pdf->write1DBarcode($data['bar_code'], 'C39', 0, 180, 120, 18, 0.4, $style2, 'N');
$pdf->SetTextColor(25,25,112);
$pdf->SetFont('aealarabiya', '', 9);

$pdf->SetTextColor(55,55,55);
//$pdf->setRTL(false);
$pdf->SetFont('aealarabiya', '', 10);
//$del = "<br /><hr />صممم و طور من قبل شركة <b><u>النهر</u></b> للحلول البرمجية<br /> 07722877759";
//$pdf->writeHTML($del, true, false, false, false, '');
//$pdf->write2DBarcode($id, 'QRCODE,M',0, 0, 30, 30, $style, 'N');
$style['position'] = '';
$pdf->setRTL(false);
//$pdf->write2DBarcode($id, 'QRCODE,M',10, 0, 30, 30, $style, 'N');
}

//Close and output PDF document
//print($id);
ob_end_clean();

$pdf->Output('Receipt'.date('Y-m-d h:i:s').'.pdf', 'I');
?>