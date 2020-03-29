<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Bookingrumah extends CI_Controller {

    function __construct()
    {
        parent::__construct();
        
        is_logged_in();
        $this->load->helper('tglindo');
        $this->load->helper('rupiah');
        $this->load->helper('url');
        $this->load->library('pdf');
        $this->load->model('Bookingrumah_model', 'bokrum');
	}
    
    public function index()
    {
        $data['title'] = 'Booking Rumah';
        $data['users'] = $this->db->get_where('users', ['username' => $this->session->userdata('username')])->row_array();
        $data['bookingrumah'] = $this->bokrum->joinTableBookingrumah()->result_array();

        if($this->session->userdata('role') == 'operator'){
            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar', $data);
            $this->load->view('transaksi/bookingrumah/bookingrumah_operator', $data);
            $this->load->view('templates/footer');
        }else{
            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar', $data);
            $this->load->view('transaksi/bookingrumah/bookingrumah', $data);
            $this->load->view('templates/footer');
        }
    }

    public function tambahbooking()
    {
        $data['title'] = 'Tambah Booking';
        $data['users'] = $this->db->get_where('users', ['username' => $this->session->userdata('username')])->row_array();
        $data['data_bank'] = $this->bokrum->getDatadropdownbank();
        $data['data_pro'] = $this->bokrum->getDatadropdownproyek();
        $data['data_unit'] = $this->bokrum->getDatadropdownunitrumah();
        
        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('transaksi/bookingrumah/bookingrumah_tambah.php', $data);
        $this->load->view('templates/footer');
    }

    public function simpanbooking()
    {
        $bank_id = $this->input->post('bank_id');
        $project_id = $this->input->post('project_id');
        $unitrumah_id = $this->input->post('unitrumah_id');
        $customer_id = $this->input->post('customer_id');
        $tgl_berkaskebank = $this->input->post('tgl_berkaskebank');
        $tgl_akad = $this->input->post('tgl_akad');
        $tgl_berkastolak = $this->input->post('tgl_berkastolak');
        $alasan_tolak = $this->input->post('alasan_tolak');
		$data = array(
            'bank_id' => $bank_id,
            'project_id' => $project_id,
            'unitrumah_id' => $unitrumah_id,
            'customer_id' => $customer_id,
            'tgl_berkaskebank' => $tgl_berkaskebank,
            'tgl_akad' => $tgl_akad,
            'tgl_berkastolak' => $tgl_berkastolak,
            'alasan_tolak' => $alasan_tolak,
		);
		$this->bokrum->add_book($data, 't_book_rumah');
		redirect('bookingrumah');
    }

    public function editbooking($kodex=0)
    {
        $t_book_rumah = $this->bokrum->get_book(" WHERE id_booking='$kodex'")->row_array();
        $data = array(
            'title'=>'Edit Booking',
            'users'=>$this->db->get_where('users', ['username' => $this->session->userdata('username')])->row_array(),
            'id_booking'=>$t_book_rumah['id_booking'],
            'bank_id'=>$t_book_rumah['bank_id'],
            'project_id'=>$t_book_rumah['project_id'],
            'unitrumah_id'=>$t_book_rumah['unitrumah_id'],
            'customer_id'=>$t_book_rumah['customer_id'],
            'nama_cus'=>$t_book_rumah['nama_cus'],
            'tgl_berkaskebank'=>$t_book_rumah['tgl_berkaskebank'],
            'tgl_akad'=>$t_book_rumah['tgl_akad'],
            'tgl_berkastolak'=>$t_book_rumah['tgl_berkastolak'],
            'alasan_tolak'=>$t_book_rumah['alasan_tolak'],
            'data_bank'=>$this->bokrum->getDatadropdownbank(),
            'data_pro'=>$this->bokrum->getDatadropdownproyek(),
            'data_unit'=>$this->bokrum->getDatadropdownunitrumah(),
        );

        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('transaksi/bookingrumah/bookingrumah_edit.php', $data);
        $this->load->view('templates/footer');    
    }

    public function updatebooking()
    {
        $id_booking = $this->input->post('id_booking');
        $bank_id = $this->input->post('bank_id');
        $project_id = $this->input->post('project_id');
        $unitrumah_id = $this->input->post('unitrumah_id');
        $customer_id = $this->input->post('customer_id');
        $tgl_berkaskebank = $this->input->post('tgl_berkaskebank');
        $tgl_akad = $this->input->post('tgl_akad');
        $tgl_berkastolak = $this->input->post('tgl_berkastolak');
        $alasan_tolak = $this->input->post('alasan_tolak');
        $data = array(
            'bank_id'=>$bank_id,
            'project_id'=>$project_id,
            'unitrumah_id'=>$unitrumah_id,
            'customer_id'=>$customer_id,
            'tgl_berkaskebank'=>$tgl_berkaskebank,
            'tgl_akad'=>$tgl_akad,
            'tgl_berkastolak'=>$tgl_berkastolak,
            'alasan_tolak'=>$alasan_tolak,
        );
        $result = $this->bokrum->edit_book('t_book_rumah', $data, array('id_booking'=>$id_booking));
        $this->session->set_flashdata('message', 'Update data');
        redirect('bookingrumah');
    }

    public function hapusbooking($id_booking)
    {
        $this->db->where('id_booking', $id_booking);
        $this->db->delete('t_book_rumah');
        $this->session->set_flashdata('message', 'Hapus data');
        redirect('bookingrumah');
    }
}