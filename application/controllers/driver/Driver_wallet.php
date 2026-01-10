<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Driver_chat extends MY_Controller {

  public function __construct(){
    parent::__construct();
    $this->load->model('Chat_model','chat');
    $this->load->model('User_model','user');
  }

    public function index()
    {
    $driver_id = (int)$this->session->userdata('driver_id');

    $data['records'] = $this->db
        ->where('driver_id',$driver_id)
        ->where('driver_payment_status','paid')
        ->get('cargo_assignments')
        ->result_array();

    $this->load->view('driver/earnings',$data);
    }

}
