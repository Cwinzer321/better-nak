<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Cart_model extends CI_Model
{
    private $table = 'carts';

    /**
     * Check if product has enough stock for the requested quantity
     *
     * @param int $product_id Product ID
     * @param int $quantity Requested quantity
     * @return bool True if enough stock, false otherwise
     */
    public function check_stock($product_id, $quantity)
    {
        $this->db->select('stock');
        $this->db->from('products');
        $this->db->where('id', $product_id);
        $query = $this->db->get();
        
        if ($query->num_rows() > 0) {
            $product = $query->row();
            return ($product->stock >= $quantity);
        }
        
        return false;
    }

    /**
     * Add product to cart in database
     *
     * @param int $user_id User ID
     * @param int $product_id Product ID
     * @param int $quantity Quantity
     * @return bool Success status
     */
    public function add_to_cart_db($user_id, $product_id, $quantity)
    {
        // Check if product already in cart
        $this->db->where('user_id', $user_id);
        $this->db->where('product_id', $product_id);
        $query = $this->db->get($this->table);
        
        if ($query->num_rows() > 0) {
            // Update quantity if product already in cart
            $cart_item = $query->row();
            $this->db->where('id', $cart_item->id);
            $this->db->update($this->table, ['quantity' => $cart_item->quantity + $quantity]);
        } else {
            // Insert new cart item
            $data = [
                'user_id' => $user_id,
                'product_id' => $product_id,
                'quantity' => $quantity,
                'created_at' => date('Y-m-d H:i:s')
            ];
            $this->db->insert($this->table, $data);
        }
        
        return ($this->db->affected_rows() > 0);
    }

    /**
     * Get cart item count for user
     *
     * @param int $user_id User ID
     * @return int Number of items in cart
     */
    public function getCartCount($user_id)
    {
        $this->db->where('user_id', $user_id);
        return $this->db->count_all_results($this->table);
    }

    /**
     * Get cart contents for user
     *
     * @param int $user_id User ID
     * @return array Cart items with product details
     */
    public function contents($user_id)
    {
        $this->db->select('carts.*, products.name, products.price, products.image');
        $this->db->from($this->table);
        $this->db->join('products', 'products.id = carts.product_id');
        $this->db->where('carts.user_id', $user_id);
        $query = $this->db->get();
        
        return $query->result_array();
    }

    /**
     * Get cart items with product details
     *
     * @param int $user_id User ID
     * @return array Cart items with product details
     */
    public function getCart($user_id)
    {
        $this->db->select('carts.id as cart_id, carts.quantity, products.*');
        $this->db->from($this->table);
        $this->db->join('products', 'products.id = carts.product_id');
        $this->db->where('carts.user_id', $user_id);
        $query = $this->db->get();
        
        return $query->result_array();
    }

    /**
     * Save cart (typically used when checking out)
     *
     * @param int $user_id User ID
     * @param array $cart_items Cart items
     * @return bool Success status
     */
    public function save_cart($user_id, $cart_items)
    {
        if (empty($cart_items)) {
            return false;
        }
        
        // Begin transaction
        $this->db->trans_begin();
        
        try {
            // Create order
            $order_data = [
                'user_id' => $user_id,
                'total_amount' => 0, // Will be updated
                'status' => 'pending',
                'created_at' => date('Y-m-d H:i:s')
            ];
            
            $this->db->insert('orders', $order_data);
            $order_id = $this->db->insert_id();
            
            $total_amount = 0;
            
            // Add order items
            foreach ($cart_items as $item) {
                $subtotal = $item['price'] * $item['quantity'];
                $total_amount += $subtotal;
                
                $order_item = [
                    'order_id' => $order_id,
                    'product_id' => $item['product_id'],
                    'quantity' => $item['quantity'],
                    'price' => $item['price'],
                    'subtotal' => $subtotal
                ];
                
                $this->db->insert('order_items', $order_item);
                
                // Update product stock
                $this->db->set('stock', 'stock - ' . $item['quantity'], FALSE);
                $this->db->where('id', $item['product_id']);
                $this->db->update('products');
            }
            
            // Update order total
            $this->db->where('id', $order_id);
            $this->db->update('orders', ['total_amount' => $total_amount]);
            
            // Clear cart
            $this->db->where('user_id', $user_id);
            $this->db->delete($this->table);
            
            if ($this->db->trans_status() === FALSE) {
                $this->db->trans_rollback();
                return false;
            }
            
            $this->db->trans_commit();
            return true;
            
        } catch (Exception $e) {
            $this->db->trans_rollback();
            return false;
        }
    }
}
