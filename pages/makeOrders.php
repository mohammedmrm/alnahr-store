
<div class="kt-portlet kt-portlet--tabs">
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
<!--                        <li class="nav-item">
                            <a class="nav-link fa-1x" data-toggle="tab" href="#invoices" role="tab" aria-selected="true">
                                <i class="fa fa-file-pdf"></i> كشوفات
                            </a>
                        </li>-->
                    </ul>
                </div>
            </div>
            <div class="kt-portlet__body">
                <div class="tab-content">
                    <div class="tab-pane active" id="baskets" role="tabpanel">
                     <div class="row">
                        <div class="col-lg-5 kt-margin-b-10-tablet-and-mobile">
                            <h1 class="fa-2x">السلات المطلوب تحضيرها</h1>
                        </div>
                        <div class="col-lg-2 kt-margin-b-10-tablet-and-mobile">
                                <input id="makeAllOrders" name="makeAllOrders" type="button" onclick="makeAllOrders()" value="توليد كل الشحنات"  class="btn btn-warning form-control">
                        </div>

                     </div>
                      <hr />
	                 <table class="table table-striped  table-bordered nowrap" style="white-space: nowrap;" id="tb-baskets">
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
                            <h3 class="kt-portlet__head-title"> الطلبيات </h3>

                                <div class="kt-portlet__body">
                            		<!--begin: Datatable -->
                                    <form id="ordertabledata" class="kt-form kt-form--fit kt-margin-b-20">
                                      <fieldset><legend>فلتر</legend>
                                      <div class="row kt-margin-b-20">
                                       <div class="col-lg-2 kt-margin-b-10-tablet-and-mobile">
                                        	<label>العميل:</label>
                                        	<select onchange="getorders();getStores($('#store'),$(this).val());" data-show-subtext="true" data-live-search="true"  class="selectpicker form-control kt-input" id="client" name="client" data-col-index="7">
                                        		<option value="">Select</option>
                                        	</select>
                                        </div>
                                        <div class="col-lg-2 kt-margin-b-10-tablet-and-mobile">
                                        	<label>الصفحة (البيج):</label>
                                        	<select onchange="getorders()" data-show-subtext="true" data-live-search="true"  class="selectpicker form-control kt-input" id="store" name="store" data-col-index="7">
                                        		<option value="">Select</option>
                                        	</select>
                                        </div>
                                        <div class="col-lg-2 kt-margin-b-10-tablet-and-mobile">
                                        	<label>الحالة:</label>
                                        	<select onchange="getorders()" class="form-control kt-input" id="orderStatus" name="orderStatus" data-col-index="7">
                                        		<option value="">Select</option>
                                        	</select>
                                        </div>
                                        <div class="col-lg-2 kt-margin-b-10-tablet-and-mobile">
                                        	<label>المحافظة المرسل لها:</label>
                                        	<select id="city" name="city" onchange="getorders();getTowns2($('#town'),$(this).val());" class="form-control kt-input" data-col-index="2">
                                        		<option value="">Select</option>
                                            </select>
                                        </div>
                                        <div class="col-lg-2 kt-margin-b-10-tablet-and-mobile">
                                        	<label>المنطقه:</label>
                                            <select id="town" name="town" data-live-search="true" onchange="getorders()" class="form-control kt-input" data-col-index="2">
                                        	</select>
                                        </div>
                                        <div class="col-lg-3 kt-margin-b-10-tablet-and-mobile">
                                        <label>الفترة الزمنية :</label>
                                        <div class="input-daterange input-group" id="kt_datepicker">
                              				<input onchange="getorders()" type="text" class="form-control kt-input" name="start" id="start" placeholder="من" data-col-index="5">
                              				<div class="input-group-append">
                              					<span class="input-group-text"><i class="la la-ellipsis-h"></i></span>
                              				</div>
                              				<input onchange="getorders()" type="text" class="form-control kt-input" name="end"  id="end" placeholder="الى" data-col-index="5">
                                      	</div>
                                        </div>
                                        <div class="col-lg-2 kt-margin-b-10-tablet-and-mobile">
                                        	<label>رقم الوصل:</label>
                                        	<input id="order_no" name="order_no" onkeyup="getorders()" type="text" class="form-control kt-input" placeholder="" data-col-index="0">
                                        </div>
                                        <div class="col-lg-2 kt-margin-b-10-tablet-and-mobile">
                                        	<label>اسم او هاتف المستلم:</label>
                                        	<input name="customer" onkeyup="getorders()" type="text" class="form-control kt-input" placeholder="" data-col-index="1">
                                        </div>
                                        <div class="col-lg-2 kt-margin-b-10-tablet-and-mobile">
                                        	<label>حاله الاحاله:</label>
                                        	<select id="assignStatus" name="assignStatus" onchange="getclient()" class="form-control kt-input" data-col-index="2">
                                        		<option value="1">الطلبات غير المحاله</option>
                                        		<option value="2">الطلبيات المحاله</option>
                                        		<option value="3">الكل</option>
                                            </select>
                                        </div>
                                        <div class="col-lg-2 kt-margin-b-10-tablet-and-mobile">
                                        	<label>حالة تسليم المبلغ للعميل:</label>
                                            <select name="money_status" onchange="getorders()" class="form-control kt-input" data-col-index="2">
                                        		<option value="">... اختر...</option>
                                        		<option value="1">تم تسليم المبلغ</option>
                                        		<option value="0">لم يتم تسليم المبلغ</option>
                                            </select>
                                        </div>
                                        <div class="col-lg-2 kt-margin-b-10-tablet-and-mobile">
                                        	<label>حالة الطباعه:</label>
                                            <select name="print" onchange="getorders()" class="form-control kt-input" data-col-index="2">
                                        		<option value="">الكل</option>
                                        		<option value="1">غير المطبوع</option>
                                        		<option value="2">المطبوع</option>
                                            </select>
                                        </div>
                                        <div class="col-lg-2 kt-margin-b-10-tablet-and-mobile">
                                                <label>.</label>
                                                <input id="downloadReceipts" name="downloadReceipts" type="button" onclick="download_Receipts()" value="تحميل الوصولات"  class="btn btn-warning form-control">
                                        </div>
                                        <div class="col-lg-2 kt-margin-b-10-tablet-and-mobile">
                                            <label>عدد السجلات</label>
                                            <select name="limit" onchange="getorders()" class="form-control kt-input" data-col-index="2">
                                        		<option value="10">10</option>
                                        		<option value="20">20</option>
                                        		<option value="30">30</option>
                                        		<option value="40">40</option>
                                        		<option value="50">50</option>
                                        		<option value="60">60</option>
                                        		<option value="75">75</option>
                                        		<option value="100">100</option>
                                            </select>
                                        </div>
                                      </div>
                                      </fieldset>
                                      <table class="table table-striped  table-bordered responsive nowrap" id="tb-orders">
                            			       <thead>
                            	  						<tr>
                    										<th><input  id="allselector" type="checkbox"><span></span></th>
                    										<th>رقم الشحنه</th>
                                                            <th>رقم الوصل</th>
                    										<th >اسم و هاتف العميل</th>
                    										<th >رقم هاتف المستلم</th>
                    										<th>عنوان المستلم</th>
                    										<th>شركه التوصل</th>
                    										<th>مبلغ الوصل</th>
                                                            <th>مبلغ التوصيل</th>
                                                            <th>الخصم</th>
                                                            <th>حالة المبلغ</th>
                                                            <th >التاريخ</th>
                            						   </tr>
                                  	            </thead>
                                                <tbody id="ordersTable">
                                                </tbody>
                            		</table>
                                    <div class="kt-section__content kt-section__content--border">
                            		<nav aria-label="...">
                            			<ul class="pagination" id="pagination">

                            			</ul>
                                    <input type="hidden" id="p" name="p" value="<?php if(!empty($_GET['p'])){ echo $_GET['p'];}else{ echo 1;}?>"/>
                            		</nav>
                                 	</div>
                                    <hr />
                                      <fieldset><legend>التحديثات</legend>
                                      <div class="row kt-margin-b-20">
                                        <div class="col-lg-2 kt-margin-b-10-tablet-and-mobile">
                                        	<label>شركة التوصيل:</label>
                                        	<select onchange="getApiStore($(this).val())" class="selectpicker form-control kt-input" data-live-search="true" name="company" id="company" data-col-index="2">
                                        		<option value="">... اختر شركه التوصيل ...</option>
                                        	</select>
                                        </div>
                                        <div class="col-lg-2 kt-margin-b-10-tablet-and-mobile">
                                        	<label>احاله المحدد بأسم السوق:</label>
                                        	<select  id="apistore" name="apistore" class="selectpicker form-control kt-input" data-col-index="2">
                                        		<option value="">... اختر ...</option>
                                        	</select>
                                        </div>
                                        <div class="col-lg-2 kt-margin-b-10-tablet-and-mobile">
                                        	<label>احالة:</label>
                                        	<input type="button" onclick="sendOrders()" class="form-control btn btn-success" value="نفذ" />
                                        </div>
                                      </div>
                                      </fieldset>
                                    </form>
                            		<!--end: Datatable -->
                            </div>
                    </div>
                    <div class="tab-pane" id="invoices" role="tabpanel">
                      الكشوفات
                    </div>
                </div>
            </div>
        </div>
<script src="assets/plugins/custom/datatables/datatables.bundle.js" type="text/javascript"></script>
<!--begin::Page Scripts(used by this page) -->
<script src="assets/js/pages/components/datatables/extensions/responsive.js" type="text/javascript"></script>

<script src="js/getStores.js" type="text/javascript"></script>
<script src="js/getCities.js" type="text/javascript"></script>
<script src="js/getTowns.js" type="text/javascript"></script>
<script src="js/getClients.js" type="text/javascript"></script>
<script src="js/getorderStatus.js" type="text/javascript"></script>
<script src="js/getCompanies.js" type="text/javascript"></script>
<script type="text/javascript">
function download_Receipts(){
    var domain = "script/downloadReceipts.php?";
    var data = $("#ordertabledata").serialize()+"&islimited=1";
    window.open(domain + data, '_blank');
}
getStores($('#store'));
function getorders(){
$.ajax({
  url:"script/_getOrders.php",
  type:"POST",
  data:$("#ordertabledata").serialize(),
  beforeSend:function(){
    $("#tb-orders").addClass("loading");
  },
  success:function(res){
   console.log(res);
   //saveEventDataLocally(res)
   $("#tb-orders").removeClass("loading");
   //$("#tb-orders").DataTable().destroy();
   $('#ordersTable').html("");
   $("#pagination").html("");
   if(res.pages >= 1){
     if(res.page > 1){
         $("#pagination").append(
          '<li class="page-item"><a href="#" onclick="getorderspage('+(Number(res.page)-1)+')" class="page-link">السابق</a></li>'
         );
     }else{
         $("#pagination").append(
          '<li class="page-item disabled"><a href="#" class="page-link">السابق</a></li>'
         );
     }
     if(Number(res.pages) <= 5){
       i = 1;
     }else{
       i =  Number(res.page) - 5;
     }
     if(i <=0 ){
       i=1;
     }
     for(i; i <= res.pages; i++){
       if(res.page != i){
         $("#pagination").append(
          '<li class="page-item"><a href="#" onclick="getorderspage('+(i)+')"  class="page-link">'+i+'</a></li>'
         );
       }else{
         $("#pagination").append(
          '<li class="page-item active"><span class="page-link">'+i+'</span></li>'
         );
       }
       if(i == Number(res.page) + 5 ){
         break;
       }
     }
     if(res.page < res.pages){
         $("#pagination").append(
          '<li class="page-item"><a href="#" onclick="getorderspage('+(Number(res.page)+1)+')" class="page-link">التالي</a></li>'
         );
     }else{
         $("#pagination").append(
          '<li class="page-item disabled"><a href="#" class="page-link">التالي</a></li>'
         );
     }
   }
   i=0;
   $.each(res.data,function(){
      $('#ordersTable').append(
       '<tr>'+
            '<td class=""><input type="checkbox" value="'+this.id+'" name="ids[]" rowid="'+this.id+'"><span></span></td>'+
            '<td>'+this.id+'</td>'+
            '<td>'+this.order_no+'</td>'+
            '<td>'+this.store_name+'<br />'+phone_format(this.client_phone)+'</td>'+
            '<td>'+this.customer_name+'<br />'+phone_format(this.customer_phone)+'</td>'+
            '<td>'+this.city+'/'+this.town+'<br />'+this.address+'</td>'+
            '<td>'+this.dev_comp_name+'</td>'+
            '<td>'+formatMoney(this.total_price)+'</td>'+
            '<td>'+formatMoney(this.dev_price)+'</td>'+
            '<td>'+formatMoney(this.discount)+'</td>'+
            '<td>'+this.money_status+'</td>'+
            '<td>'+this.date+'</td>'+
         '</tr>');
     });
    },
   error:function(e){
     $("#tb-orders").removeClass("loading");
    console.log(e);
  }
});
}
function getTowns2(elem,city){
   $.ajax({
     url:"script/_getTowns.php",
     type:"POST",
     data:{city: city},
     beforeSent:function(){

     },
     success:function(res){
       elem.html("");
       elem.append("<option value=''>-- اختر --</option>");
       $.each(res.data,function(){
         elem.append("<option value='"+this.id+"'>"+this.name+"</option>");
       });
       elem.selectpicker('refresh');
       console.log(res);
     },
     error:function(e){
        elem.append("<option value='' class='bg-danger'>خطأ اتصل بمصمم النظام</option>");
        console.log(e);
     }
   });
}
getTowns2($("#town"),1);
function getorderspage(page){
    $("#p").val(page);
    getorders();
}
getClients($("#client"));
function getclient(){
 getClients($("#client"),$("#branch").val());
 getorders();
}

$(document).ready(function(){
  getCompanies($('#company'));
  getorders();
$("#allselector").change(function() {
    var ischecked= $(this).is(':checked');
    if(!ischecked){
      $('input[name="ids\[\]"]').attr('checked', false);;
    }else{
      $('input[name="ids\[\]"]').attr('checked', true);;
    }
});
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
getorderStatus($("#orderStatus"));
getCities($("#city"));
});
function getApiStore(id){
      $.ajax({
        url:"script/_getApiStore.php",
        type:"POST",
        data:$("#ordertabledata").serialize(),
        success:function(res){
          $("#apistore").html("");
          console.log(res);
          if(res.response != null){
          if(res.response.success == 1){
            $.each(res.response.data,function(){
              $("#apistore").append(
                '<option value="'+this.id+'">'+this.name+'</option>'
              );
            });
          }else{
            toastr.warning("لايمكن طلب تحميل الاسواق",'فشل الاتصال');
          }
          }else{
            toastr.warning("تاكد من معلومات الشركه",'فشل الاتصال');
          }
           $("#apistore").selectpicker("refresh");
        },
        error:function(e){
          toastr.error("خطأ!");
          console.log(e);
        }
      });
}
function sendOrders(){
      $.ajax({
        url:"script/_sendOrders.php",
        type:"POST",
        data:$("#ordertabledata").serialize(),
        success:function(res){
          console.log(res);
          Toast.success("تم الاحاله "+res.response.count.added + " شحنه");
          if(res.response.count.not > 0){
            Toast.warning(res.response.count.not + " شحنه محاله مسبقاً");
          }
          getorders();
        },
        error:function(e){
           Toast.error("خطأ!");
          console.log(e);
        }
      });
}

$(document).ready(function(){
  getStores($("#store"));
  getCities($("#e_city"));
  getBasketForPerpare();
  $("#tb-baskets").DataTable({
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
      $("#baskets").removeClass("loading");
      $("#tb-baskets").DataTable().destroy();
      $("#basketsTable").html("");
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
          $('#setBasketToOrderModal').modal('toggle');
          getBasketForPerpare();
          getorders();
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
function makeAllOrders(){
    $.ajax({
      url:"script/_setBasketsToOrders.php",
      type:"POST",
      beforeSend:function(){
        $("#basketOrdersForm").addClass("loading");
      },
      success:function(res){
        $("#basketOrdersForm").removeClass("loading");
        console.log(res);
        if(res.success == 1){
          toastr.success('تم تسجيل '+res.added+' طلب ');
          getBasketForPerpare();
          getorders();
        }else{
          toastr.warning(res.msg);
          getBasketForPerpare();
          getorders();
        }
      },
      error:function(e){
        $("#basketOrdersForm").removeClass("loading");
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
