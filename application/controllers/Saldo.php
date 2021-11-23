<?php 
    class Saldo extends CI_Controller 
        {
            public function __construct()
                {
                    parent::__construct();
                    $this->load->model('M_modal');
                    $this->load->model('M_pemasukan');
                    $this->load->model('M_pengeluaran');
                    $this->load->model('M_saldo');
                }

            public function index()
            {
                $dt = [ 'id_umkm'   => 'a',
                        'tgl_awal'  => '',
                        'tgl_akhir' => ''
                    ];

                $cari = $this->M_saldo->get_total_saldo($dt)->result_array();

                $saldo = 0;
                $tot_d = 0;

                foreach ($cari as $c) {
                    
                    $saldo += $c['tot_debit'] - $c['tot_kredit'];

                    $tot_d += $c['tot_kredit'];

                }

                $data = array(
                    'content'       => 'saldo/V_saldo',
                    'judul'         => 'saldo',
                    'umkm'          => $this->M_saldo->get_data('umkm')->result_array(),
                    'total_saldo'   => number_format($saldo, '2',',','.')
                );

                $this->load->view('layout/template',$data);
            }

            public function saldo_umkm()
            {
                $id_umkm = $this->session->userdata('umkm');

                // input otomatis bulan
                $date = date("Y-m");
                // $date = date("2019-10");

                $awal   = date('1', strtotime($date));
                $akhir  = date('t', strtotime($date));

                if ($id_umkm != '') {
                    $cek = $this->M_saldo->cari_data_tgl_tr('pencatatan', $date, $id_umkm)->num_rows();

                    if ($cek == 0) {
                        for ($i=$awal; $i <= $akhir ; $i++) { 
                            
                            $tgl_tr = $date."-".$i;

                            $tgl_b = nice_date($tgl_tr, 'd-m-Y');

                            $judul_p = "Pencatatan Tanggal ".$tgl_b;

                            $data = ['tanggal_transaksi'   => $tgl_tr,
                                    'id_umkm'              => $id_umkm,
                                    'judul_pencatatan'     => $judul_p
                                    ];
                            
                            $this->M_saldo->input_data('pencatatan', $data);
                                
                        }
                    } 
                }

                $dt = [ 'id_umkm'   => $id_umkm,
                        'tgl_awal'  => '',
                        'tgl_akhir' => '',
                        'tanggal'   => $date
                    ];

                $cari = $this->M_saldo->get_total_saldo($dt)->result_array();

                $saldo = 0;
                $tot_d = 0;

                foreach ($cari as $c) {
                    
                    $saldo += $c['tot_debit'] - $c['tot_kredit'];

                    $tot_d += $c['tot_kredit'];

                }
                
                $data = array(
                    'content'       => 'umkm/saldo_umkm',
                    'judul'         => 'saldo',
                    'id_umkm'       => $id_umkm,
                    'tot_saldo_1'   => number_format($saldo, '2',',','.')
                );

                $this->load->view('layout/template',$data);
            }

            public function ambil_total_saldo()
            {
                $date = date("Y-m");
                
                $dt = [ 'id_umkm'   => $this->input->post('id_umkm'),
                        'tgl_awal'  => $this->input->post('tgl_awal'),
                        'tgl_akhir' => $this->input->post('tgl_akhir'),
                        'tanggal'   => $date
                    ];

                $cari = $this->M_saldo->get_total_saldo($dt)->result_array();

                $saldo = 0;

                foreach ($cari as $c) {
                    
                    $saldo += $c['tot_debit'] - $c['tot_kredit'];

                }  

                echo json_encode(['tot_saldo' => number_format($saldo, '2',',','.')]);
            }

            public function tes()
            {
                // $cek = $this->db->from('pemasukan')->order_by('add_time', 'asc')->get()->row_array(1);

                // print_r($cek);

                // Current timestamp is assumed, so these find first and last day of THIS month
                $first_day_this_month = date('m-1-Y'); // hard-coded '01' for first day
                $last_day_this_month  = date('m-t-Y');

                $date = date("Y-m");

                // With timestamp, this gets last day and first
                echo "last day ".$last_day = date('t', strtotime($date))."<br>"; 
                echo "first day ".$first_day = date('1', strtotime($date));
                
            }

            public function kurang_hari()
            {
                // echo date('Y-m-d', strtotime("2019-10-18 +3 days"));

                $tgl_skrg = date("Y-m-d", now('Asia/Jakarta'));

                echo date('Y-m-d', strtotime("2019-03-01 -1 days"));
            }
            
            // menampilkan saldo 
            public function get_saldo_baru()
            {
                $dt = [ 'id_umkm'   => $this->input->post('id_umkm'),
                        'tgl_awal'  => $this->input->post('tgl_awal'),
                        'tgl_akhir' => $this->input->post('tgl_akhir'),
                        'tanggal'   => date("Y-m")
                    ];
                
                $list = $this->M_saldo->get_datatables($dt);

                $total_pemasukan = 0;

                $data = array();
                $no = $_POST['start'];

                foreach($list as $field)
                    {
                        $no++;
                        $row        = array();

                        // cari saldo di log modal
                        $cari_1 = $this->M_saldo->cari_saldo($field->tanggal_transaksi, $field->id_umkm);

                        // tentukan saldo terakhir
                        if ($cari_1->num_rows() == 0) {
                            $saldo_terakhir = 0;
                        } else {
                            $c = $cari_1->row_array();
                            $saldo_terakhir = $c['nominal'];
                        }

                        if ($this->session->userdata('umkm') == '') {
                            $row[]  = $no;
                            $row[]  = $field->nama_umkm;
                            $row[]  = nice_date($field->tanggal_transaksi, 'd-M-Y');
                            $row[]  = $field->judul_pencatatan;
                            $row[]  = "Rp. ".number_format($field->tot_debit,2,",",".");
                            $row[]  = "Rp. ".number_format($field->tot_kredit,2,",",".");
                            $row[]  = "Rp. ".number_format($saldo_terakhir,2,",",".");

                            if (isset($field->id_pencatatan)) {
                                $row[]  = "<button type='button' class='btn btn-outline-info btn-sm detail' data-id='".$field->id_umkm."' id_pen='".$field->id_pencatatan."'>Detail</button>";
                            } else {
                                $row[]  = "";
                            }
                            
                        } else {
                            $row[]  = $no;
                            $row[]  = nice_date($field->tanggal_transaksi, 'd-M-Y');
                            $row[]  = $field->judul_pencatatan;
                            $row[]  = "Rp. ".number_format($field->tot_debit,2,",",".");
                            $row[]  = "Rp. ".number_format($field->tot_kredit,2,",",".");
                            $row[]  = "Rp. ".number_format($saldo_terakhir,2,",",".");;
                            $row[]  = "<button type='button' class='btn btn-outline-primary btn-sm tambah mr-3' data-id='".$field->id_pencatatan."'><i class='fa fa-plus'></i></button><button type='button' class='btn btn-outline-warning btn-sm edit mr-3' data-id='".$field->id_pencatatan."'><i class='fa fa-pencil'></i></button><button type='button' class='btn btn-outline-danger btn-sm hapus' data-id='".$field->id_pencatatan."'><i class='fa fa-trash'></i></button>";
                        }


                        $data[] = $row;
                    }

                $output = array(
                    'draw'              => $_POST['draw'],
                    'recordsTotal'      => $this->M_saldo->count_all($dt),
                    'recordsFiltered'   => $this->M_saldo->count_filtered($dt),
                    'data'              => $data
                );

                echo json_encode($output);
            }

            public function saldo_detail()
            {
                $id_umkm        = $this->input->post('id_umkm');
                $id_pencatatan  = $this->input->post('id_pencatatan');

                // cari tanggal transaksi
                $tg = $this->M_saldo->cari_data('pencatatan', array('id_pencatatan' => $id_pencatatan))->row_array();
                
                $tgl = $tg['tanggal_transaksi'];

                // cari saldo di log modal
                $cari_1 = $this->M_saldo->cari_saldo($tgl, $id_umkm);

                // tentukan saldo terakhir
                if ($cari_1->num_rows() == 0) {
                    $saldo_terakhir = 0;
                } else {
                    $c = $cari_1->row_array();
                    $saldo_terakhir = $c['nominal'];
                }

                $data = [ 'saldo_d'  => $this->M_saldo->get_data_saldo_detail($id_umkm, $id_pencatatan),
                          'id_umkm'  => $id_umkm,
                          'id_pen'   => $id_pencatatan,
                          'tot_saldo'=> $saldo_terakhir
                        ];
                
                $this->load->view('saldo/V_saldo_detail', $data);
            }

            public function tes_tampil_saldo($id_umkm = 11, $id_pen = 72)
            {
                $hasil_deb  = $this->M_saldo->cari_data_detail('pemasukan', $id_pen, $id_umkm)->result();

                $hasil_kre  = $this->M_saldo->cari_data_detail('pengeluaran', $id_pen, $id_umkm)->result();

                $data = array();
                
                foreach($hasil_deb as $pem)
                {
                    $key            = strtotime($pem->add_time);

                    $data[$key.$pem->id_umkm][]   = array(

                        'id'        => $pem->id_pemasukan,
                        'keterangan'=> $pem->penjualan,
                        'jumlah'    => $pem->jumlah,
                        'nominal'   => $pem->nominal,
                        'saldo'     => $pem->saldo,
                        'tabel'     => 'pemasukan',
                        'id_pk'     => 'id_pemasukan',
                        'id_pen'    => $pem->id_pencatatan
                    );
                }

                foreach($hasil_kre as $peng)
                {
                    $key            = strtotime($peng->add_time);

                    $data[$key.$peng->id_umkm][]   = array(

                        'id'        => $peng->id_pengeluaran,
                        'keterangan'=> $peng->pembelian,
                        'jumlah'    => $peng->jumlah,
                        'nominal'   => $peng->nominal,
                        'saldo'     => $peng->saldo,
                        'tabel'     => 'pengeluaran',
                        'id_pk'     => 'id_pengeluaran',
                        'id_pen'    => $peng->id_pencatatan
                    );
                }

                ksort($data);

                // $tot_saldo = 0;

                // $no=0;
                // foreach($data as $key =>$value)
                // {
                //     foreach($value as $p)
                //     {
                //         $no++;
                //         $row    = array();

                //         $row[]  = $no;
                //         $row[]  = $p['keterangan'];
                //         $row[]  = $p['jumlah'];
                        
                //         $row[]  = "Rp. ".number_format($p['debet'],0,",",".");
                //         $row[]  = "Rp. ".number_format($p['kredit'],0,",",".");
                //         $row[]  = "Rp. ".number_format($p['saldo'],0,",",".");
                    
                //         $data_saldo[] = $row;

                //         $tot_saldo += $p['saldo'];
                //     }
                // }

                echo "<pre>";
                print_r($data);
                echo "</pre>";

            }

            public function tampil_saldo_detail($id_umkm, $id_pen)
            {
                $hasil_deb  = $this->M_saldo->cari_data_detail('pemasukan', $id_pen, $id_umkm)->result();

                $hasil_kre  = $this->M_saldo->cari_data_detail('pengeluaran', $id_pen, $id_umkm)->result();

                $data = array();
                
                foreach($hasil_deb as $pem)
                {
                    $key            = strtotime($pem->add_time);

                    $data[$key.$pem->id_umkm][]   = array(

                        'keterangan'=> $pem->penjualan,
                        'jumlah'    => $pem->jumlah,
                        'debet'     => $pem->nominal,
                        'kredit'    => 0,
                        'saldo'     => $pem->saldo
                    );
                }

                foreach($hasil_kre as $peng)
                {
                    $key            = strtotime($peng->add_time);

                    $data[$key.$peng->id_umkm][]   = array(
                        'keterangan'=> $peng->pembelian,
                        'jumlah'    => $peng->jumlah,
                        'debet'     => 0,
                        'kredit'    => $peng->nominal,
                        'saldo'     => $peng->saldo
                    );
                }

                ksort($data);

                $tot_saldo = 0;

                $no=0;
                foreach($data as $key =>$value)
                {
                    foreach($value as $p)
                    {
                        $no++;
                        $row    = array();

                        $row[]  = $no;
                        $row[]  = $p['keterangan'];
                        $row[]  = $p['jumlah'];
                        
                        $row[]  = "Rp. ".number_format($p['debet'],0,",",".");
                        $row[]  = "Rp. ".number_format($p['kredit'],0,",",".");
                        $row[]  = "Rp. ".number_format($p['saldo'],0,",",".");
                    
                        $data_saldo[] = $row;

                        $tot_saldo += $p['saldo'];
                    }
                }

                if ($data) {
                    echo json_encode(array('data'=> $data_saldo, 'tot_saldo' => $tot_saldo));
                }else{
                    echo json_encode(array('data'=>0));
                }
            }

            public function form_tambah_detail()
            {
                $id_pencatatan  = $this->input->post('id_pen');
                $id_umkm        = $this->session->userdata('umkm');

                // cari tanggal transaksi
                $tg = $this->M_saldo->cari_data('pencatatan', array('id_pencatatan' => $id_pencatatan))->row_array();
                
                $tgl = $tg['tanggal_transaksi'];

                // cari saldo di log modal
                $cari_1 = $this->M_saldo->cari_saldo($tgl, $id_umkm);

                // tentukan saldo terakhir
                if ($cari_1->num_rows() == 0) {
                    $saldo_terakhir = 0;
                } else {
                    $c = $cari_1->row_array();
                    $saldo_terakhir = $c['nominal'];
                }
                
                $data = [ 'id_pen'      => $id_pencatatan,
                          'id_umkm'     => $id_umkm,
                          'tot_saldo'   => $saldo_terakhir,
                          'tanggal_tr'  => $tgl,
                          'tgl_tr'      => nice_date($tgl, 'd F Y')
                        ];

                $this->load->view('saldo/V_saldo_tambah', $data);
                
            }

            // tes lagi 
            public function tes_lagi()
            {
                // $this->db->from('pengeluaran');
                // $this->db->where("CAST(add_time as VARCHAR) LIKE '%2019-12%'");
                
                // $this->db->where_not_in('id_pencatatan', '72');

                // $query = $this->db->get()->result_array();

                $a = '2019-12-01';

                $this->db->from('log_modal');
                $this->db->where('id_umkm',11);
                $this->db->where("CAST(tanggal_pencatatan as VARCHAR) BETWEEN '2019-12-02' AND '2019-12-02'");
                
                $query_3 = $this->db->get()->result_array();

                print_r($query_3);
                
            }

            // proses simpan data nominal pemasukan dan pengeluaran
            public function tambah_nominal()
            {
                $keterangan = $this->input->post('keterangan');
                $jumlah     = $this->input->post('jumlah');
                $nominal    = $this->input->post('nominal');
                
                $id_umkm    = $this->input->post('id_umkm');
                $id_pen     = $this->input->post('id_pen');

                $tanggal_tr = $this->input->post('tgl_tr');
                
                $aksi       = $this->input->post('aksi');

                // cari tanggal transaksi
                $tg = $this->M_saldo->cari_data('pencatatan', array('id_pencatatan' => $id_pen))->row_array();
                
                $tgl_c = nice_date($tg['tanggal_transaksi'], 'Y-m');

                $tgl = $tg['tanggal_transaksi'];

                // cari saldo di log modal, menurut bulan transaksi dan id umkm
                $cari_1 = $this->M_saldo->cari_saldo($tgl_c, $id_umkm);

                $cari_2 = $this->M_saldo->cari_saldo_pen($tanggal_tr, $id_umkm);

                // tentukan saldo terakhir
                if ($cari_1->num_rows() == 0) {
                    $saldo_terakhir = 0;
                } else {

                    // jika tanggal transaksi tidak ada
                    if ($cari_2->num_rows() == 0) {
                        $c = $cari_1->row_array();
                        $saldo_terakhir = $c['nominal'];
                    } else {
                        $d = $cari_2->row_array();
                        $saldo_terakhir = $d['nominal'];
                    }
                    
                }

                // kondisi aksi debit atau kredit
                if ($aksi == 'pemasukan') {
                    $saldo = $saldo_terakhir + $nominal;
                } else {
                    $saldo = $saldo_terakhir - $nominal;
                }

                $this->db->trans_start();

                    // input tabel pemasukn atau pengeluaran
                    if ($aksi == 'pemasukan') {

                        $data_pem   = [ 'id_umkm'       => $id_umkm,
                                        'nominal'       => $nominal,
                                        'saldo'         => $saldo,
                                        'penjualan'     => $keterangan,
                                        'jumlah'        => $jumlah,
                                        'id_pencatatan' => $id_pen
                                    ];

                        $this->M_saldo->input_data('pemasukan', $data_pem);

                    } else {

                        $data_peng  = [ 'id_umkm'       => $id_umkm,
                                        'nominal'       => $nominal,
                                        'saldo'         => $saldo,
                                        'pembelian'     => $keterangan,
                                        'jumlah'        => $jumlah,
                                        'id_pencatatan' => $id_pen,
                                        'add_by'        => $this->session->userdata('id_peg')
                                    ];

                        $this->M_saldo->input_data('pengeluaran', $data_peng);

                    }

                    // input log modal
                    $this->M_saldo->input_data('log_modal', array('nominal' => $saldo, 'id_umkm' => $id_umkm, 'tanggal_pencatatan' => $tgl));

                    $c = $cari_1->row_array();

                    $tgl_akhir = strtotime($c['tanggal_pencatatan']);
                    $tgl_input = strtotime($tanggal_tr);

                    // cek jika tanggal input kurang dari tanggal akhir di log modal
                    if ($tgl_input < $tgl_akhir) {

                        $date = date("Y-m");

                        $tgl_akh = date('Y-t-m', strtotime($date));

                        // hapus data log modal
                        $this->db->from('log_modal');
                        $this->db->where("CAST(tanggal_pencatatan as VARCHAR) BETWEEN '$tanggal_tr+1' AND '$tgl_akh'");
                        $this->db->where('id_umkm', $id_umkm);
                        $d_tgl = $this->db->get()->result_array();
                        
                        foreach ($d_tgl as $d) {
                            $this->db->delete('log_modal', array('id_log_modal' => $d['id_log_modal']));
                        }

                        // mengupdate saldo per tanggal per pencatatan
                        $hasil_deb  = $this->M_saldo->cari_data_detail('pemasukan', $id_pen, $id_umkm)->result();

                        $hasil_kre  = $this->M_saldo->cari_data_detail('pengeluaran', $id_pen, $id_umkm)->result();

                        $data = array();
                        
                        foreach($hasil_deb as $pem)
                        {
                            $key            = strtotime($pem->add_time);

                            $data[$key.$pem->id_umkm][]   = array(

                                'id'        => $pem->id_pemasukan,
                                'keterangan'=> $pem->penjualan,
                                'jumlah'    => $pem->jumlah,
                                'nominal'   => $pem->nominal,
                                'saldo'     => $pem->saldo,
                                'tabel'     => 'pemasukan',
                                'id_pk'     => 'id_pemasukan',
                                'id_pen'    => $pem->id_pencatatan
                            );
                        }

                        foreach($hasil_kre as $peng)
                        {
                            $key            = strtotime($peng->add_time);

                            $data[$key.$peng->id_umkm][]   = array(

                                'id'        => $peng->id_pengeluaran,
                                'keterangan'=> $peng->pembelian,
                                'jumlah'    => $peng->jumlah,
                                'nominal'   => $peng->nominal,
                                'saldo'     => $peng->saldo,
                                'tabel'     => 'pengeluaran',
                                'id_pk'     => 'id_pengeluaran',
                                'id_pen'    => $peng->id_pencatatan
                            );
                        }

                        ksort($data);

                        foreach($data as $key =>$value)
                        {
                            foreach($value as $p)
                            {
                                $cari_1 = $this->M_saldo->cari_saldo($tgl_c, $id_umkm);

                                $c = $cari_1->row_array();
                                $saldo_terakhir = $c['nominal'];

                                if ($p['tabel'] == 'pemasukan') {
                                    $saldo = $saldo_terakhir + $p['nominal'];
                                } else {
                                    $saldo = $saldo_terakhir - $p['nominal'];
                                }

                                $cr = $this->M_saldo->cari_data('pencatatan', array('id_pencatatan' => $p['id_pen']))->row_array();

                                $this->db->update($p['tabel'], array('saldo' => $saldo), array($p['id_pk'] => $p['id']));

                                $this->M_saldo->input_data('log_modal', array('nominal' => $saldo, 'id_umkm' => $id_umkm, 'tanggal_pencatatan' => $cr['tanggal_transaksi']));
                                
                            }
                        }


                    }

                $this->db->trans_complete();

                // cek status
                if($this->db->trans_status() === FALSE) {

                    $res['status_tambah'] = "not ok";
                    $this->db->trans_rollback();

                } else {
                    
                    $res['status_tambah'] = "ok";
                    $res['saldo']         = number_format($saldo, '2', ',', '.');
                }
                
                echo json_encode($res);

            }

            public function tambah_pencatatan()
            {
                $tanggal    = $this->input->post('tanggal');
                $judul      = $this->input->post('judul');
                $id_umkm    = $this->input->post('id_umkm');
                $aksi       = $this->input->post('aksi_pen');
                $id_pen     = $this->input->post('id_pen');

                $data   = [ 'judul_pencatatan'  => $judul,
                            'tanggal_transaksi' => $tanggal,
                            'id_umkm'           => $id_umkm
                ];

                if ($aksi == 'Tambah') {
                    $this->M_saldo->input_data('pencatatan', $data);
                } elseif ($aksi == 'Edit') {
                    $this->M_saldo->ubah_data('pencatatan', $data, array('id_pencatatan' => $id_pen));
                } else {
                    $this->M_saldo->hapus_data('pencatatan', array('id_pencatatan' => $id_pen));
                }

                echo json_encode(['status' => TRUE]);
                
            }

            public function ambil_data_pencatatan($id_pencatatan)
            {
                $data = $this->M_saldo->cari_data('pencatatan', array('id_pencatatan' => $id_pencatatan))->row_array();

                $hasil = [ 'tgl'    => nice_date($data['tanggal_transaksi'], 'd-F-Y'),
                           'judul'  => $data['judul_pencatatan'],
                           'id_pen' => $data['id_pencatatan']
                ];

                echo json_encode($hasil );
            }

            public function get_saldo_umkm()
                {
                    $id_umkm    = $this->session->userdata('umkm');

                    $bulan      = date('m');
                    $tahun      = date('Y');

                    $data       = array();
                    $data_saldo = array();
                    $total_saldo = 0;

                    $cond = "EXTRACT(MONTH FROM add_time) ='".$bulan."' AND EXTRACT(YEAR FROM add_time) ='".$tahun."' ";

                    if($this->session->userdata('cond_pemasukan_saldo_umkm') != "" && $this->session->userdata('cond_pengeluaran_saldo_umkm') != "")
                        {
                            $cond_pemasukan     = $this->session->userdata('cond_pemasukan_saldo_umkm');
                            $cond_pengeluaran   = $this->session->userdata('cond_pengeluaran_saldo_umkm');
                            $pemasukan = $this->M_pemasukan->tampil_pemasukan()
                            ->where(array(
                                'pemasukan.id_umkm' => $id_umkm,
                            ))
                            ->where($cond_pemasukan)
                            ->order_by('pemasukan.add_time','asc')
                            ->get()
                            ->result();

                            // echo $this->db->last_query();exit();

                            $pengeluaran = $this->M_pengeluaran->tampil_pengeluaran()
                            ->where(array(
                                'pengeluaran.id_umkm'                           => $id_umkm,
                            )) 
                            ->where($cond_pengeluaran)
                            ->order_by('pengeluaran.add_time','asc')
                            ->get()
                            ->result();
                        }
                    else 
                        {
                            $pemasukan = $this->M_pemasukan->tampil_pemasukan()->where(array(
                                'pemasukan.id_umkm'                           => $id_umkm,
                                "EXTRACT(MONTH FROM pemasukan.add_time) ='".$bulan."'"    => NULL,
                                "EXTRACT(YEAR FROM pemasukan.add_time) ='".$tahun."' "    => NULL,
                            ))->order_by('pemasukan.add_time','asc')->get()->result();

                            // echo $this->db->last_query();exit();

                            $pengeluaran = $this->M_pengeluaran->tampil_pengeluaran()->where(array(
                                'pengeluaran.id_umkm'                           => $id_umkm,
                                "EXTRACT(MONTH FROM pengeluaran.add_time) ='".$bulan."'"    => NULL,
                                "EXTRACT(YEAR FROM pengeluaran.add_time) ='".$tahun."' "    => NULL,
                            ))->order_by('pengeluaran.add_time','asc')->get()->result();
                        }

                    

                    foreach($pemasukan as $pem)
                        {
                            $key            = strtotime($pem->add_time);
                            $tanggal        = date_format(date_create($pem->add_time),"d-m-Y");

                            $data[$key][]   = array(
                                'tanggal'   => $tanggal,
                                'debet'     => $pem->nominal,
                                'kredit'    => 0,
                                'saldo'     => $pem->saldo,
                            );
                        }

                    foreach($pengeluaran as $peng)
                        {
                            $key            = strtotime($peng->add_time);
                            $tanggal        = date_format(date_create($pem->add_time),"d-m-Y");

                            $data[$key][]   = array(
                                'tanggal'   => $tanggal,
                                'debet'     => 0,
                                'kredit'    => $peng->nominal,
                                'saldo'     => $peng->saldo,
                            );
                        }
                    ksort($data);
                    // echo json_encode($data);exit();
                    $no=0;
                    foreach($data as $key =>$value)
                        {
                            foreach($value as $p)
                            {
                                // $id = $->id_pemasukan;
                                // $status = $field->status;

                                    $no++;
                                    $row        = array();

                                    $row[]  = $no;
                                    $row[]  = $p['tanggal'];
                                    
                                    $row[]  = $p['debet'];
                                    $row[]  = $p['kredit'];
                                    $row[]  = $p['saldo'];
                                

                                    $data_saldo[] = $row;
                                    $total_saldo = $p['saldo'];
                                    // $this->session->set_userdata('total_saldo_umkm',$total_saldo);
                            }
                        }

                    // echo $total_saldo;exit();
                    $this->session->set_userdata('total_saldo_umkm',$total_saldo);
                    
                    # membuat output data nama kategori
                    # yang akan ditampilkan pada datatables
                    $output = array(
                        // 'draw'              => $_POST['draw'],
                        // 'recordsTotal'      => count($data_saldo),
                        // 'recordsFiltered'   => 10,
                        'data'              => $data_saldo,
                        'total_saldo'       => number_format($total_saldo,0,",","."),
                    );

                    echo json_encode($output);


                }

            public function get_total_saldo()
                {
                    echo $this->session->userdata('total_saldo_umkm');
                }

            public function set_periode_saldo_umkm()
                {
                    // echo jsoN_encode($this->input->post());

                    $awal   = $this->input->post('awal');
                    $akhir  = $this->input->post('akhir');

                    $cond_pemasukan   = "";
                    $cond_pengeluaran = "";

                    if($awal != "" && $akhir != "")
                        {
                            if($awal == $akhir)
                                {
                                    $cond_pemasukan     = "(pemasukan.add_time)::DATE ='".$awal."'::DATE";
                                    $cond_pengeluaran   = "(pengeluaran.add_time)::DATE ='".$awal."'::DATE";
                                }
                            else 
                                {
                                    $cond_pemasukan     = "(pemasukan.add_time)::DATE BETWEEN '".$awal."'::DATE AND '".$akhir."'::DATE";
                                    $cond_pengeluaran   = "(pengeluaran.add_time)::DATE BETWEEN '".$awal."'::DATE AND '".$akhir."'::DATE";
                                }
                        }
                    else if($awal != "" && $akhir == "")
                        {
                            $cond_pemasukan     = "(pemasukan.add_time)::DATE ='".$awal."'::DATE";
                            $cond_pengeluaran   = "(pengeluaran.add_time)::DATE ='".$awal."'::DATE";
                        }
                    else if($awal == "" && $akhir != "")
                        {
                            $cond_pemasukan = "(pemasukan.add_time)::DATE ='".$akhir."'::DATE";
                            $cond_pengeluaran = "(pengeluaran.add_time)::DATE ='".$akhir."'::DATE";
                        }
                    else 
                        {
                            $cond_pemasukan     = "";
                            $cond_pengeluaran   = "";
                        }

                    $this->session->set_userdata('cond_pemasukan_saldo_umkm',$cond_pemasukan);
                    $this->session->set_userdata('cond_pengeluaran_saldo_umkm',$cond_pengeluaran);
                }


            public function set_periode_saldo()
                {
                    // echo jsoN_encode($this->input->post());

                    $awal   = $this->input->post('awal');
                    $akhir  = $this->input->post('akhir');

                    $cond_pemasukan   = "";
                    $cond_pengeluaran = "";

                    if($awal != "" && $akhir != "")
                        {
                            if($awal == $akhir)
                                {
                                    $cond_pemasukan     = "(pemasukan.add_time)::DATE ='".$awal."'::DATE";
                                    $cond_pengeluaran   = "(pengeluaran.add_time)::DATE ='".$awal."'::DATE";
                                }
                            else 
                                {
                                    $cond_pemasukan     = "(pemasukan.add_time)::DATE BETWEEN '".$awal."'::DATE AND '".$akhir."'::DATE";
                                    $cond_pengeluaran   = "(pengeluaran.add_time)::DATE BETWEEN '".$awal."'::DATE AND '".$akhir."'::DATE";
                                }
                        }
                    else if($awal != "" && $akhir == "")
                        {
                            $cond_pemasukan     = "(pemasukan.add_time)::DATE ='".$awal."'::DATE";
                            $cond_pengeluaran   = "(pengeluaran.add_time)::DATE ='".$awal."'::DATE";
                        }
                    else if($awal == "" && $akhir != "")
                        {
                            $cond_pemasukan = "(pemasukan.add_time)::DATE ='".$akhir."'::DATE";
                            $cond_pengeluaran = "(pengeluaran.add_time)::DATE ='".$akhir."'::DATE";
                        }
                    else 
                        {
                            $cond_pemasukan     = "";
                            $cond_pengeluaran   = "";
                        }

                    $this->session->set_userdata('cond_pemasukan_saldo',$cond_pemasukan);
                    $this->session->set_userdata('cond_pengeluaran_saldo',$cond_pengeluaran);
                }


            public function get_saldo()
                {
                    

                    $bulan      = date('m');
                    $tahun      = date('Y');

                    $data       = array();
                    $data_saldo = array();
                    $total_saldo = 0;

                    $cond = "EXTRACT(MONTH FROM add_time) ='".$bulan."' AND EXTRACT(YEAR FROM add_time) ='".$tahun."' ";

                    if($this->session->userdata('cond_pemasukan_saldo') != "" && $this->session->userdata('cond_pengeluaran_saldo') != "")
                        {
                            $cond_pemasukan     = $this->session->userdata('cond_pemasukan_saldo');
                            $cond_pengeluaran   = $this->session->userdata('cond_pengeluaran_saldo');
                            $pemasukan = $this->M_pemasukan->tampil_pemasukan()
                            ->where($cond_pemasukan)
                            ->order_by('pemasukan.add_time','asc')
                            ->get()
                            ->result();

                            // echo $this->db->last_query();exit();

                            $pengeluaran = $this->M_pengeluaran->tampil_pengeluaran()
                            ->where($cond_pengeluaran)
                            ->order_by('pengeluaran.add_time','asc')
                            ->get()
                            ->result();
                        }
                    else 
                        {
                            $pemasukan = $this->M_pemasukan->tampil_pemasukan()->where(array(
                                "EXTRACT(MONTH FROM pemasukan.add_time) ='".$bulan."'"    => NULL,
                                "EXTRACT(YEAR FROM pemasukan.add_time) ='".$tahun."' "    => NULL,
                            ))->order_by('pemasukan.add_time','asc')->get()->result();

                            // echo $this->db->last_query();exit();

                            $pengeluaran = $this->M_pengeluaran->tampil_pengeluaran()->where(array(
                                "EXTRACT(MONTH FROM pengeluaran.add_time) ='".$bulan."'"    => NULL,
                                "EXTRACT(YEAR FROM pengeluaran.add_time) ='".$tahun."' "    => NULL,
                            ))->order_by('pengeluaran.add_time','asc')->get()->result();
                        }

                    

                    foreach($pemasukan as $pem)
                        {
                            $key            = strtotime($pem->add_time);
                            $tanggal        = date_format(date_create($pem->add_time),"d-m-Y");

                            $data[$key.$pem->id_umkm][]   = array(

                                'nama_umkm' => $pem->nama_umkm,
                                'tanggal'   => $tanggal,
                                'debet'     => $pem->nominal,
                                'kredit'    => 0,
                                'saldo'     => $pem->saldo,
                            );
                        }

                    foreach($pengeluaran as $peng)
                        {
                            $key            = strtotime($peng->add_time);
                            $tanggal        = date_format(date_create($peng->add_time),"d-m-Y");

                            $data[$key.$peng->id_umkm][]   = array(
                                'nama_umkm' => $peng->nama_umkm,
                                'tanggal'   => $tanggal,
                                'debet'     => 0,
                                'kredit'    => $peng->nominal,
                                'saldo'     => $peng->saldo,
                            );
                        }
                    ksort($data);
                    // echo json_encode($data);exit();
                    $no=0;
                    foreach($data as $key =>$value)
                        {
                            foreach($value as $p)
                            {
                                // $id = $->id_pemasukan;
                                // $status = $field->status;

                            
                        
                                    $no++;
                                    $row        = array();

                                    $row[]  = $no;
                                    $row[]  = $p['nama_umkm'];
                                    $row[]  = $p['tanggal'];
                                    
                                    $row[]  = "Rp. ".number_format($p['debet'],0,",",".");
                                    $row[]  = "Rp. ".number_format($p['kredit'],0,",",".");
                                    $row[]  = "Rp. ".number_format($p['saldo'],0,",",".");
                                

                                    $data_saldo[] = $row;
                                    $total_saldo += $p['saldo'];
                                    // $this->session->set_userdata('total_saldo_umkm',$total_saldo);
                            }
                        }

                    // echo $total_saldo;exit();
                    $this->session->set_userdata('total_saldo',$total_saldo);
                    
                    # membuat output data nama kategori
                    # yang akan ditampilkan pada datatables
                    $output = array(
                        // 'draw'              => $_POST['draw'],
                        // 'recordsTotal'      => count($data_saldo),
                        // 'recordsFiltered'   => 10,
                        'data'              => $data_saldo,
                        'total_saldo'       => number_format($total_saldo,0,",","."),
                    );

                    echo json_encode($output);


                }
        }