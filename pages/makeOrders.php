
<div class="kt-portlet kt-portlet--tabs">
             <fieldset><legend>السوق (الصفحة او البيج)</legend>
                 <div class="form-group">
                       <div class="form-input col-lg-2">
                            <select class="selectpicker form-control" id="store" name="store"></select>
                       </div>
                 </div>
            </fieldset>
            <div class="kt-portlet__head">
                <div class="kt-portlet__head-toolbar">
                    <ul class="nav nav-tabs  nav-tabs-line nav-tabs-line-2x nav-tabs-line-danger" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link fa-1x active" data-toggle="tab" href="#baskets" role="tab" aria-selected="false">
                                <i class="la la-cog"></i> تجهيز السلات
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link fa-1x" data-toggle="tab" href="#made" role="tab" aria-selected="false">
                                <i class="flaticon-list"></i> المجهزه
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link fa-1x" data-toggle="tab" href="#invoices" role="tab" aria-selected="true">
                                <i class="fa fa-file-pdf"></i> كشوفات
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="kt-portlet__body">
                <div class="tab-content">
                    <div class="tab-pane active" id="baskets" role="tabpanel">
                    <h1 class="fa-2x">السلات المطلوب تحضيرها</h1>
	                <table class="table table-striped  table-bordered responsive nowrap" style="white-space: nowrap;" id="tb-baskets">
        			       <thead>
        	  						<tr>
        										<th>رقم السلة</th>
        										<th>اسم الزبون</th>
        										<th>هاتف الزبون</th>
        										<th>عنوان الزبون</th>
                                                <th>عدد المنتجات</th>
        										<th>تاريخ الادخال</th>
                                                <th>تعديل</th>
        										<th>الحاله</th>
                                                <th>المدخل</th>
        		  					</tr>
              	            </thead>
                            <tbody id="basketsTable">
                            </tbody>
		            </table>

                    </div>
                    <div class="tab-pane" id="made" role="tabpanel">
                      <h1 class="fa-2x text-success">الطلبيات المجهزة</h1>
                    </div>
                    <div class="tab-pane" id="invoices" role="tabpanel">
                      الكشوفات
                    </div>
                </div>
            </div>
        </div>

<script src="js/getStores.js" type="text/javascript"></script>
<script src="js/getCities.js" type="text/javascript"></script>
<script src="js/getTowns.js" type="text/javascript"></script>
<script type="text/javascript">
$(document).ready(function(){
  getStores($("#store"));
  getCities($("#e_city"));
  getBasketForPerpare();
  $("#tb-baskets").DataTable({
        "oLanguage": {
          "sLengthMenu": "عرض_MENU_سجل",
          "sSearch": "بحث:"
        },
         "bPaginate": false,
         "bLengthChange": false,
         "bFilter": false,
  });
});

function getBasketForPerpare(store){
  $.ajax({
    url:"script/_getBasketForPerpare.php",
    type:"POST",
    data:{store: store},
    beforeSend:function(){
      $("#baskets").addClass("loading");
    },
    success:function(res){
      $("#tb-baskets").DataTable().destroy();
      $("#baskets").removeClass("loading");
      console.log(res);
      $.each(res.data,function(){
     $("#basketsTable").append(
       '<tr>'+
            '<td>'+this.id+'</td>'+
            '<td>'+this.customer_name+'</td>'+
            '<td>'+(this.customer_phone)+'</td>'+
            '<td>'+this.city+'/'+this.town+'/'+this.address+'</td>'+
            '<td>'+this.items+'</td>'+
            '<td>'+this.date+'</td>'+
            '<td>'+
                '<button type="button" class="btn btn-clean text-info"    onclick="editBasket('+this.basket_id+')" data-toggle="modal" data-target="#editBasketModal"><span class="flaticon-edit"></sapn></button>'+
                '<button type="button" class="btn btn-clean text-danger"  onclick="getBasketItems('+this.basket_id+')" data-toggle="modal" data-target="#basketItemsModal"><span class="flaticon-shopping-basket"></sapn></button>'+
                '<button type="button" class="btn btn-clean text-success" onclick="setOrderNo('+this.basket_id+')" data-toggle="modal" data-target="#setBasketToOrderModal" ><span class="flaticon2-arrow-up"></span></button>'+
            '</td>'+
            '<td>'+this.status+'</td>'+
            '<td>'+this.name+'</td>'+
          '</tr>');
      });
      $("#tb-baskets").DataTable({
        "oLanguage": {
          "sLengthMenu": "عرض_MENU_سجل",
          "sSearch": "بحث:"
        },
      });
    },
    error:function(e){
      $("#baskets").removeClass("loading");
      console.log(e);
    }
  });
}

function editBasket(id){
  $("#e_basket_id").val(id);
  $.ajax({
    url:"script/_getBasketByID.php",
    type:"POST",
    data:{id:id},
    success:function(res){
      $.each(res.data,function(){
        $("#e_customer_name").val(this.customer_name);
        $("#e_customer_phone").val(this.customer_phone);
        $("#e_city").val(this.city_id);
        getTowns($("#e_town"),this.city_id);
        $("#e_town").val(this.town_id);
        $("#e_address").val(this.address);
        $("#e_note").val(this.note);
        $(".selectpicker").selectpicker('refresh');
      })
    },
    error:function(e){
      console.log(res);
    }
  });
}
function updateBasket() {
$.ajax({
  url:"script/_updateBasket.php",
  type:"POST",
  beforeSend:function(){
    $("#editBasketForm").addClass('loading');
  },
  data:$("#editBasketForm").serialize(),
  success:function(res){
    $("#editBasketForm").removeClass('loading');
    console.log(res);
    if(res.success == 1){
      toastr.success("تم تحديث السلة");
    }else{
      toastr.warning("يوجد بعض الاخطاء");
      $("#e_basked_id_err").text(res.error.id);
      $("#e_customer_name_err").text(res.error.customer_name);
      $("#e_customer_phone_err").text(res.error.customer_phone);
      $("#e_city_err").text(res.error.city);
      $("#e_town_err").text(res.error.town);
      $("#e_address_err").text(res.error.address);
      $("#e_note_err").text(res.error.note);

    }
  },
  error:function(e){
    $("#editBasketForm").removeClass('loading');
    toastr.error("خطأ");
    console.log(e);
  }
});
}
function getBasketItems(basket_id){
  $.ajax({
    url:"script/_getBasketItems.php",
    type:"POST",
    data:{id:basket_id},
    success:function(res){
      console.log(res);
    $("#tb-basketItemsTable").DataTable().destroy();
    $("#basketItemsTable").html("");
    $.each(res.data,function(){
     $("#basketItemsTable").append(
       '<tr>'+
            '<td> <div style="background-image:url(img/product/'+this.path+')" class="item-img-sm"></div></td>'+
            '<td>'+this.sub_name+'</td>'+
            '<td>'+this.qty+'</td>'+
            '<td>'+this.status+'</td>'+
            '<td>'+
                '<button type="button"  data-toggle="tooltip" data-placement="top" title="حذف" class="btn btn-clean text-danger"    onclick="deleteItem('+this.bi_id+','+basket_id+')" data-toggle="modal" data-target="#editBasketModal"><span class="flaticon-delete"></sapn></button>'+
                '<button type="button" data-toggle="tooltip" data-placement="top" title="زيادة الكمية 1" class="btn btn-clean text-warning"  onclick="increaseItem('+this.bi_id+','+basket_id+')" data-toggle="modal" data-target="#basketItemsModal"><span class="flaticon-add"></sapn></button>'+
            '</td>'+
           '</tr>');
      });
      $("#tb-basketItemsTable").DataTable();
    },
    error:function(e){
      console.log(e);
    }
  });
}
function deleteItem(id,basket_id){
    $.ajax({
      url:"script/_deleteItemFromBasket.php",
      type:"POST",
      beforeSend:function(){
        $("#tb-basketItemsTable").addClass('loading');
      },
      data:{id:id},
      success:function(res){
        $("#tb-basketItemsTable").removeClass('loading');
        console.log(res);
        if(res.success == 1){
          toastr.success("تم حذف المنتج");
          getBasketItems(basket_id);
        }else{
          $("#basked_id_err").text(res.error.basket);
          toastr.warning("يوجد بعض الاخطاء");
        }
      },
      error:function(e){
        $("#tb-basketItemsTable").removeClass('loading');
        toastr.error("خطأ");
        console.log(e);
      }
    });
}
function increaseItem(id,basket_id){
    $.ajax({
      url:"script/_increaseItemQtyInBasket.php",
      type:"POST",
      beforeSend:function(){
        $("#tb-basketItemsTable").addClass('loading');
      },
      data:{id:id},
      success:function(res){
        $("#tb-basketItemsTable").removeClass('loading');
        console.log(res);
        if(res.success == 1){
          toastr.success("تم زيادة الكمية (1)");
          getBasketItems(basket_id);
        }else{
          $("#basked_id_err").text(res.error.basket);
          toastr.warning("يوجد بعض الاخطاء");
        }
      },
      error:function(e){
        $("#tb-basketItemsTable").removeClass('loading');
        toastr.error("خطأ");
        console.log(e);
      }
    });
}
function setBasketToOrders(id){
    $.ajax({
      url:"script/_setBasketToOrders.php",
      type:"POST",
      beforeSend:function(){
        $("#basketOrdersForm").addClass("loading");
      },
      data:$("#basketOrdersForm").serialize()+"&id="+id,
      success:function(res){
        $("#basketOrdersForm").removeClass("loading");
        console.log(res);
        if(res.success == 1){
          toastr.success('تم تسجيل الطلب');
          getBasketForPerpare('');
        }else{
          toastr.warning(res.msg);
        }
      },
      error:function(e){
        $("#basketOrdersForm").removeClass("loading");
        toastr.error("خطأ");
        console.log(e);
      }
    });
}
function setOrderNo (id){
  $('#set_basket_id').val(id);
    $.ajax({
      url:"script/_getPossibleBasketOrders.php",
      type:"POST",
      beforeSend:function(){
      },
      data:$("#basketOrdersForm").serialize()+ "&id="+id,
      success:function(res){
        console.log(res);
        $("#basketOrdersTable").html("");
        if(res.success == 1){
           $.each(res.data,function(){
            $("#basketOrdersTable").append(
            '<tr>'+
                '<td>'+this.store_name+'</td>'+
                '<td>'+this.items+'</td>'+
                '<td>'+this.price+'</td>'+
                '<td><input type="text" name="order_nos[]" class="form-control"/></td>'+
            '</tr>'
            );
           });
        }else{
          toastr.warning(res.msg);
        }
      },
      error:function(e){
        toastr.error("خطأ");
        console.log(e);
      }
    });
}
</script>
<div class="modal fade" id="editBasketModal" role="dialog">
    <div class="modal-dialog">
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal"></button>
          <h4 class="modal-title">تحضر سلة</h4>
        </div>
        <div class="modal-body">
    <!--Begin:: App Content-->
         <form class="kt-form kt-form--label-right"  id="editBasketForm">
                <div class="kt-portlet__body">
                    <div class="kt-section kt-section--first">
                        <div class="kt-section__body">
                            <input type="hidden" id="e_basket_id" name="e_basket_id"/>
                            <div class="form-group row">
                                <div class="col-lg-6 kt-margin-b-10-tablet-and-mobile">
                                	<label>اسم الزبون</label>
                                    <input type="text" class="form-control" id="e_customer_name" name="e_customer_name" />
                                    <span class="form-text text-danger" id="e_customer_name_err"></span>
                                </div>
                                <div class="col-lg-6 kt-margin-b-10-tablet-and-mobile">
                                   <label>رقم هاتف الزبون</label><br />
                                	<input type="text" class="form-control"  id="e_customer_phone" name="e_customer_phone" />
                                    <span class="form-text text-danger" id="e_customer_phone_err"></span>
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-lg-6 kt-margin-b-10-tablet-and-mobile">
                                	<label>المدينة</label>
                                    <select data-live-search="true" onchange="getTowns($('#e_town'),$(this).val());" class="selectpicker form-control" id="e_city" name="e_city" ></select>
                                    <span class="form-text text-danger" id="e_city_err"></span>
                                </div>
                                <div class="col-lg-6 kt-margin-b-10-tablet-and-mobile">
                                    <label>القضاء او الناحية او المنطقة</label><br />
                                	<select data-live-search="true" class="selectpicker form-control"  id="e_town" name="e_town"  ></select>
                                    <span class="form-text text-danger" id="e_town_err"></span>
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-lg-6 kt-margin-b-10-tablet-and-mobile">
                                	<label>تفاصيل العنوان</label>
                                    <textarea type="text" class="form-control" id="e_address" name="e_address" ></textarea>
                                    <span class="form-text text-danger" id="e_address_err"></span>
                                </div>
                                <div class="col-lg-6 kt-margin-b-10-tablet-and-mobile">
                                	<label>ملاحظه</label>
                                    <textarea type="text" class="form-control" id="e_note" name="e_note"></textarea>
                                    <span class="form-text text-danger" id="e_address_err"></span>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
                <div class="kt-portlet__foot">
                    <div class="kt-form__actions">
                        <div class="row">
                            <div class="col-md-12">
                                <hr class="hr" />
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-9 col-xl-9">
                                <button type="button" onclick="updateBasket()" class="btn btn-danger">تحديث معلومات السلة</button>&nbsp;
                                <button type="reset" data-dismiss="modal" class="btn btn-secondary">الغأ</button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
    <!--End:: App Content-->
        </div>
      </div>

    </div>
  </div>
<div class="modal fade" id="basketItemsModal" role="dialog">
    <div class="modal-dialog modal-lg">
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal"></button>
          <h4 class="modal-title">المنتجات الموجود بالسلة</h4>
        </div>
        <div class="modal-body">
        <!--Begin:: App Content-->
        <div class="kt-grid__item kt-grid__item--fluid kt-app__content">
           <form class="kt-form kt-form--label-right" id="basketItemsForm">

            		<!--begin: Datatable -->
            		<table class="table table-striped table-bordered table-hover table-checkable responsive nowrap" id="tb-basketItemsTable">
            			       <thead>
            	  						<tr>
            										<th>الصورة</th>
            										<th>اسم المنتج</th>
            										<th>الكمية</th>
            										<th>الحالة</th>
            										<th>تعديل</th>
                                        </tr>
                  	            </thead>
                                <tbody id="basketItemsTable">
                                </tbody>
            		</table>
            		<!--end: Datatable -->
                    <input type="hidden" value="" id="driver_id" name="driver_id" />
                    </form>
            </div>
        <!--End:: App Content-->
        </div>
      </div>

    </div>
</div>
<div class="modal fade" id="setBasketToOrderModal" role="dialog">
    <div class="modal-dialog modal-lg">
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal"></button>
          <h4 class="modal-title">المنتجات الموجود بالسلة</h4>
        </div>
        <div class="modal-body">
        <!--Begin:: App Content-->
        <div class="kt-grid__item kt-grid__item--fluid kt-app__content">
           <form class="kt-form kt-form--label-right" enctype="multipart/form-data" id="basketOrdersForm">
                    <fieldset>
                          <div class="from-group col-lg-2">
                           <input type="button" class="btn btn-info" value="ارسال الطلبية" onclick="setBasketToOrders($('#set_basket_id').val())"/>
                          </div>
                          <input type="hidden" class="from-control" id="set_basket_id" name="set_basket_id"/>

                    </fieldset>
            		<!--begin: Datatable -->
            		<table class="table table-striped table-bordered table-hover table-checkable responsive nowrap" id="tb-basketOrdersTable">
            			       <thead>
            	  						<tr>
            										<th>السوق</th>
            										<th>عدد المنتجات</th>
            										<th>سعر الطلب</th>
            										<th>رقم الوصل</th>
                                        </tr>
                  	            </thead>
                                <tbody id="basketOrdersTable">
                                </tbody>
            		</table>
            		<!--end: Datatable -->
             </form>
           </div>
        <!--End:: App Content-->
        </div>
      </div>

    </div>
</div>
