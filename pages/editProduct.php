<?php
if (file_exists("script/_access.php")) {
  require_once("script/_access.php");
  access([1, 2, 3, 5, 4,10]);
}
?>
<style>
  fieldset {
    border: 1px solid #ddd !important;
    margin: 0;
    min-width: 0;
    padding: 10px;
    position: relative;
    border-radius: 4px;
    background-color: #f5f5f5;
    padding-left: 10px !important;
    width: 100%;
  }

  legend {
    font-size: 14px;
    font-weight: bold;
    margin-bottom: 0px;
    width: 55%;
    border: 1px solid #ddd;
    border-radius: 4px;
    padding: 5px 5px 5px 10px;
    background-color: #ffffff;
  }
</style>

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
      <form id="producttabledata" class="kt-form kt-form--fit kt-margin-b-20">
        <fieldset>
          <legend>فلتر</legend>
          <div class="row kt-margin-b-20">
            <div class="col-lg-2 kt-margin-b-10-tablet-and-mobile">
              <label>اسم المنتج:</label>
              <input id="name" name="name" onkeyup="getProducts()" type="text" class="form-control kt-input" placeholder="" data-col-index="0">
            </div>
            <div class="col-lg-2 kt-margin-b-10-tablet-and-mobile">
              <label>SKU:</label>
              <input name="sku" onkeyup="getProducts()" type="text" class="form-control kt-input" placeholder="" data-col-index="1">
            </div>
            <div class="kt-separator kt-separator--border-dashed kt-separator--space-md"></div>
          </div>
        </fieldset>

        <div class="row kt-margin-b-20">
          <div class="col-lg-3 kt-margin-b-10-tablet-and-mobile">
            <label>عدد السجلات في الصفحة الواحدة</label>
            <select onchange="getProducts()" class="form-control kt-input" name="limit" data-col-index="7">
              <option value="10">10</option>
              <option value="15">15</option>
              <option value="20">20</option>
              <option value="25">25</option>
              <option value="30">30</option>
              <option value="50">50</option>
              <option value="100">100</option>
            </select>
          </div>
        </div>

        <table class="table table-striped table-bordered table-hover table-checkable responsive no-wrap" id="tb-productTable">
          <thead>
            <tr>
              <th>صور</th>
              <th>اسم المنتح</th>
              <th>السعر</th>
              <th>نوع المنتج</th>
              <th>صفات المنتج</th>
              <th>السوق</th>
              <th>تعديل</th>


            </tr>
          </thead>
          <tbody id="productTable">
          </tbody>

        </table>
        <div class="kt-section__content kt-section__content--border">
          <nav aria-label="...">
            <ul class="pagination" id="pagination">

            </ul>
            <input type="hidden" id="p" name="p" value="<?php if (!empty($_GET['p'])) {
                                                          echo $_GET['p'];
                                                        } else {
                                                          echo 1;
                                                        } ?>" />
          </nav>
        </div>
      </form>
      <!--end: Datatable -->
    </div>
  </div>
</div>
<!-- end:: Content -->
<div class="modal fade" id="editProduct" role="dialog">
  <div class="modal-dialog modal-xl">
    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal"></button>
        <h4 class="modal-title">تعديل منتج</h4>
      </div>
      <div class="modal-body">
        <!--Begin:: App Content-->
        <div class="kt-grid__item kt-grid__item--fluid kt-app__content">
          <div class="kt-portlet">
            <form class="kt-form kt-form--label-right" id="editProductForm">
              <div class="kt-portlet__body">
                <div class="kt-section kt-section--first">
                  <div class="kt-section__body">
                    <div class="form-group row">
                      <div class="col-lg-6 kt-margin-b-10-tablet-and-mobile">
                        <label>السوق / البيج</label>
                        <select data-live-search="true" class="form-control selectpicker" id="e_store" name="e_store" >
                        </select>
                        <span class="form-text text-danger" id="e_store_err"></span>
                      </div>
                      <div class="col-lg-6 kt-margin-b-10-tablet-and-mobile">
                        <label>التصنيف</label><br />
                        <select data-live-search="true" class="form-control selectpicker" id="e_category" name="e_category">
                        </select>
                        <span class="form-text text-danger" id="e_category_err"></span>
                      </div>
                    </div>
                    <div class="form-group row">
                      <div class="col-lg-6 kt-margin-b-10-tablet-and-mobile">
                        <label>اسم المنتج</label>
                        <input type="text" class="form-control" id="e_name" name="e_name" />
                        <span class="form-text text-danger" id="e_name_err"></span>
                      </div>
                      <div class="col-lg-6 kt-margin-b-10-tablet-and-mobile">
                        <label>SKU</label><br />
                        <input type="text" class="form-control" id="e_sku" name="e_sku" />
                        <span class="form-text text-danger" id="e_sku_err"></span>
                      </div>
                    </div>
                    <div class="form-group row">
                     <div class="col-lg-6 kt-margin-b-10-tablet-and-mobile">
                        <label>الوصف</label><br />
                        <textarea type="text" class="form-control" id="e_simple_des" name="e_simple_des" ></textarea>
                        <span class="form-text text-danger" id="e_simple_des_err"></span>
                      </div>
                      <div class="col-lg-6 kt-margin-b-10-tablet-and-mobile">
                        <label>صور</label>
                        <input type="file" class="form-control" id="e_img" name="e_img[]" />
                        <span class="form-text text-danger" id="e_customer_name_err"></span>
                      </div>
                    </div>
                    <div class="form-group row">
                      <div class="col-lg-6 kt-margin-b-10-tablet-and-mobile">
                        <label>سعر الشراء</label>
                        <input type="text" class="form-control" id="e_buy_price" name="e_buy_price" />
                        <span class="form-text text-danger" id="e_buy_price_err"></span>
                      </div>
                      <div class="col-lg-6 kt-margin-b-10-tablet-and-mobile">
                        <label>سعر البيع</label><br />
                        <input type="text" class="form-control" id="e_price" name="e_price" />
                        <span class="form-text text-danger" id="e_price_err"></span>
                      </div>
                    </div>
                    <input  type="hidden" id="e_product_id" name="e_product_id"/>
                    <hr />
                    <div class="col-md-12">
                           <div id="configTable">
                      		<table class="table table-striped table-bordered table-hover responsive no-wrap" id="tb-Configrationtable">
                      		<thead>
                      	  	<tr id="configTableHead">
    	 							<th>Image</th>
    								<th>الاسم</th>
    								<th>sku</th>
                                    <th width='100px'>الكميه</th>
    								<th width='100px'>السعر</th>
    								<th width='100px'>سعر الشراء</th>
    								<th width='100px'>الموقع</th>
    								<th>الصفات</th>

                            </tr>
                      	  	<tr id="configTableInit" class="bg-warning">
    	 							<td colspan="3">القيم الاولية</td>
    								<td><input type="number" step="1" min="0" onchange="updateInitVal()" id="qty_init" class="form-control" /></td>
    								<td><input type="text" onchange="updateInitVal()" id="price_init" class="form-control" /></td>
    								<td><input type="text" onchange="updateInitVal()" id="buy_price_init" class="form-control" /></td>
    								<td><input type="text" onchange="updateInitVal()" id="location_init" class="form-control" /></td>
                                    <td></td>

                            </tr>
                            </thead>
                                <tbody id="configTableBody">
                                </tbody>
                            </table>
                           </div>
                    </div>
                  </div>
                </div>

              </div>
              <div class="kt-portlet__foot">
                <div class="kt-form__actions">
                  <div class="row">
                    <div class="col-lg-3 col-xl-3">
                    </div>
                    <div class="col-lg-9 col-xl-9">
                      <button type="button" onclick="updateProduct()" class="btn btn-danger">تحديث معلومات المنتج</button>&nbsp;
                      <button type="reset" data-dismiss="modal" class="btn btn-secondary">الغأ</button>
                    </div>
                  </div>
                </div>
              </div>
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
<script src="js/getStores.js" type="text/javascript"></script>
<script src="js/getCategories.js" type="text/javascript"></script>
<script type="text/javascript">
getStores($("#e_store"));
getCategories($("#e_category"));
 function getProducts() {
    $.ajax({
      url: "script/_getFullProducts.php",
      type: "POST",
      beforeSend: function() {
        $("#tb-productTable").addClass('loading');
      },
      data: $("#producttabledata").serialize(),
      success: function(res) {
        $("#tb-productTable").DataTable().destroy();
        console.log(res);
        $("#productTable").html("");
        $("#pagination").html("");
        $("#tb-productTable").removeClass('loading');
        if (res.pages >= 1) {
          if (res.page > 1) {
            $("#pagination").append(
              '<li class="page-item"><a href="#" onclick="getorderspage(' + (Number(res.page) - 1) + ')" class="page-link">السابق</a></li>'
            );
          } else {
            $("#pagination").append(
              '<li class="page-item disabled"><a href="#" class="page-link">السابق</a></li>'
            );
          }
          if (Number(res.pages) <= 5) {
            i = 1;
          } else {
            i = Number(res.page) - 5;
          }
          if (i <= 0) {
            i = 1;
          }
          for (i; i <= res.pages; i++) {
            if (res.page != i) {
              $("#pagination").append(
                '<li class="page-item"><a href="#" onclick="getorderspage(' + (i) + ')" class="page-link">' + i + '</a></li>'
              );
            } else {
              $("#pagination").append(
                '<li class="page-item active"><span class="page-link">' + i + '</span></li>'
              );
            }
            if (i == Number(res.page) + 5) {
              break;
            }
          }
          if (res.page < res.pages) {
            $("#pagination").append(
              '<li class="page-item"><a href="#" onclick="getorderspage(' + (Number(res.page) + 1) + ')" class="page-link">التالي</a></li>'
            );
          } else {
            $("#pagination").append(
              '<li class="page-item disabled"><a href="#" class="page-link">التالي</a></li>'
            );
          }
        }

        $.each(res.data, function() {
          if (res.role != 4) {
          btn =
              '<button type="button" class="btn btn-clean fa-2x text-info"    onclick="editProduct(' + this.id + ')" data-toggle="modal" data-target="#editProduct"><span class="flaticon-edit"></sapn></button>' +
              '<button type="button" class="btn btn-clean fa-2x text-danger"  onclick="deleteProduct(' + this.id + ')" data-toggle="modal" data-target="#deleteProduct"><span class="flaticon-delete"></sapn></button>' +
              '';
          }
          if(this.display != 1) {
          btn +=
              '<button type="button" class="btn btn-clean fa-2x text-success"  onclick="displayProduct(' + this.id + ')" ><span class="flaticon-eye"></sapn></button>' +
              '';
          }else{
          btn +=
              '<button type="button" class="btn btn-clean fa-2x text-warning"  onclick="hideProduct(' + this.id + ')"><span class="fa fa-eye-slash"></sapn></button>' +
              '';
          }
          attribute = "";
          $.each(this.attribute, function() {
            attribute = "<b>"+this.name+":</b> ";
            $.each(this.config, function() {
              attribute = attribute + ", " + this.value + " ";
            });
            attribute = attribute + "<br />";
          });
          $("#productTable").append(
            '<tr>' +
            '<td><div style="background-image:url(img/product/' + this.img + ');" class="item-img-sm"></div></td>' +
            '<td>' + this.name + '</td>' +
            '<td>' + this.price+'</td>' +
            '<td>' + this.category_name + '</td>' +
            '<td>' + attribute + '</td>' +
            '<td>' + this.store_name + '</td>' +
            '<td width="150px">' +
              btn +
            '</td>' +
            '</tr>');
        });
        var myTable = $('#tb-productTable').DataTable({
          "oLanguage": {
            "sLengthMenu": "عرض_MENU_سجل",
            "sSearch": "بحث:",
          },
          "bPaginate": false,
        });
      },
      error: function(e) {
        $("#tb-ProductTable").removeClass('loading');
        console.log(e);
      }
    });
  }
 getProducts();

 function getorderspage(page) {
    $("#p").val(page);
    getProducts();
  }

  function getclient() {
    getProducts();
  }

  function openBasket(id) {
    $("#product_id").val(id);
  }
  $(document).ready(function() {
    $("#allselector").change(function() {
      var ischecked = $(this).is(':checked');
      if (!ischecked) {
        $('input[name="id\[\]"]').attr('checked', false);;
      } else {
        $('input[name="id\[\]"]').attr('checked', true);;
      }
    });
    $('#start').datepicker({
      format: "yyyy-mm-dd",
      showMeridian: true,
      todayHighlight: true,
      autoclose: true,
      pickerPosition: 'bottom-left',
      defaultDate: 'now'
    });
    $('#end').datepicker({
      format: "yyyy-mm-dd",
      showMeridian: true,
      todayHighlight: true,
      autoclose: true,
      pickerPosition: 'bottom-left',
      defaultDate: 'now'
    });


  });
  function deleteProduct(id) {
    $.ajax({
      url: "script/_runAction.php",
      type: "POST",
      data: 'action=delete&ids[]=' + id,
      success: function(res) {
        getProducts();
        console.log(res);
        if (res.success == 1) {
          toastr.success("تم حذف المنتج");
        } else {
          toastr.warning("حدث خطاء! حاول مرة اخرى.");
        }
      },
      error: function(e) {
        toastr.error("خطأ!");
        console.log(e);
      }
    });
  }

  function editProduct(id) {
    $.ajax({
      url: "script/_getProductForEdit.php",
      type: "POST",
      data: {
        id: id
      },
      success: function(res) {
         console.log(res);
         $("#configTableBody").html("");
        if (res.success == 1) {
          tr = "";
          $.each(res.data, function() {
            $("#e_name").val(this.name);
            $("#e_sku").val(this.sku);
            $("#e_buy_price").val(this.buy_price);
            $("#e_price").val(this.price);
            $("#e_product_id").val(id);
            $("#e_store").val(this.store_id);
            $("#e_category").val(this.category_id);
            $("#e_simple_des").val(this.simple_des);
            $(".selectpicker").selectpicker("refresh");
            $.each(this.configurable_product,function(){
                config = "";
                $.each(this.config,function(){
                  config += '<b>'+this.name+':</b> '+this.value+'<br />';
                })
                tr = '<tr>'+
                        "<td>"+
                            "<input style='width:100px;' type='file' name='c_img[]'/>"+
                            "<input style='width:100px;' type='hidden' value='"+this.id+"'  name='c_id[]'/>"+
                        "</td>"+
                        "<td>"+"<input type='text' name='c_name[]' value='"+this.sub_name+"' class ='form-control'/></td>"+
                        "<td>"+"<input type='text' name='c_sku[]' value='"+this.sku+"' class ='form-control'/></td>"+
                        "<td>"+"<input style='width:100px;' type='number' name='c_qty[]' value='"+this.qty+"' class ='form-control' /></td>"+
                        "<td>"+"<input style='width:100px;' type='number' name='c_price[]' value='"+this.price+"' class ='form-control'/></td>"+
                        "<td>"+"<input style='width:100px;' type='number' name='c_buy_price[]' value='"+this.buy_price+"' class ='form-control' /></td>"+
                        "<td>"+"<input style='width:100px;' type='text' name='c_location[]' value='"+this.location+"' class ='form-control' /></td>"+
                        "<td>"+config+"</td>"+
                     '</tr>';
                  $("#configTableBody").append(tr);
                 });

          });
        } else {
          toastr.warning("حدث خطاء! حاول مرة اخرى.");
        }

      },
      error: function(e) {
        toastr.error("خطأ!");
        console.log(e);
      }
    });
  }
  function updateProduct(){
    editProductForm
  }
  function updateProduct() {
    var myform = document.getElementById('editProductForm');
    var fd = new FormData(myform);
    $.ajax({
      url: "script/_updateFullProduct.php",
      type: "POST",
      beforeSend: function() {
        $("#editProductForm").addClass('loading');
      },
      data: fd,
      processData: false, // tell jQuery not to process the data
      contentType: false,
      cache: false,
      success: function(res) {
        $("#editProductForm").removeClass('loading');
        console.log(res);
        if (res.success == 1) {
          $('#editProductModal').modal('hide');
          getProducts();
          toastr.success("تم تحديث المنتج");
        } else {
          $("#e_product_id_err").text(res.error.id);
          $("#e_name_err").text(res.error.name);
          $("#e_sku_err").text(res.error.sku);
          $("#e_qty_err").text(res.error.qty);
          $("#e_price_err").text(res.error.price);
          $("#e_buy_price_err").text(res.error.buy_price);
          $("#e_location_err").text(res.error.location);
          $("#e_img_err").text(res.error.img);
          toastr.warning("يوجد بعض الاخطاء");
        }
      },
      error: function(e) {
        $("#editProductForm").removeClass('loading');
        toastr.error("خطأ");
        console.log(e);
      }
    });
  }
  function hideProduct(id){
    $.ajax({
      url: "script/_hideProduct.php",
      type: "POST",
      data: {
        id: id
      },
      success: function(res) {
        getProducts();
        if (res.success == 1) {
          toastr.success("تم");
        } else {
          toastr.warning("حدث خطاء! حاول مرة اخرى.");
        }

      },
      error: function(e) {
        toastr.error("خطأ!");
        console.log(e);
      }
    });
  }
  function displayProduct(id){
    $.ajax({
      url: "script/_displayProduct.php",
      type: "POST",
      data: {
        id: id
      },
      success: function(res) {
        getProducts();
        if (res.success == 1) {
          toastr.success("تم");
        } else {
          toastr.warning("حدث خطاء! حاول مرة اخرى.");
        }

      },
      error: function(e) {
        toastr.error("خطأ!");
        console.log(e);
      }
    });
  }
</script>
