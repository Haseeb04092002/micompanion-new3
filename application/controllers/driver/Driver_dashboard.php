<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Driver_dashboard extends CI_Controller {

  public function __construct(){
    parent::__construct();
    if(!$this->session->userdata('driver_id')) redirect('driver/driver_auth/login');
    $this->load->model('Auth_model','auth');
    $this->load->model('Cargo_model','cargo');
  }

  public function index(){
    $driver_id = (int)$this->session->userdata('driver_id');
    $u = $this->auth->get_user($driver_id);

    $data['user'] = $u;
    $data['need_verify'] = ($u && $u['status']=='pending');
    $data['jobs'] = $this->cargo->driver_jobs($driver_id);

    $this->load->view('driver/dashboard', $data);
  }
}
