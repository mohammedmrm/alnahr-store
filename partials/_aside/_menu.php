<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
$a = $_SESSION['role'];
function acc($id){
  return true;
}
?>
<style>
.kt-menu__toggle{
 background-color: #663300 !important;
}

</style>
<input type="hidden" value="<?php if(isset($_GET['page'])){echo $_GET['page'];}?>" id="page">
<!-- begin:: Aside Menu -->
<div class="kt-aside-menu-wrapper kt-grid__item kt-grid__item--fluid" id="kt_aside_menu_wrapper" id="aside_menu">
	<div id="kt_aside_menu" class="kt-aside-menu " data-ktmenu-vertical="1" data-ktmenu-scroll="1" data-ktmenu-dropdown-timeout="500">
		<ul class="kt-menu__nav ">
            <li class="kt-menu__item  kt-menu__item--submenu kt-menu__item--open kt-menu__item--here" aria-haspopup="true" data-ktmenu-submenu-toggle="hover"><a href="javascript:;" class="kt-menu__link kt-menu__toggle"><i class="kt-menu__link-icon fa fa-tshirt"></i><span class="kt-menu__link-text">المنتجات</span><i class="kt-menu__ver-arrow la la-angle-right"></i></a>
				<div class="kt-menu__submenu "><span class="kt-menu__arrow"></span>
					<ul class="kt-menu__subnav">
						<li class="kt-menu__item  kt-menu__item--parent" aria-haspopup="true"><span class="kt-menu__link"><span class="kt-menu__link-text">Dashboards</span></span></li>

<!--                        <li class="kt-menu__item" aria-haspopup="true"><a href="index.php" class="kt-menu__link "><i class="kt-menu__link-bullet kt-menu__link-bullet--dot"><span></span></i><span class="kt-menu__link-text">لوحة  التحكم</span></a></li>-->
                        <?php if($a == 1 || $a == 3 || $a == 10 || $a==99){?>
                            <li class="kt-menu__item " aria-haspopup="true"><a href="?page=pages/addProduct.php" class="kt-menu__link "><i class="kt-menu__link-bullet kt-menu__link-bullet--dot"><span></span></i><span class="kt-menu__link-text">اضافه منتج</span></a></li>
                        <?php } ?>
                        <?php if($a == 1 || $a == 3 || $a == 10 || $a == 4 || $a == 5 || $a == 6 || $a==99){?>
                            <li class="kt-menu__item " aria-haspopup="true"><a href="?page=pages/getFullProducts.php" class="kt-menu__link "><i class="kt-menu__link-bullet kt-menu__link-bullet--dot"><span></span></i><span class="kt-menu__link-text">عرض المنتجات</span></a></li>
                            <li class="kt-menu__item " aria-haspopup="true"><a href="?page=pages/getProducts.php" class="kt-menu__link "><i class="kt-menu__link-bullet kt-menu__link-bullet--dot"><span></span></i><span class="kt-menu__link-text">عرض المنتجات بالتفصيل</span></a></li>
                        <?php } ?>
                        <?php if($a == 1 || $a == 3  || $a == 5 || $a == 10 || $a==99){?>
                            <li class="kt-menu__item " aria-haspopup="true"><a href="?page=pages/editProduct.php" class="kt-menu__link "><i class="kt-menu__link-bullet kt-menu__link-bullet--dot"><span></span></i><span class="kt-menu__link-text">تعديل منتج</span></a></li>
                        <?php } ?>
                        <?php if($a == 1 || $a == 3  || $a == 5 || $a == 6 || $a==99){?>
                            <li class="kt-menu__item " aria-haspopup="true"><a href="?page=pages/categories.php" class="kt-menu__link "><i class="kt-menu__link-bullet kt-menu__link-bullet--dot"><span></span></i><span class="kt-menu__link-text">التصنيفات</span></a></li>
                        <?php } ?>
                        <?php if($a == 1 || $a == 2 || $a == 3 || $a == 5 || $a==99){?>
                            <li class="kt-menu__item " aria-haspopup="true"><a href="?page=pages/attrbutes.php" class="kt-menu__link "><i class="kt-menu__link-bullet kt-menu__link-bullet--dot"><span></span></i><span class="kt-menu__link-text">الاوسمة</span></a></li>
                        <?php } ?>

                    </ul>
				   </div>
			    </li>

			     <li class="kt-menu__item  kt-menu__item--submenu kt-menu__item--open" aria-haspopup="true" data-ktmenu-submenu-toggle="hover"><a href="javascript:;" class="kt-menu__link kt-menu__toggle"><i class="kt-menu__link-icon fa fa-dollar-sign"></i><span class="kt-menu__link-text">المبيعات</span></a>
							<div class="kt-menu__submenu kt-menu__item--open"><span class="kt-menu__arrow"></span>
								<ul class="kt-menu__subnav">
                                  <li class="kt-menu__item  kt-menu__item--parent" aria-haspopup="true"><span class="kt-menu__link"><span class="kt-menu__link-text">Users</span></span></li>
                                  <?php if($a == 1 || $a == 3 || $a == 10 || $a==99){?>
                                      <li class="kt-menu__item " aria-haspopup="true"><a href="?page=pages/orders.php" class="kt-menu__link "><i class="kt-menu__link-bullet kt-menu__link-bullet--dot"><span></span></i><span class="kt-menu__link-text">الطلبيات</span></a></li>
                                  <?php } ?>
                                  <li class="kt-menu__item " aria-haspopup="true"><a href="?page=pages/myBaskets.php" class="kt-menu__link "><i class="kt-menu__link-bullet kt-menu__link-bullet--dot"><span></span></i><span class="kt-menu__link-text">السلات</span></a></li>
                                  <?php if($a == 1 || $a == 3 || $a == 5 || $a==99){?>
                                      <li class="kt-menu__item " aria-haspopup="true"><a href="?page=pages/makeOrders.php" class="kt-menu__link "><i class="kt-menu__link-bullet kt-menu__link-bullet--dot"><span></span></i><span class="kt-menu__link-text">توليد الشحنات</span></a></li>
                                  <?php } ?>
                                  <?php if($a == 1 || $a == 5|| $a==99){?>
                                  <!--    <li class="kt-menu__item " aria-haspopup="true"><a href="?page=pages/requstedItems.php" class="kt-menu__link "><i class="kt-menu__link-bullet kt-menu__link-bullet--dot"><span></span></i><span class="kt-menu__link-text">اخراج مخزني</span></a></li>
                                  -->
                                  <?php } ?>
                                  <?php if($a == 1 || $a == 3 || $a == 5 || $a==99){?>
                                      <li class="kt-menu__item " aria-haspopup="true"><a href="?page=pages/updateOrdersStatus.php" class="kt-menu__link "><i class="kt-menu__link-bullet kt-menu__link-bullet--dot"><span></span></i><span class="kt-menu__link-text">تحديث حالة الطلبيات</span></a></li>
                                  <?php } ?>
                                  <?php if($a == 1 || $a == 3 || $a == 5 || $a==99){?>
                                      <!-- <li class="kt-menu__item " aria-haspopup="true"><a href="?page=pages/updateOrdersStatus.php" class="kt-menu__link "><i class="kt-menu__link-bullet kt-menu__link-bullet--dot"><span></span></i><span class="kt-menu__link-text">تحدبث يدوي</span></a></li> -->
                                  <?php } ?>
                                  <?php if($a == 1 || $a == 3  || $a == 10 || $a == 5 || $a==99){?>
                                      <li class="kt-menu__item " aria-haspopup="true"><a href="?page=pages/earnings.php" class="kt-menu__link "><i class="kt-menu__link-bullet kt-menu__link-bullet--dot"><span></span></i><span class="kt-menu__link-text">الارباح</span></a></li>
                                  <?php } ?>
                                  <?php if($a == 1 || $a == 3 || $a == 5 || $a==99){?>
                                      <li class="kt-menu__item " aria-haspopup="true"><a href="?page=pages/receipts.php" class="kt-menu__link "><i class="kt-menu__link-bullet kt-menu__link-bullet--dot"><span></span></i><span class="kt-menu__link-text">الوصولات</span></a></li>
                                  <?php } ?>
                                </ul>
							</div>
						</li>

			     <li class="kt-menu__item  kt-menu__item--submenu kt-menu__item--open" aria-haspopup="true" data-ktmenu-submenu-toggle="hover"><a href="javascript:;" class="kt-menu__link kt-menu__toggle"><i class="kt-menu__link-icon fa fa-dollar-sign"></i><span class="kt-menu__link-text">الملف الشخصي</span></a>
							<div class="kt-menu__submenu kt-menu__item--open"><span class="kt-menu__arrow"></span>
								<ul class="kt-menu__subnav">
                                  <li class="kt-menu__item  kt-menu__item--parent" aria-haspopup="true"><span class="kt-menu__link"><span class="kt-menu__link-text">Users</span></span></li>
                                  <li class="kt-menu__item " aria-haspopup="true"><a href="?page=pages/myBaskets.php" class="kt-menu__link "><i class="kt-menu__link-bullet kt-menu__link-bullet--dot"><span></span></i><span class="kt-menu__link-text">السلات</span></a></li>
                                  <?php if($a == 1 || $a == 4 || $a==99){?>
                                    <li class="kt-menu__item " aria-haspopup="true"><a href="?page=pages/myOrders.php" class="kt-menu__link "><i class="kt-menu__link-bullet kt-menu__link-bullet--dot"><span></span></i><span class="kt-menu__link-text">طلبياتي</span></a></li>
                                    <li class="kt-menu__item " aria-haspopup="true"><a href="?page=pages/myEranings.php" class="kt-menu__link "><i class="kt-menu__link-bullet kt-menu__link-bullet--dot"><span></span></i><span class="kt-menu__link-text">ارباحي</span></a></li>
                                  <?php } ?>
                                </ul>
							</div>
						</li>
                        <li class="kt-menu__item  kt-menu__item--submenu kt-menu__item--open" aria-haspopup="true" data-ktmenu-submenu-toggle="hover"><a href="javascript:;" class="kt-menu__link kt-menu__toggle"><i class="kt-menu__link-icon flaticon-users-1"></i><span class="kt-menu__link-text">العملاء</span></a>
							<div class="kt-menu__submenu "><span class="kt-menu__arrow"></span>
								<ul class="kt-menu__subnav">
                                    <li class="kt-menu__item  kt-menu__item--parent" aria-haspopup="true"><span class="kt-menu__link"><span class="kt-menu__link-text">Profile</span></span></li>
                                    <?php if($a == 1 || $a == 3 || $a == 5 || $a==99){?>
                                        <li class="kt-menu__item " aria-haspopup="true"><a href="?page=pages/clientInoices.php" class="kt-menu__link "><i class="kt-menu__link-bullet kt-menu__link-bullet--dot"><span></span></i><span class="kt-menu__link-text">كشوفات العملاء</span></a></li>
                                    <?php } ?>
                                    <?php if($a == 1 || $a == 2 || $a==99){?>
                                      <li class="kt-menu__item " aria-haspopup="true"><a href="?page=pages/clients.php" class="kt-menu__link "><i class="kt-menu__link-bullet kt-menu__link-bullet--dot"><span></span></i><span class="kt-menu__link-text">العملاء</span></a></li>
                                   <?php } ?>
                                   <?php if($a == 1 || $a == 2 || $a == 10 || $a==99){?>
                                      <li class="kt-menu__item " aria-haspopup="true"><a href="?page=pages/stores.php" class="kt-menu__link "><i class="kt-menu__link-bullet kt-menu__link-bullet--dot"><span></span></i><span class="kt-menu__link-text">الصفحات (الاسواق)</span></a></li>
                                   <?php } ?>
                               </ul>
							</div>
						</li>
                        <li class="kt-menu__item  kt-menu__item--submenu kt-menu__item--open" aria-haspopup="true" data-ktmenu-submenu-toggle="hover"><a href="javascript:;" class="kt-menu__link kt-menu__toggle"><i class="kt-menu__link-icon flaticon2-settings"><span></span></i><span class="kt-menu__link-text">التوصيل</span><i class="kt-menu__ver-arrow la la-angle-right"></i></a>
							<div class="kt-menu__submenu "><span class="kt-menu__arrow"></span>
							   <ul class="kt-menu__subnav">
                                    <?php if($a == 1 || $a == 2 || $a == 3 || $a == 5 || $a==99){?>
                                        <li class="kt-menu__item " aria-haspopup="true"><a href="?page=pages/companies.php" class="kt-menu__link "><i class="kt-menu__link-bullet kt-menu__link-bullet--dot"><span></span></i><span class="kt-menu__link-text">شركات التوصيل</span></a></li>
                                    <?php } ?>
                                    <?php if($a == 1 || $a == 2 || $a == 3 || $a == 5 || $a==99){?>
                                        <li class="kt-menu__item " aria-haspopup="true"><a href="?page=pages/orderAssign.php" class="kt-menu__link "><i class="kt-menu__link-bullet kt-menu__link-bullet--dot"><span></span></i><span class="kt-menu__link-text">احالة الطلبيات</span></a></li>
                                    <?php } ?>
                               </ul>
							</div>
						</li>
                        <li class="kt-menu__item  kt-menu__item--submenu kt-menu__item--open" aria-haspopup="true" data-ktmenu-submenu-toggle="hover"><a href="javascript:;" class="kt-menu__link kt-menu__toggle"><i class="kt-menu__link-icon flaticon-rotate"><span></span></i><span class="kt-menu__link-text">ادارة المندوبين</span><i class="kt-menu__ver-arrow la la-angle-right"></i></a>
							<div class="kt-menu__submenu "><span class="kt-menu__arrow"></span>
								<ul class="kt-menu__subnav">
									<li class="kt-menu__item  kt-menu__item--parent" aria-haspopup="true"><span class="kt-menu__link"><span class="kt-menu__link-text">Profile</span></span></li>
                                    <?php if($a == 1 || $a == 3 || $a == 10 || $a == 5 || $a==99){?>
                                        <li class="kt-menu__item " aria-haspopup="true"><a href="?page=pages/updateOrdersStatus.php" class="kt-menu__link "><i class="kt-menu__link-bullet kt-menu__link-bullet--dot"><span></span></i><span class="kt-menu__link-text">كشف حساب مندوب</span></a></li>
                                    <?php } ?>
                                    <?php if($a == 1 || $a == 10 || $a==99){?>
                                        <li class="kt-menu__item " aria-haspopup="true"><a href="?page=pages/staff.php" class="kt-menu__link "><i class="kt-menu__link-bullet kt-menu__link-bullet--dot"><span></span></i><span class="kt-menu__link-text">المندوبين</span></a></li>
                                    <?php } ?>
                                    <?php if($a == 1 || $a == 5|| $a==99){?>
                                        <li class="kt-menu__item " aria-haspopup="true"><a href="?page=pages/mandopInvoice.php" class="kt-menu__link "><i class="kt-menu__link-bullet kt-menu__link-bullet--dot"><span></span></i><span class="kt-menu__link-text">كشوفات المندوبين</span></a></li>
                                    <?php } ?>
                                </ul>
							</div>
						</li>
                        <li class="kt-menu__item  kt-menu__item--submenu kt-menu__item--open" aria-haspopup="true" data-ktmenu-submenu-toggle="hover"><a href="javascript:;" class="kt-menu__link kt-menu__toggle"><i class="kt-menu__link-icon flaticon2-settings"><span></span></i><span class="kt-menu__link-text">الاعدادات</span><i class="kt-menu__ver-arrow la la-angle-right"></i></a>
							<div class="kt-menu__submenu "><span class="kt-menu__arrow"></span>
								<ul class="kt-menu__subnav">
									<li class="kt-menu__item  kt-menu__item--parent" aria-haspopup="true"><span class="kt-menu__link"><span class="kt-menu__link-text">Profile</span></span></li>
                                    <?php if($a == 1 || $a==99){?>
                                        <li class="kt-menu__item " aria-haspopup="true"><a href="?page=pages/staff.php" class="kt-menu__link "><i class="kt-menu__link-bullet kt-menu__link-bullet--dot"><span></span></i><span class="kt-menu__link-text">الموظفين</span></a></li>
                                    <?php } ?>
                                    <?php if($a == 1 || $a == 2 || $a == 3 || $a == 5 || $a==99){?>
                                        <li class="kt-menu__item " aria-haspopup="true"><a href="?page=pages/towns.php" class="kt-menu__link "><i class="kt-menu__link-bullet kt-menu__link-bullet--dot"><span></span></i><span class="kt-menu__link-text">المناطق</span></a></li>
                                    <?php } ?>
                                    <?php if($a == 1 || $a==99){?>
                                        <li class="kt-menu__item " aria-haspopup="true"><a href="?page=pages/orderStatus.php" class="kt-menu__link "><i class="kt-menu__link-bullet kt-menu__link-bullet--dot"><span></span></i><span class="kt-menu__link-text">الحالات</span></a></li>
                                    <?php } ?>
                               </ul>
							</div>
						</li>
                        <?php if($_SESSION['user_details']['developer'] == 1){?>
                        <li class="kt-menu__item  kt-menu__item--submenu kt-menu__item--open" aria-haspopup="true" data-ktmenu-submenu-toggle="hover"><a href="javascript:;" class="kt-menu__link kt-menu__toggle"><i class="kt-menu__link-icon flaticon2-settings"><span></span></i><span class="kt-menu__link-text">قسم المطور</span><i class="kt-menu__ver-arrow la la-angle-right"></i></a>
							<div class="kt-menu__submenu "><span class="kt-menu__arrow"></span>
								<ul class="kt-menu__subnav">
									<li class="kt-menu__item  kt-menu__item--parent" aria-haspopup="true"><span class="kt-menu__link"><span class="kt-menu__link-text">Profile</span></span></li>
                                    <?php if($a == 1 || $a==99){?>
                                        <li class="kt-menu__item " aria-haspopup="true"><a href="?page=pages/headCompanies.php" class="kt-menu__link "><i class="kt-menu__link-bullet kt-menu__link-bullet--dot"><span></span></i><span class="kt-menu__link-text">الشركات</span></a></li>
                                    <?php } ?>
                               </ul>
							</div>
						</li>
                        <?php } ?>
		</ul>
	</div>
</div>
<script type="text/javascript">
page = $("#page").val();
if(page != ""){
$("#aside_menu i").removeClass("kt-menu__item--active");
$("[href='?page="+page+"']").parent().addClass("kt-menu__item--active");
}else{
$("[href='index.php']").parent().addClass("kt-menu__item--active");
}
</script>
<!-- end:: Aside Menu -->