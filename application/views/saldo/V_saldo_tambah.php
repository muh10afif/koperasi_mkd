<div class="row">
    <div class="col-md-6">
        <div class="card shadow">
            <div class="card-header bg-primary">
                <h5 class="card-title">Transaksi Debit</h5>
            </div>
            <div class="card-body">
                <div class="form-group d-flex justify-content-center">
                    <label for="inputEmail3" class="col-sm-3 col-form-label">Keterangan</label>
                    <div class="col-sm-8">
                        <textarea id="penjualan" name="penjualan" class="form-control" cols="3" rows="3" placeholder="Masukkan Keterangan Penjualan"></textarea>
                    </div>
                </div>
                <div class="form-group d-flex justify-content-center">
                    <label for="inputEmail3" class="col-sm-3 col-form-label">Jumlah</label>
                    <div class="col-sm-8">
                        <input type="text" class="form-control angka" name="jumlah_pem" id="jumlah_pem" placeholder="Masukkan Jumlah">
                    </div>
                </div>
                <div class="form-group d-flex justify-content-center">
                    <label for="inputEmail3" class="col-md-3 col-form-label">Nominal</label>
                    <div class="col-md-8">
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text">Rp. </span>
                            </div> 
                            <input type="text" class="form-control separator" name="nominal_pem" id="nominal_pem" placeholder="Masukkan Nominal">
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-footer d-flex justify-content-end">
                <button type="button" class="btn btn-info btn-sm simpan-debit">Simpan Debit</button>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="card shadow">
            <div class="card-header bg-primary">
                <h5 class="card-title">Transaksi Kredit</h5>
            </div>
            <div class="card-body">
                <div class="form-group d-flex justify-content-center">
                    <label for="inputEmail3" class="col-sm-3 col-form-label">Keterangan</label>
                    <div class="col-sm-8">
                        <textarea id="pembelian" name="pembelian" class="form-control" cols="3" rows="3" placeholder="Masukkan Keterangan Pembelian"></textarea>
                    </div>
                </div>
                <div class="form-group d-flex justify-content-center">
                    <label for="inputEmail3" class="col-sm-3 col-form-label">Jumlah</label>
                    <div class="col-sm-8">
                        <input type="text" class="form-control angka" name="jumlah_peng" id="jumlah_peng" placeholder="Masukkan Jumlah">
                    </div>
                </div>
                <div class="form-group d-flex justify-content-center">
                    <label for="inputEmail3" class="col-md-3 col-form-label">Nominal</label>
                    <div class="col-md-8">
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text">Rp. </span>
                            </div> 
                            <input type="text" class="form-control separator" name="nominal_peng" id="nominal_peng" placeholder="Masukkan Nominal">
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-footer d-flex justify-content-end">
                <button type="button" class="btn btn-info btn-sm simpan-kredit">Simpan Kredit</button>
            </div>
        </div>
    </div>
</div>

    <div class="row">
        <div class="col-md-12">
            <div class="callout callout-info shadow">
                <h5><i class="icon fas fa-info mr-3"></i>Saldo Keseluruhan : <b>Rp. <span id="saldo"><?= number_format($tot_saldo, '2', ',', '.') ?></b></span> </h5>
            </div>
        </div>
    </div>

    <!-- Main row -->
    <div class="row">
        <div class="col-md-12">
            <div class="card shadow">
                <div class="card-body table-responsive">
                    <div class="col-md-12">
                        <table id="tbl-data-2" class="table table-bordered table-striped table-hover" width="100%">
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
                </div><!-- /.card-body -->
            </div>
            <!-- /.card -->
            
        </div>

    </div>

<script>


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

    var tabel_detail = $('#tbl-data-2').DataTable({
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

    $('.simpan-debit').on('click', function () {

        var keterangan  = $('#penjualan').val();
        var jumlah      = $('#jumlah_pem').val();
        var nominal     = $('#nominal_pem').val();
        var id_umkm     = '<?= $id_umkm ?>';
        var id_pen      = '<?= $id_pen ?>';
        var tgl_tr      = '<?= $tanggal_tr ?>';
        var aksi        = 'pemasukan';

        console.log(tgl_tr);

        if (keterangan == '') {
            swal(
                'Peringatan',
                'Keterangan Penjualan Harus Terisi!',
                'warning'
            )

            return false;
        } else if (jumlah == '') {
            swal(
                'Peringatan',
                'Jumlah Harus Terisi!',
                'warning'
            )

            return false;
        } else if (nominal == '') {
            swal(
                'Peringatan',
                'Nominal Harus Terisi!',
                'warning'
            )

            return false;
        } else {

            $.ajax({
                url         : "<?= base_url('saldo/tambah_nominal') ?>",
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
                data        : {keterangan:keterangan, jumlah:jumlah, nominal:nominal, id_umkm:id_umkm, aksi:aksi, id_pen:id_pen, tgl_tr:tgl_tr},
                dataType    : "JSON",
                success     : function (data) {
                    
                    $('#penjualan').val('');
                    $('#jumlah_pem').val('');
                    $('#nominal_pem').val('');
                    $('#saldo').html(data.saldo);

                    tabel_detail.ajax.reload(null, false); 

                    swal(
                        'Tambah Data Debit',
                        'Data Berhasil Disimpan',
                        'success'
                    )
                }
            })

            return false;

        }
        
    })

    $('.simpan-kredit').on('click', function () {

        var keterangan  = $('#pembelian').val();
        var jumlah      = $('#jumlah_peng').val();
        var nominal     = $('#nominal_peng').val();
        var id_umkm     = '<?= $id_umkm ?>';
        var id_pen      = '<?= $id_pen ?>';
        var tgl_tr      = '<?= $tanggal_tr ?>';
        var aksi        = 'pengeluaran';

        if (keterangan == '') {
            swal(
                'Peringatan',
                'Keterangan Pembelian Harus Terisi!',
                'warning'
            )

            return false;
        } else if (jumlah == '') {
            swal(
                'Peringatan',
                'Jumlah Harus Terisi!',
                'warning'
            )

            return false;
        } else if (nominal == '') {
            swal(
                'Peringatan',
                'Nominal Harus Terisi!',
                'warning'
            )

            return false;
        } else {

            $.ajax({
                url         : "<?= base_url('saldo/tambah_nominal') ?>",
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
                data        : {keterangan:keterangan, jumlah:jumlah, nominal:nominal, id_umkm:id_umkm, aksi:aksi, id_pen:id_pen, tgl_tr:tgl_tr},
                dataType    : "JSON",
                success     : function (data) {

                    $('#pembelian').val('');
                    $('#jumlah_peng').val('');
                    $('#nominal_peng').val('');
                    $('#saldo').html(data.saldo);

                    tabel_detail.ajax.reload(null, false); 

                    swal(
                        'Tambah Data Kredit',
                        'Data Berhasil Disimpan',
                        'success'
                    )
                }
            })

            return false;

        }
        
    })

</script>