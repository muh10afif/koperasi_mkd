<style>

    #tbl-data thead tr th {
        text-align: center;
    }

</style>
<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0 text-dark">Report</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="<?= base_url('home');?>">Home</a></li>
                        <li class="breadcrumb-item active">Report</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <section class="content">
        <div class="container-fluid">

            <div class="row">
                <div class="col-md-12">
                    <div class="card shadow">
                        <div class="card-body">
                            <div class="col-md-12">
                                <table id="tbl-data" class="table table-bordered table-striped table-hover" width="100%">
                                    <thead class="bg-primary">
                                        <tr>
                                            <th>No</th>
                                            <th>Modal Awal</th>
                                            <th>UMKM</th>
                                            <th>Periode</th>
                                            <th>Pemasukan</th>
                                            <th>Pengeluaran</th>
                                            <th>Laba</th>
                                            <th>Pola Bagi Hasil</th>
                                            <th>Hasil UMKM</th>
                                            <th>Hasil MKD</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    <?php $no=1; foreach ($list as $a): ?>

                                    <tr>
                                        <td class="text-center"><?= $no++ ?></td>
                                        <td class="text-center"><?= $a['modal_awal'] ?></td>
                                        <td><?= $a['nama_umkm'] ?></td>
                                        <td class="text-center"><?= nice_date($a['bulan'], 'F-Y') ?></td>
                                        <td class="text-right">Rp. <?= number_format($a['pemasukan'], '2', ',', '.') ?></td>
                                        <td class="text-right">Rp. <?= number_format($a['pengeluaran'],'2',',','.') ?></td>
                                        <td class="text-right">Rp. <?= number_format($a['laba'],'2',',','.') ?></td>
                                        <td class="text-center"></td>
                                        <td class="text-center"></td>
                                        <td class="text-center"></td>
                                    </tr>

                                    <?php endforeach; ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </section>

</div>

<script>

    var table = $('#tbl-data').DataTable({
        'columnDefs': [{
            'targets': [],
            'orderable': false
        }]
    });

</script>