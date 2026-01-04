<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Driver_vehicles extends CI_Controller {

  public function __construct(){
    parent::__construct();
    if(!$this->session->userdata('driver_id')) redirect('driver/driver_auth/login');
    $this->load->model('Auth_model','auth');
    $this->load->model('Vehicle_model','veh');
  }

  private function upload_img($field){
    if(empty($_FILES[$field]['name'])) return '';
    $path = FCPATH.'uploads/vehicles/';
    if(!is_dir($path)) @mkdir($path,0777,true);

    $config['upload_path']=$path;
    $config['allowed_types']='jpg|jpeg|png';
    $config['max_size']=4096;
    $config['encrypt_name']=true;

    $this->load->library('upload',$config);
    if(!$this->upload->do_upload($field)){
      return ['error'=>$this->upload->display_errors('','')];
    }
    return $this->upload->data()['file_name'];
  }

  public function index(){
    $driver_id = (int)$this->session->userdata('driver_id');
    $u = $this->auth->get_user($driver_id);
    if(!$u || $u['status']!='approved'){
      $this->session->set_flashdata('err','Only approved drivers can add vehicles.');
      redirect('driver/driver_dashboard');
    }

    $data['rows'] = $this->veh->list_by_driver($driver_id);
    $this->load->view('driver/vehicles_list',$data);
  }

  public function add(){
    $driver_id = (int)$this->session->userdata('driver_id');
    $u = $this->auth->get_user($driver_id);
    if(!$u || $u['status']!='approved'){
      $this->session->set_flashdata('err','Only approved drivers can add vehicles.');
      redirect('driver/driver_dashboard');
    }

    $data['err']='';

    if($this->input->post('save')){
      $cat   = trim($this->input->post('category',true));
      $name  = trim($this->input->post('name',true));
      $model = trim($this->input->post('model',true));
      $details=trim($this->input->post('details',true));

      if($cat=='' || $name=='' || $model==''){
        $data['err']='Category, name, model required.';
      } else {
        $front = $this->upload_img('front_img');
        if(is_array($front)){ $data['err']=$front['error']; $this->load->view('driver/vehicle_form',$data); return; }

        $back = $this->upload_img('back_img');
        if(is_array($back)){ $data['err']=$back['error']; $this->load->view('driver/vehicle_form',$data); return; }

        if(!$front || !$back){
          $data['err']='Front and back images required.';
        } else {
          $this->veh->add_vehicle([
            'driver_id'=>$driver_id,
            'category'=>$cat,
            'name'=>$name,
            'model'=>$model,
            'front_img'=>$front,
            'back_img'=>$back,
            'details'=>$details,
            'status'=>'pending',
            'is_deleted'=>0,
            'created_at'=>date('Y-m-d H:i:s')
          ]);
          $this->session->set_flashdata('ok','Vehicle uploaded. Wait for admin approval.');
          redirect('driver/driver_vehicles');
        }
      }
    }

    $this->load->view('driver/vehicle_form',$data);
  }

  public function view($vehicle_id)
{
  $driver_id = (int)$this->session->userdata('driver_id');

  $vehicle = $this->veh->get_by_id_and_driver($vehicle_id, $driver_id);
  if(!$vehicle) show_404();

  $data['vehicle'] = $vehicle;
  $this->load->view('driver/vehicle_view', $data);
}

}
