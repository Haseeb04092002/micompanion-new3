<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Customer_chat extends MY_Controller {

  public function __construct(){
    parent::__construct();
    $this->load->model('Chat_model','chat');
    $this->load->model('User_model','user');
  }

  private function must_be_customer()
  {
    if (!$this->session->userdata('customer_id')) exit("Access Denied");
  }

  public function index()
  {
    $this->must_be_customer();

    $customer_id = (int)$this->session->userdata('customer_id');

    // Admin id: either store in config/session OR fetch from users table
    // If you already know admin is always 1, use: $admin_id = 1;
    $admin_id = (int)$this->user->get_admin_id(); // you must have this method OR replace with 1

    $thread_id = $this->chat->ensure_thread($admin_id, $customer_id);

    $data = [];
    $data['thread_id']      = $thread_id;
    $data['chat_with_name'] = 'Admin';
    $data['viewer_id']      = $customer_id;
    $data['messages']       = $this->chat->get_messages($thread_id, $customer_id);
    $data['last_id']        = $this->chat->get_last_msg_id($thread_id);

    $data['fetch_url']      = site_url('customer/customer_chat/fetch/'.$thread_id);
    $data['send_url']       = site_url('customer/customer_chat/send/'.$thread_id);

    $this->load->view('chat/chat_box', $data);
  }

  public function send($thread_id)
  {
    $this->must_be_customer();
    $customer_id = (int)$this->session->userdata('customer_id');

    $message = $this->input->post('message', true);

    // Security: customer can only send in their own thread (admin_id, other_user_id = customer)
    $admin_id = (int)$this->user->get_admin_id();
    $thread = $this->chat->get_thread_by_pair($admin_id, $customer_id);
    if (!$thread || (int)$thread['thread_id'] !== (int)$thread_id) exit("Invalid Thread");

    $this->chat->insert_message($thread_id, $customer_id, $message);
    // 🔔 notify admin
    $this->chat->create_chat_notification(
        $admin_id,
        'Customer',
        $thread_id
    );

    redirect('customer/customer_chat');
  }

  public function fetch($thread_id)
  {
    $this->must_be_customer();
    $customer_id = (int)$this->session->userdata('customer_id');

    $last_id = (int)$this->input->get('last_id');

    // validate thread belongs to this customer
    $admin_id = (int)$this->user->get_admin_id();
    $thread = $this->chat->get_thread_by_pair($admin_id, $customer_id);
    if (!$thread || (int)$thread['thread_id'] !== (int)$thread_id) exit;

    $new = $this->chat->get_messages_since($thread_id, $customer_id, $last_id);

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
