<?php defined('BASEPATH') OR exit('No direct script access allowed');

class MY_Controller extends CI_Controller
{
  public function __construct()
  {
    parent::__construct();

    $this->_check_session_security();
  }

  private function _check_session_security()
  {
    $now = time();

    /* ===============================
       SESSION CREATED TIME
       =============================== */
    if (!$this->session->userdata('session_started_at')) {
      $this->session->set_userdata('session_started_at', $now);
    }

    /* ===============================
       SESSION IP CHECK
       =============================== */
    $current_ip = $this->input->ip_address();

    if (!$this->session->userdata('session_ip')) {
      $this->session->set_userdata('session_ip', $current_ip);
    }

    if ($this->session->userdata('session_ip') !== $current_ip) {
      $this->_force_logout('IP address changed.');
    }

    /* ===============================
       SESSION TIMEOUT CHECK (2 HOURS)
       =============================== */
    $started = (int)$this->session->userdata('session_started_at');

    if (($now - $started) > 7200) { // 2 hours
      $this->_force_logout('Session expired.');
    }
  }

  protected function _force_logout($reason = '')
  {
    $this->session->sess_destroy();

    // optional: log reason
    // log_message('info', 'Session logout: '.$reason);

    redirect('Welcome');
    exit;
  }
}
