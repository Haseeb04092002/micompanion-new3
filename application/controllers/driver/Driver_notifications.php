<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Driver_notifications extends CI_Controller {

  public function __construct(){
    parent::__construct();
    if(!$this->session->userdata('driver_id')) redirect('driver/driver_auth/login');
    $this->load->model('Notification_model','noti');
  }

  public function index(){
    $uid = (int)$this->session->userdata('driver_id');
    $data['rows'] = $this->noti->list_for_user($uid);
    $this->load->view('driver/notifications',$data);
  }
}
