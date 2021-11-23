<?php 
    class M_user extends CI_Model
        {
            protected $tbl_user     = "m_user"; 
            protected $tbl_pegawai  = 'pegawai';

            public function ubah_user($data, $id_user)
            {
                return $this->db->update('m_user', $data, array('id_user' => $id_user));
            }

            private $kolom_order = array(
                null,
                'lower(pegawai.nama_pegawai)',
                'lower(m_user.username)',
                'lower(m_user.password)',
                
            );
            
            private $kolom_cari = array(
                'lower(pegawai.nama_pegawai)',
                'lower(m_user.username)',
                'lower(m_user.password)',
                
            );

            public function tambah_user($data = array())
                {
                    return $this->db->insert($this->tbl_user,$data);
                }

            public function hapus_user($where = array())
                {
                    return $this->db->where($where)->delete($this->tbl_user);
                }

            public function update_user($where = array(), $data = array())
                {
                    return $this->db->where($where)->update($this->tbl_user,$data);
                }

            public function tampil_user()
                {
                    return $this->db->select('*')
                        ->from($this->tbl_user);
                }

            public function tampil_user_2()
                {
                    return $this->db->select($this->tbl_user.".*,".$this->tbl_pegawai.".*")
                        ->from($this->tbl_user)
                        ->join($this->tbl_pegawai,$this->tbl_user.".id_pegawai=".$this->tbl_pegawai.".id_pegawai");
                }

            public function tampil_detail_user()
                {
                    return $this->db->select($this->tbl_user.".*,".$this->tbl_pegawai.".*")
                        ->from($this->tbl_user)
                        ->join($this->tbl_pegawai,$this->tbl_user.".id_pegawai=".$this->tbl_pegawai.".id_pegawai");
                }

            public  function _get_datatables_query()
                {
                    $this->db->select($this->tbl_user.".*,".$this->tbl_pegawai.".*")
                        ->from($this->tbl_user)
                        ->join($this->tbl_pegawai,$this->tbl_user.".id_pegawai=".$this->tbl_pegawai.".id_pegawai");
                        
                        

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
                        
                    return $this->db->select($this->tbl_user.".*,".$this->tbl_pegawai.".*")
                        ->from($this->tbl_user)
                        ->join($this->tbl_pegawai,$this->tbl_user.".id_pegawai=".$this->tbl_pegawai.".id_pegawai")
                        ->count_all_results();
                }

            
        }