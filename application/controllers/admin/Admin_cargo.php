<?php defined('BASEPATH') or exit('No direct script access allowed');

class Admin_cargo extends MY_Controller
{

  public function __construct()
  {
    parent::__construct();
    if (!$this->session->userdata('admin_id')) redirect('admin/admin_auth/login');
    $this->load->model('Cargo_model', 'cargo');
    $this->load->model('Vehicle_model', 'veh');
    $this->load->model('Notification_model', 'noti');
  }

  public function set_payment($cargo_id)
  {
      if (!$this->session->userdata('admin_id')) exit('Access denied');

      $cargo = $this->db->where('cargo_id',$cargo_id)->get('cargos')->row_array();
      if (!$cargo || $cargo['status'] !== 'delivered') exit('Invalid');

      if ($_POST) {
          $amount = (float)$this->input->post('payment_amount');

          $this->db->where('cargo_id',$cargo_id)->update('cargos',[
              'payment_amount' => $amount,
              'payment_status' => 'pending'
          ]);

          // 🔔 notify customer
          $this->db->insert('notifications',[
              'user_id' => $cargo['customer_id'],
              'title' => 'Payment Required',
              'body' => 'Please pay Rs '.$amount.' for delivered cargo',
              'ref_type' => 'cargo_payment',
              'ref_id' => $cargo_id,
              'created_at' => date('Y-m-d H:i:s')
          ]);

          redirect('admin/cargos');
      }

      $this->load->view('admin/cargo_payment_set',['cargo'=>$cargo]);
  }


  public function view($booking_id)
  {
    $cargo = $this->cargo->get_full_by_id($booking_id);
    if (!$cargo) show_404();

    $data['cargo'] = $cargo;
    $this->load->view('admin/cargo_view', $data);
  }


  public function index()
  {
    $filters = [
      'status' => $this->input->get('status', true),
      'city_from' => $this->input->get('city_from', true),
      'city_to' => $this->input->get('city_to', true)
    ];
    $data['rows'] = $this->cargo->list_all_admin($filters);
    $this->load->view('admin/cargo_list', $data);
  }

  public function assign($booking_id)
  {
    $data['booking'] = $this->cargo->get_booking($booking_id);
    $data['vehicles'] = $this->veh->approved_vehicles_for_customer_selection();

    if ($this->input->post('do_assign')) {
      $driver_id  = (int)$this->input->post('driver_id');
      $vehicle_id = (int)$this->input->post('vehicle_id');

      if ($driver_id <= 0 || $vehicle_id <= 0) {
        $this->session->set_flashdata('err', 'Select driver and vehicle.');
        redirect('admin/admin_cargo/assign/' . $booking_id);
      }

      $admin_id = (int)$this->session->userdata('admin_id');
      $this->cargo->assign_driver($booking_id, $driver_id, $vehicle_id, $admin_id);

      // notifications
      $b = $this->cargo->get_booking($booking_id);
      if ($b) {
        $this->noti->add($driver_id, 'New Cargo Assigned', 'A cargo job is assigned to you. Please accept/reject.', 'booking', $booking_id);
        $this->noti->add($b['customer_id'], 'Driver Assigned', 'Admin assigned a driver to your booking.', 'booking', $booking_id);
      }

      $this->session->set_flashdata('ok', 'Assigned successfully.');
      redirect('admin/admin_cargo');
    }

    $this->load->view('admin/cargo_assign', $data);
  }
}
