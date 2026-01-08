<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Admin_reports extends MY_Controller {

  public function __construct(){
    parent::__construct();

    if(!$this->session->userdata('admin_id')){
      redirect('admin/admin_auth/login');
    }

    $this->load->model('Report_model','rep');
    $this->load->model('Expense_model','exp');
  }

  public function index(){

    $from = $this->input->get('from', true);
    $to   = $this->input->get('to', true);

    /* =========================
       RAW REPORT DATA
       ========================= */
    $cargo     = $this->rep->cargo_counts_by_status($from, $to);
    $drivers   = $this->rep->drivers_summary();
    $customers = $this->rep->customers_summary();
    $expense   = $this->exp->total(['from'=>$from,'to'=>$to]);

    /* =========================
       BUILD SUMMARY FOR VIEW
       ========================= */
    $summary = [
      'total_bookings' => (int)($cargo['total'] ?? 0),
      'completed'      => (int)($cargo['delivered'] ?? 0),
      'active_drivers' => (int)($drivers['active'] ?? 0),
      'customers'      => (int)($customers['total'] ?? 0),
      'expense_total'  => (float)($expense ?? 0)
    ];

    /* =========================
       SEND DATA TO VIEW
       ========================= */
    $data = [
      'summary'   => $summary,

      // keep full datasets for future detailed reports
      'cargo'     => $cargo,
      'drivers'   => $drivers,
      'customers' => $customers
    ];

    $this->load->view('admin/reports', $data);
  }
}
