<?php
ob_start();
session_start();
error_reporting(0);
require("_access.php");
access([1,2,3,5]);
require_once("dbconnection.php");


require("../config.php");

$id=$_REQUEST['id'];

if($city == 1){
  $dev_p = $config['dev_b'];
}else{
  $dev_p = $config['dev_o'];
}


$sty= <<<EOF
<style>
  .title {
    background-color: #FFA6A6;
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

  $query = "select orders.*,count(order_items.id) as items,date_format(orders.date,'%Y-%m-%d') as dat,
            stores.name as store_name, companies.logo as logo,
            cites.name as city ,towns.name as town,clients.phone as client_phone
            from orders
            left join cites on  cites.id = orders.city_id
            left join towns on  towns.id = orders.town_id
            left join staff on  staff.id = orders.mandop_id
            left join stores on  stores.id = orders.store_id
            left join clients on  stores.client_id = clients.id
            left join companies on  companies.id = orders.delivery_company_id
            left join order_items on  order_items.order_id = orders.id
            where orders.id = ? group by orders.id";

  $datas = getData($con,$query,[$id]);
  $success="1";

} catch(PDOException $ex) {
   $datas=["error"=>$ex];
   $success="0";
}

require_once("../tcpdf/tcpdf.php");
class MYPDF extends TCPDF {
    public function Footer() {
        // Position at 15 mm from bottom
        $this->SetY(-10);
        // Set font
        $this->SetFont('aealarabiya', 'I', 10);
        // Page number
        $this->writeHTML('<hr><span style="text-align: right;color:#003399">يسقط حق المطالبة بالوصال بعد مرور شهر من تاريخ الوصل</span>');
    }
}
$pdf = new MYPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
foreach($datas as $data){

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
foreach($items as $item){
  $products .= $item['sub_name']." | ";
}
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
if($data['delivery_company_id'] != 0){
  $logo = '../../../img/logos/companies/'.$data['logo'];
}else{
  $logo = "../../../".$config['Company_logo'];
}
$pdf->SetHeaderData($logo,30,"");

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
if($data['city_id'] == 1){
  $dev_p = $config['dev_b'];
}else{
  $dev_p = $config['dev_o'];
}
$pdf->SetFont('aealarabiya', '', 12);
$pdf->setRTL(true);
// add a page
$pdf->AddPage('P', 'A5');

// Persian and English content
$tbl = '
<table  cellpadding="5">
    <tr>
    <td width="209">اسم الصفحه : '.$data['store_name'].'</td>
    <td width="209">هاتف العميل : '.$data['client_phone'].'</td>
  </tr>
  <tr>
    <td width="209" >رقم الوصل : '.$data['order_no'].'</td>
    <td width="209">تاريخ : '.$data['dat'].'</td>
  </tr>
</table>
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
        <td colspan="1"  align="center">'.$data['city'].' - '.$data['town'].' - '.$data['address'].'</td>
    </tr>
    <tr>
        <td  align="center" class="title">المنتجات</td>
    </tr>
    <tr>
        <td colspan="1" height="100">'.$products.'</td>
    </tr>
</table>
<table  border="1" cellpadding="5">
  <tr>
    <td colspan="6" class="title" align="center">تفاصيل الطلب</td>
  </tr>
  <tr>
    <td colspan="1"  class="title">النوع</td>
    <td colspan="1" width="238" align="center" >'.$type.'</td>
    <td colspan="1" width="35" class="title">الوزن</td>
    <td colspan="1" width="35"align="center" > 1</td>
    <td colspan="1" width="35"class="title">العدد</td>
    <td colspan="1" width="35"align="center" >'.$data['items'].'</td>
  </tr>
  <tr>
    <td colspan="1" class="title">ملاحظات</td>
    <td colspan="5" align="center" >'.$data['note'].'</td>
  </tr>
  <tr>
    <td colspan="1" width="110"class="title">المبلغ مع التوصيل</td>
    <td colspan="4" align="center">'.number_format($data['total_price']+$dev_p-$data['discount']).' دينار</td>
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
    'fgcolor' => array(111,11,111),
    'bgcolor' => "",
    'text' => true,
    'label' => $data['bar_code'],
    'font' => 'helvetica',
    'fontsize' => 12,
    'stretchtext' => 1
);
// CODE 39 - ANSI MH10.8M-1983 - USD-3 - 3 of 9.
$pdf->write1DBarcode($data['bar_code'], 'C39', 0, 185, 100, 15, 0.5, $style2, 'N');
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
$pdf->write2DBarcode($id, 'QRCODE,M',10, 0, 30, 30, $style, 'N');

}

//Close and output PDF document
//print($id);
ob_end_clean();

$pdf->Output('Receipt'.date('Y-m-d h:i:s').'.pdf', 'I');
?>