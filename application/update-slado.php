// tentukan saldo terakhir
if ($cari_1->num_rows() == 0) {
    $saldo_terakhir = 0;
} else {

    // jika tanggal transaksi tidak ada
    if ($cari_2->num_rows() == 0) {
        $c = $cari_1->row_array();
        $saldo_terakhir = $c['nominal'];
    } else {
        $d = $cari_2->row_array();
        $saldo_terakhir = $d['nominal'];
    }
    
}


$c = $cari_1->row_array();

$tgl_akhir = strtotime($c['tanggal_pencatatan']);
$tgl_input = strtotime($tanggal_tr);

// cek jika tanggal input kurang dari tanggal akhir di log modal
if ($tgl_input <= $tgl_akhir) {

    $cari_2 = $this->M_saldo->cari_saldo_pen($tanggal_tr, $id_umkm);

    $c2 = $cari_2->row_array();
    $saldo_terakhir2 = $c2['nominal'];

    $this->db->from('pencatatan');
    $this->db->where('id_umkm', $id_umkm);
    $this->db->where("CAST(tanggal_transaksi as VARCHAR) LIKE '%$tgl_c%'");
    $this->db->order_by('id_pencatatan', 'desc');
    
    $cr_1 = $this->db->get()->row_array();
    
    $id_pen_ak = $cr_1['id_pencatatan'];

    $id_pen_b = $id_pen + 1;

    $this->db->from('pemasukan');
    $this->db->where("id_pencatatan BETWEEN '$id_pen_b' AND '$id_pen_ak'");

    $query = $this->db->get()->result_array();

    foreach ($query as $a) {
        $cari_2 = $this->M_saldo->cari_saldo_pen($tanggal_tr, $id_umkm);

        $c2 = $cari_2->row_array();
        $saldo_terakhir2 = $c2['nominal'];

        $saldo_br = $saldo_terakhir2 + $a['nominal'];

        $cr = $this->M_saldo->cari_data('pencatatan', array('id_pencatatan' => $a['id_pencatatan']))->row_array();
        
        $this->M_saldo->ubah_data('pemasukan', array('saldo' => $saldo_br), array('id_pemasukan' => $a['id_pemasukan']));

        $this->M_saldo->input_data('log_modal', array('nominal' => $saldo_br, 'id_umkm' => $id_umkm, 'tanggal_pencatatan' => $cr['tanggal_transaksi']));
    }

    $this->db->from('pengeluaran');
    $this->db->where("id_pencatatan BETWEEN '$id_pen_b' AND '$id_pen_ak'");

    $query1 = $this->db->get()->result_array();

    foreach ($query1 as $a1 => $a1_val) {
        $cari_2 = $this->M_saldo->cari_saldo_pen_2($tanggal_tr, $id_umkm);

        $c2 = $cari_2->row_array();
        $saldo_terakhir2 = $c2['nominal'];

        $cr = $this->M_saldo->cari_data('pencatatan', array('id_pencatatan' => $a1_val['id_pencatatan']))->row_array();

        if ($a1[0]) {
            $saldo_br1 = $saldo_terakhir2 - $a1_val['nominal'];
        } else {
            $cari_2 = $this->M_saldo->cari_saldo_pen_2($cr['tanggal_transaksi'], $id_umkm)->row_array(2);

            $saldo_br1 = $cari_2['nominal'] - $a1_val['nominal'];
        }

        $this->M_saldo->ubah_data('pengeluaran', array('saldo' => $saldo_br1), array('id_pengeluaran' => $a1_val['id_pengeluaran']));

        $this->M_saldo->input_data('log_modal', array('nominal' => $saldo_br1, 'id_umkm' => $id_umkm, 'tanggal_pencatatan' => $cr['tanggal_transaksi']));
    }

}