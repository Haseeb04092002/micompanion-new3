<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Chat_model extends CI_Model {

  /* =========================================
     THREAD MANAGEMENT
     ========================================= */

  // Ensure thread between admin and other user (customer / driver)
  public function ensure_thread($admin_id, $other_user_id)
  {
    $admin_id      = (int)$admin_id;
    $other_user_id = (int)$other_user_id;

    $row = $this->db
      ->where('admin_id', $admin_id)
      ->where('other_user_id', $other_user_id)
      ->get('chat_threads')
      ->row_array();

    if ($row) {
      return (int)$row['thread_id'];
    }

    $this->db->insert('chat_threads', [
      'admin_id'      => $admin_id,
      'other_user_id' => $other_user_id,
      'created_at'    => date('Y-m-d H:i:s')
    ]);

    return $this->db->insert_id();
  }

  /* =========================================
     ADMIN THREAD LISTING
     ========================================= */

  public function list_customer_threads_for_admin($admin_id)
  {
    return $this->db
      ->select('t.thread_id, u.user_id, u.name, u.status')
      ->from('chat_threads t')
      ->join('users u', 'u.user_id = t.other_user_id')
      ->where('t.admin_id', (int)$admin_id)
      ->where('u.role', 'customer')
      ->order_by('t.thread_id', 'DESC')
      ->get()
      ->result_array();
  }

  public function list_driver_threads_for_admin($admin_id)
  {
    return $this->db
      ->select('t.thread_id, u.user_id, u.name, u.status')
      ->from('chat_threads t')
      ->join('users u', 'u.user_id = t.other_user_id')
      ->where('t.admin_id', (int)$admin_id)
      ->where('u.role', 'driver')
      ->order_by('t.thread_id', 'DESC')
      ->get()
      ->result_array();
  }

  /* =========================================
     MESSAGE LISTING
     ========================================= */

  public function get_messages_admin($type, $admin_id, $other_user_id)
  {
    $thread_id = $this->ensure_thread($admin_id, $other_user_id);

    return $this->db
      ->select('m.*, u.name AS sender_name')
      ->from('chat_messages m')
      ->join('users u', 'u.user_id = m.sender_id')
      ->where('m.thread_id', (int)$thread_id)
      ->order_by('m.msg_id', 'ASC')
      ->get()
      ->result_array();
  }

  public function get_messages_for_other($other_user_id)
  {
    return $this->db
      ->select('m.*, u.name AS sender_name')
      ->from('chat_messages m')
      ->join('chat_threads t', 't.thread_id = m.thread_id')
      ->join('users u', 'u.user_id = m.sender_id')
      ->where('t.other_user_id', (int)$other_user_id)
      ->order_by('m.msg_id', 'ASC')
      ->get()
      ->result_array();
  }

  /* =========================================
     SEND MESSAGES
     ========================================= */

  public function send_admin_message($type, $admin_id, $other_user_id, $message)
  {
    $thread_id = $this->ensure_thread($admin_id, $other_user_id);

    $this->db->insert('chat_messages', [
      'thread_id' => (int)$thread_id,
      'sender_id' => (int)$admin_id,
      'message'   => $message,
      'created_at'=> date('Y-m-d H:i:s')
    ]);

    return $this->db->insert_id();
  }

  public function send_other_message($admin_id, $other_user_id, $message)
  {
    $thread_id = $this->ensure_thread($admin_id, $other_user_id);

    $this->db->insert('chat_messages', [
      'thread_id' => (int)$thread_id,
      'sender_id' => (int)$other_user_id,
      'message'   => $message,
      'created_at'=> date('Y-m-d H:i:s')
    ]);

    return $this->db->insert_id();
  }

  /* =========================================
     COMMON UTILITIES
     ========================================= */

  public function get_user_name($user_id)
  {
    return $this->db
      ->select('name')
      ->where('user_id', (int)$user_id)
      ->get('users')
      ->row('name');
  }
}
