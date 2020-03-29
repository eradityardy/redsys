<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Stockmaterial extends CI_Controller {

    function __construct()
    {
        parent::__construct();
        
        is_logged_in();
        $this->load->helper('tglindo');
        $this->load->helper('rupiah');
        $this->load->helper('url');
        $this->load->library('pdf');
        $this->load->model('Stockmaterial_model', 'stockmat');
	}
    
    public function index()
    {
        $data['title'] = 'Stock Material';
        $data['users'] = $this->db->get_where('users', ['username' => $this->session->userdata('username')])->row_array();
        $data['stockmaterial'] = $this->stockmat->joinTableStockmaterial()->result_array();

        if($this->session->userdata('role') == 'operator'){
            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar', $data);
            $this->load->view('transaksi/stockmaterial/stockmaterial_operator', $data);
            $this->load->view('templates/footer');
        }else{
            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar', $data);
            $this->load->view('transaksi/stockmaterial/stockmaterial', $data);
            $this->load->view('templates/footer');
        }
    }

    public function kartustock($id_stomat)
    {
        $data['title'] = 'Kartu Stock Material';
        $data['users'] = $this->db->get_where('users', ['username' => $this->session->userdata('username')])->row_array();
        $data['stock'] = $this->db->get_where('vw_stock_material', ['id_stomat' => $id_stomat])->row_array();
        $data['stockcard'] = $this->stockmat->getStockCard($id_stomat);
        
        $t_stock_material = $this->db->get_where('vw_stock_material', ['id_stomat' => $id_stomat])->row_array();
        $data['id_stomat'] = $t_stock_material['id_stomat'];

        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('transaksi/stockmaterial/stockmaterial_card', $data);
        $this->load->view('templates/footer');
    }

    public function hapusstock($id_stomat)
    {
        $this->db->where('id_stomat', $id_stomat);
        $this->db->delete('t_stock_material');
        $this->session->set_flashdata('message', 'Hapus data');
        redirect('stockmaterial');
    }

    public function StockMaterialPDF()
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
        $pdf->Cell(0,7,'STOCK MATERIAL SUMATIRTA',0,1,'C');
        // Memberikan space kebawah agar tidak terlalu rapat
        $pdf->Cell(10,5,'',0,1);

        $pdf->SetFont('Arial','B',10);
        $pdf->Cell(44,6,'Gudang',1,0,'C');
        $pdf->Cell(20,6,'Kode',1,0,'C');
        $pdf->Cell(46,6,'Material',1,0,'C');
        $pdf->Cell(15,6,'Qty',1,0,'C');
        $pdf->Cell(22,6,'Satuan',1,0,'C');
        $pdf->Cell(46,6,'Supplier',1,1,'C');
        $pdf->SetFont('Arial','',10);
        $stockmaterial = $this->stockmat->joinTableStockmaterial('stockmaterial')->result();
        foreach ($stockmaterial as $row){
            $pdf->Cell(44,6,$row->nama_gud,1,0,'C');
            $pdf->Cell(20,6,$row->kode,1,0,'C');
            $pdf->Cell(46,6,$row->nama_brg,1,0,'C'); 
            $pdf->Cell(15,6,$row->qty_stock,1,0,'C');
            $pdf->Cell(22,6,$row->satuan,1,0,'C');
            $pdf->Cell(46,6,$row->nama,1,1,'C');
        }
        $pdf->Output();
    }

    public function KartuStockPDF($id_stomat)
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
        $pdf->Cell(0,7,'KARTU STOCK MATERIAL SUMATIRTA',0,1,'C');
        // Memberikan space kebawah agar tidak terlalu rapat
        $pdf->Cell(10,5,'',0,1);

        $t_stock_material = $this->db->get_where('vw_stock_material', ['id_stomat' => $id_stomat])->row_array();
        $data = array(
            'id_stomat'=>$t_stock_material['id_stomat'],
            'kode'=>$t_stock_material['kode'],
            'nama_brg'=>$t_stock_material['nama_brg'],
            'nama_gud'=>$t_stock_material['nama_gud'],
        );
        $pdf->SetFont('Arial','B',11);
        $pdf->Cell(0,7,$data['kode'],0,0,'L');
        $pdf->SetFont('Arial','B',11);
        $pdf->Cell(0,7,$data['nama_gud'],0,1,'R');
        $pdf->SetFont('Arial','',11);
        $pdf->Cell(0,7,$data['nama_brg'],0,1,'L');

        $pdf->SetFont('Arial','B',10);
        $pdf->Cell(27,6,'Tanggal',1,0,'C');
        $pdf->Cell(52,6,'Relasi',1,0,'C');
        $pdf->Cell(39,6,'No Dokumen',1,0,'C');
        $pdf->Cell(25,6,'Masuk',1,0,'C');
        $pdf->Cell(25,6,'Keluar',1,0,'C');
        $pdf->Cell(25,6,'Saldo',1,1,'C');
        $pdf->SetFont('Arial','',10);
        $stockcard = $this->stockmat->getStockCard($id_stomat)->result();
        foreach ($stockcard as $row){
            $pdf->Cell(27,6,$row->tanggal,1,0,'C');
            $pdf->Cell(52,6,$row->relasi,1,0,'C');
            $pdf->Cell(39,6,$row->no_document,1,0,'C'); 
            $pdf->Cell(25,6,$row->masuk,1,0,'C');
            $pdf->Cell(25,6,$row->keluar,1,0,'C');
            $pdf->Cell(25,6,$row->saldo,1,1,'C');
        }
        $pdf->Output();
    }
}