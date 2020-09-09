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
              <th><input id="allselector" type="checkbox"></th>
              <th>صور</th>
              <th>SKU</th>
              <th>تعديل</th>
              <th>السعر</th>
              <th>الكمية</th>
              <th>اسم المنتج</th>
              <th>صفات المنتج</th>
              <th>السوق</th>


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
        <hr />
        <?php if ($_SESSION['role'] != 4) { ?>
          <fieldset>
            <legend>التحديثات</legend>
            <div class="row kt-margin-b-20">
              <div class="col-lg-3 kt-margin-b-10-tablet-and-mobile">
                <label>افعل مع المحدد:</label>
                <select id="action" onchange="disable()" name="action" class="selectpicker form-control kt-input" data-col-index="2">
                  <option value="">... اختر ...</option>
                  <option value="delete">حذف جميع المنتجات المحددة</option>
                </select>
              </div>
              <!--            <div class="col-lg-2 kt-margin-b-10-tablet-and-mobile">
            	<label>الخصم:</label>
            	<input type="number" class="form-control" value="0" step="250"  id="discount" name="discount"/>
            </div>-->
              <div class="col-lg-2 kt-margin-b-10-tablet-and-mobile">
                <label>تنفيذ:</label>
                <input type="button" onclick="runAction()" class="form-control btn btn-success" value="نفذ" />
              </div>
            </div>
          </fieldset>
        <?php } ?>
      </form>
      <!--end: Datatable -->
    </div>
  </div>
</div>
<!-- end:: Content -->
<div class="modal fade" id="basketProductModal" role="dialog">
  <div class="modal-dialog">
    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">اضافة للسلة</h4>
      </div>
      <div class="modal-body">
        <!--Begin:: App Content-->
        <div class="kt-grid__item kt-grid__item--fluid kt-app__content">
          <div class="kt-portlet">
            <form class="kt-form kt-form--label-right" id="addToBasketForm">
              <div class="kt-portlet__body">
                <div class="kt-section kt-section--first">
                  <div class="kt-section__body">
                    <div class="form-group row">
                      <div class="col-lg-6 kt-margin-b-10-tablet-and-mobile">
                        <label>السلة</label>
                        <select data-live-search="true" class="selectpicker form-control" id="basket" name="basket">
                        </select>
                        <span class="form-text text-danger" id="basket_err"></span>
                      </div>
                      <div class="col-lg-6 kt-margin-b-10-tablet-and-mobile">
                        <label>الكمية</label>
                        <input type="number" step="1" min="1" max="100" id="qty" name="qty" value="1" class="form-control" />
                        <span class="form-text text-danger" id="qty_err"></span>
                      </div>
                    </div>
                    <div class="form-group row">
                      <div class="col-lg-6 kt-margin-b-10-tablet-and-mobile">
                        <label>انشاء سله</label><br />
                        <button type="button" class="btn btn-warning" data-toggle="modal" data-target="#addBasketModal" id="addNewBasket" name="addNewBasket">انشاء سلة جديدة</button>
                      </div>
                      <div class="col-lg-6 kt-margin-b-10-tablet-and-mobile">
                        <label>تحضر سلة موجودة</label><br />
                        <button type="button" class="btn btn-info" data-toggle="modal" data-target="#editBasketModal" id="editNewBasket" name="addNewBasket">تحضير سلة</button>
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
                      <input type="hidden" id="product_id" name="product_id" />
                      <button type="button" onclick="addToBasket()" class="btn btn-success">اضافة المنتج للسلة</button>&nbsp;
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
<div class="modal fade" id="addBasketModal" role="dialog">
  <div class="modal-dialog">
    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">انشاء سلة جديدة</h4>
      </div>
      <div class="modal-body">
        <!--Begin:: App Content-->
        <div class="kt-grid__item kt-grid__item--fluid kt-app__content">
          <div class="kt-portlet">
            <form class="kt-form kt-form--label-right" id="addBasketForm">
              <div class="kt-portlet__body">
                <div class="kt-section kt-section--first">
                  <div class="kt-section__body">
                    <div class="form-group row">
                      <div class="col-lg-6 kt-margin-b-10-tablet-and-mobile">
                        <label>اسم الزبون</label>
                        <input type="text" class="form-control" id="customer_name" name="customer_name" />
                        <span class="form-text text-danger" id="customer_name_err"></span>
                      </div>
                      <div class="col-lg-6 kt-margin-b-10-tablet-and-mobile">
                        <label>رقم هاتف الزبون</label><br />
                        <input type="text" onkeydown="getOldOrder()" class="form-control" id="customer_phone" name="customer_phone" />
                        <span class="form-text text-danger" id="customer_phone_err"></span>
                      </div>
                    </div>
                    <div class="form-group row">
                      <div class="col-lg-6 kt-margin-b-10-tablet-and-mobile">
                        <label>المدينة</label>
                        <select data-live-search="true" onchange="getTowns($('#town'),$(this).val());" class="selectpicker form-control" id="city" name="city"></select>
                        <span class="form-text text-danger" id="city_err"></span>
                      </div>
                      <div class="col-lg-6 kt-margin-b-10-tablet-and-mobile">
                        <label>القضاء او الناحية او المنطقة</label><br />
                        <select data-live-search="true" class="selectpicker form-control" id="town" name="town"></select>
                        <span class="form-text text-danger" id="town_err"></span>
                      </div>
                    </div>
                    <div class="form-group row">
                      <div class="col-lg-6 kt-margin-b-10-tablet-and-mobile">
                        <label>تفاصيل العنوان</label>
                        <textarea type="text" class="form-control" id="address" name="address"></textarea>
                        <span class="form-text text-danger" id="address_err"></span>
                      </div>
                      <div class="col-lg-6 kt-margin-b-10-tablet-and-mobile">
                        <label>ملاحظه</label>
                        <textarea type="text" class="form-control" id="note" name="note"></textarea>
                        <span class="form-text text-danger" id="note_err"></span>
                      </div>
                      <div class="col-lg-6 kt-margin-b-10-tablet-and-mobile">
                        <label>استبدال؟</label><br />
                        <input type="checkbox" onclick="replaceStatus()" value="2" id="replace" name="replace" />
                        <span class="form-text text-danger" id="replace_err"></span>
                      </div>
                      <div style="display: none;" class="col-lg-6 kt-margin-b-10-tablet-and-mobile" id="oldOrderDiv">
                        <label>الطلب السابق</label><br />
                        <select class="selectpicker form-control" id="oldOrders" name="oldOrder">
                          <option>--اختر الطلب--</option>
                        </select>
                        <span class="form-text text-danger" id="oldOrder_err"></span>
                      </div>
                    </div>
                    <span class="form-text text-danger" id="staff_password_err"></span>
                  </div>
                </div>

              </div>
              <div class="kt-portlet__foot">
                <div class="kt-form__actions">
                  <div class="row">
                    <div class="col-lg-3 col-xl-3">
                    </div>
                    <div class="col-lg-9 col-xl-9">
                      <button type="button" onclick="createBasket()" class="btn btn-success">انشاء السلة</button>&nbsp;
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
<div class="modal fade" id="editBasketModal" role="dialog">
  <div class="modal-dialog">
    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">تحضر سلة</h4>
      </div>
      <div class="modal-body">
        <!--Begin:: App Content-->
        <div class="kt-grid__item kt-grid__item--fluid kt-app__content">
          <div class="kt-portlet">
            <form class="kt-form kt-form--label-right" id="editBasketForm">
              <div class="kt-portlet__body">
                <div class="kt-section kt-section--first">
                  <div class="kt-section__body">
                    <div class="form-group row">
                      <div class="col-lg-12 kt-margin-b-10-tablet-and-mobile">
                        <label>السلة</label>
                        <select data-live-search="true" class="selectpicker form-control" id="e_basket_id" name="e_basket_id">
                        </select>
                        <span class="form-text text-danger" id="e_basked_id_err"></span>
                      </div>
                    </div>
                    <div class="form-group row">
                      <div class="col-lg-6 kt-margin-b-10-tablet-and-mobile">
                        <label>اسم الزبون</label>
                        <input type="text" class="form-control" id="e_customer_name" name="e_customer_name" />
                        <span class="form-text text-danger" id="e_customer_name_err"></span>
                      </div>
                      <div class="col-lg-6 kt-margin-b-10-tablet-and-mobile">
                        <label>رقم هاتف الزبون</label><br />
                        <input type="text" onkeydown="e_getOldOrder()" class="form-control" id="e_customer_phone" name="e_customer_phone" />
                        <span class="form-text text-danger" id="e_customer_phone_err"></span>
                      </div>
                    </div>
                    <div class="form-group row">
                      <div class="col-lg-6 kt-margin-b-10-tablet-and-mobile">
                        <label>المدينة</label>
                        <select data-live-search="true" onchange="getTowns($('#e_town'),$(this).val());" class="selectpicker form-control" id="e_city" name="e_city"></select>
                        <span class="form-text text-danger" id="e_city_err"></span>
                      </div>
                      <div class="col-lg-6 kt-margin-b-10-tablet-and-mobile">
                        <label>القضاء او الناحية او المنطقة</label><br />
                        <select data-live-search="true" class="selectpicker form-control" id="e_town" name="e_town"></select>
                        <span class="form-text text-danger" id="e_town_err"></span>
                      </div>
                    </div>
                    <div class="form-group row">
                      <div class="col-lg-6 kt-margin-b-10-tablet-and-mobile">
                        <label>تفاصيل العنوان</label>
                        <textarea type="text" class="form-control" id="e_address" name="e_address"></textarea>
                        <span class="form-text text-danger" id="e_address_err"></span>
                      </div>
                      <div class="col-lg-6 kt-margin-b-10-tablet-and-mobile">
                        <label>ملاحظه</label>
                        <textarea type="text" class="form-control" id="e_note" name="e_note"></textarea>
                        <span class="form-text text-danger" id="e_address_err"></span>
                      </div>
                      <div class="col-lg-6 kt-margin-b-10-tablet-and-mobile">
                        <label>استبدال؟</label><br />
                        <input type="checkbox" onclick="e_replaceStatus()" value="2" id="e_replace" name="e_replace" />
                        <span class="form-text text-danger" id="replace_err"></span>
                      </div>
                      <div style="display: none;" class="col-lg-6 kt-margin-b-10-tablet-and-mobile" id="e_oldOrderDiv">
                        <label>الطلب السابق</label><br />
                        <select class="selectpicker form-control" id="e_oldOrders" name="e_oldOrder">
                          <option>--اختر الطلب--</option>
                        </select>
                        <span class="form-text text-danger" id="e_oldOrder_err"></span>
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
                      <button type="button" onclick="updateBasket()" class="btn btn-danger">تحديث معلومات السلة</button>&nbsp;
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
<div class="modal fade" id="editProduct" role="dialog">
  <div class="modal-dialog">
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
                      <div class="col-lg-12 kt-margin-b-10-tablet-and-mobile">
                        <label>صوره</label>
                        <input type="file" class="form-control" id="e_img" name="e_img" />
                        <span class="form-text text-danger" id="e_customer_name_err"></span>
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
                    <div class="form-group row">
                      <div class="col-lg-6 kt-margin-b-10-tablet-and-mobile">
                        <label>الكميه</label>
                        <input type="number" class="form-control" id="e_qty" name="e_qty" />
                        <span class="form-text text-danger" id="e_qty_err"></span>
                      </div>
                      <div class="col-lg-6 kt-margin-b-10-tablet-and-mobile">
                        <label>الموقع</label><br />
                        <input type="text" class="form-control" id="e_location" name="e_location" />
                        <span class="form-text text-danger" id="e_location_err"></span>
                      </div>
                      <input type="hidden" id="e_product_id" name="e_product_id" />
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
<script src="js/getBraches.js" type="text/javascript"></script>
<script src="js/getClients.js" type="text/javascript"></script>
<script src="js/getorderStatus.js" type="text/javascript"></script>
<script src="js/getBasketByStaff.js" type="text/javascript"></script>
<script src="js/getCities.js" type="text/javascript"></script>
<script src="js/getTowns.js" type="text/javascript"></script>
<script type="text/javascript">
  getBasketByStaff($('#basket'));
  getBasketByStaff($('#e_basket_id'));
  getCities($('#city'));
  getCities($('#e_city'));
  getTowns($('#town'), 1);
  getTowns($('#e_town'), 1);

  function getProducts() {
    $.ajax({
      url: "script/_getProducts.php",
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
            btn = '<button type="button" class="btn btn-clean fa-2x text-info"    onclick="editProduct(' + this.c_id + ')" data-toggle="modal" data-target="#editProduct"><span class="flaticon-edit"></sapn></button>' +
              '<button type="button" class="btn btn-clean fa-2x text-danger"  onclick="deleteProduct(' + this.c_id + ')" data-toggle="modal" data-target="#deleteProduct"><span class="flaticon-delete"></sapn></button>' +
              '<button type="button" class="btn btn-clean fa-2x text-success" onclick="openBasket(' + this.c_id + ')" data-toggle="modal" data-target="#basketProductModal"><span class="flaticon-shopping-basket"></sapn> شراء</button>' +
              '';
          } else {
            btn = '<button type="button" class="btn btn-clean fa-2x text-success" onclick="openBasket(' + this.c_id + ')" data-toggle="modal" data-target="#basketProductModal"><span class="flaticon-shopping-basket"></sapn> شراء</button>';
          }
          if (this.qty <= 0) {
            btn = '<button type="button" class="btn btn-clean text-info"    onclick="editProduct(' + this.c_id + ')" data-toggle="modal" data-target="#editProduct"><span class="flaticon-edit"></sapn></button>' +
              '<button type="button" class="btn btn-clean text-danger"  onclick="deleteProduct(' + this.c_id + ')" data-toggle="modal" data-target="#deleteProduct"><span class="flaticon-delete"></sapn></button>' +
              '<span type="button" class="text-warning">غير متوفر</span>' +
              '';
          }
          attribute = "";
          $.each(this.attribute, function() {
            attribute = attribute + "<b> " + this.name + "</b> : " + this.value + "&nbsp;&nbsp;&nbsp;&nbsp;";
          });
          $("#productTable").append(
            '<tr>' +
            '<td><input type="checkbox" name="id[]" rowid="' + this.c_id + '"></td>' +
            '<td><div style="background-image:url(img/product/' + this.path + ');" class="item-img-sm"></div></td>' +
            '<td>' + this.sku + '</td>' +
            '<td width="150px">' +
            btn +
            '</td>' +
            '<td>' + this.price + '</td>' +
            '<td>' + this.qty + '</td>' +
            '<td>' + this.sub_name + '</td>' +
            '<td>' + attribute + '</td>' +
            '<td>' + this.store_name + '</td>' +
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

  function getOldOrder() {

    if ($("#customer_phone").val().length >= 10 && $("#customer_phone").val().length <= 16) {

      $.ajax({
        url: "script/_getCustomerOldOrders.php",
        type: "POST",
        beforeSend: function() {
          $("#addToBasketForm").addClass('loading');
        },
        data: {
          phone: $("#customer_phone").val()
        },
        success: function(res) {
          $("#addToBasketForm").removeClass('loading');
          console.log(res);
          $("#oldOrders").html("");
          if (res.success == 1) {
            $("#oldOrders").append(
              '<option value="">-- اختر الطلب السابق --</option>'
            )
            $.each(res.data, function() {
              $("#oldOrders").append(
                '<option value="' + this.id + '">' + this.order_no + '</option>'
              )
            });
            $("#oldOrders").selectpicker("refresh");
          }
        },
        error: function(e) {
          $("#addToBasketForm").removeClass('loading');
          toastr.error("خطأ");
          console.log(e);
        }
      });
    }
  }

  function e_getOldOrder() {

    if ($("#e_customer_phone").val().length >= 10 && $("#e_customer_phone").val().length <= 16) {

      $.ajax({
        url: "script/_getCustomerOldOrders.php",
        type: "POST",
        beforeSend: function() {
          $("#addToBasketForm").addClass('loading');
        },
        data: {
          phone: $("#e_customer_phone").val()
        },
        success: function(res) {
          $("#addToBasketForm").removeClass('loading');
          console.log(res);
          $("#e_oldOrders").html("");
          if (res.success == 1) {
            $("#e_oldOrders").append(
              '<option value="">-- اختر الطلب السابق --</option>'
            )
            $.each(res.data, function() {
              $("#e_oldOrders").append(
                '<option value="' + this.id + '">' + this.order_no + '</option>'
              )
            });
            $("#e_oldOrders").selectpicker("refresh");
          }
        },
        error: function(e) {
          $("#addToBasketForm").removeClass('loading');
          toastr.error("خطأ");
          console.log(e);
        }
      });
    }
  }

  function getorderspage(page) {
    $("#p").val(page);
    getProducts();
  }
  getClients($("#client"));

  function getclient() {
    getClients($("#client"), $("#branch").val());
    getProducts();
    getAllDrivers($("#driver_action"), $("#branch").val());
  }

  function replaceStatus() {
    if ($("#replace").is(':checked')) {
      $("#oldOrderDiv").css("display", 'inline-block');
    } else {
      $("#oldOrderDiv").css("display", 'none');
    }
  }

  function e_replaceStatus() {
    if ($("#e_replace").is(':checked')) {
      $("#e_oldOrderDiv").css("display", 'inline-block');
    } else {
      $("#e_oldOrderDiv").css("display", 'none');
    }
  }

  function openBasket(id) {
    $("#product_id").val(id);
  }

  function addToBasket() {
    $.ajax({
      url: "script/_addToBasket.php",
      type: "POST",
      beforeSend: function() {
        $("#addToBasketForm").addClass('loading');
      },
      data: $("#addToBasketForm").serialize(),
      success: function(res) {
        $("#addToBasketForm").removeClass('loading');
        console.log(res);
        if (res.success == 1) {
          toastr.success("تم اضافة المنتج الى السلة");
        } else {
          $("#basked_id_err").text(res.error.basket);
          $("#qty_err").text(res.error.qty);
          if (res.error.msg == "") {
            toastr.warning("يوجد بعض الاخطاء");
          } else {
            toastr.warning(res.error.msg);
          }

        }
      },
      error: function(e) {
        $("#addToBasketForm").removeClass('loading');
        toastr.error("خطأ");
        console.log(e);
      }
    });
  }

  function createBasket() {
    $.ajax({
      url: "script/_createBasket.php",
      type: "POST",
      beforeSend: function() {
        $("#addBasketForm").addClass('loading');
      },
      data: $("#addBasketForm").serialize(),
      success: function(res) {
        $("#addBasketForm").removeClass('loading');
        console.log(res);
        if (res.success == 1) {
          getBasketByStaff($('#basket'));
          getBasketByStaff($('#e_basket_id'));
          toastr.success("تم انشاء السلة");
        } else {
          $("#customer_name_err").text(res.error.customer_name);
          $("#customer_phone_err").text(res.error.customer_phone);
          $("#city_err").text(res.error.city);
          $("#town_err").text(res.error.town);
          $("#address_err").text(res.error.address);
          $("#note_err").text(res.error.note);
          $("#oldOrder_err").text(res.error.oldOrder);
          toastr.warning("يوجد بعض الاخطاء");
          if (res.max !== "") {
            toastr.warning(res.max);
          }
        }
      },
      error: function(e) {
        $("#addBasketForm").removeClass('loading');
        toastr.error("خطأ");
        console.log(e);
      }
    });
  }

  function updateBasket() {
    $.ajax({
      url: "script/_updateBasket.php",
      type: "POST",
      beforeSend: function() {
        $("").addClass('loading');
      },
      data: $("#editBasketForm").serialize(),
      success: function(res) {
        console.log(res);
        if (res.success == 1) {
          getBasketByStaff($('#basket'));
          getBasketByStaff($('#e_basket_id'));
          toastr.success("تم تحديث السلة");
        } else {
          $("#e_basked_id_err").text(res.error.id);
          $("#e_customer_name_err").text(res.error.customer_name);
          $("#e_customer_phone_err").text(res.error.customer_phone);
          $("#e_city_err").text(res.error.city);
          $("#e_town_err").text(res.error.town);
          $("#e_address_err").text(res.error.address);
          $("#e_note_err").text(res.error.note);
          $("#e_oldOrder_err").text(res.error.oldOrder);
          toastr.warning("يوجد بعض الاخطاء");
        }
      },
      error: function(e) {
        toastr.error("خطأ");
        console.log(e);
      }
    });
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

  function runAction() {
    $('input[name="ids\[\]"]', form).remove();
    var form = $('#producttabledata');
    $.each($('input[name="id\[\]"]:checked'), function() {
      rowId = $(this).attr('rowid');
      form.append(
        $('<input>')
        .attr('type', 'hidden')
        .attr('name', 'ids[]')
        .val(rowId)
      );
    });

    $.ajax({
      url: "script/_runAction.php",
      type: "POST",
      data: $("#producttabledata").serialize(),
      success: function(res) {
        getProducts();
        console.log(res);
        if (res.success == 1) {
          toastr.success("تم التحديث بنجاح");
        } else {
          toastr.warning("حدث خطاء! حاول مرة اخرى. تاكدد من تحديد عنصر واحد على اقل تقدير");
        }
      },
      error: function(e) {
        toastr.error("خطأ!");
        console.log(e);
      }
    });

    // Remove added elements
    //$('input[name="id\[\]"]', form).remove();
  }

  function disable() {
    $('.selectpicker').selectpicker('refresh');
    console.log($("#action").val());
  }

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
      url: "script/_getProduct.php",
      type: "POST",
      data: {
        id: id
      },
      success: function(res) {
        getProducts();
        console.log(res);

        if (res.success == 1) {
          $.each(res.data, function() {
            $("#e_name").val(this.sub_name);
            $("#e_sku").val(this.sku);
            $("#e_qty").val(this.qty);
            $("#e_location").val(this.location);
            $("#e_buy_price").val(this.buy_price);
            $("#e_price").val(this.price);
            $("#e_product_id").val(id);
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

  function updateProduct() {
    var myform = document.getElementById('editProductForm');
    var fd = new FormData(myform);
    $.ajax({
      url: "script/_updateConfigrableProduct.php",
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
</script>

<div class="modal fade" id="editorderStatusModal" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">تحديث حالة الطلب</h4>
      </div>
      <div class="modal-body">
        <!--begin::Portlet-->
        <div class="kt-portlet">

          <!--begin::Form-->
          <form class="kt-form" id="addClientForm">
            <div class="kt-portlet__body">
              <div class="form-group">
                <label>الحالة</label>
                <select data-show-subtext="true" data-live-search="true" type="text" class="selectpicker form-control dropdown-primary" name="orderStatus" id="orderStatus" value="">
                </select>
                <span class="form-text text-danger" id="orderStatus_err"></span>
              </div>
              <div class="form-group">
                <label>ملاحظات:</label>
                <input type="name" name="rderStatus_note" class="form-control" placeholder="">
                <span class="form-text  text-danger" id="orderStatus_note_err"></span>
              </div>
              <div class="input-group date">
                <input size="16" type="text" readonly class="form-control form_datetime" placeholder="الوقت والتاريخ" id="orderStatus_date">
                <div class="input-group-append">
                  <span class="input-group-text">
                    <i class="la la-calendar glyphicon-th"></i>
                  </span>
                </div>
                <span class="form-text  text-danger" id="orderStatus_date_err"></span>
              </div>
            </div>
            <div class="kt-portlet__foot kt-portlet__foot--solid">
              <div class="kt-form__actions kt-form__actions--right">
                <button type="button" onclick="addClient()" class="btn btn-brand">اضافة</button>
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
<!--begin::Page Scripts(used by this page) -->
<script src="./assets/js/pages/components/forms/widgets/bootstrap-datetimepicker.js" type="text/javascript"></script>