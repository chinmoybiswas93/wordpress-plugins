<?php
/*
 * Plugin Name: Post QR Permalink
 * Description: Post Permalink with QR Code
 * Version: 1.0
 * Author: Chinmoy Biswas
 * Author URI: https://chinmoybiswas.com
 * Text Domain: postqrpermalink
 */

class PostQRPermalink
{
    public function __construct()
    {
        add_action('init', [$this, 'initialize']);
    }

    public function initialize()
    {
        add_filter('the_content', [$this, 'modify_content']);
        add_action('wp_enqueue_scripts', [$this, 'enqueue_style']);
    }

    public function modify_content($content)
    {
        $permalink = get_permalink();

        // Call the Bitly API to shorten the URL
        $short_url = $this->shorten_url($permalink);

        // QR Code display
        $qrdisplay = '<div class="qrcodebox">';
        $qrdisplay .= "<img src='https://api.qrserver.com/v1/create-qr-code/?data={$permalink}' alt='QR Code'>";
        $qrdisplay .= '</div>';

        if (is_single()) {
            // Copy link display
            $copyLinkDisplay = '
            <div class="copy-link-box">
                <input type="text" id="linkToCopy" value="' . esc_url($short_url) . '" readonly>
                <button onclick="copyToClipboard()">Copy Link</button>
            </div>
            <script>
                function copyToClipboard() {
                    var copyText = document.getElementById("linkToCopy");
                    copyText.select();
                    copyText.setSelectionRange(0, 99999); // For mobile devices
                    document.execCommand("copy");
                    alert("Link copied: " + copyText.value);
                }
            </script>
        ';
            return $content . '<br>' . $qrdisplay . '<br>' . $copyLinkDisplay;
        }
        return $content;
    }

    private function shorten_url($url)
    {
        $access_token = 'YOUR_BITLY_ACCESS_TOKEN';
        $api_url = 'https://api-ssl.bitly.com/v4/shorten';

        $args = [
            'headers' => [
                'Authorization' => 'Bearer ' . $access_token,
                'Content-Type' => 'application/json',
            ],
            'body' => json_encode(['long_url' => $url]),
        ];

        $response = wp_remote_post($api_url, $args);
        if (is_wp_error($response)) {
            return $url; // Return the original URL if there was an error
        }

        $response_body = json_decode(wp_remote_retrieve_body($response));
        return isset($response_body->link) ? $response_body->link : $url; // Return the shortened URL or the original if failed
    }

    public function enqueue_style()
    {
        if (is_singular('post')) {
            wp_enqueue_style('postqrpermalink-single-style', plugin_dir_url(__FILE__) . 'css/post-single.css', [], '1.0');
        }
    }
}

new PostQRPermalink();