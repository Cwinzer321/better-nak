<?php
defined('BASEPATH') or exit('No direct script access allowed');

/**
 * @property Invoice_model $Invoice_model
 * @property Order_model $Order_model
 * @property User_model $User_model
 * @property session $session
 * @property pdf $pdf
 */
class Invoice extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model(['Invoice_model', 'Order_model', 'User_model']);
        $this->load->library('pdf');
    }

    public function generate_pdf($order_id)
    {
        $invoice = $this->Invoice_model->get_invoice_by_id($order_id);
        $user = $this->User_model->get_user_by_id($this->session->userdata('user_id'));

        $data = [
            'invoice' => $invoice,
            'user' => $user,
            'order' => $this->Order_model->get_order_details($order_id)
        ];

        $html = $this->load->view('invoice/view', $data, true);

        $this->pdf->load_html($html);
        $this->pdf->render();
        $this->pdf->stream("invoice-" . $invoice->invoice_number . ".pdf");
    }

    public function index()
    {
        $data['invoices'] = $this->Invoice_model->get_invoices_by_user(
            $this->session->userdata('user_id')
        );

        $this->load->view('templates/header');
        $this->load->view('invoice/index', $data);
        $this->load->view('templates/footer');
    }
}
