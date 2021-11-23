<?php 
    class User extends CI_Controller 
        {
            public function __construct()
                {
                    parent::__construct();
                    $this->load->model('M_user');
                }
            
            public function auth()
                {
                    // echo json_encode($this->input->post());exit();
                    // $this->session->set_userdata('login',true);
                    // redirect(base_url('kantor_mui'));
                    $rules = array(
                        array(
                            'field'     => 'username',
                            'label'     => 'Username',
                            'rules'     => 'required',
                            'errors'    => array(
                                'required'  => "Username masih kosong",
                            ),
                        ),

                        array(
                            'field'     => 'password',
                            'label'     => 'password',
                            'rules'     => 'required',
                            'errors'    => array(
                                'required'  => "password masih kosong",
                            ),
                        ),
                    );

                    $this->form_validation->set_rules($rules);

                    if($this->form_validation->run() == false)
                        {
                            $this->session->set_flashdata('status_login','not ok');
                            $this->session->set_flashdata('error',$this->form_validation->error_array());
                            // echo validation_errors();exit();
                            redirect(base_url());
                        }

                    $data_user = array(
                        'username'  => $this->input->post('username'),
                        // 'id_level'  => 1,
                        
                        // 'password'  => $this->input->post('password'),
                    );

                    $cek_user = $this->M_user->get_pengguna()->where("(id_level = '1' OR id_level='2')")->where($data_user)->count_all_results();

                    // echo $this->db->last_query();exit();
                    if($cek_user == 1)
                        {
                            $data_user = $this->M_user->get_pengguna()->where("(id_level = '1' OR id_level='2')")->where($data_user)->get()->result();
                            foreach($data_user as $d)
                                {
                                    // $options    = array('cost' => 10);
                                    $pass       = $this->input->post('password');
                                    // $password   = password_hash($pass); 
                                
                                    
                                    // var_dump(password_verify($pass,$d->password));exit();
                                    
                                    if(password_verify($pass,$d->password))
                                        {
                                            $this->session->set_userdata('username',$d->username);
                                            $this->session->set_userdata('login',true);
                                            $this->session->set_userdata('foto_user',$d->foto);
                                            $this->session->set_userdata('nama',$d->nama_pengguna);
                                            $this->session->set_userdata('id_pengguna',$d->id_pengguna);
                                            $this->session->set_userdata('email',$d->username);
                                            $this->session->set_userdata('id_level',$d->id_level);

                                            // echo $this->session->userdata('foto_user');exit();
                                            redirect(base_url('home'));
                                        
                                        }
                                    else 
                                        {
                                            $this->session->set_flashdata('status_login','not ok');
                                            redirect(base_url());
                                            // echo "not_ok";
                                        }
                                
                                    // redirect(base_url('kantor_mui'));
                                }
                            
                            // redirect(base_url('home'));
                            
                        }
                    else 
                        {
                            $this->session->set_flashdata('status_login','not ok');
                            redirect(base_url());
                        }
                }
            public function tambah_user()
                {
                    Auth::UserLogin();
                    $data = array(
                        'content'    => 'user/tambah',
                    );

                    $this->load->view('layout/template',$data);
                }
            # register
            public function register()
                {
                    // echo json_encode($this->input->post());exit();
                    $res = array();
                    $rules = array(
                        
                        array(
                            'field'     => 'nama_pengguna',
                            'label'     => 'Nama Pengguna',
                            'rules'     => 'required',
                            'errors'    => array(
                                'required'  => "Nama Pengguna masih kosong",
                                
                            ),
                        ),
                        array(
                            'field'     => 'username',
                            'label'     => 'Username',
                            'rules'     => 'required|callback_cek_username',
                            'errors'    => array(
                                'required'  => "Email masih kosong",
                                'is_unique' => 'Email sudah digunakan, silahkan gunakan username lain',
                            ),
                        ),

                        array(
                            'field'     => 'password',
                            'label'     => 'password',
                            'rules'     => 'required',
                            'errors'    => array(
                                'required'  => "password masih kosong",
                            ),
                        ),

                        array(
                            'field'     => 'username',
                            'label'     => 'Username',
                            'rules'     => 'required',
                            'errors'    => array(
                                'required'  => "Username masih kosong",
                            ),
                        ),

                        array(
                            'field'     => 'nik',
                            'label'     => 'nik',
                            'rules'     => 'required|is_unique[detail_pengguna.nik]',
                            'errors'    => array(
                                'required'      => "NIK pengguna tidakk boleh kosong",
                                'is_unique'     => "NIK sudah digunakan, silahkan gunakan nik yang lain",
                            ),
                        ),
                    );

                    $this->form_validation->set_rules($rules);

                    if($this->form_validation->run() == false)
                        {
                            // $this->session->set_flashdata('status_tambah','not ok');
                            // $this->session->set_flashdata('error',$this->form_validation->error_array());

                            // // redirect url
                            // redirect(base_url('user/tambah_user'));

                            $res['status_tambah']   = "gagal";
                            $res['error']           = $this->form_validation->error_array();
                            echo json_encode($res);
                            exit();
                        }
                    
                    $cek = $this->M_user->get_pengguna()->where(array(
                        'username'  => $this->input->post('username'),
                    ))->count_all_results();

                    // echo $this->db->last_query();exit();
                    if($cek > 0)
                        {
                        
                            $error = array('Email sudah digunakan, silahkan gunakan username lain');
                            // $this->session->set_flashdata('status_tambah','not ok');
                            // $this->session->set_flashdata('error',$error);
                            // redirect(base_url('user/tambah_user'));
                            $res['status_tambah']   = "gagal";
                            $res['error']           = $error;
                            echo json_encode($res);
                            exit();
                        }

                    $foto = $this->input->post('foto_usr');

                    if($foto =='')
                        {
                            $foto = 'user-avatar-default.jpg';
                        }
                    
                    $options    = array('cost' => 10);
                    $pass       =  $this->input->post('password');
                    $password   = password_hash($pass,PASSWORD_DEFAULT,$options); 

                    // $data_user = array(
                    //     'nama_pengguna' => $this->input->post('nama_pengguna'),
                    //     'username'      => $this->input->post('username'),
                    //     'password'      => $password,
                    //     'alamat'        => $this->input->post('alamat'),
                    //     'foto'          => $foto,
                    //     'add_time'      => date('Y-m-d H:i:s'),
                    //     'status'        => '1',
                    //     'id_level'      => '0',
                    // );

                    $data_user = array(
                        'username'      => $this->input->post('username'),
                        'password'      => $password,
                        'add_time'      => date('Y-m-d H:i:s'),
                        'status'        => "1",
                        'id_level'      => "0",
                    );

                    

                    $this->db->trans_start();
                        $tambah_user = $this->M_user->add_pengguna($data_user);

                        if($tambah_user)
                            {
                                $user = $this->M_user->get_pengguna()->where($data_user)->get()->row_array();

                                $id_pengguna = $user['id_pengguna'];
                                $detail_pengguna  = array(
                                    'nik'           => $this->input->post('nik'),
                                    'nama'          => $this->input->post('nama_pengguna'),
                                    'tempat_lahir'  => $this->input->post('tempat_lahir'),
                                    'tanggal_lahir' => $this->input->post('tgl_lahir'),
                                    'no_telfon'     => $this->input->post('no_telfon'),
                                    'alamat'        => $this->input->post("alamat"),
                                    'lat'           => $this->input->post('lat'),
                                    'long'          => $this->input->post('long'),
                                    'foto'          => $foto,
                                    'id_pengguna'   => $id_pengguna,
                                    'add_time'      => date('Y-m-d H:i:s'),
                                );

                                $this->M_user->tambah_detail($detail_pengguna);
                            }

                    $this->db->trans_complete();
                    

                    if($this->db->trans_status() == true)
                        {
                            $res['status_tambah']   = "ok";
                            // $this->session->set_flashdata('status_tambah','ok');
                        }
                    else 
                        {
                            $res['status_tambah']   = "not ok";
                            // $this->session->set_flashdata('status_tambah','not ok');
                        }
                    
                    echo json_encode($res);
                    // redirect(base_url('user/tambah_user'));
                    
                    
                }
            
            public function upload_foto_user()
                {
                    # set nama foto yg diupload agar tidak ada spasi 
                    $name = explode(' ',$_FILES['foto_user']['name']);
                   // echo pathinfo($_FILES['file_upload']['name'],PATHINFO_EXTENSION);exit();

                    $name_upload ='';

                    
                    foreach($name as $key => $value)
                        {
                            $name_upload .= $value;
                        }

                    # set config untuk data upload foto ke sistem
                    $config = array(
                        // 'upload_path'       => realpath(APPPATH.'../upload/images/user/'),
                        'upload_path'       => '../MUI_api/documents/profile_picture',
                        'allowed_types'     => 'jpg|png|jpeg',
                        'file_name'         => date('YmdHis').'-'.$name_upload,
                    );

                    
                    # load library untuk upload file
                    $this->load->library('upload',$config);
                    // // chmod($config['upload_path'],0777);
                    
                    # cek apakah proses upload berhasil atau tidak
                    if(! $this->upload->do_upload('foto_user'))
                        {
                            $error = array(
                                'error' => $this->upload->display_errors(),
                            );

                            print_r($error);
                            $data = array(
                                'status'    => 'gagal',
                            
                            );
                            
                            echo json_encode($data);
                        }
                    else 
                        {
                            $gbr = $this->upload->data();
                            //Compress Image
                            $config['image_library']='gd2';
                            $config['source_image']='../MUI_api/documents/profil_picture/'.$gbr['file_name'];
                            $config['create_thumb']= FALSE;
                            $config['maintain_ratio']= FALSE;
                            $config['quality']= '50%';
                            $config['width']= 640;
                            $config['height']= 640;
                            $config['new_image']= '../MUI_api/documents/profil_picture/'.$gbr['file_name'];
                            $this->load->library('image_lib', $config);
                            $this->image_lib->resize();
            
                            $data = array(
                                'status'    => 'berhasil',
                                // 'file'      => 'upload/images/user/'.$config['file_name'], 
                                'file'      => $config['file_name'], 
                            );
                            
                            echo json_encode($data);
                    
                    

                        }
                }

            public function get_user()
                {
                
                
                    $list = $this->M_user->get_datatables();
                    $data = array();
                    $no = $_POST['start'];

                    # membuat list data nama kategori yang akan di generate
                    # ke datatables
                    foreach($list as $field)
                        {
                            $id = $field->id_pengguna;
                        
                            $no++;
                            $row        = array();

                            $row[]  = $no;
                            $row[]  = $field->nama;
                            
                            $row[]  =$field->username;
                            $row[]  = "<img src='http://".$_SERVER['HTTP_HOST']."/MUI_api/documents/profile_picture/".$field->foto."' style='width:60px;height:60px;border-radius:50%;'>";
                            // $row[]  = '<button onclick="edit(\''.$id.'\')" class="btn btn-success btn-sm"><i class="fa fa-pencil"></i></button>&nbsp;&nbsp;<button onclick="hapus(\''.$id.'\')" class="btn btn-danger btn-sm"><i class="fa fa-trash"></i></button>';
                            $row[]  = '<button onclick="edit(\''.$id.'\')" class="btn btn-success btn-sm"><i class="fa fa-pencil"></i></button>&nbsp;&nbsp;<button onclick="hapus(\''.$id.'\')" class="btn btn-danger btn-sm"><i class="fa fa-trash"></i></button>';

                            $data[] = $row;
                        }
                    
                    # membuat output data nama kategori
                    # yang akan ditampilkan pada datatables
                    $output = array(
                        'draw'              => $_POST['draw'],
                        'recordsTotal'      => $this->M_user->count_all(),
                        'recordsFiltered'   => $this->M_user->count_filtered(),
                        'data'              => $data,
                    );

                    # tampilkan data nama kategori berupa format JSON
                    echo json_encode($output);
                
                }
            
            public function logout()
                {
                    
                    $this->session->sess_destroy();
                
                    redirect(base_url());
                }
            
            public function show_user()
                {
                    $id_user = $_POST['id_user'];

                    $user = $this->M_user->tampil_pengguna()->where(array(
                        'a.id_pengguna'   => $id_user,
                    ))->get()->result_array();

                    echo json_encode($user);
                }
            
            public function update_user()
                {
                    // echo json_encode($this->input->post());exit();

                    $res = array();

                    $rules = array(
                    
                        array(
                            'field'     => 'nama_pengguna',
                            'label'     => 'Nama Pengguna',
                            'rules'     => 'required',
                            'errors'    => array(
                                'required'  => "Nama Pengguna masih kosong",
                                
                            ),
                        ),
                        array(
                            'field'     => 'username',
                            'label'     => 'Username',
                            'rules'     => 'required',
                            'errors'    => array(
                                'required'  => "Email masih kosong",
                                
                            ),
                        ),

                        array(
                            'field'     => 'password',
                            'label'     => 'password',
                            'rules'     => 'required',
                            'errors'    => array(
                                'required'  => "password masih kosong",
                            ),
                        ),

                        array(
                            'field'     => 'username',
                            'label'     => 'Username',
                            'rules'     => 'required',
                            'errors'    => array(
                                'required'  => "Username masih kosong",
                            ),
                        ),

                        array(
                            'field'     => 'nik',
                            'label'     => 'nik',
                            'rules'     => 'required',
                            'errors'    => array(
                                'required'  => "NIK tidak boleh kosong",
                            ),
                        ),
                    );

                    $this->form_validation->set_rules($rules);

                    if($this->form_validation->run() == false)
                        {
                            // $this->session->set_flashdata('status_update','not ok');
                            // $this->session->set_flashdata('error',$this->form_validation->error_array());

                            // // redirect url
                            // redirect(base_url('user/tambah_user'));

                            $res['status_update']   = "gagal";
                            $res['error']           = $this->form_validation->error_array();
                            echo json_encode($res);
                            exit();
                        }

                    $foto = $this->input->post('link_foto');

                    if($foto =='')
                        {
                            $foto = 'user-avatar-default.jpg';
                        }
                    
                    $options    = array('cost' => 10);
                    $pass       =  $this->input->post('password');
                    $password   = password_hash($pass,PASSWORD_DEFAULT,$options); 

                    // $data_user = array(
                    //     'nama_pengguna' => $this->input->post('nama_pengguna'),
                    //     'username'      => $this->input->post('username'),
                    //     'password'      => $password,
                    //     'alamat'        => $this->input->post('alamat'),
                    //     'foto'          => $foto,
                    //     'add_time'      => date('Y-m-d H:i:s'),
                    //     'status'        => '1',
                    //     'id_level'      => '0',
                    // );

                    $data_user = array(
                        'username'      => $this->input->post('username'),
                        'password'      => $password,
                        'add_time'      => date('Y-m-d H:i:s'),
                        'status'        => "1",
                        'id_level'      => "4",
                    );

                    $detail_pengguna  = array(
                        'nik'           => $this->input->post('nik'),
                        'nama'          => $this->input->post('nama_pengguna'),
                        'tempat_lahir'  => $this->input->post('tempat_lahir'),
                        'tanggal_lahir' => $this->input->post('tgl_lahir'),
                        'no_telfon'     => $this->input->post('no_telfon'),
                        'alamat'        => $this->input->post("alamat"),
                        'lat'           => $this->input->post('lat'),
                        'long'          => $this->input->post('long'),
                        'foto'          => $foto,
                        'add_time'      => date('Y-m-d H:i:s'),
                    );

                    $cond['id_pengguna'] = $this->input->post('id_user');

                    

                    $this->db->trans_start();

                        $this->M_user->update_pengguna($cond,$data_user);

                        $this->M_user->update_detail($cond,$detail_pengguna);

                    $this->db->trans_complete();

                    if($this->db->trans_status() == true)
                        {
                            $res['status_update']   = "ok";
                            // $this->session->set_flashdata('status_update','ok');
                        }
                    else 
                        {
                            $res['status_update']   = "not ok";
                            // $this->session->set_flashdata('status_update','not ok');
                        }

                    echo json_encode($res);
                    
                    // redirect(base_url('user/tambah_user'));
                }
            
            # data admin
            public function admin()
                {
                    Auth::UserLogin();

                    $data = array(
                        'content'   =>  'user/admin',
                    );

                    $this->load->view('layout/template',$data);
                }
            
            public function get_admin()
                {
                
                
                    $list = $this->M_user->get_datatables_admin();
                    $data = array();
                    $no = $_POST['start'];

                    # membuat list data nama kategori yang akan di generate
                    # ke datatables
                    foreach($list as $field)
                        {
                            $id = $field->id_pengguna;
                            
                            if($this->session->userdata('id_pengguna') == $id)
                                {
                                    $button = '<button onclick="edit(\''.$id.'\')" class="btn btn-success btn-sm"><i class="fa fa-pencil"></i></button>';
                                }
                            else 
                                {
                                    $button = '';
                                }

                            $no++;
                            $row        = array();

                            $row[]  = $no;
                            $row[]  = $field->nama;
                            
                            $row[]  = $field->username;
                            $row[]  = "<img src='http://".$_SERVER['HTTP_HOST']."/MUI_api/documents/profile_picture/".$field->foto."' style='width:60px;height:60px;border-radius:50%;'>";
                            // $row[]  = '<button onclick="edit(\''.$id.'\')" class="btn btn-success btn-sm"><i class="fa fa-pencil"></i></button>&nbsp;&nbsp;<button onclick="hapus(\''.$id.'\')" class="btn btn-danger btn-sm"><i class="fa fa-trash"></i></button>';
                            // $row[]  = '<button onclick="edit(\''.$id.'\')" class="btn btn-success btn-sm"><i class="fa fa-pencil"></i></button>';
                            $row[]  = $button;

                            $data[] = $row;
                        }
                    
                    # membuat output data nama kategori
                    # yang akan ditampilkan pada datatables
                    $output = array(
                        'draw'              => $_POST['draw'],
                        'recordsTotal'      => $this->M_user->count_all_admin(),
                        'recordsFiltered'   => $this->M_user->count_filtered_admin(),
                        'data'              => $data,
                    );

                    # tampilkan data nama kategori berupa format JSON
                    echo json_encode($output);
                
                }
            
            public function register_admin()
                {
                    // echo json_encode($this->input->post());exit();

                    $res = array();
                    $rules = array(
                        
                        array(
                            'field'     => 'nama_pengguna',
                            'label'     => 'Nama Pengguna',
                            'rules'     => 'required',
                            'errors'    => array(
                                'required'  => "Nama Pengguna masih kosong",
                                
                            ),
                        ),
                        array(
                            'field'     => 'username',
                            'label'     => 'Username',
                            'rules'     => 'trim|required|is_unique[pengguna.username]',
                            'errors'    => array(
                                'required'  => "Email masih kosong",
                                
                            ),
                        ),

                        array(
                            'field'     => 'password',
                            'label'     => 'password',
                            'rules'     => 'required',
                            'errors'    => array(
                                'required'  => "password masih kosong",
                            ),
                        ),

                        array(
                            'field'     => 'username',
                            'label'     => 'Username',
                            'rules'     => 'required',
                            'errors'    => array(
                                'required'  => "Username masih kosong",
                            ),
                        ),

                        array(
                            'field'     => 'nik',
                            'label'     => 'nik',
                            'rules'     => 'required',
                            'errors'    => array(
                                'required'      => "NIK pengguna tidakk boleh kosong",
                                
                            ),
                        ),
                    );

                    // var_dump($this->form_validation->set_rules($rules));exit();

                    $this->form_validation->set_rules($rules);

                    if($this->form_validation->run() == false)
                        {
                            // $this->session->set_flashdata('status_tambah','not ok');
                            // $this->session->set_flashdata('error',$this->form_validation->error_array());
                            // // echo validation_errors();
                            // // redirect url
                            // redirect(base_url('user/admin'));

                            $res['status_tambah']   = "gagal";
                            $res['error']           = $this->form_validation->error_array();
                            echo json_encode($res);
                            exit();
                        }
                    
                    $cek = $this->M_user->get_pengguna()->where(array(
                        'username'  => $this->input->post('username'),
                    ))->count_all_results();

                    // echo $this->db->last_query();exit();
                    if($cek > 0)
                        {
                        
                            $error = array('Email sudah digunakan, silahkan gunakan username lain');
                            // $this->session->set_flashdata('status_tambah','not ok');
                            // $this->session->set_flashdata('error',$error);
                            // redirect(base_url('user/admin'));
                            $res['status_tambah']   = "gagal";
                            $res['error']           = $error;
                            echo json_encode($res);
                            exit();
                        }

                    $foto = $this->input->post('foto_usr');

                    if($foto =='')
                        {
                            $foto = 'user-avatar-default.jpg';
                        }
                    
                    $options    = array('cost' => 10);
                    $pass       =  $this->input->post('password');
                    $password   = password_hash($pass,PASSWORD_DEFAULT,$options); 

                    // $data_user = array(
                    //     'nama_pengguna' => $this->input->post('nama_pengguna'),
                    //     'username'      => $this->input->post('username'),
                    //     'password'      => $password,
                    //     'alamat'        => $this->input->post('alamat'),
                    //     'foto'          => $foto,
                    //     'add_time'      => date('Y-m-d H:i:s'),
                    //     'status'        => '1',
                    //     'id_level'      => '2',
                    // );

                    $data_user = array(
                        'username'      => $this->input->post('username'),
                        'password'      => $password,
                        'add_time'      => date('Y-m-d H:i:s'),
                        'status'        => "1",
                        'id_level'      => "2",
                    );

                   $this->db->trans_start();
                        $tambah_user = $this->M_user->add_pengguna($data_user);

                        if($tambah_user)
                            {
                                $user = $this->M_user->get_pengguna()->where($data_user)->get()->row_array();

                                $id_pengguna = $user['id_pengguna'];
                                $detail_pengguna  = array(
                                    'nik'           => $this->input->post('nik'),
                                    'nama'          => $this->input->post('nama_pengguna'),
                                    'tempat_lahir'  => $this->input->post('tempat_lahir'),
                                    'tanggal_lahir' => $this->input->post('tgl_lahir'),
                                    'no_telfon'     => $this->input->post('no_telfon'),
                                    'alamat'        => $this->input->post("alamat"),
                                    'lat'           => $this->input->post('lat'),
                                    'long'          => $this->input->post('long'),
                                    'foto'          => $foto,
                                    'id_pengguna'   => $id_pengguna,
                                    'add_time'      => date('Y-m-d H:i:s'),
                                );

                                $this->M_user->tambah_detail($detail_pengguna);
                            }

                    $this->db->trans_complete();
                    

                    if($this->db->trans_status() == true)
                        {
                            $res['status_tambah']   = "ok";
                            // $this->session->set_flashdata('status_tambah','ok');
                        }
                    else 
                        {
                            $res['status_tambah']   = "not ok";
                            // $this->session->set_flashdata('status_tambah','not ok');
                        }
                    
                    echo json_encode($res);
                    
                    // redirect(base_url('user/admin'));
                    
                    
                }
            
            public function update_admin()
                {
                    // echo json_encode($this->input->post());exit();

                    $res = array();
                    $rules = array(

                        array(
                            'field'     => 'nama_pengguna',
                            'label'     => 'Nama Pengguna',
                            'rules'     => 'required',
                            'errors'    => array(
                                'required'  => "Nama Pengguna masih kosong",
                                
                            ),
                        ),
                        array(
                            'field'     => 'username',
                            'label'     => 'Username',
                            'rules'     => 'required',
                            'errors'    => array(
                                'required'  => "Email masih kosong",
                                
                            ),
                        ),

                        array(
                            'field'     => 'password',
                            'label'     => 'password',
                            'rules'     => 'required',
                            'errors'    => array(
                                'required'  => "password masih kosong",
                            ),
                        ),

                        array(
                            'field'     => 'username',
                            'label'     => 'Username',
                            'rules'     => 'required',
                            'errors'    => array(
                                'required'  => "Username masih kosong",
                            ),
                        ),

                        array(
                            'field'     => 'nik',
                            'label'     => 'nik',
                            'rules'     => 'required',
                            'errors'    => array(
                                'required'  => "NIK tidak boleh kosong",
                            ),
                        ),
                    );

                    $this->form_validation->set_rules($rules);
                    // var_dump($this->form_validation->set_rules($rules));exit();

                    if($this->form_validation->run() == false)
                        {
                            // $this->session->set_flashdata('status_update','not ok');
                            // $this->session->set_flashdata('error',$this->form_validation->error_array());

                            // // redirect url
                            // redirect(base_url('user/admin'));

                            $res['status_update']   = "gagal";
                            $res['error']           = $this->form_validation->error_array();
                            echo json_encode($res);
                            exit();
                        }

                    $foto = $this->input->post('link_foto');

                    if($foto =='')
                        {
                            $foto = 'user-avatar-default.jpg';
                        }
                    
                    $options    = array('cost' => 10);
                    $pass       =  $this->input->post('password');
                    $password   = password_hash($pass,PASSWORD_DEFAULT,$options); 
                    $data_user = array(
                        'username'      => $this->input->post('username'),
                        'password'      => $password,
                        'add_time'      => date('Y-m-d H:i:s'),
                        'status'        => "1",
                        'id_level'      => "2",
                    );

                    $detail_pengguna  = array(
                        'nik'           => $this->input->post('nik'),
                        'nama'          => $this->input->post('nama_pengguna'),
                        'tempat_lahir'  => $this->input->post('tempat_lahir'),
                        'tanggal_lahir' => $this->input->post('tgl_lahir'),
                        'no_telfon'     => $this->input->post('no_telfon'),
                        'alamat'        => $this->input->post("alamat"),
                        'lat'           => $this->input->post('lat'),
                        'long'          => $this->input->post('long'),
                        'foto'          => $foto,
                        'add_time'      => date('Y-m-d H:i:s'),
                    );

                    $cond['id_pengguna'] = $this->input->post('id_user');

                   $this->db->trans_start();

                        $this->M_user->update_pengguna($cond,$data_user);

                        $this->M_user->update_detail($cond,$detail_pengguna);

                    $this->db->trans_complete();

                    if($this->db->trans_status() == true)
                        {
                            $res['status_update']   = "ok";
                            // $this->session->set_flashdata('status_update','ok');
                        }
                    else 
                        {
                            $res['status_update']   = "not ok";
                            // $this->session->set_flashdata('status_update','not ok');
                        }

                    echo json_encode($res);
                    
                    // redirect(base_url('user/admin'));
                }
            
            public function cek_username($string)
                {
                    $cek = $this->M_user->get_pengguna()->where(array(
                        'username'  => $string
                    ))->count_all_results();

                    // echo $this->db->last_query();exit();
                    if($cek > 0)
                        {
                        
                            $this->form_validation->set_message('cek_username', "Username sudah digunakan, silahkan gunakan username lain.");
                            return false;
                        }
                    return true;
                }
            
            public function hapus_pengguna()
                {
                    $id_pengguna = $_POST['id_pengguna'];

                    $this->db->trans_start();

                    $this->M_user->hapus_pengguna(array(
                        'id_pengguna' => $id_pengguna,
                    ));

                    $this->M_user->hapus_detail(array(
                        'id_pengguna' => $id_pengguna,
                    ));

                    $this->db->trans_complete();

                
                    
                    $data = array();

                    if($this->db->trans_status() == true)
                        {
                            $data['status'] = 'ok';
                        }
                    else 
                        {
                            $data['status'] = 'not ok';
                        }
                    
                    echo json_encode($data);
                }
            
        }