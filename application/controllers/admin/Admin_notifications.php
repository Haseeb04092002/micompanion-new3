<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Admin_notifications extends CI_Controller {

  public function __construct(){
    parent::__construct();
    if(!$this->session->userdata('admin_id')) redirect('admin/admin_auth/login');
    $this->load->model('Notification_model','noti');
  }

  public function index(){
    $admin_id = (int)$this->session->userdata('admin_id');
    $data['rows'] = $this->noti->list_for_user($admin_id);
    $this->load->view('admin/notifications', $data);
  }
}
