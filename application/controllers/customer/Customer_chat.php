<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Customer_chat extends MY_Controller {

  public function __construct(){
    parent::__construct();
    $this->load->model('Auth_model','auth');
    $this->load->model('User_model','user');
    $this->load->model('Chat_model','chat');
  }

  public function index()
  {
    // 1. Logged-in customer
    $customer_id = (int) $this->session->userdata('user_id');

    $row = $this->db
        ->select('user_id')
        ->where('role', 'admin')
        ->limit(1)
        ->get('users')
        ->row_array();

    // 2. Admin ID (single admin system OR first admin)
    // $admin_id = (int) $this->user->get_admin_id();
    $admin_id = $row ? (int)$row['id'] : 0;

    // 3. Ensure chat thread exists
    $thread_id = $this->chat->ensure_thread($admin_id, $customer_id);

    // 4. Load messages
    $data['messages'] = $this->chat->get_messages($thread_id);

    $data['chat_with_name'] = 'Admin';
    $data['thread_id'] = $thread_id;

    // 5. Load UI
    $this->load->view('chat/chat_box', $data);
  }
}

