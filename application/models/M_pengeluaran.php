<?php 
    class M_pengeluaran extends CI_Model
        {
            public function get_data($tabel)
            {
                return $this->db->get($tabel);
            }

            // ambil umkm pengeluaran 
            public function get_umkm_pengeluaran()
            {
                $this->db->select('u.nama_umkm, u.id_umkm');
                $this->db->from('pengeluaran as p');
                $this->db->join('umkm as u', 'u.id_umkm = p.id_umkm', 'inner');
                
                $this->db->group_by('u.id_umkm');
                
                return $this->db->get();
                
            }

            // ambil total pengeluaran 
            public function get_total_pengeluaran($dt)
            {
                $this->db->select('sum(a.nominal) as tot_nominal');
                
                $this->db->from('pengeluaran as a');
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

            protected $tbl_pengeluaran      = "pengeluaran";
            protected $tbl_umkm             = 'umkm';
            protected $tbl_pegawai          = "pegawai";

            private $kolom_order_umkm = array(
                null,
                '(nominal)::VARCHAR',
                
                
            );
            
            private $kolom_cari_umkm = array(
                '(nominal)::VARCHAR',
                
            );

            public function tambah_pengeluaran($data = array())
                {
                    return $this->db->insert($this->tbl_pengeluaran,$data);
                }

            public function hapus_pengeluaran($where = array())
                {
                    return $this->db->where($where)->delete($this->tbl_pengeluaran);
                }
            
            public function update_pengeluaran($where = array(), $data = array())
                {
                    return $this->db->where($where)->update($this->tbl_pengeluaran,$data);
                }

            public function tampil_pengeluaran()
                {
                    return $this->db->select($this->tbl_pengeluaran.".*,".$this->tbl_umkm.".nama_umkm,".$this->tbl_pegawai.".nama_pegawai")
                        ->from($this->tbl_pengeluaran)
                        ->join($this->tbl_umkm,$this->tbl_pengeluaran.".id_umkm=".$this->tbl_umkm.".id_umkm")
                        ->join($this->tbl_pegawai,$this->tbl_pegawai.".id_pegawai=".$this->tbl_pengeluaran.".add_by");
                }

            public function total_pengeluaran_umkm()
                {
                    if($this->session->userdata('cond_pengeluaran_umkm') != "")
                        {
                            $cond = $this->session->userdata('cond_pengeluaran_umkm');
                            return $this->db->select('SUM(nominal) as total')
                                ->from($this->tbl_pengeluaran)
                                ->where(array('id_umkm'=> $this->session->userdata('umkm')))
                                ->where($cond);
                            
                        }
                    else 
                        {
                            return $this->db->select('SUM(nominal) as total')
                                ->from($this->tbl_pengeluaran)
                                ->where(array('id_umkm'=> $this->session->userdata('umkm')));
                            
                        }
                }

            public function total_pengeluaran()
                {
                    if($this->session->userdata('cond_pengeluaran') != "")
                        {
                            $cond = $this->session->userdata('cond_pengeluaran');
                            return $this->db->select("SUM(nominal) as total")
                                ->from($this->tbl_pengeluaran)
                                ->join($this->tbl_umkm,$this->tbl_pengeluaran.".id_umkm=".$this->tbl_umkm.".id_umkm")
                                ->join($this->tbl_pegawai,$this->tbl_pegawai.".id_pegawai=".$this->tbl_pengeluaran.".add_by")
                                ->where($cond);
                            
                        }
                    else 
                        {
                            return $this->db->select("SUM(nominal) as total")
                                ->from($this->tbl_pengeluaran)
                                ->join($this->tbl_umkm,$this->tbl_pengeluaran.".id_umkm=".$this->tbl_umkm.".id_umkm")
                                ->join($this->tbl_pegawai,$this->tbl_pegawai.".id_pegawai=".$this->tbl_pengeluaran.".add_by");
                            
                        }
                }

            public  function _get_datatables_query_umkm()
                {
                        $bulan = date('m');
                        $tahun = date('Y');
                        $this->db->select('*')
                        ->from($this->tbl_pengeluaran)
                        ->where(array('id_umkm'=> $this->session->userdata('umkm')));
                        
                        if($this->session->userdata('cond_pengeluaran_umkm') != "")
                            {
                                $cond = $this->session->userdata('cond_pengeluaran_umkm');
                                $this->db->where($cond);
                            }
                        else 
                            {
                                $cond = "EXTRACT(MONTH FROM add_time) ='".$bulan."' AND EXTRACT(YEAR FROM add_time) ='".$tahun."' ";
                                $this->db->where($cond);
                            }
                        
                        $this->db->order_by('add_time','asc');

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
                                else 
                                    {
                                        $this->db->order_by('add_time','desc');
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
                                ->from($this->tbl_pengeluaran)
                                ->where(array('id_umkm'=> $this->session->userdata('umkm')))
                                ->where($cond)
                                ->count_all_results();
                            
                        }
                    else 
                        {
                            return$this->db->select('*')
                                ->from($this->tbl_pengeluaran)
                                ->where(array('id_umkm'=> $this->session->userdata('umkm')))
                                ->count_all_results();
                        }
                
                }

            var $kolom_order = array(
                null,
                'u.nama_umkm', 'CAST(a.add_time as VARCHAR)', 'a.pembelian', 'a.jumlah', 'CAST(a.nominal as VARCHAR)'
                
                
            );
            
            var $kolom_cari = array(
                
                'LOWER(u.nama_umkm)', 'CAST(a.add_time as VARCHAR)', 'CAST(a.pembelian as VARCHAR)', 'CAST(a.jumlah as VARCHAR)', 'CAST(a.nominal as VARCHAR)'
                
            );

            var $order1 = ['a.add_time' => 'desc'];

            var $kolom_order_2 = array(
                null,'CAST(a.add_time as VARCHAR)', 'a.pembelian', 'a.jumlah', 'CAST(a.nominal as VARCHAR)'
                
                
            );
            
            var $kolom_cari_2 = array(
                'CAST(a.add_time as VARCHAR)', 'CAST(a.pembelian as VARCHAR)', 'CAST(a.jumlah as VARCHAR)', 'CAST(a.nominal as VARCHAR)'
                
            );

            var $order1_2 = ['a.add_time' => 'desc'];


            # datatables admin
            public  function _get_datatables_query($dt)
                {
                        // $bulan = date('m');
                        // $tahun = date('Y');
                        // $this->db->select($this->tbl_pengeluaran.".*,".$this->tbl_umkm.".nama_umkm,".$this->tbl_pegawai.".nama_pegawai")
                        // ->from($this->tbl_pengeluaran)
                        // ->join($this->tbl_umkm,$this->tbl_pengeluaran.".id_umkm=".$this->tbl_umkm.".id_umkm")
                        // ->join($this->tbl_pegawai,$this->tbl_pegawai.".id_pegawai=".$this->tbl_pengeluaran.".add_by");
                        
                        // if($this->session->userdata('cond_pengeluaran') != "")
                        //     {
                        //         $cond = $this->session->userdata('cond_pengeluaran');
                        //         $this->db->where($cond);
                        //     }
                        // else 
                        //     {
                        //         $cond = "EXTRACT(MONTH FROM pengeluaran.add_time) ='".$bulan."' AND EXTRACT(YEAR FROM pengeluaran.add_time) ='".$tahun."' ";
                        //         $this->db->where($cond);
                        //     }
                        
                        // $this->db->order_by('pengeluaran.add_time','asc');

                        $this->db->select('a.add_time, u.nama_umkm, a.pembelian, a.jumlah, a.nominal');
                        $this->db->from('pengeluaran as a');
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
                            
                                else if(isset($this->order1))
                                    {
                                        $order = $this->order1;
                                        $this->db->order_by(key($order),$order[key($order)]);
                                    }
                                else 
                                    {
                                        $this->db->order_by('add_time','desc');
                                    }


                            }

                    }
            public  function _get_datatables_query_2($dt)
                {
                        $this->db->select('a.add_time, u.nama_umkm, a.pembelian, a.jumlah, a.nominal');
                        $this->db->from('pengeluaran as a');
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
                            
                                else if(isset($this->order1_2))
                                    {
                                        $order = $this->order1_2;
                                        $this->db->order_by(key($order),$order[key($order)]);
                                    }
                                else 
                                    {
                                        $this->db->order_by('add_time','desc');
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
                    
                    // if($this->session->userdata('cond_pengeluaran') != "")
                    //     {
                    //         $cond = $this->session->userdata('cond_pengeluaran');
                    //         return $this->db->select($this->tbl_pengeluaran.".*,".$this->tbl_umkm.".nama_umkm,".$this->tbl_pegawai.".nama_pegawai")
                    //             ->from($this->tbl_pengeluaran)
                    //             ->join($this->tbl_umkm,$this->tbl_pengeluaran.".id_umkm=".$this->tbl_umkm.".id_umkm")
                    //             ->join($this->tbl_pegawai,$this->tbl_pegawai.".id_pegawai=".$this->tbl_pengeluaran.".add_by")
                    //             ->where($cond)
                    //             ->count_all_results();
                            
                    //     }
                    // else 
                    //     {
                    //         return $this->db->select($this->tbl_pengeluaran.".*,".$this->tbl_umkm.".nama_umkm,".$this->tbl_pegawai.".nama_pegawai")
                    //             ->from($this->tbl_pengeluaran)
                    //             ->join($this->tbl_umkm,$this->tbl_pengeluaran.".id_umkm=".$this->tbl_umkm.".id_umkm")
                    //             ->join($this->tbl_pegawai,$this->tbl_pegawai.".id_pegawai=".$this->tbl_pengeluaran.".add_by")
                    //             ->count_all_results();
                    //     }

                    $this->db->select('a.add_time, u.nama_umkm, a.pembelian, a.jumlah, a.nominal');
                    $this->db->from('pengeluaran as a');
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
        }