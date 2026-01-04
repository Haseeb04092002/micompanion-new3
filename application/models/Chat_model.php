<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Chat_model extends CI_Model {

  // Only Admin<->Driver OR Admin<->Customer
  public function ensure_thread($admin_id, $other_id) {
    $sql = "SELECT * FROM chat_threads
            WHERE admin_id=".(int)$admin_id." AND other_user_id=".(int)$other_id." LIMIT 1";
    $row = $this->db->query($sql)->row_array();
    if ($row) return (int)$row['thread_id'];

    $this->db->insert('chat_threads', [
      'admin_id'=>(int)$admin_id,
      'other_user_id'=>(int)$other_id,
      'created_at'=>date('Y-m-d H:i:s')
    ]);
    return $this->db->insert_id();
  }

  public function list_threads_for_admin($admin_id) {
    $sql = "SELECT t.*, u.name, u.role, u.status
            FROM chat_threads t
            JOIN users u ON u.user_id=t.other_user_id
            WHERE t.admin_id=".(int)$admin_id."
            ORDER BY t.thread_id DESC";
    return $this->db->query($sql)->result_array();
  }

  public function list_threads_for_other($user_id) {
    $sql = "SELECT t.*, a.name AS admin_name
            FROM chat_threads t
            JOIN users a ON a.user_id=t.admin_id
            WHERE t.other_user_id=".(int)$user_id."
            ORDER BY t.thread_id DESC";
    return $this->db->query($sql)->result_array();
  }

  public function messages($thread_id) {
    $sql = "SELECT m.*, u.name AS sender_name
            FROM chat_messages m
            JOIN users u ON u.user_id=m.sender_id
            WHERE m.thread_id=".(int)$thread_id."
            ORDER BY m.msg_id ASC";
    return $this->db->query($sql)->result_array();
  }

  public function send($thread_id, $sender_id, $message) {
    $this->db->insert('chat_messages', [
      'thread_id'=>(int)$thread_id,
      'sender_id'=>(int)$sender_id,
      'message'=>$message,
      'created_at'=>date('Y-m-d H:i:s')
    ]);
    return $this->db->insert_id();
  }
}
