<?php defined('BASEPATH') OR exit('No direct script access allowed');
use Dompdf\Dompdf;

class Admin_cargo_bilty extends MY_Controller {

  public function __construct(){
    parent::__construct();
    if(!$this->session->userdata('admin_id')) redirect('admin/admin_auth/login');
    require_once APPPATH.'third_party/dompdf/autoload.inc.php';
  }

  public function pdf($booking_id){
    $b = $this->db->get_where('cargo_bookings',['booking_id'=>$booking_id])->row_array();
    if(!$b) show_404();

    $html = $this->load->view('bilty/bilty_pdf',['b'=>$b],true);

    $dompdf = new Dompdf();
    $dompdf->loadHtml($html);
    $dompdf->setPaper('A4','portrait');
    $dompdf->render();

    $dompdf->stream("Bilty_{$b['bilty_code']}.pdf", ["Attachment"=>false]);
  }

  public function png($booking_id){
    $this->pdf($booking_id); // DomPDF auto rasterizes in browser print
  }
}
