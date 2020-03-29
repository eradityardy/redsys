<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Datagudang extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        
        is_logged_in();
        $this->load->helper('tglindo');
        $this->load->helper('rupiah');
        $this->load->helper('url');
        $this->load->model('Gudang_model', 'gudang');
	}

    public function index()
    {
        $this->form_validation->set_rules('nama_gud', 'Gudang', 'required|trim|is_unique[m_gudang.nama_gud]', array(
            'is_unique' => 'Simpan Gagal! Gudang sudah ada'
        ));

        if ($this->form_validation->run() == FALSE) {
            $data['title'] = 'Gudang';
            $data['users'] = $this->db->get_where('users', ['username' => $this->session->userdata('username')])->row_array();
            $data['gudang'] = $this->db->get('m_gudang')->result_array();

            if($this->session->userdata('role') == 'operator'){
                $this->load->view('templates/header', $data);
                $this->load->view('templates/sidebar', $data);
                $this->load->view('masters/datagudang/datagudang_operator', $data);
                $this->load->view('templates/footer');
            }else{
                $this->load->view('templates/header', $data);
                $this->load->view('templates/sidebar', $data);
                $this->load->view('masters/datagudang/datagudang', $data);
                $this->load->view('templates/footer');
            }
        } else {
            $data = [
                'nama_gud' => $this->input->post('nama_gud', true),
                'keterangan' => $this->input->post('keterangan', true),
            ];
            $this->db->insert('m_gudang', $data);
            $this->session->set_flashdata('message', 'Simpan data');
            redirect('datagudang');
        }
    }

    public function editgudang()
    {
        echo json_encode($this->gudang->getEditGudang($_POST['id_gud']));
    }

    public function proses_edit_gudang()
    {
        $id_gud = $this->input->post('id_gud');
        $nama_gud = $this->input->post('nama_gud');
        $keterangan = $this->input->post('keterangan');
        $this->db->set('nama_gud', $nama_gud);
        $this->db->set('keterangan', $keterangan);
        $this->db->where('id_gud', $id_gud);
        $this->db->update('m_gudang');
        $this->session->set_flashdata('message', 'Update data');
        redirect('datagudang');
    }

    public function hapusgudang($id_gud)
    {
        $this->db->where('id_gud', $id_gud);
        $this->db->delete('m_gudang');
        $this->session->set_flashdata('message', 'Hapus data');
        redirect('datagudang');
    }
}