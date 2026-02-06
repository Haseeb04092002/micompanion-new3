<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Admin_vehicles extends MY_Controller {

  public function __construct(){
    parent::__construct();
    if(!$this->session->userdata('admin_id')) redirect('admin/admin_auth/login');
    $this->load->model('Vehicle_model','veh');
    $this->load->model('Notification_model','nm');
  }

  public function index(){
    $data['rows'] = $this->veh->list_all();
    $this->load->view('admin/vehicles_list', $data);
  }

  public function approve($vehicle_id){
    // find driver id
    $v = $this->db->get_where('driver_vehicles',['vehicle_id'=>(int)$vehicle_id])->row_array();
    $this->veh->set_approval($vehicle_id,'approved');
    if($v)
     $this->nm->create([
      'sender_role' => 'admin',
      'sender_id' => NULL,
      'receiver_role' => 'driver',
      'receiver_id' => $v ? $v['driver_id'] : NULL,
      'title' => 'Vehicle Approved',
      'message' => 'Congratulations! Your vehicle has been approved. You can now start accepting rides.',
      'ref_type' => 'vehicle_approval',
      'ref_id' => $vehicle_id,
      'severity' => 'success',
      'url' => site_url('driver/vehicles')
    ]);
    $this->session->set_flashdata('ok','Vehicle approved.');
    redirect('admin/admin_vehicles');
  }

  public function reject($vehicle_id){
    $v = $this->db->get_where('driver_vehicles',['vehicle_id'=>(int)$vehicle_id])->row_array();
    $this->veh->set_approval($vehicle_id,'rejected');
    if($v) $this->nm->create([
      'sender_role' => 'admin',
      'sender_id' => NULL,
      'receiver_role' => 'driver',
      'receiver_id' => $v['driver_id'],
      'title' => 'Vehicle Rejected',
      'message' => 'Your vehicle is rejected. Please update details.',
      'ref_type' => 'vehicle_rejection',
      'ref_id' => $vehicle_id,
      'severity' => 'warning',
      'url' => site_url('driver/vehicles')
    ]);
    $this->session->set_flashdata('ok','Vehicle rejected.');
    redirect('admin/admin_vehicles');
  }
}
