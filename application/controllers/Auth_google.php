<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Auth_google extends CI_Controller {

//  Project Name  =  Cargo Delivery Mobile App
//  Client-ID     =  176803379168-rg6ns1ra9h4hsetabeh9ha54hddgjqvg.apps.googleusercontent.com
//  Client-secret =  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

  private $client_id = '176803379168-rg6ns1ra9h4hsetabeh9ha54hddgjqvg.apps.googleusercontent.com';
  private $client_secret = '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';
  private $redirect_uri;

  public function __construct()
  {
    parent::__construct();
    $this->redirect_uri = base_url('auth_google/callback');
  }

  /* ===========================
     REDIRECT TO GOOGLE
     =========================== */
  public function login()
  {
    $url = "https://accounts.google.com/o/oauth2/v2/auth?" . http_build_query([
      'client_id' => $this->client_id,
      'redirect_uri' => $this->redirect_uri,
      'response_type' => 'code',
      'scope' => 'email profile',
      'access_type' => 'online',
      'prompt' => 'select_account'
    ]);

    redirect($url);
  }

  /* ===========================
     GOOGLE CALLBACK
     =========================== */
  public function callback()
  {
    if (!$this->input->get('code')) {
      show_error('Google login failed');
    }

    // Exchange code for token
    $token = json_decode($this->curl_post(
      'https://oauth2.googleapis.com/token',
      [
        'code' => $this->input->get('code'),
        'client_id' => $this->client_id,
        'client_secret' => $this->client_secret,
        'redirect_uri' => $this->redirect_uri,
        'grant_type' => 'authorization_code'
      ]
    ), true);

    // Get user info
    $user = json_decode(
      file_get_contents(
        "https://www.googleapis.com/oauth2/v2/userinfo?access_token=".$token['access_token']
      ), true
    );

    // Check if user exists
    $dbUser = $this->db
      ->where('google_id', $user['id'])
      ->get('users')
      ->row_array();

    if ($dbUser) {
      $this->_login_user($dbUser);
      return;
    }

    // New user → ask role
    $this->session->set_userdata('google_user', [
      'google_id' => $user['id'],
      'email' => $user['email'],
      'name' => $user['name']
    ]);

    redirect('auth_google/select_role');
  }

  /* ===========================
     SELECT ROLE
     =========================== */
  public function select_role()
  {
    if (!$this->session->userdata('google_user')) {
      redirect('login');
    }

    if ($_POST) {
      $g = $this->session->userdata('google_user');
      $role = $this->input->post('role');

      if (!in_array($role, ['customer','driver'])) {
        show_error('Invalid role');
      }

      $this->db->insert('users', [
        'name' => $g['name'],
        'email' => $g['email'],
        'role' => $role,
        'google_id' => $g['google_id'],
        'auth_provider' => 'google',
        'status' => 'active',
        'created_at' => date('Y-m-d H:i:s')
      ]);

      $user_id = $this->db->insert_id();

      $dbUser = $this->db->where('user_id',$user_id)->get('users')->row_array();
      $this->_login_user($dbUser);
    }

    $this->load->view('auth/google_select_role');
  }

  /* ===========================
     LOGIN SESSION
     =========================== */
  private function _login_user($user)
  {
    $this->session->set_userdata([
      'user_id' => $user['user_id'],
      'role' => $user['role']
    ]);

    if ($user['role']=='driver') redirect('driver/dashboard');
    if ($user['role']=='customer') redirect('customer/dashboard');
  }

  /* ===========================
     CURL POST HELPER
     =========================== */
  private function curl_post($url, $data)
  {
    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    $res = curl_exec($ch);
    curl_close($ch);
    return $res;
  }
}
