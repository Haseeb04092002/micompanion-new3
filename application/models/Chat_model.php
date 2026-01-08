<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Chat_model extends CI_Model {

  /* =========================
     THREADS
     ========================= */

  public function ensure_thread($admin_id, $other_user_id)
  {
    $admin_id = (int)$admin_id;
    $other_user_id = (int)$other_user_id;

    $row = $this->db->where([
        'admin_id'      => $admin_id,
        'other_user_id' => $other_user_id
      ])->limit(1)->get('chat_threads')->row_array();

    if ($row) return (int)$row['thread_id'];

    // INSERT thread
    $this->db->insert('chat_threads', [
      'admin_id'      => $admin_id,
      'other_user_id' => $other_user_id,
      'created_at'    => date('Y-m-d H:i:s')
    ]);

    return (int)$this->db->insert_id();
  }

  public function get_admin_threads_with_users($admin_id, $type)
  {
    $admin_id = (int)$admin_id;

    if ($type === 'customer') {
      $this->db->join('customers c', 'c.customer_id = t.other_user_id');
      $this->db->select('t.thread_id, c.customer_id AS user_id, c.name, c.phone');
    } else {
      $this->db->join('drivers d', 'd.driver_id = t.other_user_id');
      $this->db->select('t.thread_id, d.driver_id AS user_id, d.name, d.phone');
    }

    $this->db->select('MAX(m.created_at) AS last_msg_at', false);
    $this->db->join('chat_messages m', 'm.thread_id = t.thread_id', 'left');
    $this->db->from('chat_threads t');
    $this->db->where('t.admin_id', $admin_id);
    $this->db->group_by('t.thread_id');
    $this->db->order_by('last_msg_at', 'DESC');

    return $this->db->get()->result_array();
  }


  public function get_thread_by_pair($admin_id, $other_user_id)
  {
    return $this->db->where([
        'admin_id'      => (int)$admin_id,
        'other_user_id' => (int)$other_user_id
      ])->limit(1)->get('chat_threads')->row_array();
  }

  public function get_admin_threads($admin_id)
  {
    return $this->db
      ->where('admin_id', (int)$admin_id)
      ->order_by('thread_id', 'DESC')
      ->get('chat_threads')
      ->result_array();
  }

  /* =========================
     MESSAGES
     ========================= */

  public function insert_message($thread_id, $sender_id, $message)
  {
    $thread_id = (int)$thread_id;
    $sender_id = (int)$sender_id;
    $message   = trim($message);

    if ($thread_id <= 0 || $sender_id <= 0 || $message === '') return 0;

    $this->db->insert('chat_messages', [
      'thread_id'   => $thread_id,
      'sender_id'   => $sender_id,
      'message'     => $message,
      'created_at'  => date('Y-m-d H:i:s')
    ]);

    return (int)$this->db->insert_id();
  }

  public function get_messages($thread_id, $viewer_id)
  {
    $thread_id = (int)$thread_id;
    $viewer_id = (int)$viewer_id;

    $rows = $this->db
      ->where('thread_id', $thread_id)
      ->order_by('msg_id', 'ASC')
      ->get('chat_messages')
      ->result_array();

    foreach ($rows as &$r) {
      $r['is_me'] = ((int)$r['sender_id'] === $viewer_id);
    }
    return $rows;
  }

  public function get_messages_since($thread_id, $viewer_id, $last_id)
  {
    $thread_id = (int)$thread_id;
    $viewer_id = (int)$viewer_id;
    $last_id   = (int)$last_id;

    $rows = $this->db
      ->where('thread_id', $thread_id)
      ->where('msg_id >', $last_id)
      ->order_by('msg_id', 'ASC')
      ->get('chat_messages')
      ->result_array();

    foreach ($rows as &$r) {
      $r['is_me'] = ((int)$r['sender_id'] === $viewer_id);
    }
    return $rows;
  }

  public function get_last_msg_id($thread_id)
  {
    $row = $this->db->select('MAX(msg_id) AS mx')
      ->where('thread_id', (int)$thread_id)
      ->get('chat_messages')->row_array();
    return (int)($row['mx'] ?? 0);
  }
}
