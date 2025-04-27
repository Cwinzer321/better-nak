<?php
defined('BASEPATH') or exit('No direct script access allowed');
/**
 * @property session $session
 * @property Invoice_model $Invoice_model
 * @property Notification_model $Notification_model
 */
class Checkout extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model(['Cart_model', 'User_model', 'Invoice_model', 'Notification_model']);
        $this->load->library('form_validation');
    }
    public function index()
    {
        $this->load->view('checkout/index');
    }

    public function process()
    {
        $data = []; // Add actual invoice data
        if ($this->Invoice_model->create_invoice($data)) {
            $invoice_code = ''; // Get actual invoice code
            $notif_data = [
                'user_id' => $this->session->userdata('user_id'),
                'title' => 'Transaksi Berhasil',
                'message' => 'Pembelian dengan invoice #' . $invoice_code . ' telah berhasil',
                'is_read' => 0,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ];
            $this->Notification_model->create_notification($notif_data);
            redirect('invoice/' . $invoice_code);
        }
    }
}
