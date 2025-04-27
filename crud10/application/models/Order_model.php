<?php
class Order_model extends CI_Model {
    public function create($data) {
        $this->db->insert('orders', $data);
        return $this->db->insert_id();
    }

    public function add_order_item($data) {
        $this->db->insert('order_items', $data);
    }

    public function get_order($id) {
        return $this->db->get_where('orders', ['id' => $id])->row_array();
    }

    public function get_order_items($order_id) {
        $this->db->select('order_items.*, products.name');
        $this->db->from('order_items');
        $this->db->join('products', 'products.id = order_items.product_id');
        $this->db->where('order_id', $order_id);
        return $this->db->get()->result_array();
    }

    public function count_orders() {
        return $this->db->count_all('orders');
    }
}