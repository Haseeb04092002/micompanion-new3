<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Expense_model extends CI_Model {

  public function add($data){
    $this->db->insert('expenses', $data);
    return $this->db->insert_id();
  }

  public function list($filters=[]){
    $where="1=1";
    if(!empty($filters['from'])) $where.=" AND exp_date>=".$this->db->escape($filters['from']);
    if(!empty($filters['to'])) $where.=" AND exp_date<=".$this->db->escape($filters['to']);
    $sql="SELECT * FROM expenses WHERE $where ORDER BY expense_id DESC";
    return $this->db->query($sql)->result_array();
  }

  public function total($filters=[]){
    $where="1=1";
    if(!empty($filters['from'])) $where.=" AND exp_date>=".$this->db->escape($filters['from']);
    if(!empty($filters['to'])) $where.=" AND exp_date<=".$this->db->escape($filters['to']);
    $sql="SELECT IFNULL(SUM(amount),0) AS total FROM expenses WHERE $where";
    return $this->db->query($sql)->row_array();
  }
}
