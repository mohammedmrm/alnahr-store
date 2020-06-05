<?php
$a = $_SESSION['user_details']['role_id'];
//$a = 99;
?>
<style>
.kt-menu__toggle{
 background-color: #421E11 !important;
}

</style>
<input type="hidden" value="<?php if(isset($_GET['page'])){echo $_GET['page'];}?>" id="page">
<!-- begin:: Aside Menu -->
<div class="kt-aside-menu-wrapper kt-grid__item kt-grid__item--fluid" id="kt_aside_menu_wrapper" id="aside_menu">
	<div id="kt_aside_menu" class="kt-aside-menu " data-ktmenu-vertical="1" data-ktmenu-scroll="1" data-ktmenu-dropdown-timeout="500">
		<ul class="kt-menu__nav ">
            <li class="kt-menu__item " aria-haspopup="true"><a href="?page=pages/profile.php" class="kt-menu__link "><i class="kt-menu__link-bullet kt-menu__link-bullet--line"><span></span></i><span class="kt-menu__link-text">الملف الشخصي</span><span class="kt-menu__link-badge"><span class="kt-badge kt-badge--danger kt-badge--inline">new</span></span></a></li>
            <li class="kt-menu__section ">
				<h4 class="kt-menu__section-text">احصائيات</h4>
				<i class="kt-menu__section-icon flaticon-more-v2"></i>
			</li>
            <li class="kt-menu__item  kt-menu__item--submenu kt-menu__item--open kt-menu__item--here" aria-haspopup="true" data-ktmenu-submenu-toggle="hover"><a href="javascript:;" class="kt-menu__link kt-menu__toggle"><i class="kt-menu__link-icon flaticon2-graphic"></i><span class="kt-menu__link-text">لوحة الاحصاء</span><i class="kt-menu__ver-arrow la la-angle-right"></i></a>
				<div class="kt-menu__submenu "><span class="kt-menu__arrow"></span>
					<ul class="kt-menu__subnav">
						<li class="kt-menu__item  kt-menu__item--parent" aria-haspopup="true"><span class="kt-menu__link"><span class="kt-menu__link-text">Dashboards</span></span></li>

                        <li class="kt-menu__item" aria-haspopup="true"><a href="index.php" class="kt-menu__link "><i class="kt-menu__link-bullet kt-menu__link-bullet--dot"><span></span></i><span class="kt-menu__link-text">لوحة  التحكم</span></a></li>
                        <?php if(access('1')){?>
                        <li class="kt-menu__item " aria-haspopup="true"><a href="?page=pages/addProduct.php" class="kt-menu__link "><i class="kt-menu__link-bullet kt-menu__link-bullet--dot"><span></span></i><span class="kt-menu__link-text">اضافه منتج</span></a></li>
                        <?php } ?>
                        <?php if(access('8')){?>
                        <li class="kt-menu__item " aria-haspopup="true"><a href="?page=pages/getProducts.php" class="kt-menu__link "><i class="kt-menu__link-bullet kt-menu__link-bullet--dot"><span></span></i><span class="kt-menu__link-text">عرض المنتجات</span></a></li>
                        <?php } ?>
                        <?php if(access('9')){?>
                        <li class="kt-menu__item " aria-haspopup="true"><a href="?page=pages/myBaskets.php" class="kt-menu__link "><i class="kt-menu__link-bullet kt-menu__link-bullet--dot"><span></span></i><span class="kt-menu__link-text">سلاتي</span></a></li>
                        <?php } ?>
                        <?php if(access('10')){?>
                            <li class="kt-menu__item " aria-haspopup="true"><a href="?page=pages/requstedItems.php" class="kt-menu__link "><i class="kt-menu__link-bullet kt-menu__link-bullet--dot"><span></span></i><span class="kt-menu__link-text">اخراج مخزني</span></a></li>
                        <?php } ?>
                        <?php if(access('11')){?>
                            <li class="kt-menu__item " aria-haspopup="true"><a href="?page=pages/makeOrders.php" class="kt-menu__link "><i class="kt-menu__link-bullet kt-menu__link-bullet--dot"><span></span></i><span class="kt-menu__link-text">توليد الشحنات</span></a></li>
                        <?php } ?>
<!--                        <?php if(access('11')){?>
                            <li class="kt-menu__item " aria-haspopup="true"><a href="?page=pages/orders.php" class="kt-menu__link "><i class="kt-menu__link-bullet kt-menu__link-bullet--dot"><span></span></i><span class="kt-menu__link-text">الطلبيات</span></a></li>
                        <?php } ?>
                        <?php if(access('12')){?>
                            <li class="kt-menu__item " aria-haspopup="true"><a href="?page=pages/reports.php" class="kt-menu__link "><i class="kt-menu__link-bullet kt-menu__link-bullet--dot"><span></span></i><span class="kt-menu__link-text">تقارير الطلبيات</span></a></li>
                        <?php } ?>-->
                        <?php if(access('12')){?>
                            <li class="kt-menu__item " aria-haspopup="true"><a href="?page=pages/updateOrdersStatus.php" class="kt-menu__link "><i class="kt-menu__link-bullet kt-menu__link-bullet--dot"><span></span></i><span class="kt-menu__link-text">تحديث حالة الطلبيات</span></a></li>
                        <?php } ?>
                    </ul>
				</div>
			</li>
			<li class="kt-menu__section ">
				<h4 class="kt-menu__section-text">الادارة</h4>
				<i class="kt-menu__section-icon flaticon-more-v2"></i>
			</li>
			           <li class="kt-menu__item  kt-menu__item--submenu kt-menu__item--open" aria-haspopup="true" data-ktmenu-submenu-toggle="hover"><a href="javascript:;" class="kt-menu__link kt-menu__toggle"><i class="kt-menu__link-bullet kt-menu__link-bullet--line"><span></span></i><span class="kt-menu__link-text">العملاء</span><i class="kt-menu__ver-arrow la la-angle-right"></i></a>
							<div class="kt-menu__submenu kt-menu__item--open"><span class="kt-menu__arrow"></span>
								<ul class="kt-menu__subnav">
                                    <li class="kt-menu__item  kt-menu__item--parent" aria-haspopup="true"><span class="kt-menu__link"><span class="kt-menu__link-text">Users</span></span></li>
                                 <?php if(access('3')){?>
                                    <li class="kt-menu__item " aria-haspopup="true"><a href="?page=pages/clients.php" class="kt-menu__link "><i class="kt-menu__link-bullet kt-menu__link-bullet--dot"><span></span></i><span class="kt-menu__link-text">العملاء</span></a></li>
                                 <?php } ?>
                                 <?php if(access('4')){?>
                                    <li class="kt-menu__item " aria-haspopup="true"><a href="?page=pages/stores.php" class="kt-menu__link "><i class="kt-menu__link-bullet kt-menu__link-bullet--dot"><span></span></i><span class="kt-menu__link-text">الصفحات (الاسواق)</span></a></li>
                                 <?php } ?>
                                </ul>
							</div>
						</li>

						<li class="kt-menu__item  kt-menu__item--submenu kt-menu__item--open" aria-haspopup="true" data-ktmenu-submenu-toggle="hover"><a href="javascript:;" class="kt-menu__link kt-menu__toggle"><i class="kt-menu__link-bullet kt-menu__link-bullet--line"><span></span></i><span class="kt-menu__link-text">الادارة</span><i class="kt-menu__ver-arrow la la-angle-right"></i></a>
							<div class="kt-menu__submenu "><span class="kt-menu__arrow"></span>
								<ul class="kt-menu__subnav">
                                    <li class="kt-menu__item  kt-menu__item--parent" aria-haspopup="true"><span class="kt-menu__link"><span class="kt-menu__link-text">Profile</span></span></li>
                                <?php if(access('2')){?>
                                    <li class="kt-menu__item " aria-haspopup="true"><a href="?page=pages/orders.php" class="kt-menu__link "><i class="kt-menu__link-bullet kt-menu__link-bullet--dot"><span></span></i><span class="kt-menu__link-text">الطبيات</span></a></li>
                                <?php }?>
                               </ul>
							</div>
						</li>
						<li class="kt-menu__item  kt-menu__item--submenu kt-menu__item--open" aria-haspopup="true" data-ktmenu-submenu-toggle="hover"><a href="javascript:;" class="kt-menu__link kt-menu__toggle"><i class="kt-menu__link-bullet kt-menu__link-bullet--line"><span></span></i><span class="kt-menu__link-text">ادارة الطلاب</span><i class="kt-menu__ver-arrow la la-angle-right"></i></a>
							<div class="kt-menu__submenu "><span class="kt-menu__arrow"></span>
								<ul class="kt-menu__subnav">
                                <?php if($a == 4 || $a == 3 || $a == 2 || $a == 1 || $a==99){?>
                                    <li class="kt-menu__item " aria-haspopup="true"><a href="?page=pages/students.php" class="kt-menu__link "><i class="kt-menu__link-bullet kt-menu__link-bullet--dot"><span></span></i><span class="kt-menu__link-text">اضافة وتعديل بيانات الطلاب</span></a></li>
                                <?php }?>
                                <?php if($a == 5 || $a==99){?>
                                    <li class="kt-menu__item " aria-haspopup="true"><a href="?page=pages/studentManagement.php" class="kt-menu__link "><i class="kt-menu__link-bullet kt-menu__link-bullet--dot"><span></span></i><span class="kt-menu__link-text">تقيم الطلاب</span></a></li>
                                <?php }?>
                                <?php if($a == 4 || $a == 3 || $a == 1 || $a==99){?>
                                    <li class="kt-menu__item " aria-haspopup="true"><a href="?page=pages/studentLeave.php" class="kt-menu__link "><i class="kt-menu__link-bullet kt-menu__link-bullet--dot"><span></span></i><span class="kt-menu__link-text">اجازات الطلاب</span></a></li>
                                <?php }?>
                                <?php if($a == 2 || $a == 4 || $a == 3 || $a == 1 || $a==99){?>
                                    <li class="kt-menu__item " aria-haspopup="true"><a href="?page=pages/showStudentLeave.php" class="kt-menu__link "><i class="kt-menu__link-bullet kt-menu__link-bullet--dot"><span></span></i><span class="kt-menu__link-text">عرض اجازات طالب</span></a></li>
                                <?php }?>
                                <?php if($a == 2 || $a == 4 || $a == 3 || $a == 1 || $a==99){?>
                                    <li class="kt-menu__item " aria-haspopup="true"><a href="?page=pages/studentPenalty.php" class="kt-menu__link "><i class="kt-menu__link-bullet kt-menu__link-bullet--dot"><span></span></i><span class="kt-menu__link-text">غرامات الطلاب</span></a></li>
                                <?php }?>
                                </ul>
							</div>
						</li>
                        <li class="kt-menu__item  kt-menu__item--submenu kt-menu__item--open" aria-haspopup="true" data-ktmenu-submenu-toggle="hover"><a href="javascript:;" class="kt-menu__link kt-menu__toggle"><i class="kt-menu__link-bullet kt-menu__link-bullet--line"><span></span></i><span class="kt-menu__link-text">الاعدادات</span><i class="kt-menu__ver-arrow la la-angle-right"></i></a>
							<div class="kt-menu__submenu "><span class="kt-menu__arrow"></span>
								<ul class="kt-menu__subnav">
									<li class="kt-menu__item  kt-menu__item--parent" aria-haspopup="true"><span class="kt-menu__link"><span class="kt-menu__link-text">Profile</span></span></li>
                                    <?php if(access("5")){?>
                                        <li class="kt-menu__item " aria-haspopup="true"><a href="?page=pages/towns.php" class="kt-menu__link "><i class="kt-menu__link-bullet kt-menu__link-bullet--dot"><span></span></i><span class="kt-menu__link-text">المناطق</span></a></li>
                                    <?php } ?>
                                    <?php if(access("6")){?>
                                        <li class="kt-menu__item " aria-haspopup="true"><a href="?page=pages/orderStatus.php" class="kt-menu__link "><i class="kt-menu__link-bullet kt-menu__link-bullet--dot"><span></span></i><span class="kt-menu__link-text">الحالات</span></a></li>
                                    <?php } ?>
                                    <?php if(access("7")){?>
                                        <li class="kt-menu__item " aria-haspopup="true"><a href="?page=pages/attrbutes.php" class="kt-menu__link "><i class="kt-menu__link-bullet kt-menu__link-bullet--dot"><span></span></i><span class="kt-menu__link-text">الاوسمة</span></a></li>
                                    <?php } ?>                                </ul>
							</div>
						</li>


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