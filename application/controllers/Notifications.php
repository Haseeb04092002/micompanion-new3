<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Notifications extends MY_Controller {

  public function poll()
  {
    $user_id = (int)$this->session->userdata('user_id');
    if (!$user_id) exit;

    $last_id = (int)$this->input->get('last_id');

    $this->db->where('user_id', $user_id);
    $this->db->where('is_read', 0);
    if ($last_id > 0) {
      $this->db->where('noti_id >', $last_id);
    }

    $rows = $this->db
      ->order_by('noti_id','ASC')
      ->limit(5)
      ->get('notifications')
      ->result_array();

    $data = [];
    foreach ($rows as $r) {

      // mark as read
      $this->db->where('noti_id', $r['noti_id'])
               ->update('notifications', ['is_read'=>1]);

      $chat_url = '#';
      if ($r['ref_type'] === 'chat') {
        $chat_url = site_url('chat/open/'.$r['ref_id']);
      }

      $data[] = [
        'noti_id' => $r['noti_id'],
        'title'   => $r['title'],
        'body'    => $r['body'],
        'ref_type'=> $r['ref_type'],
        'chat_url'=> $chat_url
      ];
    }

    $this->output
      ->set_content_type('application/json')
      ->set_output(json_encode(['notifications'=>$data]));
  }
}
