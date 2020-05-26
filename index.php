<?php
require_once('script/_access.php');
if(!isset($_SESSION)){
 session_start();
}
?>
<!DOCTYPE html>

<!--
Theme: Keen - The Ultimate Bootstrap Admin Theme
Author: KeenThemes
Website: http://www.keenthemes.com/
Contact: support@keenthemes.com
Follow: www.twitter.com/keenthemes
Dribbble: www.dribbble.com/keenthemes
Like: www.facebook.com/keenthemes
License: You must have a valid license purchased only from https://themes.getbootstrap.com/product/keen-the-ultimate-bootstrap-admin-theme/ in order to legally use the theme for your project.
-->
<html lang="en">

	<!-- begin::Head -->
	<head>
		<base href="">
		<meta charset="utf-8" />
		<title>نظام المخازن</title>
		<meta name="description" content="Latest updates and statistic charts">
		<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
		<meta http-equiv="X-UA-Compatible" content="IE=edge" />

		<!--begin::Fonts -->
		<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700">

		<!--end::Fonts -->

		<!--begin::Page Vendors Styles(used by this page) -->
		<link href="assets/plugins/custom/fullcalendar/fullcalendar.bundle.rtl.css" rel="stylesheet" type="text/css" />

		<!--end::Page Vendors Styles -->

		<!--begin::Global Theme Styles(used by all pages) -->
		<link href="assets/plugins/global/plugins.bundle.rtl.css" rel="stylesheet" type="text/css" />
		<link href="assets/css/style.bundle.rtl.css" rel="stylesheet" type="text/css" />

		<!--end::Global Theme Styles -->

		<!--begin::Layout Skins(used by all pages) -->
		<link href="assets/css/skins/header/base/light.rtl.css" rel="stylesheet" type="text/css" />
		<link href="assets/css/skins/header/menu/light.rtl.css" rel="stylesheet" type="text/css" />
		<link href="assets/css/skins/brand/light.rtl.css" rel="stylesheet" type="text/css" />
		<link href="assets/css/skins/aside/navy.rtl.css" rel="stylesheet" type="text/css" />

		<!--end::Layout Skins -->
		<link rel="shortcut icon" href="assets/media/logos/favicon.ico" />
<style>
        /* arabic */
        @font-face {
          font-family: 'Cairo';
          font-style: normal;
          font-weight: 400;
          font-display: swap;
          src: local('Cairo'), local('Cairo-Regular'), url(Cairofont.woff2) format('woff2');
          unicode-range: U+0600-06FF, U+200C-200E, U+2010-2011, U+204F, U+2E41, U+FB50-FDFF, U+FE80-FEFC;
        }
        /* latin-ext */
        @font-face {
          font-family: 'Cairo';
          font-style: normal;
          font-weight: 400;
          font-display: swap;
          src: local('Cairo'), local('Cairo-Regular'), url(Cairofont.woff2) format('woff2');
          unicode-range: U+0100-024F, U+0259, U+1E00-1EFF, U+2020, U+20A0-20AB, U+20AD-20CF, U+2113, U+2C60-2C7F, U+A720-A7FF;
        }

      fieldset {

      		margin: 0;
      		xmin-width: 0;
      		padding: 10px;
      		position: relative;
      		border-radius:4px;
              border-bottom:2px solid #FF6600;
      		background-color:#f5f5f5;
      		padding-left:10px !important;
      		width:100%;
      }
      legend
      {
      	font-size:14px;
      	font-weight:bold;
      	margin-bottom: 0px;
      	width: 55%;
      	border: 1px solid #ddd;
      	border-radius: 4px;
      	padding: 5px 5px 5px 10px;
      	background-color: #ffffff;
      }
        body * :not(.fa):not(.la):not(.kt-widget-20__label):not(.kt-widget-19__label):not(.close):not(.check-mark) {
          font-family: 'Cairo', sans-serif !important;
        }

        body {
           background-color: #F0F8FF;
           overflow-x: hidden;
        }

        body,body * :not([type="tel"]):not(.other):not(td):not(th) {
            direction: rtl !important;
            text-align: right !important;
        }
        .kt-wizard-v1__wrapper * {
          direction: ltr !important;
        }

        input[type=email],.form_datetime {
          direction: ltr !important;
        }
        .table th {
          font-size: 13px;
          font-weight: 500;
          background-color: #131357;
          color: #F0F8FF !important;
        }
        .table td {
          text-align: center !important;
          font-size: 13px;
          text-shadow: 0px 0px 0px #000000;
          text-outline: 0px #FF3300;
        }
        .nowarp {
          white-space: nowrap !important;
        }
        .dropdown-menu {
          z-index: 100 !important;
        }

        ::placeholder ,:-ms-input-placeholder,::-webkit-input-placeholder {
          color: #FFFFFF !important;
          font-weight: normal !important;
        }
        .close {
          margin-right: 0px !important;
        }

        </style>
	</head>

	<!-- end::Head -->

	<!-- begin::Body -->
	<body class="kt-page--loading-enabled kt-page--loading kt-quick-panel--right kt-demo-panel--right kt-offcanvas-panel--right kt-header--static kt-header-mobile--fixed kt-subheader--transparent kt-aside--enabled kt-aside--fixed kt-page--loading">
	   <?php include("partials/_page-loader.php"); ?>



		<!-- begin::Global Config(global config for global JS sciprts) -->


		<!-- end::Global Config -->

		<!--begin::Global Theme Bundle(used by all pages) -->
		<script src="assets/plugins/global/plugins.bundle.js" type="text/javascript"></script>
          <script>
			var KTAppOptions = {
				"colors": {
					"state": {
						"brand": "#5d78ff",
						"metal": "#c4c5d6",
						"light": "#ffffff",
						"accent": "#00c5dc",
						"primary": "#5867dd",
						"success": "#34bfa3",
						"info": "#36a3f7",
						"warning": "#ffb822",
						"danger": "#fd3995",
						"focus": "#9816f4"
					},
					"base": {
						"label": [
							"#c5cbe3",
							"#a1a8c3",
							"#3d4465",
							"#3e4466"
						],
						"shape": [
							"#f0f3ff",
							"#d9dffa",
							"#afb4d4",
							"#646c9a"
						]
					}
				}
			};
		</script>

        <?php include("layout.php"); ?>

        <script src="assets/js/scripts.bundle.js" type="text/javascript"></script>
        <!--end::Global Theme Bundle -->

		<!--begin::Page Vendors(used by this page) -->
		<script src="assets/plugins/custom/fullcalendar/fullcalendar.bundle.js" type="text/javascript"></script>

		<!--end::Page Vendors -->

		<!--begin::Page Scripts(used by this page) -->
		<script src="assets/js/pages/dashboard.js" type="text/javascript"></script>
<script>
$(document).ready(function () {
        $(document).on('show.bs.modal', '.modal', function (event) {
            var zIndex = 1040 + (10 * $('.modal:visible').length);
            $(this).css('z-index', zIndex);
            setTimeout(function() {
                $('.modal-backdrop').not('.modal-stack').css('z-index', zIndex - 1).addClass('modal-stack');
            }, 0);
        });
});
</script>
		<!--end::Page Scripts -->
	</body>

	<!-- end::Body -->
</html>