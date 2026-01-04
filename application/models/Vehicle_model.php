<?php defined('BASEPATH') or exit('No direct script access allowed');

class Vehicle_model extends CI_Model
{

  public function add_vehicle($data)
  {
    $this->db->insert('driver_vehicles', $data);
    return $this->db->insert_id();
  }

  public function get_by_id_and_driver($vehicle_id, $driver_id)
  {
    $vehicle_id = (int)$vehicle_id;
    $driver_id  = (int)$driver_id;

    return $this->db
      ->where('vehicle_id', $vehicle_id)
      ->where('driver_id', $driver_id)
      ->get('vehicles')
      ->row_array();
  }


  public function list_by_driver($driver_id)
  {
    $this->db->order_by('vehicle_id', 'DESC');
    return $this->db->get_where('driver_vehicles', ['driver_id' => (int)$driver_id, 'is_deleted' => 0])->result_array();
  }

  public function list_all()
  {
    $sql = "SELECT v.*, u.name AS driver_name, u.status AS driver_status
            FROM driver_vehicles v
            JOIN users u ON u.user_id = v.driver_id
            WHERE v.is_deleted=0
            ORDER BY v.vehicle_id DESC";
    return $this->db->query($sql)->result_array();
  }

  public function set_approval($vehicle_id, $status)
  {
    $this->db->where('vehicle_id', (int)$vehicle_id)->update('driver_vehicles', ['status' => $status]);
    return $this->db->affected_rows() > 0;
  }

  public function approved_vehicles_for_customer_selection()
  {
    $sql = "SELECT v.*, u.name AS driver_name
            FROM driver_vehicles v
            JOIN users u ON u.user_id = v.driver_id
            WHERE v.status='approved'
              AND v.is_deleted=0
              AND u.status='approved'
              AND u.role='driver'
              AND u.is_deleted=0
            ORDER BY v.vehicle_id DESC";
    return $this->db->query($sql)->result_array();
  }
}
