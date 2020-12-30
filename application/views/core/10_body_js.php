		<script type="text/javascript" src="core/libs/jquery/jquery.js"></script>
		<!--
		<script type="text/javascript" src="core/libs/bootstrap/bootstrap.min.js"></script>
		<script type="text/javascript" src="core/libs/backstretch/jquery.backstretch.js"></script>
		-->
		<script type="text/javascript" src="core/libs/moment/moment.js"></script>
		<!--
		<script type="text/javascript" src="core/libs/jquery.ui/jquery-ui-1.10.3.custom.min.js"></script>
		-->
		<script type="text/javascript" src="core/libs/daterangepicker/daterangepicker.js"></script>
		<!-- -->
		<!-- Api de Google -->
		<script>function initMap(){  } // or window.initMap = function(){  }</script>
		<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDcH2xfbm8z-5iSE4knkRJiNKRhKQrhH6E&callback=initMap"></script>
		<!-- Api de Google -->
		<script type="text/javascript" src="core/script/system.js"></script>
		<script type="text/javascript" src="core/script/functions.js"></script>
		<script type="text/javascript" src="assets/scripts/main.js"></script>
		<script src="core/libs/sweetalert/sweetalert.js"></script>
		<script src="custom/js/recover_op.js"></script>

		<?foreach($script as $js){?>
			<script src="custom/js/<?=$js?>.js"></script>
		<?}?>

		