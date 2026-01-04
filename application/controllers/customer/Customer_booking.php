<?php defined('BASEPATH') or exit('No direct script access allowed');

class Customer_booking extends CI_Controller
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
    $b = $this->cargo->get_booking($booking_id);
    if (!$b || (int)$b['customer_id'] !== $cid) show_404();

    $data['booking'] = $b;
    $data['logs'] = $this->cargo->status_logs($booking_id);
    $this->load->view('customer/booking_view', $data);
  }
}
