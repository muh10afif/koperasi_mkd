<?php 
    class Penempatan extends CI_COntroller 
        {
            public function __construct()
                {
                    parent::__construct();
                    $this->load->model('M_penempatan');
                    $this->load->model('M_umkm');
                    $this->load->model('M_pegawai');
                }

            public function index()
                {
                    $data = array(
                        'content'   => 'penempatan/tambah',
                        'pegawai'   => $this->M_pegawai->pegawai_nontempat(),
                        'umkm'      => $this->M_umkm->tampil_umkm()->where(array('status'=> 1))->get()->result(),
                        'judul'     => 'penempatan'
                    );

                    $this->load->view('layout/template',$data);
                }

            public function tambah_penempatan()
                {
                    // echo json_encode($this->input->post());exit();

                    $res = array();

                    $rules = array(
                        array(
                            'field'     => 'pegawai',
                            'label'     => 'Pegawai',
                            'rules'     => 'required',
                            'errors'    => array(
                                'required'  => 'Silahkan pilih pegawai terlebih dahulu',
                            ),
                        ),

                        array(
                            'field'     => 'umkm',
                            'label'     => 'UMKM',
                            'rules'     => 'required',
                            'errors'    => array(
                                'required'  => 'Silahkan pilih UMKM terlebih dahulu',
                            ),
                        ),
                    );

                    $this->form_validation->set_rules($rules);

                    if($this->form_validation->run() == false)
                        {
                            $res['status_tambah']  = "gagal";
                            $res['error']           = $this->form_validation->error_array();
                            echo json_encode($res);
                            exit();
                        }

                    $data = array(
                        'id_pegawai'    => $this->input->post('pegawai'),
                        'id_umkm'       => $this->input->post('umkm'),
                        'status'        => 1,
                        'add_time'      => date('Y-m-d H:i:s'),          
                    );

                    $tambah = $this->M_penempatan->tambah_penempatan($data);

                    if($tambah)
                        {
                            $res['status_tambah'] = "ok";
                        }
                    else 
                        {
                            $res['status_tambah'] = "not ok";
                        }

                    echo json_encode($res);
                }


            public function get_penempatan()
                {
                
                
                    $list_gagal = $this->M_penempatan->get_datatables();
                    $data = array();
                    $no = $_POST['start'];

                    # membuat list data nama kategori yang akan di generate
                    # ke datatables
                    foreach($list_gagal as $field)
                        {
                            $id = $field->id_penempatan;
                            $status = $field->status;

                            if($status == 1)
                                {
                                    $stat = "<button type='button' class='btn btn-success btn-sm'>Aktif</button>";
                                    $aksi = '<button title="Non Aktif" onclick="nonaktif(\''.$id.'\')" class="btn btn-danger btn-sm"><i class="fa fa-window-close"></i></button>&nbsp;&nbsp;<button onclick="edit(\''.$id.'\')" class="btn btn-success btn-sm"><i class="fa fa-pencil"></i></button>';
                                    
                                }
                            else 
                                {
                                    $stat = "<button type='button' class='btn btn-danger btn-sm'>Tidak Aktif</button>";
                                    $aksi = '<button title="Aktif" onclick="aktif(\''.$id.'\')" class="btn btn-success btn-sm"><i class="fa fa-check"></i></button>&nbsp;&nbsp;<button onclick="edit(\''.$id.'\')" class="btn btn-success btn-sm"><i class="fa fa-pencil"></i></button>';
                                }
                        
                            $no++;
                            $row        = array();

                            $row[]  = $no;
                            $row[]  = $field->nama_pegawai;
                            
                            $row[]  = $field->nama_umkm;
                        
                            $row[]  = $stat;
                            $row[]  = $aksi;
                            // $row[]  = '<button class="btn btn-sm btn-primary" onclick="detail(\''.$id.'\')">Lihat</button>';
                            // $row[]  = '<button onclick="edit(\''.$id.'\')" class="btn btn-success btn-sm"><i class="fa fa-pencil"></i></button>&nbsp;&nbsp;<button onclick="hapus(\''.$id.'\')" class="btn btn-danger btn-sm"><i class="fa fa-trash"></i></button>';

                            $data[] = $row;
                        }
                    
                    # membuat output data nama kategori
                    # yang akan ditampilkan pada datatables
                    $output = array(
                        'draw'              => $_POST['draw'],
                        'recordsTotal'      => $this->M_penempatan->count_all(),
                        'recordsFiltered'   => $this->M_penempatan->count_filtered(),
                        'data'              => $data,
                    );

                    # tampilkan data nama kategori berupa format JSON
                    echo json_encode($output);
                
                }

            public function show_penempatan()
                {
                    $id_penempatan = $this->input->post('id_penempatan');

                    $penempatan = $this->M_penempatan->tampil_penempatan()->where(array(
                        'penempatan.id_penempatan'  => $id_penempatan
                    ))->get()->row_array();

                    echo json_encode($penempatan);
                }

            public function get_pegawainon_tempat()
                {
                    $pegawai = $this->M_pegawai->pegawai_nontempat();

                    foreach($pegawai as $p)
                        {
                            $option = "<option value='".$p->id_pegawai."'>".$p->nama_pegawai."</option>";
                        }

                    echo $option;
                }

            public function update_penempatan()
                {
                    // echo json_encode($this->input->post());exit();

                    $res = array();


                    $rules = array(

                        array(
                            'field'     => 'id_penempatan',
                            'label'     => 'ID Penempatan',
                            'rules'     => 'required',
                            'errors'    => array(
                                'required'  => 'Data Penempatan tidak ditemukan',
                            ),
                        ),
                        array(
                            'field'     => 'pegawai',
                            'label'     => 'Pegawai',
                            'rules'     => 'required',
                            'errors'    => array(
                                'required'  => 'Silahkan pilih pegawai terlebih dahulu',
                            ),
                        ),

                        array(
                            'field'     => 'umkm',
                            'label'     => 'UMKM',
                            'rules'     => 'required',
                            'errors'    => array(
                                'required'  => 'Silahkan pilih UMKM terlebih dahulu',
                            ),
                        ),
                    );

                    $this->form_validation->set_rules($rules);

                    if($this->form_validation->run() == false)
                        {
                            $res['status_update']  = "gagal";
                            $res['error']           = $this->form_validation->error_array();
                            echo json_encode($res);
                            exit();
                        }

                    $data = array(
                        'id_pegawai'    => $this->input->post('pegawai'),
                        'id_umkm'       => $this->input->post('umkm'),        
                    );

                    $cond = array(
                        'id_penempatan' => $this->input->post('id_penempatan'),
                    );

                    $update = $this->M_penempatan->update_penempatan($cond,$data);

                    if($update)
                        {
                            $res['status_update']   = "ok";
                        }
                    else
                        {
                            $res['status_update']   = "not ok";
                        }

                    echo json_encode($res);

                }

            
            public function penempatan_aktif()
                {
                    $res    = array();

                    $data = array(
                        'status'    => 1,
                    );

                    $cond       = array(
                        'id_penempatan'       => $this->input->post('id_penempatan'),
                    );

                    $update_data = $this->M_penempatan->update_penempatan($cond,$data);

                    if($update_data)
                        {
                            $res['status'] = "ok";
                        }
                    else 
                        {
                            $res['status'] = "not ok";
                        }

                    echo json_encode($res);
                }

            public function penempatan_non_aktif()
                {
                    $res    = array();

                    $data = array(
                        'status'    => 0,
                    );

                    $cond       = array(
                        'id_penempatan'       => $this->input->post('id_penempatan'),
                    );

                    $update_data = $this->M_penempatan->update_penempatan($cond,$data);

                    if($update_data)
                        {
                            $res['status'] = "ok";
                        }
                    else 
                        {
                            $res['status'] = "not ok";
                        }

                    echo json_encode($res);
                }
        }