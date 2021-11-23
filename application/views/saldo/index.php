<link rel="stylesheet" href="<?php echo base_url('assets/DataTables/datatables2/datatables.css');?>">
<script src="<?php echo base_url('assets/DataTables/datatables2/datatables.js');?>"></script>
<link rel="stylesheet" href="<?php echo base_url('assets/datepicker/datepicker3.css');?>">
<script src="<?php echo base_url('assets/datepicker/bootstrap-datpicker.js');?>"></script>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0 text-dark">Transaksi</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="<?= base_url('home');?>">Home</a></li>
                        <li class="breadcrumb-item">Transaksi</li>
                        <li class="breadcrumb-item active">Saldo</li>
                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">

            


            <div class="row">
                <div class="card col-md-12">
                
                    <!-- /.card-header -->
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Periode Awal</label>
                                    <input id="periode-awal" type="text" class="form-control tgl" readonly="true">
                                </div>
                            
                            </div>
                            <!-- /.col -->
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Periode Akhir</label>
                                    <input id="periode-akhir" type="text" class="form-control tgl" readonly="true">
                                </div>
                            </div>
                            <!-- /.col -->
                        </div>
                        <!-- /.row -->

                    </div>
                
                </div>
            </div>



            <!-- /notifikasi -->

            <!-- Main row -->
            <div class="row">
                <!-- Left col -->
                <section class="col-lg-12 connectedSortable">
                    <!-- Custom tabs (Charts with tabs)-->
                    <div class="card">

                        <div class="card-header d-flex p-0">


                            <!-- <h3 class="card-title p-3">
								<button class="btn btn-sm btn-success" data-toggle="modal"
									data-target="#modal-tambah"><i class="fa fa-plus"></i>&nbsp;&nbsp;Tambah</button>
								
							</h3> -->



                        </div><!-- /.card-header -->
                        <div class="card-body">
                            <div class="tab-content p-0">
                                <div class="col-md-12">
                                    <table id="tbl-data" class="table table-bordered table-striped">
                                        <thead class="bg-success">
                                            <tr>
                                                <th class="text-center" width="5%">NO</th>
                                                <th class="text-center" width="20%">UMKM</th>
                                                <th class="text-center" width="20%">Tanggal</th>
                                                <th class="text-center" width="20%">Debit</th>
                                                <th class="text-center" width="20%">Kredit</th>
                                                <th class="text-center" width="20%">Saldo</th>

                                                <!-- <th class="text-center" width="20%">Aksi</th> -->
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



                    <!-- modal edit -->
                    <div class="modal fade" id="modal-edit" tabindex="-1" role="dialog"
                        aria-labelledby="modaltambahlabel" aria-hidden="true">
                        <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
                            <div class="modal-content">
                                <form id="form-edit" action="<?= base_url('problematika/update_problematika'); ?>"
                                    method="POST" class="form-horizontal">
                                    <input type="hidden" id="id-umkm" name="id_umkm">
                                    <div class="modal-header">
                                        <h5 class="modal-title text-center" id="exampleModalLabel">Edit Data UMKM</h5>
                                        <button type="button" class="close pull-left" data-dismiss="modal"
                                            aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <div class="form-group row">
                                            <label for="inputEmail3" class="col-sm-2 control-label">Nama UMKM</label>
                                            <div class="col-sm-6">
                                                <input id="nama-umkm-edit" type="text" name="nama_umkm"
                                                    class="form-control">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="inputEmail3" class="col-sm-2 control-label">Alamat</label>
                                            <div class="col-sm-10">
                                                <textarea id="alamat-umkm-edit" name="alamat" id="" cols="30" rows="3"
                                                    class="form-control"></textarea>
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <label for="inputEmail3" class="col-sm-2 control-label">LAT</label>
                                            <div class="col-sm-6">
                                                <input id="lat-umkm-edit" type="number" step="0.0000000001" name="lat"
                                                    class="form-control">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="inputEmail3" class="col-sm-2 control-label">LONG</label>
                                            <div class="col-sm-6">
                                                <input id="long-umkm-edit" type="number" step="0.0000000001" name="long"
                                                    class="form-control">
                                            </div>
                                        </div>


                                        <div class="form-group row">
                                            <label for="inputEmail3" class="col-sm-2 control-label">Foto</label>
                                            <div class="col-sm-10">
                                                <button id="btn-img-edit" class="btn btn-success" type="button"><i
                                                        class="fa fa-image"></i></button> <i>&nbsp;Klik untuk mengupload
                                                    foto</i>
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <label for="inputEmail3" class="col-sm-2 control-label">Foto</label>
                                            <div class="col-sm-10">
                                                <div id="foto-detail-list-edit" class="col-sm-12">

                                                </div>

                                            </div>
                                        </div>

                                        <div id="list-data-foto-edit"></div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary"
                                            data-dismiss="modal">Close</button>
                                        <button type="submit" class="btn btn-primary"><i
                                                class="fa fa-pencil-alt"></i>&nbsp;&nbsp;Ubah</button>
                                        <button id="btn-reset-edit" type="button" class="btn btn-success"><i
                                                class='fa fa-undo'></i>&nbsp; Reset</button>
                                    </div>
                                </form>

                            </div>
                        </div>
                    </div>
                    
                </section>

            </div>
            <!-- /.row (main row) -->

            <div class="row">
                <div class="card col-md-12">

                    <div class="card-header d-flex p-0">

                    </div><!-- /.card-header -->
                    <div class="card-body">
                        <div class="tab-content p-0">
                            <div class="col-md-12">
                                <h3>Total Saldo : Rp. <span id="total-saldo">0</span> </h3>
                            </div>
                        </div>
                    </div><!-- /.card-body -->
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
</div>
<!-- /.content-wrapper -->
<script>
    var table = $("#tbl-data").DataTable({

        'processing': false,
        'serverSide': true,
        'dom':"t",
        'order': [
            [1, 'asc']
        ],
        'ajax': {
            'url': "<?php echo base_url('saldo/get_saldo');?>",
            'type': 'POST',
            'dataType': 'json',
            

        },

        'columnDefs': [{
            'targets': [0, 2],
            'orderable': false,
        }, {
            'targets': [0, 2],
            'className': 'text-center',
        }, {
            'targets': [3,4,5],
            'className': 'text-right',
        }],

    });

    

    function detail(i) {
        $("#foto-detail-list").html('');
        $.ajax({
            url: "<?= base_url('problematika/show_problematika');?>",
            type: "POST",
            data: "id_problematika=" + i,
            dataType: 'JSON',
            success: function (r) {
                console.log(r);
                $("#nama-problematika").html(r[0].nama_problematika);
                $("#alamat-problematika").html(r[0].alamat);
                $("#deskripsi-problematika").html(r[0].deskripsi);
                $("#lat-problematika").html(r[0].lat);
                $("#long-problematika").html(r[0].long);
                // $("#foto-problematika-detail").attr('src',"<?= 'http://'.$_SERVER['HTTP_HOST'].'/MUI_api/documents/pemetaan_problematika/'; ?>"+r[0].foto);

                var foto = r[0].foto;
                var arr = foto.split(';');
                $.each(arr, function (index, value) {
                    if (value != "") {
                        var link =
                            "<?= 'http://'.$_SERVER['HTTP_HOST'].'/MUI_api/documents/pemetaan_problematika/'; ?>" +
                            value;
                        $("#foto-detail-list").append('<img class="foto-list" src="' + link + '">');
                        console.log(value);
                    }

                });
                $("#btn-detail").click();
            }
        });

    }

    function edit(i) {
        $.ajax({
            url: "<?= base_url('umkm/show_umkm'); ?>",
            type: "POST",
            dataType: "JSON",
            data: {
                id_umkm: i
            },
            success: function (res) {
                console.log(res);
                $("#modal-edit").modal('show');
                $("#id-umkm").val(res.id_umkm);
                $("#nama-umkm-edit").val(res.nama_umkm);
                $("#alamat-umkm-edit").val(res.alamat);
                $("#lat-umkm-edit").val(res.lat);
                $("#long-umkm-edit").val(res.lat);
                var link = "<?= base_url('assets/image/'); ?>" + res.foto;
                var iddata = $.now();
                $("#foto-detail-list-edit").html('<div id="image-' + iddata +
                    '" class="list-image"><img class="foto-list" src="' + link +
                    '"><button type="button" onclick="hapuslisfoto(\'' + iddata +
                    '\')" class="btn btn-danger btn-sm hps-foto">Hapus</button></div>');
                $("#list-data-foto-edit").html('<input id="data-' + iddata +
                    '" type="hidden" name="link_foto" value="' + res.foto + '">');
            }
        });
    };




    // hapus data kantor
    function hapus(i) {
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
                    url: "<?= base_url('problematika/hapus_problematika')?>",
                    type: "POST",
                    data: 'id_problematika=' + i,
                    dataType: "JSON",
                    success: function (r) {
                        if (r.status == 'ok') {

                            // $("#hapus-not-ok").hide();
                            // $("#hapus-ok").show();
                            Swal.fire({
                                title: 'Sukses !',
                                text: 'Data Problematika Berhasil Dihapus',
                                type: 'success',
                            });
                        } else {
                            // $("#hapus-ok").hide();
                            // $("#hapus-not-ok").show();
                            Swal.fire({
                                title: 'Maaf !',
                                text: 'Data Problematika Gagal Dihapus',
                                type: 'error',
                            });
                        }

                        setTimeout(function () {
                            // $("#hapus-not-ok").hide();
                            // $("#hapus-ok").hide();
                            Swal.close();
                        }, 3000);
                    }
                });
            }
        });
    }

    function gettotal_saldo(){
        $.ajax({
            url:"<?php echo base_url('saldo/get_saldo');?>",
            type:"POST",
            dataType:"JSON",
            success:function(res){
                $("#total-saldo").html(res.total_saldo);
            }
        });
    }

    $(document).ready(function () {

        gettotal_saldo();

        $(".tgl").datepicker({
            format: 'yyyy-mm-dd',
            autoclose: true,
        }).on('changeDate', function(e){
            var awal    = $("#periode-awal").val();
            var akhir   = $("#periode-akhir").val();

            $.ajax({
                url:"<?= base_url('saldo/set_periode_saldo'); ?>",
                type:"POST",
                data:{
                    awal:awal,
                    akhir:akhir,
                },
                success:function(res){
                    gettotal_saldo();
                    console.log(res);
                    table.ajax.reload(null, false);
                    
                }
            });

            
        });

        /* tombol reset */
        $(".close-tambah").click(function () {

            $("#form-tambah").trigger("reset");
            $("#form-upload").trigger("reset");
            $("#list-foto").html("");
            $("#list-data-foto").html("");
            // $("#modal-tambah").modal('close');
        });
        /* tombol reset form tambah */
        $("#btn-reset-tambah").click(function () {

            $("#form-tambah").trigger("reset");
            $("#form-upload").trigger("reset");
            $("#list-foto").html("");
            $("#list-data-foto").html("");
        });

        /* tombol reset form edit */
        $("#btn-reset-edit").click(function () {
            $("#form-upload-edit").trigger("reset");

        });

        /* /tombol reset */
        /* form tambah data */
        $("#form-tambah").submit(function (e) {
            e.preventDefault();
            var data = $(this).serialize();

            $.ajax({
                url: "<?= base_url('pemasukan/tambah_data_pemasukan_umkm');?>",
                type: "POST",
                dataType: "JSON",
                data: data,
                success: function (res) {
                    console.log(res);
                    if (res.status_tambah == "ok") {
                        Swal.fire({
                            title: 'Sukses !',
                            text: 'Data pemasukan Berhasil Ditambahkan',
                            type: 'success',
                        });
                        $("#form-tambah").trigger("reset");


                        table.ajax.reload(null, false);
                        getttotalpemasukanumkm();
                    } else if (res.status_tambah == "gagal") {
                        var error = "";

                        $.each(res.error, function (index, value) {
                            error += value + "<br>";
                            console.log(value);
                        });
                        Swal.fire({
                            title: 'Maaf !',
                            text: 'Data pemasukan Gagal Ditambahkan',
                            type: 'error',
                            html: error,
                        });
                    } else {
                        Swal.fire({
                            title: 'Maaf !',
                            text: 'Data pemasukan Gagal Ditambahkan',
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

        $("#form-edit").submit(function (e) {
            e.preventDefault();

            var data = $(this).serialize();

            $.ajax({
                url: "<?= base_url('umkm/update_umkm')?>",
                data: data,
                type: "POST",
                dataType: "JSON",
                success: function (res) {
                    if (res.status_update == "ok") {
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
                    } else if (res.status_update == "gagal") {
                        var error = "";

                        $.each(res.error, function (index, value) {
                            error += value + "<br>";
                            console.log(value);
                        });
                        Swal.fire({
                            title: 'Maaf !',
                            text: 'Data UMKM Gagal Diubah',
                            type: 'error',
                            html: error,
                        });
                    } else {
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
                        var link = "<?= base_url('assets/image/');?>" + res.file;
                        $("#foto-detail-list-edit").html('<div id="image-' + iddata +
                            '" class="list-image"><img class="foto-list" src="' + link +
                            '"><button type="button" onclick="hapuslisfoto(\'' +
                            iddata +
                            '\')" class="btn btn-danger btn-sm hps-foto">Hapus</button></div>'
                            );

                        // console.log(value);
                        $("#list-data-foto-edit").html('<input id="data-' + iddata +
                            '" type="hidden" name="link_foto" value="' + res.file + '">'
                            );

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

        
    });
</script>


<script>
    function aktif(i) {
        $.ajax({
            url: "<?= base_url('umkm/umkm_aktif'); ?>",
            type: "POST",
            dataType: "JSON",
            data: {
                id_umkm: i
            },
            success: function (res) {
                if (res.status == "ok") {
                    Swal.fire({
                        title: 'Sukses !',
                        text: 'Data UMKM berhasil di aktivasi',
                        type: 'success',
                    });
                    table.ajax.reload(null, false);
                } else {
                    Swal.fire({
                        title: 'Maaf !',
                        text: 'Data UMKM gagal di aktivasi',
                        type: 'error',
                    });
                }

            }
        });
    }

    function nonaktif(i) {
        $.ajax({
            url: "<?= base_url('umkm/umkm_non_aktif'); ?>",
            type: "POST",
            dataType: "JSON",
            data: {
                id_umkm: i
            },
            success: function (res) {
                if (res.status == "ok") {
                    Swal.fire({
                        title: 'Sukses !',
                        text: 'Data UMKM berhasil di non aktifkan',
                        type: 'success',
                    });
                    table.ajax.reload(null, false);
                } else {
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