<?php 
    class M_pemasukan extends CI_Model
        {
            public function get_data($tabel)
            {
                return $this->db->get($tabel);
            }

            protected $tbl_pemasukan    = "pemasukan";
            protected $tbl_umkm         = 'umkm';

            private $kolom_order_umkm = array(
                null,
                '(nominal)::VARCHAR',
                
                
            );
            
            private $kolom_cari_umkm = array(
                '(nominal)::VARCHAR',
                
            );

            public function tambah_pemasukan($data = array())
                {
                    return $this->db->insert($this->tbl_pemasukan,$data);
                }

            public function hapus_pemasukan($where = array())
                {
                    return $this->db->where($where)->delete($this->tbl_pemasukan);
                }

            public function update_pemasukan($where = array(),$data = array())
                {
                    return $this->db->where($where)->update($this->tbl_pemasukan,$data);
                }

            public function tampil_pemasukan()
                {
                    return $this->db->select($this->tbl_pemasukan.".*,".$this->tbl_umkm.".nama_umkm")
                        ->from($this->tbl_pemasukan)
                        ->join($this->tbl_umkm,$this->tbl_pemasukan.".id_umkm=".$this->tbl_umkm.".id_umkm");
                }

            public  function _get_datatables_query_umkm()
                {
                        $this->db->select('*')
                        ->from($this->tbl_pemasukan)
                        ->where(array('id_umkm'=> $this->session->userdata('umkm')));
                        
                        if($this->session->userdata('cond_pemasukan_umkm') != "")
                            {
                                $cond = $this->session->userdata('cond_pemasukan_umkm');
                                $this->db->where($cond);
                            }
                        

                        $i =0;

                        foreach($this->kolom_cari_umkm as $kc)
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

                                        if(count($this->kolom_cari_umkm)-1 == $i)
                                            {
                                                $this->db->group_end();
                                            }

                                        $i++;
                                    }

                                if(isset($_POST['order']))
                                    {
                                        $this->db->order_by($this->kolom_order_umkm[$_POST['order'][0]['column']],$_POST['order'][0]['dir']);

                                    }
                                else if(isset($this->order))
                                    {
                                        $order = $this->order;
                                        $this->db->order_by(key($order),$order[key($order)]);
                                    }


                            }

                    }
                
                # get datatables
            public function get_datatables_umkm()
                {
                        
                        $this->_get_datatables_query_umkm();

                        if($_POST['length'] != -1)
                            {
                                $this->db->limit($_POST['length'],$_POST['start']);
                            }

                        $query = $this->db->get()->result();
                        return $query;
                }
        
                # count filtered datatables
            public function count_filtered_umkm()
                {
                        
                        $this->_get_datatables_query_umkm();
                        $query = $this->db->get()->num_rows();
                        return $query;
                }

                # count all datatables
            public function count_all_umkm()
                {
                    
                    if($this->session->userdata('cond_pemasukan_umkm') != "")
                        {
                            $cond = $this->session->userdata('cond_pemasukan_umkm');
                            return$this->db->select('*')
                                ->from($this->tbl_pemasukan)
                                ->where(array('id_umkm'=> $this->session->userdata('umkm')))
                                ->where($cond)
                                ->count_all_results();
                            
                        }
                    else 
                        {
                            return$this->db->select('*')
                                ->from($this->tbl_pemasukan)
                                ->where(array('id_umkm'=> $this->session->userdata('umkm')))
                                ->count_all_results();
                        }
                
                }

            public function total_pemasukan_umkm()
                {
                    if($this->session->userdata('cond_pemasukan_umkm') != "")
                        {
                            $cond = $this->session->userdata('cond_pemasukan_umkm');
                            return$this->db->select('SUM(nominal) as total')
                                ->from($this->tbl_pemasukan)
                                ->where(array('id_umkm'=> $this->session->userdata('umkm')))
                                ->where($cond);
                            
                        }
                    else 
                        {
                            return$this->db->select('SUM(nominal) as total')
                                ->from($this->tbl_pemasukan)
                                ->where(array('id_umkm'=> $this->session->userdata('umkm')));
                            
                        }
                }

            // ambil total pemasukan 
            public function get_total_pemasukan($dt)
            {
                $this->db->select('sum(a.nominal) as tot_nominal');
                
                $this->db->from('pemasukan as a');
                if ($dt['id_umkm'] != 'a') {
                    $this->db->where('a.id_umkm', $dt['id_umkm']);
                }
                if ($dt['tgl_awal'] != '' && $dt['tgl_akhir'] != '') {

                    $tgl_awal   = nice_date($dt['tgl_awal'], 'Y-m-d'); 
                    $tgl_akhir  = nice_date($dt['tgl_akhir'], 'Y-m-d');
        
                    $this->db->where("CAST(a.add_time AS VARCHAR) BETWEEN '$tgl_awal' AND '$tgl_akhir+2'");
                }

                return $this->db->get();
                
            }

            // ambil umkm pemasukan
            public function get_umkm_pemasukan()
            {
                $this->db->select('u.nama_umkm, u.id_umkm');
                
                $this->db->from('pemasukan as p');
                $this->db->join('umkm as u', 'u.id_umkm = p.id_umkm', 'inner');
                
                $this->db->group_by('u.id_umkm');
                
                return $this->db->get();
                
            }

            var $kolom_order = array(
                null,
                'u.nama_umkm', 'CAST(a.add_time as VARCHAR)', 'a.penjualan', 'a.jumlah', 'CAST(a.nominal as VARCHAR)'
                
                
            );
            
            var $kolom_cari = array(
                'LOWER(u.nama_umkm)', 'CAST(a.add_time as VARCHAR)', 'CAST(a.penjualan as VARCHAR)', 'CAST(a.jumlah as VARCHAR)', 'CAST(a.nominal as VARCHAR)'
                
            );

            var $order_p = ['a.add_time' => 'desc'];

            var $kolom_order_2 = array(
                null,'CAST(a.add_time as VARCHAR)', 'a.penjualan', 'a.jumlah', 'CAST(a.nominal as VARCHAR)'
                
                
            );
            
            var $kolom_cari_2 = array('CAST(a.add_time as VARCHAR)', 'CAST(a.penjualan as VARCHAR)', 'CAST(a.jumlah as VARCHAR)', 'CAST(a.nominal as VARCHAR)'
                
            );

            var $order_p_2 = ['a.add_time' => 'desc'];

            # datatables pemasukan (admin)
            public  function _get_datatables_query($dt)
                {
                        // $this->db->select($this->tbl_pemasukan.".*,".$this->tbl_umkm.".nama_umkm")
                        // ->from($this->tbl_pemasukan)
                        // ->join($this->tbl_umkm,$this->tbl_pemasukan.".id_umkm=".$this->tbl_umkm.".id_umkm");
                        
                        // if($this->session->userdata('cond_pemasukan') != "")
                        //     {
                        //         $cond = $this->session->userdata('cond_pemasukan');
                        //         $this->db->where($cond);
                        //     }

                        // $this->db->order_by('pemasukan.add_time');

                        $this->db->select('a.add_time, u.nama_umkm, a.penjualan, a.jumlah, a.nominal');
                        $this->db->from('pemasukan as a');
                        $this->db->join('umkm as u', 'u.id_umkm = a.id_umkm', 'inner');
                        
                        if ($dt['id_umkm'] != 'a') {
                            $this->db->where('u.id_umkm', $dt['id_umkm']);
                        }
                        if ($dt['tgl_awal'] != '' && $dt['tgl_akhir'] != '') {

                            $tgl_awal   = nice_date($dt['tgl_awal'], 'Y-m-d'); 
                            $tgl_akhir  = nice_date($dt['tgl_akhir'], 'Y-m-d');
                
                            $this->db->where("CAST(a.add_time AS VARCHAR) BETWEEN '$tgl_awal' AND '$tgl_akhir+2'");
                        }
                        
                        

                        $i =0;

                        $input_cari = strtolower($_POST['search']['value']);

                        foreach($this->kolom_cari as $kc)
                            {
                                if(isset($input_cari))
                                    {
                                        if($i == 0)
                                            {
                                                $this->db->group_start();
                                                $this->db->like($kc,$input_cari);
                                            }
                                        else
                                            {
                                                $this->db->or_like($kc,$input_cari);
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
                                else if(isset($this->order_p))
                                    {
                                        $order = $this->order_p;
                                        $this->db->order_by(key($order),$order[key($order)]);
                                    }


                            }

                    }

            public  function _get_datatables_query_2($dt)
                {

                        $this->db->select('a.add_time, u.nama_umkm, a.penjualan, a.jumlah, a.nominal');
                        $this->db->from('pemasukan as a');
                        $this->db->join('umkm as u', 'u.id_umkm = a.id_umkm', 'inner');
                        
                        if ($dt['id_umkm'] != 'a') {
                            $this->db->where('u.id_umkm', $dt['id_umkm']);
                        }
                        if ($dt['tgl_awal'] != '' && $dt['tgl_akhir'] != '') {

                            $tgl_awal   = nice_date($dt['tgl_awal'], 'Y-m-d'); 
                            $tgl_akhir  = nice_date($dt['tgl_akhir'], 'Y-m-d');
                
                            $this->db->where("CAST(a.add_time AS VARCHAR) BETWEEN '$tgl_awal' AND '$tgl_akhir+2'");
                        }
                        
                        

                        $i =0;

                        $input_cari = strtolower($_POST['search']['value']);

                        foreach($this->kolom_cari_2 as $kc)
                            {
                                if(isset($input_cari))
                                    {
                                        if($i == 0)
                                            {
                                                $this->db->group_start();
                                                $this->db->like($kc,$input_cari);
                                            }
                                        else
                                            {
                                                $this->db->or_like($kc,$input_cari);
                                            }

                                        if(count($this->kolom_cari_2)-1 == $i)
                                            {
                                                $this->db->group_end();
                                            }

                                        $i++;
                                    }

                                if(isset($_POST['order']))
                                    {
                                        $this->db->order_by($this->kolom_order_2[$_POST['order'][0]['column']],$_POST['order'][0]['dir']);

                                    }
                                else if(isset($this->order_p_2))
                                    {
                                        $order = $this->order_p_2;
                                        $this->db->order_by(key($order),$order[key($order)]);
                                    }


                            }

                    }
                
                # get datatables
            public function get_datatables($dt)
                {
                        if ($this->session->userdata('umkm') == '') {
                            $this->_get_datatables_query($dt);
                        } else {
                            $this->_get_datatables_query_2($dt);
                        }

                        if($_POST['length'] != -1)
                            {
                                $this->db->limit($_POST['length'],$_POST['start']);
                            }

                        $query = $this->db->get()->result();
                        return $query;
                }
        
                # count filtered datatables
            public function count_filtered($dt)
                {
                    if ($this->session->userdata('umkm') == '') {
                        $this->_get_datatables_query($dt);
                    } else {
                        $this->_get_datatables_query_2($dt);
                    }
                        
                    $query = $this->db->get()->num_rows();
                    return $query;
                }

                # count all datatables
            public function count_all($dt)
                {
                    
                    // if($this->session->userdata('cond_pemasukan') != "")
                    //     {
                    //         $cond = $this->session->userdata('cond_pemasukan');
                    //         return $this->db->select($this->tbl_pemasukan.".*,".$this->tbl_umkm.".nama_umkm")
                    //             ->from($this->tbl_pemasukan)
                    //             ->join($this->tbl_umkm,$this->tbl_pemasukan.".id_umkm=".$this->tbl_umkm.".id_umkm")
                    //             ->where($cond)
                    //             ->count_all_results();
                            
                    //     }
                    // else 
                    //     {
                    //         return $this->db->select($this->tbl_pemasukan.".*,".$this->tbl_umkm.".nama_umkm")
                    //             ->from($this->tbl_pemasukan)
                    //             ->join($this->tbl_umkm,$this->tbl_pemasukan.".id_umkm=".$this->tbl_umkm.".id_umkm")
                    //             ->count_all_results();
                    //     }

                    $this->db->select('a.add_time, u.nama_umkm, a.penjualan, a.jumlah, a.nominal');
                    $this->db->from('pemasukan as a');
                    $this->db->join('umkm as u', 'u.id_umkm = a.id_umkm', 'inner');
                    
                    if ($dt['id_umkm'] != 'a') {
                        $this->db->where('u.id_umkm', $dt['id_umkm']);
                    }
                    if ($dt['tgl_awal'] != '' && $dt['tgl_akhir'] != '') {

                        $tgl_awal   = nice_date($dt['tgl_awal'], 'Y-m-d'); 
                        $tgl_akhir  = nice_date($dt['tgl_akhir'], 'Y-m-d');
            
                        $this->db->where("CAST(a.add_time AS VARCHAR) BETWEEN '$tgl_awal' AND '$tgl_akhir+2'");
                    }

                    return $this->db->count_all_results();
                    
                
                }


            public function total_pemasukan()
                {
                    // echo $this->session->userdata('cond_pemasukan');exit();
                    
                    if($this->session->userdata('cond_pemasukan') != "")
                        {
                            // echo "k";
                            $cond = $this->session->userdata('cond_pemasukan');
                            return $this->db->select("SUM(nominal) as total")
                                ->from($this->tbl_pemasukan)
                                ->join($this->tbl_umkm,$this->tbl_pemasukan.".id_umkm=".$this->tbl_umkm.".id_umkm")
                                ->where($cond)
                                ->get()
                                ->row_array();
                            
                        }
                    else 
                        {
                          
                            return $this->db->select("SUM(nominal) as total")
                                ->from($this->tbl_pemasukan)
                                ->join($this->tbl_umkm,$this->tbl_pemasukan.".id_umkm=".$this->tbl_umkm.".id_umkm")
                                ->get()
                                ->row_array();
                        }
                
                }
        }