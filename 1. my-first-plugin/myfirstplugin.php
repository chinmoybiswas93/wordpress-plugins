<?php

/*
 * Plugin Name: My First Plugin
 * Description: First plugin created for testing purposes.
 * Version: 1.0
 * Author: Chinmoy Biswas
 * Author URI: https://chinmoybiswas.com
 * Text Domain: myfirstplugin
 */

class MyFirstPlugin
{
    public function __construct()
    {
        add_action('init', [$this, 'initialize']);
    }

    public function initialize()
    {
        add_filter('the_title', [$this, 'modify_title']);
        add_filter('the_content', [$this, 'modify_content']);
        add_action('wp_enqueue_scripts', [$this, 'enqueue_style']);
    }

    public function modify_title($title)
    {
        $post_id = get_the_ID();
        $type = get_post_type($post_id);

        if ($type === 'post') {
            if (!is_admin() && !is_single()) {
                $post = get_post($post_id);
                $published_time = get_the_time('M j \a\\t g:i a', $post);
                $title .= "<br><span class='mfp-published-time'>{$published_time}</span>";
            }
        }
        return $title;
    }

    public function modify_content($content)
    {
        if (is_single()) {
            $word_count = str_word_count(strip_tags($content));
            $reading_time = ceil($word_count / 200); // Use 200 wpm for reading speed

            $wordcount_display = '<div class="mfp-wordcount">';
            $wordcount_display .= "<p>{$word_count} words</p>";
            $wordcount_display .= "<p>Estimated reading time: {$reading_time} minute" . ($reading_time !== 1 ? 's' : '') . '</p>';
            $wordcount_display .= '</div>';

            return $content . '<br>' . $wordcount_display;
        }
        return $content;
    }

    public function enqueue_style()
    {
        if (is_singular('post')) {
            wp_enqueue_style('myfirstplugin-single-style', plugin_dir_url(__FILE__) . 'css/post-single.css', [], '1.0');
        }
    }
}

new MyFirstPlugin();