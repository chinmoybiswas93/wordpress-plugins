<?php

/*
 * Plugin Name: My Custom Post Column
 * Description: Adds a custom column to the post list table.
 * Version: 1.0
 * Author: Chinmoy Biswas
 * Author URI: https://chinmoybiswas.me
 */

class My_Custom_Post_Column
{
    public function __construct()
    {
        add_action('init', array($this, 'initialize'));
    }

    public function initialize()
    {
        add_action('admin_menu', array($this, 'add_menu_page'));
        add_action('admin_enqueue_scripts', function ($hook) {
            if ($hook !== 'toplevel_page_custom-post-column') {
                return;
            }

            wp_enqueue_style('custom-post-column', plugins_url('assets/css/custom-post.css', __FILE__), [], filemtime(plugin_dir_path(__FILE__) . 'assets/css/custom-post.css'));
        });
    }

    public function add_menu_page()
    {
        add_menu_page(
            'Custom Post Column',
            'Custom Post Column',
            'manage_options',
            'custom-post-column',
            array($this, 'menu_page_callback'),
            'dashicons-media-text',
            100
        );
    }

    public function menu_page_callback()
    {
        $authors = array();

        $users = get_users(array(
            'fields' => array('display_name', 'ID')
        ));

        foreach ($users as $user) {
            $user_posts = get_posts(array(
                'author' => $user->ID,
                'post_type' => 'post',
                'numberposts' => 1
            ));

            if (!empty($user_posts)) {
                $authors[] = $user;
            }
        }

        $posts_args = array(
            'post_type' => 'post',
        );

        if (isset($_GET['cat']) && $_GET['cat'] != '0') {
            $posts_args = array(
                'post_type' => 'post',
                'tax_query' => array(
                    array(
                        'taxonomy' => 'category',
                        'field' => 'term_id',
                        'terms' => $_GET['cat']
                    )
                )
            );
        }

        if (isset($_GET['author']) && $_GET['author'] != '0') {
            $posts_args['author'] = $_GET['author'];
        }

        $posts = get_posts($posts_args);

        $categories = get_terms(array(
            'taxonomy' => 'category',
            'hide_empty' => false,
        ));

        // print_r($terms);
        include plugin_dir_path(__FILE__) . 'assets/templates/template-custom-post.php';

    }
}

new My_Custom_Post_Column();
