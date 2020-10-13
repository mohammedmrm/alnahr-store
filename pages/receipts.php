<?php
if(file_exists("script/_access.php")){
require_once("script/_access.php");
access([1,2,5]);
}
?>
<?
include_once("config.php");
?>
<!-- end:: Subheader -->
					<!-- begin:: Content -->
<div class="kt-container  kt-container--fluid  kt-grid__item kt-grid__item--fluid">
<div class="kt-portlet kt-portlet--mobile">
	<div class="kt-portlet__head">
		<div class="kt-portlet__head-label">
			<h1 class="">
				الوصولات
			</h1>
		</div>
	</div>

	<div class="kt-portlet__body">
     <form id="filtterRequestForm">
		<!--begin: Datatable -->
          <div class="row kt-margin-b-20">
            <div class="col-lg-2 kt-margin-b-10-tablet-and-mobile">
            	<input type="button" id="genrate" data-toggle="modal" data-target="#genrateReceipt"  class="btn btn-success btn-lg" value="توليد وصولات"/>
            </div>
          <div class="kt-separator kt-separator--border-dashed kt-separator--space-md"></div>
          </div>

          <fieldset><legend>فلتر</legend>
          <div class="row">
          <div class="col-lg-3 kt-margin-b-10-tablet-and-mobile">
               <div class="form-group">
						<label>الشركه:</label>
						<select  onchange="getCompanyReceipt()" id="f_company" name="company" class="form-control selectpicker"  data-show-subtext="true" data-live-search="true" ></select>
						<span class="form-text  text-danger" id="item_err"></span>
			   </div>
          </div>
          <div class="col-lg-3 kt-margin-b-10-tablet-and-mobile">
            <label>الفترة الزمنية :</label>
            <div class="input-daterange input-group" id="kt_datepicker">
  				<input value="" onchange="getCompanyReceipt()" type="text" class="form-control kt-input" name="start" id="start" placeholder="من" data-col-index="5">
  				<div class="input-group-append">
  					<span class="input-group-text"><i class="la la-ellipsis-h"></i></span>
  				</div>
  				<input onchange="getCompanyReceipt()" type="text" class="form-control kt-input" name="end" id="end" placeholder="الى" data-col-index="5">
          	</div>
            </div>
           </div>
          </fieldset>
		<table class="table table-striped- table-bordered table-hover table-checkable responsive no-wrap" id="tb-Request">
			       <thead>
	  						<tr>
								<th>#</th>
<!--								<th>الشركه</th>
                                <th>الشعار</th>-->
								<th>من</th>
								<th>الى</th>
								<th>حذف</th>
							</tr>
      	            </thead>
                            <tbody id="RequestesTable">
                            </tbody>
		</table>
        <div class="kt-section__content kt-section__content--border">
		<nav aria-label="...">
			<ul class="pagination" id="pagination">

			</ul>
        <input type="hidden" id="p" name="p" value="<?php if(!empty($_GET['p'])){ echo $_GET['p'];}else{ echo 1;}?>"/>
		</nav>
     	</div>
        </form>
		<!--end: Datatable -->
	</div>
</div>
</div>
<!-- end:: Content -->
<div class="modal fade" id="genrateReceipt" role="dialog">
    <div class="modal-dialog">
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">ادخال وصولات</h4>
        </div>
        <div class="modal-body">
		<!--begin::Portlet-->
		<div class="kt-portlet">

			<!--begin::Form-->
			<form class="kt-form" id="genrateReceiptForm">
				<div class="kt-portlet__body">
                    <div class="form-group">
    				    <label>ارقام الوصولات:</label>
                        <div class="input-daterange input-group" id="kt_datepicker">
            				<input type="number" class="form-control kt-input" name="from" id="from" placeholder="من" data-col-index="5">
            				<div class="input-group-append">
            					<span class="input-group-text"><i class="la la-ellipsis-h"></i></span>
            				</div>
            				<input type="number" class="form-control kt-input" name="to" id="to" placeholder="الى" data-col-index="5">
                    	</div>
                	</div>
					<div class="form-group">
						<label>الشركه:</label>
                        <select data-show-subtext="true" data-live-search="true" type="text" class="selectpicker form-control dropdown-primary" name="company" id="company"  value="">
                            <option value="">الشركة</option>
                        </select>
                        <span  id="number_err"class="form-text  text-danger"></span>
					</div>
	            </div>
	            <div class="kt-portlet__foot kt-portlet__foot--solid">
					<div class="kt-form__actions kt-form__actions--right">
						<button type="button" onclick="addReceipts()" class="btn btn-brand">طباعه</button>
						<button type="reset" data-dismiss="modal" class="btn btn-secondary">الغاء</button>
					</div>
				</div>
                <input type="hidden" id="printid" name="printid" />
			</form>
			<!--end::Form-->
		</div>
		<!--end::Portlet-->
        </div>
      </div>

    </div>
  </div>


<!--begin::Page Vendors(used by this page) -->
<script src="assets/plugins/custom/datatables/datatables.bundle.js" type="text/javascript"></script>
<!--begin::Page Scripts(used by this page) -->
<script src="assets/js/pages/components/datatables/extensions/responsive.js" type="text/javascript"></script>
<script src="js/getStores.js" type="text/javascript"></script>
<script type="text/javascript">
getStores($("#store"));
function getReceipts(){
$.ajax({
  url:"script/_getReceipts.php",
  type:"POST",
  data:$("#filtterRequestForm").serialize(),
  beforeSend:function(){
    $("#pagination").html("");
    $("#tb-Request").addClass('loading');
    $("#tb-Request").DataTable().destroy();
  },
  success:function(res){
    $("#tb-Request").removeClass('loading');
   console.log(res);
   $("#tb-Request").DataTable().destroy();
   $("#RequestesTable").html("");
   $("#RequestesTable").html("");
    $.each(res.data,function(){
       btn = '<button type="button" class="btn btn-clean btn-icon-lg text-danger" onclick="deleteReceipts('+this.f_id+')"><span class="flaticon-delete"></span>'+
        '</button>';

     $("#RequestesTable").append(
       '<tr>'+
            '<td>'+this.f_id+'</td>'+
/*            '<td>'+this.name+'</td>'+
            '<td><img height="50" src="img/'+this.logo+'"></td>'+*/
            '<td>'+this.from_receipt+'</td>'+
            '<td>'+this.to_receipt+'</td>'+
            '<td>'+btn+'</td>'+
      '</tr>');
     });

     var myTable= $('#tb-Request').DataTable({
       "bLengthChange": false,
       "bFilter": false,
       "order": [[ 0, "desc" ]]
     });
    },
   error:function(e){
     $("#tb-Request").removeClass('loading');
    console.log(e);
  }
});
}
getReceipts();
function printReceipt(){
  window.open("script/_printReceipt.php?printid="+$('#printid').val()+"&number="+$('#number').val(), '_blank');

}
function addReceipts(){
      $.ajax({
        url:"script/_addReceipts.php",
        type:"POST",
        beforeSend:function(){
          $("#genrateReceiptForm").addClass("loading");
        },
        data:$("#genrateReceiptForm").serialize(),
        success:function(res){
         $("#genrateReceiptForm").removeClass("loading");
         if(res.success == 1){
           toastr.success("تم الاضافة");
           getReceipts();
         }else{
           toastr.warning(res.msg);
         }
         console.log(res)
        } ,
        error:function(e){
          $("#genrateReceiptForm").removeClass("loading");
          console.log(e);
        }
      });
}
function updateID (id){
    $("#printid").val(id);
}
function updatePrintTimes(id){
$.ajax({
  url:"script/_updatePrintTimes.php",
  data:{id:id},
});
}
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
function getCompanies(elem){
$.ajax({
  url:"script/_getcompanies.php",
  type:"POST",
  success:function(res){
   console.log(res);
   elem.html("");
     elem.append(
       '<option value="0">الشركه الرئسيه</option>'
     );
   $.each(res.data,function(){
     elem.append(
       '<option value="'+this.id+'">'+this.name +'</option>'
     );
     elem.selectpicker('refresh');
   });
  },
  error:function(e){
    console.log(e);
  }
});
}
getCompanies($("#company"));
getCompanies($("#f_company"));
function deleteReceipts(id){
  if(confirm("هل انت متاكد من الحذف")){
      $.ajax({
        url:"script/_deleteReceipts.php",
        type:"POST",
        data:{id:id},
        success:function(res){
         if(res.success == 1){
           toastr.success('تم الحذف');
           getReceipts();
         }else{
           toastr.warning(res.msg);
         }
         console.log(res)
        } ,
        error:function(e){
          console.log(e);
        }
      });
  }

}
</script>
<script>


</script>