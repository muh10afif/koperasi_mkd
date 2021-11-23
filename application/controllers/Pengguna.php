<?php 
    class Pengguna extends CI_Controller 
        {
            public function __construct()
                {
                    parent::__construct();
                    $this->load->model('M_user');
                    $this->load->model('M_pegawai');
                    $this->load->model('M_penempatan');
                }

            public function index()
                {

                }

            public function tambah_user()
                {
                    $data = array(
                        'list_pegawai'      => $this->M_pegawai->pegawai_nonakun(),
                        'content'           => 'user/tambah',
                        'judul'             => 'user'
                    );

                    // echo $this->db->last_query();exit();

                    $this->load->view('layout/template',$data);
                }

            public function tambah_data_user()
                {
                    // echo json_encode($this->input->post());exit();

                    $res = array();

                    $rules = array(
                        array(
                            'field'     => 'pegawai',
                            'label'     => "Pegawai",
                            'rules'     => 'required',
                            'errors'    => array(
                                'required'  => 'Silahkan pilih pegawai terlebih dahulu',
                            ),
                        ),

                        array(
                            'field'     => 'username',
                            'label'     => "Username",
                            'rules'     => 'required|is_unique[m_user.username]',
                            'errors'    => array(
                                'required'  => 'username tidak boleh kosong',
                                'is_unique' => 'Username sudah digunakan, sialhkan gunakan username lain',
                            ),
                        ),

                        array(
                            'field'     => 'password',
                            'label'     => "password",
                            'rules'     => 'required',
                            'errors'    => array(
                                'required'  => 'password tidak boleh kosong',
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
                        'username'      => $this->input->post('username'),
                        'password'      => $this->input->post('password'),
                        'id_pegawai'    => $this->input->post('pegawai'),
                        'add_time'      => date('Y-m-d H:i:s'),
                        'status'        => 1,
                    );

                    $tambah = $this->M_user->tambah_user($data);

                    if($tambah)
                        {
                            $res['status_tambah']   = 'ok';
                        }
                    else 
                        {
                            $res['status_tambah']   = "not ok";
                        }

                    echo json_encode($res);
                }

                public function ubah_data_user()
                {
                    // echo json_encode($this->input->post());exit();

                    $res = array();

                    $rules = array(
                        array(
                            'field'     => 'username',
                            'label'     => "Username",
                            'rules'     => 'required',
                            'errors'    => array(
                                'required'  => 'username tidak boleh kosong'
                            ),
                        ),

                        array(
                            'field'     => 'password',
                            'label'     => "password",
                            'rules'     => 'required',
                            'errors'    => array(
                                'required'  => 'password tidak boleh kosong',
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
                        'username'      => $this->input->post('username'),
                        'password'      => $this->input->post('password')
                    );

                    $tambah = $this->M_user->ubah_user($data, $this->input->post('id_user'));

                    if($tambah)
                        {
                            $res['status_update']   = 'ok';
                        }
                    else 
                        {
                            $res['status_update']   = "not ok";
                        }

                    echo json_encode($res);
                }

            public function tampil_form_tambah()
            {
                $list   = $this->M_pegawai->pegawai_nonakun();

                $option = "<option value=''>-- Pilih Pegawai --</option>";

                foreach ($list as $l) {
                    $option .= "<option value=".$l->id_pegawai.">".$l->nama_pegawai."</option>";
                }

                echo json_encode(['pegawai' => $option]);
            }


            public function get_user()
                {
                
                
                    $list_gagal = $this->M_user->get_datatables();
                    $data = array();
                    $no = $_POST['start'];

                    # membuat list data nama kategori yang akan di generate
                    # ke datatables
                    foreach($list_gagal as $field)
                        {
                            $id = $field->id_user;
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
                            
                            $row[]  = $field->username;
                            $row[]  = $field->password;
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
                        'recordsTotal'      => $this->M_user->count_all(),
                        'recordsFiltered'   => $this->M_user->count_filtered(),
                        'data'              => $data,
                    );

                    # tampilkan data nama kategori berupa format JSON
                    echo json_encode($output);
                
                }

            public function show_user()
                {
                    $id_user = $this->input->post('id_user');

                    $user = $this->M_user->tampil_user_2()->where(array('m_user.id_user' => $id_user))->get()->row_array();

                    echo json_encode($user);
                }

            # aktif user dan pengguna
            public function user_aktif()
                {

                    $res            = array();
                    $id_user        = $this->input->post('id_user');

                    $tampil_user    = $this->M_user->tampil_user()->where(array('id_user'=>$id_user))->get()->row_array();

                    $cond_pegawai   = array(
                        'id_pegawai'    => $tampil_user['id_pegawai'],
                    );

                    $cond_user      = array(
                        'id_user'       => $id_user,
                    );

                    $data = array(
                        'status'    => 1,
                    );

                    $this->db->trans_start();

                    $this->M_user->update_user($cond_user,$data);
                    $this->M_pegawai->update_pegawai($cond_pegawai,$data);

                    $this->db->trans_complete();

                    if($this->db->trans_status() === FALSE)
                        {
                            $res['status']  = "not ok";
                            $this->db->trans_rollback();
                        }
                    else 
                        {
                            $res['status'] = "ok";
                        }

                    echo json_encode($res);
                }

            public function user_non_aktif()
                {

                    $res            = array();
                    $id_user        = $this->input->post('id_user');

                    $tampil_user    = $this->M_user->tampil_user()->where(array('id_user'=>$id_user))->get()->row_array();
                    // echo $this->db->last_query();exit();

                    $cond_pegawai   = array(
                        'id_pegawai'    => $tampil_user['id_pegawai'],
                    );

                    $cond_user      = array(
                        'id_user'       => $id_user,
                    );

                    $data = array(
                        'status'    => 0,
                    );

                    $this->db->trans_start();

                    $this->M_user->update_user($cond_user,$data);
                    $this->M_pegawai->update_pegawai($cond_pegawai,$data);

                    $this->db->trans_complete();

                    // echo $this->db->last_query();exit();

                    if($this->db->trans_status() === FALSE)
                        {
                            $res['status']  = "not ok";
                            // $this->db->trans_rollback();
                        }
                    else 
                        {
                            $res['status'] = "ok";
                        }

                    echo json_encode($res);
                }

            # login
            public function login()
                {
                    // echo json_encode($this->input->post());exit();

                    $rules = array(
                        array(
                            'field'     => 'username',
                            'label'     => 'Username',
                            'rules'     => 'required',
                            'errors'    => array(
                                'required'  => 'Username tidak boleh kosong'
                            ),
                        ),

                        array(
                            'field'     => 'password',
                            'label'     => 'Password',
                            'rules'     => 'required',
                            'errors'    => array(
                                'required'  => 'Password tidak boleh kosong'
                            ),
                        ),
                    );

                    $this->form_validation->set_rules($rules);

                    if($this->form_validation->run() == false)
                        {
                            $this->session->set_flashdata('status_login','gagal');
                            $this->session->set_flashdata('error',$this->form_validation->error_array());
                            redirect(base_url());
                        }

                    $cek = $this->M_user->tampil_user()->where(array(
                        'username'  => $this->input->post('username'),
                        'password'  => $this->input->post('password'),
                    ))->count_all_results();

                    if($cek == 1)
                        {
                            $data_user = $this->M_user->tampil_user()->where(array(
                                'username'  => $this->input->post('username'),
                                'password'  => $this->input->post('password'),
                            ))->get()->row_array();

                        
                            $this->session->set_userdata('username',$data_user['username']);

                            if($data_user['username'] == "solusiadmin" && $data_user['password'] == "adminsolusi")
                                {
                                    $this->session->set_userdata('level','admin');
                                    $this->session->set_userdata('umkm','');
                                    redirect(base_url('Home'));
                                }
                            else 
                                {
                                    $id_pegawai = $data_user['id_pegawai'];
                                    $this->session->set_userdata('id_pegawai',$id_pegawai);

                                    $this->session->set_userdata('level','pengguna');

                                    $cari = $this->M_penempatan->tampil_penempatan()->where(array(
                                        'penempatan.id_pegawai' => $id_pegawai
                                    ))->count_all_results();

                                    if($cari == 1)
                                        {
                                            $penempatan = $this->M_penempatan->tampil_penempatan()->where(array(
                                                'penempatan.id_pegawai' => $id_pegawai
                                            ))->get()->row_array();

                                            $this->session->set_userdata('umkm',$penempatan['id_umkm']);
                                            $this->session->set_userdata('nama',$penempatan['nama_pegawai']);
                                            $this->session->set_userdata('id_peg',$penempatan['id_pegawai']);
                                        }
                                    else 
                                        {
                                            $this->session->set_userdata('umkm','');
                                        }
                                    
                                    redirect(base_url('Home'));
                                }
                        }
                    else 
                        {
                            redirect(base_url());
                        }
                }
        }