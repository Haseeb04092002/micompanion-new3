<?php defined('BASEPATH') or exit('No direct script access allowed');

class Cargo_model extends CI_Model
{

  public function create_booking($data)
  {
    $this->db->insert('cargo_bookings', $data);
    $id = $this->db->insert_id();

    // status log
    $this->db->insert('cargo_status_logs', [
      'booking_id' => $id,
      'status' => 'requested',
      'note' => 'Booking created',
      'created_at' => date('Y-m-d H:i:s')
    ]);

    return $id;
  }

  public function get_full_by_id($booking_id)
  {
    return $this->db
      ->select('b.*,
              c.name AS customer_name, c.phone AS customer_phone,
              d.name AS driver_name, d.phone AS driver_phone,
              v.name AS vehicle_name')
      ->from('cargo_bookings b')
      ->join('customer_profiles c', 'c.customer_id=b.customer_id')
      ->join('driver_profiles d', 'd.driver_id=b.driver_id', 'left')
      ->join('driver_vehicles v', 'v.vehicle_id=b.vehicle_id', 'left')
      ->where('b.booking_id', (int)$booking_id)
      ->get()
      ->row_array();
  }


  public function get_by_id_and_customer($booking_id, $customer_id)
  {
    $booking_id  = (int)$booking_id;
    $customer_id = (int)$customer_id;

    return $this->db
      ->where('booking_id', $booking_id)
      ->where('customer_id', $customer_id)
      ->get('cargo_bookings')
      ->row_array();
  }


  public function list_by_customer($customer_id)
  {
    $this->db->order_by('booking_id', 'DESC');
    return $this->db->get_where('cargo_bookings', ['customer_id' => (int)$customer_id])->result_array();
  }

  public function list_all_admin($filters = [])
  {
    $where = "1=1";
    if (!empty($filters['status'])) {
      $where .= " AND b.status=" . $this->db->escape($filters['status']);
    }
    if (!empty($filters['city_from'])) {
      $where .= " AND b.city_from=" . $this->db->escape($filters['city_from']);
    }
    if (!empty($filters['city_to'])) {
      $where .= " AND b.city_to=" . $this->db->escape($filters['city_to']);
    }

    $sql = "SELECT b.*,
                   cu.name AS customer_name,
                   au.driver_id, du.name AS driver_name,
                   au.vehicle_id
            FROM cargo_bookings b
            JOIN users cu ON cu.user_id=b.customer_id
            LEFT JOIN cargo_assignments au ON au.booking_id=b.booking_id
            LEFT JOIN users du ON du.user_id=au.driver_id
            WHERE $where
            ORDER BY b.booking_id DESC";
    return $this->db->query($sql)->result_array();
  }

  public function get_booking($booking_id)
  {
    return $this->db->get_where('cargo_bookings', ['booking_id' => (int)$booking_id])->row_array();
  }

  public function assign_driver($booking_id, $driver_id, $vehicle_id, $admin_id)
  {
    // Upsert assignment
    $exists = $this->db->get_where('cargo_assignments', ['booking_id' => (int)$booking_id])->num_rows();
    $data = [
      'booking_id' => (int)$booking_id,
      'driver_id' => (int)$driver_id,
      'vehicle_id' => (int)$vehicle_id,
      'admin_id' => (int)$admin_id,
      'assigned_at' => date('Y-m-d H:i:s')
    ];

    if ($exists) $this->db->where('booking_id', (int)$booking_id)->update('cargo_assignments', $data);
    else $this->db->insert('cargo_assignments', $data);

    // booking status -> assigned
    $this->db->where('booking_id', (int)$booking_id)->update('cargo_bookings', ['status' => 'assigned']);

    $this->db->insert('cargo_status_logs', [
      'booking_id' => (int)$booking_id,
      'status' => 'assigned',
      'note' => 'Admin assigned driver',
      'created_at' => date('Y-m-d H:i:s')
    ]);

    return true;
  }

  public function driver_jobs($driver_id)
  {
    $sql = "SELECT b.*, a.vehicle_id, a.assigned_at
            FROM cargo_assignments a
            JOIN cargo_bookings b ON b.booking_id = a.booking_id
            WHERE a.driver_id=" . (int)$driver_id . "
            ORDER BY b.booking_id DESC";
    return $this->db->query($sql)->result_array();
  }

  public function update_status($booking_id, $status, $note = '')
  {
    $this->db->where('booking_id', (int)$booking_id)->update('cargo_bookings', ['status' => $status]);
    $this->db->insert('cargo_status_logs', [
      'booking_id' => (int)$booking_id,
      'status' => $status,
      'note' => $note,
      'created_at' => date('Y-m-d H:i:s')
    ]);
    return true;
  }

  public function status_logs($booking_id)
  {
    $this->db->order_by('log_id', 'ASC');
    return $this->db->get_where('cargo_status_logs', ['booking_id' => (int)$booking_id])->result_array();
  }
}
