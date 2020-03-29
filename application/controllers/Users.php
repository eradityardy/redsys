<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Users extends CI_Controller {

    function __construct()
    {
        parent::__construct();
        
        is_logged_in();
        $this->load->helper('tglindo');
        $this->load->helper('rupiah');
        $this->load->helper('url');
        $this->load->model('Users_model', 'user');
	}

    public function index()
    {
        $this->form_validation->set_rules('username', 'Username', 'required|trim|is_unique[users.username]', array(
            'is_unique' => 'Simpan Gagal! Username sudah ada'
        ));
        $this->form_validation->set_rules('fullname', 'Nama Panjang', 'required|trim');
        $this->form_validation->set_rules('password', 'Password', 'required|trim');
        $this->form_validation->set_rules('role', 'Role', 'required|trim');
        $this->form_validation->set_rules('password', 'Password', 'required|trim|min_length[3]|matches[repassword]', array(
            'matches' => 'Password tidak sama',
            'min_length' => 'password min 3 karakter'
        ));
        $this->form_validation->set_rules('repassword', 'Re-Password', 'required|trim|matches[password]');

        if ($this->form_validation->run() == FALSE) {
            $data['title'] = 'Users';
            $data['users'] = $this->db->get_where('users', ['username' => $this->session->userdata('username')])->row_array();
            $data['user'] = $this->user->get_users()->result_array();

            if($this->session->userdata('role') == 'manager'){
                $this->load->view('templates/header', $data);
                $this->load->view('templates/sidebar', $data);
                $this->load->view('users/users', $data);
                $this->load->view('templates/footer');
            }else{
                redirect('errorpage');
            }
        } else {
            $data = [
                'fullname' => $this->input->post('fullname', true),
                'username' => $this->input->post('username', true),
                'password' => $this->input->post('password', true),
                'role' => $this->input->post('role', true),
                'usersdate_created' => $this->input->post('usersdate_created', true),
                'image' => 'default.png',
                'is_active' => 1
            ];
            $this->db->insert('users', $data);
            $this->session->set_flashdata('message', 'Simpan data');
            redirect('users');
        }
        
    }

    public function edituser($id_users)
    {
        $this->form_validation->set_rules('username', 'Username', 'required|trim');
        $this->form_validation->set_rules('fullname', 'Nama Panjang', 'required|trim');
        $this->form_validation->set_rules('role', 'Role', 'required|trim');
        $this->form_validation->set_rules('is_active', 'Status Aktif', 'required|trim');

        if ($this->form_validation->run() == false) {
            $data['title'] = 'Users';
            $data['users'] = $this->db->get_where('users', ['username' => $this->session->userdata('username')])->row_array();
            $data['user'] = $this->db->get_where('users', ['id_users' => $id_users])->row_array();

            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar', $data);
            $this->load->view('users/users_edit', $data);
            $this->load->view('templates/footer');
        } else {
            $username = $this->input->post('username');
            $fullname = $this->input->post('fullname');
            $role = $this->input->post('role');
            $is_active = $this->input->post('is_active');

            $this->db->set('username', $username);
            $this->db->set('fullname', $fullname);
            $this->db->set('role', $role);
            $this->db->set('is_active', $is_active);

            $this->db->where('id_users', $id_users);
            $this->db->update('users');
            $this->session->set_flashdata('message', 'Update data');
            redirect('users/edituser/' . $id_users);
        }
    }

    public function hapususer($id_users)
    {
        $this->db->where('id_users', $id_users);
        $this->db->delete('users');
        $this->session->set_flashdata('message', 'Hapus user');
        redirect('users');
    }
}