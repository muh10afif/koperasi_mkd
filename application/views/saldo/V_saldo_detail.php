<div class="row">
    <div class="col-md-12">
        <div class="callout callout-primary shadow">
            <h5><i class="icon fas fa-info mr-3"></i>Saldo Keseluruhan : <b>Rp. <span id="saldo"><?= number_format($tot_saldo, '2', ',', '.') ?></b></span> </h5>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-12">
        <section class="card shadow">
            <div class="card-body table-responsive">
                <table id="tbl-saldo-detail" class="table table-bordered table-striped table-hover" width="100%">
                    <thead class="bg-primary">
                        <tr>
                            <th class="text-center">NO</th>
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
        </section>
    </div>
</div>


<script>

    var tabel_detail = $('#tbl-saldo-detail').DataTable({
            "processing"    : true,
            "ajax"          : "<?=base_url("saldo/tampil_saldo_detail/$id_umkm/$id_pen")?>",
            stateSave       : true,
            "order"         : [],
            'columnDefs': [{
            'targets': [],
            'orderable': false,
            }, {
                'targets': [0,2],
                'className': 'text-center',
            }, {
                'targets': [3,4,5],
                'className': 'text-right',
            }]
    });

</script>