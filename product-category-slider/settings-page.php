<?php
// Add settings page to dashboard menu
function category_slider_settings_page()
{
    add_submenu_page(
        'options-general.php', // parent menu slug
        'Category Slider Settings', // page title
        'Category Slider Settings', // menu title
        'manage_options', // capability
        'category-slider-settings', // menu slug
        'category_slider_render_settings_page' // callback function to render the settings page
    );
}
add_action('admin_menu', 'category_slider_settings_page');

// Render settings page
function category_slider_render_settings_page()
{
?>
    <div class="wrap">
        <h1>Category Slider Settings</h1>
        <form method="post" action="options.php">
            <?php
            settings_fields('category_slider_settings');
            do_settings_sections('category_slider_settings');
            submit_button('Save Settings');
            ?>
        </form>
    </div>
<?php
}

// Register and define settings
function category_slider_settings_init()
{
    // Register settings group
    register_setting('category_slider_settings', 'category_slider_settings');

    // Add section for slider options
    add_settings_section(
        'category_slider_options_section',
        'Slider Options',
        'category_slider_options_section_callback',
        'category_slider_settings'
    );

    // Define fields for slider options
    $fields = array(
        'slides_to_show_desktop' => 'Slides to Show (Desktop)',
        'slides_to_show_tablet' => 'Slides to Show (Tablet)',
        'slides_to_show_mobile' => 'Slides to Show (Mobile)',
        'desktop_breakpoint' => 'Desktop Breakpoint',
        'tablet_breakpoint' => 'Tablet Breakpoint',
        'mobile_breakpoint' => 'Mobile Breakpoint',
    );

    // Add fields for slider options
    foreach ($fields as $field => $label) {
        add_settings_field(
            $field,
            $label,
            'category_slider_field_callback',
            'category_slider_settings',
            'category_slider_options_section',
            array('field' => $field)
        );
    }
}
add_action('admin_init', 'category_slider_settings_init');

// Callback function for options section
function category_slider_options_section_callback()
{
    echo 'Configure options for the Category Slider.';
}

// Callback function for generating input fields
function category_slider_field_callback($args)
{
    $options = get_option('category_slider_settings');
    $value = isset($options[$args['field']]) ? $options[$args['field']] : '';
    $type = in_array($args['field'], array('slides_to_show_desktop', 'slides_to_show_tablet', 'slides_to_show_mobile')) ? 'number' : 'text';
    $min = in_array($args['field'], array('desktop_breakpoint', 'tablet_breakpoint', 'mobile_breakpoint')) ? 0 : 1;
    $max = in_array($args['field'], array('slides_to_show_desktop', 'slides_to_show_tablet', 'slides_to_show_mobile')) ? 10 : '';
    echo '<input type="' . $type . '" min="' . $min . '" max="' . $max . '" name="category_slider_settings[' . $args['field'] . ']" value="' . esc_attr($value) . '" />';
}
