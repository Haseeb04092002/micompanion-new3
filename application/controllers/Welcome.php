<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Welcome extends CI_Controller {

  public function index()
  {
    // Admin already logged in
    if ($this->session->userdata('admin_id')) {
      redirect('admin/admin_dashboard');
    }

    // Driver already logged in
    if ($this->session->userdata('driver_id')) {
      redirect('driver/driver_dashboard');
    }

    // Customer already logged in
    if ($this->session->userdata('customer_id')) {
      redirect('customer/customer_dashboard');
    }

    // No login → show role selection page
    $this->load->view('welcome');
  }
}
