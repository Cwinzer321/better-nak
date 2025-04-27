<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User_model extends Base_model {
    
    protected $table = 'users';
    
    public function __construct() {
        parent::__construct();
    }
    
    /**
     * Get user by ID
     * 
     * @param int $id_user The user ID
     * @return array User details
     */
    public function getUserById($id_user) 
    {
        $this->db->where('id', $id_user);
        return $this->db->get('users')->row_array();
    }
    
    /**
     * Check user credentials for login
     * 
     * @param string $email User email
     * @param string $password User password
     * @return object|bool User object if credentials are valid, false otherwise
     */
    public function check_credentials($email, $password)
    {
        $this->db->where('email', $email);
        $this->db->where('status', 'active');
        $user = $this->db->get('users')->row();
        
        if ($user && password_verify($password, $user->password)) {
            return $user;
        }
        
        return false;
    }
    
    /**
     * Create a new user
     * 
     * @param array $user_data User data including name, email, password, role
     * @return bool Success or failure
     */
    public function create_user($user_data)
    {
        // Make sure created_at is set
        if (!isset($user_data['created_at'])) {
            $user_data['created_at'] = date('Y-m-d H:i:s');
        }
        
        return $this->db->insert('users', $user_data);
    }
    
    /**
     * Update user profile picture
     * 
     * @param int $id_user The user ID
     * @param string $filename New profile picture filename
     * @return bool Success or failure
     */
    public function update_profile_picture($id_user, $filename) 
    {
        $this->db->where('id', $id_user);
        return $this->db->update('users', ['photo' => $filename]);
    }
    
    /**
     * Delete user account
     * 
     * @param int $id_user The user ID
     * @return bool Success or failure
     */
    public function delete_user($id_user) 
    {
        $this->db->where('id', $id_user);
        return $this->db->delete('users');
    }
    
    /**
     * Get seller profile with details
     * 
     * @param int $seller_id The seller's user ID
     * @return array Seller profile with details
     */
    public function get_seller_profile($seller_id)
    {
        $this->db->select('users.*, seller_details.description, seller_details.certificate, seller_details.verification_status');
        $this->db->from('users');
        $this->db->join('seller_details', 'users.id = seller_details.user_id', 'left');
        $this->db->where('users.id', $seller_id);
        $this->db->where('users.role', 'seller');
        
        return $this->db->get()->row_array();
    }
    
    /**
     * Update user profile
     * 
     * @param int $user_id User ID
     * @param array $data Profile data
     * @return bool Success or failure
     */
    /**
     * Update user profile data
     * 
     * @param int $user_id The user ID
     * @param array $data Profile data to update
     * @return bool Success status
     */
    public function updateProfile($user_id, $data)
    {
        $this->db->where('id', $user_id);
        return $this->db->update('users', $data);
    }
    
    /**
     * Count users, optionally filtered by role
     * 
     * @param string $role Optional role to filter by (admin, seller, customer)
     * @return int Number of users
     */
    public function count_users($role = null) 
    {
        if ($role !== null) {
            $this->db->where('role', $role);
        }
        
        $this->db->where('status', 'active');
        return $this->db->count_all_results('users');
    }
    
    /**
     * Get user data by ID
     * 
     * @param int $user_id The user ID
     * @return object User data object
     */
    public function get_user($user_id)
    {
        $this->db->where('id', $user_id);
        return $this->db->get('users')->row();
    }
    
    /**
     * Change user password
     * 
     * @param int $user_id The user ID
     * @param string $current_password Current password for verification
     * @param string $new_password New password to set
     * @return bool Success status
     */
    public function change_password($user_id, $current_password, $new_password)
    {
        // Get the user's current password hash
        $this->db->select('password');
        $this->db->where('id', $user_id);
        $user = $this->db->get('users')->row();
        
        if (!$user) {
            return false;
        }
        
        // Verify current password
        if (!password_verify($current_password, $user->password)) {
            return false;
        }
        
        // Hash the new password
        $new_password_hash = password_hash($new_password, PASSWORD_DEFAULT);
        
        // Update the password
        $this->db->where('id', $user_id);
        return $this->db->update('users', ['password' => $new_password_hash]);
    }
    
    public function get_profile_picture($user_id) {
        $this->db->select('profile_picture');
        $this->db->where('id', $user_id);
        $result = $this->db->get('users')->row();
        return $result->profile_picture ?? 'default.jpg'; // Ensure this line exists
    }
}
