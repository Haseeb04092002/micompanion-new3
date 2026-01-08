<?php defined('BASEPATH') OR exit('No direct script access allowed');

class User_model extends CI_Model {

  public function exists_email($email) {
    return $this->db->get_where('users', ['email'=>$email, 'is_deleted'=>0])->num_rows() > 0;
  }

  public function get_by_role($role) {
    $this->db->order_by('user_id','DESC');
    return $this->db->get_where('users', ['role'=>$role, 'is_deleted'=>0])->result_array();
  }

  public function suspend($user_id) {
    $this->db->where('user_id', (int)$user_id)->update('users', ['status'=>'suspended']);
    return $this->db->affected_rows() > 0;
  }

  public function update_basic($user_id, $data) {
    $this->db->where('user_id', (int)$user_id)->update('users', $data);
    return $this->db->affected_rows() >= 0;
  }
  public function get_admin_id()
  {
    $row = $this->db->select('user_id')
      ->where('role','admin')
      ->limit(1)
      ->get('users')
      ->row_array();

    return $row ? (int)$row['id'] : 1;
  }

}
