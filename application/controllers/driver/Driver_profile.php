<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Driver_profile extends CI_Controller {

  public function __construct(){
    parent::__construct();
    if(!$this->session->userdata('driver_id')) redirect('driver/driver_auth/login');
    $this->load->model('Driver_model','driver');
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
    $d = $this->upload->data();
    return $d['file_name'];
  }

  public function verify(){
    $driver_id = (int)$this->session->userdata('driver_id');
    $data['row'] = $this->driver->get_profile($driver_id);
    $data['err']='';

    if($this->input->post('save')){
      $license_no = trim($this->input->post('license_no', true));
      $cnic_no    = trim($this->input->post('cnic_no', true));
      $phone      = trim($this->input->post('phone', true));
      $address    = trim($this->input->post('address', true));

      if($license_no=='' || $cnic_no=='' || $phone=='' || $address==''){
        $data['err']='All fields required.';
      } else {
        $base = FCPATH.'uploads/users/';
        if(!is_dir($base)) @mkdir($base,0777,true);

        $profile_pic = $this->upload_file('profile_pic', $base);
        if(is_array($profile_pic)) { $data['err']=$profile_pic['error']; $this->load->view('driver/verification_form',$data); return; }

        $license_img = $this->upload_file('license_img', $base);
        if(is_array($license_img)) { $data['err']=$license_img['error']; $this->load->view('driver/verification_form',$data); return; }

        $cnic_img = $this->upload_file('cnic_img', $base);
        if(is_array($cnic_img)) { $data['err']=$cnic_img['error']; $this->load->view('driver/verification_form',$data); return; }

        $payload = [
          'license_no'=>$license_no,
          'cnic_no'=>$cnic_no,
          'phone'=>$phone,
          'address'=>$address
        ];
        if($profile_pic) $payload['profile_pic']=$profile_pic;
        if($license_img) $payload['license_img']=$license_img;
        if($cnic_img)    $payload['cnic_img']=$cnic_img;

        $this->driver->upsert_profile($driver_id, $payload);
        $this->session->set_flashdata('ok','Documents saved. Wait for admin approval.');
        redirect('driver/driver_dashboard');
      }
    }

    $this->load->view('driver/verification_form', $data);
  }
}
