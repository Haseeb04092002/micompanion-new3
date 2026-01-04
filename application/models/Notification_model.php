<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Notification_model extends CI_Model {

  public function add($user_id, $title, $body, $ref_type='', $ref_id=0) {
    $this->db->insert('notifications', [
      'user_id'=>(int)$user_id,
      'title'=>$title,
      'body'=>$body,
      'ref_type'=>$ref_type,
      'ref_id'=>(int)$ref_id,
      'is_read'=>0,
      'created_at'=>date('Y-m-d H:i:s')
    ]);
    return $this->db->insert_id();
  }

  public function list_for_user($user_id) {
    $this->db->order_by('noti_id','DESC');
    return $this->db->get_where('notifications', ['user_id'=>(int)$user_id])->result_array();
  }

  public function mark_read($noti_id, $user_id) {
    $this->db->where(['noti_id'=>(int)$noti_id,'user_id'=>(int)$user_id])->update('notifications',['is_read'=>1]);
    return true;
  }
}
