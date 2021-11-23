<?php 
    class Pengeluaran extends CI_Controller 
        {
            public function __construct()
                {
                    parent::__construct();
                    $this->load->model('M_pengeluaran');
                    $this->load->model('M_modal');
                    
                }

            public function index()
                {
                    $dt = [ 'id_umkm'   => 'a',
                            'tgl_awal'  => '',
                            'tgl_akhir' => ''
                        ];

                    $hasil = $this->M_pengeluaran->get_total_pengeluaran($dt)->row_array();

                    $data = array(
                        'content'           => 'pengeluaran/index',
                        'umkm'              => $this->M_pengeluaran->get_umkm_pengeluaran()->result_array(),
                        'tot_pengeluaran'   => number_format($hasil['tot_nominal'], '2', ',', '.'),
                        'judul'             => 'pengeluaran'
                    );

                    $this->load->view('layout/template',$data);
                }

            public function pengeluaran_umkm()
                {
                    $id_umkm= $this->session->userdata('umkm');

                    $dt = [ 'id_umkm'   => $id_umkm,
                            'tgl_awal'  => '',
                            'tgl_akhir' => ''
                        ];

                    $hasil = $this->M_pengeluaran->get_total_pengeluaran($dt)->row_array();

                    $data = array(
                        'content'   => 'umkm/pengeluaran_umkm',
                        'id_umkm'           => $id_umkm,
                        'tot_pengeluaran'   => number_format($hasil['tot_nominal'], '2', ',', '.'),
                        'judul'             => 'pengeluaran'
                    );

                    $this->load->view('layout/template',$data);
                }

            public function tambah_data_pengeluaran_umkm()
                {
                    // echo json_encode($this->input->post());exit();

                    $res = array();

                    $rules = array(
                        array(
                            'field'     => 'id_umkm',
                            'label'     => 'id umkm',
                            'rules'     => 'required',
                            'errors'    => array(
                                'required'  => 'UMKM tidak ditemukan'
                            ),
                        ),

                        array(
                            'field'     => 'nominal',
                            'label'     => 'nominal',
                            'rules'     => 'required',
                            'errors'    => array(
                                'required'  => 'nominal tidak boleh kosong'
                            ),
                        ),

                    );

                    $this->form_validation->set_rules($rules);

                    if($this->form_validation->run() == false)
                        {
                            $res['status_tambah']   = "gagal";
                            $res['error']           = $this->form_validation->error_array();
                            echo json_encode($res);exit();
                        }

                    $modal = $this->M_modal->tampil_log_modal()->where(array(
                        'id_umkm'   => $this->input->post('id_umkm'),
                    ))->order_by('id_log_modal','desc')->limit(1)->get()->row_array();

                    $jumlah_modal = $modal['nominal'];
                    $saldo        = $jumlah_modal - $this->input->post('nominal');


                    $data = array(
                        'id_umkm'       => $this->input->post('id_umkm'),
                        'nominal'       => $this->input->post('nominal'),
                        'add_by'        => $this->session->userdata('id_pegawai'),
                        'add_time'      => date('Y-m-d H:i:s'),
                        'saldo'         => $saldo
                    );
                    $tgl = date('Y-m-d');

                    $cond = array(
                        'pengeluaran.id_umkm' => $this->input->post('id_umkm'),
                        "(pengeluaran.add_time)::DATE='".$tgl."'" => NULL,
                    );

                    $jumlah = $this->M_pengeluaran->tampil_pengeluaran()->where($cond)->count_all_results();
                    $this->db->trans_start();

                    if($jumlah == 0)
                        {
                            $this->M_pengeluaran->tambah_pengeluaran($data);
                        }
                    else 
                        {
                            $data = $this->M_pengeluaran->tampil_pengeluaran()->where($cond)->get()->row_array();
                            $this->M_pengeluaran->update_pengeluaran($cond,array(
                                'nominal'   => $this->input->post('nominal') + $data['nominal'],
                                'add_time'  => date('Y-m-d H:i:s'),
                                'saldo'     => $saldo,
                            ));
                        }

                    // $this->M_pengeluaran->tambah_pengeluaran($data);
                    $this->M_modal->tambah_log_modal(array(
                            'nominal'   => $saldo,
                            'status'    => 1,
                            'id_umkm'   => $this->input->post('id_umkm'),
                        ));

                    $this->db->trans_complete();

                    // $tambah = $this->M_pengeluaran->tambah_pengeluaran($data);

                    if($this->db->trans_status() === FALSE)
                        {
                            $res['status_tambah']   = "not ok";
                            $this->db->trans_rollback();
                        }
                    else 
                        {
                            $res['status_tambah']   = "ok";
                        }

                    echo json_encode($res);
                }

            public function set_periode_umkm()
                {
                    // echo json_encode($this->input->post());exit();

                    $awal = $this->input->post('awal');
                    $akhir = $this->input->post('akhir');

                    $cond = "";

                    

                    if($awal != "" && $akhir != "")
                        {
                            if($awal == $akhir)
                                {
                                    $cond = "(add_time)::DATE = '".$awal."'::DATE";
                                }
                            else 
                                {
                                    $cond = "(add_time)::DATE BETWEEN '".$awal."'::DATE AND '".$akhir."'::DATE";
                                }
                            
                        }
                    else if($awal != "" && $akhir == "")
                        {
                            $cond = "(add_time)::DATE = '".$awal."'::DATE";
                        }
                    else if($awal == "" && $akhir != "")
                        {
                            $cond = "(add_time)::DATE = '".$akhir."'::DATE";
                        }
                    else 
                        {
                            $cond = "";
                        }

                    $this->session->set_userdata('cond_pengeluaran_umkm',$cond);
                    
                }

            public function set_periode()
                {
                    // echo json_encode($this->input->post());exit();

                    $awal = $this->input->post('awal');
                    $akhir = $this->input->post('akhir');

                    $cond = "";

                    

                    if($awal != "" && $akhir != "")
                        {
                            if($awal == $akhir)
                                {
                                    $cond = "(pengeluaran.add_time)::DATE = '".$awal."'::DATE";
                                }
                            else 
                                {
                                    $cond = "(pengeluaran.add_time)::DATE BETWEEN '".$awal."'::DATE AND '".$akhir."'::DATE";
                                }
                            
                        }
                    else if($awal != "" && $akhir == "")
                        {
                            $cond = "(pengeluaran.add_time)::DATE = '".$awal."'::DATE";
                        }
                    else if($awal == "" && $akhir != "")
                        {
                            $cond = "(pengeluaran.add_time)::DATE = '".$akhir."'::DATE";
                        }
                    else 
                        {
                            $cond = "";
                        }

                    $this->session->set_userdata('cond_pengeluaran',$cond);
                    
                }

            # get total pemasukan umkm
            public function get_total_pengeluaran_umkm()
                {
                    $pemasukan = $this->M_pengeluaran->total_pengeluaran_umkm()->get()->row_array();

                    echo number_format($pemasukan['total'],0,",",".");
                }

            # get total pemasukan umkm
            public function get_total_pengeluaran()
                {
                    $pemasukan = $this->M_pengeluaran->total_pengeluaran()->get()->row_array();

                    echo number_format($pemasukan['total'],0,",",".");
                }

            
            public function get_pengeluaran_umkm()
                {
                
                
                    $list_gagal = $this->M_pengeluaran->get_datatables_umkm();
                    $data = array();
                    $no = $_POST['start'];

                    # membuat list data nama kategori yang akan di generate
                    # ke datatables
                    foreach($list_gagal as $field)
                        {
                            $id = $field->id_pengeluaran;
                            // $status = $field->status;

                            
                        
                            $no++;
                            $row        = array();

                            $row[]  = $no;
                            $row[]  = date_format(date_create($field->add_time),'d-m-Y');
                            
                            $row[]  = "Rp. ".number_format($field->nominal,0,",",".");
                            

                            $data[] = $row;
                        }
                    
                    # membuat output data nama kategori
                    # yang akan ditampilkan pada datatables
                    $output = array(
                        'draw'              => $_POST['draw'],
                        'recordsTotal'      => $this->M_pengeluaran->count_all_umkm(),
                        'recordsFiltered'   => $this->M_pengeluaran->count_filtered_umkm(),
                        'data'              => $data,
                    );

                    # tampilkan data nama kategori berupa format JSON
                    echo json_encode($output);
                
                }

            public function get_pengeluaran()
                {
                    $dt = [ 'id_umkm'   => $this->input->post('id_umkm'),
                            'tgl_awal'  => $this->input->post('tgl_awal'),
                            'tgl_akhir' => $this->input->post('tgl_akhir')
                        ];
                
                    $list = $this->M_pengeluaran->get_datatables($dt);
                    $data = array();
                    $no = $_POST['start'];

                    foreach($list as $field)
                    {
                        $no++;
                        $row        = array();

                        $row[]  = $no;
                        if ($this->session->userdata('umkm') == '') {
                            $row[]  = $field->nama_umkm;
                        }
                        $row[]  = date_format(date_create($field->add_time),'d-M-Y');
                        $row[]  = $field->pembelian;
                        $row[]  = $field->jumlah;
                        $row[]  = "Rp. ".number_format($field->nominal,0,",",".");
                    
                        $data[] = $row;
                    }
                    
                    $output = array(
                        'draw'              => $_POST['draw'],
                        'recordsTotal'      => $this->M_pengeluaran->count_all($dt),
                        'recordsFiltered'   => $this->M_pengeluaran->count_filtered($dt),
                        'data'              => $data,
                    );

                    echo json_encode($output);
                
                }

            // ambil total pengeluaran
            public function ambil_total_pengeluaran()
            {
                $dt = [ 'id_umkm'   => $this->input->post('id_umkm'),
                        'tgl_awal'  => $this->input->post('tgl_awal'),
                        'tgl_akhir' => $this->input->post('tgl_akhir')
                    ];

                $hasil = $this->M_pengeluaran->get_total_pengeluaran($dt)->row_array();

                echo json_encode(['total_pengeluaran' => number_format($hasil['tot_nominal'], '2', ',', '.')]);
            }
        }