<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Driver_model extends CI_Model {

  public function upsert_profile($user_id, $data) {
    $exists = $this->db->get_where('driver_profiles', ['user_id'=>(int)$user_id])->num_rows();
    if ($exists) {
      $this->db->where('user_id', (int)$user_id)->update('driver_profiles', $data);
    } else {
      $data['user_id'] = (int)$user_id;
      $this->db->insert('driver_profiles', $data);
    }
    return true;
  }

  public function get_profile($user_id) {
    return $this->db->get_where('driver_profiles', ['user_id'=>(int)$user_id])->row_array();
  }

  public function list_drivers_with_profile() {
    $sql = "SELECT u.*, dp.license_no, dp.cnic_no, dp.phone, dp.address,
                   dp.profile_pic, dp.license_img, dp.cnic_img
            FROM users u
            LEFT JOIN driver_profiles dp ON dp.user_id = u.user_id
            WHERE u.role='driver' AND u.is_deleted=0
            ORDER BY u.user_id DESC";
    return $this->db->query($sql)->result_array();
  }
}
