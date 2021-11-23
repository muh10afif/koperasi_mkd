<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0 text-dark">Transaksi Saldo</h1>
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
                    <!-- /.card-header -->
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>UMKM</label>
                                    <select name="umkm" id="umkm" class="form-control select2" style="width: 100%;">
                                        <option value="a">-- Pilih UMKM --</option>
                                        <?php foreach ($umkm as $m): ?>
                                            <option value="<?= $m['id_umkm'] ?>"><?= $m['nama_umkm'] ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                            
                            </div>
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
                        <h5><i class="icon fas fa-info mr-3"></i>Saldo Keseluruhan : <b>Rp. <span id="total-saldo"><?= $total_saldo ?></b></span> </h5>
                    </div>
                </div>
            </div>

            <!-- Main row -->
            <div class="row">
                <div class="col-md-12">
                    <section class="card shadow">
                        <div class="card-body table-responsive">
                            <table id="tbl-data" class="table table-bordered table-striped table-hover" width="100%">
                                <thead class="bg-primary">
                                    <tr>
                                        <th class="text-center">NO</th>
                                        <th class="text-center">UMKM</th>
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
                    </section>
                </div>
            </div>
            <!-- /.row (main row) -->

            </div>

            <div class="data_saldo_detail" hidden>

            </div>

            <div class="d-flex justify-content-start kembali">
                <button class="btn btn-primary btn-sm" id="kembali" hidden>Kembali</button>
            </div>

        </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
</div>
<!-- /.content-wrapper -->


<script>

    var table = $("#tbl-data").DataTable({

        'processing' : true,
        'serverSide' : true,
        'order'      : [],
        'ajax': {
            'url': "<?php echo base_url('saldo/get_saldo_baru');?>",
            'type': 'POST',
            "data"  : function (data) {
                data.id_umkm    = $('#umkm').val();
                data.tgl_awal   = $('#periode-awal').val();
                data.tgl_akhir  = $('#periode-akhir').val();
            }
        },


        'columnDefs': [{
            'targets': [0,4,5,6,7],
            'orderable': false,
        }, {
            'targets': [0, 2, 7],
            'className': 'text-center',
        },{
            'targets': [4, 5, 6],
            'className': 'text-right',
        }],

    });

    $(document).ready(function () {
        
        $('#filter').click(function () {

            var id_umkm    = $('#umkm').val();
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

            $('#umkm').select2('val', "a");
            $('#periode-awal').datepicker('setDate', null);
            $('#periode-akhir').datepicker('setDate', null);
            $('#total-saldo').html('<?= $total_saldo ?>');

            table.ajax.reload(null, false);
        })

        $('#tbl-data').on('click', '.detail', function () {
            
            var id_umkm        = $(this).data('id');
            var id_pencatatan  = $(this).attr('id_pen');

            $.ajax({
                url         : "<?= base_url('saldo/saldo_detail') ?>",
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
                data        : {id_umkm:id_umkm, id_pencatatan:id_pencatatan},
                success     : function (data) {
                    swal.close();

                    $('.data_saldo').hide();
                    $('.data_saldo_detail').removeAttr('hidden');
                    $('#kembali').removeAttr('hidden');
                    $('.data_saldo_detail').html(data);
                }
            })

            return false;

        })

        $('#kembali').on('click', function () {

            var id_umkm    = $('#umkm').val();
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
                    $('.data_saldo_detail').attr('hidden', true);
                    $('#kembali').attr('hidden', true);
                }
            })

            return false;


        })

    })

</script>