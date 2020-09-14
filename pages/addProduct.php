<?php
require_once("script/dbconnection.php");
require_once("script/_access.php");
function categoryTree($parent_id = -1, $sub_mark = ''){
    global $con;
    $query = getData($con,"SELECT * FROM category WHERE parent_id = $parent_id and company_id=? ORDER BY title ASC",[$_SESSION['company_id']]);
    foreach($query as $row){
            echo '<option value="'.$row['id'].'">'.$sub_mark.$row['title'].'</option>';
            categoryTree($row['id'], $sub_mark.'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;');
    }

}
?>
<link href="assets/css/pages/wizards/wizard-v1.css" rel="stylesheet" type="text/css" />

<!-- begin:: Content -->
<div class="kt-container  kt-container--fluid  kt-grid__item kt-grid__item--fluid">
    <div class="kt-portlet__head">
		<div class="kt-portlet__head">
			<h3 class="kt-portlet__head-title">
				اضافة منتج
			</h3>
		</div>
	</div>

	<div class="kt-portlet__body" id="Product_table">
		<!--begin::Portlet-->
		<div class="kt-portlet">

			<!--begin::Form-->
			<form class="kt-form" id="addProductForm">
                <div class="row">
  				  <div class="col-md-6">
  				    <div class="kt-portlet__body">
  					<div class="form-group">
  						<label>السوق او الصفحة (البيج)</label>
  						<select id="store" name="store" class="selectpicker form-control">

                        </select>
  						<span class="form-text  text-danger" id="cat_err"></span>
  					</div>
  					<div class="form-group">
  						<label>التصنيف</label>
  						<select  name="cat" class="selectpicker form-control">
                            <?php categoryTree();?>
                        </select>
  						<span class="form-text  text-danger" id="cat_err"></span>
  					</div>
                    <div class="form-group">
  						<label>اسم المنتج</label>
  						<input type="name" onkeyup="updateSKU()" id="Product_name" name="Product_name" class="form-control"  placeholder="ادخل اسم المنتج">
  						<span class="form-text  text-danger" id="name_err"></span>
  					</div>
  					<div class="form-group">
  						<label>وصف مختصر</label>
  						<textarea type="name" id="simple_des" name="simple_des" class="form-control"  placeholder=""></textarea>
  						<span class="form-text  text-danger" id="simple_des_err"></span>
  					</div>
  					<div class="form-group">
  						<label>وصف المنتج</label>
  						<textarea type="name" id="des" name="des" class="form-control summernote"  placeholder=""></textarea>
                        <span class="form-text  text-danger" id="des_err"></span>
  					</div>
  	              </div>
  	             </div>
                  <div class="col-md-6">
                    <div class="kt-portlet__body">
                    <div class="form-group">
						<label>الصور</label>
						<div class="custom-file">
						  	<input type="file" class="custom-file-input" id="imgs" name="imgs[]" multiple="multiple">
						  	<label class="custom-file-label" for="img">اختر الصور</label>
						</div>
                        <span class="form-text  text-danger" id="imgs_err"></span>
					</div>
    					<div class="form-group">
    						<label>سعر الشراء</label>
    						<input type="text" id="buy_price" name="buy_price" class="form-control" placeholder="">
    						<span class="form-text  text-danger" id="buy_price_err"></span>
    					</div>
    					<div class="form-group">
    						<label>سعر البيع</label>
    						<input type="text" id="price" name="price" class="form-control" placeholder="">
    						<span class="form-text  text-danger" id="price_err"></span>
    					</div>
    					<div class="form-group">
    						<label>العدد</label>
    						<input type="number" id="qty" min="0" step="1" value="1" name="qty" class="form-control" placeholder="">
    						<span class="form-text  text-danger" id="qty_err"></span>
    					</div>
    					<div class="form-group">
    						<label>sku (Barcode)</label>
    						<input type="text" id="sku" name="sku" class="form-control" placeholder="">
    						<span class="form-text  text-danger" id="sku_err"></span>
    					</div>
    					<div class="form-group">
    						<label>الموقع</label>
    						<input type="text" id="location" name="location" class="form-control" placeholder="">
    						<span class="form-text  text-danger" id="location_err"></span>
    					</div>
    					<div class="form-group">
    						<label>نوع المنتج</label>
    						<select onchange="toggloConfigrationBtn($(this))" id="type" name="type" class="selectpicker form-control">
                             <option value="1">منتج بسيط</option>
                             <option value="2">منتج يحتوي على صفات (لون، قياس، ...)</option>
                            </select>
                            <span class="form-text  text-danger" id="type_err"></span>
    					</div>
    					<div class="form-group" id="configration_btn" style="display: none;">
    						<button type="button" class="btn btn-info" data-toggle="modal" data-target="#productConfigrationModal">انشاء ضبط</button>
    					</div>
                    </div>
                  </div>
                </div>
                <div class="row">
  				  <div class="col-md-12">
                           <div id="configTable" style="visibility: hidden;">
                      		<table class="table table-striped table-bordered table-hover responsive no-wrap" id="tb-Configrationtable">
                      		<thead>
                      	  	<tr id="configTableHead">
    	 							<th>Image</th>
    								<th>الاسم</th>
    								<th>sku</th>
                                    <th>الكميه</th>
    								<th>السعر</th>
    								<th>سعر الشراء</th>
    								<th>الموقع</th>
    								<th>المخزن</th>

                            </tr>
                      	  	<tr id="configTableInit" class="bg-warning">
    	 							<td colspan="3">القيم الاولية</td>
    								<td><input type="number" step="1" min="0" onchange="updateInitVal()" id="qty_init" class="form-control" /></td>
    								<td><input type="text" onchange="updateInitVal()" id="price_init" class="form-control" /></td>
    								<td><input type="text" onchange="updateInitVal()" id="buy_price_init" class="form-control" /></td>
    								<td><input type="text" onchange="updateInitVal()" id="location_init" class="form-control" /></td>
    								<td>
                                      <select onchange="updateInitVal()" id="stock_init" class="from-control selectpicker">
                                        <option value="1" class="text-success">بالمخزن</option>
                                        <option value="0" class="text-danger">غير متوفر</option>
                                      </select>
                                    </td>

                            </tr>
                            </thead>
                                <tbody id="configTableBody">
                                </tbody>
                            </table>
                           </div>

                  </div>
                </div>
	            <div class="kt-portlet__foot kt-portlet__foot--solid">
					<div class="kt-form__actions kt-form__actions--right">
						<button type="button" onclick="addProduct()" class="btn btn-brand">اضافة</button>
					</div>
				</div>
			</form>
			<!--end::Form-->
		</div>
		<!--end::Portlet-->
	</div>
</div>
<!-- end:: Content -->
<div class="modal fade" id="productConfigrationModal" role="dialog">
    <div class="modal-dialog modal-xl">
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">انشاء اعدادات المنتج</h4>
        </div>
        <div class="modal-body">
		<!--begin::Portlet-->
		<div class="kt-portlet">

<div class="kt-container  kt-container--fluid  kt-grid__item kt-grid__item--fluid">
		<div class="kt-portlet">
	<div class="kt-portlet__body kt-portlet__body--fit">
		<div class="kt-grid kt-grid--desktop-xl kt-grid--ver-desktop-xl  kt-wizard-v1" id="kt_wizard_v1" data-ktwizard-state="first">
			<div class="kt-grid__item kt-wizard-v1__aside">

				<!--begin: Form Wizard Nav -->
				<div class="kt-wizard-v1__nav">
					<div class="kt-wizard-v1__nav-items">
						<!--doc: Replace A tag with SPAN tag to disable the step link click -->
						<a class="kt-wizard-v1__nav-item" href="#" data-ktwizard-type="step" data-ktwizard-state="current">
							<span>1</span>
						</a>
						<a class="kt-wizard-v1__nav-item" href="#" data-ktwizard-type="step" data-ktwizard-state="pending">
							<span>2</span>
						</a>
					</div>
					<div class="kt-wizard-v1__nav-details">
						<div class="kt-wizard-v1__nav-item-wrapper" data-ktwizard-type="step-info">
							<div class="kt-wizard-v1__nav-item-title">
								تحديد صفات المنتج
							</div>
							<div class="kt-wizard-v1__nav-item-desc">
							  الرجا اختيار صفات المنتج ك (اللون، القياس،...)
							</div>
						</div>
						<div class="kt-wizard-v1__nav-item-wrapper" data-ktwizard-type="step-info">
							<div class="kt-wizard-v1__nav-item-title">
								حدد قيم كل صفه
							</div>
							<div class="kt-wizard-v1__nav-item-desc">
								يتم تحديد قيم كل صفه
							</div>
						</div>
					</div>
				</div>
				<!--end: Form Wizard Nav -->

			</div>
				<!--begin: Form Wizard Form-->
				<form class="kt-form" id="kt_form" novalidate="novalidate">

					<!--begin: Form Wizard Step 1-->
					<div class="kt-wizard-v1__content" data-ktwizard-type="step-content" data-ktwizard-state="current">
						<div class="kt-heading kt-heading--md">تحديد صفات المنتج</div>
						<div class="kt-separator kt-separator--height-xs"></div>
						<div class="kt-form__section kt-form__section--first">
                        <div class="from-group" >
                            <select title="اختر  صفات المنتج" onchange="getAttributesConfig()" multiple class="selectpicker" id="attributes" name="attributes[]"></select>
                        </div>
						</div>
					</div>
					<!--end: Form Wizard Step 1-->

					<!--begin: Form Wizard Step 2-->
					<div class="kt-wizard-v1__content" data-ktwizard-type="step-content">
						<div class="kt-heading kt-heading--md">تحديد قيم الصفات</div>
						<div class="kt-separator kt-separator--height-sm"></div>
						<div class="kt-form__section kt-form__section--first">
                            <div id="attributesConfig"></div>
						</div>
					</div>
					<!--end: Form Wizard Step 2-->
                    <!--begin: Form Actions -->
					<div class="kt-form__actions" style="alignment-adjust: central; text-align: left">
						<div class="btn btn-outline-brand btn-md btn-tall btn-wide btn-bold btn-upper" data-ktwizard-type="action-prev">
							السابق
						</div>
						<div onclick="createCofigTable()" class="btn btn-brand btn-md btn-tall btn-wide btn-bold btn-upper" data-ktwizard-type="action-submit">
							اضافة الاعدادات
						</div>
						<div class="btn btn-brand btn-md btn-tall btn-wide btn-bold btn-upper" data-ktwizard-type="action-next">
							التالي
						</div>
					</div>
					<!--end: Form Actions -->
				</form>
				<!--end: Form Wizard Form-->

		</div>
	</div>
</div>
</div>
		</div>
		<!--end::Portlet-->
        </div>
      </div>

    </div>
  </div>


<!--begin::Page Vendors(used by this page) -->
<script src="assets/plugins/custom/datatables/datatables.bundle.js" type="text/javascript"></script>
<!--end::Page Vendors -->
<!--begin::Page Scripts(used by this page) -->
<script src="assets/js/pages/components/forms/widgets/summernote.js" type="text/javascript"></script>
<script src="assets/js/pages/components/forms/widgets/dropzone.js" type="text/javascript"></script>
<!--end::Page Scripts -->
 <script src="assets/js/pages/custom/wizards/wizard-v1.js" type="text/javascript"></script>
 <script src="js/getAttributes.js" type="text/javascript"></script>
 <script src="js/getStores.js" type="text/javascript"></script>

<script type="text/javascript">
$('.summernote').summernote();
getStores($("#store"));
getAttributes($("#attributes"));
$(".selectpicker").selectpicker("refresh");
function updateSKU(){
  $("#sku").val($("#Product_name").val());
}
function getAllProducts(elem){
$.ajax({
  url:"script/_getProducts.php",
  type:"POST",
  beforeSend:function(){
    $("#Product_table").addClass('loading');
  },
  success:function(res){
   $("#tb-getAllProducts").DataTable().destroy();
   console.log(res);
   elem.html("");
   $("#Product_table").removeClass('loading');
   $.each(res.data,function(){
     elem.append(
       '<tr>'+
            '<td>'+this.name+'</td>'+
            '<td>'+this.price+'</td>'+
            '<td>'+this.sku+'</td>'+
            '<td>'+this.qty+'</td>'+
            '<td width="150px">'+
              '<button class="btn btn-clean btn-icon-lg" onclick="editProduct('+this.id+')" data-toggle="modal" data-target="#editProduct"><span class="flaticon-edit"></sapn>'+
              '<button class="btn btn-clean btn-icon-lg" onclick="deleteProduct('+this.id+')" data-toggle="modal" data-target="#deleteProduct"><span class="flaticon-delete"></sapn>'+
            '</button></td>'+

       '</tr>');
     });
     var myTable= $('#tb-getAllProducts').DataTable({

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
    $("#Product_table").removeClass('loading');
    console.log(e);
  }
});
}
getAllProducts($("#getAllProductsTable"));
function editProduct(id){
  $(".text-danger").text("");
  $("#editProductid").val(id);
  $.ajax({
    url:"script/_getProductByID.php",
    data:{id: id},
    beforeSend:function(){
      $("#editProductForm").addClass('loading');
    },
    success:function(res){
       $("#editProductForm").removeClass('loading');
      if(res.success == 1){
        $.each(res.data,function(){
          $('#e_Product_name').val(this.name);
          $('#e_Product_email').val(this.email);
          $('#e_Product_phone').val(this.phone);
          $('#e_Product_branch').selectpicker('val', this.branch_id);
        });
      }
      console.log(res);
    },
    error:function(e){
      $("#editProductForm").removeClass('loading');
      console.log(e);
    }
  });
}
function updateProduct(){
    $(".text-danger").text("");
    $.ajax({
       url:"script/_updateProduct.php",
       type:"POST",
       data:$("#editProductForm").serialize(),
       beforeSend:function(){
        $("#editProductForm").addClass('loading');
       },
       success:function(res){
         $("#editProductForm").removeClass('loading');
         console.log(res);
       if(res.success == 1){
          $("#kt_form input").val("");
          Toast.success('تم التحديث');
          getAllProducts($("#getAllProductsTable"));
       }else{
           $("#e_Product_branch_err").text(res.error["Product_branch_err"]);
           $("#e_Product_name_err").text(res.error["Product_name_err"]);
           $("#e_Product_email_err").text(res.error["Product_email_err"]);
           $("#e_Product_phone_err").text(res.error["Product_phone_err"]);
           $("#e_Product_password_err").text(res.error["Product_password_err"]);
           Toast.warning("هناك بعض المدخلات غير صالحة",'خطأ');
       }
       },
       error:function(e){
        $("#editProductForm").removeClass('loading');
        Toast.error('خطأ');
        console.log(e);
       }
    })
}
function deleteProduct(id){
  if(confirm("هل انت متاكد من الحذف")){
      $.ajax({
        url:"script/_deleteProduct.php",
        type:"POST",
        data:{id:id},
        success:function(res){
         if(res.success == 1){
           Toast.success('تم الحذف');
           getAllProducts($("#getAllProductsTable"));
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
function addProduct(){
    var myform = document.getElementById('addProductForm');
    var fd = new FormData(myform);
    var poData = $("#kt_form").serializeArray();
    for (var i=0; i<poData.length; i++){
     fd.append(poData[i].name, poData[i].value);
    }
  $.ajax({
    url:"script/_addProduct.php",
     type:"POST",
     data:fd,
     processData: false,  // tell jQuery not to process the data
     contentType: false,
   	 cache: false,
      beforeSend:function(){
        $("#addProductForm").addClass('loading');
        $("#addProductForm .text-danger").text('');
      },
     success:function(res){
       $("#addProductForm").removeClass('loading');
       console.log(res);
       if(res.success == 1){
         getAllProducts($("#getAllProductsTable"));
         $("#addProductForm input").val("");
         toastr.success('تم الاضافة');
       }else{
           $("#cat_err").text(res.error["cat"]);
           $("#name_err").text(res.error["name"]);
           $("#simple_des_err").text(res.error["simple_des"]);
           $("#des_err").text(res.error["des"]);
           $("#buy_price_err").text(res.error["buy_price"]);
           $("#price_err").text(res.error["price"]);
           $("#sku_err").text(res.error["sku"]);
           $("#qty_err").text(res.error["qty"]);
           $("#imgs_err").html(res.error["imgs"]);
       }

     },
     error:function(e){
       $("#addProductForm").removeClass('loading');
       console.log(e);
       toastr.error('تأكد من المدخلات','خطأ');
     }
  });
}
function getAttributesConfig(){
  $.ajax({
    url:"script/_getMultiAttributesConfig.php",
    data:{attributes: $('#attributes').val()},
    beforeSend:function(){
      $("#attributesConfig").addClass('loading');
    },
    success:function(res){
       $("#attributesConfig").removeClass('loading');
      if(res.success == 1){
         $("#attributesConfig").html('');
        $.each(res.data,function(){
          $("#attributesConfig").append("<h3>"+this.attribute.name+"</h3>");
          data = '<hr>'+
                 '<div>';
          $.each(this.config,function(){
             data = data + '<label class="col-md-3 kt-checkbox kt-checkbox--bold kt-checkbox--brand">'+
								'<input  name="config[]" type="checkbox" value="'+this.id+'" >'+this.value+
								'<span></span>'+
							'</label>';
          });
          data = data + '</div>'
          $("#attributesConfig").append(data);
        });
        $(".selectpicker").selectpicker("refresh");
      }
      console.log(res);
    },
    error:function(e){
      $("#attributesConfig").removeClass('loading');
      console.log(e);
    }
  });
}
function createCofigTable(){
  $.ajax({
    url:"script/_createCofigTable.php",
    data:$('#kt_form').serialize(),
    type:"POST",
    beforeSend:function(){
      $("#configTable").addClass('loading');
      $('[extra="head"]').remove();
      $('#configTableBody').html("");
      $("#configTable").css('visibility','visible');
    },
    success:function(res){
       $("#configTable").removeClass('loading');
      if(res.success == 1){

        $.each(res.data,function(){
            $('#configTableHead').append('<th extra="head">'+this.attribute.name+'</th>');
            $('#configTableInit').append('<td extra="head"></td>');

        });
        bluid(res.veiwID,res.veiw,res.rows);

      }
      console.log(res);
    },
    error:function(e){
      $("#configTable").removeClass('loading');
      console.log(e);
    }
  });

}

function bluid(veiwID,veiw,rows){
  row = "";
  $("#configTable").addClass("loading");
  $("#price_init").val($("#price").val());
  $("#buy_price_init").val($("#buy_price").val());
  $("#location_init").val($("#location").val());
  $("#qty_init").val($("#qty").val());
  i=0;
  $.each(veiwID,function(k1,v1){
    j=0;
    h=0;
    sku =  $("#Product_name").val();
    name =  $("#Product_name").val();
    $.each(v1,function(wdez){
      name = name +"-"+veiw[i][h];
      sku =  sku +"-"+veiw[i][h];
      h++;
    });

    row = row +
    "<tr>"+
      "<td><input type='file' class='form-control' name='config_matrix["+i+"][img]'></td>"+
      "<td><input type='text' class='form-control'  value='"+name+"' name='config_matrix["+i+"][sub_name]'></td>"+
      "<td><input type='text' class='form-control'  value='"+sku+"' name='config_matrix["+i+"][sku]'></td>"+
      "<td><input type='number' class='form-control' qty='qty' value='"+Math.ceil((Number($("#qty").val())/rows))+"' name='config_matrix["+i+"][qty]'></td>"+
      "<td><input type='text' class='form-control' price='price' value='"+$("#price_init").val()+"' name='config_matrix["+i+"][price]'></td>"+
      "<td><input type='text' class='form-control' buy_price='buy_price'  value='"+$("#buy_price_init").val()+"' name='config_matrix["+i+"][buy_price]'></td>"+
      "<td><input type='text' class='form-control' location='location' value='"+$("#location_init").val()+"' name='config_matrix["+i+"][location]'></td>"+
      "<td>"+
      '<select stock="stock" onchange="updateInitVal()" id="stock_init" name="config_matrix['+i+'][stock]" class="from-control selectpicker">'+
          '<option value="1" class="text-success">بالمخزن</option>'+
          '<option value="0" class="text-danger">غير متوفر</option>'+
      '</select>'+
      "</td>"
      ;
    $.each(v1,function(k2,v2){
          row = row +
          "<td>"+
           veiw[i][j]+
           "<input type='hidden' value='"+v2+"' name='config_matrix["+i+"][config][]'>"+
          "</td>";

          j++;
    });
    row = row + "</tr>";

    i++;
  });
  $('#configTableBody').append(row);
  $("#configTable").removeClass('loading');
  $(".selectpicker").selectpicker('refresh');
}
function updateInitVal(){
  if($("#qty_init").val() != ""){
   $('[qty="qty"]').val($("#qty_init").val());
  }
  if($("#price_init").val() != ""){
  $('[price="price"]').val($("#price_init").val());
  }
  if($("#buy_price_init").val() != ""){
  $('[buy_price="buy_price"]').val($("#buy_price_init").val());
  }
  if($("#location_init").val() != ""){
    $('[location="location"]').val($("#location_init").val());
  }
  if($("#stock_init").val() != ""){
    $('[stock="stock"]').val($("#stock_init").val());
  }
  $(".selectpicker").selectpicker('refresh');

}
function toggloConfigrationBtn(ele){
 if(ele.val() == 1){
   $("#configration_btn").css('display','none');
 }else{
   $("#configration_btn").css('display','inline-block');
 }
}
</script>