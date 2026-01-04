<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Admin_drivers extends CI_Controller {

  public function __construct(){
    parent::__construct();
    if(!$this->session->userdata('admin_id')) redirect('admin/admin_auth/login');
    $this->load->model('Driver_model','driver');
    $this->load->model('Auth_model','auth');
    $this->load->model('Notification_model','noti');
  }

  public function index(){
    $data['rows'] = $this->driver->list_drivers_with_profile();
    $this->load->view('admin/drivers_list', $data);
  }

  public function approve($user_id){
    $this->auth->set_status($user_id,'approved');
    $this->noti->add($user_id,'Driver Approved','Your account is approved. You can add vehicles now.','driver', $user_id);
    $this->session->set_flashdata('ok','Driver approved.');
    redirect('admin/admin_drivers');
  }

  public function reject($user_id){
    $this->auth->set_status($user_id,'rejected');
    $this->noti->add($user_id,'Driver Rejected','Your verification is rejected. Please update documents.','driver',$user_id);
    $this->session->set_flashdata('ok','Driver rejected.');
    redirect('admin/admin_drivers');
  }

  public function suspend($user_id){
    $this->auth->set_status($user_id,'suspended');
    $this->noti->add($user_id,'Account Suspended','Your account has been suspended by admin.','driver',$user_id);
    $this->session->set_flashdata('ok','Driver suspended.');
    redirect('admin/admin_drivers');
  }
}
