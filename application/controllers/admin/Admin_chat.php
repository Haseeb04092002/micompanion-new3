<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Admin_chat extends MY_Controller {

  public function __construct(){
    parent::__construct();
    if(!$this->session->userdata('admin_id')) redirect('admin/admin_auth/login');
    $this->load->model('Chat_model','chat');
  }

  public function index(){
    $admin_id = (int)$this->session->userdata('admin_id');
    $data['threads'] = $this->chat->list_threads_for_admin($admin_id);
    $this->load->view('admin/chat_threads', $data);
  }

  public function view($thread_id){
    $admin_id = (int)$this->session->userdata('admin_id');

    if($this->input->post('send_msg')){
      $msg = trim($this->input->post('message', true));
      if($msg!='') $this->chat->send($thread_id, $admin_id, $msg);
      redirect('admin/admin_chat/view/'.$thread_id);
    }

    $data['thread_id'] = (int)$thread_id;
    $data['messages'] = $this->chat->messages($thread_id);
    $this->load->view('admin/chat_view', $data);
  }
}
