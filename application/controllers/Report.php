<?php 

defined('BASEPATH') OR exit('No direct script access allowed');

class Report extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        
    }
    

    public function index()
    {
        $this->db->join('umkm as u', 'u.id_umkm = p.id_umkm', 'inner');
        $hasil = $this->db->get('pencatatan as p');

        $b = array();
        foreach ($hasil->result_array() as $a) {
            $data[] = ['id_umkm'        => $a['id_umkm'],
                        'nama_umkm'     => $a['nama_umkm'],
                        'modal_awal'    => $a['modal_awal'],
                        'bulan'         => nice_date($a['tanggal_transaksi'], 'Y-m')
                    ];
        }
        $list = array_map(
            'unserialize',
            array_unique(
                array_map(
                    'serialize',
                    $data
                )
            )
        );

        $tot_laba = 0;

        foreach ($list as $u) {
            $bln = $u['bulan'];
            $id_umkm = $u['id_umkm'];

            $this->db->select('sum(nominal) tot_pengeluaran');
            $this->db->from('pengeluaran as p');
            $this->db->join('pencatatan as pe', 'pe.id_pencatatan = p.id_pencatatan', 'inner');
            $this->db->where('pe.id_umkm', $id_umkm);

            $this->db->where("CAST(pe.tanggal_transaksi as VARCHAR) LIKE '%$bln%'");

            $hasil_peng = $this->db->get()->row_array();

            $this->db->select('sum(nominal) tot_pemasukan');
            $this->db->from('pemasukan as p');
            $this->db->join('pencatatan as pe', 'pe.id_pencatatan = p.id_pencatatan', 'inner');
            $this->db->where('pe.id_umkm', $id_umkm);
            
            $this->db->where("CAST(pe.tanggal_transaksi as VARCHAR) LIKE '%$bln%'");
            

            $hasil_pem = $this->db->get()->row_array();

            $tot_laba += $hasil_pem['tot_pemasukan'] - $hasil_peng['tot_pengeluaran'];

            $value[] = [ 'id_umkm'     => $u['id_umkm'],
                        'nama_umkm'    => $u['nama_umkm'],
                        'bulan'        => $u['bulan'],
                        'modal_awal'   => $u['modal_awal'],
                        'pemasukan'    => $hasil_pem['tot_pemasukan'],
                        'pengeluaran'  => $hasil_peng['tot_pengeluaran'],
                        'laba'         => $hasil_pem['tot_pemasukan'] - $hasil_peng['tot_pengeluaran']
                        ];
        }

        $data = array(
            'content'   => 'report/index',
            'judul'     => 'report',
            'list'      => $value
        );

        $this->load->view('layout/template',$data);
    }

}

/* End of file Report.php */
