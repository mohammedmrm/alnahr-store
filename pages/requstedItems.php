<div class="kt-portlet kt-portlet--tabs">
            <div class="kt-portlet__head">
                <div class="kt-portlet__head-toolbar">
                    <ul class="nav nav-tabs nav-tabs-line nav-tabs-line-success" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active" data-toggle="tab" href="#requestedItems" role="tab">
                                <i class="la la-cog"></i> المنتجات المطلوبة
                            </a>
                        </li>
<!--                        <li class="nav-item">
                            <a class="nav-link" data-toggle="tab" href="#pdfs" role="tab">
                                <i class="la la-briefcase"></i> طباعة تقارير
                            </a>
                        </li>-->
                    </ul>
                </div>
            </div>
            <div class="kt-portlet__body">
                <div class="tab-content">
                    <div class="tab-pane active" id="requestedItems" role="tabpanel">
                    <form id="basketItemsForm">
                      <fieldset><legend>فلتر</legend>
                      <div class="row kt-margin-b-20">
                        <div onkeyup="getItemsToPrepare()" class="col-lg-2 kt-margin-b-10-tablet-and-mobile">
                        	<label>اسم المنتج:</label>
                        	<input type="text" class="form-control" id="name" name="name"/>
                        </div>
                        <div class="col-lg-2 kt-margin-b-10-tablet-and-mobile">
                        	<label>العميل:</label>
                        	<select onchange="getItemsToPrepare()" data-show-subtext="true" data-live-search="true"  class="selectpicker form-control kt-input" id="client" name="client" data-col-index="7">
                        		<option value="">Select</option>
                        	</select>
                        </div>
                        <div class="col-lg-2 kt-margin-b-10-tablet-and-mobile">
                        	<label>الصفحه:</label>
                        	<select onchange="getItemsToPrepare()" data-show-subtext="true" data-live-search="true"  class="selectpicker form-control kt-input" id="store" name="store" data-col-index="7">
                        		<option value="">Select</option>
                        	</select>
                        </div>
                        <div class="col-lg-1 kt-margin-b-10-tablet-and-mobile">
                        	<label>الحالة:</label>
                        	<select onchange="getItemsToPrepare()" class="form-control selectpicker" id="status" name="status" data-col-index="7">
                        		<option value="0">قيد الانتظار</option>
                        		<option value="1">تم التجهيز</option>
                        		<option value="2">غير متوفر</option>
                        		<option value="3">تالف</option>
                        	</select>
                        </div>
                        <div class="col-lg-3 kt-margin-b-10-tablet-and-mobile">
                        <label>الفترة الزمنية :</label>
                        <div class="input-daterange input-group" id="kt_datepicker">
              				<input value="<?php echo date('Y-m-d');?>" onchange="getItemsToPrepare()" type="text" class="form-control kt-input" name="start" id="start" placeholder="من" data-col-index="5">
              				<div class="input-group-append">
              					<span class="input-group-text"><i class="la la-ellipsis-h"></i></span>
              				</div>
              				<input onchange="getItemsToPrepare()" type="text" class="form-control kt-input" name="end"  id="end" placeholder="الى" data-col-index="5">
                      	</div>
                      </div>
                        <div class="col-lg-1 kt-margin-b-10-tablet-and-mobile">
                            	<label class="">.</label><br />
                                <input id="download" name="download" type="button" value="تحميل التقرير" data-toggle="modal" data-target="#reportOptionsModal" class="btn btn-success" placeholder="" data-col-index="1">
                        </div>
                      </div>
                      </fieldset>
                      <table class="table table-striped  table-bordered responsive nowrap" style="white-space: nowrap;" id="tb-prepareTable">
        			       <thead>
        	  						<tr>
        										<th>ID</th>
        										<th>صورة</th>
        										<th>اسم المنتج</th>
        										<th>SKU</th>
        										<th>الموقع</th>
                                                <th>الكمية المطلوبة</th>
        										<th>الكمية المتوفرة</th>
        										<th>الحالة</th>
                                                <th>تعديل</th>
        		  					</tr>
              	            </thead>
                            <tbody id="prepareTable">
                            </tbody>
		            </table>
                    </form>
                    </div>
                </div>
            </div>
        </div>
<!--begin::Page Vendors(used by this page) -->
<script src="assets/plugins/custom/datatables/datatables.bundle.js" type="text/javascript"></script>
<!--begin::Page Scripts(used by this page) -->
<script src="assets/js/pages/components/datatables/extensions/responsive.js" type="text/javascript"></script>

<script>
function getItemsToPrepare(){
   $.ajax({
     url:"script/_getItemsToPrepare.php",
     type:"POST",
     data:$("#basketItemsForm").serialize(),
     beforeSend:function(){
      $("#tb-prepareTable").addClass("loading");
     },
     success:function(res){
      $("#tb-prepareTable").DataTable().destroy();
      $("#tb-prepareTable").removeClass("loading");
      $("#prepareTable").html("");
      console.log(res);
      $.each(res.data,function(){
      if(this.item_status == 0){
          item_status = "<span class='text-info fa-2x'>قيد التجهيز<span>";
      }else if(this.item_status == 1){
         item_status = "<span class='text-success fa-2x'>تم التجهيز<span>";
      }else if(this.item_status == 2){
         item_status = "<span class='text-danger fa-2x'>غير متوفر<span>";
      }else if(this.item_status == 3){
          item_status = "<span class='text-warning fa-2x'>تالف<span>";
      }else{
         item_status = "/";
      }
     $("#prepareTable").append(
       '<tr>'+
            '<td>'+this.bi_id+'</td>'+
            '<td> <div style="background-image:url(img/product/'+this.path+')" class="item-img-sm"></div></td>'+
            '<td>'+this.sub_name+'</td>'+
            '<td>'+this.sku+'</td>'+
            '<td>'+this.location+'</td>'+
            '<td class="fa-2x">'+this.r_qty+'</td>'+
            '<td>'+this.a_qty+'</td>'+
            '<td>'+item_status+'</td>'+
            '<td>'+
                '<button type="button" class="btn btn-clean text-success"  onclick="setitemPrepared('+this.bi_id+')"><span class="flaticon2-check-mark"></sapn></button>'+
                '<button type="button" class="btn btn-clean text-danger"  onclick="itemNotAvalible('+this.bi_id+')" data-toggle="modal" data-target="#notAvalibleItemModal"><span class="flaticon2-cross"></sapn></button>'+
            '</td>'+
          '</tr>');
      });
      $("#tb-prepareTable").DataTable({
        "oLanguage": {
          "sLengthMenu": "عرض_MENU_سجل",
          "sSearch": "بحث:"
        },
      });
    },
     error:function(e){
       $("#tb-prepareTable").removeClass("loading");
       console.log(e);
     }
   });
}
function itemNotAvalible(id){
  $("#item_id").val(id);
}
function setitemPrepared(id){
   $.ajax({
     url:"script/_setitemPrepared.php",
     type:"POST",
     data:{id:id},
     beforeSend:function(){
      $("#requestedItems").addClass("loading");
     },
     success:function(res){
       $("#requestedItems").removeClass("loading");
       console.log(res);
       toastr.success('تم تحضير المنتج');
       getItemsToPrepare();
     },
     error:function(e){
       $("#requestedItems").removeClass("loading");
       console.log(e);
       toastr.error('خطأ');
     }
   });
}
function setItemNotAvalible(id,status){
   $.ajax({
     url:"script/_setitemNotAvalible.php",
     type:"POST",
     data:{id:id,status:status},
     beforeSend:function(){
      $("#requestedItems").addClass("loading");
     },
     success:function(res){
       $("#requestedItems").removeClass("loading");
       console.log(res);
       toastr.success('تم تحديث حالة الطلب');
       getItemsToPrepare();
     },
     error:function(e){
       $("#requestedItems").removeClass("loading");
       console.log(e);
       toastr.error('خطأ');
     }
   });
}
getItemsToPrepare();
</script>
<div class="modal fade" id="notAvalibleItemModal" role="dialog">
    <div class="modal-dialog modal-sm">
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal"></button>
          <h4 class="modal-title">المنتج غير متوفر</h4>
        </div>
        <div class="modal-body">
        <!--Begin:: App Content-->
        <div class="kt-grid__item kt-grid__item--fluid kt-app__content">
           <form class="kt-form kt-form--label-right" id="basketItemsForm">
                    <div class="row">
                      <div class="form-group col-lg-6">
                         <label>السبب</label>
                         <select class="form-control selectpicker" id="reason">
                           <option value="2">غير متوفر</option>
                           <option value="3">تالف</option>
                         </select>
                      </div>
                      <div class="form-group col-lg-6">
                         <label></label><br />
                         <input type="button" onclick="setItemNotAvalible($('#item_id').val(),$('#reason').val())" class="btn btn-danger" value="تاكيد"/>
                      </div>
                    </div>
                    <input type="hidden" value="" id="item_id" name="item_id" />
           </form>
            </div>
        <!--End:: App Content-->
        </div>
      </div>

    </div>
</div>
