<?php
// category-slider-template-basic.php

if (!empty($categories)) {
    echo '<div class="category-slider">';
    foreach ($categories as $category) {
        // Get category image URL
        $image = wp_get_attachment_image_src(get_term_meta($category->term_id, 'thumbnail_id', true), 'full');
        $image_url = $image ? $image[0] : '';

        // Get category link
        $category_link = get_term_link($category);

        // Get product count for the category
        $product_count = $category->count;

        // Output category item
        echo '<div class="category-item">';
        // Output category featured image with link
        if ($image_url) {
            echo '<a href="' . esc_url($category_link) . '"><img class="thumbnail" src="' . esc_url($image_url) . '" alt="' . esc_attr($category->name) . '" /></a>';
        }
        // Output category name with link
        echo '<h3 class="title"><a href="' . esc_url($category_link) . '">' . esc_html($category->name) . '</a></h3>';
        // Output product count
        echo '<p class="product-count">' . sprintf(_n('%d Product', '%d Products', $product_count, 'textdomain'), $product_count) . '</p>';
        echo '</div>'; // Close category-item
    }
    echo '</div>';
}
