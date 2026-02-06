<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Admin_drivers extends MY_Controller {

  public function __construct(){
    parent::__construct();
    if(!$this->session->userdata('admin_id')) redirect('admin/admin_auth/login');
    $this->load->model('Driver_model','driver');
    $this->load->model('Auth_model','auth');
    $this->load->model('Notification_model','nm');
  }

  public function index(){
    $data['rows'] = $this->driver->list_drivers_with_profile();
    $this->load->view('admin/drivers_list', $data);
  }

  public function approve($user_id){
    $this->auth->set_status($user_id,'approved');
     $this->nm->create([
      'sender_role' => 'admin',
      'sender_id' => NULL,
      'receiver_role' => 'driver',
      'receiver_id' => $user_id,
      'title' => 'Driver Approved',
      'message' => 'Congratulations! Your driver account has been approved. You can now log in and start accepting rides.',
      'ref_type' => 'driver_approval',
      'ref_id' => $user_id,
      'severity' => 'success',
      'url' => site_url('driver/dashboard')
    ]);
    $this->session->set_flashdata('ok','Driver approved.');
    redirect('admin/admin_drivers');
  }

  public function reject($user_id){
    $this->auth->set_status($user_id,'rejected');
    $this->nm->create([
      'sender_role' => 'driver',
      'sender_id' => $user_id,
      'receiver_role' => 'admin',
      'receiver_id' => NULL,
      'title' => 'Driver Rejected',
      'message' => 'Your verification is rejected. Please update documents.',
      'ref_type' => 'driver_rejection',
      'ref_id' => $user_id,
      'severity' => 'warning',
      'url' => site_url('admin/admin_drivers/view/' . $user_id)
    ]);
    $this->session->set_flashdata('ok','Driver rejected.');
    redirect('admin/admin_drivers');
  }

  public function suspend($user_id){
    $this->auth->set_status($user_id,'suspended');
    $this->nm->create([
      'sender_role' => 'driver',
      'sender_id' => $user_id,
      'receiver_role' => 'admin',
      'receiver_id' => NULL,
      'title' => 'Driver Suspended',
      'message' => 'Driver account has been suspended. Please contact support.',
      'ref_type' => 'driver_suspension',
      'ref_id' => $user_id,
      'severity' => 'danger',
      'url' => site_url('admin/admin_drivers/view/' . $user_id)
    ]);
     $this->session->set_flashdata('ok','Driver suspended.');
    redirect('admin/admin_drivers');
  }
}
