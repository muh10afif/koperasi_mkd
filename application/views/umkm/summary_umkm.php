<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0 text-dark">Summary</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="<?= base_url('home');?>">Home</a></li>
                        <li class="breadcrumb-item active">Summary</li>
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
                <div class="col-md-12">
                <div class="card shadow">
                    <!-- /.card-header -->
                    <div class="card-body">
                        <div class="d-flex justify-content-center">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Periode</label>
                                    <input id="periode" type="text" class="form-control tgl-bulan" readonly="true" placeholder="Pilih Periode">
                                </div>
                            </div>
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
                        <h5><i class="icon fas fa-info mr-3"></i>Laba Keseluruhan : <b>Rp. <span id="tot-laba"><?= $tot_saldo ?></b></span> </h5>
                    </div>
                </div>
            </div>

            <!-- Main row -->
            <div class="row">
                <section class="col-md-12">
                    <div class="card shadow">
                        <div class="card-body table-responsive">
                            <div class="col-md-12">
                                <table id="tbl-data" class="table table-bordered table-striped table-hover" width="100%">
                                    <thead class="bg-primary">
                                        <tr>
                                            <th class="text-center">No</th>
                                            <th class="text-center">Tanggal</th>
                                            <th class="text-center">Keterangan</th>
                                            <th class="text-center">Jumlah</th>
                                            <th class="text-center">Debit</th>
                                            <th class="text-center">Kredit</th>
                                            <th class="text-center">Saldo</th>
                                        </tr>
                                    </thead>
                                    <tbody>

                                    </tbody>
                                </table>
                            </div>
                        </div><!-- /.card-body -->
                    </div>
                    <!-- /.card -->
                    
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
        "processing"    : true,
        'ajax': {
            'url': "<?php echo base_url("summary/get_summary_umkm/$id_umkm");?>",
            'type': 'POST',
            'data': function (data) {
                data.bulan = $('#periode').val();
            }
        },
        stateSave       : true,
        "order"         : [],
        'columnDefs': [{
            'targets': [0,6],
            'orderable': false,
        }, {
            'targets': [0,1,3],
            'className': 'text-center',
        }, {
            'targets': [4,5,6],
            'className': 'text-right',
        }],
    });

    $(document).ready(function () {

        $('#filter').click(function () {
            
            var bulan = $('#periode').val();

            $.ajax({
                url         : "<?= base_url('summary/ambil_total_saldo') ?>",
                type        : "POST",
                data        : {bulan:bulan},
                dataType    : "JSON",
                success     : function (data) {
                    table.ajax.reload(null, false); 

                    $('#tot-laba').html(data.tot_saldo);
                
                }
            })

            return false;

        })

        $('#reset').click(function () {
            $('#periode').datepicker('setDate', null);
            $('#tot-laba').html('<?= $tot_saldo ?>');

            table.ajax.reload(null, false);
        })


    });
</script>
