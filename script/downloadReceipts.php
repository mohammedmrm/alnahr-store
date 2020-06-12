<?php
ini_set('max_execution_time', 2000);
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
$repated = $_REQUEST['repated'];
$start = trim($_REQUEST['start']);
$end = trim($_REQUEST['end']);

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
    background-color: #FFFACD;
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
            left join (
             select order_no,count(*) as rep from orders
              GROUP BY order_no
              HAVING COUNT(orders.id) > 1
            ) b on b.order_no = orders.order_no
           ";
  $query = "select orders.*,date_format(orders.date,'%Y-%m-%d') as dat,
            stores.name as store_name,
            cites.name as city ,towns.name as town,staff.name as driver_name
            from orders
            left join cites on  cites.id = orders.city_id
            left join towns on  towns.id = orders.town_id
            left join staff on  staff.id = orders.mandop_id
            left join stores on  stores.id = orders.store_id
            left join (
             select order_no,count(*) as rep from orders
              GROUP BY order_no
              HAVING COUNT(orders.id) > 1
            ) b on b.order_no = orders.order_no
            ";
   $where = "where";
   $filter = " and orders.confirm = 1";

  if($driver >= 1){
   $filter .= " and driver_id =".$driver;
  }

  if($repated == 1){
   $filter .= " and b.rep >= 2";
  }else if($repated == 2){
   $filter .= " and b.rep == null";
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
    $filter .= " and client_id=".$client;
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
  if($filter != ""){
    $filter = preg_replace('/^ and/', '', $filter);
    $filter = $where." ".$filter;
    $count .= " ".$filter;
    $query .= " ".$filter." order by city_id,town_id,orders.id";
  }else{
    $query .=" order by city_id,town_id,orders.id";
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

$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
foreach($datas as $data){
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
if($data['com_id'] != 0){
  $logo = '../../../img/'.$data['logo'];
}else{
  $logo = "../../../".$config['Company_logo'];
}
$pdf->SetHeaderData($logo,33,"");

// set header and footer fonts
$pdf->setHeaderFont(Array('aealarabiya', '', 12));
//$pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));


// set margins
$pdf->SetMargins(10, 30,10, 10);
$pdf->SetHeaderMargin(5);
//$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);
// set auto page breaks
$pdf->SetAutoPageBreak(TRUE, 5);

// set image scale factor
$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);



// ---------------------------------------------------------
//print_r($datas);

$pdf->SetFont('aealarabiya', '', 12);
$pdf->setRTL(true);
// add a page
$pdf->AddPage('P', 'A5');

// Persian and English content
$tbl = '
<table  cellpadding="5">
    <tr>
    <td width="209">اسم السوق : '.$data['store_name'].'</td>
  </tr>
  <tr>
    <td width="209" >رقم الوصل : '.$data['order_no'].'</td>
    <td width="209">تاريخ : '.$data['dat'].'</td>
  </tr>
</table>
<br />
<table  border="1" cellpadding="5">
    <tr>
    <td width="153" class="title">اسم الزبون</td>
    <td align="center" width="300">'.$data['customer_name'].'</td>
  </tr>
  <tr>
    <td width="153" class="title">هاتف الزبون</td>
    <td align="center" width="300">'.$data['customer_phone'].'</td>
  </tr>
</table>
<br /><br />
<table cellpadding="2" border="1">
    <tr>
        <td  align="center" class="title">العنوان</td>
    </tr>
    <tr>
        <td colspan="1" height="60" align="center">'.$data['city'].' - '.$data['town'].' - '.$data['address'].'</td>
    </tr>
</table>
<br /><br />
<table  border="1" cellpadding="5">
  <tr>
    <td colspan="6" class="title" align="center">تفاصيل الطلب</td>
  </tr>
  <tr>
    <td colspan="1"  class="title">النوع</td>
    <td colspan="1" align="center" >'.$data['order_type'].'</td>
    <td colspan="1"  class="title">الوزن</td>
    <td colspan="1" align="center" >'.$data['weight'].' كغم</td>
    <td colspan="1" class="title">العدد</td>
    <td colspan="1" align="center" >'.$data['qty'].'</td>
  </tr>
  <tr>
    <td colspan="1" class="title">ملاحظات</td>
    <td colspan="5" align="center" >'.$data['note'].'</td>
  </tr>
  <tr>
    <td colspan="2"  class="title">المبلغ مع التوصيل</td>
    <td colspan="4" align="center">'.number_format($data['price']).' دينار</td>
  </tr>
</table>
';
if($data['com_id'] != 0){
$comp = $data['text1']."<br />".$data['text2'].
"<br /><br /><span>* يسقط حق المطالبة بالوصال بعد مرور شهر من تاريخ الوصل </span>";
}else{
$comp = "
<span>* يسقط حق المطالبة بالوصال بعد مرور شهر من تاريخ الوصل </span>
";
}

$pdf->writeHTML($sty.$tbl, true, false, false, false, '');
$htmlpersian = $hcontent;
$pdf->cell('','','توقيع العميل','');
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
      '"price":'.'"'.$data['price'].'",'.
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
$style2 = array(
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
    'label' => $data['id'],
    'font' => 'helvetica',
    'fontsize' => 12,
    'stretchtext' => 1
);
// CODE 39 - ANSI MH10.8M-1983 - USD-3 - 3 of 9.
$pdf->write1DBarcode($data['id'], 'S25+', 0, '', 60, 20, 0.4, $style2, 'N');
$pdf->SetTextColor(25,25,112);
$pdf->SetFont('aealarabiya', '', 9);

$pdf->writeHTML("<br /><br /><hr>".$comp, true, false, false, false, '');
$pdf->SetTextColor(55,55,55);
$pdf->setRTL(false);
$pdf->SetFont('aealarabiya', '', 10);
$del = "<br /><hr />صممم و طور من قبل شركة <b><u>النهر</u></b> للحلول البرمجية<br /> 07722877759 , itpcentre@gamil.com, www.alnahr.net";
$pdf->writeHTML($del, true, false, false, false, '');
//$pdf->write2DBarcode($id, 'QRCODE,M',0, 0, 30, 30, $style, 'N');
$style['position'] = '';
$pdf->write2DBarcode($id, 'QRCODE,M',70, 130, 40, 40, $style, 'N');

}

//Close and output PDF document
//print($id);
ob_end_clean();

$pdf->Output('Receipt'.date('Y-m-d h:i:s').'.pdf', 'I');
?>