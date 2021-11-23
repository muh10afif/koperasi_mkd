<?php 
    class Pegawai extends CI_Controller 
        {
            public function __construct()
                {
                    parent::__construct();
                    $this->load->model('M_pegawai');
                }

            public function index()
                {

                }


            public function tambah()
                {
                    $data = array(
                        'content'   => 'pegawai/tambah',
                        'judul'     => 'pegawai'
                    );

                    $this->load->view('layout/template',$data);
                }

            public function tambah_data_pegawai()
                {
                    // echo json_encode($this->input->post());exit();

                    $res = array();

                    $rules = array(
                        array(
                            'field'     => 'nama_pegawai',
                            'label'     => 'Nama Pegawai',
                            'rules'     => 'required',
                            'errors'    => array(
                                'required'  => 'Nama Pegawai tidak boleh kosong',
                            ),
                        ),

                        array(
                            'field'     => 'alamat',
                            'label'     => 'Alamat',
                            'rules'     => 'required',
                            'errors'    => array(
                                'required'  => 'Alamat Pegawai tidak boleh kosong',
                            ),
                        ),

                        array(
                            'field'     => 'no_telepon',
                            'label'     => 'No Telepon',
                            'rules'     => 'required',
                            'errors'    => array(
                                'required'  => 'No Telepon tidak boleh kosong',
                            ),
                        ),

                        array(
                            'field'     => 'nik',
                            'label'     => 'NIK',
                            'rules'     => 'required|is_unique[pegawai.nik]',
                            'errors'    => array(
                                'required'  => 'NIK Pegawai tidak boleh kosong',
                                'is_unique' => 'NIK sudah digunakan, silahkan gunakan nik lain'
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

                    $data = array(
                        'nama_pegawai'      => $this->input->post('nama_pegawai'),
                        'nik'               => $this->input->post('nik'),
                        'no_telp'           => $this->input->post('no_telepon'),
                        'alamat'            => $this->input->post('alamat'),
                        'status'            => 1,
                        'add_time'          => date('Y-m-d H:i:s'),
                    );


                    $tambah = $this->M_pegawai->tambah_pegawai($data);

                    if($tambah)
                        {
                            $res['status_tambah']   = "ok";
                        }
                    else 
                        {
                            $res['status_tambah']   = "not ok";
                        }

                    echo json_encode($res);


                }


            public function get_pegawai()
                {
                
                
                    $list_gagal = $this->M_pegawai->get_datatables();
                    $data = array();
                    $no = $_POST['start'];

                    # membuat list data nama kategori yang akan di generate
                    # ke datatables
                    foreach($list_gagal as $field)
                        {
                            $id = $field->id_pegawai;
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
                            
                            $row[]  = $field->alamat;
                            $row[]  = $field->no_telp;
                            $row[]  = $field->nik;
                            $row[]  = $stat;
                            $row[]  = $aksi;
                            // $row[]  = '<button class="btn btn-sm btn-primary" onclick="detail(\''.$id.'\')">Lihat</button>';
                            // $row[]  = '<button onclick="edit(\''.$id.'\')" class="btn btn-success btn-sm"><i class="fa fa-pencil-alt"></i></button>&nbsp;&nbsp;<button onclick="hapus(\''.$id.'\')" class="btn btn-danger btn-sm"><i class="fa fa-trash"></i></button>';

                            $data[] = $row;
                        }
                    
                    # membuat output data nama kategori
                    # yang akan ditampilkan pada datatables
                    $output = array(
                        'draw'              => $_POST['draw'],
                        'recordsTotal'      => $this->M_pegawai->count_all(),
                        'recordsFiltered'   => $this->M_pegawai->count_filtered(),
                        'data'              => $data,
                    );

                    # tampilkan data nama kategori berupa format JSON
                    echo json_encode($output);
                
                }

            public function show_pegawai()
                {
                    $id_pegawai = $this->input->post('id_pegawai');

                    $pegawai = $this->M_pegawai->tampil_pegawai()->where(array(
                        'id_pegawai'    => $id_pegawai,
                    ))->get()->row_array();


                    echo json_encode($pegawai);
                }

            public function update_pegawai()
                {
                    // echo json_encode($this->input->post());exit();

                    $res = array();

                    $rules = array(

                         array(
                            'field'     => 'id_pegawai',
                            'label'     => 'ID Pegawai',
                            'rules'     => 'required',
                            'errors'    => array(
                                'required'  => 'Data Pegawai tidak ditemukan',
                            ),
                        ),

                        array(
                            'field'     => 'nama_pegawai',
                            'label'     => 'Nama Pegawai',
                            'rules'     => 'required',
                            'errors'    => array(
                                'required'  => 'Nama Pegawai tidak boleh kosong',
                            ),
                        ),

                        array(
                            'field'     => 'alamat',
                            'label'     => 'Alamat',
                            'rules'     => 'required',
                            'errors'    => array(
                                'required'  => 'Alamat Pegawai tidak boleh kosong',
                            ),
                        ),

                        array(
                            'field'     => 'no_telepon',
                            'label'     => 'No Telepon',
                            'rules'     => 'required',
                            'errors'    => array(
                                'required'  => 'No Telepon tidak boleh kosong',
                            ),
                        ),

                        array(
                            'field'     => 'nik',
                            'label'     => 'NIK',
                            'rules'     => 'required',
                            'errors'    => array(
                                'required'  => 'NIK Pegawai tidak boleh kosong',
                            ),
                        ),
                    );

                    $this->form_validation->set_rules($rules);

                    if($this->form_validation->run() == false)
                        {
                            $res['status_update']   = "gagal";
                            $res['error']           = $this->form_validation->error_array();
                            echo json_encode($res);
                            exit();
                        }

                    $data = array(
                        'nama_pegawai'      => $this->input->post('nama_pegawai'),
                        'nik'               => $this->input->post('nik'),
                        'no_telp'           => $this->input->post('no_telepon'),
                        'alamat'            => $this->input->post('alamat'),
                    );

                    $cond = array(
                        'id_pegawai'        => $this->input->post('id_pegawai'),
                    );

                    $update = $this->M_pegawai->update_pegawai($cond,$data);

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

            # aktifasi umkm
            public function pegawai_aktif()
                {
                    $res    = array();

                    $data_pegawai = array(
                        'status'    => 1,
                    );

                    $cond       = array(
                        'id_pegawai'       => $this->input->post('id_pegawai'),
                    );

                    $update_data = $this->M_pegawai->update_pegawai($cond,$data_pegawai);

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

            # non aktifkan umkm
            public function pegawai_non_aktif()
                {
                    $res    = array();

                    $data_pegawai = array(
                        'status'    => 0,
                    );

                    $cond       = array(
                        'id_pegawai'       => $this->input->post('id_pegawai'),
                    );

                    $update_data = $this->M_pegawai->update_pegawai($cond,$data_pegawai);

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