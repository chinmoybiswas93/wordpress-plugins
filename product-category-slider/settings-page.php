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

    // Add fields for slider options
    add_settings_field(
        'slides_to_show_desktop',
        'Slides to Show (Desktop)',
        'slides_to_show_desktop_callback',
        'category_slider_settings',
        'category_slider_options_section'
    );

    add_settings_field(
        'slides_to_show_tablet',
        'Slides to Show (Tablet)',
        'slides_to_show_tablet_callback',
        'category_slider_settings',
        'category_slider_options_section'
    );

    add_settings_field(
        'slides_to_show_mobile',
        'Slides to Show (Mobile)',
        'slides_to_show_mobile_callback',
        'category_slider_settings',
        'category_slider_options_section'
    );

    // Add fields for slider options
    add_settings_field(
        'desktop_breakpoint',
        'Desktop Breakpoint',
        'desktop_breakpoint_callback',
        'category_slider_settings',
        'category_slider_options_section'
    );

    add_settings_field(
        'tablet_breakpoint',
        'Tablet Breakpoint',
        'tablet_breakpoint_callback',
        'category_slider_settings',
        'category_slider_options_section'
    );

    add_settings_field(
        'mobile_breakpoint',
        'Mobile Breakpoint',
        'mobile_breakpoint_callback',
        'category_slider_settings',
        'category_slider_options_section'
    );
}
add_action('admin_init', 'category_slider_settings_init');

// Callback function for options section
function category_slider_options_section_callback()
{
    echo 'Configure options for the Category Slider.';
}

// Callback function for slides to show desktop field
function slides_to_show_desktop_callback()
{
    $options = get_option('category_slider_settings');
    $slides_to_show_desktop = isset($options['slides_to_show_desktop']) ? $options['slides_to_show_desktop'] : 3;
    echo '<input type="number" min="1" max="10" name="category_slider_settings[slides_to_show_desktop]" value="' . esc_attr($slides_to_show_desktop) . '" />';
}

// Callback function for slides to show tablet field
function slides_to_show_tablet_callback()
{
    $options = get_option('category_slider_settings');
    $slides_to_show_tablet = isset($options['slides_to_show_tablet']) ? $options['slides_to_show_tablet'] : 2;
    echo '<input type="number" min="1" max="10" name="category_slider_settings[slides_to_show_tablet]" value="' . esc_attr($slides_to_show_tablet) . '" />';
}

// Callback function for slides to show mobile field
function slides_to_show_mobile_callback()
{
    $options = get_option('category_slider_settings');
    $slides_to_show_mobile = isset($options['slides_to_show_mobile']) ? $options['slides_to_show_mobile'] : 1;
    echo '<input type="number" min="1" max="10" name="category_slider_settings[slides_to_show_mobile]" value="' . esc_attr($slides_to_show_mobile) . '" />';
}


// Callback function for desktop breakpoint field
function desktop_breakpoint_callback()
{
    $options = get_option('category_slider_settings');
    $desktop_breakpoint = isset($options['desktop_breakpoint']) ? $options['desktop_breakpoint'] : 1200;
    echo '<input type="number" min="0" name="category_slider_settings[desktop_breakpoint]" value="' . esc_attr($desktop_breakpoint) . '" />';
}

// Callback function for tablet breakpoint field
function tablet_breakpoint_callback()
{
    $options = get_option('category_slider_settings');
    $tablet_breakpoint = isset($options['tablet_breakpoint']) ? $options['tablet_breakpoint'] : 1008;
    echo '<input type="number" min="0" name="category_slider_settings[tablet_breakpoint]" value="' . esc_attr($tablet_breakpoint) . '" />';
}

// Callback function for mobile breakpoint field
function mobile_breakpoint_callback()
{
    $options = get_option('category_slider_settings');
    $mobile_breakpoint = isset($options['mobile_breakpoint']) ? $options['mobile_breakpoint'] : 800;
    echo '<input type="number" min="0" name="category_slider_settings[mobile_breakpoint]" value="' . esc_attr($mobile_breakpoint) . '" />';
}
