<?php
defined('BASEPATH') or exit('No direct script access allowed');

/**
 * @property CI_Session $session
 * @property Seller_model $Seller_model
 * @property User_model $User_model
 * @property Produk_model $Produk_model
 * @property Order_model $Order_model
 * @property Notification_model $Notification_model
 * @property CI_Input $input
 * @property CI_Output $output
 * @property CI_Upload $upload
 * @property CI_Form_validation $form_validation
 */

class Seller extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model(['Seller_model', 'Produk_model', 'User_model', 'Order_model', 'Notification_model']);
        $this->load->library(['upload', 'form_validation']);

        // Authorization check
        if (!$this->session->userdata('logged_in')) {
            redirect('auth');
        }
        
        $user_role = $this->session->userdata('role');
        if ($user_role !== 'seller') {
            $this->session->set_flashdata('error', 'Unauthorized access!');
            redirect('beranda');
        }
    }

    // Dashboard Method
    public function dashboard()
    {
        $seller_id = $this->session->userdata('user_id');

        $data = [
            'stats' => [
                'total_products' => $this->Produk_model->count_seller_products($seller_id),
                'total_orders' => $this->Order_model->count_seller_orders($seller_id),
                'total_revenue' => $this->Order_model->get_seller_revenue($seller_id),
                'pending_orders' => $this->Order_model->count_pending_orders($seller_id)
            ],
            'orders' => $this->Order_model->get_recent_orders($seller_id, 10),
            'seller_data' => $this->User_model->get_seller_profile($seller_id)
        ];

        $this->load->view('folder_seller/index', $data);
    }

    // Product Management Methods
    public function produk()
    {
        $user_id = $this->session->userdata('user_id');
        
        $data = [
            'seller_data' => $this->User_model->get_seller_profile($user_id),
            'products' => $this->Produk_model->get_produk_by_seller($user_id),
            'kategori_options' => $this->Produk_model->get_kategori_options()
        ];
        
        $this->load->view('folder_seller/produk/index', $data);
    }

    public function create()
    {
        $seller_id = $this->session->userdata('user_id');

        $data = [
            'seller_data' => $this->User_model->get_seller_profile($seller_id),
            'kategori_options' => $this->Produk_model->get_kategori_options()
        ];

        $this->load->view('folder_seller/produk/create', $data);
    }

    public function store()
    {
        $this->set_product_validation_rules();
        
        // Handle file upload
        $config['upload_path'] = './uploads/produk/';
        $config['allowed_types'] = 'gif|jpg|png|jpeg';
        $config['max_size'] = 2048;
        $this->upload->initialize($config);

        if (!$this->form_validation->run()) {
            return $this->json_response(false, validation_errors());
        }

        // Process image upload
        $gambar = 'default.jpg';
        if ($this->upload->do_upload('gambar')) {
            $upload_data = $this->upload->data();
            $gambar = $upload_data['file_name'];
        }

        $product_data = $this->get_product_input_data();
        $product_data['gambar'] = $gambar;

        if ($this->Produk_model->save_product($product_data)) {
            return $this->json_response(true, 'Produk berhasil ditambahkan');
        } else {
            return $this->json_response(false, 'Gagal menyimpan data ke database');
        }
    }

    public function edit($id)
    {
        $seller_id = $this->session->userdata('user_id');
        $product = $this->Produk_model->get_product_by_id($id);

        if (!$product || $product['seller_id'] !== $seller_id) {
            $this->session->set_flashdata('error', 'Produk tidak ditemukan atau Anda tidak memiliki akses.');
            return redirect('seller/produk');
        }

        $data = [
            'product' => $product,
            'seller_data' => $this->User_model->get_seller_profile($seller_id),
            'kategori_options' => $this->Produk_model->get_kategori_options()
        ];

        $this->load->view('folder_seller/produk/edit', $data);
    }

    public function update($id)
    {
        $seller_id = $this->session->userdata('user_id');
        $product = $this->Produk_model->get_product_by_id($id);

        if (!$product || $product['seller_id'] !== $seller_id) {
            $this->session->set_flashdata('error', 'Produk tidak ditemukan atau Anda tidak memiliki akses.');
            return redirect('seller/produk');
        }

        $this->set_product_validation_rules();

        if ($this->form_validation->run() === FALSE) {
            $data = [
                'product' => $product,
                'seller_data' => $this->User_model->get_seller_profile($seller_id),
                'kategori_options' => $this->Produk_model->get_kategori_options()
            ];
            return $this->load->view('folder_seller/produk/edit', $data);
        }

        $update_data = $this->get_product_input_data();

        // Handle image upload if new image is provided
        if (!empty($_FILES['gambar']['name'])) {
            $config['upload_path'] = './uploads/produk/';
            $config['allowed_types'] = 'gif|jpg|png|jpeg';
            $config['max_size'] = 2048;
            $this->upload->initialize($config);

            if ($this->upload->do_upload('gambar')) {
                $upload_data = $this->upload->data();
                $update_data['gambar'] = $upload_data['file_name'];
                
                // Delete old image if not default
                if ($product['gambar'] !== 'default.jpg') {
                    @unlink('./uploads/produk/'.$product['gambar']);
                }
            }
        }

        if ($this->Produk_model->update_product($id, $update_data, $seller_id)) {
            $this->session->set_flashdata('success', 'Produk berhasil diperbarui.');
        } else {
            $this->session->set_flashdata('error', 'Gagal memperbarui produk.');
        }

        redirect('seller/produk');
    }

    public function delete($id)
    {
        $seller_id = $this->session->userdata('user_id');
        $product = $this->Produk_model->get_product_by_id($id);

        if ($product && $product['seller_id'] === $seller_id) {
            // Delete product image if not default
            if ($product['gambar'] !== 'default.jpg') {
                @unlink('./uploads/produk/'.$product['gambar']);
            }
            
            if ($this->Produk_model->delete_product($id, $seller_id)) {
                $this->session->set_flashdata('success', 'Produk berhasil dihapus');
            } else {
                $this->session->set_flashdata('error', 'Gagal menghapus produk');
            }
        } else {
            $this->session->set_flashdata('error', 'Produk tidak ditemukan atau Anda tidak memiliki akses');
        }

        redirect('seller/produk');
    }

    // Order Management Methods
    public function orders()
    {
        $seller_id = $this->session->userdata('user_id');
        
        $data = [
            'orders' => $this->Order_model->get_seller_orders($seller_id),
            'seller_data' => $this->User_model->get_seller_profile($seller_id)
        ];
        
        $this->load->view('folder_seller/orders/index', $data);
    }

    public function order_detail($order_id)
    {
        $seller_id = $this->session->userdata('user_id');
        $order = $this->Order_model->get_order_with_items($order_id, $seller_id);
        
        if (!$order) {
            $this->session->set_flashdata('error', 'Order tidak ditemukan');
            redirect('seller/orders');
        }
        
        $data = [
            'order' => $order,
            'seller_data' => $this->User_model->get_seller_profile($seller_id)
        ];
        
        $this->load->view('folder_seller/orders/detail', $data);
    }

    public function update_order_status()
    {
        $seller_id = $this->session->userdata('user_id');
        $order_id = $this->input->post('order_id');
        $status = $this->input->post('status');
        
        // Validasi kepemilikan order
        if (!$this->Order_model->is_order_belongs_to_seller($order_id, $seller_id)) {
            return $this->json_response(false, 'Order tidak valid');
        }
        
        if ($this->Order_model->update_order_status($order_id, $status)) {
            // Kirim notifikasi ke pembeli
            $this->send_order_notification($order_id, $status);
            return $this->json_response(true, 'Status order berhasil diperbarui');
        }
        
        return $this->json_response(false, 'Gagal memperbarui status order');
    }

    // Review Management Methods
    public function product_reviews()
    {
        $seller_id = $this->session->userdata('user_id');
        
        $data = [
            'reviews' => $this->Produk_model->get_seller_product_reviews($seller_id),
            'seller_data' => $this->User_model->get_seller_profile($seller_id)
        ];
        
        $this->load->view('folder_seller/reviews/index', $data);
    }

    public function reply_review()
    {
        $seller_id = $this->session->userdata('user_id');
        $review_id = $this->input->post('review_id');
        $reply = $this->input->post('reply');
        
        // Validasi kepemilikan review
        if (!$this->Produk_model->is_review_belongs_to_seller($review_id, $seller_id)) {
            return $this->json_response(false, 'Review tidak valid');
        }
        
        if ($this->Produk_model->add_review_reply($review_id, $reply, $seller_id)) {
            return $this->json_response(true, 'Balasan berhasil ditambahkan');
        }
        
        return $this->json_response(false, 'Gagal menambahkan balasan');
    }

    // Sales Report Methods
    public function sales_report()
    {
        $seller_id = $this->session->userdata('user_id');
        $date_range = $this->input->get('date_range') ?? 'this_month';
        
        $report_data = $this->Order_model->get_sales_report($seller_id, $date_range);
        
        $data = [
            'report' => $report_data,
            'seller_data' => $this->User_model->get_seller_profile($seller_id),
            'date_range' => $date_range,
            'date_ranges' => [
                'today' => 'Hari Ini',
                'this_week' => 'Minggu Ini',
                'this_month' => 'Bulan Ini',
                'this_year' => 'Tahun Ini',
                'last_month' => 'Bulan Lalu',
                'last_year' => 'Tahun Lalu',
                'custom' => 'Custom'
            ]
        ];
        
        $this->load->view('folder_seller/reports/sales', $data);
    }

    public function export_sales_report()
    {
        $seller_id = $this->session->userdata('user_id');
        $date_range = $this->input->get('date_range') ?? 'this_month';
        
        $this->load->library('excel');
        
        $report_data = $this->Order_model->get_sales_report($seller_id, $date_range);
        
        // Replace PHPExcel with PhpSpreadsheet
        $spreadsheet = new \PhpOffice\PhpSpreadsheet\Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        
        // Set document properties
        $spreadsheet->getProperties()
            ->setCreator("Better-nak")
            ->setTitle("Sales Report")
            ->setSubject("Sales Report")
            ->setDescription("Sales report generated by Better-nak");
        
        // Add headers
        $sheet->setCellValue('A1', 'Tanggal');
        $sheet->setCellValue('B1', 'Order ID');
        $sheet->setCellValue('C1', 'Produk');
        $sheet->setCellValue('D1', 'Jumlah');
        $sheet->setCellValue('E1', 'Harga');
        $sheet->setCellValue('F1', 'Total');
        
        // Add data
        $row = 2;
        foreach ($report_data as $item) {
            $sheet->setCellValue('A'.$row, $item->order_date);
            $sheet->setCellValue('B'.$row, $item->order_number);
            $sheet->setCellValue('C'.$row, $item->product_name);
            $sheet->setCellValue('D'.$row, $item->quantity);
            $sheet->setCellValue('E'.$row, $item->price);
            $sheet->setCellValue('F'.$row, $item->subtotal);
            $row++;
        }
        
        // Auto size columns
        foreach(range('A','F') as $columnID) {
            $sheet->getColumnDimension($columnID)->setAutoSize(true);
        }
        
        // Set headers for download
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="sales_report_'.date('Ymd').'.xlsx"');
        header('Cache-Control: max-age=0');
        
        // Update writer for Excel 2007+ format
        $writer = \PhpOffice\PhpSpreadsheet\IOFactory::createWriter($spreadsheet, 'Xlsx');
        
        $writer->save('php://output');
        exit;
    }

    // Profile Management Methods
    public function profile()
    {
        $seller_id = $this->session->userdata('user_id');
        
        $data = [
            'seller_data' => $this->User_model->get_seller_profile($seller_id)
        ];
        
        $this->load->view('folder_seller/profile/index', $data);
    }

    public function update_profile()
    {
        $seller_id = $this->session->userdata('user_id');
        
        $this->form_validation->set_rules('name', 'Nama', 'required|max_length[100]');
        $this->form_validation->set_rules('phone', 'Nomor HP', 'required|numeric');
        $this->form_validation->set_rules('address', 'Alamat', 'required');
        $this->form_validation->set_rules('business_name', 'Nama Usaha', 'required|max_length[100]');
        $this->form_validation->set_rules('business_address', 'Alamat Usaha', 'required');

        if ($this->form_validation->run() === FALSE) {
            return $this->profile();
        }

        $update_data = [
            'name' => $this->input->post('name'),
            'phone' => $this->input->post('phone'),
            'address' => $this->input->post('address'),
            'business_name' => $this->input->post('business_name'),
            'business_address' => $this->input->post('business_address')
        ];

        // Handle profile picture upload
        if (!empty($_FILES['profile_picture']['name'])) {
            $config['upload_path'] = './uploads/profile_pictures/';
            $config['allowed_types'] = 'gif|jpg|png|jpeg';
            $config['max_size'] = 2048;
            $this->upload->initialize($config);

            if ($this->upload->do_upload('profile_picture')) {
                $upload_data = $this->upload->data();
                $update_data['profile_picture'] = $upload_data['file_name'];
                
                // Delete old picture if exists
                $old_picture = $this->User_model->get_user($seller_id)->profile_picture;
                if ($old_picture && file_exists('./uploads/profile_pictures/'.$old_picture)) {
                    @unlink('./uploads/profile_pictures/'.$old_picture);
                }
            }
        }

        if ($this->User_model->updateProfile($seller_id, $update_data)) {
            // Update session data
            $this->session->set_userdata([
                'name' => $update_data['name'],
                'business_name' => $update_data['business_name']
            ]);
            
            $this->session->set_flashdata('success', 'Profil berhasil diperbarui');
        } else {
            $this->session->set_flashdata('error', 'Gagal memperbarui profil');
        }

        redirect('seller/profile');
    }

    // Helper Methods
    private function set_product_validation_rules()
    {
        $this->form_validation->set_rules('nama_produk', 'Nama Produk', 'required|max_length[255]');
        $this->form_validation->set_rules('jenis_produk', 'Jenis Produk', 'required|in_list[hewan_ternak,produk_turunan]');
        $this->form_validation->set_rules('kategori_id', 'Kategori', 'required|numeric');
        $this->form_validation->set_rules('harga', 'Harga', 'required|numeric|greater_than[0]');
        $this->form_validation->set_rules('stok', 'Stok', 'required|integer|greater_than_equal_to[0]');
        $this->form_validation->set_rules('deskripsi', 'Deskripsi', 'max_length[500]');

        if ($this->input->post('jenis_produk') === 'hewan_ternak') {
            $this->form_validation->set_rules('umur', 'Umur', 'numeric|greater_than_equal_to[0]');
            $this->form_validation->set_rules('berat', 'Berat', 'numeric|greater_than[0]');
        }
    }

    private function get_product_input_data()
    {
        return [
            'seller_id' => $this->session->userdata('user_id'),
            'nama_produk' => $this->input->post('nama_produk'),
            'jenis_produk' => $this->input->post('jenis_produk'),
            'kategori_id' => $this->input->post('kategori_id'),
            'harga' => $this->input->post('harga'),
            'stok' => $this->input->post('stok'),
            'deskripsi' => $this->input->post('deskripsi'),
            'berat' => $this->input->post('jenis_produk') === 'hewan_ternak' ? $this->input->post('berat') : null,
            'umur' => $this->input->post('jenis_produk') === 'hewan_ternak' ? $this->input->post('umur') : null
        ];
    }

    private function send_order_notification($order_id, $status)
    {
        $order = $this->Order_model->get_order($order_id);
        $status_labels = [
            'processing' => 'sedang diproses',
            'shipped' => 'telah dikirim',
            'completed' => 'telah selesai'
        ];
        
        $message = "Order #{$order->order_number} {$status_labels[$status]}";
        
        $this->Notification_model->create_notification([
            'user_id' => $order->user_id,
            'message' => $message,
            'link' => "order/detail/{$order_id}",
            'type' => 'order'
        ]);
    }

    private function json_response($success, $message)
    {
        return $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode([
                'success' => $success,
                'message' => $message
            ]));
    }

    // Notification Methods
    public function notifications()
    {
        $seller_id = $this->session->userdata('user_id');
        
        $data = [
            'notifications' => $this->Notification_model->get_user_notifications($seller_id),
            'seller_data' => $this->User_model->get_seller_profile($seller_id)
        ];
        
        $this->load->view('folder_seller/notifications/index', $data);
    }
    
    public function mark_notification_read($notification_id)
    {
        $seller_id = $this->session->userdata('user_id');
        
        if ($this->Notification_model->mark_as_read($notification_id, $seller_id)) {
            return $this->json_response(true, 'Notifikasi ditandai sebagai dibaca');
        }
        
        return $this->json_response(false, 'Gagal menandai notifikasi');
    }
    
    public function mark_all_notifications_read()
    {
        $seller_id = $this->session->userdata('user_id');
        
        if ($this->Notification_model->mark_all_as_read($seller_id)) {
            return $this->json_response(true, 'Semua notifikasi ditandai sebagai dibaca');
        }
        
        return $this->json_response(false, 'Gagal menandai notifikasi');
    }
    
    // Settings Methods
    public function settings()
    {
        $seller_id = $this->session->userdata('user_id');
        
        $data = [
            'seller_data' => $this->User_model->get_seller_profile($seller_id),
            'settings' => $this->Seller_model->get_seller_settings($seller_id)
        ];
        
        $this->load->view('folder_seller/settings/index', $data);
    }
    
    public function update_settings()
    {
        $seller_id = $this->session->userdata('user_id');
        
        $this->form_validation->set_rules('notification_email', 'Email Notifikasi', 'required|in_list[0,1]');
        $this->form_validation->set_rules('notification_app', 'Notifikasi Aplikasi', 'required|in_list[0,1]');
        
        if ($this->form_validation->run() === FALSE) {
            return $this->settings();
        }
        
        $settings_data = [
            'notification_email' => $this->input->post('notification_email'),
            'notification_app' => $this->input->post('notification_app')
        ];
        
        if ($this->Seller_model->update_settings($seller_id, $settings_data)) {
            $this->session->set_flashdata('success', 'Pengaturan berhasil diperbarui');
        } else {
            $this->session->set_flashdata('error', 'Gagal memperbarui pengaturan');
        }
        
        redirect('seller/settings');
    }
    
    // Password Change Method
    public function change_password()
    {
        $seller_id = $this->session->userdata('user_id');
        
        $this->form_validation->set_rules('current_password', 'Password Saat Ini', 'required');
        $this->form_validation->set_rules('new_password', 'Password Baru', 'required|min_length[8]');
        $this->form_validation->set_rules('confirm_password', 'Konfirmasi Password', 'required|matches[new_password]');
        
        if ($this->form_validation->run() === FALSE) {
            $data = [
                'seller_data' => $this->User_model->get_seller_profile($seller_id)
            ];
            
            $this->load->view('folder_seller/profile/change_password', $data);
            return;
        }
        
        $current_password = $this->input->post('current_password');
        $new_password = $this->input->post('new_password');
        
        if ($this->User_model->change_password($seller_id, $current_password, $new_password)) {
            $this->session->set_flashdata('success', 'Password berhasil diubah');
            redirect('seller/profile');
        } else {
            $this->session->set_flashdata('error', 'Password saat ini tidak valid');
            redirect('seller/change_password');
        }
    }

    // AJAX Methods
    public function get_kategori_by_jenis()
    {
        $jenis_produk = $this->input->post('jenis_produk');
        $kategori = $this->Produk_model->get_kategori_by_jenis($jenis_produk);
    
        $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode($kategori));
    }
}