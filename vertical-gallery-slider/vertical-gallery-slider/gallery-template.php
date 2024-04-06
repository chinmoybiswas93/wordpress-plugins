<?php
// Retrieve the current post ID
$post_id = get_the_ID();

// Get the featured image URL
$featured_image_url = get_the_post_thumbnail_url($post_id, 'full');

// Get Gallery Images
$gallery_images = get_post_meta(get_the_ID(), 'image-gallery', true);

// Combine the featured image with the ACF gallery images
$image_urls = array_merge([$featured_image_url], $gallery_images);

// Extract only the URLs
$image_urls = array_map(function ($item) {
  if (is_array($item) && isset($item['url'])) {
    return $item['url'];
  }
  return $item;
}, $image_urls);

$arrow_top = '    <div class="arrow top">
<!-- <img src="./icons/arrow-up.png" alt="" srcset="" /> -->
<svg xmlns="http://www.w3.org/2000/svg" height="16" width="16" viewBox="0 0 512 512">
  <!--!Font Awesome Free 6.5.1 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2024 Fonticons, Inc.-->
  <path d="M233.4 105.4c12.5-12.5 32.8-12.5 45.3 0l192 192c12.5 12.5 12.5 32.8 0 45.3s-32.8 12.5-45.3 0L256 173.3 86.6 342.6c-12.5 12.5-32.8 12.5-45.3 0s-12.5-32.8 0-45.3l192-192z" />
</svg>
</div>';

$arrow_bottom = '
<div class="arrow bottom">
  <!-- <img src="./icons/arrow-down.png" alt="" srcset="" /> -->
  <svg xmlns="http://www.w3.org/2000/svg" height="16" width="16" viewBox="0 0 512 512">
    <!--!Font Awesome Free 6.5.1 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2024 Fonticons, Inc.-->
    <path d="M233.4 406.6c12.5 12.5 32.8 12.5 45.3 0l192-192c12.5-12.5 12.5-32.8 0-45.3s-32.8-12.5-45.3 0L256 338.7 86.6 169.4c-12.5-12.5-32.8-12.5-45.3 0s-12.5 32.8 0 45.3l192 192z" />
  </svg>
</div>';

// Output only the URLs
// var_dump($image_urls);
?>

<div id="gallery-container">
  <div id="thumbnail-wrapper">

    <div id="thumbnail-container" class="slider-container">
      <?php echo $arrow_top; ?>
      <div class="slider-wrapper">
        <?php foreach ($image_urls as $index => $image_url) : ?>
          <img class="thumbnail" src="<?php echo esc_url($image_url); ?>" alt="Thumbnail <?php echo esc_attr($index + 1); ?>" />
        <?php endforeach; ?>
      </div>
      <?php echo $arrow_bottom; ?>
    </div>

  </div>
  <div id="preview-container">
    <img id="main-image" src="<?php echo $featured_image_url; ?>" alt="Main Image" />
  </div>
</div>