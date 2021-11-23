<?php 
    class Home extends CI_Controller
        {
            public function __construct()
                {
                    parent::__construct();
                }
            
            public function index()
                {
                    // Auth::UserLogin();
                    $data['content'] = 'home';
                    $data['judul']   = 'home';
                    $this->load->view('layout/template',$data);
                    
                }
            
            
        }