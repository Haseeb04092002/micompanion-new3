<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Driver_payments extends MY_Controller {

  public function __construct()
  {
    parent::__construct();
    if (!$this->session->userdata('admin_id')) exit('Access denied');
    $this->load->model('Driver_payment_model','pay');
  }

  /* ===========================
     LIST
     =========================== */
  public function index()
  {
    $data['records'] = $this->pay->get_paid_bookings_with_driver();
    $this->load->view('admin/driver_payment_list',$data);
  }

  /* ===========================
     PAY DRIVER
     =========================== */
  public function pay($booking_id)
  {
    $booking_id = (int)$booking_id;
    $assignment = $this->pay->get_assignment($booking_id);

    if (!$assignment || $assignment['driver_payment_status']=='paid') {
      show_error('Invalid request');
    }

    if ($_POST) {

      $update = [
        'driver_commission' => (float)$this->input->post('driver_commission'),
        'driver_payment_status' => 'paid',
        'driver_paid_at' => date('Y-m-d H:i:s')
      ];

      if ($this->input->post('payment_method')=='easypaisa') {
        $update['driver_payment_method'] = 'easypaisa';
        $update['driver_payment_ref'] = $this->input->post('ep_txn');
      }

      if ($this->input->post('payment_method')=='manual') {
        $dir = FCPATH.'uploads/driver_payments/';
        if (!is_dir($dir)) mkdir($dir,0777,true);

        $img = 'driver_'.$booking_id.'_'.time().'.jpg';
        move_uploaded_file($_FILES['proof']['tmp_name'],$dir.$img);

        $update['driver_payment_method'] = 'manual';
        $update['driver_payment_proof'] = $img;
      }

      $this->pay->mark_driver_paid($booking_id,$update);

      // 🔔 notify driver
      $this->db->insert('notifications',[
        'user_id'=>$assignment['driver_id'],
        'title'=>'Commission Paid',
        'body'=>'Your commission for booking #'.$booking_id.' has been paid',
        'ref_type'=>'driver_payment',
        'ref_id'=>$booking_id,
        'is_read'=>0,
        'created_at'=>date('Y-m-d H:i:s')
      ]);

      redirect('admin/driver_payments');
    }

    $this->load->view('admin/driver_pay_form',['a'=>$assignment]);
  }
}
