<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Customer_dashboard extends CI_Controller {

  public function __construct(){
    parent::__construct();
    if(!$this->session->userdata('customer_id')) redirect('customer/customer_auth/login');
    $this->load->model('Auth_model','auth');
    $this->load->model('Cargo_model','cargo');
  }

  public function index(){
    $cid = (int)$this->session->userdata('customer_id');
    $u = $this->auth->get_user($cid);
    $data['user'] = $u;
    $data['need_verify'] = ($u && $u['status']=='pending');
    $data['bookings'] = $this->cargo->list_by_customer($cid);
    $this->load->view('customer/dashboard',$data);
  }
}
