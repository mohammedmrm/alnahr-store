
<!--begin: User Bar -->
<div class="kt-header__topbar-item kt-header__topbar-item--user">
	<div class="kt-header__topbar-wrapper" id="kt_offcanvas_toolbar_profile_toggler_btn">

		<!--use "kt-rounded" class for rounded avatar style-->
		<div class="kt-header__topbar-user kt-rounded-">
			<span class="kt-header__topbar-welcome kt-hidden-mobile">مرحبا,</span>
			<span class="kt-header__topbar-username kt-hidden-mobile"><?php echo $_SESSION['user_details']['name'];?></span>
			<img alt="Pic" class="kt-hidden" src="assets/media/users/300_25.jpg" class="kt-rounded-" />

			<!--use below badge element instead the user avatar to display username's first letter(remove kt-hidden class to display it) -->
			<span class="kt-badge kt-badge--username kt-badge--lg kt-badge--brand  kt-badge--bold"><?php echo $_SESSION['user_details']['name'][0];?></span>
		</div>
	</div>
</div>

<!--end: User Bar -->