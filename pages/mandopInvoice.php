<?php
if(file_exists("script/_access.php")){
require_once("script/_access.php");
access([1,2,5]);
}
?>
<?
include("config.php");
?>
<style>
fieldset {
		border: 1px solid #ddd !important;
		margin: 0;
		xmin-width: 0;
		padding: 10px;
		position: relative;
		border-radius:4px;
		background-color:#f5f5f5;
		padding-left:10px !important;
		width:100%;
}
legend
{
	font-size:14px;
	font-weight:bold;
	margin-bottom: 0px;
	width: 55%;
	border: 1px solid #ddd;
	border-radius: 4px;
	padding: 5px 5px 5px 10px;
	background-color: #ffffff;
}
.success {
 background-color: #CCFFCC;
}
.danger {
background-color: #FFCCCC;
}
.warning{
background-color: #FFFF99;
}

@media print {
  body * {
    visibility: hidden;

  }
  #printReportForm, .header{
    display: none;
  }

  #section-to-print, #section-to-print * {
    visibility: visible;
    color: #000000;

  }
  #section-to-print {
    //position: absolute;
    margin:0px;
    padding: 0px;
    left: 0;

  }
  .dele, .edit{
   visibility: hidden;
   display: none;
  }
}
.text-white {
  color: #FFFFFF;
  padding: 15px;
}

@page {
  size: landscape;
  margin: 5mm 5mm 5mm 5mm;
  }
</style>
<div class="kt-content  kt-grid__item kt-grid__item--fluid kt-grid kt-grid--hor" id="kt_content">

<!-- begin:: Subheader -->
<div class="kt-subheader   kt-grid__item" id="kt_subheader">
    <div class="kt-container  kt-container--fluid ">
        <div class="kt-subheader__toolbar">
            <div class="kt-subheader__wrapper">

            </div>
        </div>
    </div>
</div>
<!-- end:: Subheader -->
					<!-- begin:: Content -->
	<div class="kt-container  kt-container--fluid  kt-grid__item kt-grid__item--fluid">
<div class="kt-portlet kt-portlet--mobile">
	<div class="kt-portlet__head">
		<div class="kt-portlet__head-label">
			<h3 class="kt-portlet__head-title">
				الفواتير
			</h3>
		</div>
	</div>


	<div class="kt-portlet__body">
    <form id="mandopInvoicesForm" class="kt-form kt-form--fit kt-margin-b-20">
          <fieldset><legend>بحث عن كشف</legend>
          <div class="row kt-margin-b-20">
            <div class="col-lg-2 kt-margin-b-10-tablet-and-mobile">
            	<label>المندوب:</label>
            	<select onchange="" data-show-subtext="true" data-live-search="true"  class="selectpicker form-control kt-input" id="mandop" name="mandop" data-col-index="7">
            		<option value="">Select</option>
            	</select>
            </div>
            <div class="col-lg-3 kt-margin-b-10-tablet-and-mobile">
            	<label>حالة الطلبيات:</label>
            	<select onchange="" title="اختر الحالة" data-live-search="true" data-show-subtext="true"  class="selectpicker form-control kt-input" id="status" name="status[]" multiple data-actions-box="true">
            	</select>
            </div>
            <div class="col-lg-3 kt-margin-b-10-tablet-and-mobile">
            <label>الفترة الزمنية :</label>
            <div class="input-daterange input-group" id="kt_datepicker">
  				<input value="<?php echo date('Y-m-d', strtotime('-7 days'));?>" onchange="" type="text" class="form-control kt-input" name="start" id="start" placeholder="من" data-col-index="5">
  				<div class="input-group-append">
  					<span class="input-group-text"><i class="la la-ellipsis-h"></i></span>
  				</div>
  				<input onchange="" type="text" class="form-control kt-input" name="end"  id="end" placeholder="الى" data-col-index="5">
          	</div>
            </div>
            <div class="col-lg-2 kt-margin-b-10-tablet-and-mobile">
            	<label>بحث:</label><br />
            	<button type="button" onclick="getMandopInvoices();" type="text" class="btn btn-success" value="" placeholder="" data-col-index="0">بحث
                    <span id="search"  role="status"></span>
                </button>
            </div>
          <div class="kt-separator kt-separator--border-dashed kt-separator--space-md"></div>
          </div>
          </fieldset>

		<!--begin: Datatable -->
        <div class="" id="section-to-print">
        <div class="col-md-12" id="">
            <table class="table table-striped  table-bordered table-hover table-checkable responsive no-wrap" id="tb-orders">
			       <thead>
	  						<tr>
										<th>رقم الشحنه</th>
										<th>رقم الوصل</th>
										<th>تاريخ الطلب</th>
										<th>رقم المستلم</th>
										<th>العنوان</th>
										<th>مبلغ الوصل</th>
										<th>مبلغ المندوب</th>
                                        <th>حالة الطلب</th>

                            </tr>
                   </thead>
                   <tbody id="mandop_orders">
                   </tbody>
            </table>
        <hr>
        </div>
        <div class="col-md-12" id="mandop_data">


        </div>
        <hr />
    	<table class="table  table-bordered  responsive no-wrap" id="tb-invioces">
	       <thead>
 						<tr>
      						<th>#</th>
      						<th>رقم الفاتوره</th>
      						<th>اسم المندوب</th>
      						<th>رقم هاتف المندوب</th>
      						<th>التاريخ</th>
      						<th>الملف</th>
      						<th>حالة الكشف</th>
      						<th>تعديل</th>
  					</tr>
    	            </thead>
                  <tbody id="invoicesTable">
                  </tbody>
        </table>
		<div class="kt-section__content kt-section__content--border">
		<nav aria-label="...">
			<ul class="pagination" id="pagination">

			</ul>
        <input type="hidden" id="p" name="p" value="<?php if(!empty($_GET['p'])){ echo $_GET['p'];}else{ echo 1;}?>"/>
		</nav>
     	</div>
        </div>
        </form>
        <!--end: Datatable -->
	</div>

</div>

</div>
<!-- end:: Content -->
</div>

            <!--begin::Page Vendors(used by this page) -->
<script src="assets/plugins/custom/datatables/datatables.bundle.js" type="text/javascript"></script>
<script src="assets/js/pages/components/datatables/extensions/responsive.js" type="text/javascript"></script>
<script src="js/getMandops.js" type="text/javascript"></script>
<script src="js/getBraches.js" type="text/javascript"></script>
<script type="text/javascript">

function getorderStatus(elem){
$.ajax({
  url:"script/_getorderStatus.php",
  type:"POST",
  success:function(res){
   console.log(res);
   elem.html("");
   $.each(res.data,function(){
     bg ="";
     if(this.id == 4){
       bg ="#9CDE7C";
     }else if(this.id == 5){
       bg ="#FFFFAC";
     }else if(this.id == 9){
       bg ="#F2A69B";
     }else if(this.id == 4){
       bg ="";
     }else if(this.id == 4){
       bg ="";
     }
     elem.append(
       '<option style="background-color:'+bg+'" value="'+this.id+'">'+this.status +'</option>'
     );
     if(elem.attr('st') == 'st'){
       getorders();
     }
    });
    elem.selectpicker('refresh');
    },
   error:function(e){
    console.log(e);
  }
});
}
getorderStatus($("#status"));
function  getMandopInvoices(){
  $.ajax({
    url:"script/_getMandopDetails.php",
    type:"POST",
    data:$("#mandopInvoicesForm").serialize(),
    beforeSend:function(){
        $("#section-to-print").addClass('loading');

    },
    success:function(res){
      console.log(res);
      $("#section-to-print").removeClass('loading');
      $("#tb-orders").DataTable().destroy();
      $("#tb-invioces").DataTable().destroy();
      $("#mandop_orders").html("");
      $("#mandop_data").html("");
      $("#invoicesTable").html("");

      content ="";
      $.each(res.data,function(){
      content = content +
                       '<tr>'+
                          '<td>'+this.id+'</td>'+
                          '<td>'+this.order_no+'</td>'+
                          '<td>'+this.dat+'</td>'+
                          '<td>'+this.customer_phone+'</td>'+
                          '<td>'+this.city_name+'-'+this.town_name+'-'+this.address+'</td>'+
                          '<td>'+this.price+'</td>'+
                          '<td class="text-danger">'+this.mandop_price+'</td>'+
                          '<td>'+this.status_name+'</td>'+
                       '</tr>'
                   ;
      });
      $("#mandop_orders").append(content);
      var myTable= $('#tb-orders').DataTable({
          "oLanguage": {
            "sLengthMenu": "عرض_MENU_سجل",
            "sSearch": "بحث:"
          }
      });

      if(res.success == 1){
      $("#mandop_data").append(
        '<table class="table table-striped  table-bordered">'+
          '<tr>'+
            '<td>عدد الطلبيات</td>'+
            '<td>المبلغ الكلي</td>'+
            '<td>مبلغ التوصيل</td>'+
            '<td>الصافي للعميل</td>'+
            '<td>الصافي للمندوب</td>'+
            '<td>انشاء فاتوره</td>'+
          '</tr>'+
          '</tr>'+
            '<td>'+res.pay.orders+'</td>'+
            '<td>'+formatMoney(res.pay.income)+'</td>'+
            '<td>'+formatMoney(res.pay.dev)+'</td>'+
            '<td>'+formatMoney(res.pay.client_price)+'</td>'+
            '<td class="text-danger">'+formatMoney(res.pay.mandop_price)+'</td>'+
            '<td><button onclick="makeMandopInvoice()" type="button" class="btn btn-success">انشاء كشف</button></td>'+
          '</tr>'+
        '</table>'
      );
      }
     $.each(res.invoice,function(){
     bg = "";
     if(this.invoice_status == 1){
       invoice_status = "تم التحاسب";
       btn = '<button type="button" class="btn btn-danger" onclick="unpayInvoice('+this.id+')" >الغأ التحاسب</button>';
     }else{
       invoice_status = "لم يتم التحاسب";
       btn = '<button type="button" class="btn btn-success" onclick="payInvoice('+this.id+')">تم التحاسب</button>';

     }
      $("#invoicesTable").append(
       '<tr class="">'+
            '<td></td>'+
            '<td>'+this.id+'</td>'+
            '<td>'+this.mandop_name+'</td>'+
            '<td>'+this.mandop_phone+'</td>'+
            '<td>'+this.in_date+'</td>'+
            '<td><a href="mandop_invoice/'+this.path+'" target="_blank">تحميل ملف الفاتوره</a></td>'+
            '<td>'+invoice_status+'</td>'+
            '<td>'+
                btn+
                '<button type="button" class="btn btn-clean btn-link" onclick="deleteInvoice('+this.id+')" data-toggle="modal" data-target="#deleteOrderModal"><span class="flaticon-delete"></sapn></button>'+
            '</td>'+
        '</tr>');
     });
     var myTable= $('#tb-invioces').DataTable({
      "oLanguage": {
        "sLengthMenu": "عرض_MENU_سجل",
        "sSearch": "بحث:"
      },
      "order": [[ 1, "desc" ]],
      });
    },
    error:function(e){
     $("#section-to-print").removeClass('loading');
     console.log(e);
    }
  })
}
function makeMandopInvoice() {
 if(Number($("#mandop").val()) > 0){
        $.ajax({
            url:"script/_makeMandopInvoice.php",
            type:"POST",
            data: $("#mandopInvoicesForm").serialize(),
            beforeSend:function(){
               $("#mandop_data").addClass('loading');
            },
            success:function(res){
            $("#mandop_data").removeClass('loading');
            console.log(res);
                  if(res.success == 1){
                    getMandopInvoices();
                  }else{
                   Toast.warning("خطأ");
                  }
                },
                error:function(e){
                  $("#mandop_data").removeClass('loading');
                  console.log(e);
                }
              });
    }else{
      Toast.warning("يحب تحديد المندوب"+Number($("#mandop").val()));
    }
}

function deleteInvoice(id){
  if(confirm("هل انت متاكد من الحذف")){
      $.ajax({
        url:"script/_deleteMandopInvoice.php",
        type:"POST",
        data:{id:id},
        success:function(res){
         if(res.success == 1){
           Toast.success('تم الحذف');
           getMandopInvoices();
         }else{
           Toast.warning(res.msg);
         }
         console.log(res)
        } ,
        error:function(e){
          console.log(e);
        }
      });
  }

}
function payInvoice(id){
  if(confirm("هل انت متاكد من التحاسب على الكشف")){
      $.ajax({
        url:"script/_payMandopInvoice.php",
        type:"POST",
        data:{id:id},
        success:function(res){
         if(res.success == 1){
           Toast.success('تم التحاسب');
           getMandopInvoices();
         }else{
           Toast.warning(res.msg);
         }
         console.log(res)
        } ,
        error:function(e){
          console.log(e);
        }
      });
  }
}
function unpayInvoice(id){
  if(confirm("هل انت متاكد من الغأ دفع الكشف")){
      $.ajax({
        url:"script/_unpayMandopInvoice.php",
        type:"POST",
        data:{id:id},
        success:function(res){
         if(res.success == 1){
           Toast.success('تم الدفع');
           getMandopInvoices();
         }else{
           Toast.warning(res.msg);
         }
         console.log(res)
        } ,
        error:function(e){
          console.log(e);
        }
      });
  }
}
$( document ).ready(function(){
    $('#tb-orders').DataTable();
    $('#tb-invioces').DataTable();
    getMandops($("#mandop"));
    getMandopInvoices();
});

$('#start').datepicker({
    format: "yyyy-mm-dd",
    showMeridian: true,
    todayHighlight: true,
    autoclose: true,
    pickerPosition: 'bottom-left',
    defaultDate:'now'
});
$('#end').datepicker({
    format: "yyyy-mm-dd",
    showMeridian: true,
    todayHighlight: true,
    autoclose: true,
    pickerPosition: 'bottom-left',
    defaultDate:'now'
});
</script>