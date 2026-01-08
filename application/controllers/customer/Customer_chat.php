<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Customer_chat extends MY_Controller {

  public function __construct(){
    parent::__construct();
    $this->load->model('Auth_model','auth');
    $this->load->model('User_model','user');
  }

  public function index()
    {
    // load messages between customer & admin
    $data['chat_with_name'] = 'Admin';
    $data['messages'] = $this->chat->get_messages_for_other();
    $this->load->view('chat/chat_box', $data);

    
    }

}
