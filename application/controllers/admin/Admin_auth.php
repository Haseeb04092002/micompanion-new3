<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Admin_auth extends MY_Controller {

  public function __construct(){
    parent::__construct();
    $this->load->model('Auth_model','auth');
  }

  public function login(){
    if($this->session->userdata('admin_id')) redirect('admin/admin_dashboard');

    $data['err'] = '';
    if($this->input->post('do_login')){
      $email = trim($this->input->post('email', true));
      $pass  = trim($this->input->post('password', true));

      if($email=='' || $pass==''){
        $data['err'] = 'Please enter email and password.';
      } else {
        $u = $this->auth->login('admin', $email, $pass);
        if($u){
          $this->session->set_userdata('admin_id', $u['user_id']);
          $this->session->set_flashdata('ok','Welcome Admin!');
          redirect('admin/admin_dashboard');
        } else {
          $data['err'] = 'Invalid login.';
        }
      }
    }
    $this->load->view('admin/login', $data);
  }

  public function logout(){
    $this->session->unset_userdata('admin_id');
    redirect('admin/admin_auth/login');
  }
}
