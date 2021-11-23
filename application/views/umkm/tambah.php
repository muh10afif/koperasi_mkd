<style>
	
     #hapus-ok,#hapus-not-ok,#import-ok,#import-not-ok{
        display:none;
    }

	.list-image{
		position:relative;
		float:left;
	}
	.hps-foto{
		position:absolute;
		/* clear:both; */
		bottom: 8px;
		margin-left:-100px;
		z-index:9999999999999;
		
	}

	.foto-list{
		height: 150px;
		width: 150px;
		padding:2px;
		float:left;
	}
</style>

<div class="content-wrapper">
	<!-- Content Header (Page header) -->
	<div class="content-header">
		<div class="container-fluid">
			<div class="row mb-2">
				<div class="col-sm-6">
					<h1 class="m-0 text-dark">Master UMKM</h1>
				</div><!-- /.col -->
				<div class="col-sm-6">
					<ol class="breadcrumb float-sm-right">
						<li class="breadcrumb-item"><a href="<?= base_url('home');?>">Home</a></li>
						<li class="breadcrumb-item">Master Data</li>
						<li class="breadcrumb-item active">UMKM</li>
					</ol>
				</div><!-- /.col -->
			</div><!-- /.row -->
		</div><!-- /.container-fluid -->
	</div>
	<!-- /.content-header -->

	<!-- Main content -->
	<section class="content">
		<div class="container-fluid">


			<!-- notifikasi -->
			<div id='import-ok' class="callout callout-info">
                <h4>Sukses!</h4>
                Data UMKM Berhasil Diimport
            </div>

            <div id="import-not-ok" class="callout callout-danger">
                <h4>Maaf!</h4>
                Data UMKM gagal Diimport

            </div>
		
            <div id='hapus-ok' class="callout callout-info">
                <h4>Sukses!</h4>
                Data UMKM Berhasil Dihapus
            </div>

            <div id="hapus-not-ok" class="callout callout-danger">
                <h4>Maaf!</h4>
                Data UMKM gagal Dihapus

            </div>
			
			<?php 
                if($this->session->flashdata('status_update') == "ok")
                    {
            ?>
						<div class="callout callout-info">
							<h4>Sukses!</h4>
							Data UMKM Berhasil Diubah
						</div>
			<?php
                    }
                else if($this->session->flashdata('status_update') == 'not ok')
                    {
            ?>
						<div class="callout callout-danger">
							<h4>Maaf!</h4>
							Data UMKM gagal Diubah
							<?php 
								if(is_array($this->session->flashdata('error')))
									{
										foreach($this->session->flashdata('error') as $key => $value)
											{
												echo "<br><span style='color:red;'>".$value."</span>";
											}
									}
							?>
						</div>
			<?php
                    }
            ?>

			<?php 
                if($this->session->flashdata('status_tambah') == "ok")
                    {
            ?>
						<div class="callout callout-info">
							<h4>Sukses!</h4>
							Data UMKM Berhasil Ditambahkan
						</div>
			<?php
                    }
                else if($this->session->flashdata('status_tambah') == 'not ok')
                    {
            ?>
						<div class="callout callout-danger">
							<h4>Maaf!</h4>
							Data UMKM gagal Ditambahkan
							<?php 
								if(is_array($this->session->flashdata('error')))
									{
										foreach($this->session->flashdata('error') as $key => $value)
											{
												echo "<br><span style='color:red;'>".$value."</span>";
											}
									}
							?>
						</div>
			<?php
                    }
            ?>

			

			<!-- /notifikasi -->
                
			<!-- Main row -->
			<div class="row">
				<!-- Left col -->
				<section class="col-lg-12 connectedSortable">
					<!-- Custom tabs (Charts with tabs)-->
					<div class="card shadow">

						<div class="card-header d-flex p-0">
							<h3 class="card-title p-3">
								<button class="btn btn-sm btn-primary" data-toggle="modal"
									data-target="#modal-tambah"><i class="fa fa-plus mr-2"></i>Tambah Data</button>
							</h3>

						</div><!-- /.card-header -->
						<div class="card-body">
							<div class="tab-content p-0">
								<div class="col-md-12">
									<table id="tbl-data" class="table table-bordered table-striped table-hover" width="100%">
										<thead class="bg-primary">
											<tr>
												<th class="text-center">NO</th>
												<th class="text-center">Nama UMKM</th>
												<th class="text-center">Modal</th>
												<th class="text-center">Alamat</th>
												<th class="text-center">Jenis Dagangan</th>
												<th class="text-center">No Kios</th>
                                                <th class="text-center">Foto</th>
                                                <th class="text-center">Status</th>
                                                <th class="text-center">Aksi</th>
											</tr>
										</thead>
										<tbody>

										</tbody>
									</table>
								</div>
							</div>
						</div><!-- /.card-body -->
					</div>
					<!-- /.card -->
					<!-- Button trigger modal -->


					<!-- Modal -->
					<div class="modal fade" id="modal-tambah" tabindex="-1" role="dialog"
						aria-labelledby="modaltambahlabel" aria-hidden="true">
						<div class="modal-dialog modal-lg modal-dialog-centered" role="document">
							<div class="modal-content">
								<form id="form-tambah" action="<?= base_url('umkm/tambah_data_umkm'); ?>" method="POST"
									class="form-horizontal">
									<div class="modal-header bg-primary">
										<h5 class="modal-title text-center" id="exampleModalLabel">Tambah UMKM</h5>
										<button type="button" class="close pull-left close-tambah" data-dismiss="modal"
											aria-label="Close">
											<span aria-hidden="true">&times;</span>
										</button>
									</div>
									<div class="modal-body">
										<div class="form-group d-flex justify-content-center">
											<label for="inputEmail3" class="col-sm-3 control-label">Nama UMKM</label>
											<div class="col-sm-7">
												<input type="text" name="nama_umkm" class="form-control" placeholder="Masukkan Nama UMKM">
											</div>
										</div>
										<div class="form-group d-flex justify-content-center">
											<label for="inputEmail3" class="col-sm-3 control-label">Modal</label>
											<div class="col-sm-7">
												<input type="text" name="nominal" class="form-control separator" placeholder="Masukkan Modal">
											</div>
										</div>
										<div class="form-group d-flex justify-content-center">
											<label for="inputEmail3" class="col-sm-3 control-label">Alamat</label>
											<div class="col-sm-7">
												<textarea name="alamat" id="" rows="3" class="form-control" placeholder="Masukkan Alamat"></textarea>
											</div>
										</div>
										
										<div class="form-group d-flex justify-content-center">
											<label for="inputEmail3" class="col-sm-3 control-label">Jenis Dagangan</label>
											<div class="col-sm-7">
												<input type="text"  id="" name="jenis" class="form-control" placeholder="Masukkan Jenis Dagangan">
											</div>
										</div>
										<div class="form-group d-flex justify-content-center">
											<label for="inputEmail3" class="col-sm-3 control-label">No Kios</label>
											<div class="col-sm-7">
												<input type="text"  id="" name="no" class="form-control" placeholder="Masukkan No Kios">
											</div>
										</div>

										<div class="form-group d-flex justify-content-center">
											<label for="inputEmail3" class="col-sm-3 control-label">Foto</label>
											<div class="col-sm-7">
												<button id="btn-img" class="btn btn-success" type="button"><i class="fa fa-image"></i></button> <i>&nbsp;Klik  untuk mengupload foto</i>
											</div>
										</div>

										<div class="form-group d-flex justify-content-center">
											<label for="inputEmail3" class="col-sm-3 control-label"></label>
											<div class="col-sm-7">
												<div id="list-foto"></div>
											</div>
										</div>

										<div id="list-data-foto"></div>
									</div>
									<div class="modal-footer">
										<button type="button" class="btn btn-secondary close-tambah"
											data-dismiss="modal"><i class='fa fa-close mr-2'></i>Close</button>
										<button type="submit" class="btn btn-primary"><i
												class="fa fa-check"></i>&nbsp;&nbsp;Simpan</button>
										<button id="btn-reset-tambah" type="button" class="btn btn-success"><i class='fa fa-undo'></i>&nbsp; Reset</button>
									</div>
								</form>

							</div>
						</div>
					</div>
                    <!-- /modal tambah -->
                    
					<!-- modal edit -->
					<div class="modal fade" id="modal-edit" tabindex="-1" role="dialog"
						aria-labelledby="modaltambahlabel" aria-hidden="true">
						<div class="modal-dialog modal-lg modal-dialog-centered" role="document">
							<div class="modal-content">
								<form id="form-edit" action="<?= base_url('problematika/update_problematika'); ?>" method="POST"
									class="form-horizontal">
									<input type="hidden" id="id-umkm" name="id_umkm" >
									<div class="modal-header bg-primary">
										<h5 class="modal-title text-center" id="exampleModalLabel">Edit Data UMKM</h5>
										<button type="button" class="close pull-left" data-dismiss="modal"
											aria-label="Close">
											<span aria-hidden="true">&times;</span>
										</button>
									</div>
									<div class="modal-body">
										<div class="form-group d-flex justify-content-center">
											<label for="inputEmail3" class="col-sm-3 control-label">Nama UMKM</label>
											<div class="col-sm-7">
												<input id="nama-umkm-edit" type="text" name="nama_umkm" class="form-control">
											</div>
										</div>
										<div class="form-group d-flex justify-content-center">
											<label for="inputEmail3" class="col-sm-3 control-label">Modal</label>
											<div class="col-sm-7">
												<input id="nominal-umkm-edit" type="text" name="nominal" class="form-control separator">
											</div>
										</div>
										<div class="form-group d-flex justify-content-center">
											<label for="inputEmail3" class="col-sm-3 control-label">Alamat</label>
											<div class="col-sm-7">
												<textarea id="alamat-umkm-edit" name="alamat" id="" cols="30" rows="3"
													class="form-control"></textarea>
											</div>
										</div>
									
										<div class="form-group d-flex justify-content-center">
											<label for="inputEmail3" class="col-sm-3 control-label">Jenis Dagangan</label>
											<div class="col-sm-7">
												<input id="lat-umkm-edit" type="text" name="jenis" class="form-control">
											</div>
										</div>
										<div class="form-group d-flex justify-content-center">
											<label for="inputEmail3" class="col-sm-3 control-label">No Kios</label>
											<div class="col-sm-7">
												<input id="long-umkm-edit" type="text" name="no" class="form-control">
											</div>
										</div>
										
										<div class="form-group d-flex justify-content-center">
											<label for="inputEmail3" class="col-sm-3 control-label">Foto</label>
											<div class="col-sm-7">
												<button id="btn-img-edit" class="btn btn-success" type="button"><i class="fa fa-image"></i></button> <i>&nbsp;Klik  untuk mengupload foto</i>
											</div>
										</div>

										<div class="form-group d-flex justify-content-center">
											<label for="inputEmail3" class="col-sm-3 control-label">Foto</label>
											<div class="col-sm-7">
												<div id="foto-detail-list-edit" class="col-sm-12">
													
												</div>
												
											</div>
										</div>

										<div id="list-data-foto-edit"></div>
									</div>
									<div class="modal-footer">
										<button type="button" class="btn btn-secondary"
											data-dismiss="modal"><i class='fa fa-close mr-2'></i>Close</button>
										<button type="submit" class="btn btn-primary"><i
												class="fa fa-pencil"></i>&nbsp;&nbsp;Ubah</button>
										<button id="btn-reset-edit" type="button" class="btn btn-success"><i class='fa fa-undo'></i>&nbsp; Reset</button>
									</div>
								</form>

							</div>
						</div>
					</div>
					<button id="btn-edit" class="" data-toggle="modal" data-target="#modal-edit" style="display:none;"></button>
					<!-- /modal edit -->

					<form action="#" method="POST" id="form-upload">
						<input style="display:none;" type="file" name="foto_umkm" id="foto-upload">
					</form>

					<form action="#" method="POST" id="form-upload-edit">
						<input style="display:none;" type="file" name="foto_umkm" id="foto-upload-edit">
					</form>

					<form action="#" method="POST" id="form-import" enctype="multipart/form-data">
						<input style="display:none;" type="file" name="file_excel" id="import-file"> 
					</form>
				</section>

			</div>
			<!-- /.row (main row) -->
		</div><!-- /.container-fluid -->
	</section>
	<!-- /.content -->
</div>
<!-- /.content-wrapper -->
<script>

	var table = $("#tbl-data").DataTable({

			'processing': false,
			'serverSide': true,
			'order': [
				[1, 'asc']
			],
			'ajax': {
				'url': "<?php echo base_url('umkm/get_umkm');?>",
				'type': 'POST',
				'dataType': 'json',

			},

			'columnDefs': [{
				'targets': [0,6,7,8],
				'orderable': false,
			}, {
				'targets': [0,5,6,7,8],
				'className': 'text-center',
			}],

		});
	
	function hapuslisfoto(i){
			$("#data-"+i).remove();
			$("#image-"+i).remove();
		}
	/* detail data kantor mui */
    function detail(i){
		$("#foto-detail-list").html('');
		$.ajax({
			url:"<?= base_url('problematika/show_problematika');?>",
			type:"POST",
			data:"id_problematika="+i,
			dataType:'JSON',
			success:function(r){
				console.log(r);
				$("#nama-problematika").html(r[0].nama_problematika);
				$("#alamat-problematika").html(r[0].alamat);
				$("#deskripsi-problematika").html(r[0].deskripsi);
				$("#lat-problematika").html(r[0].lat);
				$("#long-problematika").html(r[0].long);
				// $("#foto-problematika-detail").attr('src',"<?= 'http://'.$_SERVER['HTTP_HOST'].'/MUI_api/documents/pemetaan_problematika/'; ?>"+r[0].foto);

				var foto = r[0].foto;
				var arr = foto.split(';');
				$.each( arr, function( index, value ) {
					if(value != ""){
						var link = "<?= 'http://'.$_SERVER['HTTP_HOST'].'/MUI_api/documents/pemetaan_problematika/'; ?>"+value;
						$("#foto-detail-list").append('<img class="foto-list" src="'+link+'">');
						console.log(value);
					}
					
				});
				$("#btn-detail").click();
			}
		});
    
	}

    function edit(i){
        $.ajax({
            url:"<?= base_url('umkm/show_umkm'); ?>",
            type:"POST",
            dataType:"JSON",
            data:{id_umkm:i},
            success:function(res){
                console.log(res);
                $("#modal-edit").modal('show');
                $("#id-umkm").val(res.id_umkm);
                $("#nama-umkm-edit").val(res.nama_umkm);
                $("#nominal-umkm-edit").val(res.modal_awal);
                $("#alamat-umkm-edit").val(res.alamat);
                $("#lat-umkm-edit").val(res.jenis_dagangan);
                $("#long-umkm-edit").val(res.no_kios);
                var link = "<?= base_url('assets/image/'); ?>"+ res.foto;
                var iddata = $.now();
                $("#foto-detail-list-edit").html('<div id="image-'+iddata+'" class="list-image"><img class="foto-list" src="'+link+'"><button type="button" onclick="hapuslisfoto(\''+iddata+'\')" class="btn btn-danger btn-sm hps-foto">Hapus</button></div>');
                $("#list-data-foto-edit").html('<input id="data-'+iddata+'" type="hidden" name="link_foto" value="'+res.foto+'">');
            }
        });
    };

    
	

	// hapus data kantor
	function hapus(i){
		Swal.fire({
			title: 'Peringatan !',
			text: "Apakah anda yakin akan menghapus data ini ?",
			type: 'warning',
			showCancelButton: true,
			confirmButtonColor: '#3085d6',
			cancelButtonColor: '#d33',
			confirmButtonText: 'Ya, Hapus!',
			cancelButtonText: 'Tidak, Batalkan!',
			}).then((result) => {
				if (result.value) {
					$.ajax({
						url:"<?= base_url('problematika/hapus_problematika')?>",
						type:"POST",
						data:'id_problematika='+i,
						dataType:"JSON",
						success:function(r){
							if(r.status == 'ok'){
								
								// $("#hapus-not-ok").hide();
								// $("#hapus-ok").show();
								Swal.fire({
									title: 'Sukses !',
									text: 'Data Problematika Berhasil Dihapus',
									type: 'success',
								});
							}
							else{
								// $("#hapus-ok").hide();
								// $("#hapus-not-ok").show();
								Swal.fire({
									title: 'Maaf !',
									text: 'Data Problematika Gagal Dihapus',
									type: 'error',
								});
							}

							setTimeout(function(){
								// $("#hapus-not-ok").hide();
								// $("#hapus-ok").hide();
								Swal.close();
							},3000);
						}
					});
				}
			});
	}
	


	$(document).ready(function () {

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

		/* tombol reset */
		$(".close-tambah").click(function(){
			
			$("#form-tambah").trigger("reset");
			$("#form-upload").trigger("reset");
			$("#list-foto").html("");
			$("#list-data-foto").html("");
			// $("#modal-tambah").modal('close');
		});
		/* tombol reset form tambah */
		$("#btn-reset-tambah").click(function(){
			
			$("#form-tambah").trigger("reset");
			$("#form-upload").trigger("reset");
			$("#list-foto").html("");
			$("#list-data-foto").html("");
		});

		/* tombol reset form edit */
		$("#btn-reset-edit").click(function(){
			$("#form-upload-edit").trigger("reset");
			var iddata = $("#id-problematika").val();
			
			$.ajax({
				url:"<?= base_url('problematika/show_problematika');?>",
				type:"POST",
				data:"id_problematika="+iddata,
				dataType:'JSON',
				success:function(r){
					console.log(r);
					$("#id-problematika").val(r[0].id_problematika);
					$("#nama-problematika-edit").val(r[0].nama_problematika);
					$("#alamat-problematika-edit").val(r[0].alamat);
					$("#deskripsi-problematika-edit").val(r[0].deskripsi);
					$("#lat-problematika-edit").val(r[0].jenis_dagangan);
					$("#long-problematika-edit").val(r[0].no_kios);
					// $("#foto-problematika-edit").attr('src',"<?= 'http://'.$_SERVER['HTTP_HOST'].'/MUI_api/documents/pemetaan_problematika/'; ?>"+r[0].foto);
					// $("#link-foto-edit").val(r[0].foto)
					$("#foto-detail-list-edit").html("");
					$("#list-data-foto-edit").html("");
					var foto = r[0].foto;
					var arr = foto.split(';');
					$.each( arr, function( index, value ) {
						if(value != ""){
							var iddata = $.now();
							var link = "<?= 'http://'.$_SERVER['HTTP_HOST'].'/MUI_api/documents/pemetaan_problematika/'; ?>"+value;
							// $("#foto-organisasi-detail-list-edit").append('<img class="foto-list" src="'+link+'">');
							$("#foto-detail-list-edit").append('<div id="image-'+iddata+'" class="list-image"><img class="foto-list" src="'+link+'"><button type="button" onclick="hapuslisfoto(\''+iddata+'\')" class="btn btn-danger btn-sm hps-foto">Hapus</button></div>');
							
							// console.log(value);
							$("#list-data-foto-edit").append('<input id="data-'+iddata+'" type="hidden" name="link_foto" value="'+value+'">');
						}
						
					});
					
				}
			});
			
		});

		/* /tombol reset */
		/* form tambah data */
		$("#form-tambah").submit(function(e){
			e.preventDefault();
			var data = $(this).serialize();

			$.ajax({
				url:"<?= base_url('umkm/tambah_data_umkm');?>",
				type:"POST",
				dataType:"JSON",
				data:data,
				success:function(res){
					console.log(res);
					if(res.status_tambah =="ok"){
						Swal.fire({
							title: 'Sukses !',
							text: 'Data umkm Berhasil Ditambahkan',
							type: 'success',
						});
						$("#form-tambah").trigger("reset");
						$("#list-foto").html("");
						$("#list-data-foto").html("");
						$(".close").click();
                        table.ajax.reload(null, false);
					}
					else if(res.status_tambah == "gagal"){
						var error = "";

						$.each(res.error,function(index,value){
							error += value+"<br>";
							console.log(value);
						});
						Swal.fire({
							title: 'Maaf !',
							text: 'Data UMKM Gagal Ditambahkan',
							type: 'error',
							html:error,
						});
					}
					else{
						Swal.fire({
							title: 'Maaf !',
							text: 'Data UMKM Gagal Ditambahkan',
							type: 'error',
							// html:''
						});
					}
				}
			});

			// console.log(data);
		});
		/* / form tambah data */

		/* form edit data */

		$("#form-edit").submit(function(e){
			e.preventDefault();

			var data = $(this).serialize();

			$.ajax({
				url:"<?= base_url('umkm/update_umkm')?>",
				data:data,
				type:"POST",
				dataType:"JSON",
				success:function(res){
					if(res.status_update =="ok"){
						Swal.fire({
							title: 'Sukses !',
							text: 'Data UMKM Berhasil Diubah',
							type: 'success',
						});
						$("#form-edit").trigger("reset");
						$("#list-foto-edit").html("");
						$("#list-data-foto-edit").html("");
						$(".close").click();
                        table.ajax.reload(null, false);
					}
					else if(res.status_update == "gagal"){
						var error = "";

						$.each(res.error,function(index,value){
							error += value+"<br>";
							console.log(value);
						});
						Swal.fire({
							title: 'Maaf !',
							text: 'Data UMKM Gagal Diubah',
							type: 'error',
							html:error,
						});
					}
					else{
						Swal.fire({
							title: 'Maaf !',
							text: 'Data UMKM Gagal Diubah',
							type: 'error',
							// html:''
						});
					}
				}
			});
		});
		/* /form edit data */
		/* upload foto */
		$("#btn-img").click(function () {
			$("#foto-upload").click();
		});


		$("#foto-upload").change(function () {
			$("#form-upload").submit();
		});


		$("#form-upload").submit(function (a) {
			a.preventDefault();

			$.ajax({
				url: "<?= base_url('umkm/upload'); ?>?",
				method: "POST",
				data: new FormData(this),
				dataType: 'JSON',
				contentType: false,
				cache: false,
				processData: false,
				success: function (res) {
					if (res.status == 'berhasil') {
						console.log(res);
						
						var iddata = $.now();
						var link = "<?= 'http://'.$_SERVER['HTTP_HOST'].'/somat/assets/image/'; ?>"+ res.file;
						$("#list-foto").html('<div id="image-'+iddata+'" class="list-image"><img class="foto-list" src="'+link+'"><button type="button" onclick="hapuslisfoto(\''+iddata+'\')" class="btn btn-danger btn-sm hps-foto">Hapus</button></div>');
						$("#list-data-foto").html('<input id="data-'+iddata+'" type="hidden" name="link_foto" value="'+res.file+'">');


					} else {
						Swal.fire({
							title: 'Maaf !',
							text: 'File Gagal Diupload, silahkan cek kembali format file.',
							type: 'error',
							// html:''
						});
					}
				},

			});
		});
		/* /upload foto */

		/* datatable */
		// var table = $("#tbl-data").DataTable({

		// 	'processing': false,
		// 	'serverSide': true,
		// 	'order': [
		// 		[1, 'asc']
		// 	],
		// 	'ajax': {
		// 		'url': "<?php echo base_url('umkm/get_umkm');?>",
		// 		'type': 'POST',
		// 		'dataType': 'json',

		// 	},

		// 	'columnDefs': [{
		// 		'targets': [0,6,7],
		// 		'orderable': false,
		// 	}, {
		// 		'targets': [0,5,6,7],
		// 		'className': 'text-center',
		// 	}],

		// });


		// setInterval(function () {
		// 	table.ajax.reload(null, false); // user paging is not reset on reload

		// }, 1000);

		/* datatable */


		// edit upload foto
		$("#btn-img-edit").click(function () {
			$("#foto-upload-edit").click();
		});


		$("#foto-upload-edit").change(function () {
			$("#form-upload-edit").submit();
		});


		$("#form-upload-edit").submit(function (a) {
			a.preventDefault();

			$.ajax({
				url: "<?= base_url('umkm/upload'); ?>?",
				method: "POST",
				data: new FormData(this),
				dataType: 'JSON',
				contentType: false,
				cache: false,
				processData: false,
				success: function (res) {
					if (res.status == 'berhasil') {
						console.log(res);
						// $("#foto-problematika-edit").attr('src',"<?= 'http://'.$_SERVER['HTTP_HOST'].'/MUI_api/documents/pemetaan_problematika/'; ?>"+ res.file);
						// $("#link-foto-edit").val(res.file);
						var iddata = $.now();
						var link = "<?= base_url('assets/image/');?>"+ res.file;
						$("#foto-detail-list-edit").html('<div id="image-'+iddata+'" class="list-image"><img class="foto-list" src="'+link+'"><button type="button" onclick="hapuslisfoto(\''+iddata+'\')" class="btn btn-danger btn-sm hps-foto">Hapus</button></div>');
						
						// console.log(value);
						$("#list-data-foto-edit").html('<input id="data-'+iddata+'" type="hidden" name="link_foto" value="'+res.file+'">');

					} else {
						Swal.fire({
							title: 'Maaf !',
							text: 'File Gagal Diupload, silahkan cek kembali format file.',
							type: 'error',
							// html:''
						});
					}
				},

			});
		});

		/* import data */
		$("#btn-import").click(function () {
			$("#import-file").click();
		});


		$("#import-file").change(function () {
			$("#form-import").submit();
		});


		$("#form-import").submit(function (a) {
			a.preventDefault();

			$.ajax({
				url: "<?= base_url('problematika/upload_excel'); ?>?",
				method: "POST",
				data: new FormData(this),
				dataType: 'JSON',
				contentType: false,
				cache: false,
				processData: false,
				success: function (res) {
					console.log(res);
					if(res.status =="berhasil"){
						$("#import-not-ok").hide();
						$("#import-ok").show();
					}
					else{
						$("#import-ok").hide();
						$("#import-not-ok").show();
					}
				},

			});
		});
		/* import excel */
	});

</script>


<script>
function aktif(i){
        $.ajax({
            url:"<?= base_url('umkm/umkm_aktif'); ?>",
            type:"POST",
            dataType:"JSON",
            data:{id_umkm:i},
            success:function(res){
                if(res.status == "ok"){
                    Swal.fire({
                        title: 'Sukses !',
                        text: 'Data UMKM berhasil di aktivasi',
                        type: 'success',
                    });
                    table.ajax.reload(null, false);
                }
                else{
                    Swal.fire({
                        title: 'Maaf !',
                        text: 'Data UMKM gagal di aktivasi',
                        type: 'error',
                    });
                }
                
            }
        });
    }

    function nonaktif(i){
        $.ajax({
            url:"<?= base_url('umkm/umkm_non_aktif'); ?>",
            type:"POST",
            dataType:"JSON",
            data:{id_umkm:i},
            success:function(res){
                if(res.status == "ok"){
                    Swal.fire({
                        title: 'Sukses !',
                        text: 'Data UMKM berhasil di non aktifkan',
                        type: 'success',
                    });
                    table.ajax.reload(null, false);
                }
                else{
                    Swal.fire({
                        title: 'Maaf !',
                        text: 'Data UMKM gagal di non aktifkan',
                        type: 'error',
                    });
                }
                
            }
        });
    }
</script>

