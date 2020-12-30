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
		<script type="text/javascript" src="core/script/system.js"></script>
		<script type="text/javascript" src="core/script/functions.js"></script>
		<script type="text/javascript" src="assets/scripts/main.js"></script>
		<script src="core/libs/sweetalert/sweetalert.js"></script>
		<!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.12.2/js/bootstrap-select.min.js"></script> -->
		<script src="core/libs/bootstrap-datepicker/js/bootstrap-datepicker.min.js"></script>
		<script src="core/libs/validate js/validate.min.js"></script>
		
		<?foreach($script as $js){?>
			<script src="custom/js/<?=$js?>.js"></script>
		<?}?>