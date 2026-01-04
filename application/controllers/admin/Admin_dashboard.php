<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Admin_dashboard extends CI_Controller {

  public function __construct(){
    parent::__construct();
    if(!$this->session->userdata('admin_id')) redirect('admin/admin_auth/login');
    $this->load->model('Report_model','rep');
  }

  public function index(){
    $data['cargo'] = $this->rep->cargo_counts_by_status();
    $data['drivers'] = $this->rep->drivers_summary();
    $data['customers'] = $this->rep->customers_summary();
    $this->load->view('admin/dashboard', $data);
  }
}
