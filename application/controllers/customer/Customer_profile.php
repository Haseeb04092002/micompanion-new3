<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Customer_profile extends MY_Controller {

  public function __construct(){
    parent::__construct();
    if(!$this->session->userdata('customer_id')) redirect('customer/customer_auth/login');
    $this->load->model('Customer_model','cust');
  }

  private function upload_file($field, $path){
    if(empty($_FILES[$field]['name'])) return '';
    $config['upload_path'] = $path;
    $config['allowed_types'] = 'jpg|jpeg|png';
    $config['max_size'] = 4096;
    $config['encrypt_name'] = true;
    $this->load->library('upload', $config);

    if(!$this->upload->do_upload($field)){
      return ['error'=>$this->upload->display_errors('','')];
    }
    return $this->upload->data()['file_name'];
  }

  public function verify(){
    $cid = (int)$this->session->userdata('customer_id');
    $data['row'] = $this->cust->get_profile($cid);
    $data['err']='';

    if($this->input->post('save')){
      $cnic_no = trim($this->input->post('cnic_no', true));
      $phone   = trim($this->input->post('phone', true));
      $address = trim($this->input->post('address', true));

      if($cnic_no=='' || $phone=='' || $address==''){
        $data['err']='All fields required.';
      } else {
        $base = FCPATH.'uploads/users/';
        if(!is_dir($base)) @mkdir($base,0777,true);

        $profile_pic = $this->upload_file('profile_pic',$base);
        if(is_array($profile_pic)) { $data['err']=$profile_pic['error']; $this->load->view('customer/verification_form',$data); return; }

        $cnic_img = $this->upload_file('cnic_img',$base);
        if(is_array($cnic_img)) { $data['err']=$cnic_img['error']; $this->load->view('customer/verification_form',$data); return; }

        $payload = ['cnic_no'=>$cnic_no,'phone'=>$phone,'address'=>$address];
        if($profile_pic) $payload['profile_pic']=$profile_pic;
        if($cnic_img) $payload['cnic_img']=$cnic_img;

        $this->cust->upsert_profile($cid,$payload);
        $this->session->set_flashdata('ok','Verification saved. Wait for admin approval.');
        redirect('customer/customer_dashboard');
      }
    }

    $this->load->view('customer/verification_form',$data);
  }
}
