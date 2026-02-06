<?php defined('BASEPATH') or exit('No direct script access allowed');

class Admin_customers extends MY_Controller
{

    public function __construct()
    {
        parent::__construct();
        if (!$this->session->userdata('admin_id')) redirect('admin/admin_auth/login');
        $this->load->model('Customer_model', 'cust');
        $this->load->model('Auth_model', 'auth');
        $this->load->model('Notification_model','nm');
    }

    public function index()
    {
        $data['rows'] = $this->cust->list_customers_with_profile();
        $this->load->view('admin/customers_list', $data);
    }

    public function view($user_id)
    {
        $user_id = (int)$user_id;

        // basic user
        $user = $this->db->get_where('users', [
            'user_id' => $user_id,
            'role'    => 'customer',
            'is_deleted' => 0
        ])->row_array();

        if (!$user) {
            show_404();
        }

        // customer profile
        $profile = $this->db->get_where('customer_profiles', [
            'user_id' => $user_id
        ])->row_array();

        $data['user'] = $user;
        $data['profile'] = $profile;

        $this->load->view('admin/customer_view', $data);
    }


    public function approve($user_id)
    {
        $this->auth->set_status($user_id, 'approved');
        $this->nm->create([
            'sender_role' => 'customer',
            'sender_id' => $user_id,
            'receiver_role' => 'admin',
            'receiver_id' => NULL,
            'title' => 'Customer Approved',
            'message' => 'Customer has been approved.',
            'ref_type' => 'customer',
            'ref_id' => $user_id,
            'severity' => 'info',
            'url' => site_url('admin/admin_customers/view/' . $user_id)
        ]);
        $this->session->set_flashdata('ok', 'Customer approved.');
        redirect('admin/admin_customers');
    }

    public function reject($user_id)
    {
        $this->auth->set_status($user_id, 'rejected');
        $this->nm->create([
            'sender_role' => 'customer',
            'sender_id' => $user_id,
            'receiver_role' => 'admin',
            'receiver_id' => NULL,
            'title' => 'Customer Rejected',
            'message' => 'Your verification is rejected. Please update details.',
            'ref_type' => 'customer',
            'ref_id' => $user_id,
            'severity' => 'warning',
            'url' => site_url('admin/admin_customers/view/' . $user_id)
        ]);
        $this->session->set_flashdata('ok', 'Customer rejected.');
        redirect('admin/admin_customers');
    }

    public function suspend($user_id)
    {
        $this->auth->set_status($user_id, 'suspended');
        $this->nm->create([
            'sender_role' => 'customer',
            'sender_id' => $user_id,
            'receiver_role' => 'admin',
            'receiver_id' => NULL,
            'title' => 'Customer Suspended',
            'message' => 'Customer has been suspended.',
            'ref_type' => 'customer',
            'ref_id' => $user_id,
            'severity' => 'error',
            'url' => site_url('admin/admin_customers/view/' . $user_id)
        ]);
         $this->session->set_flashdata('ok', 'Customer suspended.');
        redirect('admin/admin_customers');
    }
}
