<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Auth extends CI_Controller
{
    public function index()
    {
        $this->form_validation->set_rules('username', 'Username', 'trim|required');
        $this->form_validation->set_rules('password', 'Password', 'trim|required');
        if ($this->form_validation->run() == false) {
            $this->load->view('auth/index');
        } else {
            $username = $this->input->post('username');
            $password = $this->input->post('password');
            $user = $this->db->get_where('users', ['username' => $username])->row_array();
            if ($user) {
                if ($user['is_active'] == 1) {
                    if ($password == $user['password']) {
                        $data = [
                            'id_users' => $user['id_users'],
                            'username' => $user['username'],
                            'fullname' => $user['fullname'],
                            'role' => $user['role']
                        ];
                        $this->session->set_userdata($data);
                        redirect('dashboard');
                    } else {
                        $this->session->set_flashdata('msg', '<div class="alert alert-danger" role="alert">Password salah</div>');
                        redirect('auth');
                    }
                } else {
                    $this->session->set_flashdata('msg', '<div class="alert alert-danger" role="alert">User Tidak aktif</div>');
                    redirect('auth');
                }
            } else {
                $this->session->set_flashdata('msg', '<div class="alert alert-danger" role="alert">Username dan Password tidak sama</div>');
                redirect('auth');
            }
        }
    }

    public function blocked()
    {
        $data['title'] = 'Access Forbidden';
        $data['user'] = $this->db->get_where('users', ['username' => $this->session->userdata('username')])->row_array();
        $this->load->view('auth/blocked', $data);
    }

    public function logout()
    {
        $this->session->unset_userdata('id_user');
        $this->session->unset_userdata('username');
        $this->session->unset_userdata('pegawai_kd');
        $this->session->unset_userdata('nama');
        $this->session->unset_userdata('level');
        $this->session->set_flashdata('message', 'Logout');
        redirect('auth/index');
    }
}
