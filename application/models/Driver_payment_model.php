<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Driver_payment_model extends CI_Model {

  /* ===========================
     ADMIN: PAID BOOKINGS LIST
     =========================== */
  public function get_paid_bookings_with_driver()
  {
    return $this->db->select("
        b.booking_id,
        b.city_from, b.city_to, b.cargo_category, b.units, b.vehicle_type,
        a.driver_id, a.driver_commission, a.driver_payment_status,
        u.name AS driver_name,
        dp.phone, dp.cnic_no
      ")
      ->from('cargo_bookings b')
      ->join('cargo_assignments a','a.booking_id=b.booking_id')
      ->join('users u','u.user_id=a.driver_id')
      ->join('driver_profiles dp','dp.user_id=a.driver_id','left')
      ->where('b.payment_status','paid')
      ->order_by('b.booking_id','DESC')
      ->get()
      ->result_array();
  }

  /* ===========================
     GET ASSIGNMENT
     =========================== */
  public function get_assignment($booking_id)
  {
    return $this->db
      ->where('booking_id',(int)$booking_id)
      ->get('cargo_assignments')
      ->row_array();
  }

  /* ===========================
     PAY DRIVER
     =========================== */
  public function mark_driver_paid($booking_id, $data)
  {
    $this->db->where('booking_id',(int)$booking_id)
             ->update('cargo_assignments',$data);
  }
}
