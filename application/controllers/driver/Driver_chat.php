<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Driver_chat extends MY_Controller {

  public function __construct(){
    parent::__construct();
    $this->load->model('Chat_model','chat');
    $this->load->model('User_model','user');
    $this->load->model('Notification_model','nm');
  }

  private function must_be_driver()
  {
    if (!$this->session->userdata('driver_id')) exit("Access Denied");
  }

  public function index()
  {
    $this->must_be_driver();

    $driver_id = (int)$this->session->userdata('driver_id');
    $admin_id  = (int)$this->user->get_admin_id();

    $thread_id = $this->chat->ensure_thread($admin_id, $driver_id);

    $data = [];
    $data['thread_id']      = $thread_id;
    $data['chat_with_name'] = 'Admin';
    $data['viewer_id']      = $driver_id;
    $data['messages']       = $this->chat->get_messages($thread_id, $driver_id);
    $data['last_id']        = $this->chat->get_last_msg_id($thread_id);

    $data['fetch_url']      = site_url('driver/driver_chat/fetch/'.$thread_id);
    $data['send_url']       = site_url('driver/driver_chat/send/'.$thread_id);

    $this->load->view('chat/chat_box', $data);
  }

  public function send($thread_id)
  {
    $this->must_be_driver();
    $driver_id = (int)$this->session->userdata('driver_id');

    $message = $this->input->post('message', true);

    $admin_id = (int)$this->user->get_admin_id();
    $thread = $this->chat->get_thread_by_pair($admin_id, $driver_id);
    if (!$thread || (int)$thread['thread_id'] !== (int)$thread_id) exit("Invalid Thread");

    $this->chat->insert_message($thread_id, $driver_id, $message);
    $this->nm->create([
      'sender_role' => 'driver',
      'sender_id' => $driver_id,
      'receiver_role' => 'admin',
      'receiver_id' => NULL,
      'title' => 'New Message',
      'message' => $message,
      'ref_type' => 'chat',
      'ref_id' => $thread_id,
      'severity' => 'info',
      'url' => site_url('admin/admin_chat/with/' . $driver_id)
    ]);
    redirect('driver/driver_chat');
  }

  public function fetch($thread_id)
  {
    $this->must_be_driver();
    $driver_id = (int)$this->session->userdata('driver_id');

    $last_id = (int)$this->input->get('last_id');

    $admin_id = (int)$this->user->get_admin_id();
    $thread = $this->chat->get_thread_by_pair($admin_id, $driver_id);
    if (!$thread || (int)$thread['thread_id'] !== (int)$thread_id) exit;

    $new = $this->chat->get_messages_since($thread_id, $driver_id, $last_id);

    $html = $this->load->view('chat/_messages', ['messages'=>$new], true);
    $new_last_id = $last_id;
    foreach ($new as $m) $new_last_id = (int)$m['msg_id'];

    $this->output
      ->set_content_type('application/json')
      ->set_output(json_encode([
        'html' => $html,
        'last_id' => $new_last_id
      ]));
  }
}
