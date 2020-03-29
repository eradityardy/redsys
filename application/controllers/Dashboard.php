<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends CI_Controller {

    public function __construct()
    {
        parent::__construct();

        is_logged_in();
        $this->load->helper('tglindo');
        $this->load->helper('rupiah');
        $this->load->helper('url');
        $this->load->model('Users_model', 'users');
	}

    public function index()
    {
        $this->form_validation->set_rules('fullname', 'Nama Lengkap', 'required|trim');

        if ($this->form_validation->run() == false) {
            $data['title'] = 'Dashboard';
            $data['users'] = $this->db->get_where('users', ['username' => $this->session->userdata('username')])->row_array();
            $data['user_aktif'] = $this->users->countUsersAktif();
            $data['count_pekerja'] = $this->users->countJmlPekerja();
            $data['count_karyawan'] = $this->users->countJmlKaryawan();
            $data['count_unitrumah'] = $this->users->countUnitRumah();
            $data['count_proyek'] = $this->users->countProyek();
            $data['list_user'] = $this->db->get('users')->result_array();
            $data['list_karyawan'] = $this->db->get('vw_karyawan')->result_array();

            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar', $data);
            $this->load->view('dashboard');
            $this->load->view('templates/footer');
        } else {
            $id_users = $this->input->post('id_users');
            $fullname = $this->input->post('fullname');
            $this->db->set('fullname', $fullname);
            $this->db->where('id_users', $id_users);
            $this->db->update('users');

            $this->session->set_flashdata('message', 'Update data');
            redirect('dashboard');
        }
    }

    public function ubah_password()
    {
        $this->form_validation->set_rules('current_password', 'Password Lama', 'required|trim');
        $this->form_validation->set_rules('new_password1', 'Password Baru', 'required|trim|min_length[3]|matches[new_password2]');
        $this->form_validation->set_rules('new_password2', 'Konfirm Password Baru', 'required|trim|min_length[3]|matches[new_password1]');

        if ($this->form_validation->run() == false) {
            $data['title'] = 'Dashboard';
            $data['users'] = $this->db->get_where('users', ['username' => $this->session->userdata('username')])->row_array();
            $data['user_aktif'] = $this->users->countUsersAktif();
            $data['count_pekerja'] = $this->users->countJmlPekerja();
            $data['count_karyawan'] = $this->users->countJmlKaryawan();
            $data['count_unitrumah'] = $this->users->countUnitRumah();
            $data['list_user'] = $this->db->get('users')->result_array();
            $data['list_karyawan'] = $this->db->get('m_karyawan')->result_array();

            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar', $data);
            $this->load->view('dashboard');
            $this->load->view('templates/footer');
        } else {
            $current_password = $this->input->post('current_password');
            $new_password = $this->input->post('new_password1');
            if ($current_password == $new_password) {
                $this->session->set_flashdata('msg', '<div class="alert alert-danger" role="alert">Password baru tidak boleh sama dengan password lama</div>');
                redirect('admin/index');
            } else {
                $password_newlah = $new_password;
                $this->db->set('password', $password_newlah);
                $this->db->where('username', $this->session->userdata('username'));
                $this->db->update('users');
                $this->session->set_flashdata('message', 'Ubah password');
                redirect('dashboard');
            }
        }
    }
} ?>