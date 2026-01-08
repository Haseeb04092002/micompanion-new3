<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Customer_notifications extends MY_Controller {

  public function __construct(){
    parent::__construct();
    if(!$this->session->userdata('customer_id')) redirect('customer/customer_auth/login');
    $this->load->model('Notification_model','noti');
  }

  public function index(){
    $uid = (int)$this->session->userdata('customer_id');
    $data['rows'] = $this->noti->list_for_user($uid);
    $this->load->view('customer/notifications',$data);
  }
}
