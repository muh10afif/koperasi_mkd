<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0 text-dark">Transaksi Saldo <span id="tgl_pen"></span></h1>
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

        <div class="data_saldo">

            <div class="row">
                <div class="col-md-12">
                    <div class="card shadow">
                        <div class="card-body">
                            <div class="d-flex justify-content-center">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>Periode Awal</label>
                                        <input id="periode-awal" type="text" class="form-control tgl" readonly="true" placeholder="Pilih Tanggal Awal">
                                    </div>
                                
                                </div>
                                <!-- /.col -->
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>Periode Akhir</label>
                                        <input id="periode-akhir" type="text" class="form-control tgl" readonly="true" placeholder="Pilih Tanggal Akhir">
                                    </div>
                                </div>
                                <!-- /.col -->
                            </div>
                            <!-- /.row -->

                        </div>
                        <div class="card-footer">
                            <div class="d-flex justify-content-end">
                                <button class="btn btn-primary btn-sm mr-2" id="filter">Tampilkan</button>
                                <button class="btn btn-dark btn-sm" id="reset">Reset</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-12">
                    <div class="callout callout-info shadow">
                        <h5><i class="icon fas fa-info mr-3"></i>Saldo Keseluruhan : <b>Rp. <span id="total-saldo"><?= $tot_saldo_1 ?></b></span> </h5>
                    </div>
                </div>
            </div>
            
            <!-- Main row -->
            <div class="row">
                <div class="col-md-12">
                    <div class="card shadow">
                        <!-- <div class="card-header">
                            <div class="d-flex justify-content-end">
                                <button class="btn btn-info btn-sm" id="buat_pencatatan">Buat Transaksi Pencatatan</button>
                            </div>
                        </div> -->
                        <div class="card-body table-responsive">
                            <div class="col-md-12">
                                <table id="tbl-data" class="table table-bordered table-striped table-hover" width="100%">
                                    <thead class="bg-primary">
                                        <tr>
                                            <th class="text-center">NO</th>
                                            <th class="text-center">Tanggal</th>
                                            <th class="text-center">Pencatatan</th>
                                            <th class="text-center">Total Debit</th>
                                            <th class="text-center">Total Kredit</th>
                                            <th class="text-center">Total Saldo</th>
                                            <th class="text-center">Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>

                                    </tbody>
                                </table>
                            </div>
                        </div><!-- /.card-body -->
                    </div>
                    <!-- /.card -->
                    
                </div>

            </div>
            <!-- /.row (main row) -->

            <!-- modal buat transaksi pencatatan -->

            <div id="buat_transaksi_pen" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
                <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
                    <div class="modal-content">
                        <div class="modal-header  bg-primary">
                            <h5 class="modal-title text-white judul_modal" id="my-modal-title">Tambah Transaksi Pencatatan</h5>
                            <button class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <input type="hidden" id="aksi_pen" value="Tambah">
                            <input type="hidden" id="id_pencatatan">
                            <div class="form-group row">
                                <label for="inputEmail3" class="col-sm-3 col-form-label">Tanggal</label>
                                <div class="col-sm-8">
                                    <input id="tanggal_pen" name="tanggal_pen" type="text" class="form-control tgl" readonly="true" placeholder="Pilih Tanggal">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="inputEmail3" class="col-sm-3 col-form-label">Judul Pencatatan</label>
                                <div class="col-sm-8">
                                    <textarea id="judul_pen" name="judul_pen" class="form-control" cols="3" rows="3"></textarea>
                                </div>
                            </div>
                            
                        </div>
                        <div class="modal-footer d-flex justify-content-end">
                            <button type="button" class="btn btn-dark" data-dismiss="modal">Close</button>
                            <button type="button" class="btn btn-primary" id="simpan_pen">Save</button>
                        </div>
                    </div>
                </div>
            </div>
        
        </div>

            <div class="data_det_saldo" hidden>

                <div class="tambah_detail">

                </div>

                <div class="d-flex justify-content-start kembali">
                    <button class="btn btn-info btn-sm" id="kembali">Kembali</button>
                </div>

            </div>

        </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
</div>
<!-- /.content-wrapper -->
<script>

    var table = $("#tbl-data").DataTable({

        'processing': true,
        'serverSide': true,
        'order': [
            [1, 'asc']
        ],
        'ajax': {
            'url': "<?php echo base_url('saldo/get_saldo_baru');?>",
            'type': 'POST',
            "data"  : function (data) {
                data.id_umkm    = '<?= $id_umkm ?>';
                data.tgl_awal   = $('#periode-awal').val();
                data.tgl_akhir  = $('#periode-akhir').val();
            }
        },

        'columnDefs': [{
            'targets': [0, 2],
            'orderable': false,
        }, {
            'targets': [0, 1, 6],
            'className': 'text-center',
        }, {
            'targets': [3,4,5],
            'className': 'text-right',
        }],

    });

    $(document).ready(function () {

        $('#filter').click(function () {

            var id_umkm    = '<?= $id_umkm ?>';
            var tgl_awal   = $('#periode-awal').val();
            var tgl_akhir  = $('#periode-akhir').val();

            $.ajax({
                url         : "<?= base_url('saldo/ambil_total_saldo') ?>",
                type        : "POST",
                data        : {id_umkm:id_umkm, tgl_awal:tgl_awal, tgl_akhir:tgl_akhir},
                dataType    : "JSON",
                success     : function (data) {
                    table.ajax.reload(null, false); 

                    $('#total-saldo').html(data.tot_saldo);
                
                }
            })

            return false;
 
        });

        $('#reset').click(function () {

            $('#periode-awal').datepicker('setDate', null);
            $('#periode-akhir').datepicker('setDate', null);
            $('#total-saldo').html('<?= $tot_saldo_1 ?>')

            table.ajax.reload(null, false);
        })

        // aksi tambah detail
        $('#tbl-data').on('click', '.tambah', function () {
            
            var id_pen      = $(this).data('id');

            $.ajax({
                url         : "<?= base_url('saldo/form_tambah_detail') ?>",
                type        : "POST",
                beforeSend  : function () {
                    swal({
                        title   : 'Menunggu',
                        html    : 'Memproses data',
                        onOpen  : () => {
                            swal.showLoading();
                        }
                    })
                },
                data        : {id_pen:id_pen},
                success     : function (data) {
                    swal.close();

                    $('.data_saldo').hide();
                    $('.data_det_saldo').removeAttr('hidden');
                    $('.tambah_detail').html(data);

                }
            })

            return false;

        })

        // kembali
        $('#kembali').on('click', function () {

            var id_umkm    = '<?= $id_umkm ?>';
            var tgl_awal   = $('#periode-awal').val();
            var tgl_akhir  = $('#periode-akhir').val();
            
            $.ajax({
                url         : "<?= base_url('saldo/ambil_total_saldo') ?>",
                type        : "POST",
                beforeSend  : function () {
                    swal({
                        title   : 'Menunggu',
                        html    : 'Memproses data',
                        onOpen  : () => {
                            swal.showLoading();
                        }
                    })
                },
                data        : {id_umkm:id_umkm, tgl_awal:tgl_awal, tgl_akhir:tgl_akhir},
                dataType    : "JSON",
                success     : function (data) {
                    swal.close();

                    table.ajax.reload(null, false); 

                    $('#total-saldo').html(data.tot_saldo);

                    $('.data_saldo').show();
                    $('.data_det_saldo').attr('hidden', true);

                    
                }
            })

            return false;

        })

        $('#buat_pencatatan').on('click', function () {

            $('#tanggal_pen').datepicker('setDate', null);
            $('#judul_pen').val('');
            $('.judul_modal').html('Tambah Transaksi Pencatatan');
            $('#aksi_pen').val('Tambah');

            $('#buat_transaksi_pen').modal('show');

        })

        // proses simpan
        $('#simpan_pen').click(function () {
            var tanggal     = $('#tanggal_pen').val();
            var judul       = $('#judul_pen').val();
            var id_umkm     = '<?= $id_umkm ?>';
            var aksi_pen    = $('#aksi_pen').val();
            var id_pen      = $('#id_pencatatan').val();

            $.ajax({
                url         : "<?= base_url('saldo/tambah_pencatatan') ?>",
                type        : "POST",
                beforeSend  : function () {
                    swal({
                        title   : 'Menunggu',
                        html    : 'Memproses data',
                        onOpen  : () => {
                            swal.showLoading();
                        }
                    })
                },
                data        : {judul:judul, tanggal:tanggal, id_umkm:id_umkm, aksi_pen:aksi_pen, id_pen:id_pen},
                dataType    : "JSON",
                success     : function (data) {
                    table.ajax.reload(null, false); 

                    $('#buat_transaksi_pen').modal('hide');

                    swal(
                        aksi_pen+' Transaksi Pencatatan',
                        'Data Berhasil Disimpan',
                        'success'
                    )
                }
            })

            return false;
        })

        // proses ubah data 
        $('#tbl-data').on('click', '.edit', function () {

            var id_pencatatan = $(this).data('id');

            $.ajax({
                url         : "<?php echo base_url('saldo/ambil_data_pencatatan')?>/"+id_pencatatan,
                type        : "GET",
                beforeSend  : function () {
                swal({
                    title   : 'Menunggu',
                    html    : 'Memproses Data',
                    onOpen  : () => {
                        swal.showLoading();
                    }
                })
                },
                dataType    : "JSON",
                success     : function(data)
                    {
                        swal.close();

                        $('[name="tanggal_pen"]').val(data.tgl);
                        $('[name="judul_pen"]').val(data.judul);
                        $('#id_pencatatan').val(data.id_pen);

                        $('#buat_transaksi_pen').modal('show');
                        $('.judul_modal').html('Edit Transaksi Pencatatan');
                        $('#aksi_pen').val('Edit');
            
                    },
                error: function (jqXHR, textStatus, errorThrown)
                    {
                        alert('Error get data from ajax');
                    }
            });
            
        })

        // hapus data
        $('#tbl-data').on('click', '.hapus', function () {

            var id_pencatatan = $(this).data('id');
            var aksi_pen      = 'hapus';

            swal({
                title       : 'Konfirmasi',
                text        : 'Yakin akan hapus data',
                type        : 'warning',

                showCancelButton    : true,
                confirmButtonText   : 'Hapus Data',
                confirmButtonColor  : '#d33',
                cancelButtonColor   : '#3085d6',
                cancelButtonText    : 'Batal',
                reverseButtons      : true
            }).then((result) => {
                if (result.value) {
                    $.ajax({
                        url         : "<?= base_url('saldo/tambah_pencatatan') ?>",
                        method      : "POST",
                        beforeSend  : function () {
                            swal({
                                title   : 'Menunggu',
                                html    : 'Memproses Data',
                                onOpen  : () => {
                                    swal.showLoading();
                                }
                            })
                        },
                        data        : {id_pen:id_pencatatan, aksi_pen:aksi_pen},
                        dataType    : "JSON",
                        success     : function (data) {

                            table.ajax.reload(null, false);

                            swal(
                                'Hapus Transaksi Pencatatan',
                                'Data Berhasil Dihapus',
                                'success'
                            )
                            
                        },
                        error       : function(xhr, status, error) {
                            var err = eval("(" + xhr.responseText + ")");
                            alert(err.Message);
                        }

                    })

                    return false;
                } else if (result.dismiss === swal.DismissReason.cancel) {
                    swal(
                        'Batal',
                        'Anda membatalkan hapus transaksi pencatatan',
                        'error'
                    )
                }
            })
        })

        
    });
</script>