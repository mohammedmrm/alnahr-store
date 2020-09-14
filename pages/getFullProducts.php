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
    .padding-10 {
      padding: 10px;
    }
    .price {
      font-size: 16px;
      font-weight: bold;
      color: #990000;
    }
.preview {
  display: -webkit-box;
  display: -webkit-flex;
  display: -ms-flexbox;
  display: flex;
  -webkit-box-orient: vertical;
  -webkit-box-direction: normal;
  -webkit-flex-direction: column;
      -ms-flex-direction: column;
          flex-direction: column; }
  @media screen and (max-width: 996px) {
    .preview {
      margin-bottom: 20px; } }

.preview-pic {
  -webkit-box-flex: 1;
  -webkit-flex-grow: 1;
      -ms-flex-positive: 1;
          flex-grow: 1; }

.preview-thumbnail.nav-tabs {
  border: none;
  margin-top: 15px; }
.preview-thumbnail.nav-tabs li {
width: 18%;
margin-right: 2.5%; }
.preview-thumbnail.nav-tabs li img {
  max-width: 100%;
  display: block; }
.preview-thumbnail.nav-tabs li a {
  padding: 0;
  max-width: 100%;
  margin: 0; }
.preview-thumbnail.nav-tabs li:last-of-type {
  margin-right: 0; }

.tab-content {
  overflow: hidden; }
  .tab-content img {
    -webkit-animation-name: opacity;
            animation-name: opacity;
    -webkit-animation-duration: .3s;
            animation-duration: .3s; }

.card {
  margin-top: 50px;
  background: #eee;
  padding: 3em;
  line-height: 1.5em; }

@media screen and (min-width: 997px) {
  .wrapper {
    display: -webkit-box;
    display: -webkit-flex;
    display: -ms-flexbox;
    display: flex; } }

.details {
  display: -webkit-box;
  display: -webkit-flex;
  display: -ms-flexbox;
  display: flex;
  -webkit-box-orient: vertical;
  -webkit-box-direction: normal;
  -webkit-flex-direction: column;
      -ms-flex-direction: column;
          flex-direction: column; }

.colors {
  -webkit-box-flex: 1;
  -webkit-flex-grow: 1;
      -ms-flex-positive: 1;
          flex-grow: 1; }

.product-title, .price, .sizes, .colors {
  text-transform: UPPERCASE;
  font-weight: bold; }

.checked, .price span {
  color: #ff9f1a; }

.product-title, .rating, .product-description, .price, .vote, .sizes {
  margin-bottom: 15px; }

.product-title {
  margin-top: 0;
}

.thump {
  width:80px;
  min-height:80px;
  border: 1px solid #B3B3B3;
  border-radius: 5px;
  background-position: center;
  background-repeat: no-repeat;
  background-size: contain;
  background-color: #FFFFFF;
  margin: 1px;
  float: left;
}
#img{
 border-radius: 5px;
}
.kt-widget-6__item {
  margin-right: 0 !important;
}

</style>

<!-- begin:: Content -->
<div class="kt-container  kt-container--fluid  kt-grid__item kt-grid__item--fluid">
       <div class="kt-portlet__head">
            <div class="kt-portlet__head-label">
                <h3 class="kt-portlet__head-title">
                    الطلبيات
                </h3>
            </div>
        </div>
        <form id="producttabledata" action="#">
        <div class="kt-portlet__body  bg-white padding-10">
          <div class="kt-widget-6">
            <!-- begin::Tab Content -->
            <div class="kt-widget6__tab tab-content">
                <div class="row">
                  <div class="form-group ">
                    <div class="input-group input-group-lg">
                    <input type="text"  name="search" class="form-control" placeholder="بحث" aria-describedby="basic-addon1">
                    </div>
                  </div>
                </div>
                <hr /><!-- --------------- -->
                <div id="kt_personal_income_quater_15d3532e15cc23" class="tab-pane fade active show">
                    <div class="kt-widget-6__items row" id="product-grid">
                    </div>
                    <hr />
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
            </div>
            <!-- end::Tab Content -->
        </div>
        </div>
</div>
</form>
<div class="modal fade" id="productDetails" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
     <div class="modal-header">
        <h5 class="modal-title" id="gridModalLabel">تفاصيل المنتج</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
     </div>
     <div class="modal-body">
     <form id="productDataForm">
		<div class="">
			<div class="container-fliud">
				<div class="wrapper row">
					<div class="details col-xl-5">
						<h3 class="product-title h1" id="title">اسم المنتج</h3>
						<p class="product-description" id="des">
                           وصف المنتج
                        </p>
						<h4 class="price" id="price">سعر المنتج</h4>
						<p class="vote"></p>
						<div class="options" id="options">
                        </div>
                        <hr />
						<div class="action">
							<button class="add-to-cart btn btn-default" data-toggle="modal" data-target="#baskets" type="button">اضافه للسله</button>
							<button class="like btn btn-default" onclick="editProduct()" data-toggle="modal" data-target="#editProduct" type="button"><span class="fa fa-edit"></span></button>
							<button class="like btn btn-default" onclick="deleteProduct()" type="button"><span class="fa fa-trash"></span></button>
						</div>
					</div>
					<div class="preview col-xl-5">
                        <div class="preview-pic tab-content">
						  <div class="tab-pane active" id="pic-1">
                          <img id="img" style="width:100%;" src="http://placekitten.com/400/252" />
                          </div>
					   </div>
					</div>
                    <div class="col-xl-2" id="thumpnail">
					</div>
				</div>
			</div>
		</div>
     </form>
    </div>
    </div>
  </div>
</div>
</div>
<div class="modal fade" id="editProduct" role="dialog">
  <div class="modal-dialog modal-lg">
    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
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
                        <label>اسم المنتج</label>
                        <input  type="text" class="form-control" id="e_name" name="e_name"/>
                        <span class="form-text text-danger" id="e_name_err"></span>
                      </div>
                    </div>
                    <div class="form-group row">
                      <div class="col-lg-6 kt-margin-b-10-tablet-and-mobile">
                        <label>سعر المنتج</label>
                        <input type="number" step="250" min="0" class="form-control" id="e_price" name="e_price" />
                        <span class="form-text text-danger" id="e_price_err"></span>
                      </div>
                      <div class="col-lg-6 kt-margin-b-10-tablet-and-mobile">
                        <label>تعديل السعر للمنتجات الفرعيه</label><br />
                        <input type="checkbox" value="checked" value="1" checked  class="form-control" id="e_price_forall" name="e_price_forall" />
                        <span class="form-text text-danger" id="e_price_forall_err"></span>
                      </div>
                    </div>
                    <div class="form-group row">
                      <div class="col-lg-12 kt-margin-b-10-tablet-and-mobile">
                        <label>الصور</label>
                        <input type="file" multiple="multiple" class="form-control" id="e_img" name="e_img[]" />
                        <span class="form-text text-danger" id="e_img_err"></span>
                      </div>
                    </div>
                    <div class="form-group row">
                      <div class="col-lg-12 kt-margin-b-10-tablet-and-mobile">
                        <label>الوصف المختصر</label>
                        <textarea type="text" class="form-control" id="e_simple_des" name="e_simple_des"></textarea>
                        <span class="form-text text-danger" id="e_simple_des_err"></span>
                      </div>
                      <div class="col-lg-12 kt-margin-b-10-tablet-and-mobile">
                        <label>الوصف</label>
                        <textarea type="text" class="form-control summernote" id="e_des" name="edes"></textarea>
                        <span class="form-text text-danger" id="e_des_err"></span>
                      </div>
                    </div>
                    <input type="hidden" id="e_product_id" name="e_product_id" />

                  </div>
                </div>

              </div>
              <div class="kt-portlet__foot">
                <div class="kt-form__actions">
                  <div class="row">
                    <div class="col-lg-3 col-xl-3">
                    </div>
                    <div class="col-lg-9 col-xl-9">
                      <button type="button" onclick="updateProduct()" class="btn btn-danger">تحديث</button>&nbsp;
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

<div class="modal fade" id="baskets" role="dialog">
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


$('.summernote').summernote();
    getBasketByStaff($('#basket'));
    getBasketByStaff($('#e_basket_id'));
    getCities($('#city'));
    getCities($('#e_city'));
    getTowns($('#town'), 1);
    getTowns($('#e_town'), 1);
    $(document).keydown(function(e) {
    if (event.which === 13 || event.keyCode === 13 ) {
        event.stopPropagation();
        event.preventDefault();
        getProducts();
    }
    });
    function getProducts() {
        $.ajax({
            url: "script/_getFullProducts.php",
            type: "POST",
            beforeSend: function() {
                $("#product-grid").addClass('loading');
            },
            data: $("#producttabledata").serialize(),
            success: function(res) {
                $("#tb-productTable").DataTable().destroy();
                console.log(res);
                $("#product-grid").html("");
                $("#pagination").html("");
                $("#product-grid").removeClass('loading');
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
                     $("#product-grid").append (
                       `<div class="kt-widget-6__item col-lg-4" onclick="getProductDetails(`+this.id+`);openBasket(`+this.id+`)" data-toggle="modal" data-target="#productDetails">
                            <div class="kt-widget-6__item-pic">
                                <img class=""  src="img/product/`+this.img+`" alt="صوره المنتج" onerror="this.onerror=null; this.src='img/default.svg'">
                            </div>
                            <div class="kt-widget-6__item-info">
                                <div class="kt-widget-6__item-title h3">
                                    `+this.name+`
                                </div>
                                <div class="price" >
                                     `+this.price+` دينار
                                </div>

                                <div class="kt-widget-6__item-desc">
                                    `+this.simple_des+`
                                </div>
                            </div>
                        </div>`
                       )
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
            url: "script/_addToBasket2.php",
            type: "POST",
            beforeSend: function() {
                $("#addToBasketForm").addClass('loading');
            },
            data: $("#productDataForm").serialize()+'&basket='+$("#basket").val()+'&qty='+$("#qty").val()+'&product_id='+$("#product_id").val(),
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
function getProductDetails(id){
        $.ajax({
            url: "script/_getProductDetails.php",
            type: "POST",
            beforeSend: function() {
                $("#productDetails").addClass('loading');
            },
            data: {id: id},
            success: function(res) {
              $("#productDetails").removeClass('loading');
              console.log(res);
              if (res.success == 1) {
                $.each(res.data,function(){
                  $("#title").text(this.name);
                  $("#price").text(this.price+' دينار عراقي');
                  $("#des").text(this.simple_des);
                  $("#img").attr("src",'img/product/'+this.img);

                  ///-----add thumpnails-----------
                  $("#thumpnail").html("");
                  $.each(this.images,function(){
                      $("#thumpnail").append(
                      '<div onmouseover="setImg(\'img/product/'+this.path+'\')" class="thump col" style="background-image:url(img/product/'+this.path+')"></div>'
                      )
                  });
                  ///-----add thumpnails-----------
                  $('#options').html("");
                  $.each(this.attribute,function(){
                      attr = '<h4>'+this.name+':</h4>';
                      attr += '<select name="config[]" style="min-width:100px;height:30px;">';
                      $.each(this.config,function(){
                        attr += '<option value="'+this.id+'">'+this.value+'</option>';
                      });
                      attr += '</select>';
                      $('#options').append(attr);
                  });
                });
              }
            },
            error: function(e) {
                $("#productDetails").removeClass('loading');
                toastr.error("خطأ");
                console.log(e);
            }
        });
}

function setImg(path){
  $("#img").attr('src',path);
  console.log(path);
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

    function deleteProduct() {
      if(confirm("هل انت متاكد من حذف المنتج")){
        $.ajax({
            url: "script/_deleteFullProduct.php",
            type: "POST",
            data: {id: $("#product_id").val()},
            success: function(res) {

                console.log(res);
                if (res.success == 1) {
                    toastr.success("تم حذف المنتج");
                    getProducts();
                    $('.modal').modal('hide');
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
    }

    function editProduct() {
        $("#e_product_id").val($("#product_id").val());
        $.ajax({
            url: "script/_getProductDetails.php",
            type: "POST",
            data: {
                id: $("#product_id").val()
            },
            success: function(res) {
                $(".text-dange").text("");
                console.log(res);
                if (res.success == 1) {
                    $.each(res.data, function() {
                        $("#e_name").val(this.name);
                        $("#e_price").val(this.price);
                        $("#e_simple_des").val(this.simple_des);
                        $("#e_des").val(this.des);
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
            url: "script/_updateProduct.php",
            type: "POST",
            beforeSend: function() {
                $("#editProductForm").addClass('loading');
                $(".text-dange").text("");
            },
            data: fd,
            processData: false, // tell jQuery not to process the data
            contentType: false,
            cache: false,
            success: function(res) {
                $("#editProductForm").removeClass('loading');
                console.log(res);
                if (res.success == 1) {
                    $('#editProduct').modal('hide');
                    getProducts();
                    toastr.success("تم تحديث المنتج");
                } else {
                    $("#e_name_err").text(res.error.name);
                    $("#e_simple_des_err").text(res.error.simple_des);
                    $("#e_des_err").text(res.error.des);
                    $("#e_price_err").text(res.error.price);
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