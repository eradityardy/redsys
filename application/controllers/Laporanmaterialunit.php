<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Laporanmaterialunit extends CI_Controller {

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
        $data['title'] = 'Laporan Material Unit Rumah';
        $data['users'] = $this->db->get_where('users', ['username' => $this->session->userdata('username')])->row_array();
        $data['laporanmaterialunit'] = $this->lapmat->joinTableLaporanmaterialbyunit()->result_array();

        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('transaksi/laporanmaterialunit/laporanmaterialunit', $data);
        $this->load->view('templates/footer');
    }

    public function detaillaporan($id_unit)
    {
        $data['title'] = 'Laporan Material Unit Rumah';
        $data['users'] = $this->db->get_where('users', ['username' => $this->session->userdata('username')])->row_array();
        $data['detaillaporan'] = $this->lapmat->show_laporanmaterial_by_idunit($id_unit)->result_array();
        
        $data['unitrum'] = $this->db->get_where('vw_laporanmaterial_unit_detail', ['id_unit' => $id_unit])->row_array();
        $t_laporan_material = $this->db->get_where('vw_laporanmaterial_unit_detail', ['id_unit' => $id_unit])->row_array();
        $data['id_unit'] = $t_laporan_material['id_unit'];

        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('transaksi/laporanmaterialunit/laporanmaterialunit_detail', $data);
        $this->load->view('templates/footer');
    }

    public function DetaillaporanPDF($id_unit)
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
        $pdf->Cell(0,7,'PEMAKAIAN MATERIAL PERUNIT RUMAH SUMATIRTA',0,1,'C');
        // Memberikan space kebawah agar tidak terlalu rapat
        $pdf->Cell(10,5,'',0,1);

        $t_laporan_material = $this->db->get_where('vw_laporanmaterial_unit_detail', ['id_unit' => $id_unit])->row_array();
        $data = array(
            'alamat'=>$t_laporan_material['alamat'],
            'nama_cus'=>$t_laporan_material['nama_cus'],
            'nama_pro'=>$t_laporan_material['nama_pro'],
        );
        $pdf->SetFont('Arial','B',11);
        $pdf->Cell(0,7,$data['alamat'],0,0,'L');
        $pdf->SetFont('Arial','B',11);
        $pdf->Cell(0,7,$data['nama_pro'],0,1,'R');
        $pdf->SetFont('Arial','B',11);
        $pdf->Cell(0,7,$data['nama_cus'],0,1,'L');


        $pdf->SetFont('Arial','B',10);
        $pdf->Cell(25,6,'Kode',1,0,'C');
        $pdf->Cell(30,6,'Material',1,0,'C');
        $pdf->Cell(50,6,'Gudang',1,0,'C');
        $pdf->Cell(34,6,'Tanggal Pake',1,0,'C');
        $pdf->Cell(15,6,'Qty',1,0,'C');
        $pdf->Cell(20,6,'Harga',1,0,'C');
        $pdf->Cell(20,6,'Total',1,1,'C');
        $pdf->SetFont('Arial','',10);
        $lapmatunit = $this->lapmat->show_laporanmaterial_by_idunit($id_unit)->result();
        foreach ($lapmatunit as $row){
            $pdf->Cell(25,6,$row->kode,1,0,'C');
            $pdf->Cell(30,6,$row->nama_brg,1,0,'C');
            $pdf->Cell(50,6,$row->nama_gud,1,0,'C'); 
            $pdf->Cell(34,6,$row->tgl_pake,1,0,'C');
            $pdf->Cell(15,6,$row->qty,1,0,'C');
            $pdf->Cell(20,6,$row->price,1,0,'C');
            $pdf->Cell(20,6,$row->total_biaya,1,1,'C');
        }
        $pdf->Output();
    }
}