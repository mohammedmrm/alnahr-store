<?php
if(file_exists("script/_access.php")){
  require_once("script/_access.php");
  access([1,2]);
}
?>
<style>
table.dataTable tr th.select-checkbox.selected::after {
    content: "✔";
    margin-top: -11px;
    margin-left: -4px;
    text-align: center;
    text-shadow: rgb(176, 190, 217) 1px 1px, rgb(176, 190, 217) -1px -1px, rgb(176, 190, 217) 1px -1px, rgb(176, 190, 217) -1px 1px;
}
</style>
<div class="kt-content  kt-grid__item kt-grid__item--fluid kt-grid kt-grid--hor" id="kt_content">

<div class="kt-container  kt-container--fluid  kt-grid__item kt-grid__item--fluid">
<div class="kt-portlet kt-portlet--mobile">
	<div class="kt-portlet__head">
		<div class="kt-portlet__head-label">
			<h3 class="kt-portlet__head-title">
				الاوسمة
			</h3>
		</div>
	</div>

     <div class="kt-portlet__body">
      <div class="form-group col-lg-2">
        	<input type="button" data-toggle="modal" data-target="#addAttrbuteModal"  class="btn btn-success" value="اضافة وسم"/>
      </div>
		<!--begin: Datatable -->
		<table class="table table-striped- table-bordered table-hover table-checkable responsive no-wrap" id="tb-attributes">
			       <thead>
	  						<tr>
	 							<th>ID</th>
								<th>اسم الوسم</th>
								<th>ملاحظه</th>
								<th>تعديل</th>
                            </tr>
      	            </thead>
                            <tbody id="attributesTable">
                            </tbody>

		</table>
		<!--end: Datatable -->
	</div>
</div>	</div>
<!-- end:: Content -->				</div>


            <!--begin::Page Vendors(used by this page) -->
                       <script type="text/javascript">
function getattributes(){
$.ajax({
  url:"script/_getAllattributes.php",
  type:"POST",
  data:{city: $("#city").val()},
  success:function(res){
   console.log(res);
   $("#tb-attributes").DataTable().destroy();
   $("#attributesTable").html("");
   $.each(res.data,function(){
     $("#attributesTable").append(
       '<tr>'+
            '<td>'+this.id+'</td>'+
            '<td>'+this.name+'</td>'+
            '<td>'+this.date+'</td>'+
            '<td>'+
                '<button class="btn btn-clean btn-link" onclick="editattributes('+this.id+')" data-toggle="modal" data-target="#editAttributeModal"><span class="flaticon-edit"></sapn></button>'+
                '<button class="btn btn-clean btn-link" onclick="deleteattributes('+this.id+')" data-toggle="modal" data-target="#deleteAttributeModal"><span class="flaticon-delete"></sapn></button>'+
                '<button class="btn btn-clean btn-link" onclick="getAttributesConfig('+this.id+')" data-toggle="modal" data-target="#attributeConfigModal"><span class="flaticon-info"></sapn></button>'+
            '</td>'+

       '</tr>');
     });
     var myTable= $('#tb-attributes').DataTable({
        className: 'select-checkbox',
        targets: 0,
        "oLanguage": {
        "sLengthMenu": "عرض_MENU_سجل",
        "sSearch": "بحث:" ,
        select: {
        style: 'os',
        selector: 'td:first-child'
    }
      }
});
    },
   error:function(e){
    console.log(e);
  }
});
}
getattributes();

</script>
<div class="modal fade" id="addAttrbuteModal" role="dialog">
    <div class="modal-dialog">
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal"> </button>
          <h4 class="modal-title">اضافة وسم او صفه</h4>
        </div>
        <div class="modal-body">
		<!--begin::Portlet-->
		<div class="kt-portlet">

			<!--begin::Form-->
			<form class="kt-form" id="addattributesForm">
				<div class="kt-portlet__body">
                    <div class="form-group">
						<label>اسم الوسم او الصفه:</label>
						<input type="name" name="name" class="form-control"  placeholder="اسم الوسم">
						<span class="form-text  text-danger" id="name_err"></span>
					</div>
	            </div>
	            <div class="kt-portlet__foot kt-portlet__foot--solid">
					<div class="kt-form__actions kt-form__actions--right">
						<button type="button" onclick="addattributes()" class="btn btn-brand">اضافة</button>
						<button type="reset" data-dismiss="modal" class="btn btn-secondary">الغاء</button>
					</div>
				</div>
			</form>
			<!--end::Form-->
		</div>
		<!--end::Portlet-->
        </div>
      </div>

    </div>
  </div>

<div class="modal fade" id="editAttributeModal" role="dialog">
    <div class="modal-dialog">
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal"> </button>
          <h4 class="modal-title">اضافة فرع</h4>
        </div>
        <div class="modal-body">
		<!--begin::Portlet-->
		<div class="kt-portlet">

			<!--begin::Form-->
			<form class="kt-form" id="editattributesForm">
				<div class="kt-portlet__body">
					<div class="form-group">
						<label>اسم الوسم او الصفه</label>
						<input type="name" id="e_name" name="e_name" class="form-control"  placeholder="">
						<span class="form-text  text-danger" id="e_name_err"></span>
					</div>
	            </div>
	            <div class="kt-portlet__foot kt-portlet__foot--solid">
					<div class="kt-form__actions kt-form__actions--right">
						<button type="button" onclick="updateattributes()" class="btn btn-brand">حفظ التغيرات</button>
						<button type="reset" data-dismiss="modal" class="btn btn-secondary">الغاء</button>
					</div>
				</div>
                <input type="hidden" name="e_attribute_id" id="editattributesid"/>
			</form>
			<!--end::Form-->
		</div>
		<!--end::Portlet-->
        </div>
      </div>

    </div>
  </div>
<div class="modal fade" id="editAttributeConfigModal" role="dialog">
    <div class="modal-dialog">
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal"> </button>
          <h4 class="modal-title">اضافة فرع</h4>
        </div>
        <div class="modal-body">
		<!--begin::Portlet-->
		<div class="kt-portlet">

			<!--begin::Form-->
			<form class="kt-form" id="editAttributeConfigForm">
				<div class="kt-portlet__body">
					<div class="form-group">
						<label>قيمة الوسم او الصفه</label>
						<input type="text" id="e_config" name="e_config" class="form-control"  placeholder="">
						<span class="form-text  text-danger" id="e_config_err"></span>
					</div>
	            </div>
	            <div class="kt-portlet__foot kt-portlet__foot--solid">
					<div class="kt-form__actions kt-form__actions--right">
						<button type="button" onclick="updateAttributeConfig()" class="btn btn-brand">حفظ التغيرات</button>
						<button type="reset" data-dismiss="modal" class="btn btn-secondary">الغاء</button>
					</div>
				</div>
                <input type="hidden" id="e_AttributeConfig_id" name="editAttributeConfigid"/>
			</form>
			<!--end::Form-->
		</div>
		<!--end::Portlet-->
        </div>
      </div>

    </div>
  </div>
<div class="modal fade" id="attributeConfigModal" role="dialog">
    <div class="modal-dialog modal-lg">
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal"> </button>
          <h4 class="modal-title">قيم الوسم</h4>
        </div>
        <div class="modal-body">
        <!--Begin:: App Content-->
        <div class="kt-grid__item kt-grid__item--fluid kt-app__content">
            <div class="kt-portlet">
                <form class="kt-form kt-form--label-right" id="attributeConfigForm">
                  <fieldset><legend>اضافه قيم للصفة او الوسم</legend>
                  <div class="row kt-margin-b-20">
                    <div class="col-lg-3 kt-margin-b-10-tablet-and-mobile">
                    	<label>قيمة الصفه</label>
                        <input type="text" id="config" name="config" class="form-control"/>
                    </div>
                    <div class="col-lg-3 kt-margin-b-10-tablet-and-mobile">
                    	<label>صورة</label>
                        <input type="file" id="img" name="img" class="form-control"/>
                    </div>
                    <div class="col-lg-3 kt-margin-b-10-tablet-and-mobile">
                    	<label>اضافه:</label><br>
                    	<button type="button" onclick="addAttributeConfig()" class="btn btn-success" value="" placeholder="" data-col-index="0">اضافه

                        </button>
                    </div>
                    <div class="col-lg-4 kt-margin-b-10-tablet-and-mobile">
                    	<label>اسم الوسم</label><br>
                    	<label id="attribute_name"></label><br>
                    </div>
                  </div>
                  </fieldset>
		           <!--begin: Datatable -->
		           <table class="table table-striped- table-bordered table-hover table-checkable responsive no-wrap" id="tb-attributeConfig">
  			         <thead>
  	  						<tr>
  										<th>ID</th>
  										<th>اسم الوسم</th>
  										<th>صورة</th>
  										<th>القيمة</th>
  										<th>حذف</th>
                           </tr>
        	            </thead>
                      <tbody id="attributeConfig">
                      </tbody>
	            	</table>
		            <!--end: Datatable -->
                    <input type="hidden" value="" id="attributeConfig_id" name="attribute_id" />
                </form>
            </div>
        </div>
        <!--End:: App Content-->
        </div>
      </div>

    </div>
</div>
<!--begin::Page Vendors(used by this page) -->
<script src="assets/plugins/custom/datatables/datatables.bundle.js" type="text/javascript"></script>
<!--begin::Page Scripts(used by this page) -->
<script src="assets/js/pages/components/datatables/extensions/responsive.js" type="text/javascript"></script>

<script type="text/javascript" src="js/getCities.js"></script>
<script>
getCities($("#town_city"));
getCities($("#city"));
function addattributes(){
  $.ajax({
    url:"script/_addattributes.php",
    type:"POST",
    data:$("#addattributesForm").serialize(),
    beforeSend:function(){

    },
    success:function(res){
       console.log(res);
       if(res.success == 1){
         $("#kt_form input").val("");
         toastr.success('تم الاضافة');
         getattributes();
       }else{
           $("#name_err").text(res.error["name"]);
           toastr.warning("هناك بعض المدخلات غير صالحة",'خطأ');
       }
    },
    error:function(e){
     console.log(e);
     toastr.error('خطأ');
    }
  });
}
function editattributes(id){
  $("#editattributesid").val(id);
  $.ajax({
    url:"script/_getAttribute.php",
    data:{id: id},
    success:function(res){
      if(res.success == 1){
        $.each(res.data,function(){
          $('#e_name').val(this.name);
        });
      }
      console.log(res);
    },
    error:function(e){
      console.log(e);
    }
  });
}
function updateattributes(){
    $.ajax({
       url:"script/_updateAttribute.php",
       type:"POST",
       data:$("#editattributesForm").serialize(),
       beforeSend:function(){

       },
       success:function(res){
          console.log(res);
       if(res.success == 1){
         $("#kt_form input").val("");
          toastr.success('تم التحديث');
          getattributes();
       }else{
           $("#e_name_err").text(res.error["name"]);
           toastr.warning("هناك بعض المدخلات غير صالحة",'خطأ');
       }

       },
       error:function(e){
        //toastr.error('خطأ');
        console.log(e);
       }
    });
}
function deleteattributes(id){
  if(confirm("هل انت متاكد من الحذف")){
      $.ajax({
        url:"script/_deleteAttribute.php",
        type:"POST",
        data:{id:id},
        success:function(res){
          console.log(res);
         if(res.success == 1){
           toastr.success('تم الحذف');
           getattributes();
         }else{
           toastr.warning(res.msg);
         }
        } ,
        error:function(e){
          console.log(e);
        }
      });
  }
}
function getAttributesConfig(id){
  $("#attributeConfig_id").val(id);
  $.ajax({
    url:"script/_getAttributesConfig.php",
    data:{id: id},
    success:function(res){
      $("#tb-attributeConfig").DataTable().destroy();
      $("#attributeConfig").html("");
      if(res.success == 1){
        $.each(res.data,function(){
        $("#attributeConfig").append(
           '<tr>'+
                '<td>'+this.id+'</td>'+
                '<td>'+this.value+'</td>'+
                '<td><div style="background-image:url(img/attribute_config/'+this.img+')"  class="img-sm"></div></td>'+
                '<td>'+this.date+'</td>'+
                '<td>'+
                    '<button type="button" class="btn btn-link" onclick="editAttributeConfig('+this.id+')" data-toggle="modal" data-target="#editAttributeConfigModal"><span class="flaticon-edit"></sapn></button>'+
                    '<button type="button"  class="btn btn-link" onclick="deleteAttributeConfig('+this.id+')"><span class="flaticon-delete"></sapn></button>'+
                '</td>'+

           '</tr>');
        });
      }
      $("#tb-attributeConfig").DataTable({
            pageLength: 5,
            lengthMenu: [5, 10, 20, 50, 100, 200, 500],
      });
      console.log(res);
    },
    error:function(e){
      console.log(e);
    }
  });
}
function addAttributeConfig(){
    var myform = document.getElementById('attributeConfigForm');
    var fd = new FormData(myform);
    $.ajax({
       url:"script/_addAttributeConfig.php",
       type:"POST",
       data:fd,
       processData: false,  // tell jQuery not to process the data
       contentType: false,
       cache: false,
       beforeSend:function(){

       },
       success:function(res){
          console.log(res);
       if(res.success == 1){
         $("input[type='text']").val("");
          //toastr.success('تم التحديث');
          getAttributesConfig($("#attributeConfig_id").val());
       }else{
           $("#e_name_err").text(res.error["name"]);
           //toastr.warning("هناك بعض المدخلات غير صالحة",'خطأ');
       }

       },
       error:function(e){
        //toastr.error('خطأ');
        console.log(e);
       }
    })
}
function editAttributeConfig(id){
$("#e_AttributeConfig_id").val(id);
  $.ajax({
    url:"script/_getAttributeConfigByID.php",
    data:{id: id},
    success:function(res){
      if(res.success == 1){
        $.each(res.data,function(){
          $('#e_config').val(this.value);
        });
      }
      console.log(res);
    },
    error:function(e){
      console.log(e);
    }
});
}
function updateAttributeConfig(){
    $.ajax({
       url:"script/_updateAttributeConfig.php",
       type:"POST",
       data:$("#editAttributeConfigForm").serialize(),
       beforeSend:function(){
         $("#editAttributeConfigForm").addClass('loading');
       },
       success:function(res){
          $("#editAttributeConfigForm").removeClass('loading');
          console.log(res);
           if(res.success == 1){
             $("#kt_form input").val("");
              toastr.success('تم التحديث');
               getAttributesConfig($("#attributeConfig_id").val());
           }else{
               $("#e_name_err").text(res.error["name"]);
               toastr.warning("هناك بعض المدخلات غير صالحة",'خطأ');
           }

       },
       error:function(e){
        $("#editAttributeConfigForm").removeClass('loading');
        console.log(e);
       }
    });
}
</script>