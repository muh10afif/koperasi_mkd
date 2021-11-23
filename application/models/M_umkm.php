<?php 
    class M_umkm extends CI_Model
        {
            protected $tbl_umkm     = "umkm";

            private $kolom_order = array(
                null,
                'lower(nama_umkm)',
                'lower(alamat)',
                
            );
            
            private $kolom_cari = array(
                'lower(nama_umkm)',
                'lower(alamat)',
                
            );

            # tambah umkm
            public function tambah_umkm($data = array())
                {
                    return $this->db->insert($this->tbl_umkm,$data);
                }
            
            # hapus umkm
            public function hapus_umkm($where = array())
                {
                    return $this->db->where($where)->delete($this->tbl_umkm);
                }
            
            # update umkm
            public function update_umkm($where = array(), $data = array())
                {
                    return $this->db->where($where)->update($this->tbl_umkm,$data);
                }

            # tampil umkm
            public function tampil_umkm()
                {
                    return $this->db->select('*')
                        ->from($this->tbl_umkm);
                }

            # datatables 
            public  function _get_datatables_query()
                {
                        $this->db->select('*');
                        $this->db->from('umkm');
                        

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

                    $this->db->select('*');
                    $this->db->from('umkm');
                   

                    return $this->db->count_all_results();
                        
                }
        }