<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Opnameprogress extends CI_Controller {

    function __construct()
    {
        parent::__construct();
        
        is_logged_in();
        $this->load->helper('tglindo');
        $this->load->helper('rupiah');
        $this->load->helper('url');
        $this->load->library('pdf');
        $this->load->model('Opnameprogress_model', 'opnamepro');
	}
    
    public function index()
    {
        $data['title'] = 'Opname Progress';
        $data['users'] = $this->db->get_where('users', ['username' => $this->session->userdata('username')])->row_array();
        $data['opnameprogress'] = $this->opnamepro->joinTableOpnameprogress()->result_array();

        if($this->session->userdata('role') == 'operator'){
            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar', $data);
            $this->load->view('transaksi/opnameprogress/opnameprogress_operator', $data);
            $this->load->view('templates/footer');
        }else{
            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar', $data);
            $this->load->view('transaksi/opnameprogress/opnameprogress', $data);
            $this->load->view('templates/footer');
        }
    }

    public function tambahprogress()
    {
        $data['title'] = 'Tambah Progress';
        $data['users'] = $this->db->get_where('users', ['username' => $this->session->userdata('username')])->row_array();
        $data['data_unit'] = $this->opnamepro->getDatadropdownunitrumah();
        $data['data_pekerjaan'] = $this->opnamepro->getDatadropdownpekerjaan();
        
        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('transaksi/opnameprogress/opnameprogress_tambah.php', $data);
        $this->load->view('templates/footer');
    }

    public function simpanprogress()
    {
        $tgl_progress = $this->input->post('tgl_progress');
        $rpbu_id = $this->input->post('rpbu_id');
        $unit_id = $this->input->post('unit_id');
        $pekerjaan_id = $this->input->post('pekerjaan_id');
        $persentase = $this->input->post('persentase');
        $price = $this->input->post('price');
		$data = array(
            'tgl_progress' => $tgl_progress,
            'rpbu_id' => $rpbu_id,
            'unit_id' => $unit_id,
            'pekerjaan_id' => $pekerjaan_id,
            'persentase' => $persentase,
            'price' => $price,
		);
		$this->opnamepro->add_opnameprogress($data, 't_opname_progress');
		redirect('opnameprogress');
    }

    public function editprogress($kodex=0)
    {
        $t_opname_progress = $this->opnamepro->get_opnameprogress(" WHERE id_op='$kodex'")->row_array();
        $data = array(
            'title'=>'Edit Progress',
            'users'=>$this->db->get_where('users', ['username' => $this->session->userdata('username')])->row_array(),
            'id_op'=>$t_opname_progress['id_op'],
            'tgl_progress'=>$t_opname_progress['tgl_progress'],
            'rpbu_id'=>$t_opname_progress['rpbu_id'],
            'unit_id'=>$t_opname_progress['unit_id'],
            'pekerjaan_id'=>$t_opname_progress['pekerjaan_id'],
            'persentase'=>$t_opname_progress['persentase'],
            'price'=>$t_opname_progress['price'],
            'data_unit'=>$this->opnamepro->getDatadropdownunitrumah(),
            'data_pekerjaan'=>$this->opnamepro->getDatadropdownpekerjaan(),
        );

        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('transaksi/opnameprogress/opnameprogress_edit.php', $data);
        $this->load->view('templates/footer');    
    }

    public function updateprogress()
    {
        $id_op = $this->input->post('id_op');
        $tgl_progress = $this->input->post('tgl_progress');
        $rpbu_id = $this->input->post('rpbu_id');
        $unit_id = $this->input->post('unit_id');
        $pekerjaan_id = $this->input->post('pekerjaan_id');
        $persentase = $this->input->post('persentase');
        $price = $this->input->post('price');
        $data = array(
            'tgl_progress'=>$tgl_progress,
            'rpbu_id'=>$rpbu_id,
            'unit_id'=>$unit_id,
            'pekerjaan_id'=>$pekerjaan_id,
            'persentase'=>$persentase,
            'price'=>$price,
        );
        $result = $this->opnamepro->edit_opnameprogress('t_opname_progress', $data, array('id_op'=>$id_op));
        $this->session->set_flashdata('message', 'Update data');
        redirect('opnameprogress');
    }

    public function hapusprogress($id_op)
    {
        $this->db->where('id_op', $id_op);
        $this->db->delete('t_opname_progress');
        $this->session->set_flashdata('message', 'Hapus data');
        redirect('opnameprogress');
    }

    public function OpnameProgressPDF()
    {
        $pdf = new FPDF('l','mm','A5');
        // membuat halaman baru
        $pdf->AddPage();
        // setting jenis font yang akan digunakan
        $pdf->SetFont('Arial','B',16);
        // mencetak string 
        $pdf->Cell(190,7,'LAPORAN',0,1,'C');
        $pdf->SetFont('Arial','B',12);
        $pdf->Cell(190,7,'OPNAME PROGRESS SUMATIRTA',0,1,'C');
        // Memberikan space kebawah agar tidak terlalu rapat
        $pdf->Cell(10,7,'',0,1);
        $pdf->SetFont('Arial','B',10);
        $pdf->Cell(36,6,'Tanggal Pengerjaan',1,0,'C');
        $pdf->Cell(27,6,'Proyek',1,0,'C');
        $pdf->Cell(43,6,'Unit Rumah',1,0,'C');
        $pdf->Cell(30,6,'Customer',1,0,'C');
        $pdf->Cell(26,6,'Pekerjaan',1,0,'C');
        $pdf->Cell(28,6,'Nilai Progress',1,1,'C');
        $pdf->SetFont('Arial','',10);
        $opnameprogress = $this->opnamepro->joinTableOpnameprogress('opnameprogress')->result();
        foreach ($opnameprogress as $row){
            $pdf->Cell(36,6,$row->tgl_progress,1,0,'C');
            $pdf->Cell(27,6,$row->nama_pro,1,0,'C');
            $pdf->Cell(43,6,$row->alamat,1,0,'C'); 
            $pdf->Cell(30,6,$row->nama_cus,1,0,'C');
            $pdf->Cell(26,6,$row->pekerjaan,1,0,'C');
            $pdf->Cell(28,6,$row->persentase,1,1,'C');
        }
        $pdf->Output();
    }
} ?>