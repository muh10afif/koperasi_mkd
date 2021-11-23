<?php 
    class Umkm extends CI_Controller 
        {
            public function __construct()
                {
                    parent::__construct();
                    $this->load->model('M_umkm');
                    $this->load->model('M_modal');
                    
                }

            public function index()
                {

                }


            public function tambah()
                {
                    $data = array(
                        'content'   => 'umkm/tambah',
                        'judul'     => 'umkm'
                    );

                    $this->load->view('layout/template',$data);
                }

            
            public function tambah_data_umkm()
                {
                    // echo json_encode($this->input->post());exit();

                    $res    = array();
                    
                    $rules  = array(
                        array(
                            'field'     => 'nama_umkm',
                            'label'     => 'Nama UMKM',
                            'rules'     => 'required',
                            'errors'    => array(
                                'required'  => 'Nama umkm tidak boleh kosong',
                            ),
                        ), 
                        array(
                            'field'     => 'nominal',
                            'label'     => 'Modal',
                            'rules'     => 'required',
                            'errors'    => array(
                                'required'  => 'Modal tidak boleh kosong',
                            ),
                        ),

                        array(
                            'field'     => 'jenis',
                            'label'     => 'Jenis Dagangan',
                            'rules'     => 'required',
                            'errors'    => array(
                                'required'      => 'Jenis dAGANGAN tidak boleh kosong',
                            ),
                        ),

                        array(
                            'field'     => 'no',
                            'label'     => 'No Kios',
                            'rules'     =>'required',
                            'errors'    => array(
                                'required'  => 'nO kIOS tidak boleh kosong',
                            ),
                        ),

                        array(
                            'field'     => 'alamat',
                            'label'     => 'Alamat',
                            'rules'     => 'required',
                            'errors'    => array(
                                'required'  => 'Alamat tidak boleh kosong'
                            ),
                        ),

                        array(
                            'field'     => 'link_foto',
                            'label'     => 'Foto',
                            'rules'     => 'required',
                            'errors'    => array(
                                'required'  => 'silahkan upload foto terlebih dahulu'
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

                    $data_umkm = array(
                        'nama_umkm'     => $this->input->post('nama_umkm'),
                        'modal_awal'     => $this->input->post('nominal'),
                        'alamat'        => $this->input->post('alamat'),
                        'jenis_dagangan'           => $this->input->post('jenis'),
                        'no_kios'          => $this->input->post('no'),
                        'foto'          => $this->input->post('link_foto'),
                        'status'        => 1,
                        'add_time'      => date('Y-m-d H:i:s'),
                    );

                    $this->db->trans_start();

                    $this->M_umkm->tambah_umkm($data_umkm);
                    $insert_id = $this->db->insert_id();

                    $this->M_modal->tambah_log_modal(array(
                        'nominal'   => $this->input->post('nominal'),
                        'status'    => 1,
                        'id_umkm'   => $insert_id,
                        'add_time'  => date('Y-m-d H:i:s'),
                    ));

                    $this->db->trans_complete();

                    

                    if($this->db->trans_status() == FALSE)
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

            public function upload()
                {
                    # set nama foto yg diupload agar tidak ada spasi 
                    $name = explode(' ',$_FILES['foto_umkm']['name']);
                
                    // echo json_encode($_FILES['foto_masjid']);exit();
                   // echo pathinfo($_FILES['file_upload']['name'],PATHINFO_EXTENSION);exit();
                    // $size = getimagesize($_FILES['foto_masjid']['tmp_name']);
                    // list($width, $height) = getimagesize($_FILES['foto_masjid']['tmp_name']);
                    // var_dump($width);
                    // echo "<br>";
                    // var_dump($height);
                    // exit();
                    // echo json_encode($);exit();
                    $name_upload ='';

                    
                    foreach($name as $key => $value)
                        {
                            $name_upload .= $value;
                        }

                    # set config untuk data upload foto ke sistem
                    $config = array(
                        'upload_path'       => 'assets/image/',
                        'allowed_types'     => 'jpeg|jpg|png',
                        'file_name'         => date('YmdHis').'-'.$name_upload,
                    );

                    
                    // echo json_encode($config);exit();
                    # load library untuk upload file
                    $this->load->library('upload',$config);
                    // // chmod($config['upload_path'],0777);
                    
                    # cek apakah proses upload berhasil atau tidak
                    if(! $this->upload->do_upload('foto_umkm'))
                        {
                            $error = array(
                                'error' => $this->upload->display_errors(),
                            );

                            // print_r($error);
                            $data = array(
                                'status'    => 'gagal',
                            
                            );
                            
                            echo json_encode($error);
                        }
                    else 
                        {
                            // $data = array(
                            //     'status'    => 'berhasil',
                            //     'file'   => 'upload/images/masjid/'.$config['file_name'], 
                            // );
                            
                            // echo json_encode($data);

                            $gbr = $this->upload->data();
                            //Compress Image
                            $config['image_library']='gd2';
                            $config['source_image']='assets/image/'.$gbr['file_name'];
                            $config['create_thumb']= FALSE;
                            $config['maintain_ratio']= FALSE;
                            $config['quality']= '50%';
                            $config['width']= 640;
                            $config['height']= 640;
                            $config['new_image']= 'assets/image/'.$gbr['file_name'];
                            $this->load->library('image_lib', $config);
                            $this->image_lib->resize();
            
                            $data = array(
                                'status'    => 'berhasil',
                                'file'   => $config['file_name'], 
                            );
                            
                            echo json_encode($data);
                    
                    

                        }
                }


            # get datatables
            public function get_umkm()
                {
                
                    $list_gagal = $this->M_umkm->get_datatables();
                    $data = array();
                    $no = $_POST['start'];

                    # membuat list data nama kategori yang akan di generate
                    # ke datatables
                    foreach($list_gagal as $field)
                        {
                            $id = $field->id_umkm;
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
                            $row[]  = $field->nama_umkm;
                            $row[]  = "Rp. ".number_format($field->modal_awal, '0','.','.');
                            $row[]  = $field->alamat;
                            $row[]  = $field->jenis_dagangan;
                            $row[]  = $field->no_kios;
                            $row[]  = "<img src='".base_url('assets/image/'.$field->foto)."' width='100px' height='100px'>";
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
                        'recordsTotal'      => $this->M_umkm->count_all(),
                        'recordsFiltered'   => $this->M_umkm->count_filtered(),
                        'data'              => $data,
                    );

                    # tampilkan data nama kategori berupa format JSON
                    echo json_encode($output);
                
                }

            # tampil data umkm
            public function show_umkm()
                {
                    $id_umkm    = $this->input->post('id_umkm');

                    $data_umkm  = $this->M_umkm->tampil_umkm()->where(array(
                        'id_umkm'   => $id_umkm,
                    ))->get()->row_array();

                    echo json_encode($data_umkm);
                }

            # update data umkm
            public function update_umkm()
                {
                    // echo json_encode($this->input->post());exit();

                    $res    = array();
                    
                    $rules  = array(

                        array(
                            'field'     => 'id_umkm',
                            'label'     => 'Label UMKM',
                            'rules'     => 'required',
                            'errors'    => array(
                                'required'  => 'Data UMKM tidak ditemukan'
                            ),
                        ),

                        array(
                            'field'     => 'nama_umkm',
                            'label'     => 'Nama UMKM',
                            'rules'     => 'required',
                            'errors'    => array(
                                'required'  => 'Nama umkm tidak boleh kosong',
                            ),
                        ),

                        array(
                            'field'     => 'nominal',
                            'label'     => 'Modal Awal',
                            'rules'     => 'required',
                            'errors'    => array(
                                'required'  => 'Modal tidak boleh kosong',
                            ),
                        ),

                        array(
                            'field'     => 'jenis',
                            'label'     => 'Jenis Dagangan',
                            'rules'     => 'required',
                            'errors'    => array(
                                'required'      => 'Jenis Dagangan tidak boleh kosong',
                            ),
                        ),

                        array(
                            'field'     => 'no',
                            'label'     => 'No Kios',
                            'rules'     =>'required',
                            'errors'    => array(
                                'required'  => 'No Kios tidak boleh kosong',
                            ),
                        ),

                        array(
                            'field'     => 'alamat',
                            'label'     => 'Alamat',
                            'rules'     => 'required',
                            'errors'    => array(
                                'required'  => 'Alamat tidak boleh kosong'
                            ),
                        ),

                        array(
                            'field'     => 'link_foto',
                            'label'     => 'Foto',
                            'rules'     => 'required',
                            'errors'    => array(
                                'required'  => 'silahkan upload foto terlebih dahulu'
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

                    $data_umkm = array(
                        'nama_umkm'         => $this->input->post('nama_umkm'),
                        'alamat'            => $this->input->post('alamat'),
                        'modal_awal'        => $this->input->post('nominal'),
                        'jenis_dagangan'    => $this->input->post('jenis'),
                        'no_kios'           => $this->input->post('no'),
                        'foto'              => $this->input->post('link_foto'),
                    );

                    $cond       = array(
                            'id_umkm'       => $this->input->post('id_umkm'),
                    );

                    $update_data = $this->M_umkm->update_umkm($cond,$data_umkm);

                    if($update_data)
                        {
                            $res['status_update'] = "ok";
                        }
                    else 
                        {
                            $res['status_update'] = "not ok";
                        }

                    echo json_encode($res);
                }

            # aktifasi umkm
            public function umkm_aktif()
                {
                    $res    = array();

                    $data_umkm = array(
                        'status'    => 1,
                    );

                    $cond       = array(
                        'id_umkm'       => $this->input->post('id_umkm'),
                    );

                    $update_data = $this->M_umkm->update_umkm($cond,$data_umkm);

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
            public function umkm_non_aktif()
                {
                    $res    = array();

                    $data_umkm = array(
                        'status'    => 0,
                    );

                    $cond       = array(
                        'id_umkm'       => $this->input->post('id_umkm'),
                    );

                    $update_data = $this->M_umkm->update_umkm($cond,$data_umkm);

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