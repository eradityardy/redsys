<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Pemakaianmaterial extends CI_Controller {

    function __construct()
    {
        parent::__construct();
        
        is_logged_in();
        $this->load->helper('tglindo');
        $this->load->helper('rupiah');
        $this->load->helper('url');
        $this->load->library('pdf');
        $this->load->library('form_validation');
        $this->load->model('Pemakaianmaterial_model', 'pemmat');
	}
    
    public function index()
    {
        $data['title'] = 'Pemakaian Material';
        $data['users'] = $this->db->get_where('users', ['username' => $this->session->userdata('username')])->row_array();
        $data['pemakaianmaterial'] = $this->pemmat->joinTablePemakaianmaterial()->result_array();

        if($this->session->userdata('role') == 'operator'){
            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar', $data);
            $this->load->view('transaksi/pemakaianmaterial/pemakaianmaterial_operator', $data);
            $this->load->view('templates/footer');
        }else{
            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar', $data);
            $this->load->view('transaksi/pemakaianmaterial/pemakaianmaterial', $data);
            $this->load->view('templates/footer');
        }
    }
#---------------------------------------------------------------------------------------------------------------#
    public function tambahpemakaian()
    {
        $data['title'] = 'Tambah Pemakaian';
        $data['users'] = $this->db->get_where('users', ['username' => $this->session->userdata('username')])->row_array();
        $data['data_type'] = $this->pemmat->getDatadropdowntyperumah();
        $data['data_unit'] = $this->pemmat->getDatadropdownunitrumah();
        $data['data_material'] = $this->pemmat->getDatadropdownmaterial();
        $data['data_stock'] = $this->pemmat->getDatadropdownstock();
        $data['data_pro'] = $this->pemmat->getDatadropdownproyek();
        $data['no_pemakaian'] = $this->pemmat->getNomorpemakaian();
        
        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('transaksi/pemakaianmaterial/pemakaianmaterial_tambah.php', $data);
        $this->load->view('templates/footer');
    }

    public function simpanpemakaian()
    {
        $no_pemakaian = $this->input->post('no_pemakaian');
        $tgl_pake = $this->input->post('tgl_pake');
        $unit_id = $this->input->post('unit_id');
		$data = array(
            'no_pemakaian' => $no_pemakaian,
            'tgl_pake' => $tgl_pake,
            'unit_id' => $unit_id,
		);
        $result = $this->pemmat->add_pemakaianmaterial('t_pakai_material', $data);
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

    public function simpandetail()
    {
        $no_pemakaian = $this->input->post('no_pemakaian');
        $material_id = $this->input->post('material_id');
        $stock_id = $this->input->post('stock_id');
        $qty = $this->input->post('qty');
        $qty_anggaran = $this->input->post('qty_anggaran');
        $price = $this->input->post('price');
        $satuan = $this->input->post('satuan');
		$data = array(
            'no_pemakaian' => $no_pemakaian,
            'material_id' => $material_id,
            'stock_id' => $stock_id,
            'qty' => $qty,
            'qty_anggaran' => $qty_anggaran,
            'price' => $price,
            'satuan' => $satuan,
        );
        $cek = $this->db->query("SELECT * FROM t_pakai_detail WHERE no_pemakaian='".$this->input->post('no_pemakaian')."' AND material_id='".$this->input->post('material_id')."'")->num_rows();
        if ($cek<=0) {
            $result = $this->pemmat->add_pemakaianmaterial('t_pakai_detail', $data);
            echo $this->tampilhasiltabel();
        }
        else if ($cek==1) {
            $this->tampilkanhasilgagal();
        }
    }

    public function tampilkantabel()
    {
        echo $this->tampilhasiltabel();
    }

    public function tampilhasiltabel()
    { 
        $no_pemakaian = $this->pemmat->getNopemakaian();
        $data_detail = $this->pemmat->show_pemakaian_detail($no_pemakaian)->result_array();
        $output = '';
		foreach ($data_detail as $material) {
			$output .='
				<tr>
                    <td>'.$material['nama_brg'].'</td>
                    <td>'.$material['qty_anggaran'].'</td>
                    <td>'.$material['qty'].'</td>
                    <td>'.$material['satuan'].'</td>
                    <td>'.$material['price'].'</td>
                    <td>'.$material['nama_gud'].'</td>
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
    public function editpemakaian($id_pake)
    {
        $t_pakai_material = $this->pemmat->get_pemakaianmaterial(" WHERE id_pake='$id_pake'")->row_array();
        $data = array(
            'title'=>'Edit Pemakaian',
            'users'=>$this->db->get_where('users', ['username' => $this->session->userdata('username')])->row_array(),
            'id_pake'=>$t_pakai_material['id_pake'],
            'tgl_pake'=>$t_pakai_material['tgl_pake'],
            'unit_id'=>$t_pakai_material['unit_id'],
            'no_pemakaian'=>$t_pakai_material['no_pemakaian'],
            'data_unit'=>$this->pemmat->getDatadropdownunitrumah(),
            'data_material'=>$this->pemmat->getDataeditdropdownmaterial($t_pakai_material['unit_id']),
            'data_stock'=>$this->pemmat->getDatadropdownstock(),
            'data_detail'=>$this->pemmat->show_pemakaian_detail($t_pakai_material['no_pemakaian']),
        );
        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('transaksi/pemakaianmaterial/pemakaianmaterial_edit.php', $data);
        $this->load->view('templates/footer');
    }

    public function updatemaster()
    {
        $id_pake = $this->input->post('id_pake');
        $no_pemakaian = $this->input->post('no_pemakaian');
        $tgl_pake = $this->input->post('tgl_pake');
        $unit_id = $this->input->post('unit_id');
        $data = array(
            'no_pemakaian'=>$no_pemakaian,
            'tgl_pake'=>$tgl_pake,
            'unit_id'=>$unit_id,
        );
        $result = $this->pemmat->edit_pemakaianmaterial('t_pakai_material', $data, array('id_pake'=>$id_pake));
        $this->tampilberhasilupdatemaster();
    }

    public function tampilberhasilupdatemaster()
    {
        echo $this->tampilhasilberhasilupdatemaster();
    }

    public function tampilhasilberhasilupdatemaster()
    { 
		$output =   '<div class="alert alert-primary" role="alert">
                        Terupdate!
                    </div>';
		return $output;
    }

    public function updatedetail()
    {
        //save data ke pembelian detail
        $no_pemakaian = $this->input->post('no_pemakaian');
        $material_id = $this->input->post('material_id');
        $qty_anggaran = $this->input->post('qty_anggaran');
        $stock_id = $this->input->post('stock_id');
        $qty = $this->input->post('qty');
        $price = $this->input->post('price');
        $satuan = $this->input->post('satuan');
        $data = array(
            'no_pemakaian' => $no_pemakaian,
            'material_id' => $material_id,
            'qty_anggaran' => $qty_anggaran,
            'stock_id' => $stock_id,
            'qty' => $qty,
            'price' => $price,
            'satuan' => $satuan,
        );
        $cek = $this->db->query("SELECT * FROM t_pakai_detail WHERE no_pemakaian='".$this->input->post('no_pemakaian')."' AND material_id='".$this->input->post('material_id')."'")->num_rows();
        if ($cek<=0) {
            $result = $this->pemmat->add_pemakaianmaterial('t_pakai_detail', $data);
            $this->tampilkandetail();
        }
        else if ($cek==1){
            $this->tampilkanhasilgagal2();
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
    public function hapuspemakaian($id_pake)
    {
        $this->db->where('id_pake', $id_pake);
        $this->db->delete('t_pakai_material');
        $this->session->set_flashdata('message', 'Hapus data');
        redirect('pemakaianmaterial');
    }

    public function hapusdetail($id_pake, $id_pakedetail)
    {
        $this->db->where('id_pakedetail', $id_pakedetail);
        $this->db->delete('t_pakai_detail');
        $this->session->set_flashdata('message', 'Hapus data');
        redirect('pemakaianmaterial/editpemakaian/'.$id_pake);
    }

    public function PemakaianMaterialPDF()
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
        $pdf->Cell(0,7,'PEMAKAIAN MATERIAL SUMATIRTA',0,1,'C');
        // Memberikan space kebawah agar tidak terlalu rapat
        $pdf->Cell(10,7,'',0,1);
        $pdf->SetFont('Arial','B',10);
        $pdf->Cell(22,6,'Tgl Pake',1,0,'C');
        $pdf->Cell(25,6,'Proyek',1,0,'C');
        $pdf->Cell(59,6,'Unit Rumah',1,0,'C');
        $pdf->Cell(45,6,'Customer',1,0,'C');
        $pdf->Cell(22,6,'Material',1,0,'C');
        $pdf->Cell(20,6,'Jml Pake',1,1,'C');
        $pdf->SetFont('Arial','',10);
        $pemakaianmaterial = $this->pemmat->joinTablePemakaianmaterial('pemakaianmaterial')->result();
        foreach ($pemakaianmaterial as $row){
            $pdf->Cell(22,6,$row->tgl_pake,1,0,'C');
            $pdf->Cell(25,6,$row->nama_pro,1,0,'C');
            $pdf->Cell(59,6,$row->alamat,1,0,'C'); 
            $pdf->Cell(45,6,$row->nama_cus,1,0,'C');
            $pdf->Cell(22,6,$row->nama_brg,1,0,'C');
            $pdf->Cell(20,6,$row->qty,1,1,'C');
        }
        $pdf->Output();
    }
}