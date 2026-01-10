<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Easypaisa_model extends CI_Model {

  public function generate_hash($data)
  {
    $hash_string =
      $data['store_id'] .
      $data['amount'] .
      $data['order_id'] .
      $data['callback'] .
      $this->config->item('easypaisa')['hash_key'];

    return hash('sha256', $hash_string);
  }

  public function create_request($order_id, $amount)
  {
    $cfg = $this->config->item('easypaisa');

    $data = [
      'store_id' => $cfg['store_id'],
      'order_id' => $order_id,
      'amount'   => number_format($amount, 2, '.', ''),
      'callback' => $cfg['callback'],
    ];

    $data['hash'] = $this->generate_hash($data);
    return $data;
  }
}
