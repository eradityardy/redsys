<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Databagkaryawan extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        
        is_logged_in();
        $this->load->helper('tglindo');
        $this->load->helper('rupiah');
        $this->load->helper('url');
        $this->load->model('Bagkaryawan_model', 'bagkaryawan');
	}

    public function index()
    {
        $this->form_validation->set_rules('nama_bag', 'Bagian Karyawan', 'required|trim|is_unique[m_bagian_pekerjaan.nama_bag]', array(
            'is_unique' => 'Simpan Gagal! Bagian Karyawan sudah ada'
        ));

        if ($this->form_validation->run() == FALSE) {
            $data['title'] = 'Bagian Karyawan';
            $data['users'] = $this->db->get_where('users', ['username' => $this->session->userdata('username')])->row_array();
            $data['bagkaryawan'] = $this->db->get('m_bagian_pekerjaan')->result_array();

            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar', $data);
            $this->load->view('masters/databagkaryawan/databagkaryawan', $data);
            $this->load->view('templates/footer');
        } else {
            $data = [
                'nama_bag' => $this->input->post('nama_bag', true),
                'keterangan' => $this->input->post('keterangan', true),
            ];
            $this->db->insert('m_bagian_pekerjaan', $data);
            $this->session->set_flashdata('message', 'Simpan data');
            redirect('databagkaryawan');
        }
    }

    public function editbagkaryawan()
    {
        echo json_encode($this->bagkaryawan->getEditBagian($_POST['id_bag']));
    }

    public function proses_edit_bagkaryawan()
    {
        $id_bag = $this->input->post('id_bag');
        $nama_bag = $this->input->post('nama_bag');
        $keterangan = $this->input->post('keterangan');
        $this->db->set('nama_bag', $nama_bag);
        $this->db->set('keterangan', $keterangan);
        $this->db->where('id_bag', $id_bag);
        $this->db->update('m_bagian_pekerjaan');
        $this->session->set_flashdata('message', 'Update data');
        redirect('databagkaryawan');
    }

    public function hapusbagkaryawan($id_bag)
    {
        $this->db->where('id_bag', $id_bag);
        $this->db->delete('m_bagian_pekerjaan');
        $this->session->set_flashdata('message', 'Hapus data');
        redirect('databagkaryawan');
    }
}