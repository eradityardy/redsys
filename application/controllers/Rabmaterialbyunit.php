<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Rabmaterialbyunit extends CI_Controller {

    function __construct()
    {
        parent::__construct();
        
        is_logged_in();
        $this->load->helper('tglindo');
        $this->load->helper('rupiah');
        $this->load->helper('url');
        $this->load->model('Rabmaterialbyunit_model', 'rabmatbyunit');
	}
    
    public function index()
    {
        $data['title'] = 'RAB Material Unit Rumah';
        $data['users'] = $this->db->get_where('users', ['username' => $this->session->userdata('username')])->row_array();
        $data['rabmatbyunit'] = $this->rabmatbyunit->joinTableRabmaterialbyunit()->result_array();
        
        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('masters/rabmaterialbyunit/rabmaterialbyunit', $data);
        $this->load->view('templates/footer');
    }

    public function detailrab($id_unit)
    {
        $this->form_validation->set_rules('material_id', 'Material', 'required|trim');
        $this->form_validation->set_rules('unit_id', 'Unit Rumah', 'required|trim');
        $this->form_validation->set_rules('qty', 'Quantity Material', 'required|trim');
        $this->form_validation->set_rules('price', 'Harga Material', 'required|trim');

        if ($this->form_validation->run() == FALSE) {
            $data['title'] = 'RAB Material Unit Rumah';
            $data['users'] = $this->db->get_where('users', ['username' => $this->session->userdata('username')])->row_array();
            $data['detailrab'] = $this->rabmatbyunit->show_material_by_unit_id($id_unit)->result_array();
            $data['unit_id'] = $id_unit;
            $data['data_unit'] = $this->rabmatbyunit->getDataunit();
            $data['data_material'] = $this->rabmatbyunit->getDatamaterial();
            $data['unitrum'] = $this->db->get_where('vw_rab_material_by_unitrumah_summary', ['id_unit' => $id_unit])->row_array();

            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar', $data);
            $this->load->view('masters/rabmaterialbyunit/rabmaterialbyunit_lihat.php', $data);
            $this->load->view('templates/footer');
        } else {
            $unit_id = $this->input->post('unit_id');
            $material_id = $this->input->post('material_id');
            $qty = $this->input->post('qty');
            $price = $this->input->post('price');
            $data = array(
                'unit_id'=>$unit_id,
                'material_id'=>$material_id,
                'price'=>$price,
                'qty'=>$qty,
            );
            $cek = $this->db->query("SELECT * FROM m_rab_material_byunit where unit_id='".$this->input->post('unit_id')."' AND material_id='".$this->input->post('material_id')."'")->num_rows();
            if ($cek<=0) {
                $this->rabmatbyunit->add_rabmaterialbyunit($data, 'm_rab_material_byunit');
                $this->session->set_flashdata('message', 'Simpan data');
                redirect('rabmaterialbyunit/detailrab/'.$unit_id);
            }
            else {
                $this->session->set_flashdata('message', 'Material sudah ada, Tidak tersimpan secara');
                redirect('rabmaterialbyunit/detailrab/'.$unit_id);
            }
        }
    }

    public function hapusrab($unit_id, $id_rmbu)
    {
        $this->db->where('id_rmbu', $id_rmbu);
        $this->db->delete('m_rab_material_byunit');
        $this->session->set_flashdata('message', 'Hapus data');
        redirect('rabmaterialbyunit/detailrab/'.$unit_id);
    }
} ?>