<?php  defined('BASEPATH') OR exit('No direct script access allowed');

/*
 * Content excerpt creation helper function
 */
if (!function_exists('excerpt')) {
    function excerpt($content, $len = 200) {
        $content = strip_tags($content);
        return (strlen($content)>$len)?substr($content,0,$len).'.....':$content;
    }
}

/*
 * Pagination label and style configuration helper function
 */
if (!function_exists('adminPaginationConfig')) {
    function adminPaginationConfig($config = array()) {
        $config['first_link']  = 'First';
		$config['next_link'] = 'Next';
		$config['prev_link'] = 'Prev';
		$config['num_tag_open'] = '<li>';
		$config['num_tag_close'] = '</li>';
		$config['next_tag_open'] = '<li class="pg-next">';
		$config['next_tag_close'] = '</li>';
		$config['prev_tag_open'] = '<li class="pg-prev">';
		$config['prev_tag_close'] = '</li>';
		$config['first_tag_open'] = '<li>';
		$config['first_tag_close'] = '</li>';
		$config['last_tag_open'] = '<li>';
		$config['last_tag_close'] = '</li>';
		$config['cur_tag_open'] = '<li><a href="javascript:void(0);" class="active">';
		$config['cur_tag_close'] = '</a></li>';
        return $config;
    }
}


if (!function_exists('debugvar')) {
	function debugvar($var){
		echo '<pre>';
		print_r($var);
		die;
	}
}