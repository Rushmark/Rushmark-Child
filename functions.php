<?php
/**
 * Functions
 *
* @package      RushmarkChild
* @author      Chris Clarke
 * @since        1.0.0
 * @license      GPL-2.0+
**/

/*
BEFORE MODIFYING THIS THEME:
Please read the instructions here (private repo): https://github.com/billerickson/rushmark-Starter/wiki
Devs, contact me if you need access
*/

/**
 * Set up the content width value based on the theme's design.
 *
 */
if (! isset($content_width)) {
    $content_width = 768;
}

/**
 * Global enqueues
 *
 * @since  1.0.0
 * @global array $wp_styles
 */
function rushmark_global_enqueues()
{

    // javascript
    if (! rushmark_is_amp()) {
        wp_enqueue_script('rushmark-global', get_stylesheet_directory_uri() . '/assets/js/global-min.js', array( 'jquery' ), filemtime(get_stylesheet_directory() . '/assets/js/global-min.js'), true);
        wp_enqueue_script('rushmark-uikit', get_stylesheet_directory_uri() . '/assets/js/uikit.min.js', array( 'jquery' ));
        wp_enqueue_script('rushmark-uikit-icons', get_stylesheet_directory_uri() . '/assets/js/uikit-icons.min.js', array( 'jquery' ));
    }

    // Move jQuery to footer
    if (! is_admin()) {
        wp_deregister_script('jquery');
        wp_register_script('jquery', includes_url('/js/jquery/jquery.js'), false, null, true);
        wp_enqueue_script('jquery');
    }

    

    // css
    wp_dequeue_style('child-theme');
    wp_enqueue_style('rushmark-fonts', rushmark_theme_fonts_url());
    wp_enqueue_style('rushmark-style', get_stylesheet_directory_uri() . '/assets/css/main.css', array(), filemtime(get_stylesheet_directory() . '/assets/css/main.css'));
    wp_enqueue_style('rushmark-uikit', get_stylesheet_directory_uri() . '/assets/css/uikit.min.css');
}

add_action('wp_enqueue_scripts', 'rushmark_global_enqueues');

/**
 * Gutenberg scripts and styles
 *
 */
function rushmark_gutenberg_scripts()
{
    wp_enqueue_style('rushmark-fonts', rushmark_theme_fonts_url());
    wp_enqueue_script('rushmark-editor', get_stylesheet_directory_uri() . '/assets/js/editor.js', array( 'wp-blocks', 'wp-dom' ), filemtime(get_stylesheet_directory() . '/assets/js/editor.js'), true);
}
add_action('enqueue_block_editor_assets', 'rushmark_gutenberg_scripts');

/**
 * Theme Fonts URL
 *
 */
function rushmark_theme_fonts_url()
{
    return false;
}

/**
 * Theme setup.
 *
 * Attach all of the site-wide functions to the correct hooks and filters. All
 * the functions themselves are defined below this setup function.
 *
 * @since 1.0.0
 */
function rushmark_child_theme_setup()
{
    define('CHILD_THEME_VERSION', filemtime(get_stylesheet_directory() . '/assets/css/main.css'));

    // General cleanup
    include_once(get_stylesheet_directory() . '/inc/wordpress-cleanup.php');
    include_once(get_stylesheet_directory() . '/inc/genesis-changes.php');

    // Theme
    include_once(get_stylesheet_directory() . '/inc/markup.php');
    include_once(get_stylesheet_directory() . '/inc/helper-functions.php');
    include_once(get_stylesheet_directory() . '/inc/layouts.php');
    include_once(get_stylesheet_directory() . '/inc/navigation.php');
    include_once(get_stylesheet_directory() . '/inc/loop.php');
    include_once(get_stylesheet_directory() . '/inc/author-box.php');
    include_once(get_stylesheet_directory() . '/inc/template-tags.php');
    include_once(get_stylesheet_directory() . '/inc/site-footer.php');

    // Editor
    include_once(get_stylesheet_directory() . '/inc/disable-editor.php');
    include_once(get_stylesheet_directory() . '/inc/tinymce.php');

    // Functionality
    include_once(get_stylesheet_directory() . '/inc/login-logo.php');
    include_once(get_stylesheet_directory() . '/inc/block-area.php');
    include_once(get_stylesheet_directory() . '/inc/social-links.php');

    // Plugin Support
    include_once(get_stylesheet_directory() . '/inc/acf.php');
    include_once(get_stylesheet_directory() . '/inc/amp.php');
    include_once(get_stylesheet_directory() . '/inc/shared-counts.php');
    include_once(get_stylesheet_directory() . '/inc/wpforms.php');

    // Editor Styles
    add_theme_support('editor-styles');
    add_editor_style('assets/css/editor-style.css');

    // Image Sizes
    // add_image_size( 'rushmark_featured', 400, 100, true );

    // Gutenberg

    // -- Responsive embeds
    add_theme_support('responsive-embeds');

    // -- Wide Images
    add_theme_support('align-wide');

    // -- Disable custom font sizes
    add_theme_support('disable-custom-font-sizes');

    // -- Editor Font Styles
    add_theme_support('editor-font-sizes', array(
        array(
            'name'      => __('Small', 'rushmark_genesis_child'),
            'shortName' => __('S', 'rushmark_genesis_child'),
            'size'      => 14,
            'slug'      => 'small'
        ),
        array(
            'name'      => __('Normal', 'rushmark_genesis_child'),
            'shortName' => __('M', 'rushmark_genesis_child'),
            'size'      => 20,
            'slug'      => 'normal'
        ),
        array(
            'name'      => __('Large', 'rushmark_genesis_child'),
            'shortName' => __('L', 'rushmark_genesis_child'),
            'size'      => 24,
            'slug'      => 'large'
        ),
    ));

    // -- Disable Custom Colors
    add_theme_support('disable-custom-colors');

    // -- Editor Color Palette
    add_theme_support('editor-color-palette', array(
        array(
            'name'  => __('Blue', 'rushmark_genesis_child'),
            'slug'  => 'blue',
            'color'	=> '#05306F',
        ),
        array(
            'name'  => __('Grey', 'rushmark_genesis_child'),
            'slug'  => 'grey',
            'color' => '#FAFAFA',
        ),
    ));
}
add_action('genesis_setup', 'rushmark_child_theme_setup', 15);

/**
 * Change the comment area text
 *
 * @since  1.0.0
 * @param  array $args
 * @return array
 */
function rushmark_comment_text($args)
{
    $args['title_reply']          = __('Leave A Reply', 'rushmark_genesis_child');
    $args['label_submit']         = __('Post Comment', 'rushmark_genesis_child');
    $args['comment_notes_before'] = '';
    $args['comment_notes_after']  = '';
    return $args;
}
add_filter('comment_form_defaults', 'rushmark_comment_text');


/**
 * Template Hierarchy
 *
 */
function rushmark_template_hierarchy($template)
{
    if (is_home()) {
        $template = get_query_template('archive');
    }
    return $template;
}
add_filter('template_include', 'rushmark_template_hierarchy');
