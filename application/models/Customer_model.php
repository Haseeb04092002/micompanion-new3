<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Customer_model extends CI_Model {

  public function upsert_profile($user_id, $data) {
    $exists = $this->db->get_where('customer_profiles', ['user_id'=>(int)$user_id])->num_rows();
    if ($exists) {
      $this->db->where('user_id', (int)$user_id)->update('customer_profiles', $data);
    } else {
      $data['user_id'] = (int)$user_id;
      $this->db->insert('customer_profiles', $data);
    }
    return true;
  }

  public function get_profile($user_id) {
    return $this->db->get_where('customer_profiles', ['user_id'=>(int)$user_id])->row_array();
  }

  public function list_customers_with_profile() {
    $sql = "SELECT u.*, cp.cnic_no, cp.phone, cp.address, cp.profile_pic, cp.cnic_img
            FROM users u
            LEFT JOIN customer_profiles cp ON cp.user_id = u.user_id
            WHERE u.role='customer' AND u.is_deleted=0
            ORDER BY u.user_id DESC";
    return $this->db->query($sql)->result_array();
  }
}
