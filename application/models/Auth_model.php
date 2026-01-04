<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Auth_model extends CI_Model {

  public function login($role, $email, $password) {
    $q = $this->db->get_where('users', [
      'role' => $role,
      'email' => $email,
      'password' => $password, // NO HASH (as per instruction)
      'is_deleted' => 0
    ]);
    return $q->row_array();
  }

  public function create_user($data) {
    $this->db->insert('users', $data);
    return $this->db->insert_id();
  }

  public function get_user($user_id) {
    return $this->db->get_where('users', ['user_id' => (int)$user_id, 'is_deleted'=>0])->row_array();
  }

  public function set_status($user_id, $status) {
    $this->db->where('user_id', (int)$user_id)->update('users', ['status' => $status]);
    return $this->db->affected_rows() > 0;
  }
}
