<?php 
    class Summary extends CI_Controller 
        {
            public function __construct()
                {
                    parent::__construct();
                    $this->load->model('M_modal');
                    $this->load->model('M_pemasukan');
                    $this->load->model('M_pengeluaran');
                    $this->load->model('M_summary');
                }

            public function index()
            {
                // $bulan = '';
            
                // $laba = $this->M_summary->get_total_laba($bulan)->result_array();

                // $tot_laba = 0;
                // foreach ($laba as $b) {
                //     $tot_laba += $b['laba'];
                // }

                $bulan = '';

                $this->db->join('umkm as u', 'u.id_umkm = p.id_umkm', 'inner');
                
                if ($bulan != '') {
                $this->db->where("CAST(p.tanggal_transaksi as VARCHAR) LIKE '%$bulan%'");
                }
                
                $hasil = $this->db->get('pencatatan as p');
                
                if ($hasil->num_rows() != 0) {
                    $b = array();
                    foreach ($hasil->result_array() as $a) {
                        $data[] = ['id_umkm'    => $a['id_umkm'],
                                    'nama_umkm' => $a['nama_umkm'],
                                    'bulan'     => nice_date($a['tanggal_transaksi'], 'Y-m')
                                ];
                    }
                    $list = array_map(
                        'unserialize',
                        array_unique(
                            array_map(
                                'serialize',
                                $data
                            )
                        )
                    );

                    $tot_laba = 0;

                    foreach ($list as $u) {
                        $bln = $u['bulan'];
                        $id_umkm = $u['id_umkm'];

                        $this->db->select('sum(nominal) tot_pengeluaran');
                        $this->db->from('pengeluaran as p');
                        $this->db->join('pencatatan as pe', 'pe.id_pencatatan = p.id_pencatatan', 'inner');
                        $this->db->where('pe.id_umkm', $id_umkm);

                        $this->db->where("CAST(pe.tanggal_transaksi as VARCHAR) LIKE '%$bln%'");

                        $hasil_peng = $this->db->get()->row_array();

                        $this->db->select('sum(nominal) tot_pemasukan');
                        $this->db->from('pemasukan as p');
                        $this->db->join('pencatatan as pe', 'pe.id_pencatatan = p.id_pencatatan', 'inner');
                        $this->db->where('pe.id_umkm', $id_umkm);
                        
                        $this->db->where("CAST(pe.tanggal_transaksi as VARCHAR) LIKE '%$bln%'");
                        

                        $hasil_pem = $this->db->get()->row_array();

                        $tot_laba += $hasil_pem['tot_pemasukan'] - $hasil_peng['tot_pengeluaran'];

                        $value[] = [ 'id_umkm'     => $u['id_umkm'],
                                    'nama_umkm'    => $u['nama_umkm'],
                                    'bulan'        => $u['bulan'],
                                    'pemasukan'    => $hasil_pem['tot_pemasukan'],
                                    'pengeluaran'  => $hasil_peng['tot_pengeluaran'],
                                    'laba'         => $hasil_pem['tot_pemasukan'] - $hasil_peng['tot_pengeluaran']
                                    ];
                    }

                    $h_tot = number_format($tot_laba, '2', ',', '.');
                } else {
                    $value[] = [];

                    $h_tot = '0,00';
                }

                $data = array(
                    'content'   => 'summary/index',
                    'judul'     => 'summary',
                    'tot_laba'  => $h_tot,
                    'list'      => $value
                );

                $this->load->view('layout/template',$data);
            }

            public function form_filter_summary()
            {
                $bulan = date_format(date_create($this->input->post('bulan')),'Y-m');

                $this->db->join('umkm as u', 'u.id_umkm = p.id_umkm', 'inner');
                
                if ($bulan != '') {
                $this->db->where("CAST(p.tanggal_transaksi as VARCHAR) LIKE '%$bulan%'");
                }
                
                $hasil = $this->db->get('pencatatan as p');

                if ($hasil->num_rows() != 0) {
                    $b = array();
                    foreach ($hasil->result_array() as $a) {
                        $data[] = ['id_umkm' => $a['id_umkm'],
                                    'nama_umkm' => $a['nama_umkm'],
                                    'bulan'  => nice_date($a['tanggal_transaksi'], 'Y-m')
                                ];
                    }
                    $list = array_map(
                        'unserialize',
                        array_unique(
                            array_map(
                                'serialize',
                                $data
                            )
                        )
                    );

                    $tot_laba = 0;

                    foreach ($list as $u) {
                        $bln = $u['bulan'];
                        $id_umkm = $u['id_umkm'];

                        $this->db->select('sum(nominal) tot_pengeluaran');
                        $this->db->from('pengeluaran as p');
                        $this->db->join('pencatatan as pe', 'pe.id_pencatatan = p.id_pencatatan', 'inner');
                        $this->db->where('pe.id_umkm', $id_umkm);

                        $this->db->where("CAST(pe.tanggal_transaksi as VARCHAR) LIKE '%$bln%'");

                        $hasil_peng = $this->db->get()->row_array();

                        $this->db->select('sum(nominal) tot_pemasukan');
                        $this->db->from('pemasukan as p');
                        $this->db->join('pencatatan as pe', 'pe.id_pencatatan = p.id_pencatatan', 'inner');
                        $this->db->where('pe.id_umkm', $id_umkm);
                        
                        $this->db->where("CAST(pe.tanggal_transaksi as VARCHAR) LIKE '%$bln%'");
                        

                        $hasil_pem = $this->db->get()->row_array();

                        $tot_laba += $hasil_pem['tot_pemasukan'] - $hasil_peng['tot_pengeluaran'];

                        $value[] = [ 'id_umkm'     => $u['id_umkm'],
                                    'nama_umkm'    => $u['nama_umkm'],
                                    'bulan'        => $u['bulan'],
                                    'pemasukan'    => $hasil_pem['tot_pemasukan'],
                                    'pengeluaran'  => $hasil_peng['tot_pengeluaran'],
                                    'laba'         => $hasil_pem['tot_pemasukan'] - $hasil_peng['tot_pengeluaran']
                                    ];
                    }

                    $h_tot = number_format($tot_laba, '2', ',', '.');
                } else {
                    $value[] = [];

                    $h_tot = '0,00';
                }
                
                

                $data1 = array(
                    'judul'         => 'summary',
                    'tot_laba_fil'  => $h_tot,
                    'list_fil'      => $value
                );

                $this->load->view('summary/V_filter_sum',$data1);
            }

            public function tes()
            {
                $bulan = '';

                $this->db->join('umkm as u', 'u.id_umkm = p.id_umkm', 'inner');

                if ($bulan != '') {
                $this->db->where("CAST(p.tanggal_transaksi as VARCHAR) LIKE '%$bulan%'");
                }
                
                $hasil = $this->db->get('pencatatan as p');
                
                $b = array();
                foreach ($hasil->result_array() as $a) {
                    $data[] = ['id_umkm' => $a['id_umkm'],
                                'nama_umkm' => $a['nama_umkm'],
                                'bulan'  => nice_date($a['tanggal_transaksi'], 'Y-m')
                            ];
                }

                $unique = array_map(
                    'unserialize',
                    array_unique(
                        array_map(
                            'serialize',
                            $data
                        )
                    )
                );
                
                foreach ($unique as $u) {
                    $bln = $u['bulan'];
                    $id_umkm = $u['id_umkm'];

                    $this->db->select('sum(nominal) tot_pengeluaran');
                    $this->db->from('pengeluaran as p');
                    $this->db->join('pencatatan as pe', 'pe.id_pencatatan = p.id_pencatatan', 'inner');
                    $this->db->where('pe.id_umkm', $id_umkm);

                    $this->db->where("CAST(pe.tanggal_transaksi as VARCHAR) LIKE '%$bln%'");

                    $hasil_peng = $this->db->get()->row_array();

                    $this->db->select('sum(nominal) tot_pemasukan');
                    $this->db->from('pemasukan as p');
                    $this->db->join('pencatatan as pe', 'pe.id_pencatatan = p.id_pencatatan', 'inner');
                    $this->db->where('pe.id_umkm', $id_umkm);
                    
                    $this->db->where("CAST(pe.tanggal_transaksi as VARCHAR) LIKE '%$bln%'");
                    

                    $hasil_pem = $this->db->get()->row_array();

                    $value[] = [ 'id_umkm'     => $u['id_umkm'],
                                'nama_umkm'    => $u['nama_umkm'],
                                'bulan'        => $u['bulan'],
                                'pemasukan'    => $hasil_pem['tot_pemasukan'],
                                'pengeluaran'  => $hasil_peng['tot_pengeluaran'],
                                'laba'         => $hasil_pem['tot_pemasukan'] - $hasil_peng['tot_pengeluaran']
                                ];
                }

                echo "<pre>";
                print_r($value);
                echo "</pre>";

            }

            public function get_summary_baru_2()
            {
                // $tanggal = $this->input->post('bulan');
                 
                // $list = $this->M_summary->get_data_summary_baru_2($tanggal);

                $bulan = '2019-11';

                $this->db->join('umkm as u', 'u.id_umkm = p.id_umkm', 'inner');
                
                $this->db->where("CAST(p.tanggal_transaksi as VARCHAR) LIKE '%$bulan%'");
                
                $hasil = $this->db->get('pencatatan as p');
                
                $b = array();
                foreach ($hasil->result_array() as $a) {
                    $data[] = ['id_umkm' => $a['id_umkm'],
                                'nama_umkm' => $a['nama_umkm'],
                                'bulan'  => nice_date($a['tanggal_transaksi'], 'Y-m')
                            ];
                }
                $list = array_map(
                    'unserialize',
                    array_unique(
                        array_map(
                            'serialize',
                            $data
                        )
                    )
                );
                
                // print_r($unique);

                $no = 0;

                foreach($list as $f)
                {
                    $no++;
                    $row    = array();

                    $row[]  = $no;
                    $row[]  = $f['nama_umkm'];
                    $row[]  = '';
                    $row[]  = '';
                    $row[]  = '';
                    $row[]  = '';
                    $row[]  = "<button type='button' class='btn btn-outline-info btn-sm detail' data-id='".$f['id_umkm']."'>Detail</button>";

                    $data[] = $row;
                }

                if ($list) {
                    echo json_encode(['hasil'   => $data]);
                } else {
                    echo json_encode(['hasil'   => 0]);
                }
                
            }

            public function get_summary_baru()
            {
                $tanggal = $this->input->post('bulan');
                 
                $list = $this->M_summary->get_datatables($tanggal);

                $data = array();
                $no = $_POST['start'];

                foreach($list as $field)
                {
                    $no++;
                    $row        = array();

                    $row[]  = $no;
                    $row[]  = $field->nama_umkm;
                    $row[]  = nice_date($field->tanggal_transaksi, 'd-M-Y');
                    $row[]  = "Rp. ".number_format($field->tot_pemasukan,2,",",".");
                    $row[]  = "Rp. ".number_format($field->tot_pengeluaran,2,",",".");
                    $row[]  = "Rp. ".number_format($field->laba,2,",",".");
                    $row[]  = "<button type='button' class='btn btn-outline-info btn-sm detail' data-id='".$field->id_umkm."' id_pen='".$field->id_pencatatan."'>Detail</button>";

                    $data[] = $row;
                }

                $output = array(
                    'draw'              => $_POST['draw'],
                    'recordsTotal'      => $this->M_summary->count_all($tanggal),
                    'recordsFiltered'   => $this->M_summary->count_filtered($tanggal),
                    'data'              => $data
                );

                echo json_encode($output);
            }

            public function form_detail_summary()
            {
                $id_umkm = $this->input->post('id_umkm');
                $bulan_s   = $this->input->post('bulan');

                $cr = [ 'tgl_awal'   => '',
                        'tgl_akhir'   => ''
                     ];
                
                $hasil_deb  = $this->M_summary->cari_data_detail_sum_admin('pemasukan', $id_umkm, $cr, $bulan_s)->result();

                $hasil_kre  = $this->M_summary->cari_data_detail_sum_admin('pengeluaran', $id_umkm, $cr, $bulan_s)->result();

                $data = array();

                $tot_pem = 0;
                $tot_peng=0;
                
                foreach($hasil_deb as $pem)
                {
                    $tot_pem += $pem->nominal;
                }

                foreach($hasil_kre as $peng)
                {
                    $tot_peng += $peng->nominal;
                }

                $data = [ 'id_umkm' => $id_umkm,
                          'bulan_s' => $bulan_s,
                          'tot_saldo_s' => number_format($tot_pem - $tot_peng, '2',',','.')
                        ];

                $this->load->view('summary/V_detail_summary', $data);
                
            }

            public function ambil_total_saldo_s()
            {
                $id_umkm = $this->input->post('id_umkm');
                $bulan_s = $this->input->post('bulan_s');
                
                $cr = [ 'tgl_awal'   => $this->input->post('tgl_awal'),
                        'tgl_akhir'   => $this->input->post('tgl_akhir')
                        
                     ];
                
                $hasil_deb  = $this->M_summary->cari_data_detail_sum_admin('pemasukan', $id_umkm, $cr, $bulan_s)->result();

                $hasil_kre  = $this->M_summary->cari_data_detail_sum_admin('pengeluaran', $id_umkm, $cr, $bulan_s)->result();

                $data = array();

                $tot_pem = 0;
                $tot_peng=0;
                
                foreach($hasil_deb as $pem)
                {
                    $tot_pem += $pem->nominal;
                }

                foreach($hasil_kre as $peng)
                {
                    $tot_peng += $peng->nominal;
                }

                $data = [
                          'tot_saldo_s' => number_format($tot_pem - $tot_peng, '2',',','.')
                        ];

                echo json_encode($data);
            }

            public function ambil_total_laba()
            {
                $bulan = $this->input->post('bulan');
                
                $laba = $this->M_summary->get_total_laba($bulan)->result_array();

                $tot_laba = 0;
                foreach ($laba as $b) {
                    $tot_laba += $b['laba'];
                }

                echo json_encode(['tot_laba' => number_format($tot_laba, '2', ',', '.')]);
            }
            
            public function summary_umkm()
            {
                $id_umkm = $this->session->userdata('umkm');

                $bulan = '';
                
                $hasil_deb  = $this->M_summary->cari_data_detail_sum('pemasukan', $id_umkm, $bulan)->result();

                $hasil_kre  = $this->M_summary->cari_data_detail_sum('pengeluaran', $id_umkm, $bulan)->result();

                $tot_debit = 0;
                foreach($hasil_deb as $pem)
                {
                    $tot_debit += $pem->nominal;
                }

                $tot_kredit = 0;
                foreach($hasil_kre as $peng)
                {
                    $tot_kredit += $peng->nominal;
                }
                
                $data = array(
                    'content'   => 'umkm/summary_umkm',
                    'judul'     => 'summary',
                    'id_umkm'   => $id_umkm,
                    'tot_saldo' => number_format($tot_debit - $tot_kredit, '2',',','.')
                );

                $this->load->view('layout/template',$data);
            }

            public function ambil_total_saldo()
            {
                $id_umkm = $this->session->userdata('umkm');

                $bulan = $this->input->post('bulan');
                ;
                
                $hasil_deb  = $this->M_summary->cari_data_detail_sum('pemasukan', $id_umkm, $bulan)->result();

                $hasil_kre  = $this->M_summary->cari_data_detail_sum('pengeluaran', $id_umkm, $bulan)->result();

                $tot_debit = 0;
                foreach($hasil_deb as $pem)
                {
                    $tot_debit += $pem->nominal;
                }

                $tot_kredit = 0;
                foreach($hasil_kre as $peng)
                {
                    $tot_kredit += $peng->nominal;
                }

                $data = ['tot_saldo'    => number_format($tot_debit - $tot_kredit, '2',',','.')];

                echo json_encode($data);
            }

            public function get_summary_admin($id_umkm, $bulan_s)
            {
                $bulan = $this->input->post('bulan');
                $cr = [ 'tgl_awal'   => $this->input->post('tgl_awal'),
                        'tgl_akhir'   => $this->input->post('tgl_akhir')
                     ];
                
                $hasil_deb  = $this->M_summary->cari_data_detail_sum_admin('pemasukan', $id_umkm, $cr, $bulan_s)->result();

                $hasil_kre  = $this->M_summary->cari_data_detail_sum_admin('pengeluaran', $id_umkm, $cr, $bulan_s)->result();

                $data = array();
                
                foreach($hasil_deb as $pem)
                {
                    $key            = strtotime($pem->add_time);

                    $data[$key.$pem->id_umkm][]   = array(

                        'tgl_tran'  => $pem->add_time,
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

                        'tgl_tran'  => $peng->add_time,
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
                        $row        = array();

                        $row[]  = $no;
                        $row[]  = nice_date($p['tgl_tran'], 'd-M-Y');
                        $row[]  = $p['keterangan'];
                        $row[]  = $p['jumlah'];
                        
                        $row[]  = "Rp. ".number_format($p['debet'],0,",",".");
                        $row[]  = "Rp. ".number_format($p['kredit'],0,",",".");
                        $row[]  = "Rp. ".number_format($p['saldo'],0,",",".");
                    
                        $data_saldo[] = $row;
                    }
                }

                if ($data) {
                    echo json_encode(array('data'=> $data_saldo));
                }else{
                    echo json_encode(array('data'=>0));
                }
            }


            public function get_summary_umkm($id_umkm)
            {
                $bulan = $this->input->post('bulan');
                
                $hasil_deb  = $this->M_summary->cari_data_detail_sum('pemasukan', $id_umkm, $bulan)->result();

                $hasil_kre  = $this->M_summary->cari_data_detail_sum('pengeluaran', $id_umkm, $bulan)->result();

                $data = array();
                
                foreach($hasil_deb as $pem)
                {
                    $key            = strtotime($pem->add_time);

                    $data[$key.$pem->id_umkm][]   = array(

                        'tgl_tran'  => $pem->add_time,
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

                        'tgl_tran'  => $peng->add_time,
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
                        $row        = array();

                        $row[]  = $no;
                        $row[]  = nice_date($p['tgl_tran'], 'd-M-Y');
                        $row[]  = $p['keterangan'];
                        $row[]  = $p['jumlah'];
                        
                        $row[]  = "Rp. ".number_format($p['debet'],0,",",".");
                        $row[]  = "Rp. ".number_format($p['kredit'],0,",",".");
                        $row[]  = "Rp. ".number_format($p['saldo'],0,",",".");
                    
                        $data_saldo[] = $row;
                    }
                }

                if ($data) {
                    echo json_encode(array('data'=> $data_saldo));
                }else{
                    echo json_encode(array('data'=>0));
                }
            }

            public function get_summary()
                {
                    $id_umkm = $this->session->userdata('umkm');

                    $data_laba = array();

                    $data       = array();
                    $total_laba = 0;

                    if($this->session->userdata('cond_laba_pemasukan_umkm') != "" && $this->session->userdata('cond_laba_pengeluaran_umkm') != "")
                        {
                            $cond_pemasukan     = $this->session->userdata('cond_laba_pemasukan_umkm');
                            $cond_pengeluaran   = $this->session->userdata('cond_laba_pengeluaran_umkm');

                            $pemasukan          = $this->M_pemasukan->tampil_pemasukan()
                            ->where(array(
                                'pemasukan.id_umkm'  => $id_umkm,
                                
                            ))
                            ->where($cond_pemasukan)
                            ->order_by('pemasukan.add_time','asc')
                            ->get()
                            ->result();

                            // echo $this->db->last_query();exit();

                            $pengeluaran        = $this->M_pengeluaran->tampil_pengeluaran()
                            ->where(array(
                                'pengeluaran.id_umkm' => $id_umkm,
                            ))
                            ->where($cond_pengeluaran)
                            ->order_by('pengeluaran.add_time','asc')->get()->result();
                        }
                    else 
                        {
                            $tahun      = date('Y');
                            $pemasukan = $this->M_pemasukan->tampil_pemasukan()->where(array(
                                'pemasukan.id_umkm'                           => $id_umkm,
                                "EXTRACT(YEAR FROM pemasukan.add_time) ='".$tahun."' "    => NULL,
                            ))->order_by('pemasukan.add_time','asc')->get()->result();

                            // echo $this->db->last_query();exit();

                            $pengeluaran = $this->M_pengeluaran->tampil_pengeluaran()->where(array(
                                'pengeluaran.id_umkm'                           => $id_umkm,
                                "EXTRACT(YEAR FROM pengeluaran.add_time) ='".$tahun."' "    => NULL,
                            ))->order_by('pengeluaran.add_time','asc')->get()->result();
                        }

                    

                    

                    foreach($pemasukan as $p)
                        {
                            
                            $bulan = date_format(date_create($p->add_time),'m');
                            $thn   = date_format(date_create($p->add_time),'Y');

                            if(!isset($data[$bulan.$thn]['modal']))
                                {
                                    $tgl_cari = $thn."-".$bulan."-01";
                                    $cari_modal     = $this->M_modal->tampil_log_modal()->where(array(
                                        'id_umkm'   => $id_umkm,
                                        "(add_time)::DATE < '".$tgl_cari."'::DATE" => NULL,
                                    ))->count_all_results();

                                    if($cari_modal > 0)
                                        {
                                            $modal =$this->M_modal->tampil_log_modal()
                                            ->where(array(
                                                'id_umkm'   => $id_umkm,
                                                "(add_time)::DATE < '".$tgl_cari."'::DATE" => NULL,
                                            ))->order_by('add_time','desc')->limit(1)->get()->row_array();

                                            $modal_awal = $modal['nominal'];
                                        }
                                    else 
                                        {
                                            $modal =$this->M_modal->tampil_log_modal()
                                            ->where(array(
                                                'id_umkm'   => $id_umkm,
                                            ))->get()->row_array();

                                            $modal_awal = $modal['nominal'];
                                        }

                                    $data[$bulan.$thn]['modal']      = $modal_awal;
                                }
                            if(isset($data[$bulan.$thn]['pemasukan']))
                                {
                                    $data[$bulan.$thn]['pemasukan'] += $p->nominal;
                                } 
                            else 
                                {
                                    $data[$bulan.$thn]['pemasukan'] = $p->nominal;
                                }

                            if(isset($data[$bulan.$thn]['pengeluaran']))
                                {
                                    $laba = ($data[$bulan.$thn]['modal'] + $data[$bulan.$thn]['pemasukan']) - $data[$bulan.$thn]['pengeluaran'];
                                }
                            else 
                                {
                                    $data[$bulan.$thn]['pengeluaran'] = 0;
                                    $laba = $data[$bulan.$thn]['modal'] + $data[$bulan.$thn]['pemasukan'];
                                }
                            
                            $data[$bulan.$thn]['laba'] = $laba;
                            $data[$bulan.$thn]['bulan'] =$bulan."/".$thn;
                        }

                    foreach($pengeluaran as $p)
                        {
                            
                            $bulan = date_format(date_create($p->add_time),'m');
                            $thn   = date_format(date_create($p->add_time),'Y');

                            if(!isset($data[$bulan.$thn]['modal']))
                                {
                                    $tgl_cari = $thn."-".$bulan."-01";
                                    $cari_modal     = $this->M_modal->tampil_log_modal()->where(array(
                                        'id_umkm'   => $id_umkm,
                                        "(add_time)::DATE < '".$tgl_cari."'::DATE" => NULL,
                                    ))->count_all_results();

                                    

                                    if($cari_modal > 0)
                                        {
                                            $modal =$this->M_modal->tampil_log_modal()
                                            ->where(array(
                                                'id_umkm'   => $id_umkm,
                                                "(add_time)::DATE < '".$tgl_cari."'::DATE" => NULL,
                                            ))->order_by('add_time','desc')->limit(1)->get()->row_array();

                                            // echo $this->db->last_query();exit();

                                            $modal_awal = $modal['nominal'];
                                        }
                                    else 
                                        {
                                            $modal =$this->M_modal->tampil_log_modal()
                                            ->where(array(
                                                'id_umkm'   => $id_umkm,
                                            ))->get()->row_array();

                                            $modal_awal = $modal['nominal'];
                                        }

                                    $data[$bulan.$thn]['modal']      = $modal_awal;
                                }

                            if(isset($data[$bulan.$thn]['pengeluaran']))
                                {
                                    $data[$bulan.$thn]['pengeluaran'] += $p->nominal;
                                } 
                            else 
                                {
                                    $data[$bulan.$thn]['pengeluaran'] = $p->nominal;
                                }

                            if(isset($data[$bulan.$thn]['pemasukan']))
                                {
                                    $laba = ($data[$bulan.$thn]['modal'] + $data[$bulan.$thn]['pemasukan']) - $data[$bulan.$thn]['pengeluaran'];
                                }
                            else 
                                {
                                    $data[$bulan.$thn]['bulan'] =$bulan."/".$thn;
                                    $data[$bulan.$thn]['pemasukan'] = 0;
                                    $laba = $data[$bulan.$thn]['modal'] - $data[$bulan.$thn]['pengeluaran'];
                                }

                            

                            $data[$bulan.$thn]['laba'] = $laba;
                            
                        }

                    // echo json_encode($data);

                    $no=0;
                    foreach($data as $key =>$p)
                        {
                            // foreach($value as $p)
                            // {
                                // $id = $->id_pemasukan;
                                // $status = $field->status;

                            
                        
                                    $no++;
                                    $row        = array();

                                    $row[]  = $no;
                                    $row[]  = $p['bulan'];
                                    $row[]  = $p['modal'];
                                    
                                    $row[]  = "Rp. ".number_format($p['pemasukan'],0,",",".");
                                    $row[]  = "Rp. ".number_format($p['pengeluaran'],0,",",".");
                                    $row[]  = "Rp. ".number_format($p['laba'],0,",",".");;
                                

                                    $data_laba[]    = $row;
                                    $total_laba     = $p['laba'];
                                    // $this->session->set_userdata('total_saldo_umkm',$total_saldo);
                            // }
                        }

                    // echo $total_saldo;exit();
                    // $this->session->set_userdata('total_saldo_umkm',$total_saldo);
                    
                    # membuat output data nama kategori
                    # yang akan ditampilkan pada datatables
                    $output = array(
                        // 'draw'              => $_POST['draw'],
                        // 'recordsTotal'      => count($data_saldo),
                        // 'recordsFiltered'   => 10,
                        'data'              => $data_laba,
                        'total_laba'        => number_format($total_laba,0,",","."),
                    );

                    echo json_encode($output);


                }

            public function set_periode_laba_umkm()
                {
                    echo json_encode($this->input->post());

                    $awal   = $this->input->post('awal');
                    $akhir  = $this->input->post('akhir');

                    $cond_pemasukan     = "";
                    $cond_pengeluaran   = "";

                    if($awal != "" && $akhir != "")
                        {
                            if($awal == $akhir)
                                {
                                    $cond_pengeluaran   = "EXTRACT(YEAR FROM pengeluaran.add_time) ='".$awal."' ";
                                    $cond_pemasukan     = "EXTRACT(YEAR FROM pemasukan.add_time) ='".$awal."' ";
                                }
                            else 
                                {
                                    $cond_pengeluaran = "EXTRACT(YEAR FROM pengeluaran.add_time) BETWEEN '".$awal."'  AND '".$akhir."'";
                                    $cond_pemasukan   = "EXTRACT(YEAR FROM pemasukan.add_time) BETWEEN '".$awal."'  AND '".$akhir."'";
                                }
                        }
                    else if($awal != "" && $akhir == "")
                        {
                            $cond_pengeluaran = "EXTRACT(YEAR FROM pengeluaran.add_time) ='".$awal."' ";
                            $cond_pemasukan = "EXTRACT(YEAR FROM pemasukan.add_time) ='".$awal."' ";
                        }
                    else if($awal == "" && $akhir != "")
                        {
                            $cond_pengeluaran = "EXTRACT(YEAR FROM pengeluaran.add_time) ='".$akhir."' ";
                            $cond_pemasukan = "EXTRACT(YEAR FROM pemasukan.add_time) ='".$akhir."' ";
                        }
                    else 
                        {
                            $cond_pengeluaran = "";
                            $cond_pemasukan = "";
                        }

                    $this->session->set_userdata('cond_laba_pemasukan_umkm',$cond_pemasukan);
                    $this->session->set_userdata('cond_laba_pengeluaran_umkm',$cond_pengeluaran);
                }

            public function set_periode_laba()
                {
                    echo json_encode($this->input->post());

                    $awal   = $this->input->post('awal');
                    $akhir  = $this->input->post('akhir');

                    $cond_pemasukan     = "";
                    $cond_pengeluaran   = "";

                    if($awal != "" && $akhir != "")
                        {
                            if($awal == $akhir)
                                {
                                    $cond_pengeluaran   = "EXTRACT(YEAR FROM pengeluaran.add_time) ='".$awal."' ";
                                    $cond_pemasukan     = "EXTRACT(YEAR FROM pemasukan.add_time) ='".$awal."' ";
                                }
                            else 
                                {
                                    $cond_pengeluaran = "EXTRACT(YEAR FROM pengeluaran.add_time) BETWEEN '".$awal."'  AND '".$akhir."'";
                                    $cond_pemasukan   = "EXTRACT(YEAR FROM pemasukan.add_time) BETWEEN '".$awal."'  AND '".$akhir."'";
                                }
                        }
                    else if($awal != "" && $akhir == "")
                        {
                            $cond_pengeluaran = "EXTRACT(YEAR FROM pengeluaran.add_time) ='".$awal."' ";
                            $cond_pemasukan = "EXTRACT(YEAR FROM pemasukan.add_time) ='".$awal."' ";
                        }
                    else if($awal == "" && $akhir != "")
                        {
                            $cond_pengeluaran = "EXTRACT(YEAR FROM pengeluaran.add_time) ='".$akhir."' ";
                            $cond_pemasukan = "EXTRACT(YEAR FROM pemasukan.add_time) ='".$akhir."' ";
                        }
                    else 
                        {
                            $cond_pengeluaran = "";
                            $cond_pemasukan = "";
                        }

                    $this->session->set_userdata('cond_laba_pemasukan',$cond_pemasukan);
                    $this->session->set_userdata('cond_laba_pengeluaran',$cond_pengeluaran);
                }

            
                #

            public function get_summary_data()
                {
                    

                    $data_laba = array();

                    $data       = array();
                    $total_laba = 0;

                    if($this->session->userdata('cond_laba_pemasukan') != "" && $this->session->userdata('cond_laba_pengeluaran') != "")
                        {
                            $cond_pemasukan     = $this->session->userdata('cond_laba_pemasukan');
                            $cond_pengeluaran   = $this->session->userdata('cond_laba_pengeluaran');

                            $pemasukan          = $this->M_pemasukan->tampil_pemasukan()
                            ->where($cond_pemasukan)
                            ->order_by('pemasukan.add_time','asc')
                            ->get()
                            ->result();

                            // echo $this->db->last_query();exit();

                            $pengeluaran        = $this->M_pengeluaran->tampil_pengeluaran()
                            ->where($cond_pengeluaran)
                            ->order_by('pengeluaran.add_time','asc')->get()->result();
                        }
                    else 
                        {
                            $tahun      = date('Y');
                            $pemasukan = $this->M_pemasukan->tampil_pemasukan()->where(array(
                                "EXTRACT(YEAR FROM pemasukan.add_time) ='".$tahun."' "    => NULL,
                            ))->order_by('pemasukan.add_time','asc')->get()->result();

                            // echo $this->db->last_query();exit();

                            $pengeluaran = $this->M_pengeluaran->tampil_pengeluaran()->where(array(
                                "EXTRACT(YEAR FROM pengeluaran.add_time) ='".$tahun."' "    => NULL,
                            ))->order_by('pengeluaran.add_time','asc')->get()->result();
                        }


                    
                    

                    

                    foreach($pemasukan as $p)
                        {
                            
                            $bulan = date_format(date_create($p->add_time),'m');
                            $thn   = date_format(date_create($p->add_time),'Y');

                            if(!isset($data[$bulan.$thn.$p->id_umkm.$p->id_umkm]['modal']))
                                {
                                    $tgl_cari = $thn."-".$bulan."-01";
                                    $cari_modal     = $this->M_modal->tampil_log_modal()->where(array(
                                        'id_umkm'   => $p->id_umkm,
                                        "(add_time)::DATE < '".$tgl_cari."'::DATE" => NULL,
                                    ))->count_all_results();

                                    if($cari_modal > 0)
                                        {
                                            $modal =$this->M_modal->tampil_log_modal()
                                            ->where(array(
                                                'id_umkm'   => $p->id_umkm,
                                                "(add_time)::DATE < '".$tgl_cari."'::DATE" => NULL,
                                            ))->order_by('add_time','desc')->limit(1)->get()->row_array();

                                            $modal_awal = $modal['nominal'];
                                        }
                                    else 
                                        {
                                            $modal =$this->M_modal->tampil_log_modal()
                                            ->where(array(
                                                'id_umkm'   => $p->id_umkm,
                                            ))->get()->row_array();

                                            $modal_awal = $modal['nominal'];
                                        }

                                    $data[$bulan.$thn.$p->id_umkm]['modal']      = $modal_awal;
                                }
                            if(isset($data[$bulan.$thn.$p->id_umkm]['pemasukan']))
                                {
                                    $data[$bulan.$thn.$p->id_umkm]['pemasukan'] += $p->nominal;
                                } 
                            else 
                                {
                                    $data[$bulan.$thn.$p->id_umkm]['pemasukan'] = $p->nominal;
                                }

                            if(isset($data[$bulan.$thn.$p->id_umkm]['pengeluaran']))
                                {
                                    $laba = ($data[$bulan.$thn.$p->id_umkm]['modal'] + $data[$bulan.$thn.$p->id_umkm]['pemasukan']) - $data[$bulan.$thn.$p->id_umkm]['pengeluaran'];
                                }
                            else 
                                {
                                    $data[$bulan.$thn.$p->id_umkm]['pengeluaran'] = 0;
                                    $laba = $data[$bulan.$thn.$p->id_umkm]['modal'] + $data[$bulan.$thn.$p->id_umkm]['pemasukan'];
                                }
                            
                            $data[$bulan.$thn.$p->id_umkm]['laba'] = $laba;
                            $data[$bulan.$thn.$p->id_umkm]['bulan'] =$bulan."/".$thn;
                            $data[$bulan.$thn.$p->id_umkm]['nama_umkm'] = $p->nama_umkm;
                        }

                    foreach($pengeluaran as $p)
                        {
                            
                            $bulan = date_format(date_create($p->add_time),'m');
                            $thn   = date_format(date_create($p->add_time),'Y');

                            if(!isset($data[$bulan.$thn.$p->id_umkm]['modal']))
                                {
                                    $tgl_cari = $thn."-".$bulan."-01";
                                    $cari_modal     = $this->M_modal->tampil_log_modal()->where(array(
                                        'id_umkm'   => $p->id_umkm,
                                        "(add_time)::DATE < '".$tgl_cari."'::DATE" => NULL,
                                    ))->count_all_results();

                                    

                                    if($cari_modal > 0)
                                        {
                                            $modal =$this->M_modal->tampil_log_modal()
                                            ->where(array(
                                                'id_umkm'   => $p->id_umkm,
                                                "(add_time)::DATE < '".$tgl_cari."'::DATE" => NULL,
                                            ))->order_by('add_time','desc')->limit(1)->get()->row_array();

                                            // echo $this->db->last_query();exit();

                                            $modal_awal = $modal['nominal'];
                                        }
                                    else 
                                        {
                                            $modal =$this->M_modal->tampil_log_modal()
                                            ->where(array(
                                                'id_umkm'   => $p->id_umkm,
                                            ))->get()->row_array();

                                            $modal_awal = $modal['nominal'];
                                        }

                                    $data[$bulan.$thn.$p->id_umkm]['modal']      = $modal_awal;
                                }

                            if(isset($data[$bulan.$thn.$p->id_umkm]['pengeluaran']))
                                {
                                    $data[$bulan.$thn.$p->id_umkm]['pengeluaran'] += $p->nominal;
                                } 
                            else 
                                {
                                    $data[$bulan.$thn.$p->id_umkm]['pengeluaran'] = $p->nominal;
                                }

                            if(isset($data[$bulan.$thn.$p->id_umkm]['pemasukan']))
                                {
                                    $laba = ($data[$bulan.$thn.$p->id_umkm]['modal'] + $data[$bulan.$thn.$p->id_umkm]['pemasukan']) - $data[$bulan.$thn.$p->id_umkm]['pengeluaran'];
                                }
                            else 
                                {
                                    $data[$bulan.$thn.$p->id_umkm]['bulan'] =$bulan."/".$thn;
                                    $data[$bulan.$thn.$p->id_umkm]['pemasukan'] = 0;
                                    $laba = $data[$bulan.$thn.$p->id_umkm]['modal'] - $data[$bulan.$thn.$p->id_umkm]['pengeluaran'];
                                }

                            
                            $data[$bulan.$thn.$p->id_umkm]['nama_umkm'] = $p->nama_umkm;
                            $data[$bulan.$thn.$p->id_umkm]['laba'] = $laba;
                            
                        }

                    // echo json_encode($data);exit();

                    $no=0;
                    foreach($data as $key =>$p)
                        {
                            // foreach($value as $p)
                            // {
                                // $id = $->id_pemasukan;
                                // $status = $field->status;

                            
                        
                                    $no++;
                                    $row        = array();

                                    $row[]  = $no;
                                    $row[]  = $p['nama_umkm'];
                                    $row[]  = $p['modal'];
                                    // $row[]  = $p['modal'];
                                    
                                    $row[]  = "Rp.".number_format($p['pemasukan'],0,",",".");
                                    $row[]  = "Rp.".number_format($p['pengeluaran'],0,",",".");
                                    $row[]  = "Rp.".number_format($p['laba'],0,",",".");;
                                

                                    $data_laba[]    = $row;
                                    $total_laba     += $p['laba'];
                                    // $this->session->set_userdata('total_saldo_umkm',$total_saldo);
                            // }
                        }

                    // echo $total_saldo;exit();
                    // $this->session->set_userdata('total_saldo_umkm',$total_saldo);
                    
                    # membuat output data nama kategori
                    # yang akan ditampilkan pada datatables
                    $output = array(
                        // 'draw'              => $_POST['draw'],
                        // 'recordsTotal'      => count($data_saldo),
                        // 'recordsFiltered'   => 10,
                        'data'              => $data_laba,
                        'total_laba'        => number_format($total_laba,0,",","."),
                    );

                    echo json_encode($output);


                }
        }