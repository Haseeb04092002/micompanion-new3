<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Report_model extends CI_Model {

  public function cargo_counts_by_status($from='', $to='') {
    $where="1=1";
    if($from) $where.=" AND DATE(created_at)>=".$this->db->escape($from);
    if($to)   $where.=" AND DATE(created_at)<=".$this->db->escape($to);
    $sql="SELECT status, COUNT(*) cnt FROM cargo_bookings WHERE $where GROUP BY status";
    return $this->db->query($sql)->result_array();
  }

  public function drivers_summary() {
    $sql="SELECT status, COUNT(*) cnt FROM users WHERE role='driver' AND is_deleted=0 GROUP BY status";
    return $this->db->query($sql)->result_array();
  }

  public function customers_summary() {
    $sql="SELECT status, COUNT(*) cnt FROM users WHERE role='customer' AND is_deleted=0 GROUP BY status";
    return $this->db->query($sql)->result_array();
  }

  // Placeholder profit: (booking_price - expenses) if you add prices later
  public function simple_profit($from='', $to='') {
    $expWhere="1=1";
    if($from) $expWhere.=" AND exp_date>=".$this->db->escape($from);
    if($to)   $expWhere.=" AND exp_date<=".$this->db->escape($to);

    $exp = $this->db->query("SELECT IFNULL(SUM(amount),0) total FROM expenses WHERE $expWhere")->row_array();
    return ['income'=>0, 'expense'=>(float)$exp['total'], 'profit'=>0 - (float)$exp['total']];
  }
}
