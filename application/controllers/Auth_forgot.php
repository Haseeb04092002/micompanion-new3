<?php defined('BASEPATH') or exit('No direct script access allowed');

//  Project Name  =  Cargo Delivery Mobile App
//  Client-ID     =  176803379168-rg6ns1ra9h4hsetabeh9ha54hddgjqvg.apps.googleusercontent.com
//  Client-secret =  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

class Auth_forgot extends CI_Controller
{

  /* ===========================
     STEP 1: REQUEST OTP
     =========================== */
  public function index()
  {
    if ($_POST) {
      $email = trim($this->input->post('email'));

      $user = $this->db
        ->where('email', $email)
        ->where('is_deleted', 0)
        ->get('users')
        ->row_array();

      if (!$user) {
        $data['error'] = 'Account not found';
        return $this->load->view('auth/forgot_password', $data);
      }

      // ❌ Admin cannot reset
      if ($user['role'] === 'admin') {
        redirect('auth_forgot/admin');
      }

      // Generate OTP
      $otp = rand(100000, 999999);

      $this->db->insert('password_resets', [
        'user_id'    => $user['user_id'],
        'otp'        => $otp,
        'expires_at' => date('Y-m-d H:i:s', strtotime('+10 minutes'))
      ]);

      $config['smtp_user']   = 'records@aramex-pk.com';     // YOUR GMAIL
      $this->load->library('email', $config);
      $this->email->from('records@aramex-pk.com', 'Password Reset');
      $this->email->to($user['email']);
      $this->email->subject('Password Reset OTP');
      $this->email->message('Your OTP is: ' . $otp);

      if (!$this->email->send()) {
        echo 'Email Not send ! Go Back and Try Again';
      }

      // TODO: send OTP (SMS / Email / WhatsApp)
      log_message('error', 'OTP for ' . $email . ' = ' . $otp);

      redirect('auth_forgot/verify/' . $user['user_id']);
    }

    $this->load->view('auth/forgot_password');
  }

  /* ===========================
     STEP 2: VERIFY OTP
     =========================== */
  public function verify($user_id)
  {
    if ($_POST) {
      $otp = $this->input->post('otp');

      $row = $this->db
        ->where('user_id', $user_id)
        ->where('otp', $otp)
        ->where('is_used', 0)
        ->where('expires_at >=', date('Y-m-d H:i:s'))
        ->order_by('reset_id', 'DESC')
        ->get('password_resets')
        ->row_array();

      if (!$row) {
        $data['error'] = 'Invalid or expired OTP';
        return $this->load->view('auth/verify_otp', $data);
      }

      redirect('auth_forgot/reset/' . $user_id . '/' . $row['reset_id']);
    }

    $this->load->view('auth/verify_otp');
  }

  /* ===========================
     STEP 3: RESET PASSWORD
     =========================== */
  public function reset($user_id, $reset_id)
  {
    if ($_POST) {
      $pass = $this->input->post('password');

      $this->db->where('user_id', $user_id)->update('users', [
        'password' => $pass
      ]);

      $this->db->where('reset_id', $reset_id)->update('password_resets', [
        'is_used' => 1
      ]);

      redirect('welcome');
    }

    $this->load->view('auth/reset_password');
  }

  /* ===========================
     ADMIN FORGOT PASSWORD
     =========================== */
  public function admin()
  {
    $this->load->view('auth/admin_forgot');
  }
}
