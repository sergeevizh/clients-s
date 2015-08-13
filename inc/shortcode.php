<?php
/*
Plugin Name: Posts Swiper for WordPress
Plugin URI: https://github.com/systemo-biz/posts-swiper-wp
Description: Плагин добавляет возможсноть вывода постов через Swiper https://github.com/systemo-biz/posts-swiper-wp

*/


//Posts shortcode swiper
class PostsSwiper_Singleton {
private static $_instance = null;
private function __construct() {
  add_shortcode('clients-s', array($this, 'posts_swiper_sc_callback'));
  add_action( 'wp_enqueue_scripts', array($this, 'wp_enqueue_scripts_cb'));
  add_action('wp_head', array($this, 'hook_css'));
}

  function wp_enqueue_scripts_cb(){
    wp_register_style( 'swiper', plugin_dir_url(__FILE__).'swiper/dist/css/swiper.min.css', '', $ver = '3.1.0', $media = 'all' );
    wp_enqueue_style( 'swiper' );

    wp_register_script( 'swiper', plugin_dir_url(__FILE__).'swiper/dist/js/swiper.jquery.min.js', array('jquery'), $ver = '3.1.0' );
    wp_enqueue_script( 'swiper' );
  }


  function posts_swiper_sc_callback($atts) {

    extract( shortcode_atts( array(
        'post_type'       => 'client-s',
        'numberposts'     => 7,
      	'offset'          => 0,
      	'category'        => '',
      	'orderby'         => 'post_date',
      	'order'           => 'DESC',
      	'include'         => '',
      	'exclude'         => '',
      	'meta_key'        => '',
      	'meta_value'      => '',
      	'post_parent'     => '',
      	'post_status'     => 'publish',
        'slides_per_view' => 5,
        'size'            => 'thumbnail',
        'show_title'      => '',
        'url'             => '',
        'space_between'   => 15,

  	 ), $atts ) );

     $posts = get_posts(array(
       'post_type'       => $post_type,
       'numberposts'     => $numberposts,
       'offset'          => $offset,
       'category'        => $category,
       'orderby'         => $orderby,
       'order'           => $order,
       'include'         => $include,
       'exclude'         => $exclude,
       'meta_key'        => $meta_key,
       'meta_value'      => $meta_value,
       'post_parent'     => $post_parent,
       'post_status'     => $post_status,
     ));


     ob_start();

     ?>
      <div class="swiper-container">
          <div class="swiper-wrapper">
            <?php foreach($posts as $post): setup_postdata($post); ?>
              <?php if($url): ?>
                <a href="<?php echo get_the_permalink($post->ID); ?>">
              <?php endif; ?>
                <div class="swiper-slide">
                  <div class="post-swiper-thumbnail-title">
                    <?php echo get_the_post_thumbnail( $post->ID, 'thumbnail' ); ?>
                  </div>

                  <?php if($show_title): ?>
                    <div>
                      <strong><?php echo $post->post_title; ?></strong>
                    </div>
                  <?php endif; ?>
                </div>
              <?php if($url): ?>
                </a>
              <?php endif; ?>

            <?php endforeach; wp_reset_postdata(); ?>

          </div>
          <!-- Add Arrows -->
           <div class="swiper-button-next"></div>
           <div class="swiper-button-prev"></div>
      </div>

      <!-- Initialize Swiper -->
      <script>
        jQuery(document).ready(function($) {

          var swiper = new Swiper('.swiper-container', {
              nextButton: '.swiper-button-next',
              prevButton: '.swiper-button-prev',
              slidesPerView: 5,
              spaceBetween:  12,
              autoplay: 2500,
              autoplayDisableOnInteraction: false,
              loop: true
          });
        });
      </script>
     <?php

     $html = ob_get_contents();
     ob_get_clean();

     return $html;
  }

function hook_css(){

  $post = get_post();

  if(has_shortcode( $post->post_content, 'clients-s' )):
    ?>
      <style>
        .swiper-container {
            width: 100%;
            height: 100%;
        }
        .swiper-slide {
            min-height: 100px;
        }

        .swiper-slide img {
          width: auto;
        }
      </style>
    <?php
  endif;
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
} $ThePostsSwiper = PostsSwiper_Singleton::getInstance();
