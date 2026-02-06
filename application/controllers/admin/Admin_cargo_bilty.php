<?php defined('BASEPATH') or exit('No direct script access allowed');

use Dompdf\Dompdf;

class Admin_cargo_bilty extends MY_Controller
{

  public function __construct()
  {
    parent::__construct();
    if (!$this->session->userdata('admin_id')) redirect('admin/admin_auth/login');
    require_once APPPATH . 'third_party/dompdf/autoload.inc.php';
  }

  // public function pdf($booking_id){
  //   $b = $this->db->get_where('cargo_bookings',['booking_id'=>$booking_id])->row_array();
  //   if(!$b) show_404();

  //   $html = $this->load->view('bilty/bilty_pdf',['b'=>$b],true);

  //   $dompdf = new Dompdf();
  //   $dompdf->loadHtml($html);
  //   $dompdf->setPaper('A4','portrait');
  //   $dompdf->render();

  //   $dompdf->stream("Bilty_{$b['bilty_code']}.pdf", ["Attachment"=>false]);
  // }  

  public function pdf($booking_id)
  {
    $b = $this->db
      ->select("
            b.*,

            /* CUSTOMER */
            cu.name   AS customer_name,
            cu.email  AS customer_email,
            cp.phone  AS customer_phone,
            cp.cnic_no AS customer_cnic,

            /* DRIVER (if assigned) */
            du.name   AS driver_name,
            dp.phone  AS driver_phone,
            dp.license_no AS driver_license_no,
            dp.cnic_no AS driver_cnic,

            /* VEHICLE */
            v.category AS vehicle_category,
            v.name     AS vehicle_name,
            v.model    AS vehicle_model
        ", false)
      ->from('cargo_bookings b')

      /* ASSIGNMENT */
      ->join('cargo_assignments ca', 'ca.booking_id = b.booking_id', 'left')

      /* CUSTOMER */
      ->join('users cu', 'cu.user_id = b.customer_id', 'left')
      ->join('customer_profiles cp', 'cp.user_id = b.customer_id', 'left')

      /* DRIVER */
      ->join('users du', 'du.user_id = ca.driver_id', 'left')
      ->join('driver_profiles dp', 'dp.user_id = ca.driver_id', 'left')

      /* VEHICLE */
      ->join('driver_vehicles v', 'v.vehicle_id = ca.vehicle_id', 'left')

      ->where('b.booking_id', $booking_id)
      ->get()
      ->row_array();

    if (!$b) show_404();

    $html = $this->load->view('bilty/bilty_pdf', ['b' => $b], true);

    $dompdf = new Dompdf();
    $dompdf->loadHtml($html);
    $dompdf->setPaper('A4', 'portrait');
    $dompdf->render();

    $dompdf->stream(
      "Bilty_{$b['bilty_code']}.pdf",
      ["Attachment" => false]
    );
  }




  public function png($booking_id)
  {
    $this->pdf($booking_id); // DomPDF auto rasterizes in browser print
  }
}
