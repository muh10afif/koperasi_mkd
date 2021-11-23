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

            <div class="row filter">
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

            <div class="row total_row">
                <div class="col-md-12">
                    <div class="callout callout-info shadow">
                        <h5><i class="icon fas fa-info mr-3"></i>Laba Keseluruhan : <b>Rp. <span id="tot-laba"><?= $tot_laba ?></b></span> </h5>
                    </div>
                </div>
            </div>

            <div class="row data-tabel">
                <section class="col-md-12">
                    <div class="card shadow">
                        <div class="card-body">
                            <div class="col-md-12">
                                <table id="tbl-data" class="table table-bordered table-striped table-hover" width="100%">
                                    <thead class="bg-primary">
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
                                    <?php if ($tot_laba != '0,00'): ?>
                                        <?php $no=1; foreach ($list as $a): ?>

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

            <div class="tabel-data-detail" hidden>

            </div>

            <div class="d-flex justify-content-start kembali">
                <button class="btn btn-info btn-sm" id="kembali" hidden>Kembali</button>
            </div>
            
            
        </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
</div>
<!-- /.content-wrapper -->
<script>
    var table = $('#tbl-data').DataTable({
        'columnDefs': [{
            'targets': [0,6],
            'orderable': false
        }]
    });

    // var table = $("#tbl-data4").DataTable({

    //     'processing': true,
    //     'ajax': {
    //         'url': "<?php echo base_url('summary/get_summary_baru_2');?>",
    //         'type': 'POST',
    //         'data': function (data) {
    //             data.bulan = $('#periode').val();
    //         }
    //     },
    //     stateSave       : true,
    //     'order': [
    //         [1, 'asc']
    //     ],
    //     'columnDefs': [{
    //         'targets': [0,6],
    //         'orderable': false,
    //     }, {
    //         'targets': [0,2, 6],
    //         'className': 'text-center'
    //     }, {
    //         'targets': [3,4,5],
    //         'className': 'text-right'
    //     }]

    // });

    $(document).ready(function () {

        $('#filter').click(function () {
            
            var bulan = $('#periode').val();

            console.log(bulan);

            $.ajax({
                url         : "<?= base_url('summary/form_filter_summary') ?>",
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
                data        : {bulan:bulan},
                success     : function (data) {
                    swal.close();

                    $('.data-tabel').hide();
                    $('.total_row').hide();
                    $('.tabel-data-detail').removeAttr('hidden');
                    $('.tabel-data-detail').html(data);
                
                }
            })

            return false;

        })

        $('#reset').click(function () {

            var bulan = '';

            $.ajax({
                url         : "<?= base_url('summary/form_filter_summary') ?>",
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
                data        : {bulan:bulan},
                success     : function (data) {
                    swal.close();

                    $('#periode').datepicker('setDate', null);

                    $('.data-tabel').show();
                    $('.total_row').show();
                    $('.tabel-data-detail').attr('hidden', true);
                
                }
            })

            return false;
        })

        $('#tbl-data').on('click', '.detail', function () {
            
            var id_umkm      = $(this).data('id');
            var bulan        = $(this).attr('bulan');

            $.ajax({
                url         : "<?= base_url('summary/form_detail_summary') ?>",
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
                data        : {id_umkm:id_umkm, bulan:bulan},
                success     : function (data) {
                    swal.close();

                    $('.data-tabel').hide();
                    $('.total_row').hide();
                    $('.filter').hide();
                    $('.tabel-data-detail').removeAttr('hidden');
                    $('.tabel-data-detail').html(data);
                    $('#kembali').removeAttr('hidden');
                }
            })

            return false;

        })

        $('#kembali').on('click', function () {
            

            $.ajax({
                beforeSend  : function () {
                    swal({
                        title   : 'Menunggu',
                        html    : 'Memproses data',
                        onOpen  : () => {
                            swal.showLoading();
                        }
                    })
                },
                success     : function (data) {
                    swal.close();

                    $('.data-tabel').show();
                    $('.total_row').show();
                    $('.filter').show();
                    $('.tabel-data-detail').attr('hidden', true);
                    $('#kembali').attr('hidden', true);
                }
            })

            return false;
        })

        
    });
</script>