<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Admin_chat extends MY_Controller {

  public function __construct(){
    parent::__construct();

    if(!$this->session->userdata('admin_id')){
      redirect('admin/admin_auth/login');
    }

    $this->load->model('Chat_model','chat');
  }

  /* =========================================
     ADMIN CHAT THREADS (CUSTOMERS + DRIVERS)
     ========================================= */
  public function index()
  {
    $admin_id = (int)$this->session->userdata('admin_id');

    $data['customer_threads'] = $this->chat->list_customer_threads_for_admin($admin_id);
    $data['driver_threads']   = $this->chat->list_driver_threads_for_admin($admin_id);

    $this->load->view('admin/chat_threads', $data);
  }

  /* =========================================
     CHAT VIEW (ADMIN ↔ CUSTOMER / DRIVER)
     ========================================= */
  public function chat($type, $user_id)
  {
    $admin_id = (int)$this->session->userdata('admin_id');
    $user_id  = (int)$user_id;

    if (!in_array($type, ['customer','driver'])) {
      show_404();
    }

    /* ---------- SEND MESSAGE ---------- */
    if ($this->input->post('send_msg')) {
      $msg = trim($this->input->post('message', true));
      if ($msg !== '') {
        $this->chat->send_admin_message($type, $admin_id, $user_id, $msg);
      }
      redirect('admin/admin_chat/chat/'.$type.'/'.$user_id);
    }

    /* ---------- LOAD CHAT DATA ---------- */
    $data['chat_with_name'] = $this->chat->get_user_name($user_id);
    $data['messages']       = $this->chat->get_messages_admin($type, $admin_id, $user_id);

    $this->load->view('chat/chat_box', $data);
  }
}
