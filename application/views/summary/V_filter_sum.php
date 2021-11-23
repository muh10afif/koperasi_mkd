<div class="row total_row">
    <div class="col-md-12">
        <div class="callout callout-success shadow">
            <h5><i class="icon fas fa-info mr-3"></i>Laba Keseluruhan : <b>Rp. <span id="tot-laba"><?= $tot_laba_fil ?></b></span> </h5>
        </div>
    </div>
</div>

<div class="row data-tabel">
    <section class="col-md-12">
        <div class="card shadow">
            <div class="card-body">
                <div class="col-md-12">
                    <table id="tbl-data5" class="table table-bordered table-striped table-hover" width="100%">
                        <thead class="bg-success">
                            <tr>
                                <th class="text-center">NO</th>
                                <th class="text-center">UMKM</th>
                                <th class="text-center">Bulan Transaksi</th>
                                <th class="text-center">Pemasukan</th>
                                <th class="text-center">Pengeluaran</th>
                                <th class="text-center">Laba</th>
                                <th class="text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if ($tot_laba_fil != '0,00'): ?>
                                <?php $no=1; foreach ($list_fil as $a): ?>

                                <tr>
                                    <td class="text-center"><?= $no++ ?></td>
                                    <td><?= $a['nama_umkm'] ?></td>
                                    <td class="text-center"><?= nice_date($a['bulan'], 'F-Y') ?></td>
                                    <td class="text-right">Rp. <?= number_format($a['pemasukan'], '2', ',', '.') ?></td>
                                    <td class="text-right">Rp. <?= number_format($a['pengeluaran'],'2',',','.') ?></td>
                                    <td class="text-right">Rp. <?= number_format($a['laba'],'2',',','.') ?></td>
                                    <td class="text-center"><button type='button' class='btn btn-outline-info btn-sm detail' data-id='<?= $a['id_umkm'] ?>' bulan='<?= $a['bulan'] ?>'>Detail</button></td>
                                </tr>

                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="7" align='center'>Data Kosong</td>
                                </tr>
                            <?php endif; ?>
                            
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </section>

</div>

<script>
    var table = $('#tbl-data5').DataTable();
</script>