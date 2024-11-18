<?php
/*
Plugin Name: Vertical Gallery Slider
Description: Shortcode: [vertical_gallery_slider]
Version: 1.0
Author: Chinmoy Biswas
*/

function enqueue_gallery_scripts_styles()
{
  // Enqueue styles with file modification time as version
  wp_enqueue_style('gallery-styles', plugin_dir_url(__FILE__) . 'style.css', array(), filemtime(plugin_dir_path(__FILE__) . 'style.css'));

  // Enqueue scripts with file modification time as version
  wp_enqueue_script('jquery');
  wp_enqueue_script('gallery-script', plugin_dir_url(__FILE__) . 'script.js', array('jquery'), filemtime(plugin_dir_path(__FILE__) . 'script.js'), true);
}

add_action('wp_enqueue_scripts', 'enqueue_gallery_scripts_styles');



function vertical_gallery_slider_shortcode($atts)
{
  ob_start();
  include(plugin_dir_path(__FILE__) . 'gallery-template.php');
  return ob_get_clean();
}
add_shortcode('vertical_gallery_slider', 'vertical_gallery_slider_shortcode');
