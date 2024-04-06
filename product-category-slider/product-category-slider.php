<?php
/*
Plugin Name: WooCommerce Product Category Slider
Description: Display WooCommerce product categories in a slider using Slick Slider. User Shortcode [custom_woo_category_slider]
Version: 1.0
Author: Chinmoy Biswas
*/

// Enqueue scripts and styles
function category_slider_scripts()
{
    // Enqueue jQuery
    wp_enqueue_script('jquery');

    // Enqueue Slick Slider scripts and styles
    wp_enqueue_style('slick-css', plugin_dir_url(__FILE__) . 'assets/slick/slick.css');
    wp_enqueue_script('slick-js', plugin_dir_url(__FILE__) . 'assets/slick/slick.min.js', array('jquery'), '2', true);
    wp_enqueue_style('category-slider-css', plugin_dir_url(__FILE__) . 'assets/style.css');
    wp_enqueue_script('custom-category-slider-js', plugin_dir_url(__FILE__) . 'assets/script.js', array('jquery'), '', true);
}
add_action('wp_enqueue_scripts', 'category_slider_scripts');

// Shortcode to display category slider
function category_slider_shortcode($atts)
{
    ob_start();

    // Retrieve product categories
    $args = array(
        'taxonomy' => 'product_cat',
        'hide_empty' => true,
    );
    $categories = get_terms($args);

    // Include category slider template
    include(plugin_dir_path(__FILE__) . 'template/basic.php');

    return ob_get_clean();
}
add_shortcode('custom_woo_category_slider', 'category_slider_shortcode');

// Include settings page
require_once(plugin_dir_path(__FILE__) . 'settings-page.php');


// AJAX handler to fetch slider settings
add_action('wp_ajax_get_slider_settings', 'get_slider_settings_callback');
function get_slider_settings_callback()
{
    $options = get_option('category_slider_settings');

    // Fetch slider settings
    $slides_to_show_desktop = isset($options['slides_to_show_desktop']) ? $options['slides_to_show_desktop'] : 3;
    $slides_to_show_tablet = isset($options['slides_to_show_tablet']) ? $options['slides_to_show_tablet'] : 2;
    $slides_to_show_mobile = isset($options['slides_to_show_mobile']) ? $options['slides_to_show_mobile'] : 1;
    $desktop_breakpoint = isset($options['desktop_breakpoint']) ? $options['desktop_breakpoint'] : 1200;
    $tablet_breakpoint = isset($options['tablet_breakpoint']) ? $options['tablet_breakpoint'] : 1008;
    $mobile_breakpoint = isset($options['mobile_breakpoint']) ? $options['mobile_breakpoint'] : 800;

    // Return settings as JSON object
    $response = array(
        'slidesToShowDesktop' => $slides_to_show_desktop,
        'slidesToShowTablet' => $slides_to_show_tablet,
        'slidesToShowMobile' => $slides_to_show_mobile,
        'desktopBreakpoint' => $desktop_breakpoint,
        'tabletBreakpoint' => $tablet_breakpoint,
        'mobileBreakpoint' => $mobile_breakpoint
    );

    echo json_encode($response);
    wp_die();
}
