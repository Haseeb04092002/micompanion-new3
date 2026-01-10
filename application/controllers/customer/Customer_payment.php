<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Customer_payment extends MY_Controller {

  public function pay($booking_id)
  {
    $this->load->model('Easypaisa_model','ep');

    $cargo = $this->db
      ->where('booking_id',$booking_id)
      ->where('payment_status','pending')
      ->get('cargo_bookings')
      ->row_array();

    if (!$cargo) show_error('Invalid payment');

    $order_id = 'CARGO_'.$booking_id.'_'.time();

    // save order ref
    $this->db->where('booking_id',$booking_id)->update('cargo_bookings',[
      'payment_ref' => $order_id
    ]);

    $data = $this->ep->create_request($order_id, $cargo['payment_amount']);

    $this->load->view('payments/easypaisa_redirect', $data);
  }
}

