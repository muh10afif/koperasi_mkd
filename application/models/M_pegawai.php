<?php
    class M_pegawai extends CI_Model
        {
            protected $tbl_pegawai      = "pegawai";
            protected $tbl_user         = 'm_user';
            protected $tbl_penempatan   = "penempatan";

            private $kolom_order = array(
                null,
                'lower(nama_pegawai)',
                'lower(alamat)',
                'no_telp',
                'nik',
                
            );
            
            private $kolom_cari = array(
                'lower(nama_pegawai)',
                'lower(alamat)',
                'no_telp',
                'nik',
                
            );

            public function tambah_pegawai($data = array())
                {
                    return $this->db->insert($this->tbl_pegawai,$data);
                }

            public function hapus_pegawai($where = array())
                {
                    return $this->db->where($where)->delete($this->tbl_pegawai);
                }

            public function update_pegawai($where = array(), $data = array())
                {
                    return $this->db->where($where)->update($this->tbl_pegawai,$data);

                }

            public function tampil_pegawai()
                {
                    return $this->db->select('*')
                        ->from($this->tbl_pegawai);
                }

            # datatables 
            public  function _get_datatables_query()
                {
                        $this->db->select('*')
                        ->from($this->tbl_pegawai);
                        
                        

                        $i =0;

                        foreach($this->kolom_cari as $kc)
                            {
                                if(isset($_POST['search']['value']))
                                    {
                                        if($i == 0)
                                            {
                                                $this->db->group_start();
                                                $this->db->like($kc,$_POST['search']['value']);
                                            }
                                        else
                                            {
                                                $this->db->or_like($kc,$_POST['search']['value']);
                                            }

                                        if(count($this->kolom_cari)-1 == $i)
                                            {
                                                $this->db->group_end();
                                            }

                                        $i++;
                                    }

                                if(isset($_POST['order']))
                                    {
                                        $this->db->order_by($this->kolom_order[$_POST['order'][0]['column']],$_POST['order'][0]['dir']);

                                    }
                                else if(isset($this->order))
                                    {
                                        $order = $this->order;
                                        $this->db->order_by(key($order),$order[key($order)]);
                                    }


                            }

                    }
                
                # get datatables
            public function get_datatables()
                {
                        
                        $this->_get_datatables_query();

                        if($_POST['length'] != -1)
                            {
                                $this->db->limit($_POST['length'],$_POST['start']);
                            }

                        $query = $this->db->get()->result();
                        return $query;
                }
        
                # count filtered datatables
            public function count_filtered()
                {
                        
                        $this->_get_datatables_query();
                        $query = $this->db->get()->num_rows();
                        return $query;
                }

                # count all datatables
            public function count_all()
                {
                        
                    return $this->db->select('*')
                        ->from($this->tbl_pegawai)
                        ->count_all_results();
                }

            # get data pegawai yang belum mempunyai akun
            public function pegawai_nonakun()
                {
                    return $this->db->select('*')
                        ->from($this->tbl_pegawai)
                        ->where("id_pegawai NOT IN (SELECT id_pegawai FROM m_user where id_pegawai=id_pegawai ) AND status='1'")
                        ->get()
                        ->result();
                }

            public function pegawai_nontempat()
                {
                    return $this->db->select('*')
                        ->from($this->tbl_pegawai)
                        ->where("id_pegawai NOT IN (SELECT id_pegawai FROM penempatan ) AND status='1'")
                        ->get()
                        ->result();
                }
        }