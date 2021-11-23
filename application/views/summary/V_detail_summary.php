<div class="row">
    <div class="col-md-12">
    <div class="card shadow">
        <!-- /.card-header -->
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
                <button class="btn btn-primary btn-sm mr-2" id="filter_s">Tampilkan</button>
                <button class="btn btn-dark btn-sm" id="reset_s">Reset</button>
            </div>
        </div>
        </div>
    </div>
    </div>

<div class="row">
    <div class="col-md-12">
        <div class="callout callout-info shadow">
            <h5><i class="icon fas fa-info mr-3"></i>Laba Keseluruhan : <b>Rp. <span id="tot-saldo-s"><?= $tot_saldo_s ?></b></span> </h5>
        </div>
    </div>
</div>
<div class="row">
    <section class="col-md-12">
        <div class="card shadow">
            <div class="card-body">
                <div class="col-md-12">
                    <table id="tbl-detail-bulan" class="table table-bordered table-striped table-hover" width="100%">
                        <thead class="bg-primary">
                            <tr>
                                <th class="text-center">NO</th>
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
            </div>
        </div>
    </section>
</div>

<script>

    var tabel_detail_bulan = $('#tbl-detail-bulan').DataTable({
            "processing"    : true,
            'ajax': {
                'url': "<?=base_url("summary/get_summary_admin/$id_umkm/$bulan_s")?>",
                'type': 'POST',
                "data"  : function (data) {
                    data.tgl_awal   = $('#periode-awal').val();
                    data.tgl_akhir  = $('#periode-akhir').val();
                }
            },
            stateSave       : true,
            "order"         : [],
            'columnDefs': [{
            'targets': [],
            'orderable': false,
            }, {
                'targets': [0,1,3],
                'className': 'text-center',
            }, {
                'targets': [4,5,6],
                'className': 'text-right',
            }]
    });

    $(document).ready(function () {
        $('.tgl').datepicker({
            format: 'dd-MM-yyyy',
            autoclose: true,
        })

        $('#filter_s').click(function () {

            var tgl_awal   = $('#periode-awal').val();
            var tgl_akhir  = $('#periode-akhir').val();
            var id_umkm    = '<?= $id_umkm ?>';
            var bulan_s    = '<?= $bulan_s ?>'; 

            $.ajax({
                url         : "<?= base_url('summary/ambil_total_saldo_s') ?>",
                type        : "POST",
                data        : {tgl_awal:tgl_awal, tgl_akhir:tgl_akhir, id_umkm:id_umkm, bulan_s:bulan_s},
                dataType    : "JSON",
                success     : function (data) {
                    tabel_detail_bulan.ajax.reload(null, false); 

                    $('#tot-saldo-s').html(data.tot_saldo_s);
                
                }
            })

            return false;
        });

        $('#reset_s').click(function () {

            $('#periode-awal').datepicker('setDate', null);
            $('#periode-akhir').datepicker('setDate', null);
            $('#tot-saldo-s').html('<?= $tot_saldo_s ?>');

            tabel_detail_bulan.ajax.reload(null, false);
        })

    })


</script>