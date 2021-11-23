<?php 
    class M_modal extends CI_model
        {
            protected $tbl_log_modal = 'log_modal';

            public function tambah_log_modal($data = array())
                {
                    return $this->db->insert($this->tbl_log_modal,$data);
                }

            public function tampil_log_modal()
                {
                    return $this->db->select('*')
                        ->from($this->tbl_log_modal);
                }
        }