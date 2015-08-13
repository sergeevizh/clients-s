<?php
/*
Plugin Name: Clients for WP
Plugin URI: https://github.com/systemo-biz/clients-s
Description: Плагин добавляет возможсноть вывода постов через Swiper https://github.com/systemo-biz/posts-swiper-wp
Author: Systemo
Author URI: http://systemo.biz
GitHub Plugin URI: https://github.com/systemo-biz/clients-s
GitHub Branch: master
Version: 20150814
*/



//Clinets for WP
class Clients_S_Singleton {
private static $_instance = null;
private function __construct() {

  add_action('init', array($this, 'taxonomy'));
  add_action('init', array($this, 'cpt'));

}
function cpt() {
  register_post_type('client-s', array(
    'label' => 'Клиенты',
    'description' => '',
    'public' => false,
    'show_ui' => true,
    'show_in_menu' => true,
    'capability_type' => 'post',
    'map_meta_cap' => true,
    'hierarchical' => false,
    'rewrite' => array('slug' => 'clients', 'with_front' => 0),
    'query_var' => true,
    'has_archive' => true,
    'supports' => array('title','editor','custom-fields','thumbnail'),
    'labels' => array (
      'name' => 'Клиенты',
      'singular_name' => 'Клиент',
      'menu_name' => 'Клиенты',
      'add_new' => 'Add Клиент',
      'add_new_item' => 'Add New Клиент',
      'edit' => 'Edit',
      'edit_item' => 'Edit Клиент',
      'new_item' => 'New Клиент',
      'view' => 'View Клиент',
      'view_item' => 'View Клиент',
      'search_items' => 'Search Клиенты',
      'not_found' => 'No Клиенты Found',
      'not_found_in_trash' => 'No Клиенты Found in Trash',
      'parent' => 'Parent Клиент',
    )
  ));
}

function taxonomy() {
  register_taxonomy(
    'clients-category',
    array('clients-s'),
    array(
      'hierarchical' => false,
    	'label' => 'Категории клиентов',
    	'show_ui' => true,
    	'query_var' => true,
    	'show_admin_column' => false,
    	'labels' => array (
        'search_items' => 'Категории клиентов',
        'popular_items' => '',
        'all_items' => '',
        'parent_item' => '',
        'parent_item_colon' => '',
        'edit_item' => '',
        'update_item' => '',
        'add_new_item' => '',
        'new_item_name' => '',
        'separate_items_with_commas' => '',
        'add_or_remove_items' => '',
        'choose_from_most_used' => '',
      )
    )
  );
}


protected function __clone() {
	// ограничивает клонирование объекта
}
static public function getInstance() {
	if(is_null(self::$_instance))
	{
	self::$_instance = new self();
	}
	return self::$_instance;
}
} $TheClients_S = Clients_S_Singleton::getInstance();
