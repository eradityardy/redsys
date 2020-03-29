<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Stockrumah extends CI_Controller {

    function __construct()
    {
        parent::__construct();
        
        is_logged_in();
        $this->load->helper('tglindo');
        $this->load->helper('rupiah');
        $this->load->helper('url');
        $this->load->library('pdf');
        $this->load->model('Stockrumah_model', 'stockrum');
	}
    
    public function index()
    {
        $data['title'] = 'Stock Rumah';
        $data['users'] = $this->db->get_where('users', ['username' => $this->session->userdata('username')])->row_array();
        $data['stockrumah'] = $this->stockrum->joinTableStockrumah()->result_array();

        if($this->session->userdata('role') == 'operator'){
            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar', $data);
            $this->load->view('transaksi/stockrumah/stockrumah_operator', $data);
            $this->load->view('templates/footer');
        }else{
            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar', $data);
            $this->load->view('transaksi/stockrumah/stockrumah', $data);
            $this->load->view('templates/footer');
        }
    }

    public function StockRumahPDF()
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
        $pdf->Cell(0,7,'STOCK RUMAH SUMATIRTA',0,1,'C');
        // Memberikan space kebawah agar tidak terlalu rapat
        $pdf->Cell(10,5,'',0,1);

        $pdf->SetFont('Arial','B',10);
        $pdf->Cell(25,6,'Proyek',1,0,'C');
        $pdf->Cell(25,6,'Type',1,0,'C');
        $pdf->Cell(25,6,'Blok',1,0,'C');
        $pdf->Cell(50,6,'Alamat',1,0,'C');
        $pdf->Cell(23,6,'L Bangunan',1,0,'C');
        $pdf->Cell(23,6,'L Tanah',1,0,'C');
        $pdf->Cell(22,6,'Harga',1,1,'C');
        $pdf->SetFont('Arial','',10);
        $stockmaterial = $this->stockrum->joinTableStockrumah('stockrumah')->result();
        foreach ($stockmaterial as $row){
            $pdf->Cell(25,6,$row->nama_pro,1,0,'C');
            $pdf->Cell(25,6,$row->nama_type,1,0,'C');
            $pdf->Cell(25,6,$row->nama_blok,1,0,'C'); 
            $pdf->Cell(50,6,$row->alamat,1,0,'C');
            $pdf->Cell(23,6,$row->luas_bangunan,1,0,'C');
            $pdf->Cell(23,6,$row->luas_tanah,1,0,'C');
            $pdf->Cell(22,6,$row->harga_rum,1,1,'C');
        }
        $pdf->Output();
    }
}