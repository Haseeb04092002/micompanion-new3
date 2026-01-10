<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Payments extends CI_Controller {

  public function easypaisa_callback()
  {
    // ---- Raw inputs from EasyPaisa ----
    $order_id = trim($this->input->post('orderId'));
    $status   = trim($this->input->post('status'));        // success | failed
    $txn_ref  = trim($this->input->post('transactionId'));

    if ($order_id === '') {
      log_message('error', 'EasyPaisa callback: empty orderId');
      return;
    }

    if ($status !== 'success') {
      log_message('error', 'EasyPaisa failed: '.$order_id);
      return;
    }

    /*
    |--------------------------------------------------------------------------
    | CUSTOMER → ADMIN PAYMENT
    | Order ID format: CARGO_{booking_id}_{timestamp}
    |--------------------------------------------------------------------------
    */
    if (preg_match('/^CARGO_(\d+)_/', $order_id, $m)) {

      $booking_id = (int)$m[1];

      // prevent double update
      $cargo = $this->db
        ->where('booking_id', $booking_id)
        ->where('payment_status !=', 'paid')
        ->get('cargo_bookings')
        ->row_array();

      if (!$cargo) {
        log_message('error', 'EasyPaisa cargo not found or already paid: '.$order_id);
        return;
      }

      // mark customer payment as PAID
      $this->db->where('booking_id', $booking_id)->update('cargo_bookings', [
        'payment_status' => 'paid',
        'payment_method' => 'easypaisa',
        'payment_ref'    => $txn_ref,
        'paid_at'        => date('Y-m-d H:i:s')
      ]);

      // notify admin (you can replace 1 with dynamic admin id if needed)
      $this->db->insert('notifications', [
        'user_id'    => 1,
        'title'      => 'Payment Received',
        'body'       => 'Cargo #'.$booking_id.' paid via EasyPaisa',
        'ref_type'   => 'cargo',
        'ref_id'     => $booking_id,
        'is_read'    => 0,
        'created_at' => date('Y-m-d H:i:s')
      ]);

      return;
    }

    /*
    |--------------------------------------------------------------------------
    | ADMIN → DRIVER COMMISSION PAYMENT
    | Order ID format: DRIVER_{booking_id}_{timestamp}
    |--------------------------------------------------------------------------
    */
    if (preg_match('/^DRIVER_(\d+)_/', $order_id, $m)) {

      $booking_id = (int)$m[1];

      // get assignment
      $assignment = $this->db
        ->where('booking_id', $booking_id)
        ->where('driver_payment_status !=', 'paid')
        ->get('cargo_assignments')
        ->row_array();

      if (!$assignment) {
        log_message('error', 'EasyPaisa driver payment invalid: '.$order_id);
        return;
      }

      // mark driver commission as PAID
      $this->db->where('booking_id', $booking_id)->update('cargo_assignments', [
        'driver_payment_status' => 'paid',
        'driver_payment_method' => 'easypaisa',
        'driver_payment_ref'    => $txn_ref,
        'driver_paid_at'        => date('Y-m-d H:i:s')
      ]);

      // notify driver
      $this->db->insert('notifications', [
        'user_id'    => $assignment['driver_id'],
        'title'      => 'Commission Paid',
        'body'       => 'Your commission for booking #'.$booking_id.' has been paid via EasyPaisa',
        'ref_type'   => 'driver_payment',
        'ref_id'     => $booking_id,
        'is_read'    => 0,
        'created_at' => date('Y-m-d H:i:s')
      ]);

      return;
    }

    /*
    |--------------------------------------------------------------------------
    | UNKNOWN ORDER FORMAT
    |--------------------------------------------------------------------------
    */
    log_message('error', 'EasyPaisa callback: unknown orderId '.$order_id);
  }
}


