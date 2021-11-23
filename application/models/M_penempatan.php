<?php 
    class M_penempatan extends CI_Model
        {
            protected $tbl_penempatan       = "penempatan";
            protected $tbl_umkm             = "umkm";
            protected $tbl_pegawai          = "pegawai";

            private $kolom_order = array(
                null,
                'lower(pegawai.nama_pegawai)',
                'lower(umkm.nama_umkm)',
                
                
            );
            
            private $kolom_cari = array(
                'lower(pegawai.nama_pegawai)',
                'lower(umkm.nama_umkm)',
                
            );

            public function tambah_penempatan($data = array())
                {
                    return $this->db->insert($this->tbl_penempatan,$data);
                }
            
            public function hapus_penempatan($where = array())
                {
                    return $this->db->where($where)->delete($this->tbl_penempatan);
                }
            
            public function update_penempatan($where = array(), $data = array())
                {
                    return $this->db->where($where)->update($this->tbl_penempatan,$data);
                }

            public function tampil_penempatan()
                {
                    return $this->db->select($this->tbl_penempatan.".*,".$this->tbl_pegawai.".nama_pegawai,".$this->tbl_umkm.".nama_umkm")
                        ->from($this->tbl_penempatan)
                        ->join($this->tbl_pegawai,$this->tbl_pegawai.".id_pegawai=".$this->tbl_penempatan.".id_pegawai")
                        ->join($this->tbl_umkm,$this->tbl_umkm.".id_umkm=".$this->tbl_penempatan.".id_umkm");
                }


            public  function _get_datatables_query()
                {
                    $this->db->select($this->tbl_penempatan.".*,".$this->tbl_pegawai.".nama_pegawai,".$this->tbl_umkm.".nama_umkm")
                        ->from($this->tbl_penempatan)
                        ->join($this->tbl_pegawai,$this->tbl_pegawai.".id_pegawai=".$this->tbl_penempatan.".id_pegawai")
                        ->join($this->tbl_umkm,$this->tbl_umkm.".id_umkm=".$this->tbl_penempatan.".id_umkm");
                        

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
                        
                    return $this->db->select($this->tbl_penempatan.".*,".$this->tbl_pegawai.".nama_pegawai,".$this->tbl_umkm.".nama_umkm")
                        ->from($this->tbl_penempatan)
                        ->join($this->tbl_pegawai,$this->tbl_pegawai.".id_pegawai=".$this->tbl_penempatan.".id_pegawai")
                        ->join($this->tbl_umkm,$this->tbl_umkm.".id_umkm=".$this->tbl_penempatan.".id_umkm")
                        ->count_all_results();
                }
        }