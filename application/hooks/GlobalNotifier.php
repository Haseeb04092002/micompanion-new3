<?php defined('BASEPATH') or exit('No direct script access allowed');

class GlobalNotifier
{

    protected $CI;

    public function __construct()
    {
        $this->CI = &get_instance();
    }

    public function dispatch()
    {
        // nothing triggered
        if (empty($this->CI->noti_event)) {
            return;
        }

        $this->CI->load->model('Notification_model', 'noti');

        $event = $this->CI->noti_event;

        switch ($event['event']) {

            /* ============================
         CUSTOMER → ADMIN
      ============================ */
            case 'CUSTOMER_NEW_CARGO':
                $this->CI->noti->create([
                    'to_user_id' => 1,
                    'to_role' => 'admin',
                    'type' => 'NEW_CARGO_CUSTOMER',
                    'title' => 'New Cargo Request',
                    'message' => 'New cargo booking #' . $event['booking_id'],
                    'link' => site_url('admin/cargo/view/' . $event['booking_id'])
                ]);
                break;

            /* ============================
         DRIVER → ADMIN
      ============================ */
            case 'DRIVER_JOB_REQUEST':
                $this->CI->noti->create([
                    'to_user_id' => 1,
                    'to_role' => 'admin',
                    'type' => 'NEW_CARGO_DRIVER_REQUEST',
                    'title' => 'Driver Requested Cargo',
                    'message' => 'Driver requested cargo #' . $event['booking_id'],
                    'link' => site_url('admin/driver_requests')
                ]);
                break;

            /* ============================
         ADMIN → DRIVER
      ============================ */
            case 'CARGO_ASSIGNED':
                $this->CI->noti->create([
                    'to_user_id' => $event['driver_id'],
                    'to_role' => 'driver',
                    'type' => 'CARGO_ASSIGNED',
                    'title' => 'New Cargo Assigned',
                    'message' => 'Cargo #' . $event['booking_id'] . ' assigned to you',
                    'link' => site_url('driver/driver_jobs/view/' . $event['booking_id'])
                ]);
                break;

            /* ============================
         STATUS UPDATE
      ============================ */
            case 'CARGO_STATUS_UPDATED':
                $this->CI->noti->create([
                    'to_user_id' => $event['customer_id'],
                    'to_role' => 'customer',
                    'type' => 'CARGO_STATUS_UPDATED',
                    'title' => 'Cargo Status Updated',
                    'message' => 'Your cargo is now ' . $event['status'],
                    'link' => site_url('customer/bookings/view/' . $event['booking_id'])
                ]);
                break;

            /* ============================
         CHAT MESSAGE
      ============================ */
            case 'CHAT_MESSAGE':
                $this->CI->noti->create([
                    'to_user_id' => $event['to_user_id'],
                    'to_role' => $event['to_role'],
                    'type' => 'CHAT_MESSAGE',
                    'title' => 'New Message',
                    'message' => $event['message'],
                    'link' => site_url('chat/thread/' . $event['thread_id'])
                ]);
                break;

            /* ============================
         PROMOTION / NEWS
      ============================ */
            case 'PROMOTION':
                $this->CI->noti->create([
                    'to_user_id' => $event['to_user_id'],
                    'to_role' => $event['to_role'],
                    'type' => 'PROMOTION',
                    'title' => $event['title'],
                    'message' => $event['message'],
                    'link' => site_url('news')
                ]);
                break;
        }

        // reset event (important)
        unset($this->CI->noti_event);
    }
}
