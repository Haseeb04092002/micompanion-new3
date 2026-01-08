<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Admin_chat extends MY_Controller {

  public function __construct(){
    parent::__construct();
    $this->load->model('Chat_model','chat');
    $this->load->model('User_model','user');
  }

  private function must_be_admin()
  {
    if (!$this->session->userdata('admin_id')) exit("Access Denied");
  }

  public function index()
  {
    $this->must_be_admin();
    $admin_id = (int)$this->session->userdata('admin_id');

    // Simple inbox (threads list)
    $data['threads'] = $this->chat->get_admin_threads($admin_id);
    $this->load->view('chat/admin_inbox', $data);
  }

  public function with($other_user_id)
  {
    $this->must_be_admin();
    $admin_id = (int)$this->session->userdata('admin_id');
    $other_user_id = (int)$other_user_id;

    $thread_id = $this->chat->ensure_thread($admin_id, $other_user_id);

    $data = [];
    $data['thread_id']      = $thread_id;
    $data['chat_with_name'] = 'User #'.$other_user_id; // replace with real name if you have
    $data['viewer_id']      = $admin_id;
    $data['messages']       = $this->chat->get_messages($thread_id, $admin_id);
    $data['last_id']        = $this->chat->get_last_msg_id($thread_id);

    $data['fetch_url']      = site_url('admin/admin_chat/fetch/'.$thread_id);
    $data['send_url']       = site_url('admin/admin_chat/send/'.$thread_id);

    $this->load->view('chat/chat_box', $data);
  }

  public function send($thread_id)
  {
    $this->must_be_admin();
    $admin_id = (int)$this->session->userdata('admin_id');

    $message = $this->input->post('message', true);

    // Validate thread belongs to this admin
    $t = $this->db->where(['thread_id'=>(int)$thread_id, 'admin_id'=>$admin_id])
      ->limit(1)->get('chat_threads')->row_array();
    if (!$t) exit("Invalid Thread");

    $this->chat->insert_message($thread_id, $admin_id, $message);

    redirect('admin/admin_chat/with/'.$t['other_user_id']);
  }

  public function fetch($thread_id)
  {
    $this->must_be_admin();
    $admin_id = (int)$this->session->userdata('admin_id');

    $last_id = (int)$this->input->get('last_id');

    // Validate thread belongs to this admin
    $t = $this->db->where(['thread_id'=>(int)$thread_id, 'admin_id'=>$admin_id])
      ->limit(1)->get('chat_threads')->row_array();
    if (!$t) exit;

    $new = $this->chat->get_messages_since($thread_id, $admin_id, $last_id);

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
