<?php

/*
 * Template Name: Custom Post
 * Template Post Type: post
 * Description: A custom post type with a custom columns.
 * Version: 1.0
 * Author: Chinmoy Biswas
 */

?>

<div class="wrap">
    <h1 class="wp-heading-inline">Custom Posts</h1>
    <hr class="wp-header-end">
    <form method="get" id="post-filter">
        <input type="hidden" name="page" value="custom-post-column">
        <div class="table-nav top">
            <div class="alignleft actions bulkactions">
                <?php
                $selected_author = isset($_GET['author']) ? $_GET['author'] : 0;
                $selected_cat = isset($_GET['cat']) ? $_GET['cat'] : 0;
                ?>
                <select name="author" id="bulk-action-selector-top">
                    <option <?php selected($selected_author, 0) ?> value="0">All Authors</option>
                    <?php
                    foreach ($authors as $author): ?>
                        <option <?php selected($selected_author, $author->ID) ?> value="<?php echo $author->ID; ?>">
                            <?php echo $author->display_name; ?>
                        </option>
                    <?php endforeach ?>
                </select>
                <select name="cat" id="bulk-action-selector-top">
                    <option <?php selected($selected_cat, 0) ?> value="0">All Categories</option>
                    <?php
                    foreach ($categories as $category): ?>
                        <option <?php selected($selected_cat, $category->term_id) ?>
                            value="<?php echo $category->term_id; ?>"><?php echo $category->name; ?></option>
                    <?php endforeach ?>
                </select>
                <input type="submit" id="doaction" class="button action" value="Apply">
            </div>
        </div>
        <table class="wp-list-table widefat fixed striped table-view-list posts">
            <thead>
                <tr>
                    <th class="column-title">Title</th>
                    <th class="column-author">Author</th>
                    <th class="column-categories">Categories</th>
                    <th class="column-date sorted desc">Date</th>
                </tr>
            </thead>
            <tbody id="the-list">
                <?php
                if (empty($posts)) {
                    echo '<tr><td colspan="4">No posts found.</td></tr>';
                }
                foreach ($posts as $post):
                    $author_name = get_the_author_meta('display_name', $post->post_author);
                    ?>
                    <tr>
                        <td class="title column-title">
                            <strong>
                                <a class="row-title" href="<?php the_permalink(); ?>"><?php echo $post->post_title; ?></a>
                            </strong>
                        </td>
                        <td class="author column-author" data-colname="Author">
                            <?php echo $author_name; ?>
                        </td>
                        <td class="categories column-categories" data-colname="Categories">
                            <?php echo get_the_category_list(', ', '', $post->ID); ?>
                        </td>
                        <td class="date" data-colname="Date">
                            <?php echo ($post->post_status === 'publish') ? 'Published' : ucfirst($post->post_status); ?><br><?php echo date('Y/m/d \a\\t g:i a', strtotime($post->post_date)); ?>
                        </td>
                    </tr>
                    <?php
                endforeach;
                ?>

            </tbody>
            <tfoot>
                <tr>
                    <th scope="col" class="manage-column column-title">Title</th>
                    <th scope="col" class="manage-column column-author">Author</th>
                    <th scope="col" class="manage-column column-categories">Categories</th>
                    <th scope="col" class="manage-column column-date">Date</th>
                </tr>
            </tfoot>
        </table>
    </form>
</div>