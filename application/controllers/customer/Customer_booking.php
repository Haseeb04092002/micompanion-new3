<?php defined('BASEPATH') or exit('No direct script access allowed');

class Customer_booking extends MY_Controller
{

  public function __construct()
  {
    parent::__construct();
    if (!$this->session->userdata('customer_id')) redirect('customer/customer_auth/login');
    $this->load->model('Auth_model', 'auth');
    $this->load->model('Vehicle_model', 'veh');
    $this->load->model('Cargo_model', 'cargo');
    $this->load->model('Notification_model', 'noti');
  }

  public function pay_cargo($booking_id = '')
  {
      // 🔐 customer must be logged in
      $customer_id = (int)$this->session->userdata('customer_id');
      if (!$customer_id) {
          show_error('Unauthorized access');
      }

      $booking_id = (int)$booking_id;
      if (!$booking_id) {
          show_error('Invalid cargo');
      }

      // 🔍 fetch cargo
      $cargo = $this->db
          ->where('booking_id', $booking_id)
          ->where('customer_id', $customer_id)
          ->get('cargo_bookings')
          ->row_array();

      if (!$cargo) {
          show_error('Cargo not found');
      }

      // 🚫 only delivered & unpaid cargos
      if ($cargo['status'] !== 'delivered' || $cargo['payment_status'] === 'paid') {
          show_error('Payment not allowed');
      }

      // 🔍 find admin (from assignment)
      $assignment = $this->db
          ->where('booking_id', $booking_id)
          ->get('cargo_assignments')
          ->row_array();

      if (!$assignment) {
          show_error('Admin not found');
      }

      $admin_id = (int)$assignment['admin_id'];

      // 🧾 payment method
      $method = $this->input->post('payment_method');

      // =========================
      // EASYPaisa PAYMENT
      // =========================
      if ($method === 'easypaisa') {

          $ep_number = trim($this->input->post('ep_number'));
          $ep_txn    = trim($this->input->post('ep_txn'));

          if ($ep_number === '' || $ep_txn === '') {
              show_error('Easypaisa details required');
          }

          $this->db->where('booking_id', $booking_id)->update('cargo_bookings', [
              'payment_method' => 'easypaisa',
              'payment_ref'    => $ep_txn,
              'payment_status' => 'paid',
              'paid_at'        => date('Y-m-d H:i:s')
          ]);
      }

      // =========================
      // MANUAL PAYMENT
      // =========================
      elseif ($method === 'manual') {

          if (empty($_FILES['proof']['name'])) {
              show_error('Payment proof required');
          }

          $dir = FCPATH . 'uploads/payments/';
          if (!is_dir($dir)) {
              mkdir($dir, 0777, true);
          }

          $ext = pathinfo($_FILES['proof']['name'], PATHINFO_EXTENSION);
          $img = 'pay_'.$booking_id.'_'.time().'.'.$ext;

          if (!move_uploaded_file($_FILES['proof']['tmp_name'], $dir.$img)) {
              show_error('Upload failed');
          }

          $this->db->where('booking_id', $booking_id)->update('cargo_bookings', [
              'payment_method' => 'manual',
              'payment_proof'  => $img,
              'payment_status' => 'paid',
              'paid_at'        => date('Y-m-d H:i:s')
          ]);
      }

      else {
          show_error('Invalid payment method');
      }

      // 🔔 notify admin
      $this->db->insert('notifications', [
          'user_id'    => $admin_id,
          'title'      => 'Payment Received',
          'body'       => 'Payment submitted for Cargo #'.$booking_id,
          'ref_type'   => 'cargo',
          'ref_id'     => $booking_id,
          'is_read'    => 0,
          'created_at' => date('Y-m-d H:i:s')
      ]);

      // ✅ success
      $this->session->set_flashdata('success', 'Payment submitted successfully');
      redirect('customer/bookings');
  }


  public function create()
  {

    $cid = (int)$this->session->userdata('customer_id');
    $u = $this->auth->get_user($cid);

    if (!$u || $u['status'] != 'approved') {
      $this->session->set_flashdata('err', 'Only approved customers can create bookings.');
      redirect('customer/customer_dashboard');
    }

    // echo "here";
    //   die();

    $data['err'] = '';
    $data['vehicles'] = $this->veh->approved_vehicles_for_customer_selection();
    if (empty($data['vehicles'])) {
      $this->session->set_flashdata('err', 'No vehicles available right now. Please try later.');
      redirect('customer/customer_dashboard');
    }


    if ($this->input->post('save')) {

      $city_from = trim($this->input->post('city_from', true));
      $city_to   = trim($this->input->post('city_to', true));
      $loc_from  = trim($this->input->post('loc_from', true));
      $loc_to    = trim($this->input->post('loc_to', true));
      $units     = (int)$this->input->post('units');
      $cargo_cat = trim($this->input->post('cargo_category', true));
      $veh_type  = trim($this->input->post('vehicle_type', true));

      if ($city_from == '' || $city_to == '' || $loc_from == '' || $loc_to == '' || $units <= 0 || $cargo_cat == '' || $veh_type == '') {
        $data['err'] = 'Please fill all required fields.';
      } else {
        // create booking
        $booking_id = $this->cargo->create_booking([
          'customer_id' => $cid,
          'city_from' => $city_from,
          'city_to' => $city_to,
          'loc_from' => $loc_from,
          'loc_to' => $loc_to,
          'units' => $units,
          'cargo_category' => $cargo_cat,
          'vehicle_type' => $veh_type,
          'status' => 'requested',
          'bilty_code' => 'BLT-' . date('ymd') . '-' . rand(1000, 9999),
          'created_at' => date('Y-m-d H:i:s')
        ]);

        // notify admin (assume admin_id=1 for first admin; you can change later)
        $this->noti->add(1, 'New Booking', 'A new cargo booking is created.', 'booking', $booking_id);

        $this->session->set_flashdata('ok', 'Booking created. Bilty generated (code) and sent to admin.');
        redirect('customer/customer_booking/listing');
      }
    }

    $this->load->view('customer/booking_form', $data);
  }

  public function listing()
  {
    $cid = (int)$this->session->userdata('customer_id');
    $data['rows'] = $this->cargo->list_by_customer($cid);
    $this->load->view('customer/bookings_list', $data);
  }

  public function view($booking_id)
  {
    $cid = (int)$this->session->userdata('customer_id');

    $booking = $this->cargo->get_by_id_and_customer($booking_id, $cid);
    if(!$booking) show_404();

    $data['booking'] = $booking;
    $this->load->view('customer/booking_view', $data);
  }
}
