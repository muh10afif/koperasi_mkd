<?php 

defined('BASEPATH') OR exit('No direct script access allowed');

class M_saldo extends CI_Model {

    public function get_data($tabel)
    {
        return $this->db->get($tabel);
    }

    public function input_data($tabel, $data)
    {
        $this->db->insert($tabel, $data);
    }

    public function ubah_data($tabel, $data, $where)
    {
        return $this->db->update($tabel, $data, $where);
    }

    public function hapus_data($tabel, $where)
    {
        $this->db->delete($tabel, $where);
    }

    public function cari_data($tabel, $where)
    {
        return $this->db->get_where($tabel, $where);  
    }

    public function cari_data_saldo($id_umkm, $tgl_transaksi)
    {
        $this->db->from('tr_saldo');
        $this->db->where('id_umkm', $id_umkm);
        $this->db->where("to_char(add_time, 'yyyy-mm-dd')", $tgl_transaksi);
        $this->db->order_by('add_time', 'asc');
        
        return $this->db->get();
        
    }

    // cari saldo awal 
    public function cari_saldo($tgl, $id_umkm)
    {
        $this->db->from('log_modal');
        $this->db->where("CAST(tanggal_pencatatan as VARCHAR) LIKE '%$tgl%'");
        $this->db->where('id_umkm', $id_umkm);
        $this->db->order_by('id_log_modal', 'desc');
        
        return $this->db->get();
        
    }

    public function cari_saldo_2($tgl, $id_umkm)
    {
        $this->db->from('log_modal');
        $this->db->where("CAST(tanggal_pencatatan as VARCHAR) LIKE '%$tgl%'");
        $this->db->where('id_umkm', $id_umkm);
        $this->db->order_by('id_log_modal', 'desc');
        $this->db->limit(1);
        
        return $this->db->get();
        
    }

    public function cari_saldo_pen($tanggal_tr, $id_umkm)
    {
        $this->db->from('log_modal');
        $this->db->where('id_umkm', $id_umkm);
        $this->db->where('tanggal_pencatatan', $tanggal_tr);
        $this->db->order_by('id_log_modal', 'desc');
        
        return $this->db->get();
    }

    public function cari_saldo_pen_2($tanggal_tr, $id_umkm)
    {
        $this->db->from('log_modal');
        $this->db->where('id_umkm', $id_umkm);
        $this->db->where('tanggal_pencatatan', $tanggal_tr);
        $this->db->order_by('add_time', 'desc');
        
        return $this->db->get();
    }

    public function cari_data_tgl_tr($tabel, $date, $id_umkm)
    {
        $this->db->where("CAST(tanggal_transaksi as VARCHAR) LIKE '%$date%'");
        $this->db->where('id_umkm', $id_umkm);
        
        
        return $this->db->get($tabel);
    }

    public function get_data_saldo_detail()
    {
        # code...
    }

    public function cari_data_detail($tabel, $id_pen, $id_umkm)
    {
        if ($tabel == 'pemasukan') {
            $this->db->select('p.id_umkm, p.add_time, p.nominal, p.saldo, u.nama_umkm, p.penjualan, p.jumlah, p.id_pemasukan, p.id_pencatatan');
        } else {
            $this->db->select('p.id_umkm, p.add_time, p.nominal, p.saldo, u.nama_umkm, p.pembelian, p.jumlah, p.id_pengeluaran, p.id_pencatatan');
        }
        
        $this->db->from("$tabel as p");
        $this->db->join('umkm as u', 'u.id_umkm = p.id_umkm', 'inner');
        $this->db->where('p.id_pencatatan', $id_pen);
        $this->db->where('p.id_umkm', $id_umkm);
        
        return $this->db->get();
    }

    public function get_total_saldo($dt)
    {
        $this->db->select("u.nama_umkm, pen.tanggal_transaksi, pen.judul_pencatatan, u.id_umkm, pen.id_pencatatan, (select sum(nominal) as tot_debit FROM pemasukan WHERE id_umkm=u.id_umkm and pemasukan.id_pencatatan = pen.id_pencatatan), (select sum(nominal) as tot_kredit FROM pengeluaran WHERE id_umkm=u.id_umkm and pengeluaran.id_pencatatan = pen.id_pencatatan)");
        $this->db->from('umkm as u');
        $this->db->join('pencatatan as pen', 'pen.id_umkm = u.id_umkm', 'inner');
        $this->db->group_by('u.id_umkm');
        $this->db->group_by('pen.id_pencatatan');

        if ($this->session->userdata('umkm') != '') {
            $a = $dt['tanggal'];

            $this->db->where("CAST(pen.tanggal_transaksi AS VARCHAR) LIKE '%$a%'");

            $this->db->where('u.id_umkm', $dt['id_umkm']);
        } else {
            if ($dt['id_umkm'] != 'a') {
                $this->db->where('u.id_umkm', $dt['id_umkm']);
            }
        }

        
        if ($dt['tgl_awal'] != '' && $dt['tgl_akhir'] != '') {

            $tgl_awal   = nice_date($dt['tgl_awal'], 'Y-m-d'); 
            $tgl_akhir  = nice_date($dt['tgl_akhir'], 'Y-m-d');

            $this->db->where("CAST(pen.tanggal_transaksi AS VARCHAR) BETWEEN '$tgl_awal' AND '$tgl_akhir+2'");
        }

        return $this->db->get();
        
    }

    public function get_datatables($dt)
    {
        if ($this->session->userdata('umkm') == '') {
            $this->_get_datatables_query($dt);
        } else {
            $this->_get_datatables_query_2($dt);
        }
        

        if ($this->input->post('length') != -1) {
            $this->db->limit($this->input->post('length'), $this->input->post('start'));
            
            return $this->db->get()->result();
        }
    }

    var $kolom_order = [null, 'u.nama_umkm', 'CAST(pen.tanggal_transaksi as VARCHAR)', 'pen.judul_pencatatan'];
    var $kolom_cari  = ['LOWER(u.nama_umkm)', 'CAST(pen.tanggal_transaksi as VARCHAR)', 'LOWER(pen.judul_pencatatan)'];
    var $order       = ['CAST(pen.tanggal_transaksi as VARCHAR)' => 'asc'];

    var $kolom_order_2 = [null, 'CAST(pen.tanggal_transaksi as VARCHAR)', 'pen.judul_pencatatan'];
    var $kolom_cari_2  = ['CAST(pen.tanggal_transaksi as VARCHAR)', 'LOWER(pen.judul_pencatatan)'];
    var $order_2       = ['CAST(pen.tanggal_transaksi as VARCHAR)' => 'asc'];

    public function _get_datatables_query($dt)
    {
        // SELECT u.nama_umkm, pen.tanggal_transaksi, pen.judul_pencatatan, u.id_umkm, (select sum(nominal) as debit FROM pemasukan WHERE id_umkm=u.id_umkm), (select sum(nominal) as kredit FROM pengeluaran WHERE id_umkm=u.id_umkm)
        // FROM umkm as u 
        // left JOIN pencatatan as pen ON pen.id_umkm = u.id_umkm
        // GROUP BY u.id_umkm, pen.id_pencatatan
        // ORDER BY u.nama_umkm ASC

        $this->db->select("u.nama_umkm, pen.tanggal_transaksi, pen.judul_pencatatan, u.id_umkm, pen.id_pencatatan, (select sum(nominal) as tot_debit FROM pemasukan WHERE id_umkm=u.id_umkm and id_pencatatan=pen.id_pencatatan), (select sum(nominal) as tot_kredit FROM pengeluaran WHERE id_umkm=u.id_umkm and id_pencatatan=pen.id_pencatatan)");
        $this->db->from('umkm as u');
        $this->db->join('pencatatan as pen', 'pen.id_umkm = u.id_umkm', 'inner');
        $this->db->group_by('u.id_umkm');
        $this->db->group_by('pen.id_pencatatan');

        if ($dt['id_umkm'] != 'a') {
            $this->db->where('u.id_umkm', $dt['id_umkm']);
        }
        if ($dt['tgl_awal'] != '' && $dt['tgl_akhir'] != '') {

            $tgl_awal   = nice_date($dt['tgl_awal'], 'Y-m-d'); 
            $tgl_akhir  = nice_date($dt['tgl_akhir'], 'Y-m-d');

            $this->db->where("CAST(pen.tanggal_transaksi AS VARCHAR) BETWEEN '$tgl_awal' AND '$tgl_akhir+2'");
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

    public function _get_datatables_query_2($dt)
    {
        $this->db->select("u.nama_umkm, pen.tanggal_transaksi, pen.judul_pencatatan, u.id_umkm, pen.id_pencatatan, (select sum(nominal) as tot_debit FROM pemasukan WHERE id_umkm=u.id_umkm and id_pencatatan=pen.id_pencatatan), (select sum(nominal) as tot_kredit FROM pengeluaran WHERE id_umkm=u.id_umkm and id_pencatatan=pen.id_pencatatan)");
        $this->db->from('umkm as u');
        $this->db->join('pencatatan as pen', 'pen.id_umkm = u.id_umkm', 'inner');
        $this->db->group_by('u.id_umkm');
        $this->db->group_by('pen.id_pencatatan');

        $a = $dt['tanggal'];

        $this->db->where("CAST(pen.tanggal_transaksi AS VARCHAR) LIKE '%$a%'");
        
        if ($dt['id_umkm'] != 'a') {
            $this->db->where('u.id_umkm', $dt['id_umkm']);
        }
        if ($dt['tgl_awal'] != '' && $dt['tgl_akhir'] != '') {

            $tgl_awal   = nice_date($dt['tgl_awal'], 'Y-m-d'); 
            $tgl_akhir  = nice_date($dt['tgl_akhir'], 'Y-m-d');

            $this->db->where("CAST(pen.tanggal_transaksi AS VARCHAR) BETWEEN '$tgl_awal' AND '$tgl_akhir+2'");
        }
        
        $b = 0;

        $input_cari = strtolower($_POST['search']['value']);
        $kolom_cari = $this->kolom_cari_2;

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

            $kolom_order = $this->kolom_order_2;
            $this->db->order_by($kolom_order[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
            
        } elseif (isset($this->order_2)) {
            
            $order = $this->order_2;
            $this->db->order_by(key($order), $order[key($order)]);
            
        }

    }

    public function count_all($dt)
    {
        $this->db->select("u.nama_umkm, pen.tanggal_transaksi, pen.judul_pencatatan, u.id_umkm, pen.id_pencatatan, (select sum(nominal) as tot_debit FROM pemasukan WHERE id_umkm=u.id_umkm and to_char(pemasukan.add_time, 'yyyy-mm-dd') = pen.tanggal_transaksi::VARCHAR), (select sum(nominal) as tot_kredit FROM pengeluaran WHERE id_umkm=u.id_umkm and to_char(pengeluaran.add_time, 'yyyy-mm-dd') = pen.tanggal_transaksi::VARCHAR)");
        $this->db->from('umkm as u');
        $this->db->join('pencatatan as pen', 'pen.id_umkm = u.id_umkm', 'left');
        $this->db->group_by('u.id_umkm');
        $this->db->group_by('pen.id_pencatatan');

        if ($dt['id_umkm'] != 'a') {
            $this->db->where('u.id_umkm', $dt['id_umkm']);
        }
        if ($dt['tgl_awal'] != '' && $dt['tgl_akhir'] != '') {

            $tgl_awal   = nice_date($dt['tgl_awal'], 'Y-m-d'); 
            $tgl_akhir  = nice_date($dt['tgl_akhir'], 'Y-m-d');

            $this->db->where("CAST(pen.tanggal_transaksi AS VARCHAR) BETWEEN '$tgl_awal' AND '$tgl_akhir+2'");
        }

        return $this->db->count_all_results();
    }

    public function count_filtered($dt)
    {
        if ($this->session->userdata('umkm') == '') {
            $this->_get_datatables_query($dt);
        } else {
            $this->_get_datatables_query_2($dt);
        }
        return $this->db->get()->num_rows();
        
    }

}

/* End of file M_saldo.php */
