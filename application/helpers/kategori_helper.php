<?php
defined('BASEPATH') or exit('No direct script access allowed');

/**
 * Get categories by type
 * 
 * @param string $jenis Type of category
 * @return array
 */
function get_kategori_by_jenis($jenis)
{
    $CI = &get_instance();

    // Try to load the model if not already loaded
    if (!isset($CI->Category_model)) {
        $CI->load->model('Category_model');
    }

    return $CI->Category_model->get_kategori_by_jenis($jenis);
}

/**
 * Get all category options for dropdown
 * 
 * @return array
 */
function get_kategori_options()
{
    $CI = &get_instance();

    // Try to load the model if not already loaded
    if (!isset($CI->Category_model)) {
        $CI->load->model('Category_model');
    }

    return $CI->Category_model->get_kategori_options();
}
