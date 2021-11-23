<!DOCTYPE html>
<html>

<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title><?= (!empty($judul)) ? $a = ucwords($judul)." | " : '' ?>MKD</title>
	<!-- Tell the browser to be responsive to screen width -->
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<!-- Font Awesome -->
	<!-- <link rel="stylesheet" href="<?php echo base_url();?>assets/adminlte/plugins/font-awesome/css/font-awesome.min.css"> -->
	<link rel="stylesheet" href="<?php echo base_url();?>assets/font-awesome/css/all.css">
	<!-- Ionicons -->
	<link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
	<!-- DataTables -->
	<link rel="stylesheet" href="<?php echo base_url();?>assets/adminlte/plugins/datatables-bs4/css/dataTables.bootstrap4.css">
	
	<!-- iCheck -->
	<link rel="stylesheet" href="<?php echo base_url();?>assets/adminlte/plugins/iCheck/flat/blue.css">
	<!-- Morris chart -->
	<link rel="stylesheet" href="<?php echo base_url();?>assets/adminlte/plugins/morris/morris.css">
	<!-- jvectormap -->
	<link rel="stylesheet"
		href="<?php echo base_url();?>assets/adminlte/plugins/jvectormap/jquery-jvectormap-1.2.2.css">
	<!-- Date Picker -->
	<link rel="stylesheet" href="<?php echo base_url();?>assets/adminlte/plugins/datepicker/datepicker3.css">
	<link rel="stylesheet" href="<?php echo base_url('assets/datepicker/datepicker3.css');?>" >
	<!-- select 2 -->
	<link rel="stylesheet" href="<?= base_url() ?>assets/adminlte/plugins/select2/css/select2.min.css">
	<!-- Daterange picker -->
	<link rel="stylesheet"
		href="<?php echo base_url();?>assets/adminlte/plugins/daterangepicker/daterangepicker-bs3.css">
	<!-- bootstrap wysihtml5 - text editor -->
	<link rel="stylesheet"
		href="<?php echo base_url();?>assets/adminlte/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css">
	<!-- Google Font: Source Sans Pro -->
	<link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
	<link rel="stylesheet" href="<?php echo base_url();?>assets/adminlte/plugins/overlayScrollbars/css/OverlayScrollbars.css">
	<link rel="icon" href="<?php echo base_url();?>assets/logo/mui.png" type="image/png" />
	<link href="<?= base_url() ?>assets/swa/sweetalert2.css">

	<!-- Theme style -->
	<link rel="stylesheet" href="<?php echo base_url();?>assets/adminlte/dist/css/adminlte.min.css">

	<link rel="stylesheet" href="<?= base_url() ?>assets/font-awesome-4/css/font-awesome.min.css">
	<style>
		.footer-link {
			color: red;
		}

	</style>
	<!-- jQuery -->
	<!-- <script src="<?php echo base_url();?>assets/adminlte/plugins/jquery/jquery.min.js"></script> -->
	<script src="<?php echo base_url('assets/js/jquery-3.3.1.min.js')?>"></script>
	<!-- jQuery UI 1.11.4 -->
	<!-- <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js"></script> -->
	<!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
	<script>
		// $.widget.bridge('uibutton', $.ui.button)

	</script>
	<!-- Bootstrap 4 -->
	<script src="<?php echo base_url();?>assets/adminlte/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
	<!-- Morris.js charts -->
	<script src="https://cdnjs.cloudflare.com/ajax/libs/raphael/2.1.0/raphael-min.js"></script>
	<!-- <script src="<?php echo base_url();?>assets/adminlte/plugins/morris/morris.min.js"></script> -->
	<!-- Sparkline -->
	<script src="<?php echo base_url();?>assets/adminlte/plugins/sparkline/jquery.sparkline.min.js"></script>
	<!-- jvectormap -->
	<script src="<?php echo base_url();?>assets/adminlte/plugins/jvectormap/jquery-jvectormap-1.2.2.min.js"></script>
	<script src="<?php echo base_url();?>assets/adminlte/plugins/jvectormap/jquery-jvectormap-world-mill-en.js">
	</script>
	<!-- DataTables -->
	<script src="<?php echo base_url();?>assets/adminlte/plugins/datatables/jquery.dataTables.js"></script>
	<script src="<?php echo base_url();?>assets/adminlte/plugins/datatables-bs4/js/dataTables.bootstrap4.js"></script>
	<!-- jQuery Knob Chart -->
	<script src="<?php echo base_url();?>assets/adminlte/plugins/knob/jquery.knob.js"></script>
	<!-- daterangepicker -->
	<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.10.2/moment.min.js"></script>
	<script src="<?php echo base_url();?>assets/adminlte/plugins/daterangepicker/daterangepicker.js"></script>
	<!-- datepicker -->
	<script src="<?php echo base_url();?>assets/adminlte/plugins/datepicker/bootstrap-datepicker.js"></script>
	<script src="<?php echo base_url('assets/datepicker/bootstrap-datepicker.js');?>"></script>
	<!-- select 2 -->
	<script src="<?= base_url() ?>assets/adminlte/plugins/select2/js/select2.full.min.js"></script>
	<!-- Bootstrap WYSIHTML5 -->
	<script src="<?php echo base_url();?>assets/adminlte/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js">
	</script>
	<!-- Slimscroll -->
	<script src="<?php echo base_url();?>assets/adminlte/plugins/slimScroll/jquery.slimscroll.min.js"></script>
	<!-- FastClick -->
	<script src="<?php echo base_url();?>assets/adminlte/plugins/fastclick/fastclick.js"></script>
	<script src="<?php echo base_url();?>assets/adminlte/plugins/overlayScrollbars/js/jquery.overlayScrollbars.js"></script>
	<script src="<?= base_url() ?>assets/swa/sweetalert2.all.min.js"></script>
	<!-- separator divider -->
	<script src="<?= base_url() ?>assets/divider/number-divider.min.js"></script>

	<!-- AdminLTE App -->
	<script src="<?php echo base_url();?>assets/adminlte/dist/js/adminlte.js"></script>
	<!-- AdminLTE dashboard demo (This is only for demo purposes) -->
	<!-- <script src="<?php echo base_url();?>assets/adminlte/dist/js/pages/dashboard.js"></script> -->
	<!-- AdminLTE for demo purposes -->
	<script src="<?php echo base_url();?>assets/adminlte/dist/js/demo.js"></script>

	
	<script>
		var urlhost = "<?php echo base_url();?>";

		$(document).ready(function () {
			$('.select2').select2();

			$('.tgl').datepicker({
				format: 'dd-MM-yyyy',
				autoclose: true,
			})

			$(".tgl-bulan").datepicker( {
				format: "MM-yyyy",
				viewMode: "months", 
				minViewMode: "months",
				autoclose: true
			});
		})

		$('.separator').divide({
			delimiter: '.',
			divideThousand: true, // 1,000..9,999
			delimiterRegExp: /[\.\,\s]/g
		});

		$('.separator').keypress(function(event) {
			if ((event.which != 46 || $(this).val().indexOf('.') != -1) && (event.which < 48 || event.which > 57)) {
				event.preventDefault();
			}
		});

		$('.angka').keypress(function(event) {
			if (event.which != 8 && event.which != 0 && (event.which < 48 || event.which > 57)) {
				event.preventDefault();
			}
		});

	</script>
</head>

<body class="sidebar-mini layout-fixed layout-navbar-fixed sidebar-collapse">
	<div class="wrapper">

		<?php
        	$this->load->view('layout/navbar');
        	$this->load->view('layout/sidebar');
			$this->load->view(@$content);
			$this->load->view('layout/footer');
		?>
		<!-- Control Sidebar -->
		<aside class="control-sidebar control-sidebar-dark">
			<!-- Control sidebar content goes here -->
		</aside>
		<!-- /.control-sidebar -->
	</div>
	<!-- ./wrapper -->


</body>

</html>
