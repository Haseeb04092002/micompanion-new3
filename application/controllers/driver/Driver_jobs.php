<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Driver_jobs extends CI_Controller {

  public function __construct(){
    parent::__construct();
    if(!$this->session->userdata('driver_id')) redirect('driver/driver_auth/login');
    $this->load->model('Cargo_model','cargo');
    $this->load->model('Notification_model','noti');
  }

  public function index(){
    $driver_id = (int)$this->session->userdata('driver_id');
    $data['rows'] = $this->cargo->driver_jobs($driver_id);
    $this->load->view('driver/jobs_list', $data);
  }

  public function view($booking_id){
    $driver_id = (int)$this->session->userdata('driver_id');
    $b = $this->cargo->get_booking($booking_id);
    if(!$b){ show_404(); }

    // ensure this booking assigned to current driver (manual check)
    $a = $this->db->get_where('cargo_assignments', ['booking_id'=>(int)$booking_id,'driver_id'=>$driver_id])->row_array();
    if(!$a){ show_404(); }

    if($this->input->post('set_status')){
      $status = $this->input->post('status', true);
      $note   = trim($this->input->post('note', true));

      $allowed = ['accepted','rejected','picked_up','in_transit','delivered','mishap'];
      if(!in_array($status,$allowed)){
        $this->session->set_flashdata('err','Invalid status.');
        redirect('driver/driver_jobs/view/'.$booking_id);
      }

      $this->cargo->update_status($booking_id, $status, $note);

      // notify customer + admin
      $this->noti->add($b['customer_id'], 'Cargo Update', 'Your cargo status: '.$status, 'booking', $booking_id);

      $admin_id = (int)$a['admin_id'];
      if($admin_id>0) $this->noti->add($admin_id, 'Cargo Update', 'Driver updated status: '.$status, 'booking', $booking_id);

      $this->session->set_flashdata('ok','Status updated.');
      redirect('driver/driver_jobs/view/'.$booking_id);
    }

    $data['booking'] = $b;
    $data['logs'] = $this->cargo->status_logs($booking_id);
    $this->load->view('driver/job_view', $data);
  }
}
