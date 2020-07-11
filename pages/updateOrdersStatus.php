<?php
if(file_exists("script/_access.php")){
require_once("script/_access.php");
access([1,2,5,3]);
}
?>
<style>
#ordersTableDiv {
min-height: 100px;
}

</style>
<div class="kt-content  kt-grid__item kt-grid__item--fluid kt-grid kt-grid--hor" id="kt_content">

<!-- begin:: Subheader -->
<div class="kt-subheader   kt-grid__item" id="kt_subheader">
    <div class="kt-container  kt-container--fluid ">

    </div>
</div>
<!-- end:: Subheader -->
					<!-- begin:: Content -->
	<div class="kt-container  kt-container--fluid  kt-grid__item kt-grid__item--fluid">
<div class="kt-portlet kt-portlet--mobile">
	<div class="kt-portlet__head">
		<div class="kt-portlet__head-label">
			<h3 class="kt-portlet__head-title">
			  الطلبيات
			</h3>
		</div>
	</div>

	<div class="kt-portlet__body">
		<!--begin: Datatable -->
        <form id="ordertabledata" class="kt-form kt-form--fit kt-margin-b-20">
          <fieldset><legend>فلتر</legend>
          <div class="row kt-margin-b-20">
            <div class="col-lg-2 kt-margin-b-10-tablet-and-mobile">
            	<label>الصفحه:</label>
            	<select onchange="" data-show-subtext="true" data-live-search="true"  class="selectpicker form-control kt-input" id="store" name="store" data-col-index="7">
            		<option value="">Select</option>
            	</select>
            </div>
            <div class="col-lg-2 kt-margin-b-10-tablet-and-mobile">
            	<label>الحالة:</label>
            	<select onchange="getorders()" class="form-control kt-input" id="orderStatus" name="orderStatus" data-col-index="7">
            		<option value="">Select</option>
            	</select>
            </div>
            <div class="col-lg-2 kt-margin-b-10-tablet-and-mobile">
            	<label>المحافظة المرسل لها:</label>
            	<select id="city" name="city" onchange="" class="form-control kt-input" data-col-index="2">
            		<option value="">Select</option>
                </select>
            </div>
            <div class="col-lg-2 kt-margin-b-10-tablet-and-mobile">
            	<label>حالة التكرار:</label>
                <select name="repated" onchange="" class="selectpicker form-control kt-input" data-col-index="2">
            		<option value="">عرض الكل</option>
            		<option value="1">عرض المكرر فقط</option>
            		<option value="2">عرض غير المكرر</option>
                </select>
            </div>
            <div class="col-lg-2 kt-margin-b-10-tablet-and-mobile">
            	<label>رقم الوصل:</label>
            	<input id="order_no" name="order_no" value="<?php if(!empty($_GET['order_no'])){ echo $_GET['order_no'];} ?>"  type="text" class="form-control kt-input" placeholder="" data-col-index="0">
            </div>
            <div class="col-lg-2 kt-margin-b-10-tablet-and-mobile">
            	<label>اسم او هاتف المستلم:</label>
            	<input name="customer" onkeyup="" type="text" class="form-control kt-input" placeholder="" data-col-index="1">
            </div>
            <div class="col-lg-2 kt-margin-b-10-tablet-and-mobile">
            	<label>المندوب:</label>
                <select id="driver" name="driver" data-show-subtext="true" data-live-search="true" onchange="getorders()" class="form-control kt-input" data-col-index="2">
            	</select>
            </div>
            <div class="col-lg-3 kt-margin-b-10-tablet-and-mobile">
            <label>الفترة الزمنية :</label>
            <div class="input-daterange input-group" id="kt_datepicker">
  				<input value="" onchange="" type="text" class="form-control kt-input" name="start" id="start" placeholder="من" data-col-index="5">
  				<div class="input-group-append">
  					<span class="input-group-text"><i class="la la-ellipsis-h"></i></span>
  				</div>
  				<input onchange="" type="text" class="form-control kt-input" name="end"  id="end" placeholder="الى" data-col-index="5">
          	</div>
            </div>
            <div class="col-lg-2 kt-margin-b-10-tablet-and-mobile">
            	<label>.</label> <br />
            	<input type="button" class="btn btn-success" value="بحث" id="updateStatues"  onclick="getorders()"/>
            </div>
          </div>
          </fieldset>
          <div class="row kt-margin-b-20">
            <div class="col-lg-3 kt-margin-b-10-tablet-and-mobile">
              	<label>عدد السجلات في الصفحة الواحدة</label>
              	<select onchange="getorders()" class="form-control selectpicker" name="limit" data-col-index="7">
                    <option value="10">10</option>
              		<option value="15">15</option>
              		<option value="20">20</option>
              		<option value="25">25</option>
              		<option value="30">30</option>
                    <option value="50">50</option>
                    <option value="100">100</option>
              	</select>
              </div>
            <div class="col-lg-2 kt-margin-b-10-tablet-and-mobile">
            	<label>تحديث الحاله الى:</label>
            	<select st='st'  class="form-control kt-input" onchange="setOrdersStatus()" id="setOrderStatus" name="setOrderStatus" data-col-index="7">
            		<option value="">Select</option>
            	</select>
            </div>
            <div class="col-lg-2 kt-margin-b-10-tablet-and-mobile">
            	<label>تحديث:</label> <br />
            	<input type="button" class="btn btn-success" value="تحديث" id="updateStatues"  onclick="updateOredrsStatus()"/>
            </div>
            <div class="col-lg-3 kt-margin-b-10-tablet-and-mobile">
                <br /><label class="fa-2x">عدد الطلبيات:&nbsp;</label><label class="fa-2x" id="total-orders"> 0 </label>
            </div>
          </div>
        <div id="ordersTableDiv" >
        <table class="table table-striped table-bordered table-hover  responsive nowarp" id="tb-orders">
			       <thead>
	  						<tr>
										<th>رقم الوصل</th>
                                        <th>مبلغ الوصل</th>
                                        <th>اسم و هاتف العميل</th>
										<th width="200px;">تـــــــــــحديث الحالــــــــــــــة</th>
										<th>المنتجات</th>
										<th>الحاله</th>
										<th>رقم هاتف المستلم</th>
										<th>عنوان المستلم</th>
										<th>المبلغ</th>
									    <th width="120px">التاريخ</th>
                                        <th>المدخل</th>
										<th>المندوب</th>
						   </tr>
      	            </thead>
                            <tbody id="ordersTable">
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
<input type="hidden" id="user_id" value="<?php echo $_SESSION['userid'];?>"/>
<input type="hidden" id="user_branch" value="<?php echo $_SESSION['user_details']['branch_id'];?>"/>
<input type="hidden" id="user_role" value="<?php echo $_SESSION['role'];?>"/>

<!--begin::Page Vendors(used by this page) -->
<script src="assets/plugins/custom/datatables/datatables.bundle.js" type="text/javascript"></script>

<!--begin::Page Scripts(used by this page) -->
<script src="assets/js/pages/components/datatables/extensions/responsive.js" type="text/javascript"></script>
<script src="js/getClients.js" type="text/javascript"></script>
<script src="js/getStores.js" type="text/javascript"></script>
<script src="js/getorderStatusMulti.js" type="text/javascript"></script>
<script src="js/getCities.js" type="text/javascript"></script>
<script src="js/getTowns.js" type="text/javascript"></script>
<script src="js/getManagers.js" type="text/javascript"></script>
<script type="text/javascript">
getStores($("#store"));
$(document).keydown(function(e) {
if (event.which === 13 || event.keyCode === 13 ) {
    event.stopPropagation();
    event.preventDefault();
    getorders();
}
});
function getorders(){
  options = $("#setOrderStatus").html();
$.ajax({
  url:"script/_getOrdersForStatusUpdate.php",
  type:"POST",
  data:$("#ordertabledata").serialize(),
  beforeSend:function(){
    $("#ordersTableDiv").addClass('loading');

  },
  success:function(res){
   $("#ordersTableDiv").removeClass('loading');
   console.log(res);
   $("#tb-orders").DataTable().destroy();
   $("#ordersTable").html("");
   $("#pagination").html("");

   if(res.pages >= 1){
     if(res.page > 1){
         $("#pagination").append(
          '<li class="page-item"><a href="#" onclick="getorderspage('+(Number(res.page)-1)+')" class="page-link">السابق</a></li>'
         );
     }else{
         $("#pagination").append(
          '<li class="page-item disabled"><a href="#" class="page-link">السابق</a></li>'
         );
     }
     if(Number(res.pages) <= 5){
       i = 1;
     }else{
       i =  Number(res.page) - 5;
     }
     if(i <=0 ){
       i=1;
     }
     for(i; i <= res.pages; i++){
       if(res.page != i){
         $("#pagination").append(
          '<li class="page-item"><a href="#" onclick="getorderspage('+(i)+')" class="page-link">'+i+'</a></li>'
         );
       }else{
         $("#pagination").append(
          '<li class="page-item active"><span class="page-link">'+i+'</span></li>'
         );
       }
       if(i == Number(res.page) + 5 ){
         break;
       }
     }
     if(res.page < res.pages){
         $("#pagination").append(
          '<li class="page-item"><a href="#" onclick="getorderspage('+(Number(res.page)+1)+')" class="page-link">التالي</a></li>'
         );
     }else{
         $("#pagination").append(
          '<li class="page-item disabled"><a href="#" class="page-link">التالي</a></li>'
         );
     }
   }
   $("#total-orders").text(res.total[0].orders);
   $.each(res.data,function(){
     if(this.money_status == 1){
       money = '<span class="success">تم التحاسب</span>';
     }else{
       money = '<span class="danger">لم يتم التحاسب</span>';
     }
     nuseen_msg =this.nuseen_msg;
     notibg = "kt-badge--danger";
     if(this.nuseen_msg == null){
       nuseen_msg = "";
       notibg="";
     }

     items = "";
     order_id= this.id;
     $.each(this.items,function(){
         items += '<input name="items['+order_id+'][]" class="text-left" type="checkbox" value="'+this.id+'">&nbsp;&nbsp;'+this.sub_name+'<br />';
     });
     oldItems = "";
     if(this.type == 2){
     $.each(this.items,function(){
         oldItems += '<input name="items['+order_id+'][]" class="text-left" type="checkbox" value="'+this.id+'">&nbsp;&nbsp;'+this.sub_name+'<br />';
     });
     oldItems = '<hr>'+oldItems;
     }
     $("#ordersTable").append(
       '<tr >'+
            '<td>'+this.order_no+'<input type="hidden" value="'+this.id+'" name="ids[]"></td>'+
            '<td>'+formatMoney(this.price)+'</td>'+
            '<td>'+this.store_name+'<br />'+(this.client_phone)+'</td>'+
            '<td>'+
              '<select status="status" class="form-control" style="height:40px;" name="status[]"  value="">'+
                options+
              '</select>'+
            '</td>'+
            '<td>'+this.status_name+'</td>'+
            '<td class="text-right">'+
                  items+oldItems+
            '</td>'+
            '<td>'+(this.customer_phone)+'</td>'+
            '<td>'+this.city+' - '+this.town+'</td>'+
            '<td>'+formatMoney(this.total_price)+'</td>'+
            '<td>'+this.date+'</td>'+
            '<td>'+this.staff_name+'</td>'+
            '<td>'+this.driver_name+'</td>'+
        '</tr>');
     });
     //$('.selectpicker').selectpicker('refresh');
    var myTable= $('#tb-orders').DataTable({
       "bPaginate": false,
       "bFilter": false,
      });

    },
   error:function(e){
    $("#ordersTableDiv").removeClass('loading');
    console.log(e);
  }
});
}
function setOrdersStatus(){
 status = $("#setOrderStatus").val();
 $('[status="status"]').val(status);
}
function updateOredrsStatus(){
      $.ajax({
        url:"script/_updateOredrsStatus.php",
        type:"POST",
        data:$("#ordertabledata").serialize(),
        beforeSend:function(){
            $("#section-to-print").addClass('loading');
        },
        success:function(res){
         $("#section-to-print").removeClass('loading');
         if(res.success == 1){
           Toast.success('تم تحديث الحاله');
           getorders();
         }else{
           Toast.warning('خطأ');
         }
         console.log(res);
        },
        error:function(e){
          $("#section-to-print").removeClass('loading');
          console.log(e);
        }
      });
}
function getorderspage(page){
    $("#p").val(page);
    getorders();
}
function updateTown(){
   getTowns($('#e_town'),$('#e_city').val());
}

$( document ).ready(function(){

$("#allselector").change(function() {
    var ischecked= $(this).is(':checked');
    if(!ischecked){
      $('input[name="id\[\]"]').attr('checked', false);;
    }else{
      $('input[name="id\[\]"]').attr('checked', true);;
    }
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
getorderStatus($("#orderStatus"),1);
getorderStatus($("#status_action"),1);
getorderStatus($("#setOrderStatus"),1);
getCities($("#city"));

});
</script>