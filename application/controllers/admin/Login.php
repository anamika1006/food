<?php
defined('BASEPATH') OR exit ('No direct script access allowed');

class Login extends CI_Controller {

    public function index() {
        $this->load->view('admin/login');
    }

    public function authenticate() {
        $this->load->library('form_validation');
        $this->load->model('Admin_model');
        
        $this->form_validation->set_rules('username','Username', 'trim|required');
        $this->form_validation->set_rules('password','Password', 'trim|required');

        if($this->form_validation->run() == true) {
            $username = $this->input->post('username');
            $password = $this->input->post('password');
            $this->db->select('*');
            $this->db->from('admin');
            $this->db->where('username',$username);
            $this->db->where('password',$password);
            $admin=$this->db->get()->row();
             if($admin==TRUE) {
                $adminArray['admin_id'] = $admin->admin_id;
                $adminArray['username'] = $admin->username;
                $this->session->set_userdata('admin', $adminArray);
                redirect(base_url().'admin/home');
             } else {
                $this->session->set_flashdata('msg', 'Either username or password is incorrect');
                redirect(base_url().'admin/login/index');
             }
             //success
         } else {
             //Error
            $this->load->view('admin/login');
         }
    }

    public function logout() {
        $this->session->unset_userdata('admin');
        redirect(base_url().'admin/login/index');
    }
}