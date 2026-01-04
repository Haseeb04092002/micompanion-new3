<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Customer_auth extends CI_Controller {

  public function __construct(){
    parent::__construct();
    $this->load->model('Auth_model','auth');
    $this->load->model('User_model','user');
  }

  public function register(){
    $data['err']='';

    if($this->input->post('do_register')){
      $name = trim($this->input->post('name', true));
      $email= trim($this->input->post('email', true));
      $pass = trim($this->input->post('password', true));

      if($name=='' || $email=='' || $pass==''){
        $data['err']='All fields required.';
      } elseif($this->user->exists_email($email)){
        $data['err']='Email already exists.';
      } else {
        $id = $this->auth->create_user([
          'role'=>'customer',
          'name'=>$name,
          'email'=>$email,
          'password'=>$pass,
          'status'=>'pending',
          'created_at'=>date('Y-m-d H:i:s')
        ]);
        $this->session->set_userdata('customer_id', $id);
        $this->session->set_flashdata('ok','Account created. Please upload verification.');
        redirect('customer/customer_dashboard');
      }
    }

    $this->load->view('customer/register', $data);

  }

  public function login(){
    $data['err']='';
    if($this->input->post('do_login')){
      $email= trim($this->input->post('email', true));
      $pass = trim($this->input->post('password', true));
      if($email=='' || $pass=='') $data['err']='Enter email and password.';
      else {
        $u = $this->auth->login('customer',$email,$pass);
        if($u){
          $this->session->set_userdata('customer_id',$u['user_id']);
          redirect('customer/customer_dashboard');
        } else $data['err']='Invalid login.';
      }
    }
    $this->load->view('customer/login', $data);
  }

  public function logout(){
    $this->session->unset_userdata('customer_id');
    redirect('customer/customer_auth/login');
  }
}
