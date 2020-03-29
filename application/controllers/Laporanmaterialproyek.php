<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Laporanmaterialproyek extends CI_Controller {

    function __construct()
    {
        parent::__construct();
        
        is_logged_in();
        $this->load->helper('tglindo');
        $this->load->helper('rupiah');
        $this->load->helper('url');
        $this->load->library('pdf');
        $this->load->model('Laporanmaterial_model', 'lapmat');
    }
    
    public function index()
    {
        $data['title'] = 'Laporan Material Proyek';
        $data['users'] = $this->db->get_where('users', ['username' => $this->session->userdata('username')])->row_array();
        $data['laporanmaterialpro'] = $this->lapmat->joinTableLaporanmaterialbypro()->result_array();

        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('transaksi/laporanmaterialproyek/laporanmaterialproyek', $data);
        $this->load->view('templates/footer');
    }

    public function detaillaporan($id_pro)
    {
        $data['title'] = 'Laporan Material Proyek';
        $data['users'] = $this->db->get_where('users', ['username' => $this->session->userdata('username')])->row_array();
        $data['detaillaporan'] = $this->lapmat->show_laporanmaterial_by_idpro($id_pro)->result_array();

        $data['pro'] = $this->db->get_where('vw_laporanmaterial_proyek_detail', ['id_pro' => $id_pro])->row_array();
        $t_laporan_material = $this->db->get_where('vw_laporanmaterial_proyek_detail', ['id_pro' => $id_pro])->row_array();
        $data['id_pro'] = $t_laporan_material['id_pro'];

        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('transaksi/laporanmaterialproyek/laporanmaterialproyek_detail', $data);
        $this->load->view('templates/footer');
    }

    public function DetaillaporanPDF($id_pro)
    {
        $pdf = new FPDF('P','mm','A4');
        // membuat halaman baru
        $pdf->AddPage();
        $pdf->SetMargins(8.5,1,8.5);
        // setting jenis font yang akan digunakan
        $pdf->SetFont('Arial','B',16);
        // mencetak string 
        $pdf->Cell(0,7,'LAPORAN',0,1,'C');
        $pdf->SetFont('Arial','B',13);
        $pdf->Cell(0,7,'PEMAKAIAN MATERIAL PERPROYEK SUMATIRTA',0,1,'C');
        // Memberikan space kebawah agar tidak terlalu rapat
        $pdf->Cell(10,5,'',0,1);

        $t_laporan_material = $this->db->get_where('vw_laporanmaterial_proyek_detail', ['id_pro' => $id_pro])->row_array();
        $data = array(
            'nama_pro'=>$t_laporan_material['nama_pro'],
            'lokasi'=>$t_laporan_material['lokasi'],
            'owner'=>$t_laporan_material['owner'],
        );
        $pdf->SetFont('Arial','B',11);
        $pdf->Cell(0,7,$data['nama_pro'],0,0,'L');
        $pdf->SetFont('Arial','B',11);
        $pdf->Cell(0,7,$data['lokasi'],0,1,'R');
        $pdf->SetFont('Arial','B',11);
        $pdf->Cell(0,7,$data['owner'],0,1,'L');


        $pdf->SetFont('Arial','B',10);
        $pdf->Cell(43,6,'Unit Rumah',1,0,'C');
        $pdf->Cell(34,6,'Tanggal Pemakaian',1,0,'C');
        $pdf->Cell(28,6,'Material',1,0,'C');
        $pdf->Cell(43,6,'Gudang',1,0,'C');
        $pdf->Cell(15,6,'Qty',1,0,'C');
        $pdf->Cell(18,6,'Harga',1,0,'C');
        $pdf->Cell(18,6,'Total',1,1,'C');
        $pdf->SetFont('Arial','',10);
        $lapmatpro = $this->lapmat->show_laporanmaterial_by_idpro($id_pro)->result();
        foreach ($lapmatpro as $row){
            $pdf->Cell(43,6,$row->alamat,1,0,'C');
            $pdf->Cell(34,6,$row->tgl_pake,1,0,'C');
            $pdf->Cell(28,6,$row->nama_brg,1,0,'C'); 
            $pdf->Cell(43,6,$row->nama_gud,1,0,'C');
            $pdf->Cell(15,6,$row->qty,1,0,'C');
            $pdf->Cell(18,6,$row->price,1,0,'C');
            $pdf->Cell(18,6,$row->total_biaya,1,1,'C');
        }
        $pdf->Output();
    }
}