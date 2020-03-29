<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require('./application/third_party/phpoffice/vendor/autoload.php');

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class Transaksipembelian extends CI_Controller {

    function __construct()
    {
        parent::__construct();
        
        is_logged_in();
        $this->load->helper('tglindo');
        $this->load->helper('rupiah');
        $this->load->helper('url');
        $this->load->library('pdf');
        $this->load->model('Transaksipembelian_model', 'transpem');
        $this->load->model('Stockmaterial_model', 'stockmat');
	}
    
    public function index()
    {
        $data['title'] = 'Pembelian Material';
        $data['users'] = $this->db->get_where('users', ['username' => $this->session->userdata('username')])->row_array();
        $data['transaksipem'] = $this->transpem->joinTableTransaksibeli()->result_array();

        if($this->session->userdata('role') == 'operator'){
            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar', $data);
            $this->load->view('transaksi/pembelianmaterial/pembelianmaterial_operator', $data);
            $this->load->view('templates/footer');
        }else{
            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar', $data);
            $this->load->view('transaksi/pembelianmaterial/pembelianmaterial', $data);
            $this->load->view('templates/footer');
        }
    }
#---------------------------------------------------------------------------------------------------------------#
    public function exportexcel()
    {
        $styleArray = [
            'font' => [
                'bold' => true,
                'size' => 12,
            ],
            'borders' => [
                'outline' => [
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THICK,
                    'color' => ['argb' => '0e1111'],
                ],
            ],
            'fill' => [
                'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_GRADIENT_LINEAR,
                'rotation' => 90,
                'color' => [
                    'argb' => 'FFFF00',
                ],
            ],
        ];

        $semua_transaksi = $this->transpem->jointablepembelian()->result();
        $spreadsheet = new Spreadsheet;
        $spreadsheet->setActiveSheetIndex(0)
                    ->setCellValue('A1', 'No')
                    ->setCellValue('B1', 'Nomor Faktur Pembelian Master')
                    ->setCellValue('C1', 'Tanggal Beli')
                    ->setCellValue('D1', 'Lama Kredit')
                    ->setCellValue('E1', 'Supplier')
                    ->setCellValue('F1', 'Gudang')
                    ->setCellValue('G1', 'Keterangan')
                    ->setCellValue('H1', 'Material')
                    ->setCellValue('I1', 'Quantity')
                    ->setCellValue('J1', 'Satuan')
                    ->setCellValue('K1', 'Harga');

        $kolom = 2;
        $nomor = 1;
        foreach($semua_transaksi as $transaksi) {
            $spreadsheet->setActiveSheetIndex(0)
                        ->setCellValue('A' . $kolom, $nomor)
                        ->setCellValue('B' . $kolom, $transaksi->no_faktur)
                        ->setCellValue('C' . $kolom, $transaksi->tgl_beli)
                        ->setCellValue('D' . $kolom, $transaksi->jatuh_tempo)
                        ->setCellValue('E' . $kolom, $transaksi->nama)
                        ->setCellValue('F' . $kolom, $transaksi->nama_gud)
                        ->setCellValue('G' . $kolom, $transaksi->keterangan)
                        ->setCellValue('H' . $kolom, $transaksi->nama_brg)
                        ->setCellValue('I' . $kolom, $transaksi->qty)
                        ->setCellValue('J' . $kolom, $transaksi->satuan)
                        ->setCellValue('K' . $kolom, $transaksi->price);
            $kolom++;
            $nomor++;
        }

        // Rename Sheet
        $spreadsheet->getActiveSheet()->setTitle('Transaksi Pembelian Material');

        $spreadsheet->getActiveSheet()->getColumnDimension('A')->setAutoSize(true);
        $spreadsheet->getActiveSheet()->getColumnDimension('B')->setAutoSize(true);
        $spreadsheet->getActiveSheet()->getColumnDimension('C')->setAutoSize(true);
        $spreadsheet->getActiveSheet()->getColumnDimension('D')->setAutoSize(true);
        $spreadsheet->getActiveSheet()->getColumnDimension('E')->setAutoSize(true);
        $spreadsheet->getActiveSheet()->getColumnDimension('F')->setAutoSize(true);
        $spreadsheet->getActiveSheet()->getColumnDimension('G')->setAutoSize(true);
        $spreadsheet->getActiveSheet()->getColumnDimension('H')->setAutoSize(true);
        $spreadsheet->getActiveSheet()->getColumnDimension('I')->setAutoSize(true);
        $spreadsheet->getActiveSheet()->getColumnDimension('J')->setAutoSize(true);
        $spreadsheet->getActiveSheet()->getColumnDimension('K')->setAutoSize(true);

        $spreadsheet->getActiveSheet()->getStyle('A1')->applyFromArray($styleArray);
        $spreadsheet->getActiveSheet()->getStyle('B1')->applyFromArray($styleArray);
        $spreadsheet->getActiveSheet()->getStyle('C1')->applyFromArray($styleArray);
        $spreadsheet->getActiveSheet()->getStyle('D1')->applyFromArray($styleArray);
        $spreadsheet->getActiveSheet()->getStyle('E1')->applyFromArray($styleArray);
        $spreadsheet->getActiveSheet()->getStyle('F1')->applyFromArray($styleArray);
        $spreadsheet->getActiveSheet()->getStyle('G1')->applyFromArray($styleArray);
        $spreadsheet->getActiveSheet()->getStyle('H1')->applyFromArray($styleArray);
        $spreadsheet->getActiveSheet()->getStyle('I1')->applyFromArray($styleArray);
        $spreadsheet->getActiveSheet()->getStyle('J1')->applyFromArray($styleArray);
        $spreadsheet->getActiveSheet()->getStyle('K1')->applyFromArray($styleArray);
        
        $writer = new Xlsx($spreadsheet);
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="Transaksipembelianmaterial.xlsx"');
        header('Cache-Control: max-age=0');
        $writer->save('php://output');
    }
#---------------------------------------------------------------------------------------------------------------#
    public function lihatpembelian($no_faktur)
    {
        $t_beli_masterdetail = $this->transpem->joinTablebelidetail(" WHERE no_faktur='$no_faktur'")->row_array();
        $data = array(
            'title'=>'Detail Pembelian',
            'users'=>$this->db->get_where('users', ['username' => $this->session->userdata('username')])->row_array(),
            'no_faktur'=>$t_beli_masterdetail['no_faktur'],
            'tgl_beli'=>$t_beli_masterdetail['tgl_beli'],
            'nama'=>$t_beli_masterdetail['nama'],
            'nama_gud'=>$t_beli_masterdetail['nama_gud'],
            'total'=>$t_beli_masterdetail['sub_total'],
            'detailpembelian'=>$this->transpem->show_transaksipembelian_detail($no_faktur)->result_array(),
        );

        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('transaksi/pembelianmaterial/pembelianmaterial_detail.php', $data);
        $this->load->view('templates/footer');
    }
#---------------------------------------------------------------------------------------------------------------#
    public function tambahpembelian()
    {
        $data['title'] = 'Tambah Pembelian';
        $data['users'] = $this->db->get_where('users', ['username' => $this->session->userdata('username')])->row_array();
        $data['data_sup'] = $this->transpem->getDatasupplier();
        $data['data_gud'] = $this->transpem->getDatagudang();
        $data['data_mat'] = $this->transpem->getDatamaterial();

        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('transaksi/pembelianmaterial/pembelianmaterial_tambah.php', $data);
        $this->load->view('templates/footer');
    }

    public function simpantransaksi()
    {
        $no_faktur = $this->input->post('no_faktur');
        $tgl_beli = $this->input->post('tgl_beli');
        $jatuh_tempo = $this->input->post('jatuh_tempo');
        $supplier_id = $this->input->post('supplier_id');
        $gudang_id = $this->input->post('gudang_id');
        $keterangan = $this->input->post('keterangan');
        $data = array(
            'no_faktur' => $no_faktur,
            'tgl_beli' => $tgl_beli,
            'jatuh_tempo' => $jatuh_tempo,
            'supplier_id' => $supplier_id,
            'gudang_id' => $gudang_id,
            'keterangan' => $keterangan,
        );
        $result = $this->transpem->simpan('t_beli_master', $data);
        $this->tampilkan();
    }

    public function tampilkan()
    {
        echo $this->tampilhasil();
    }

    public function tampilhasil()
    { 
		$output =   '<div class="alert alert-primary" role="alert">
                        Tersimpan!
                    </div>';
		return $output;
    }
    
    public function simpandetail($gudangId = 0)
    {
        //save data ke pembelian detail
        $no_faktur = $this->input->post('no_faktur');
        $material_id = $this->input->post('material_id');
        $qty = $this->input->post('qty');
        $price = $this->input->post('price');
        $satuan = $this->input->post('satuan');

        //untuk ambil supplier
        $supplier_id1 = $this->input->post('supplier_id1');

        $stock_id = $this->stockmat->getStockId($gudangId,$material_id);
        if ($stock_id == null){
            $stock_id = 0;
        }

        if ($stock_id == 0){
            //jika belum ada data stok barang buat dulu 
            $dstock = array(
                'gudang_id' => $gudangId,
                'supplier_id' => $supplier_id1,
                'material_id' => $material_id,
                'qty_stock' => 0,
                'keterangan' => '-',
            );
            $result = $this->stockmat->simpan('t_stock_material',$dstock);
            if ($result > 0){
                $stock_id = $result;
            }
        }
        //jika sudah ada stok lanjut simpan data 
        if ($stock_id > 0){
            $data = array(
                'no_faktur' => $no_faktur,
                'material_id' => $material_id,
                'qty' => $qty,
                'price' => $price,
                'stock_id' => $stock_id,
                'satuan' => $satuan,
            );
            $cek = $this->db->query("SELECT * FROM t_beli_detail WHERE no_faktur='".$this->input->post('no_faktur')."' AND material_id='".$this->input->post('material_id')."'")->num_rows();
            if ($cek<=0) {
                $result = $this->transpem->simpan('t_beli_detail', $data);
                echo $this->tampilhasiltabel();
            }
            else if ($cek==1) {
                $this->tampilkanhasilgagal();
            }
        }
    }

    public function tampilkantabel()
    {
        echo $this->tampilhasiltabel();
    }

    public function tampilhasiltabel()
    { 
        $no_faktur = $this->transpem->getNofaktur();
        $data_detail = $this->transpem->show_transaksipembelian_detail($no_faktur)->result_array();
        $output = '';
		foreach ($data_detail as $material) {
			$output .='
				<tr>
					<td>'.$material['nama_brg'].'</td>
                    <td>'.$material['qty'].'</td>
                    <td>'.$material['satuan'].'</td>
					<td>'.$material['price'].'</td>
				</tr>
			';
		}
		return $output;
    }

    public function tampilkanhasilgagal()
    {
        echo $this->tampilhasilgagal();
    }

    public function tampilhasilgagal()
    { 
        echo "<script>alert('Data Material sudah ada!')</script>";
    }
#---------------------------------------------------------------------------------------------------------------#
    public function editpembelian($id_tbm)
    {
        $t_beli_master = $this->transpem->getTbelimaster(" WHERE id_tbm='$id_tbm'")->row_array();
        $data = array(
            'title'=>'Edit Pembelian',
            'users'=>$this->db->get_where('users', ['username' => $this->session->userdata('username')])->row_array(),
            'id_tbm'=>$t_beli_master['id_tbm'],
            'no_faktur'=>$t_beli_master['no_faktur'],
            'tgl_beli'=>$t_beli_master['tgl_beli'],
            'jatuh_tempo'=>$t_beli_master['jatuh_tempo'],
            'supplier_id'=>$t_beli_master['supplier_id'],
            'gudang_id'=>$t_beli_master['gudang_id'],
            'keterangan'=>$t_beli_master['keterangan'],
            'data_sup'=>$this->transpem->getDatasupplier(),
            'data_gud'=>$this->transpem->getDatagudang(),
            'data_detail'=>$this->transpem->show_transaksipembelian_detail($t_beli_master['no_faktur']),
            'data_mat'=>$this->transpem->getDatamaterial(),
        );
        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('transaksi/pembelianmaterial/pembelianmaterial_edit.php', $data);
        $this->load->view('templates/footer');
    }

    public function updatemaster()
    {
        $id_tbm = $this->input->post('id_tbm');
        $no_faktur = $this->input->post('no_faktur');
        $tgl_beli = $this->input->post('tgl_beli');
        $jatuh_tempo = $this->input->post('jatuh_tempo');
        $gudang_id = $this->input->post('gudang_id');
        $supplier_id = $this->input->post('supplier_id');
        $keterangan = $this->input->post('keterangan');
        $data = array(
            'no_faktur'=>$no_faktur,
            'tgl_beli'=>$tgl_beli,
            'jatuh_tempo'=>$jatuh_tempo,
            'gudang_id'=>$gudang_id,
            'supplier_id'=>$supplier_id,
            'keterangan'=>$keterangan,
        );
        $result = $this->transpem->update('t_beli_master', $data, array('id_tbm'=>$id_tbm));
        $this->tampilberhasilupdate();
    }

    public function tampilberhasilupdate()
    {
        echo $this->tampilhasilberhasilupdate();
    }

    public function tampilhasilberhasilupdate()
    { 
		$output =   '<div class="alert alert-primary" role="alert">
                        Terupdate!
                    </div>';
		return $output;
    }

    public function updatedetail($gudangId = 0)
    {
        //save data ke pembelian detail
        $no_faktur = $this->input->post('no_faktur');
        $material_id = $this->input->post('material_id');
        $qty = $this->input->post('qty');
        $price = $this->input->post('price');

        //untuk ambil supplier
        $supplier_id1 = $this->input->post('supplier_id1');

        $stock_id = $this->stockmat->getStockId($gudangId,$material_id);
        if ($stock_id == null){
            $stock_id = 0;
        }

        if ($stock_id == 0){
            //jika belum ada data stok barang buat dulu 
            $dstock = array(
                'gudang_id' => $gudangId,
                'supplier_id' => $supplier_id1,
                'material_id' => $material_id,
                'qty_stock' => 0,
                'keterangan' => '-',
            );
            $result = $this->stockmat->simpan('t_stock_material',$dstock);
            if ($result > 0){
                $stock_id = $result;
            }
        }
        //jika sudah ada stok lanjut simpan data 
        if ($stock_id > 0){
            $data = array(
                'no_faktur' => $no_faktur,
                'material_id' => $material_id,
                'qty' => $qty,
                'price' => $price,
                'stock_id' => $stock_id,
            );
            $cek = $this->db->query("SELECT * FROM t_beli_detail WHERE no_faktur='".$this->input->post('no_faktur')."' AND material_id='".$this->input->post('material_id')."'")->num_rows();
            if ($cek<=0) {
                $result = $this->transpem->simpan('t_beli_detail', $data);
                $this->tampilkandetail();
            }
            else if ($cek==1){
                $this->tampilkanhasilgagal2();
            }
        }
    }

    public function tampilkandetail()
    {
        echo $this->tampilhasildetail();
    }

    public function tampilhasildetail()
    { 
		echo "<script>alert('Data Material berhasil tersimpan!')</script>";
    }
    
    public function tampilkanhasilgagal2()
    {
        echo $this->tampilhasilgagal2();
    }

    public function tampilhasilgagal2()
    { 
        echo "<script>alert('Data Material sudah ada!')</script>";
    }
#---------------------------------------------------------------------------------------------------------------#
    public function hapuspembelian($id_tbm, $no_faktur)
    {
        $cek = $this->db->query("SELECT * FROM t_beli_detail WHERE no_faktur = $no_faktur")->num_rows();
        if ($cek<=0) {
            $this->db->where('id_tbm', $id_tbm);
            $this->db->delete('t_beli_master');
            $this->session->set_flashdata('message', 'Hapus data');
        }
        else if ($cek>0) {
            $this->session->set_flashdata('message', 'Penghapusan data tidak');
        }
        redirect('transaksipembelian');
    }

    public function hapusdetail($id_tbm, $id_tbd)
    {
        $this->db->where('id_tbd', $id_tbd);
        $this->db->delete('t_beli_detail');
        $this->session->set_flashdata('message', 'Hapus data');
        redirect('transaksipembelian/editpembelian/'.$id_tbm);
    }

    public function TransaksiPembelianPDF()
    {
        $pdf = new FPDF('p','mm','A4');
        // membuat halaman baru
        $pdf->AddPage();
        $pdf->SetMargins(8.5,1,8.5);
        // setting jenis font yang akan digunakan
        $pdf->SetFont('Arial','B',17);
        // mencetak string 
        $pdf->Cell(0,7,'LAPORAN',0,1,'C');
        $pdf->SetFont('Arial','B',13);
        $pdf->Cell(0,7,'TRANSAKSI PEMBELIAN SUMATIRTA',0,1,'C');
        // Memberikan space kebawah agar tidak terlalu rapat
        $pdf->Cell(10,7,'',0,1);
        $pdf->SetFont('Arial','B',10);
        $pdf->Cell(28,6,'No Faktur',1,0,'C');
        $pdf->Cell(25,6,'Tanggal Beli',1,0,'C');
        $pdf->Cell(46,6,'Supplier',1,0,'C');
        $pdf->Cell(50,6,'Gudang',1,0,'C');
        $pdf->Cell(22,6,'Total Biaya',1,0,'C');
        $pdf->Cell(22,6,'Keterangan',1,1,'C');
        $pdf->SetFont('Arial','',10);
        $transaksipembelian = $this->transpem->joinTableTransaksibeli('transaksipembelian')->result();
        foreach ($transaksipembelian as $row){
            $pdf->Cell(28,6,$row->no_faktur,1,0,'C');
            $pdf->Cell(25,6,$row->tgl_beli,1,0,'C');
            $pdf->Cell(46,6,$row->nama,1,0,'C'); 
            $pdf->Cell(50,6,$row->nama_gud,1,0,'C');
            $pdf->Cell(22,6,$row->sub_total,1,0,'C');
            $pdf->Cell(22,6,$row->keterangan,1,1,'C');
        }
        $pdf->Output();
    }

    public function CheckFaktur()
    {
        $noFaktur = $this->input->post('no_faktur');
        $ada = $this->transpem->checkNoFaktur($noFaktur);
        print($ada);
    }

    public function DetailPembelianPDF($no_faktur)
    {
        $pdf = new FPDF('p','mm','A4');
        // membuat halaman baru
        $pdf->AddPage();
        $pdf->SetMargins(8.5,1,8.5);
        // setting jenis font yang akan digunakan
        $pdf->SetFont('Arial','B',17);
        // mencetak string 
        $pdf->Cell(0,7,'LAPORAN',0,1,'C');
        $pdf->SetFont('Arial','B',13);
        $pdf->Cell(0,7,'DETAIL PEMBELIAN MATERIAL SUMATIRTA',0,1,'C');
        // Memberikan space kebawah agar tidak terlalu rapat
        $pdf->Cell(10,5,'',0,1);

        $t_beli_masterdetail = $this->transpem->joinTablebelidetail(" WHERE no_faktur='$no_faktur'")->row_array();
        $data = array(
            'no_faktur'=>$t_beli_masterdetail['no_faktur'],
            'tgl_beli'=>$t_beli_masterdetail['tgl_beli'],
            'nama'=>$t_beli_masterdetail['nama'],
            'nama_gud'=>$t_beli_masterdetail['nama_gud'],
            'total'=>$t_beli_masterdetail['sub_total'],
        );
        $pdf->SetFont('Arial','B',11);
        $pdf->Cell(0,7,$data['no_faktur'],0,0,'L');
        $pdf->SetFont('Arial','B',11);
        $pdf->Cell(0,7,$data['tgl_beli'],0,1,'R');
        $pdf->SetFont('Arial','',11);
        $pdf->Cell(0,7,$data['nama_gud'],0,0,'L');
        $pdf->SetFont('Arial','',11);
        $pdf->Cell(0,7,$data['nama'],0,1,'R');

        $pdf->Cell(10,2,'',0,1);
        $pdf->SetFont('Arial','B',10);
        $pdf->Cell(45,6,'Material',1,0,'C');
        $pdf->Cell(30,6,'Quantity',1,0,'C');
        $pdf->Cell(34,6,'Satuan',1,0,'C');
        $pdf->Cell(34,6,'Harga',1,0,'C');
        $pdf->Cell(50,6,'Total Harga',1,1,'C');
        $pdf->SetFont('Arial','',10);
        $detailpembelian = $this->transpem->show_transaksipembelian_detail($no_faktur)->result();
        foreach ($detailpembelian as $row){
            $pdf->Cell(45,6,$row->nama_brg,1,0,'C');
            $pdf->Cell(30,6,$row->qty,1,0,'C');
            $pdf->Cell(34,6,$row->satuan,1,0,'C');
            $pdf->Cell(34,6,$row->price,1,0,'C');
            $pdf->Cell(50,6,$row->sub_total,1,1,'C');
        }
        $pdf->Cell(10,3,'',0,1);
        $pdf->SetFont('Arial','B',11);
        $pdf->Cell(0,7,'Total harga = Rp. ' .number_format($data['total'],0),0,1,'L');
        $pdf->Output();
    }
} ?>