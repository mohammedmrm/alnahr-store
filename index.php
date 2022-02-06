<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
if($_SESSION['login'] != 1 && $_SESSION['app'] != 'stote'){
    header('location: login.php');
}
include_once("config.php");
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
		<link href="assets/plugins/custom/datatables/datatables.bundle.rtl.css" rel="stylesheet" type="text/css" />

		<!--end::Layout Skins -->
		<link rel="shortcut icon" href="<?php echo $config['faicon'];?>" />
        <link rel="manifest" href="pwa/manifest.webmanifest">
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
      		min-width: 0;
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
            overflow-y: scroll !important;
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
          background-color:#663300;
          color: #F0F8FF !important;
        }
        .table td {
          text-align: right !important;
          font-size: 13px;
          text-shadow: 0px 0px 0px #000000;
          text-outline: 0px #FF3300;
        }
        .nowarp {
          white-space: nowrap !important;
        }


        ::placeholder ,:-ms-input-placeholder,::-webkit-input-placeholder {
          color: #FFFFFF !important;
          font-weight: normal !important;
        }
        .close {
          margin-right: 0px !important;
        }
        .toast {
          opacity: 1 !important;
        }

        .toast-message{
          font-size: 1.2rem !important;
        }
        .toast-success{
          background-color:#33CC33 !important;
          color:#FFFFFF !important;
        }
        .toast-error{
          background-color: #CC0000 !important;
          color:#FFFFFF;
        }
        .toast-warning{
          background-color: #FFCC33 !important;
          color:#FFFFFF !important;
        }
        .toast-info{
          background-color: #6666FF !important;
          color:#FFFFFF !important;
        }
        hr.hr {
          border: 0;   /* in order to override TWBS stylesheet */
          height: 5px;
          background: -moz-linear-gradient(left, rgba(196,222,138,1) 0%, rgba(196,222,138,1) 12.5%, rgba(245,253,212,1) 12.5%, rgba(245,253,212,1) 25%, rgba(255,208,132,1) 25%, rgba(255,208,132,1) 37.5%, rgba(242,122,107,1) 37.5%, rgba(242,122,107,1) 50%, rgba(223,157,185,1) 50%, rgba(223,157,185,1) 62.5%, rgba(192,156,221,1) 62.5%, rgba(192,156,221,1) 75%, rgba(95,156,217,1) 75%, rgba(95,156,217,1) 87.5%, rgba(94,190,227,1) 87.5%, rgba(94,190,227,1) 87.5%, rgba(94,190,227,1) 100%);  /* FF3.6+ */
          background: -webkit-linear-gradient(left, rgba(196,222,138,1) 0%, rgba(196,222,138,1) 12.5%, rgba(245,253,212,1) 12.5%, rgba(245,253,212,1) 25%, rgba(255,208,132,1) 25%, rgba(255,208,132,1) 37.5%, rgba(242,122,107,1) 37.5%, rgba(242,122,107,1) 50%, rgba(223,157,185,1) 50%, rgba(223,157,185,1) 62.5%, rgba(192,156,221,1) 62.5%, rgba(192,156,221,1) 75%, rgba(95,156,217,1) 75%, rgba(95,156,217,1) 87.5%, rgba(94,190,227,1) 87.5%, rgba(94,190,227,1) 87.5%, rgba(94,190,227,1) 100%); /* Chrome10+,Safari5.1+ */
          background: -o-linear-gradient(left, rgba(196,222,138,1) 0%, rgba(196,222,138,1) 12.5%, rgba(245,253,212,1) 12.5%, rgba(245,253,212,1) 25%, rgba(255,208,132,1) 25%, rgba(255,208,132,1) 37.5%, rgba(242,122,107,1) 37.5%, rgba(242,122,107,1) 50%, rgba(223,157,185,1) 50%, rgba(223,157,185,1) 62.5%, rgba(192,156,221,1) 62.5%, rgba(192,156,221,1) 75%, rgba(95,156,217,1) 75%, rgba(95,156,217,1) 87.5%, rgba(94,190,227,1) 87.5%, rgba(94,190,227,1) 87.5%, rgba(94,190,227,1) 100%); /* Opera 11.10+ */
          background: -ms-linear-gradient(left, rgba(196,222,138,1) 0%, rgba(196,222,138,1) 12.5%, rgba(245,253,212,1) 12.5%, rgba(245,253,212,1) 25%, rgba(255,208,132,1) 25%, rgba(255,208,132,1) 37.5%, rgba(242,122,107,1) 37.5%, rgba(242,122,107,1) 50%, rgba(223,157,185,1) 50%, rgba(223,157,185,1) 62.5%, rgba(192,156,221,1) 62.5%, rgba(192,156,221,1) 75%, rgba(95,156,217,1) 75%, rgba(95,156,217,1) 87.5%, rgba(94,190,227,1) 87.5%, rgba(94,190,227,1) 87.5%, rgba(94,190,227,1) 100%); /* IE10+ */
          background: linear-gradient(to right, rgba(196,222,138,1) 0%, rgba(196,222,138,1) 12.5%, rgba(245,253,212,1) 12.5%, rgba(245,253,212,1) 25%, rgba(255,208,132,1) 25%, rgba(255,208,132,1) 37.5%, rgba(242,122,107,1) 37.5%, rgba(242,122,107,1) 50%, rgba(223,157,185,1) 50%, rgba(223,157,185,1) 62.5%, rgba(192,156,221,1) 62.5%, rgba(192,156,221,1) 75%, rgba(95,156,217,1) 75%, rgba(95,156,217,1) 87.5%, rgba(94,190,227,1) 87.5%, rgba(94,190,227,1) 87.5%, rgba(94,190,227,1) 100%); /* W3C */
        }
        .item-img {
          background-position: center;
          background-repeat: no-repeat;
          background-size: contain;
          border-radius: 5px;
          width:100px;
          height:100px;
        }
        .item-img-xlg {
          background-position: center;
          background-repeat: no-repeat;
          background-size: contain;
          border-radius: 5px;
          width:180px;
          height:180px;
        }
        .item-img-lg {
          background-position: center;
          background-repeat: no-repeat;
          background-size: contain;
          border-radius: 5px;
          width:150px;
          height:150px;
        }
        .item-img-md {
          background-position: center;
          background-repeat: no-repeat;
          background-size: contain;
          border-radius: 5px;
          width:80px;
          height:80px;
        }
        .item-img-sm {
          background-position: center;
          background-repeat: no-repeat;
          background-size: contain;
          border-radius: 5px;
          width:50px;
          height:50px;
        }
        .item-img-xs {
          background-position: center;
          background-repeat: no-repeat;
          background-size: contain;
          border-radius: 5px;
          width:25px;
          height:25px;
        }
        .img-sm{
          background-position: center;
          background-repeat: no-repeat;
          background-size: cover;
          border-radius: 360px;
          width:30px;
          height:30px;
        }
        .modal-open .modal {
            overflow-x: hidden;
            overflow-y: scroll;
        }
        </style>
	</head>

	<!-- end::Head -->

	<!-- begin::Body -->
	<body class="kt-page--loading-enabled kt-page--loading kt-quick-panel--right kt-demo-panel--right kt-offcanvas-panel--right kt-header--static kt-header-mobile--fixed kt-subheader--transparent kt-aside--enabled kt-aside--fixed kt-page--loading">
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
<!--begin::Global Theme Bundle(used by all pages) -->
        <?php include("partials/_page-loader.php"); ?>
        <script src="assets/plugins/global/plugins.bundle.js" type="text/javascript"></script>

        <!--end::Global Theme Bundle -->


        <?php include("layout.php"); ?>
        <script src="assets/js/scripts.bundle.js" type="text/javascript"></script>
        <script src="assets/plugins/custom/datatables/datatables.bundle.js" type="text/javascript"></script>
        <script src="assets/js/pages/components/datatables/extensions/responsive.js" type="text/javascript"></script>
        
        <!--begin::Page Vendors(used by this page) -->
		<script src="assets/plugins/custom/fullcalendar/fullcalendar.bundle.js" type="text/javascript"></script>
        <script src="assets/js/pages/dashboard.js" type="text/javascript"></script>
        <script src="js/toast.js" type="text/javascript"></script>
        <script>
        // Check that service workers are supported
        if ('serviceWorker' in navigator) {
           window.addEventListener('load', () => {
            navigator.serviceWorker.register('sw.js')
          });
        }
        </script>
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
        toastr.options = {
          "closeButton": false,
          "debug": false,
          "newestOnTop": false,
          "progressBar": true,
          "positionClass": "toast-bottom-center",
          "preventDuplicates": false,
          "onclick": null,
          "showDuration": "5000",
          "hideDuration": "1000",
          "timeOut": "5000",
          "extendedTimeOut": "1000",
          "showEasing": "swing",
          "hideEasing": "linear",
          "showMethod": "fadeIn",
          "hideMethod": "fadeOut"
        };
        function phone_format(text) {
          if(text){
            if(text.length == 10){
              return text.replace(/(\d{3})(\d{3})(\d{4})/, '$1-$2-$3');
            }
            if(text.length == 11){
              return text.replace(/(\d{4})(\d{3})(\d{4})/, '$1-$2-$3');
            }
          }
        }
        function formatMoney(amount, decimalCount = 0, decimal = ".", thousands = ",") {
          try {
            decimalCount = Math.abs(decimalCount);
            decimalCount = isNaN(decimalCount) ? 2 : decimalCount;

            const negativeSign = amount < 0 ? "-" : "";

            let i = parseInt(amount = Math.abs(Number(amount) || 0).toFixed(decimalCount)).toString();
            let j = (i.length > 3) ? i.length % 3 : 0;

            return negativeSign + (j ? i.substr(0, j) + thousands : '') + i.substr(j).replace(/(\d{3})(?=\d)/g, "$1" + thousands) + (decimalCount ? decimal + Math.abs(amount - i).toFixed(decimalCount).slice(2) : "");
          } catch (e) {
            console.log(e)
          }
        }
        $('img').on('error',function(){
        this.src='img/default.svg';
        });
        </script>


<!--end::Page Scripts -->
</body>
</html>