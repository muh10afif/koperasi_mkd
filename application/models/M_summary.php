<?php 

defined('BASEPATH') OR exit('No direct script access allowed');

class M_summary extends CI_Model {

    public function get_data($tabel)
    {
        return $this->db->get($tabel);
    }

    public function cari_data($tabel, $where)
    {
        return $this->db->get_where($tabel, $where); 
    }

    public function get_data_summary_baru_2($tanggal)
    {
        // $this->db->from('umkm as u');
        // $this->db->group_by('u.id_umkm');
        // $this->db->order_by('u.id_umkm', 'asc');

        $this->db->from('pencatatan as p');
        $this->db->join('umkm as u', 'u.id_umkm = p.id_umkm', 'inner');
        

        $hasil = $this->db->get()->result_array();

        foreach ($hasil as $h) {
            $id_umkm = $h['id_umkm'];
            $nm_umkm = $h['nama_umkm'];

            $this->db->from('pencatatan');
            $this->db->where('id_umkm', $id_umkm);

            $hasil_2 = $this->db->get()->result_array();

            $tg = array();

            foreach ($hasil_2 as $h2) {
                
                array_push($tg, nice_date($h2['tanggal_transaksi'], 'Y-m'));

            }

            $ab = array_unique($tg);

            $tt = date_format(date_create($tanggal),'Y-m');

            if (in_array($tt, $ab)) {

                foreach ($ab as $a) {

                    $this->db->select('sum(nominal) tot_pengeluaran');
                    $this->db->from('pengeluaran as p');
                    $this->db->join('pencatatan as pe', 'pe.id_pencatatan = p.id_pencatatan', 'inner');

                    if ($tanggal != '') {
                        $tgl_l = nice_date($tanggal, 'Y-m');
                        $this->db->where("CAST(pe.tanggal_transaksi as VARCHAR) LIKE '%$tgl_l%'");
                    } else {
                        $this->db->where("CAST(pe.tanggal_transaksi as VARCHAR) LIKE '%$a%'");
                    }

                    $hasil_peng = $this->db->get()->row_array();

                    $this->db->select('sum(nominal) tot_pemasukan');
                    $this->db->from('pemasukan as p');
                    $this->db->join('pencatatan as pe', 'pe.id_pencatatan = p.id_pencatatan', 'inner');
                    
                    if ($tanggal != '') {
                        $tgl_l = nice_date($tanggal, 'Y-m');
                        $this->db->where("CAST(pe.tanggal_transaksi as VARCHAR) LIKE '%$tgl_l%'");
                    } else {
                        $this->db->where("CAST(pe.tanggal_transaksi as VARCHAR) LIKE '%$a%'");
                    }

                    $hasil_pem = $this->db->get()->row_array();

                    $value[] = [ 'id_umkm'     => $id_umkm,
                                'nama_umkm'    => $nm_umkm,
                                'bulan'        => $a,
                                'pemasukan'    => $hasil_pem['tot_pemasukan'],
                                'pengeluaran'  => $hasil_peng['tot_pengeluaran'],
                                'laba'         => $hasil_pem['tot_pemasukan'] - $hasil_peng['tot_pengeluaran']
                                ];

                }

                return $value;
            
            } else {

                $value[] = ['id_umkm'      => '',
                            'nama_umkm'    => '',
                            'bulan'        => '',
                            'pemasukan'    => '',
                            'pengeluaran'  => '',
                            'laba'         => ''
                        ];

                    return $value;

            }

            

        }
        
    }

    public function get_data_summary_baru($tgl)
    {
        $this->db->select("u.nama_umkm, pen.judul_pencatatan, u.id_umkm, pen.id_pencatatan, (select sum(nominal) as tot_pemasukan FROM pemasukan join pencatatan ON pencatatan.id_pencatatan = pemasukan.id_pencatatan WHERE pen.id_umkm=u.id_umkm and pemasukan.id_pencatatan=pen.id_pencatatan and to_char(pencatatan.tanggal_transaksi, 'yyyy-mm') = to_char(pen.tanggal_transaksi, 'yyyy-mm')), (select sum(nominal) as tot_pengeluaran FROM pengeluaran join pencatatan ON pencatatan.id_pencatatan = pengeluaran.id_pencatatan WHERE pen.id_umkm=u.id_umkm and pengeluaran.id_pencatatan=pen.id_pencatatan and to_char(pencatatan.tanggal_transaksi, 'yyyy-mm') = to_char(pen.tanggal_transaksi, 'yyyy-mm'))");
        $this->db->from('umkm as u');
        $this->db->join('pencatatan as pen', 'pen.id_umkm = u.id_umkm', 'left');
        $this->db->group_by('u.id_umkm');
        $this->db->group_by('pen.id_pencatatan');

        if ($tgl != '') {
            $tgl = nice_date($tgl, 'Y-m');

            $this->db->where("CAST(pen.tanggal_transaksi as VARCHAR) LIKE '%$tgl%'");
        } 

        return $this->db->get();
        
    }

    public function get_datatables($tgl)
    {
        $this->_get_datatables_query($tgl);

        if ($this->input->post('length') != -1) {
            $this->db->limit($this->input->post('length'), $this->input->post('start'));
            
            return $this->db->get()->result();
        }
    }

    var $kolom_order = [null, 'LOWER(u.nama_umkm)', 'CAST(pen.tanggal_transaksi as VARCHAR)'];
    var $kolom_cari  = ['LOWER(u.nama_umkm)', 'CAST(pen.tanggal_transaksi as VARCHAR)'];
    var $order       = ['pen.tanggal_transaksi' => 'asc'];

    public function _get_datatables_query($tgl)
    {
        $this->db->select("u.nama_umkm, pen.tanggal_transaksi, pen.judul_pencatatan, u.id_umkm, pen.id_pencatatan, (select sum(nominal) as tot_pemasukan FROM pemasukan WHERE id_umkm=u.id_umkm and id_pencatatan=pen.id_pencatatan), (select sum(nominal) as tot_pengeluaran FROM pengeluaran WHERE id_umkm=u.id_umkm and id_pencatatan=pen.id_pencatatan), COALESCE((select sum(nominal) as tot_pemasukan1 FROM pemasukan WHERE id_umkm=u.id_umkm and id_pencatatan=pen.id_pencatatan), 0) - COALESCE((select sum(nominal) as tot_pengeluaran1 FROM pengeluaran WHERE id_umkm=u.id_umkm and id_pencatatan=pen.id_pencatatan), 0) as laba");
        $this->db->from('umkm as u');
        $this->db->join('pencatatan as pen', 'pen.id_umkm = u.id_umkm', 'left');
        $this->db->group_by('u.id_umkm');
        $this->db->group_by('pen.id_pencatatan');

        if ($tgl != '') {
            $tgl = nice_date($tgl, 'Y-m');

            $this->db->where("CAST(pen.tanggal_transaksi as VARCHAR) LIKE '%$tgl%'");
        } 

        $b = 0;

        $input_cari = strtolower($_POST['search']['value']);
        $kolom_cari = $this->kolom_cari;

        foreach ($kolom_cari as $cari) {
            if ($input_cari) {
                if ($b === 0) {
                    $this->db->group_start();
                    $this->db->like($cari, $input_cari);
                } else {
                    $this->db->or_like($cari, $input_cari);
                }

                if ((count($kolom_cari) - 1) == $b ) {
                    $this->db->group_end();
                }
            }

            $b++;
        }

        if (isset($_POST['order'])) {

            $kolom_order = $this->kolom_order;
            $this->db->order_by($kolom_order[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
            
        } elseif (isset($this->order)) {
            
            $order = $this->order;
            $this->db->order_by(key($order), $order[key($order)]);
            
        }
    }

    public function count_all($tgl)
    {
        $this->db->select("u.nama_umkm, pen.tanggal_transaksi, pen.judul_pencatatan, u.id_umkm, pen.id_pencatatan, (select sum(nominal) as tot_pemasukan FROM pemasukan WHERE id_umkm=u.id_umkm and id_pencatatan=pen.id_pencatatan), (select sum(nominal) as tot_pengeluaran FROM pengeluaran WHERE id_umkm=u.id_umkm and  id_pencatatan=pen.id_pencatatan), COALESCE((select sum(nominal) as tot_pemasukan1 FROM pemasukan WHERE id_umkm=u.id_umkm and id_pencatatan=pen.id_pencatatan), 0) - COALESCE((select sum(nominal) as tot_pengeluaran1 FROM pengeluaran WHERE id_umkm=u.id_umkm and id_pencatatan=pen.id_pencatatan), 0) as laba");
        $this->db->from('umkm as u');
        $this->db->join('pencatatan as pen', 'pen.id_umkm = u.id_umkm', 'left');
        $this->db->group_by('u.id_umkm');
        $this->db->group_by('pen.id_pencatatan');

        if ($tgl != '') {
            $tgl = nice_date($tgl, 'Y-m');

            $this->db->where("CAST(pen.tanggal_transaksi as VARCHAR) LIKE '%$tgl%'");
        } 

        return $this->db->count_all_results();
        
    }

    public function count_filtered($tgl)
    {
        $this->_get_datatables_query($tgl);
        return $this->db->get()->num_rows();
        
    }

    public function get_total_laba($tgl)
    {
        $this->db->select("u.nama_umkm, pen.tanggal_transaksi, pen.judul_pencatatan, u.id_umkm, pen.id_pencatatan, (select sum(nominal) as tot_pemasukan FROM pemasukan WHERE id_umkm=u.id_umkm), (select sum(nominal) as tot_pengeluaran FROM pengeluaran WHERE id_umkm=u.id_umkm), COALESCE((select sum(nominal) as tot_pemasukan1 FROM pemasukan WHERE id_umkm=u.id_umkm), 0) - COALESCE((select sum(nominal) as tot_pengeluaran1 FROM pengeluaran WHERE id_umkm=u.id_umkm), 0) as laba");
        $this->db->from('umkm as u');
        $this->db->join('pencatatan as pen', 'pen.id_umkm = u.id_umkm', 'left');
        $this->db->group_by('u.id_umkm');
        $this->db->group_by('pen.id_pencatatan');

        if ($tgl != '') {
            $tgl = nice_date($tgl, 'Y-m');

            $this->db->where("CAST(pen.tanggal_transaksi as VARCHAR) LIKE '%$tgl%'");
        } 

        return $this->db->get();
        
    }

    public function cari_data_detail_sum($tabel, $id_umkm, $bulan)
    {
        if ($tabel == 'pemasukan') {
            $this->db->select('p.id_umkm, pe.tanggal_transaksi as add_time, p.nominal, p.saldo, u.nama_umkm, p.penjualan, p.jumlah');
        } else {
            $this->db->select('p.id_umkm, pe.tanggal_transaksi as add_time, p.nominal, p.saldo, u.nama_umkm, p.pembelian, p.jumlah');
        }
        
        $this->db->from("$tabel as p");
        $this->db->join('umkm as u', 'u.id_umkm = p.id_umkm', 'inner');
        $this->db->join('pencatatan as pe', 'pe.id_pencatatan = p.id_pencatatan', 'inner');
        
        
        $this->db->where('p.id_umkm', $id_umkm); 

        if ($bulan != '') {
            $bulan = nice_date($bulan, 'Y-m');

            $this->db->where("CAST(p.add_time as VARCHAR) LIKE '%$bulan%'");
            
        }
        
        return $this->db->get();
    }

    public function cari_data_detail_sum_admin($tabel, $id_umkm, $cr, $bulan_s)
    {
        $this->db->from('pencatatan');
        $this->db->where('id_umkm', $id_umkm);
        $this->db->where("CAST(tanggal_transaksi as VARCHAR) LIKE '%$bulan_s%'");
        
        $hasil = $this->db->get();
        
        $cc = array();
        foreach ($hasil->result_array() as $k) {
            array_push($cc, $k['id_pencatatan']);
        }

        $kecil = min($cc);
        $besar = max($cc);

        if ($tabel == 'pemasukan') {
            $this->db->select('p.id_umkm, pe.tanggal_transaksi as add_time, p.nominal, p.saldo, u.nama_umkm, p.penjualan, p.jumlah');
        } else {
            $this->db->select('p.id_umkm, pe.tanggal_transaksi as add_time, p.nominal, p.saldo, u.nama_umkm, p.pembelian, p.jumlah');
        }
        
        $this->db->from("$tabel as p");
        $this->db->join('umkm as u', 'u.id_umkm = p.id_umkm', 'inner');
        $this->db->join('pencatatan as pe', 'pe.id_pencatatan = p.id_pencatatan', 'inner');
        $this->db->where("p.id_pencatatan BETWEEN $kecil AND $besar");
        
        $this->db->where('p.id_umkm', $id_umkm); 

        if ($cr['tgl_awal'] != '' && $cr['tgl_akhir'] != '') {

            $tgl_awal   = nice_date($cr['tgl_awal'], 'Y-m-d'); 
            $tgl_akhir  = nice_date($cr['tgl_akhir'], 'Y-m-d');

            $this->db->where("CAST(pe.tanggal_transaksi AS VARCHAR) BETWEEN '$tgl_awal' AND '$tgl_akhir+2'");
        }
        
        return $this->db->get();
    }

}

/* End of file M_summary.php */
