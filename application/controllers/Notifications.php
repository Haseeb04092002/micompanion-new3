<?php defined('BASEPATH') or exit('No direct script access allowed');

class Notifications extends CI_Controller
{

  public function __construct()
  {
    parent::__construct();
    $this->load->model('Notification_model', 'nm');
  }

  private function user()
  {
    if ($this->session->userdata('admin_id'))
      return ['admin', $this->session->userdata('admin_id')];

    if ($this->session->userdata('driver_id'))
      return ['driver', $this->session->userdata('driver_id')];

    if ($this->session->userdata('customer_id'))
      return ['customer', $this->session->userdata('customer_id')];

    return [null, null];
  }

  public function poll()
  {
    list($role, $uid) = $this->user();
    if (!$role) exit;

    echo json_encode([
      'unread' => $this->nm->unread_count($role, $uid),
      'list' => $this->nm->get_for_user($role, $uid)
    ]);
  }

  public function mark_read($id)
  {
    list($role, $uid) = $this->user();
    $this->nm->mark_read($id, $role, $uid);
    echo json_encode(['ok' => 1]);
  }
}
