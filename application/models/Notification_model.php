<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Notification_model extends CI_Model {
    
    public function __construct() {
        parent::__construct();
    }
    
    /**
     * Get all notifications for a user
     * 
     * @param int $user_id The user ID
     * @param int $limit Limit number of notifications
     * @return array List of notifications
     */
    public function getNotifications($user_id, $limit = 5) {
        $this->db->select('notifications.*, users.name as user_name');
        $this->db->join('users', 'notifications.user_id = users.id');
        $this->db->where('notifications.user_id', $user_id);
        $this->db->order_by('notifications.created_at', 'DESC');
        $this->db->limit($limit);
        return $this->db->get('notifications')->result_array();
    }
    
    /**
     * Create a new notification
     * 
     * @param array $data Notification data
     * @return int|bool Notification ID or false on failure
     */
    public function create_notification($data) {
        $notification_data = [
            'user_id' => $data['user_id'],
            'message' => $data['message'],
            'is_read' => 0,
            'created_at' => date('Y-m-d H:i:s')
        ];
        
        $this->db->insert('notifications', $notification_data);
        return $this->db->insert_id();
    }
    
    /**
     * Mark a notification as read for a specific user
     * 
     * @param int $notification_id The notification ID
     * @param int $user_id The user ID
     * @return bool Success or failure
     */
    public function mark_as_read($notification_id, $user_id) {
        $this->db->where('id', $notification_id);
        $this->db->where('user_id', $user_id);
        return $this->db->update('notifications', ['is_read' => 1]);
    }
    
    /**
     * Mark all notifications as read for a user
     * 
     * @param int $user_id The user ID
     * @return bool Success or failure
     */
    public function mark_all_as_read($user_id) {
        $this->db->where('user_id', $user_id);
        return $this->db->update('notifications', ['is_read' => 1]);
    }
    
    /**
     * Count unread notifications for a user
     * 
     * @param int $user_id The user ID
     * @return int Number of unread notifications
     */
    public function getUnreadCount($user_id) {
        $this->db->where('user_id', $user_id);
        $this->db->where('status', 'unread');
        return $this->db->count_all_results('notifications');
    }
}
