<?php
/*
 *  Theme Name: MXM Com
 *  Theme URI: http://www.mxmcom.se
 *  Description: Wordpress by MXM Com
 */

/*------------------------------------*\
  Locale
\*------------------------------------*/
setlocale(LC_ALL, 'sv_SE.UTF-8','sv_SE@euro','sv_SE','swedish');
date_default_timezone_set('Europe/Stockholm');

/*------------------------------------*\
  Utils / Helper functions
\*------------------------------------*/
require_once('lib/utils.php');

/*------------------------------------*\
  External Modules/Files
\*------------------------------------*/

// Load any external files you have here

/*------------------------------------*\
  Theme Support
\*------------------------------------*/


function load_scripts_and_styles() {
    /* LIBRARIES */

    // jQuery
    wp_deregister_script('jquery'); // use our version of jquery
    wp_enqueue_script('jquery', 'https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js', array(), '1.12.4', true);

    // jQuery plugins
    wp_enqueue_script('jquery-mmenu', get_template_directory_uri() . '/mmenu/src/js/jquery.mmenu.min.js', array('jquery'), '', true);
    wp_enqueue_script('jquery-mmenu-offcanvas', get_template_directory_uri() . '/mmenu/src/js/addons/jquery.mmenu.offcanvas.min.js', array('jquery', 'jquery-mmenu'), '', true);
    wp_enqueue_script('jquery-bxslider', get_template_directory_uri() . '/bxslider/jquery.bxslider.min.js', array('jquery'), '', true);
    wp_enqueue_script('jquery-fancybox', get_template_directory_uri() . '/fancybox/source/jquery.fancybox.pack.js', array('jquery'), '2.1.5', true);
    wp_enqueue_script('jquery-fancybox-media', get_template_directory_uri() . '/fancybox/source/helpers/jquery.fancybox-media.js', array('jquery', 'jquery-fancybox'), '1.0.6', true);
    wp_enqueue_script('jquery-waypoint', get_template_directory_uri() . '/waypoint/lib/jquery.waypoints.min.js', array('jquery'), '', true);

    wp_enqueue_style('jquery-mmenu', get_template_directory_uri() . '/mmenu/src/css/jquery.mmenu.css');
    wp_enqueue_style('jquery-mmenu-offcanvas', get_template_directory_uri() . '/mmenu/src/css/addons/jquery.mmenu.offcanvas.css', array('jquery-mmenu'));
    wp_enqueue_style('jquery-mmenu-positioning', get_template_directory_uri() . '/mmenu/src/css/extensions/jquery.mmenu.positioning.css', array('jquery-mmenu'));
    wp_enqueue_style('jquery-bxslider', get_template_directory_uri() . '/bxslider/jquery.bxslider.css');
    wp_enqueue_style('jquery-fancybox', get_template_directory_uri() . '/fancybox/source/jquery.fancybox.css', array(), '2.1.5');


    // Masonry - don't think this is ever used?
    // wp_enqueue_script('masonry', 'https://unpkg.com/masonry-layout@4/dist/masonry.pkgd.min.js', array('jquery'), '', true);

    // Fonts
    wp_enqueue_style('fonts', get_template_directory_uri() . '/fonts/fonts.css');
    wp_enqueue_style('google-fonts', 'https://fonts.googleapis.com/css?family=Creepster|Playfair+Display|Shadows+Into+Light', array());

    // API key for Google Maps, (Get key here: https://developers.google.com/maps/documentation/javascript/get-api-key)
    wp_enqueue_script('googlemaps', 'https://maps.googleapis.com/maps/api/js?key=_KEY_REMOVED_',null,null,true);

    // Bootstrap
    wp_enqueue_script('bootstrap', get_template_directory_uri() . '/bootstrap/js/bootstrap.min.js', array('jquery'), '3.3.7', true);
    wp_enqueue_style('bootstrap', get_template_directory_uri() . '/bootstrap/css/bootstrap.min.css', array(), '3.3.7');
    // wp_enqueue_style('bootstrap-theme', get_template_directory_uri() . '/bootstrap/css/bootstrap-theme.min.css', array(), '3.3.7'); // not neccessary?

    // Add this
    wp_enqueue_script('addthis', '//s7.addthis.com/js/300/addthis_widget.js#pubid=ra-5aa8f975cbf5695c', array(), false, true);

    // Fontawesome
    wp_enqueue_style('font-awesome-fa', 'https://use.fontawesome.com/releases/v5.0.13/css/all.css', array(), '5.0.13');
    wp_enqueue_style('fa-brands', get_template_directory_uri() . '/assets/css/fa-brands.min.css', array('font-awesome-fa'), '5.0.13');

    // Include FormData polyfill for support in IE 11
    wp_enqueue_script('form-data-polyfill', get_template_directory_uri() . '/assets/js/lib/form-data-polyfill.js', array(), '1.0.2', true);

    /* CONDITIONAL SCRIPTS AND STYLES */
    // Booking page - fullcalendar.io and it's dependencies
    if ( is_page_template('template-bokapass.php') ) {
      wp_enqueue_style('fullcalendar', get_template_directory_uri() . '/assets/css/fullcalendar.css', array('bootstrap', 'font-awesome-fa'));
      wp_enqueue_style('fullcalendar-print', 'https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.10.0/fullcalendar.print.css', array(), '3.10.0', 'print');
      wp_enqueue_script('moment', 'https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.24.0/moment.min.js', array(), '2.24.0', true);
      wp_enqueue_script('fullcalendar', 'https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.10.0/fullcalendar.min.js', array('moment', 'jquery', 'bootstrap'), '3.10.0', true);
      wp_enqueue_script('fullcalendar-locale', 'https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.10.0/locale/sv.js', array('fullcalendar'), '3.10.0', true);
    }

    // Bokförlag page or post page with category 'bokforlag'
    if ( is_page_template('template-bokforlag.php') || in_category('bokforlag') ) {
      wp_enqueue_style('book', get_template_directory_uri() . '/book.css', array('bootstrap', 'font-awesome-fa'));
      wp_enqueue_style('google-font-special-elite', 'https://fonts.googleapis.com/css?family=Special+Elite');
    }

    // Load recaptcha script for register forms
    if ( is_page_template( array('template-blivolontar.php', 'template-blilarare.php') ) ) {
      wp_enqueue_script( 'g-captcha', 'https://www.google.com/recaptcha/api.js', array(), '', true );
    }

    /* THEME SCRIPT AND STYLES */
    wp_enqueue_style('mxmcom', get_template_directory_uri() . '/style.css', array(), '1.2', 'all');
    wp_enqueue_style('main', get_template_directory_uri() . '/assets/css/main.css', array('bootstrap'));
    wp_enqueue_script('script', get_template_directory_uri() . '/assets/js/scripts.js', array('jquery'), '', true );

}
add_action( 'wp_enqueue_scripts', 'load_scripts_and_styles' );

// API key for Google Maps

if( function_exists('acf_add_options_page') ) {

    acf_add_options_page(array(
        'page_title'    => 'Allmänt',
        'menu_title'    => 'Allmänt',
    ));

}
function nifty_login_redirect( $redirect_to, $request, $user ){
    global $user;
    if( isset( $user->roles ) && is_array( $user->roles ) ) {
        //check for admins
        if( $user->roles[0] == 'teacher' ) {
            return home_url().'/for-larare';

        } else if( $user->roles[0] == 'volunteer' ) {
            return home_url().'/for-volontarer';
        } else{
          return $redirect_to;
        }
    }
    else {
        return $redirect_to;
    }
}
add_filter("login_redirect", "nifty_login_redirect", 10, 3);
add_filter( 'if_menu_conditions', 'wpb_new_menu_conditions' );

function wpb_new_menu_conditions( $conditions ) {
  $conditions[] = array(
    'name'    =>  'If it is Custom Post Type archive', // name of the condition
    'condition' =>  function($item) {          // callback - must return TRUE or FALSE
      return is_post_type_archive();
    }
  );

  return $conditions;
}
if (!isset($content_width))
{
    $content_width = 900;
}

if (function_exists('add_theme_support'))
{
    // Add Menu Support
    add_theme_support('menus');

    // Add Thumbnail Theme Support
    add_theme_support('post-thumbnails');
    add_image_size('large', 700, '', true); // Large Thumbnail
    add_image_size('medium', 250, '', true); // Medium Thumbnail
    add_image_size('small', 120, '', true); // Small Thumbnail
    add_image_size('custom-size', 700, 200, true); // Custom Thumbnail Size call using the_post_thumbnail('custom-size');

    // Add Support for Custom Backgrounds - Uncomment below if you're going to use
    /*add_theme_support('custom-background', array(
  'default-color' => 'FFF',
  'default-image' => get_template_directory_uri() . '/img/bg.jpg'
    ));*/

    // Add Support for Custom Header - Uncomment below if you're going to use
    /*add_theme_support('custom-header', array(
  'default-image'      => get_template_directory_uri() . '/img/headers/default.jpg',
  'header-text'      => false,
  'default-text-color'    => '000',
  'width'        => 1000,
  'height'      => 198,
  'random-default'    => false,
  'wp-head-callback'    => $wphead_cb,
  'admin-head-callback'    => $adminhead_cb,
  'admin-preview-callback'  => $adminpreview_cb
    ));*/

    // Enables post and comment RSS feed links to head
    add_theme_support('automatic-feed-links');

    // Localisation Support
    load_theme_textdomain('mxmcom', get_template_directory() . '/languages');
}

/*------------------------------------*\
  Functions
\*------------------------------------*/

// HTML5 Blank navigation
function html5blank_nav()
{
  wp_nav_menu(
  array(
    'theme_location'  => 'header-menu',
    'menu'            => '',
    'container'       => 'div',
    'container_class' => 'menu-{menu slug}-container',
    'container_id'    => '',
    'menu_class'      => 'menu',
    'menu_id'         => '',
    'echo'            => true,
    'fallback_cb'     => 'wp_page_menu',
    'before'          => '',
    'after'           => '',
    'link_before'     => '',
    'link_after'      => '',
    'items_wrap'      => '<ul>%3$s</ul>',
    'depth'           => 0,
    'walker'          => ''
    )
  );
}

// Register HTML5 Blank Navigation
function register_html5_menu()
{
    register_nav_menus(array( // Using array to specify more menus if needed
        'header-menu' => __('Header Menu', 'mxmcom'), // Main Navigation
        'sidebar-menu' => __('Sidebar Menu', 'mxmcom'), // Sidebar Navigation
        'extra-menu' => __('Extra Menu', 'mxmcom') // Extra Navigation if needed (duplicate as many as you need!)
    ));
}

// Remove the <div> surrounding the dynamic navigation to cleanup markup
function my_wp_nav_menu_args($args = '')
{
    $args['container'] = false;
    return $args;
}

// Remove Injected classes, ID's and Page ID's from Navigation <li> items
function my_css_attributes_filter($var)
{
    return is_array($var) ? array() : '';
}

// Remove invalid rel attribute values in the categorylist
function remove_category_rel_from_category_list($thelist)
{
    return str_replace('rel="category tag"', 'rel="tag"', $thelist);
}

// Add page slug to body class, love this - Credit: Starkers Wordpress Theme
function add_slug_to_body_class($classes)
{
    global $post;
    if (is_home()) {
        $key = array_search('blog', $classes);
        if ($key > -1) {
            unset($classes[$key]);
        }
    } elseif (is_page()) {
        $classes[] = sanitize_html_class($post->post_name);
    } elseif (is_singular()) {
        $classes[] = sanitize_html_class($post->post_name);
    }

    return $classes;
}

// If Dynamic Sidebar Exists
if (function_exists('register_sidebar'))
{
    // Define Sidebar Widget Area 1
    register_sidebar(array(
        'name' => __('Widget Area 1', 'mxmcom'),
        'description' => __('Description for this widget-area...', 'mxmcom'),
        'id' => 'widget-area-1',
        'before_widget' => '<div id="%1$s" class="%2$s">',
        'after_widget' => '</div>',
        'before_title' => '<h3>',
        'after_title' => '</h3>'
    ));

    // Define Sidebar Widget Area 2
    register_sidebar(array(
        'name' => __('Widget Area 2', 'mxmcom'),
        'description' => __('Description for this widget-area...', 'mxmcom'),
        'id' => 'widget-area-2',
        'before_widget' => '<div id="%1$s" class="%2$s">',
        'after_widget' => '</div>',
        'before_title' => '<h3>',
        'after_title' => '</h3>'
    ));
}

// Remove wp_head() injected Recent Comment styles
function my_remove_recent_comments_style()
{
    global $wp_widget_factory;
    remove_action('wp_head', array(
        $wp_widget_factory->widgets['WP_Widget_Recent_Comments'],
        'recent_comments_style'
    ));
}

// Pagination for paged posts, Page 1, Page 2, Page 3, with Next and Previous Links, No plugin
function html5wp_pagination()
{
    global $wp_query;
    $big = 999999999;
    echo paginate_links(array(
        'base' => str_replace($big, '%#%', get_pagenum_link($big)),
        'format' => '?paged=%#%',
        'current' => max(1, get_query_var('paged')),
        'total' => $wp_query->max_num_pages
    ));
}

function get_excerpt($limit, $source = null){

    if($source == "content" ? ($excerpt = get_the_content()) : ($excerpt = get_the_excerpt()));
    return create_excerpt_from_content($excerpt);

    // $excerpt = preg_replace(" (\[.*?\])",'',$excerpt);
    // $excerpt = strip_shortcodes($excerpt);
    // $excerpt = strip_tags($excerpt);
    // $excerpt = substr($excerpt, 0, $limit);
    // $excerpt = substr($excerpt, 0, strripos($excerpt, " "));
    // $excerpt = trim(preg_replace( '/\s+/', ' ', $excerpt));
    // $excerpt = $excerpt.'...';
    // return $excerpt;
}

function create_excerpt_from_content($limit, $content) {
    $excerpt = preg_replace(" (\[.*?\])",'',$content);
    $excerpt = strip_shortcodes($excerpt);
    $excerpt = strip_tags($excerpt);
    $excerpt = substr($excerpt, 0, $limit);
    $excerpt = substr($excerpt, 0, strripos($excerpt, " "));
    $excerpt = trim(preg_replace( '/\s+/', ' ', $excerpt));
    $excerpt = $excerpt.'...';
    return $excerpt;
}

// Custom Excerpts
function html5wp_index($length) // Create 20 Word Callback for Index page Excerpts, call using html5wp_excerpt('html5wp_index');
{
    return 18;
}

// Create 40 Word Callback for Anpassat inlägg Excerpts, call using html5wp_excerpt('html5wp_custom_post');
function html5wp_custom_post($length)
{
    return 15;
}

// Create the Custom Excerpts callback
function html5wp_excerpt($length_callback = '', $more_callback = '')
{
    global $post;
    if (function_exists($length_callback)) {
        add_filter('excerpt_length', $length_callback);
    }
    if (function_exists($more_callback)) {
        add_filter('excerpt_more', $more_callback);
    }
    $output = get_the_excerpt();
    $output = apply_filters('wptexturize', $output);
    $output = apply_filters('convert_chars', $output);
    $output = '<p>' . $output . '</p>';
    echo $output;
}

// Remove Admin bar
function remove_admin_bar()
{
    return false;
}

// Remove 'text/css' from our enqueued stylesheet
function html5_style_remove($tag)
{
    return preg_replace('~\s+type=["\'][^"\']++["\']~', '', $tag);
}

// Remove thumbnail width and height dimensions that prevent fluid images in the_thumbnail
function remove_thumbnail_dimensions( $html )
{
    $html = preg_replace('/(width|height)=\"\d*\"\s/', "", $html);
    return $html;
}

// Custom Gravatar in Settings > Discussion
function html5blankgravatar ($avatar_defaults)
{
    $myavatar = get_template_directory_uri() . '/img/gravatar.jpg';
    $avatar_defaults[$myavatar] = "Custom Gravatar";
    return $avatar_defaults;
}

// Threaded Comments
function enable_threaded_comments()
{
    if (!is_admin()) {
        if (is_singular() AND comments_open() AND (get_option('thread_comments') == 1)) {
            wp_enqueue_script('comment-reply');
        }
    }
}

// Custom Comments Callback
function html5blankcomments($comment, $args, $depth)
{
  $GLOBALS['comment'] = $comment;
  extract($args, EXTR_SKIP);

  if ( 'div' == $args['style'] ) {
    $tag = 'div';
    $add_below = 'comment';
  } else {
    $tag = 'li';
    $add_below = 'div-comment';
  }
?>
    <!-- heads up: starting < for the html tag (li or div) in the next line: -->
    <<?php echo $tag ?> <?php comment_class(empty( $args['has_children'] ) ? '' : 'parent') ?> id="comment-<?php comment_ID() ?>">
  <?php if ( 'div' != $args['style'] ) : ?>
  <div id="div-comment-<?php comment_ID() ?>" class="comment-body">
  <?php endif; ?>
  <div class="comment-author vcard">
  <?php if ($args['avatar_size'] != 0) echo get_avatar( $comment, $args['180'] ); ?>
  <?php printf(__('<cite class="fn">%s</cite> <span class="says">says:</span>'), get_comment_author_link()) ?>
  </div>
<?php if ($comment->comment_approved == '0') : ?>
  <em class="comment-awaiting-moderation"><?php _e('Your comment is awaiting moderation.') ?></em>
  <br />
<?php endif; ?>

  <div class="comment-meta commentmetadata"><a href="<?php echo htmlspecialchars( get_comment_link( $comment->comment_ID ) ) ?>">
    <?php
      printf( __('%1$s at %2$s'), get_comment_date(),  get_comment_time()) ?></a><?php edit_comment_link(__('(Edit)'),'  ','' );
    ?>
  </div>

  <?php comment_text() ?>

  <div class="reply">
  <?php comment_reply_link(array_merge( $args, array('add_below' => $add_below, 'depth' => $depth, 'max_depth' => $args['max_depth']))) ?>
  </div>
  <?php if ( 'div' != $args['style'] ) : ?>
  </div>
  <?php endif; ?>
<?php }

/*------------------------------------*\
  Actions + Filters + ShortCodes
\*------------------------------------*/

// Add Actions
add_action('get_header', 'enable_threaded_comments'); // Enable Threaded Comments
add_action('init', 'register_html5_menu'); // Add HTML5 Blank Menu
add_action('widgets_init', 'my_remove_recent_comments_style'); // Remove inline Recent Comment Styles from wp_head()
add_action('init', 'html5wp_pagination'); // Add our HTML5 Pagination

// Remove Actions
remove_action('wp_head', 'feed_links_extra', 3); // Display the links to the extra feeds such as category feeds
remove_action('wp_head', 'feed_links', 2); // Display the links to the general feeds: Post and Comment Feed
remove_action('wp_head', 'rsd_link'); // Display the link to the Really Simple Discovery service endpoint, EditURI link
remove_action('wp_head', 'wlwmanifest_link'); // Display the link to the Windows Live Writer manifest file.
remove_action('wp_head', 'index_rel_link'); // Index link
remove_action('wp_head', 'parent_post_rel_link', 10, 0); // Prev link
remove_action('wp_head', 'start_post_rel_link', 10, 0); // Start link
remove_action('wp_head', 'adjacent_posts_rel_link', 10, 0); // Display relational links for the posts adjacent to the current post.
remove_action('wp_head', 'wp_generator'); // Display the XHTML generator that is generated on the wp_head hook, WP version
remove_action('wp_head', 'adjacent_posts_rel_link_wp_head', 10, 0);
remove_action('wp_head', 'rel_canonical');
remove_action('wp_head', 'wp_shortlink_wp_head', 10, 0);

// Add Filters
add_filter('avatar_defaults', 'html5blankgravatar'); // Custom Gravatar in Settings > Discussion
add_filter('body_class', 'add_slug_to_body_class'); // Add slug to body class (Starkers build)
add_filter('widget_text', 'do_shortcode'); // Allow shortcodes in Dynamic Sidebar
add_filter('widget_text', 'shortcode_unautop'); // Remove <p> tags in Dynamic Sidebars (better!)
add_filter('wp_nav_menu_args', 'my_wp_nav_menu_args'); // Remove surrounding <div> from WP Navigation
// add_filter('nav_menu_css_class', 'my_css_attributes_filter', 100, 1); // Remove Navigation <li> injected classes (Commented out by default)
// add_filter('nav_menu_item_id', 'my_css_attributes_filter', 100, 1); // Remove Navigation <li> injected ID (Commented out by default)
// add_filter('page_css_class', 'my_css_attributes_filter', 100, 1); // Remove Navigation <li> Page ID's (Commented out by default)
add_filter('the_category', 'remove_category_rel_from_category_list'); // Remove invalid rel attribute
add_filter('the_excerpt', 'shortcode_unautop'); // Remove auto <p> tags in Excerpt (Manual Excerpts only)
add_filter('the_excerpt', 'do_shortcode'); // Allows Shortcodes to be executed in Excerpt (Manual Excerpts only)
// add_filter('excerpt_more', 'html5_blank_view_article'); // Add 'View Article' button instead of [...] for Excerpts
add_filter('show_admin_bar', 'remove_admin_bar'); // Remove Admin bar
add_filter('style_loader_tag', 'html5_style_remove'); // Remove 'text/css' from enqueued stylesheet
add_filter('post_thumbnail_html', 'remove_thumbnail_dimensions', 10); // Remove width and height dynamic attributes to thumbnails
add_filter('image_send_to_editor', 'remove_thumbnail_dimensions', 10); // Remove width and height dynamic attributes to post images

// Remove Filters
remove_filter('the_excerpt', 'wpautop'); // Remove <p> tags from Excerpt altogether

// Shortcodes
add_shortcode('html5_shortcode_demo', 'html5_shortcode_demo'); // You can place [html5_shortcode_demo] in Pages, Posts now.
add_shortcode('html5_shortcode_demo_2', 'html5_shortcode_demo_2'); // Place [html5_shortcode_demo_2] in Pages, Posts now.

// Shortcodes above would be nested like this -
// [html5_shortcode_demo] [html5_shortcode_demo_2] Here's the page title! [/html5_shortcode_demo_2] [/html5_shortcode_demo]


/*------------------------------------*\
  Customize WP mail
\*------------------------------------*/
/**
 * Filters the contents of the new user notification email sent to the new user.
 * @param array   $wp_new_user_notification_email {
 *   @type string $to      The intended recipient - New user email address.
 *   @type string $subject The subject of the email.
 *   @type string $message The body of the email.
 *   @type string $headers The headers of the email.
 * }
 * @param WP_User $user     User object for new user.
 * @param string  $blogname The site title.
 */
function custom_wp_new_user_notification_email( $wp_new_user_notification_email, $user, $blogname ) {
  $wp_new_user_notification_email['subject'] = sprintf( 'Välkommen till Berättarministeriet, %s!', $user->first_name );
  $wp_new_user_notification_email['message'] .= "\r\nVi ses i utbildningscentret!\r\n\r\nHjärtliga hälsningar,\r\nVännerna på Berättarministeriet";
  return $wp_new_user_notification_email;
}
add_filter( 'wp_new_user_notification_email', 'custom_wp_new_user_notification_email', 10, 3 );

/*------------------------------------*\
  Anpassat inlägg Types
\*------------------------------------*/
include 'lib/custom-post-types.php';

/*------------------------------------*\
  ShortCode Functions
\*------------------------------------*/

// Shortcode Demo with Nested Capability
function html5_shortcode_demo($atts, $content = null)
{
    return '<div class="shortcode-demo">' . do_shortcode($content) . '</div>'; // do_shortcode allows for nested Shortcodes
}

// Shortcode Demo with simple <h2> tag
function html5_shortcode_demo_2($atts, $content = null) // Demo Heading H2 shortcode, allows for nesting within above element. Fully expandable.
{
    return '<h2>' . $content . '</h2>';
}

// Callback function to filter the MCE settings
function my_mce_before_init_insert_formats( $init_array ) {
    // Define the style_formats array
    $style_formats = array(
        // Each array child is a format with it's own settings
        array(
            'title' => 'Stor lila knapp',
            'selector' => 'a',
            'classes' => 'big-button purple'
        ),
    array(
            'title' => 'Stor blå knapp',
            'selector' => 'a',
            'classes' => 'big-button blue'
        ),
    array(
            'title' => 'Stor grön knapp',
            'selector' => 'a',
            'classes' => 'big-button green'
        ),
    array(
            'title' => 'Liten lila knapp',
            'selector' => 'a',
            'classes' => 'small-button purple'
        ),
    array(
            'title' => 'Liten blå knapp',
            'selector' => 'a',
            'classes' => 'small-button blue'
        ),
    array(
            'title' => 'Liten grön knapp',
            'selector' => 'a',
            'classes' => 'small-button green'
        )
    );
    // Insert the array, JSON ENCODED, into 'style_formats'
    $init_array['style_formats'] = json_encode( $style_formats );

    return $init_array;

}
// Attach callback to 'tiny_mce_before_init'
add_filter( 'tiny_mce_before_init', 'my_mce_before_init_insert_formats' );

function getNewsTemplateUrl()
{
    $args = [
        'post_type' => 'page',
        'fields' => 'ids',
        'nopaging' => true,
        'meta_key' => '_wp_page_template',
        'meta_value' => 'template-news-listing.php'
    ];

    $pages = get_posts($args);

    if ($pages) {
        return get_permalink($pages[0]);
    }

    return null;
}

include 'lib/change-password.php';
include 'lib/lost-password.php';

/*
* Logout menu
*/
function html5blank_logout_menu() {

  if(is_user_logged_in()) {

    $user = wp_get_current_user();
    // $user->roles[0] == 'administrator'
    if( $user->roles[0] == 'volunteer' ){
      ?>
      <style>
        nav li.volunteer-loggedin-hide, header.header-nav li.volunteer-loggedin-hide { display: none; }
        nav li.volunteer-logout, header.header-nav li.volunteer-logout { display: block; }
      </style>
      <?php
    } else if ( $user->roles[0] == 'teacher' ) {
      ?>
      <style>
        nav li.teacher-loggedin-hide, header.header-nav li.teacher-loggedin-hide { display: none; }
        nav li.teacher-logout, header.header-nav li.teacher-logout { display: block; }
      </style>
      <?php
    }

  }

}
add_action( 'wp_head', 'html5blank_logout_menu' );

function html5blank_redirect_after_logout(){
  wp_redirect( home_url() );
  exit();
}
add_action('wp_logout','html5blank_redirect_after_logout');

// Redirect to /bokningar if is volunteer and need to book 'grundutbildning'. This is make the registration process smoother: Register > Set password from mail > Login > Land on booking page.
function volunteer_login_without_police_register($user_login, $user) {
  if (in_array('volunteer', $user->roles)) {
    $police_register_date = get_field('user_'.$user->ID, 'sf_police_register_date');
    if (!$police_register_date) {
      if ( wp_redirect('boka-pass') ) {
        exit;
      }
    }
  }
}
add_action('wp_login', 'volunteer_login_without_police_register', 10, 2);

/*------------------------------------*\
  Custom Login Form
\*------------------------------------*/
function login_logo() { ?>
  <style type="text/css">
    #login h1 a, .login h1 a {
      background-image: url(<?php echo get_stylesheet_directory_uri(); ?>/img/logo-black.png);
      height: 42px;
      width: 258px;
      background-size: 258px 42px;
      background-repeat: no-repeat;
    }
  </style>
<?php }
add_action( 'login_enqueue_scripts', 'login_logo' );

function login_logo_url() {
  return home_url();
}
add_filter( 'login_headerurl', 'login_logo_url' );

function login_logo_url_title() {
  return get_bloginfo('name');
}
add_filter( 'login_headertitle', 'login_logo_url_title' );

/*------------------------------------*\
  Keys
\*------------------------------------*/
include 'lib/keys.php';

/*------------------------------------*\
  Error Handler
\*------------------------------------*/
include 'lib/error_handler/error_handler.php';
$error_handler = new errorHandler();

/*------------------------------------*\
  Cache Handler
\*------------------------------------*/
include 'lib/cache-handler/cache-handler.php';
$cache_handler = new CacheHandler();

/*------------------------------------*\
  ReCaptcha Validation
\*------------------------------------*/
include 'lib/recaptcha.php';
$recaptcha = new ReCaptcha($keys['g_captcha_secret']);

/*------------------------------------*\
  Custom Rest Api Endpoints
\*------------------------------------*/
include 'lib/custom-rest-endpoints.php';

/*------------------------------------*\
  Object sync for Salesforce hooks
\*------------------------------------*/
include 'lib/custom-object-sync-for-salesforce.php';

/*------------------------------------*\
  Custom ACF
\*------------------------------------*/
include 'lib/custom-acf.php';
