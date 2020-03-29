<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Rabpekerjaanbyunit extends CI_Controller {

    function __construct()
    {
        parent::__construct();
        
        is_logged_in();
        $this->load->helper('tglindo');
        $this->load->helper('rupiah');
        $this->load->helper('url');
        $this->load->model('Rabpekerjaanbyunit_model', 'rabpekbyunit');
	}
    
    public function index()
    {
        $data['title'] = 'RAB Pekerjaan Unit Rumah';
        $data['users'] = $this->db->get_where('users', ['username' => $this->session->userdata('username')])->row_array();
        $data['rabpekbyunit'] = $this->rabpekbyunit->joinTableRabpekerjaanbyunit()->result_array();

        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('masters/rabpekerjaanbyunit/rabpekerjaanbyunit', $data);
        $this->load->view('templates/footer');
    }

    public function detailrab($id_unit)
    {
        $this->form_validation->set_rules('pekerjaan_id', 'Pekerjaan', 'required|trim');
        $this->form_validation->set_rules('unit_id', 'Unit Rumah', 'required|trim');
        $this->form_validation->set_rules('price', 'Harga Pekerjaan', 'required|trim');

        if ($this->form_validation->run() == FALSE) {
            $data['title'] = 'RAB Pekerjaan Unit Rumah';
            $data['users'] = $this->db->get_where('users', ['username' => $this->session->userdata('username')])->row_array();
            $data['detailrab'] = $this->rabpekbyunit->show_pekerjaan_by_unit_id($id_unit)->result_array();
            $data['unit_id'] = $id_unit;
            $data['data_unit'] = $this->rabpekbyunit->getDataunit();
            $data['data_pekerjaan'] = $this->rabpekbyunit->getDatapekerjaan();
            $data['unitrum'] = $this->db->get_where('vw_rab_pekerjaan_by_unitrumah_summary', ['id_unit' => $id_unit])->row_array();

            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar', $data);
            $this->load->view('masters/rabpekerjaanbyunit/rabpekerjaanbyunit_lihat.php', $data);
            $this->load->view('templates/footer');
        } else {
            $unit_id = $this->input->post('unit_id');
            $pekerjaan_id = $this->input->post('pekerjaan_id');
            $price = $this->input->post('price');
            $data = array(
                'unit_id'=>$unit_id,
                'pekerjaan_id'=>$pekerjaan_id,
                'price'=>$price,
            );
            $cek = $this->db->query("SELECT * FROM m_rab_pekerjaan_byunit where unit_id='".$this->input->post('unit_id')."' AND pekerjaan_id='".$this->input->post('pekerjaan_id')."'")->num_rows();
            if ($cek<=0) {
                $this->rabpekbyunit->add_rabpekerjaanbyunit($data, 'm_rab_pekerjaan_byunit');
                $this->session->set_flashdata('message', 'Simpan data');
                redirect('rabpekerjaanbyunit/detailrab/'.$unit_id);
            }
            else {
                $this->session->set_flashdata('message', 'Pekerjaan sudah ada, Tidak tersimpan secara');
                redirect('rabpekerjaanbyunit/detailrab/'.$unit_id);
            }
        }
    }


    public function hapusrab($unit_id, $id)
    {
        $this->db->where('id', $id);
        $this->db->delete('m_rab_pekerjaan_byunit');
        $this->session->set_flashdata('message', 'Hapus data');
        redirect('rabpekerjaanbyunit/detailrab/'.$unit_id);
    }
} ?>