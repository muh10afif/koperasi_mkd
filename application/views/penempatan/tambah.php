<div class="content-wrapper">
	<!-- Content Header (Page header) -->
	<div class="content-header">
		<div class="container-fluid">
			<div class="row mb-2">
				<div class="col-sm-6">
					<h1 class="m-0 text-dark">List Penempatan</h1>
				</div><!-- /.col -->
				<div class="col-sm-6">
					<ol class="breadcrumb float-sm-right">
						<li class="breadcrumb-item"><a href="<?= base_url('home');?>">Home</a></li>
						<li class="breadcrumb-item active">Penempatan</li>
					</ol>
				</div><!-- /.col -->
			</div><!-- /.row -->
		</div><!-- /.container-fluid -->
	</div>
	<!-- /.content-header -->

	<!-- Main content -->
	<section class="content">
		<div class="container-fluid">
			<!-- Main row -->
			<div class="row">
				<!-- Left col -->
				<section class="col-lg-12 connectedSortable">
					<!-- Custom tabs (Charts with tabs)-->
					<div class="card shadow">

						<div class="card-header d-flex p-0">
							<h3 class="card-title p-3">
								<button class="btn btn-sm btn-primary" data-toggle="modal" data-target="#modal-tambah"><i class="fa fa-plus"></i>&nbsp;&nbsp;Tambah Data</button>								
							</h3>

						</div><!-- /.card-header -->
						<div class="card-body">
							<div class="tab-content p-0">
								<div class="col-md-12">
									<table id="tbl-data" class="table table-bordered table-striped table-hover" width="100%">
										<thead class="bg-primary">
											<tr>
												<th class="text-center">NO</th>
												<th class="text-center">Nama Pegawai</th>
												<th class="text-center">Nama UMKM</th>
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
								<form id="form-tambah" action="<?= base_url('penempatan/tambah_penempatan'); ?>" method="POST"
									class="form-horizontal">
									<div class="modal-header bg-primary">
										<h5 class="modal-title text-center" id="exampleModalLabel">Tambah Penempatan</h5>
										<button type="button" class="close pull-left close-tambah" data-dismiss="modal"
											aria-label="Close">
											<span aria-hidden="true">&times;</span>
										</button>
									</div>
									<div class="modal-body">
										<div class="form-group d-flex justify-content-center">
											<label for="inputEmail3" class="col-sm-3 control-label">Nama Pegawai</label>
											<div class="col-sm-7">
												<select name="pegawai" id="pegawai-tambah" class="form-control">
                                                    <option value="" selected>--Pilih Pegawai--</option>
                                                   
                                                </select>
											</div>
										</div>

                                        <div class="form-group d-flex justify-content-center">
											<label for="inputEmail3" class="col-sm-3 control-label">UMKM</label>
											<div class="col-sm-7">
												<select name="umkm" id="umkm-tambah" class="form-control">
                                                    <option value="" selected>--Pilih UMKM--</option>
                                                    <?php foreach($umkm as $u): ?>
                                                        <option value="<?= $u->id_umkm;?>"><?= $u->nama_umkm;?></option>
                                                    <?php endforeach;?>
                                                </select>
											</div>
										</div>
										

                                    
										
									</div>
									<div class="modal-footer">
										<button type="button" class="btn btn-secondary close-tambah" data-dismiss="modal"><i class="fa fa-close mr-2"></i>Close</button>
										<button type="submit" class="btn btn-primary"><i class="fa fa-check"></i>&nbsp;&nbsp;Simpan</button>
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
								<form id="form-edit" action="<?= base_url('penempatan/update_penempatan'); ?>" method="POST"
									class="form-horizontal">
									<input type="hidden" id="id-penempatan" name="id_penempatan" >
									<div class="modal-header bg-primary">
										<h5 class="modal-title text-center" id="exampleModalLabel">Edit Data Pegawai</h5>
										<button type="button" class="close pull-left" data-dismiss="modal"
											aria-label="Close">
											<span aria-hidden="true">&times;</span>
										</button>
									</div>
									<div class="modal-body">
										<div class="form-group d-flex justify-content-center">
											<label for="inputEmail3" class="col-sm-3 control-label">Nama Pegawai</label>
											<div class="col-sm-7">
												<select id="pegawai-edit" name="pegawai" id="" class="form-control">
                                                    <option value="" selected>--Pilih Pegawai--</option>
                                                    
                                                </select>
											</div>
										</div>

                                        <div class="form-group d-flex justify-content-center">
											<label for="inputEmail3" class="col-sm-3 control-label">UMKM</label>
											<div class="col-sm-7">
												<select id="umkm-edit" name="umkm" class="form-control">
                                                    <option value="">--Pilih UMKM--</option>
                                                    <?php foreach($umkm as $u): ?>
                                                        <option value="<?= $u->id_umkm;?>"><?= $u->nama_umkm;?></option>
                                                    <?php endforeach;?>
                                                </select>
											</div>
										</div>
									</div>
									<div class="modal-footer">
										<button type="button" class="btn btn-secondary" data-dismiss="modal"><i class="fa fa-close mr-2"></i>Close</button>
										<button type="submit" class="btn btn-primary"><i class="fa fa-pencil"></i>&nbsp;&nbsp;Ubah</button>
										<button id="btn-reset-edit" type="button" class="btn btn-success"><i class='fa fa-undo'></i>&nbsp; Reset</button>
									</div>
								</form>

							</div>
						</div>
					</div>
					
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
				'url': "<?php echo base_url('penempatan/get_penempatan');?>",
				'type': 'POST',
				'dataType': 'json',

			},

			'columnDefs': [{
				'targets': [0,3,4],
				'orderable': false,
			}, {
				'targets': [0,3,4],
				'className': 'text-center',
			}],

		});
	
	function hapuslisfoto(i){
			$("#data-"+i).remove();
			$("#image-"+i).remove();
		}
	

    function edit(i){
        $.ajax({
            url:"<?= base_url('penempatan/show_penempatan'); ?>",
            type:"POST",
            dataType:"JSON",
            data:{id_penempatan:i},
            success:function(res){
                console.log(res);
               
                // get_pegawai_edit();
                
                $("#pegawai-edit").html();
                $("#pegawai-edit").html("<option value='"+res.id_pegawai+"'>"+res.nama_pegawai+"</option>");
                get_pegawai_edit();
                $("#pegawai-edit").val(res.id_pegawai);
               
                $("#id-penempatan").val(res.id_penempatan);
                $("#pegawai-edit").val(res.id_pegawai);
                $("#umkm-edit").val(res.id_umkm);
                 $("#modal-edit").modal('show');
                
            
            }
        });
    };

    function get_pegawai_tambah(){
        $.ajax({
            url:"<?= base_url('penempatan/get_pegawainon_tempat') ?>",
            type:"POSt",
            success:function(res){
                $("#pegawai-tambah").html(res);
            }
        });
    }

    function get_pegawai_edit(){
        $.ajax({
            url:"<?= base_url('penempatan/get_pegawainon_tempat') ?>",
            type:"POST",
            success:function(res){
                $("#pegawai-edit").append(res);
            }
        });
    }
    
	

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

        get_pegawai_tambah();
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
					$("#lat-problematika-edit").val(r[0].lat);
					$("#long-problematika-edit").val(r[0].long);
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
				url:"<?= base_url('penempatan/tambah_penempatan');?>",
				type:"POST",
				dataType:"JSON",
				data:data,
				success:function(res){
					console.log(res);
					if(res.status_tambah =="ok"){
						Swal.fire({
							title: 'Sukses !',
							text: 'Data Penempatan Berhasil Ditambahkan',
							type: 'success',
						});
						$("#form-tambah").trigger("reset");
						$("#list-foto").html("");
						$("#list-data-foto").html("");
						$(".close").click();
                        table.ajax.reload(null, false);
                        get_pegawai_tambah();
					}
					else if(res.status_tambah == "gagal"){
						var error = "";

						$.each(res.error,function(index,value){
							error += value+"<br>";
							console.log(value);
						});
						Swal.fire({
							title: 'Maaf !',
							text: 'Data Penempatan Gagal Ditambahkan',
							type: 'error',
							html:error,
						});
					}
					else{
						Swal.fire({
							title: 'Maaf !',
							text: 'Data Penempatan Gagal Ditambahkan',
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
				url:"<?= base_url('penempatan/update_penempatan')?>",
				data:data,
				type:"POST",
				dataType:"JSON",
				success:function(res){
					if(res.status_update =="ok"){
						Swal.fire({
							title: 'Sukses !',
							text: 'Data Penempatan Berhasil Diubah',
							type: 'success',
						});
						$("#form-edit").trigger("reset");
						
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
							text: 'Data Penempatan Gagal Diubah',
							type: 'error',
							html:error,
						});
					}
					else{
						Swal.fire({
							title: 'Maaf !',
							text: 'Data Penempatan Gagal Diubah',
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
            url:"<?= base_url('penempatan/penempatan_aktif'); ?>",
            type:"POST",
            dataType:"JSON",
            data:{id_penempatan:i},
            success:function(res){
                if(res.status == "ok"){
                    Swal.fire({
                        title: 'Sukses !',
                        text: 'Data Penempatan berhasil di aktivasi',
                        type: 'success',
                    });
                    table.ajax.reload(null, false);
                }
                else{
                    Swal.fire({
                        title: 'Maaf !',
                        text: 'Data Penempatan gagal di aktivasi',
                        type: 'error',
                    });
                }
                
            }
        });
    }

    function nonaktif(i){
        $.ajax({
            url:"<?= base_url('penempatan/penempatan_non_aktif'); ?>",
            type:"POST",
            dataType:"JSON",
            data:{id_penempatan:i},
            success:function(res){
                if(res.status == "ok"){
                    Swal.fire({
                        title: 'Sukses !',
                        text: 'Data Penempatan berhasil di non aktifkan',
                        type: 'success',
                    });
                    table.ajax.reload(null, false);
                }
                else{
                    Swal.fire({
                        title: 'Maaf !',
                        text: 'Data Penempatan gagal di non aktifkan',
                        type: 'error',
                    });
                }
                
            }
        });
    }
</script>

