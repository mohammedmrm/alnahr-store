<style>
.img-div {
  height: 60px;
  background-repeat: no-repeat;
  background-size: contain;
  background-position: center;
}
.item {
  box-shadow: 0px 0px 5px #CCCCCC;
  padding:2px;
  border-radius: 4px;
}

</style>
<div class="col-md-12">
<div class="row" id="baskets">
</div>
</div>
<script>
$(document).ready(function(){
getMyBasket();
});
function getMyBasket(){
  $.ajax({
    url:"script/_getMyBasket.php",
    type:"POST",
    data:$("#form").serialize(),
    beforeSend:function(){

    },
    success:function(res){
     $("#baskets").html("");
     console.log(res);
     $.each(res.data,function(){
             status = this.status;

        basket = `<form class="col-md-4">
                  <div class="col-md-12">
                   <div class="kt-portlet kt-portlet--height-fluid">
                    <div class="kt-portlet__head">
                        <div class="kt-portlet__head-label">
                            <h3 class="kt-portlet__head-title"> `+this.customer_name+`</h3>
                            <h5 class="kt-portlet__head-title"> &nbsp;&nbsp;( `+this.city+` ) </h5>
                        </div>
                    </div>
                    <div class="kt-portlet__body">
                    `;
        total = 0;
        $.each(this.items,function(){
             item_btn = "";
             if(status== 1){
              item_btn =
              `<button type="button" onclick="deleteItemFromBasket(`+this.bi_id+`,`+this.basket_id+`)" class="btn btn-icon text-danger"><i class="flaticon-delete"></i></button>
              <button type="button" onclick="increaseItem(`+this.bi_id+`,`+this.basket_id+`)" class="btn btn-icon text-success"><i class="flaticon-add"></i></button>`
              ;
             }else if(status == 2){
              item_btn ="";
             }else{
              item_btn ="";
             }
            basket +=`<div class="row item">
                      <div class="col-3 img-div" style="background-image:url(img/product/`+this.path+`)">
                      </div>
                      <div class="col-7">
                          <div class="h6">
                               `+this.sub_name+`
                          </div>
                          <div class="">
                               `+(this.price)+` دينار
                          </div>
                          <div class="">
                               `+this.bi_qty+` قطعه
                          </div>
                      </div>
                      <div class="col-2">
                       `+item_btn+`
                      </div>
                      </div><hr />`
                      total = total + (Number(this.price) * Number(this.bi_qty));
        });
        if(this.city_id == 1){
            total = total + 5000 -Number(this.discount);
        }else{
           total = total + 10000 -Number(this.discount);
        }
         if(status == 1){
         btn = ` <div class="input-group">
			<div class="input-group-prepend">
				<span class="input-group-text">الخصم</span>
			</div>
			<input type="text" value="`+Number(this.discount)+`" onkeyup="updateBasketPrice(`+total+`,`+this.id+`,$(this).val(),`+this.city_id+`)" class="form-control" id="discount" name="discount"/>
			<div class="input-group-append">
				<span class="input-group-text">دينار</span>
			</div>
         </div><br />
                  <button type="button" onclick="sendBasket(`+this.id+`,$(this).parents('form:first'))" class="btn  btn-success">ارسال<i class="flaticon2-arrow-up"></i></button>
                  <button type="reset"  onclick="emptyBasket(`+this.id+`)" class="btn btn-danger">افراغ<i class="flaticon2-open-box"></i></button>`;
         }else if(status == 2){
           btn = `<button type="button" onclick="cancelBasket(`+this.id+`)" class="btn  btn-info">الغأ<i class="flaticon-cancel"></i></button>`;
         }
        basket +=`
               </div>
                <div class="kt-portlet__foot">
                    <div class="kt-form__actions">
                        <div class="row">
                            <div class="col-lg-12 col-xl-12">
                               <span class="fa-2x"><span id="price`+this.id+`">`+total+`</span> دينار</span> مع التوصيل<br />
                               `+btn+`
                            </div>
                        </div>
                    </div>
                </div>
        </div></div>
        </form>`;
        $("#baskets").append(basket);
     });

    },
    error:function(e){
      console.log(e);
    }
  })
}
function emptyBasket(id){
  $(".text-danger").text("");
  $.ajax({
    url:"script/_emptyBasket.php",
    data:{id: id},
    beforeSend:function(){
      $("#editProductForm").addClass('loading');
    },
    success:function(res){
      $("#editProductForm").removeClass('loading');
      if(res.success == 1){
        toastr.success("تم افراغ السلة");
        getMyBasket();
      }else{
        toastr.success("خطأ");
      }
      console.log(res);
    },
    error:function(e){
      $("#editProductForm").removeClass('loading');
      console.log(e);
    }
  });
}

function sendBasket(id,ele){
  $(".text-danger").text("");
  $.ajax({
    url:"script/_sendBasket.php",
    data:ele.serialize()+"&id="+id,
    beforeSend:function(){
      $("#editProductForm").addClass('loading');
    },
    success:function(res){
      $("#editProductForm").removeClass('loading');
      if(res.success == 1){
        toastr.success("تم ارسال السلة");
        getMyBasket();
      }else{
        toastr.success("خطأ");
      }
      console.log(res);
    },
    error:function(e){
      $("#editProductForm").removeClass('loading');
      console.log(e);
    }
  });
}
function cancelBasket(id){
  $(".text-danger").text("");
  $.ajax({
    url:"script/_cancelBasket.php",
    data:{id: id},
    beforeSend:function(){
      $("#editProductForm").addClass('loading');
    },
    success:function(res){
      $("#editProductForm").removeClass('loading');
      if(res.success == 1){
        toastr.success("تم الالغأ");
        getMyBasket();
      }else{
        toastr.success("خطأ");
      }
      console.log(res);
    },
    error:function(e){
      $("#editProductForm").removeClass('loading');
      console.log(e);
    }
  });
}
function deleteItemFromBasket(id){
  $(".text-danger").text("");
  $.ajax({
    url:"script/_deleteItemFromBasket.php",
    data:{id: id},
    beforeSend:function(){
      $("#editProductForm").addClass('loading');
    },
    success:function(res){
      $("#editProductForm").removeClass('loading');
      if(res.success == 1){
        toastr.success("تم الحذف");
        getMyBasket();
      }else{
        toastr.success("خطأ");
      }
      console.log(res);
    },
    error:function(e){
      $("#editProductForm").removeClass('loading');
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
          getMyBasket();
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
function updateBasketPrice(total,id,discount){
  $("#price"+id).text(Number(total)-Number(discount));
}
</script>