<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Driver_easypaisa extends MY_Controller {

    public function __construct()
    {
        parent::__construct();
        if (!$this->session->userdata('admin_id')) {
            show_error('Unauthorized');
        }
        $this->load->model('Easypaisa_model', 'ep');
    }

    /**
     * Start EasyPaisa payment for driver commission
     */
    public function pay($booking_id)
    {
        $booking_id = (int)$booking_id;

        // Get assignment
        $assignment = $this->db
            ->where('booking_id', $booking_id)
            ->where('driver_payment_status', 'pending')
            ->get('cargo_assignments')
            ->row_array();

        if (!$assignment || !$assignment['driver_commission']) {
            show_error('Invalid or already paid');
        }

        // Create unique order id
        $order_id = 'DRIVER_'.$booking_id.'_'.time();

        // Save order ref temporarily
        $this->db->where('booking_id', $booking_id)->update('cargo_assignments', [
            'driver_payment_ref' => $order_id
        ]);

        // Prepare EasyPaisa request
        $data = $this->ep->create_request(
            $order_id,
            $assignment['driver_commission']
        );

        // Redirect to EasyPaisa
        $this->load->view('payments/easypaisa_redirect', $data);
    }
}
