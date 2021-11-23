<?php 
    class Pemasukan extends CI_Controller 
        {
            public function __construct()
                {   
                    parent::__construct();
                    $this->load->model('M_pemasukan');
                    $this->load->model('M_modal');
                }

            public function index()
            {
                $dt = [ 'id_umkm'   => 'a',
                        'tgl_awal'  => '',
                        'tgl_akhir' => ''
                    ];

                $hasil = $this->M_pemasukan->get_total_pemasukan($dt)->row_array();

                $data = array(
                    'content'           => 'pemasukan/index',
                    'umkm'              => $this->M_pemasukan->get_umkm_pemasukan()->result_array(),
                    'tot_pemasukan'     => number_format($hasil['tot_nominal'], '2', ',', '.'),
                    'judul'             => 'pemasukan'
                );

                $this->load->view('layout/template',$data);
            }
            
            public function pemasukan_umkm()
            {
                $id_umkm= $this->session->userdata('umkm');

                $dt = [ 'id_umkm'   => $id_umkm,
                        'tgl_awal'  => '',
                        'tgl_akhir' => ''
                    ];

                $hasil = $this->M_pemasukan->get_total_pemasukan($dt)->row_array();

                $data = array(
                    'content'           => 'umkm/pemasukan_umkm',
                    'id_umkm'           => $id_umkm,
                    'tot_pemasukan'     => number_format($hasil['tot_nominal'], '2', ',', '.'),
                    'judul'             => 'pemasukan'
                );

                $this->load->view('layout/template',$data);
            }

            public function tambah_data_pemasukan_umkm()
                {
                    // echo json_encode($this->input->post());exit();

                    $res = array();

                    $rules = array(
                        array(
                            'field'     => 'id_umkm',
                            'label'     => 'ID UMKM',
                            'rules'     => 'required',
                            'errors'    => array(
                                'required'      => 'UMKM tidak ditemukan',
                            ),
                        ),
                        array(
                            'field'     => 'nominal',
                            'label'     => 'Nominal',
                            'rules'     => 'required',
                            'errors'    => array(
                                'required'      => 'Nominal tidak boleh kosong',
                            ),
                        ),

                    );

                    $this->form_validation->set_rules($rules);

                    if($this->form_validation->run() == false)
                        {
                            $res['status_tambah']   = "gagal";
                            $res['error']           = $this->form_validation->error_array();
                            echo json_encode($res);
                            exit();
                        }

                    $modal = $this->M_modal->tampil_log_modal()->where(array(
                        'id_umkm'   => $this->input->post('id_umkm'),
                    ))->order_by('id_log_modal','desc')->limit(1)->get()->row_array();


                    $jumlah_modal = $modal['nominal'];
                    $saldo        = $jumlah_modal + $this->input->post('nominal');
                    $data = array(
                        'id_umkm'   => $this->input->post('id_umkm'),
                        'nominal'   => $this->input->post('nominal'),
                        'add_time'  => date('Y-m-d H:i:s'),
                        'saldo'     => $saldo,
                    );
                    $tgl = date('Y-m-d');

                    $cond = array(
                        'pemasukan.id_umkm' => $this->input->post('id_umkm'),
                        "(pemasukan.add_time)::DATE='".$tgl."'" => NULL,
                    );

                    $jumlah = $this->M_pemasukan->tampil_pemasukan()->where($cond)->count_all_results();
                    $this->db->trans_start();
                        if($jumlah == 0)
                            {
                                $this->M_pemasukan->tambah_pemasukan($data);
                            }
                        else 
                            {
                                $data = $this->M_pemasukan->tampil_pemasukan()->where($cond)->get()->row_array();
                                $this->M_pemasukan->update_pemasukan($cond,array(
                                    'nominal'   => $this->input->post('nominal') + $data['nominal'],
                                    'add_time'  => date('Y-m-d H:i:s'),
                                    'saldo'     => $saldo,
                                ));
                            }
                        $this->M_modal->tambah_log_modal(array(
                            'nominal'   => $saldo,
                            'status'    => 1,
                            'id_umkm'   => $this->input->post('id_umkm'),
                        ));
                    $this->db->trans_complete();

                    // $tambah = $this->M_pemasukan->tambah_pemasukan($data);

                    if($this->db->trans_status() === FALSE)
                        {
                            $res['status_tambah'] = "not ok";
                            $this->db->trans_rollback();
                        }
                    else 
                        {
                            $res['status_tambah'] = "ok";
                        }
                    
                    echo json_encode($res);
                }

            public function get_pemasukan_umkm()
                {
                
                
                    $list_gagal = $this->M_pemasukan->get_datatables_umkm();
                    $data = array();
                    $no = $_POST['start'];

                    # membuat list data nama kategori yang akan di generate
                    # ke datatables
                    foreach($list_gagal as $field)
                        {
                            $id = $field->id_pemasukan;
                            // $status = $field->status;

                            
                        
                            $no++;
                            $row        = array();

                            $row[]  = $no;
                            $row[]  = date_format(date_create($field->add_time),'d-m-Y');
                            
                            $row[]  = "Rp. ".number_format($field->nominal,0,",",".");
                            // $row[]  = $field->no_telp;
                            // $row[]  = $field->nik;
                            // $row[]  = $stat;
                            // $row[]  = $aksi;
                            // $row[]  = '<button class="btn btn-sm btn-primary" onclick="detail(\''.$id.'\')">Lihat</button>';
                            // $row[]  = '<button onclick="edit(\''.$id.'\')" class="btn btn-success btn-sm"><i class="fa fa-pencil-alt"></i></button>&nbsp;&nbsp;<button onclick="hapus(\''.$id.'\')" class="btn btn-danger btn-sm"><i class="fa fa-trash"></i></button>';

                            $data[] = $row;
                        }
                    
                    # membuat output data nama kategori
                    # yang akan ditampilkan pada datatables
                    $output = array(
                        'draw'              => $_POST['draw'],
                        'recordsTotal'      => $this->M_pemasukan->count_all_umkm(),
                        'recordsFiltered'   => $this->M_pemasukan->count_filtered_umkm(),
                        'data'              => $data,
                    );

                    # tampilkan data nama kategori berupa format JSON
                    echo json_encode($output);
                
                }

            

            # set periode umkm
            public function set_periode_umkm()
                {
                    // echo json_encode($this->input->post());exit();

                    $awal   = $this->input->post('awal');
                    $akhir  = $this->input->post('akhir');
                    
                    
                    $cond = "";

                    if($awal != "" && $akhir != "")
                        {
                            $cond = " (add_time)::DATE BETWEEN '".$awal."'::DATE AND '".$akhir."'::DATE";
                        }
                    else if($awal != "" && $akhir == "")
                        {
                            $cond = "(add_time)::DATE ='".$awal."'::DATE";
                        }
                    else if($awal == "" && $akhir != "")
                        {
                            $cond = "(add_time)::DATE ='".$akhir."'::DATE";
                        }
                    else 
                        {
                            $cond = "";
                        }

                    $this->session->set_userdata('cond_pemasukan_umkm',$cond);
                }

            # get total pemasukan umkm
            public function get_total_pemasukan_umkm()
                {
                    $pemasukan = $this->M_pemasukan->total_pemasukan_umkm()->get()->row_array();

                    echo $pemasukan['total'];
                }

            


            # get pemasukan (admin)
            public function get_pemasukan()
                {
                    $dt = [ 'id_umkm'   => $this->input->post('id_umkm'),
                            'tgl_awal'  => $this->input->post('tgl_awal'),
                            'tgl_akhir' => $this->input->post('tgl_akhir')
                        ];
                
                    $list = $this->M_pemasukan->get_datatables($dt);

                    $total_pemasukan = 0;

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
                            $row[]  = $field->penjualan;
                            $row[]  = $field->jumlah;
                            $row[]  = "Rp. ".number_format($field->nominal,2,",",".");

                            $data[] = $row;
                            $total_pemasukan += $field->nominal;
                        }

                    $output = array(
                        'draw'              => $_POST['draw'],
                        'recordsTotal'      => $this->M_pemasukan->count_all($dt),
                        'recordsFiltered'   => $this->M_pemasukan->count_filtered($dt),
                        'data'              => $data,
                    );

                    echo json_encode($output);
                }

            // ambil total pemasukan
            public function ambil_total_pemasukan()
            {
                $dt = [ 'id_umkm'   => $this->input->post('id_umkm'),
                        'tgl_awal'  => $this->input->post('tgl_awal'),
                        'tgl_akhir' => $this->input->post('tgl_akhir')
                    ];

                $hasil = $this->M_pemasukan->get_total_pemasukan($dt)->row_array();

                echo json_encode(['total_pemasukan' => number_format($hasil['tot_nominal'], '2', ',', '.')]);
            }

            # set periode (admin)
            public function set_periode()
                {
                    // echo json_encode($this->input->post());exit();

                    $awal   = $this->input->post('awal');
                    $akhir  = $this->input->post('akhir');
                    
                    
                    $cond = "";

                    if($awal != "" && $akhir != "")
                        {
                            $cond = " (pemasukan.add_time)::DATE BETWEEN '".$awal."'::DATE AND '".$akhir."'::DATE";
                        }
                    else if($awal != "" && $akhir == "")
                        {
                            $cond = "(pemasukan.add_time)::DATE ='".$awal."'::DATE";
                        }
                    else if($awal == "" && $akhir != "")
                        {
                            $cond = "(pemasukan.add_time)::DATE ='".$akhir."'::DATE";
                        }
                    else 
                        {
                            $cond = "";
                        }

                    $this->session->set_userdata('cond_pemasukan',$cond);
                }

            public function get_total()
                {
                    $pemasukan = $this->M_pemasukan->total_pemasukan();
                    // echo $this->db->last_query();exit();

                    // echo $this->session->userdata('cond_pemasukan');exit();

                    echo number_format($pemasukan['total'],0,",",".");
                }
        }