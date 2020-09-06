<?php
if(file_exists("script/_access.php")){
require_once("script/_access.php");
access([1]);
}
?>
<style>
</style>
<div class="kt-content  kt-grid__item kt-grid__item--fluid kt-grid kt-grid--hor" id="kt_content">

<!-- begin:: Subheader -->
<div class="kt-subheader   kt-grid__item" id="kt_subheader">
    <div class="kt-container  kt-container--fluid ">
        <div class="kt-subheader__toolbar">
            <div class="kt-subheader__wrapper">
                <div class="dropdown dropdown-inline" data-toggle="kt-tooltip" title="اضافة عميل" data-placement="top">
                    <span>اضافة شركه جديد</span>
                    <a data-toggle="modal" data-target="#addCompanyModal" class="btn btn-icon btn btn-label btn-label-brand btn-bold" data-toggle="dropdown" data-offset="0px,0px" aria-haspopup="true" aria-expanded="false">
                        <i class="flaticon2-add-1"></i>
                    </a>
                </div>
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
			<h1 class="kt-portlet__head-title">
				شركات التوصيل
			</h1>
		</div>
	</div>

	<div class="kt-portlet__body" id="Company_table">
		<!--begin: Datatable -->
		<table class="table table-striped- table-bordered table-hover table-checkable responsive no-wrap" id="tb-getAllcompanies">
			       <thead>
	  						<tr>
								<th>ID</th>
								<th>اسم الشركه</th>
								<th>رقم الهاتف</th>
								<th>ملاحظه</th>
								<th>تعديل</th>
		  					</tr>
      	            </thead>
                            <tbody id="getAllcompaniesTable">
                            </tbody>
                            <tfoot>
	                <tr>
								<th>ID</th>
								<th>اسم الشركه</th>
								<th>رقم الهاتف</th>
								<th>ملاحظه</th>
								<th>تعديل</th>
					</tr>
	           </tfoot>
		</table>
		<!--end: Datatable -->
	</div>
</div>	</div>
<!-- end:: Content -->				</div>


            <!--begin::Page Vendors(used by this page) -->
<script src="assets/plugins/custom/datatables/datatables.bundle.js" type="text/javascript"></script>
                        <!--end::Page Vendors -->



            <!--begin::Page Scripts(used by this page) -->
<script src="assets/js/pages/components/datatables/extensions/responsive.js" type="text/javascript"></script>
                       <script type="text/javascript">
function getAllcompanies(elem){
$.ajax({
  url:"script/_getHeadCompanies.php",
  type:"POST",
  beforeSend:function(){
    $("#Company_table").addClass('loading');
  },
  success:function(res){
   console.log(res);
   elem.html("");
   $("#Company_table").removeClass('loading');
   $("#tb-getAllcompanies").DataTable().destroy();
   $.each(res.data,function(){
     elem.append(
       '<tr>'+
            '<td>'+this.id+'</td>'+
            '<td>'+this.name+'</td>'+
            '<td>'+this.phone+'</td>'+
            '<td>'+this.note+'</td>'+
            '<td width="150px">'+
              '<button class="btn btn-clean btn-icon-lg" onclick="editCompany('+this.id+')" data-toggle="modal" data-target="#editCompany"><span class="flaticon-edit"></sapn>'+
              '<button class="btn btn-clean btn-icon-lg" onclick="deleteCompany('+this.id+')" data-toggle="modal" data-target="#deleteCompany"><span class="flaticon-delete"></sapn>'+
            '</button></td>'+
       '</tr>');
     });
     var myTable= $('#tb-getAllcompanies').DataTable({
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
    $("#Company_table").removeClass('loading');
    console.log(e);
  }
});
}
getAllcompanies($("#getAllcompaniesTable"));

</script>
<div class="modal fade" id="editCompany" role="dialog">
    <div class="modal-dialog">
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">تحديث بيانات الشركه</h4>
        </div>
        <div class="modal-body">
		<!--begin::Portlet-->
		<div class="kt-portlet">

			<!--begin::Form-->
			<form class="kt-form" id="editCompanyForm">
				<div class="kt-portlet__body">
					<div class="form-group">
						<label>اسم الشركه:</label>
						<input type="name" id="e_Company_name" name="e_company_name" class="form-control"  placeholder="ادخل الاسم الكامل">
						<span class="form-text  text-danger" id="e_Company_name_err"></span>
					</div>
					<div class="form-group">
						<label>شعار الشركه:</label>
						<input type="file" id="e_Company_phone" name="e_company_logo" class="form-control" placeholder="ادخل رقم الهاتف">
						<span  id="e_Company_logo_err"class="form-text  text-danger"></span>
					</div>
  					<div class="form-group">
  						<label>توكن:</label>
  						<input type="text" id="e_Company_token" name="e_company_token" class="form-control" placeholder="ex: 1r76yuiort34984.....">
  						<span  id="e_Company_token_err"class="form-text  text-danger"></span>
  					</div>
                      					<div class="form-group">
  						<label>الموقع الالكتروني:</label>
  						<input type="text" id="e_Company_dns" name="e_company_dns" class="form-control" placeholder="ex: www.example.com">
  						<span  id="e_Company_dns_err"class="form-text  text-danger"></span>
  					</div>
					<div class="form-group">
						<label>رقم الهاتف:</label>
						<input type="text" id="e_Company_phone" name="e_company_phone" class="form-control" placeholder="ادخل رقم الهاتف">
						<span  id="e_Company_phone_err"class="form-text  text-danger"></span>
					</div>
					<div class="form-group">
						<label>النص الاول:</label>
						<textarea id="e_Company_text1" name="e_company_text1" class="form-control"></textarea>
						<span class="form-text  text-danger" id="e_Company_text1_err"></span>
					</div>
					<div class="form-group">
						<label>النص الثاني:</label>
						<textarea id="e_Company_text2" name="e_company_text2" class="form-control"></textarea>
						<span class="form-text  text-danger" id="e_Company_text2_err"></span>
					</div>
	            </div>
	            <div class="kt-portlet__foot kt-portlet__foot--solid">
					<div class="kt-form__actions kt-form__actions--right">
						<button type="button" onclick="updateCompany()" class="btn btn-brand">تحديث</button>
						<button type="reset" data-dismiss="modal" class="btn btn-secondary">الغاء</button>
					</div>
				</div>
                <input type="hidden" id="editCompanyid" name="editcompanyid" />
			</form>
			<!--end::Form-->
		</div>
		<!--end::Portlet-->
        </div>
      </div>

    </div>
  </div>
<script>
function editCompany(id){
  $(".text-danger").text("");
  $("#editCompanyid").val(id);
  $.ajax({
    url:"script/_getCompanyByID.php",
    data:{id: id},
    beforeSend:function(){
      $("#editCompanyForm").addClass('loading');
    },
    success:function(res){
       $("#editCompanyForm").removeClass('loading');
      if(res.success == 1){
        $.each(res.data,function(){
          $('#e_Company_name').val(this.name);
          $('#e_Company_email').val(this.email);
          $('#e_Company_phone').val(this.phone);
        });
      }
      console.log(res);
    },
    error:function(e){
      $("#editCompanyForm").removeClass('loading');
      console.log(e);
    }
  });
}
function updateCompany(){
    $(".text-danger").text("");
    $.ajax({
       url:"script/_updateCompany.php",
       type:"POST",
       data:$("#editCompanyForm").serialize(),
       beforeSend:function(){
        $("#editCompanyForm").addClass('loading');
       },
       success:function(res){
         $("#editCompanyForm").removeClass('loading');
         console.log(res);
       if(res.success == 1){
          $("#kt_form input").val("");
          Toast.success('تم التحديث');
          getAllcompanies($("#getAllcompaniesTable"));
       }else{
           $("#e_Company_name_err").text(res.error["company_name_err"]);
           $("#e_Company_dns_err").text(res.error["company_dns_err"]);
           $("#e_Company_phone_err").text(res.error["company_phone_err"]);
           $("#e_Company_token_err").text(res.error["company_token_err"]);
           $("#e_Company_text1_err").text(res.error["company_text1_err"]);
           $("#e_Company_text2_err").text(res.error["company_text2_err"]);
           Toast.warning("هناك بعض المدخلات غير صالحة",'خطأ');
       }
       },
       error:function(e){
        $("#editCompanyForm").removeClass('loading');
        Toast.error('خطأ');
        console.log(e);
       }
    })
}
function deleteCompany(id){
  if(confirm("هل انت متاكد من الحذف")){
      $.ajax({
        url:"script/_deleteCompany.php",
        type:"POST",
        data:{id:id},
        success:function(res){
         if(res.success == 1){
           Toast.success('تم الحذف');
           getAllcompanies($("#getAllcompaniesTable"));
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
</script>
  <!-- Modal -->
  <div class="modal fade " id="addCompanyModal" role="dialog">
    <div class="modal-dialog">

      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">اضافة شركه</h4>
        </div>
        <div class="modal-body">
		<!--begin::Portlet-->
		<div class="kt-portlet">

			<!--begin::Form-->
			<form class="kt-form" id="addCompanyForm">
                <div class="row">
  				  <div class="kt-portlet__body">
  					<div class="form-group">
  						<label>الاسم الشركه:</label>
  						<input type="name" name="name" class="form-control"  placeholder="ادخل الاسم">
  						<span class="form-text  text-danger" id="name_err"></span>
  					</div>
  					<div class="form-group">
  						<label>هاتف الشركه:</label>
  						<input type="tel" name="phone" class="form-control">
  						<span  id="phone_err"class="form-text  text-danger"></span>
  					</div>
  					<div class="form-group">
  						<label>ملاحظه:</label>
  						<textarea  name="note" class="form-control" ></textarea>
  						<span class="form-text  text-danger" id="note_err"></span>
  					</div>
                    <hr />
  					<div class="form-group">
  						<label>اسم مدير الشركه:</label>
  						<input type="text" name="m_name" class="form-control">
  						<span  id="m_name_err"class="form-text  text-danger"></span>
  					</div>
  					<div class="form-group">
  						<label>رقم الهاتف:</label>
  						<input type="tel" name="username" class="form-control" placeholder="ادخل رقم الهاتف">
  						<span class="form-text  text-danger" id="username_err"></span>
  					</div>
  					<div class="form-group">
  						<label>كلمه المرور:</label>
  						<input type="password" name="password" class="form-control" placeholder="ادخل رقم الهاتف">
  						<span  id="password_err"class="form-text  text-danger"></span>
  					</div>
  	            </div>
                </div>
	            <div class="kt-portlet__foot kt-portlet__foot--solid">
					<div class="kt-form__actions kt-form__actions--right">
						<button type="button" onclick="addCompany()" class="btn btn-brand">اضافة</button>
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

  <script src="assets/js/demo1/pages/custom/profile/overview-3.js" type="text/javascript"></script>
  <script type="text/javascript" src="js/getCities.js"></script>
  <script type="text/javascript">
  function addCompany(){
    var myform = document.getElementById('addCompanyForm');
    var fd = new FormData(myform);
  $.ajax({
     url:"script/_addHeadCompany.php",
     type:"POST",
     data:fd,
     processData: false,  // tell jQuery not to process the data
     contentType: false,
   	 cache: false,
     beforeSend:function(){
           $("#name_err").text('');
           $("#phone_err").text('');
           $("#username_err").text('');
           $("#password_err").text('');
           $("#note_err").text('');
           $("#m_name_err").text('');
     },
     success:function(res){
       console.log(res);
       if(res.success == 1){
         getAllcompanies($("#getAllcompaniesTable"));
         $("#addCompanyForm input").val("");
         Toast.success('تم الاضافة');
       }else{
           $("#name_err").text(res.error["name_err"]);
           $("#phone_err").text(res.error["phone_err"]);
           $("#note_err").text(res.error["note_err"]);
           $("#username_err").text(res.error["username_err"]);
           $("#password_err").text(res.error["password_err"]);
           $("#m_name_err").text(res.error["mname_err"]);
       }
     },
     error:function(e){
       console.log(e);
       Toast.error.displayDuration=5000;
       Toast.error('تأكد من المدخلات','خطأ');
     }
  });
}
  </script>