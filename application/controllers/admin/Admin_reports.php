<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Admin_reports extends CI_Controller {

  public function __construct(){
    parent::__construct();
    if(!$this->session->userdata('admin_id')) redirect('admin/admin_auth/login');
    $this->load->model('Report_model','rep');
    $this->load->model('Expense_model','exp');
  }

  public function index(){
    $from = $this->input->get('from', true);
    $to   = $this->input->get('to', true);

    $data['cargo'] = $this->rep->cargo_counts_by_status($from,$to);
    $data['drivers'] = $this->rep->drivers_summary();
    $data['customers'] = $this->rep->customers_summary();
    $data['expense_total'] = $this->exp->total(['from'=>$from,'to'=>$to]);
    $this->load->view('admin/reports', $data);
  }
}
