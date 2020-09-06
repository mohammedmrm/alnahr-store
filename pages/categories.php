<?php
if(file_exists("script/_access.php")){
require_once("script/_access.php");
access([1,2,5]);
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
                    <span>اضافة تصنيف جديد</span>
                    <a data-toggle="modal" data-target="#addCategoryModal" class="btn btn-icon btn btn-label btn-label-brand btn-bold" data-toggle="dropdown" data-offset="0px,0px" aria-haspopup="true" aria-expanded="false">
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
			<h3 class="kt-portlet__head-title">
			   التصنيفات
			</h3>
		</div>
	</div>

	<div class="kt-portlet__body" id="Category_table">
		<!--begin: Datatable -->
		<table class="table table-striped- table-bordered table-hover table-checkable responsive no-wrap" id="tb-getAllCategories">
			       <thead>
	  						<tr>
								<th>ID</th>
								<th>اسم التصنيف</th>
								<th>تعديل</th>
		  					</tr>
      	            </thead>
                            <tbody id="getAllCategoriesTable">
                            </tbody>
		</table>
		<!--end: Datatable -->
	</div>
</div>	</div>
<!-- end:: Content -->				</div>

<!--begin::Page Vendors(used by this page) -->
            <script src="assets/plugins/custom/datatables/datatables.bundle.js" type="text/javascript"></script>
                        <!--end::Page Vendors -->



<script type="text/javascript">
function getAllCategories(elem){
$.ajax({
  url:"script/_getCategories.php",
  type:"POST",
  beforeSend:function(){
    $("#Category_table").addClass('loading');
  },
  success:function(res){
   $("#Category_table").removeClass('loading');
   $("#tb-getAllCategories").DataTable().destroy();
   console.log(res);
   elem.html("");
   $.each(res.data,function(){
     elem.append(
       '<tr>'+
            '<td>'+this.id+'</td>'+
            '<td>'+this.title+'</td>'+
            '<td width="150px">'+
              '<button class="btn btn-clean btn-icon-lg" onclick="editCategory('+this.id+')" data-toggle="modal" data-target="#editCategory"><span class="flaticon-edit"></sapn>'+
              '<button class="btn btn-clean btn-icon-lg" onclick="deleteCategory('+this.id+')" data-toggle="modal" data-target="#deleteCategory"><span class="flaticon-delete"></sapn>'+
            '</button></td>'+
     '</tr>');
     });
     var myTable= $('#tb-getAllCategories').DataTable();
    },
   error:function(e){
    $("#Category_table").removeClass('loading');
    console.log(e);
  }
});
}
getAllCategories($("#getAllCategoriesTable"));

</script>
<div class="modal fade" id="editCategory" role="dialog">
    <div class="modal-dialog">
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">التصنيفات</h4>
        </div>
        <div class="modal-body">
		<!--begin::Portlet-->
		<div class="kt-portlet">

			<!--begin::Form-->
			<form class="kt-form" id="editCategoryForm">
				<div class="kt-portlet__body">
					<div class="form-group">
						<label>الاسم التصنيف:</label>
						<input type="name" id="e_name" name="e_name" class="form-control"  placeholder="">
						<span class="form-text  text-danger" id="e_name_err"></span>
					</div>
	            </div>
	            <div class="kt-portlet__foot kt-portlet__foot--solid">
					<div class="kt-form__actions kt-form__actions--right">
						<button type="button" onclick="updateCategory()" class="btn btn-brand">تحديث</button>
						<button type="reset" data-dismiss="modal" class="btn btn-secondary">الغاء</button>
					</div>
				</div>
                <input type="hidden" id="editCategoryid" name="editCategoryid" />
			</form>
			<!--end::Form-->
		</div>
		<!--end::Portlet-->
        </div>
      </div>

    </div>
  </div>

<script type="text/javascript" src="js/getCities.js"></script>
<script>
function editCategory(id){
  $(".text-danger").text("");
  $("#editCategoryid").val(id);
  $.ajax({
    url:"script/_getCategoryByID.php",
    data:{id: id},
    beforeSend:function(){
      $("#editCategoryForm").addClass('loading');
    },
    success:function(res){
       $("#editCategoryForm").removeClass('loading');
      if(res.success == 1){
        $.each(res.data,function(){
          $('#e_name').val(this.title);
        });
      }
      console.log(res);
    },
    error:function(e){
      $("#editCategoryForm").removeClass('loading');
      console.log(e);
    }
  });
}
function updateCategory(){
    $(".text-danger").text("");
    $.ajax({
       url:"script/_updateCategory.php",
       type:"POST",
       data:$("#editCategoryForm").serialize(),
       beforeSend:function(){
        $("#editCategoryForm").addClass('loading');
       },
       success:function(res){
         $("#editCategoryForm").removeClass('loading');
         console.log(res);
       if(res.success == 1){
          $("#kt_form input").val("");
          toastr.success('تم التحديث');
          getAllCategories($("#getAllCategoriesTable"));
       }else{
           $("#e_Category_branch_err").text(res.error["Category_branch_err"]);
           $("#e_Category_name_err").text(res.error["Category_name_err"]);
           $("#e_Category_email_err").text(res.error["Category_email_err"]);
           $("#e_Category_phone_err").text(res.error["Category_phone_err"]);
           $("#e_Category_password_err").text(res.error["Category_password_err"]);
           toastr.warning("هناك بعض المدخلات غير صالحة",'خطأ');
       }
       },
       error:function(e){
        $("#editCategoryForm").removeClass('loading');
        toastr.error('خطأ');
        console.log(e);
       }
    })
}
function deleteCategory(id){
  if(confirm("هل انت متاكد من الحذف")){
      $.ajax({
        url:"script/_deleteCategory.php",
        type:"POST",
        data:{id:id},
        success:function(res){
         if(res.success == 1){
           toastr.success('تم الحذف');
           getAllCategories($("#getAllCategoriesTable"));
         }else{
           toastr.warning(res.msg);
         }
         console.log(res)
        } ,
        error:function(e){
          toastr.error('خطأ');
          console.log(e);
        }
      });
  }
}
</script>
  <!-- Modal -->
  <div class="modal fade " id="addCategoryModal" role="dialog">
    <div class="modal-dialog modal-lg">

      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">اضافة تصنيف</h4>
        </div>
        <div class="modal-body">
		<!--begin::Portlet-->
		<div class="kt-portlet">

			<!--begin::Form-->
			<form class="kt-form" id="addCategoryForm">
                <div class="row">
  				  <div class="col-md-12">
  				    <div class="kt-portlet__body">
  					<div class="form-group">
  						<label>التصنيف الاب</label>
  						<select data-show-subtext="true" data-live-search="true" type="text" class="selectpicker form-control dropdown-primary" name="parent" id="parent"  value="">
                          <?php
                          require_once("script/dbconnection.php");
                          function categoryTree($parent_id = -1, $sub_mark = ''){
                              global $con;
                              $query = getData($con,"SELECT * FROM category WHERE parent_id = $parent_id and company_id=? ORDER BY title ASC",[$_SESSION['company_id']]);
                              foreach($query as $row){
                                      echo '<option value="'.$row['id'].'">'.$sub_mark.$row['title'].'</option>';
                                      categoryTree($row['id'], $sub_mark.'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;');
                              }

                          }
                          echo categoryTree();
                          ?>
                        </select>
                          <span class="form-text text-danger" id="parent_err"></span>
  					</div>
  					<div class="form-group">
  						<label>الاسم التصنيف:</label>
  						<input type="name" name="name" class="form-control"  placeholder="">
  						<span class="form-text  text-danger" id="Category_name_err"></span>
  					</div>
  					<div class="form-group">
  						<label>ملاحظات:</label>
  						<input type="name" name="note" class="form-control"  placeholder="">
  						<span class="form-text  text-danger" id="Category_note_err"></span>
  					</div>
                 </div>
  	            </div>
                </div>
	            <div class="kt-portlet__foot kt-portlet__foot--solid">
					<div class="kt-form__actions kt-form__actions--right">
						<button type="button" onclick="addCategory()" class="btn btn-brand">اضافة</button>
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


<script type="text/javascript">
function addCategory(){
  $.ajax({
     url:"script/_addCategory.php",
     type:"POST",
     data:$("#addCategoryForm").serialize(),
     success:function(res){
       console.log(res);
       if(res.success == 1){
         getAllCategories($("#getAllCategoriesTable"));
         $("#addCategoryForm input").val("");
         toastr.success('تم الاضافة');
       }else{
           $("#parent_err").text(res.error["parent"]);
           $("#Category_name_err").text(res.error["name"]);
           $("#Category_note_err").text(res.error["note"]);
           }

     },
     error:function(e){
       console.log(e);
       toastr.error.displayDuration=5000;
       toastr.error('تأكد من المدخلات','خطأ');
     }
  });
}

 </script>
