<?php defined('BASEPATH') or exit('No direct script access allowed');

class Notification_model extends CI_Model
{

  public function create($data)
  {
    $this->db->insert('notifications', $data);
    return $this->db->insert_id();
  }

  public function get_for_user($role, $user_id)
  {
    $sql = "
      SELECT n.*, IFNULL(r.is_read,0) AS is_read
      FROM notifications n
      LEFT JOIN notification_reads r
        ON r.notification_id = n.id
       AND r.user_role = ?
       AND r.user_id = ?
      WHERE n.receiver_role = ?
        AND (n.receiver_id IS NULL OR n.receiver_id = ?)
      ORDER BY n.id DESC
      LIMIT 20
    ";
    return $this->db->query($sql, [$role, $user_id, $role, $user_id])->result_array();
  }

  public function unread_count($role, $user_id)
  {
    $sql = "
      SELECT COUNT(*) c
      FROM notifications n
      LEFT JOIN notification_reads r
        ON r.notification_id = n.id
       AND r.user_role = ?
       AND r.user_id = ?
      WHERE n.receiver_role = ?
        AND (n.receiver_id IS NULL OR n.receiver_id = ?)
        AND IFNULL(r.is_read,0)=0
    ";
    return (int)$this->db->query($sql, [$role, $user_id, $role, $user_id])->row()->c;
  }

  public function mark_read($notif_id, $role, $user_id)
  {
    $row = $this->db->get_where('notification_reads', [
      'notification_id' => $notif_id,
      'user_role' => $role,
      'user_id' => $user_id
    ])->row();

    if ($row) {
      $this->db->where('id', $row->id)->update('notification_reads', [
        'is_read' => 1,
        'read_at' => date('Y-m-d H:i:s')
      ]);
    } else {
      $this->db->insert('notification_reads', [
        'notification_id' => $notif_id,
        'user_role' => $role,
        'user_id' => $user_id,
        'is_read' => 1,
        'read_at' => date('Y-m-d H:i:s')
      ]);
    }
  }
}
