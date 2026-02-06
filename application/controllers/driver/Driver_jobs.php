<?php defined('BASEPATH') or exit('No direct script access allowed');

class Driver_jobs extends MY_Controller
{

  public function __construct()
  {
    parent::__construct();

    if (!$this->session->userdata('driver_id')) {
      redirect('driver/driver_auth/login');
    }

    $this->load->model('Cargo_model', 'cargo');
    $this->load->model('Notification_model', 'nm');

    $this->driver_id = (int)$this->session->userdata('driver_id');
  }

  /* ================================
     JOBS DASHBOARD (3 TABS)
     ================================ */
  public function index()
  {
    $data['my_jobs']        = $this->cargo->driver_jobs($this->driver_id);            // assigned
    $data['requested_jobs'] = $this->cargo->driver_requested_jobs($this->driver_id); // requested
    $data['all_jobs']       = $this->cargo->all_open_jobs($this->driver_id);          // all

    $this->load->view('driver/jobs_list', $data);
  }

  /* ================================
     DRIVER REQUESTS A JOB
     ================================ */
  public function request_job($booking_id)
  {
    $booking_id = (int)$booking_id;

    // booking must exist
    $b = $this->cargo->get_booking($booking_id);
    if (!$b) {
      show_404();
    }

    // already assigned? stop
    $assigned = $this->db->get_where('cargo_assignments', [
      'booking_id' => $booking_id
    ])->row();

    if ($assigned) {
      $this->session->set_flashdata('err', 'Job already assigned.');
      redirect('driver/driver_jobs');
    }

    // already requested?
    $exists = $this->db->get_where('driver_job_requests', [
      'booking_id' => $booking_id,
      'driver_id' => $this->driver_id
    ])->row();

    if ($exists) {
      $this->session->set_flashdata('err', 'You have already requested this job.');
      redirect('driver/driver_jobs');
    }

    // insert request
    $this->db->insert('driver_job_requests', [
      'booking_id'   => $booking_id,
      'driver_id'    => $this->driver_id,
      'status'       => 'requested',
      'requested_at' => date('Y-m-d H:i:s')
    ]);

    // notify admin(s)
    $admins = $this->db->where('role', 'admin')->where('is_deleted', 0)->get('users')->result();
    foreach ($admins as $a) {
      $this->nm->create([
        'sender_role' => 'customer',
        'sender_id' => $this->driver_id,
        'receiver_role' => 'admin',
        'receiver_id' => NULL,
        'title' => 'New Job Requested',
        'message' => 'Driver requested a new job. Booking ID: ' . $booking_id,
        'ref_type' => 'cargo',
        'ref_id' => $booking_id,
        'severity' => 'info',
        'url' => site_url('admin/bookings')
      ]);
    }
    $this->session->set_flashdata('ok', 'Job request sent to admin.');
    redirect('driver/driver_jobs');
  }

  /* ================================
     VIEW ASSIGNED JOB
     ================================ */
  public function view($booking_id)
  {
    $booking_id = (int)$booking_id;

    $b = $this->cargo->get_booking($booking_id);
    if (!$b) {
      show_404();
    }

    // ensure assigned to this driver
    $a = $this->db->get_where('cargo_assignments', [
      'booking_id' => $booking_id,
      'driver_id' => $this->driver_id
    ])->row_array();

    if (!$a) {
      show_404();
    }

    /* STATUS UPDATE */
    if ($this->input->post('set_status')) {
      $status = $this->input->post('status', true);
      $note   = trim($this->input->post('note', true));

      $allowed = ['accepted', 'rejected', 'picked_up', 'in_transit', 'delivered', 'mishap'];
      if (!in_array($status, $allowed)) {
        $this->session->set_flashdata('err', 'Invalid status.');
        redirect('driver/driver_jobs/view/' . $booking_id);
      }

      $this->cargo->update_status($booking_id, $status, $note);

      // notify customer
      $this->noti->add(
        $b['customer_id'],
        'Cargo Update',
        'Your cargo status: ' . $status,
        'booking',
        $booking_id
      );

      // notify admin
      if (!empty($a['admin_id'])) {
        $this->noti->add(
          (int)$a['admin_id'],
          'Cargo Update',
          'Driver updated status: ' . $status,
          'booking',
          $booking_id
        );
      }

      $this->session->set_flashdata('ok', 'Status updated.');
      redirect('driver/driver_jobs/view/' . $booking_id);
    }

    $data['booking'] = $b;
    $data['logs']    = $this->cargo->status_logs($booking_id);

    $this->load->view('driver/job_view', $data);
  }
}
