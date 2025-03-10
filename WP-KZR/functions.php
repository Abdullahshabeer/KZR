<?php
include_once 'inc/post-type-shortcode.php';
include_once 'inc/coustom-post-types.php';
add_theme_support( 'title-tag' );
if (!function_exists('KZR_theme_setup')) {
    /**
     * Sets up theme defaults and registers support for various WordPress features.
     *
     * Note that this function is hooked into the after_setup_theme hook, which
     * runs before the init hook. The init hook is too late for some features, such
     * as indicating support for post thumbnails.
     *
     
     *
     * @return void
     */
    function KZR_theme_setup()
    {
        /*
         * Make theme available for translation.
         * Translations can be filed in the /languages/ directory.
         * If you're building a theme based on Twenty Twenty-One, use a find and replace
         * to change 'KZR' to the name of your theme in all the template files.
         */
        load_theme_textdomain('KZR', get_template_directory() . '/languages');

        // Add default posts and comments RSS feed links to head.
        add_theme_support('automatic-feed-links');

        /*
         * Let WordPress manage the document title.
         * This theme does not use a hard-coded <title> tag in the document head,
         * WordPress will provide it for us.
         */
        add_theme_support('title-tag');

        /**
         * Add post-formats support.
         */
        add_theme_support(
            'post-formats',
            array(
                'link',
                'aside',
                'gallery',
                'image',
                'quote',
                'status',
                'video',
                'audio',
                'chat',
            )
        );

        /*
         * Enable support for Post Thumbnails on posts and pages.
         *
         * @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
         */
        add_theme_support('post-thumbnails');
        set_post_thumbnail_size(1568, 9999);

        register_nav_menus(
            array(
                'primary' => esc_html__('header menu', 'KZR'),
                'footer-bottom-menu' => esc_html__('footer bottom menu', 'KZR'),
                'footermenu' => esc_html__('footer menu', 'KZR'),
                'languagechange' => esc_html__('language changer', 'KZR'), 
                'mobilelanguagechange' => esc_html__('mobile language changer', 'KZR'), 
            )
        );

        /*
         * Switch default core markup for search form, comment form, and comments
         * to output valid HTML5.
         */
        add_theme_support(
            'html5',
            array(
                'comment-form',
                'comment-list',
                'gallery',
                'caption',
                'style',
                'script',
                'navigation-widgets',
            )
        );

        /*
         * Add support for core custom logo.
         *
         * @link https://codex.wordpress.org/Theme_Logo
         */
        add_theme_support(
            'custom-logo',
            array(
                'flex-width' => true,
                'flex-height' => true,
                'unlink-homepage-logo' => true,
            )
        );

        // Add theme support for selective refresh for widgets.
        add_theme_support('customize-selective-refresh-widgets');

        // Add support for Block Styles.
        add_theme_support('wp-block-styles');

        // Add support for full and wide align images.
        add_theme_support('align-wide');
        add_filter('wpcf7_autop_or_not', '__return_false');
        // Add support for editor styles.
        add_theme_support('editor-styles');
        add_post_type_support('page', 'excerpt');
        // Add support for responsive embedded content.
        add_theme_support('responsive-embeds');

        // Add support for custom line height controls.
        add_theme_support('custom-line-height');

        // Add support for experimental link color control.
        add_theme_support('experimental-link-color');

        // Add support for experimental cover block spacing.
        add_theme_support('custom-spacing');

        // Add support for custom units.
        // This was removed in WordPress 5.6 but is still required to properly support WP 5.5.
        add_theme_support('custom-units');

        // Remove feed icon link from legacy RSS widget.
        add_filter('rss_widget_feed_link', '__return_empty_string');
    }
}
add_action('after_setup_theme', 'KZR_theme_setup');

// function cc_mime_types($mimes) {
//     $mimes['svg'] = 'image/svg+xml';
//     return $mimes;
//   }
function custom_mime_types($mimes) {
    $mimes['svg'] = 'image/svg+xml';
    return $mimes;
}
add_filter('upload_mimes', 'custom_mime_types');

// Sanitize SVG before uploading
function sanitize_svg($svg) {
    $svg = simplexml_load_string($svg);
    return $svg->asXML();
}
//   add_filter('upload_mimes', 'cc_mime_types');
//   add_action('wp_ajax_load_categories', 'load_categories');
// add_action('wp_ajax_nopriv_load_categories', 'load_categories');

// function load_categories() {
//     $categories = get_categories();
//     $options = array();

//     foreach ($categories as $category) {
//         $options[] = array(
//             'id' => $category->term_id,
//             'name' => $category->name
//         );
//     }

//     wp_send_json($options);
// }



  function KZR_enqueue_scripts()
{
    
    wp_enqueue_script('jquery');
    wp_enqueue_media();
    wp_enqueue_script('wp-tinymce');
    wp_enqueue_style('owl-carousel-css', get_stylesheet_directory_uri() . '/owl-carousel/assets/owl.carousel.min.css');
    wp_enqueue_style('bootstrap-css', get_stylesheet_directory_uri() . '/css/bootstrap.min.css', array(), '1.0', 'all');
    wp_enqueue_style('datatable-css-table', get_stylesheet_directory_uri() . '/data-table/css/dataTables.css');
    wp_enqueue_style('datatable-css-responsive', get_stylesheet_directory_uri() . '/data-table/css/responsive.dataTables.css');
	  wp_enqueue_style('aos-css', get_stylesheet_directory_uri() . '/css/aos.css', array(), '1.0', 'all');
    wp_enqueue_style('main-css', get_stylesheet_directory_uri() . '/style.css', array(), '1.0', 'all');
    wp_enqueue_style('admin-css', get_stylesheet_directory_uri() . '/css/admin.css', array(), '1.0', 'all');
    wp_enqueue_script('bootstrap-script', get_stylesheet_directory_uri() . '/js/bootstrap.bundle.min.js', '1.0', true);
    wp_enqueue_script('owl-carousel-script', get_stylesheet_directory_uri() . '/owl-carousel/owl.carousel.min.js',  '1.0', true);
    wp_enqueue_script('datatable-script-table', get_stylesheet_directory_uri() . '/data-table/js/dataTables.js',);
    wp_enqueue_script('datatable-script-responsive', get_stylesheet_directory_uri() . '/data-table/js/dataTables.responsive.js',);
    wp_enqueue_script('datatable-script-dataTables', get_stylesheet_directory_uri() . '/data-table/js/responsive.dataTables.js',);
	  wp_enqueue_script('aos-script', get_stylesheet_directory_uri() . '/js/aos.js', '1.0', true);
    wp_register_script('custom-script', get_stylesheet_directory_uri() . '/js/scripts.js', array('jquery'), '1.0', true);
    wp_enqueue_script('custom-script');
    wp_enqueue_script('admin-script', get_stylesheet_directory_uri() . '/js/admin.js',);
    wp_localize_script('admin-script', 'ajax_params', array(
        'ajax_url' => admin_url('admin-ajax.php')
    ));
    
    wp_localize_script('admin-script', 'myScriptData', array(
        'siteUrl' => get_site_url(),
    ));
	  
	  // Localize the script with PHP data
    wp_localize_script('owl-carousel-script', 'carouselLabels', array(
        'prevLabel' => __('poprzedni slajd', 'kzr'),
        'nextLabel' => __('następny slajd', 'kzr'),
    ));
    wp_localize_script('custom-script', 'ajax_object', array(
        'ajax_url'      => admin_url('admin-ajax.php'),
        'ajax_nonce'    => wp_create_nonce('my_ajax_nonce'),
    ));
	wp_localize_script('custom-script', 'localizedStrings', array(
    	'clickToCall' 	=> __('kliknij aby zadzwonić', 'kzr'),
    	'clickToEmail' 	=> __('kliknij by wysłać mejla', 'kzr'),
		'ExternalLink'	=> __('link zewnętrzny', 'kzr'),
		'BlankLink'		=> __('link otworzy się w nowej karcie', 'kzr'),
));
}

add_action('wp_enqueue_scripts', 'KZR_enqueue_scripts');
function KZR_admin_enqueue()
{
    $current_screen = get_current_screen();
    wp_enqueue_media();
    // Check if we are on the Gutenberg editor screen
    if ($current_screen && 'post' === $current_screen->base && post_type_supports($current_screen->post_type, 'editor')) {
    wp_enqueue_script('jquery');
    
    wp_enqueue_style('owl-carousel-css', get_stylesheet_directory_uri() . '/owl-carousel/assets/owl.carousel.min.css');
    wp_enqueue_style('bootstrap-css', get_stylesheet_directory_uri() . '/css/bootstrap.min.css', array(), '1.0', 'all');
    wp_enqueue_style('datatable-css-table', get_stylesheet_directory_uri() . '/data-table/css/dataTables.css');
    wp_enqueue_style('datatable-css-responsive', get_stylesheet_directory_uri() . '/data-table/css/responsive.dataTables.css');
    wp_enqueue_style('main-css', get_stylesheet_directory_uri() . '/style.css', array(), '1.0', 'all');
    wp_enqueue_style('admin-css', get_stylesheet_directory_uri() . '/css/admin.css', array(), '1.0', 'all');
    wp_enqueue_script('datatable-script-table', get_stylesheet_directory_uri() . '/data-table/js/dataTables.js',);
    wp_enqueue_script('datatable-script-responsive', get_stylesheet_directory_uri() . '/data-table/js/dataTables.responsive.js',);
    wp_enqueue_script('datatable-script-dataTables', get_stylesheet_directory_uri() . '/data-table/js/responsive.dataTables.js',);
    wp_enqueue_script('bootstrap-script', get_stylesheet_directory_uri() . '/js/bootstrap.min.js', '1.0', true);
    wp_enqueue_script('owl-carousel-script', get_stylesheet_directory_uri() . '/owl-carousel/owl.carousel.min.js',  '1.0', true);
    wp_enqueue_script('custom-script', get_stylesheet_directory_uri() . '/js/scripts.js',);
    
    }
    wp_enqueue_script('wp-tinymce');
    wp_enqueue_script('admin-script', get_stylesheet_directory_uri() . '/js/admin.js',);
}
add_action('admin_enqueue_scripts', 'KZR_admin_enqueue');
function kzr_customize_register( $wp_customize ) {

    $wp_customize->add_section( 'login_register_button', array(
        'title'       => __( 'Registration button ', 'kzr' ),
        'description' => __( 'Registration content', 'kzr' ),
        'priority'    => 40,
    ) );

    
    $wp_customize->add_setting( 'Registration_text', array(
        'default'   => '',
        'transport' => 'refresh',
    ) );

    // Registration Text Control
    $wp_customize->add_control( 'Registration_text_control', array(
        'label'    => __( 'Registration Text', 'kzr' ),
        'section'  => 'login_register_button',
        'settings' => 'Registration_text',
        'type'     => 'text',
    ) );

    // Registration URL Setting
    $wp_customize->add_setting( 'Registration_url', array(
        'default'   => '',
        'transport' => 'refresh',
    ) );

    // Registration URL Control
    $wp_customize->add_control( 'Registration_url_control', array(
        'label'    => __( 'Registration URL', 'kzr' ),
        'section'  => 'login_register_button',
        'settings' => 'Registration_url',
        'type'     => 'text',
    ) );


// Social Media 1 Link Setting
$wp_customize->add_setting( 'Registration_url', array(
    'default'   => '',
    'transport' => 'refresh',
) );

// Social Media 1 Link Control
$wp_customize->add_control( 'Registration_url_control', array(
    'label'    => __( 'Registratrion url ', 'kzr' ),
    'section'  => 'login_register_button',
    'settings' => 'Registration_url',
    'type'     => 'text',
) );

}
add_action( 'customize_register', 'kzr_customize_register' );

function kzr_register_customizer_string_for_wpml() {
    // Check if WPML is active
    if ( function_exists( 'icl_register_string' ) ) {
        // Registration Text
        $registration_text = get_theme_mod( 'Registration_text', '' );
        if ( $registration_text ) {
            do_action( 'wpml_register_string', 'Theme Customizer', 'Registration_text', $registration_text );
        }

        // Registration URL (optional, if you want this translated as well)
        $registration_url = get_theme_mod( 'Registration_url', '' );
        if ( $registration_url ) {
            do_action( 'wpml_register_string', 'Theme Customizer', 'Registration_url', $registration_url );
        }
    }
}
add_action( 'wpml_loaded', 'kzr_register_customizer_string_for_wpml' );


function theme_footer_widgets_init()
{
    register_sidebar(
        array(
            'name' => __(' Footer Contact', 'KZR'),
            'id' => 'footer-sidebar',
            'description' => __('Widgets added here will appear in the footer.', 'KZR'),
            'before_widget' => '<div id="%1$s" class="widget %2$s">',
            'after_widget' => '</div>',
            'before_title' => '<h3 class="widget-title">',
            'after_title' => '</h3>',
        )
    );
    register_sidebar(
        array(
            'name' => __('Footer map', 'KZR'),
            'id' => 'footer-sidebar-2',
            'description' => __('Widgets added here will appear in the footer.', 'KZR'),
            'before_widget' => '<div id="%1$s" class="widget %2$s">',
            'after_widget' => '</div>',
            'before_title' => '<h3 class="widget-title">',
            'after_title' => '</h3>',
        )
    );
    register_sidebar(
        array(
            'name' => __('search info', 'KZR'),
            'id' => 'search-sidebar',
            'description' => __('Widgets added here will appear in the footer.', 'KZR'),
            'before_widget' => '<div id="%1$s" class="widget %2$s">',
            'after_widget' => '</div>',
            'before_title' => '<h3 class="widget-title">',
            'after_title' => '</h3>',
        )
    );
   
}

add_action('widgets_init', 'theme_footer_widgets_init');

function custom_search_filter($query) {
    if (!is_admin() && $query->is_search && $query->is_main_query()) {
        // Check if category is set and filter by it
        if (isset($_GET['category']) && !empty($_GET['category'])) {
            $query->set('cat', sanitize_text_field($_GET['category']));
        }

        // Initialize date_query if it is not already set
        $date_query = array();

        // Check if date_from is set and filter by it
        if (isset($_GET['date_from']) && !empty($_GET['date_from'])) {
            $date_query[] = array(
                'after' => sanitize_text_field($_GET['date_from']),
                'inclusive' => true,
            );
        }

        // Check if date_to is set and filter by it
        if (isset($_GET['date_to']) && !empty($_GET['date_to'])) {
            $date_query[] = array(
                'before' => sanitize_text_field($_GET['date_to']),
                'inclusive' => true,
            );
        }

        // Set the date_query if there are date filters
        if (!empty($date_query)) {
            $query->set('date_query', $date_query);
        }

        // Set the number of results per page
        if (isset($_GET['results_per_page']) && !empty($_GET['results_per_page'])) {
            $query->set('posts_per_page', intval($_GET['results_per_page']));
        }
    }
}

add_action('pre_get_posts', 'custom_search_filter');
function custom_breadcrumbs() {
    // Set the breadcrumbs home text
    $home_text = __('Strona główna', 'KZR');
    $separator = '  ';
    $breadcrumb_output = '<div class="bread-crumbs"><ul>';
    global $post;
    // Add the home link
    $breadcrumb_output .= '<li><a href="' . home_url() . '">' . $home_text . '</a></li>';

    if (is_category() || is_single()) {
        $breadcrumb_output .= $separator;
        $categories = get_the_category();
        if ($categories) {
            $category = $categories[0];
            $breadcrumb_output .= '<li><a href="' . get_category_link($category->term_id) . '">' . $category->name . '</a></li>';
        }
        if (is_single()) {
            $breadcrumb_output .= $separator . '<li><span>' . get_the_title() . '</span></li>';
        }
    } elseif (is_page()) {
        if ($post->post_parent) {
            $parent_id  = $post->post_parent;
            $breadcrumbs = array();
            
            // Loop through all parents
            while ($parent_id) {
                $parent = get_post($parent_id);
                $breadcrumbs[] = '<li><a href="' . get_permalink($parent->ID) . '">' . get_the_title($parent->ID) . '</a></li>';
                $parent_id = $parent->post_parent;
            }

            // Reverse the order to show from root parent to immediate parent
            $breadcrumbs = array_reverse($breadcrumbs);

            // Add the parents to the output
            foreach ($breadcrumbs as $crumb) {
                $breadcrumb_output .= $separator . $crumb;
            }
        }

        // Add the current page title at the end
        $breadcrumb_output .=  $separator . '<li><span>' . get_the_title() . '</span></li>';
    } elseif (is_search()) {
        $breadcrumb_output .= $separator . '<li><span>' . __('Wyniki wyszukiwania dla „', 'KZR') . get_search_query() . '”</span></li>';
    } elseif (is_tag()) {
        $breadcrumb_output .= $separator . '<li><span>Tag: „' . single_tag_title('', false) . '”</span></li>';
    } elseif (is_day()) {
        $breadcrumb_output .= $separator . '<li><a href="' . get_year_link(get_the_time('Y')) . '">' . get_the_time('Y') . '</a></li>';
        $breadcrumb_output .= $separator . '<li><a href="' . get_month_link(get_the_time('Y'), get_the_time('m')) . '">' . get_the_time('F') . '</a></li>';
        $breadcrumb_output .= $separator . '<li><span>' . get_the_time('d') . '</span></li>';
    } elseif (is_month()) {
        $breadcrumb_output .= $separator . '<li><a href="' . get_year_link(get_the_time('Y')) . '">' . get_the_time('Y') . '</a></li>';
        $breadcrumb_output .= $separator . '<li><span>' . get_the_time('F') . '</span></li>';
    } elseif (is_year()) {
        $breadcrumb_output .= $separator . '<li><span>' . get_the_time('Y') . '</span></li>';
    } elseif (is_author()) {
        $breadcrumb_output .= $separator . '<li><span>Autor: ' . get_the_author() . '</span></li>';
    } elseif (is_404()) {
        $breadcrumb_output .= $separator . '<li><span>404 - Strona nie znaleziona</span></li>';
    }

    $breadcrumb_output .= '</ul></div>';

    echo $breadcrumb_output;
}

function custom_add_meta_box() {
    add_meta_box(
        'custom_icon_meta_box', // ID
        'Icon Settings', // Title
        'custom_icon_meta_box_callback', // Callback
        'page', // Screen (post type)
        'side', // Context
        'high' // Priority
    );
}
add_action('add_meta_boxes', 'custom_add_meta_box');

function custom_icon_meta_box_callback($post) {
    // Retrieve current values
    $icon_url = get_post_meta($post->ID, '_custom_icon_url', true);
    $show_icon = get_post_meta($post->ID, '_custom_show_icon', true);

    // Nonce field for security
    wp_nonce_field('custom_icon_meta_box', 'custom_icon_meta_box_nonce');

    // Icon preview
    if ($icon_url) {
        echo '<p><img id="custom_icon_preview" src="' . esc_url($icon_url) . '" style="max-width:100%; height:auto;" /></p>';
    } else {
        echo '<p><img id="custom_icon_preview" src="" style="display:none; max-width:100%; height:auto;" /></p>';
    }

    // Icon URL field (hidden)
    echo '<input type="hidden" id="custom_icon_url" name="custom_icon_url" value="' . esc_attr($icon_url) . '" />';

    // Upload button
    echo '<input type="button" id="custom_icon_upload_button" class="button" value="Upload Icon" />';

    // Remove button (only show if an icon is set)
    if ($icon_url) {
        echo '<input type="button" id="custom_icon_remove_button" class="button" value="Remove Icon" />';
    } else {
        echo '<input type="button" id="custom_icon_remove_button" class="button" value="Remove Icon" style="display:none;" />';
    }

    // Show Icon checkbox
    echo '<p class="margin"><label for="custom_show_icon">Show Icon:</label></p>';
    echo '<input type="checkbox" id="custom_show_icon" name="custom_show_icon" value="1" ' . checked($show_icon, 1, false) . ' /> Yes';
}


function custom_save_meta_box_data($post_id) {
    if (!isset($_POST['custom_icon_meta_box_nonce']) || !wp_verify_nonce($_POST['custom_icon_meta_box_nonce'], 'custom_icon_meta_box')) {
        return;
    }

    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
        return;
    }

    if (!current_user_can('edit_post', $post_id)) {
        return;
    }

    if (isset($_POST['custom_icon_url'])) {
        update_post_meta($post_id, '_custom_icon_url', sanitize_text_field($_POST['custom_icon_url']));
    }

    $show_icon = isset($_POST['custom_show_icon']) ? 1 : 0;
    update_post_meta($post_id, '_custom_show_icon', $show_icon);
}
add_action('save_post', 'custom_save_meta_box_data');


// Add a custom field to menu items
function add_menu_icon_upload_field($item_id, $item, $depth, $args) {
    // Retrieve the existing icon URL if it exists
    $icon_url = get_post_meta($item_id, '_cutstom_icon_url', true);
    ?>
    <p class="description description-wide">
        <label for="edit-menu-item-icon-<?php echo esc_attr($item_id); ?>" style="display: block; width: 100%;">
            <?php _e('SVG Icon Code', 'KZR'); ?><br>
            <input type="button" class="button button-secondary upload-icon-button" value="<?php _e('Upload Icon', 'KZR'); ?>" />
			<!-- <textarea style="width: 100%;" id="edit-menu-item-icon-<?php echo esc_attr($item_id); ?>" name="menu-item-icon[<?php echo esc_attr($item_id); ?>]"><?php echo esc_attr($icon_url); ?></textarea> -->
            <input type="hidden" id="edit-menu-item-icon-<?php echo esc_attr($item_id); ?>" name="menu-item-icon[<?php echo esc_attr($item_id); ?>]" value="<?php echo esc_attr($icon_url); ?>" />
            <img src="<?php echo esc_url($icon_url); ?>" alt="<?php _e('Icon Preview', 'KZR'); ?>" style="max-width: 100px; display: <?php echo $icon_url ? 'block' : 'none'; ?>;" />
        </label>
    </p>
    <?php
}
add_action('wp_nav_menu_item_custom_fields', 'add_menu_icon_upload_field', 10, 4);

// Save the custom field value
function save_menu_icon_upload_field($menu_id, $menu_item_db_id, $args) {
    if (isset($_POST['menu-item-icon'][$menu_item_db_id])) {
        $icon_url = $_POST['menu-item-icon'][$menu_item_db_id];
        update_post_meta($menu_item_db_id, '_cutstom_icon_url', $icon_url);
    } else {
        delete_post_meta($menu_item_db_id, '_cutstom_icon_url');
    }
}
add_action('wp_update_nav_menu_item', 'save_menu_icon_upload_field', 10, 3);

// Add image upload field to the add new term page
function add_category_image_field() {
    ?>
    <div class="form-field">
        <label for="category-image"><?php _e('Category Image', 'text-domain'); ?></label>
        <input type="text" name="category_image" id="category-image" value="" class="category-image-url">
        <button class="upload-category-image button"><?php _e('Upload Image', 'text-domain'); ?></button>
    </div>
    <?php
}
add_action('category_add_form_fields', 'add_category_image_field');

// Add image upload field to the edit term page
function edit_category_image_field($term) {
    $category_image = get_term_meta($term->term_id, 'category_image', true);
    ?>
    <tr class="form-field">
        <th scope="row" valign="top"><label for="category-image"><?php _e('Category Image', 'text-domain'); ?></label></th>
        <td>
            <input type="text" name="category_image" id="category-image" value="<?php echo esc_attr($category_image); ?>" class="category-image-url">
            <button class="upload-category-image button"><?php _e('Upload Image', 'text-domain'); ?></button>
            <p class="description"><?php _e('Upload an image for this category.', 'text-domain'); ?></p>
        </td>
    </tr>
    <?php
}
add_action('category_edit_form_fields', 'edit_category_image_field');

// Enqueue the media uploader script and add JS to handle image upload


// Save the category image
function save_category_image($term_id) {
    if (isset($_POST['category_image']) && '' !== $_POST['category_image']) {
        update_term_meta($term_id, 'category_image', sanitize_text_field($_POST['category_image']));
    } else {
        delete_term_meta($term_id, 'category_image');
    }
}
add_action('created_category', 'save_category_image');
add_action('edited_category', 'save_category_image');
// function populate_categories_select() {
//     // Fetch all categories
//     $categories = get_categories();
    
//     // Start the output buffer
//     ob_start();
    
//     // Create the <select> element
//     echo '<select name="menu-497" id="form-consultation" class="wpcf7-form-control wpcf7-select wpcf7-validates-as-required form-select">';
//     echo '<option value="">Wybierz temat</option>'; // Default option
    
//     // Loop through categories and add them as <option> elements
//     foreach ( $categories as $category ) {
//         echo '<option value="' . esc_attr( $category->term_id ) . '">' . esc_html( $category->name ) . '</option>';
//     }
    
//     echo '</select>';
    
//     // Return the buffered content
//     return ob_get_clean();
// }
// add_shortcode('category_select', 'populate_categories_select');



add_filter('wpcf7_form_elements', 'populate_categories_in_select');

function populate_categories_in_select($content) {
   
    // Check if this is the specific form you want to modify
    if (strpos($content, 'name="menu-497"' ) !== false) {
        // Fetch all categories
        $categories = get_categories();

        // Initialize options
        $options = '<option value="">Wybierz temat</option>';

        // Build options
        foreach ($categories as $category) {
            $options .= '<option value="' . esc_attr($category->term_id) . '">' . esc_html($category->name) . '</option>';
        }

        // Replace the placeholder with the new options
        $pattern = '/<select[^>]*name="menu-497"[^>]*>.*?<\/select>/s';
        $replacement = '<select id="form-consultation" class="form-select" name="menu-497">' . $options . '</select>';
        $content = preg_replace($pattern, $replacement, $content);

       
    }
    return $content;
}

// function custom_pagination_rewrite_rules($rules) {
//     $new_rules = array(
//         'certyfikacja/wydane-certyfikaty/page/([0-9]+)/per-page/([0-9]+)/?$' => 'index.php?pagename=certyfikacja/wydane-certyfikaty&paged=$matches[1]&per_page=$matches[2]',
//     );
//     return $new_rules + $rules;
// }
// add_filter('rewrite_rules_array', 'custom_pagination_rewrite_rules');

// function custom_query_vars($vars) {
//     $vars[] = 'per_page';
//     return $vars;
// }
// add_filter('query_vars', 'custom_query_vars');


function create_certificates_post_type() {
    register_post_type('certificates',
        array(
            'labels' => array(
                'name' => __('Certificates'),
                'singular_name' => __('Certificate')
            ),
            'public' => true,
            'has_archive' => true,
            'supports' => array('title', 'editor'),
        )
    );
}
add_action('init', 'create_certificates_post_type');



function fetch_certificates_data($token) {
    header("Content-Type: application/json");
    $apiUrl = "https://bok-kzr.inig.pl/websrv/app/getkzrcertinfo?token=".$token."&pagesize=100000&status_certyfikatu=1&pageno=1&sort_nazwa_firmy=asc";
    $certificates = file_get_contents($apiUrl);
    $certificates = trim($certificates, "\xEF\xBB\xBF");
    $certificates = json_decode($certificates, true);
   
    return $certificates;
}


// function import_certificates($token) {
//     // Step 1: Fetch certificates from API
//     $certificates = fetch_certificates_data($token);

//     if (!$certificates) {
//         error_log("Failed to fetch or decode API data.");
//         return; // Stop further execution
//     }

//     // Step 2: Prepare for batch processing
//     $batch_size = 500; // Process 500 certificates at a time
//     $total_certificates = count($certificates);
//     $batches = array_chunk($certificates, $batch_size);

//     foreach ($batches as $batch_index => $batch) {
//         error_log("Processing batch " . ($batch_index + 1) . " of " . ceil($total_certificates / $batch_size));

//         foreach ($batch as $cert) {
//             $nip = strtolower(trim($cert['nip']));
//             $title = trim($cert['nr_certyfikatu']); // Normalize the title

//             // Step 3: Check for existing posts by NIP or title and delete them
//             // $existing_posts = get_posts(array(
//             //     'post_type'   => 'certificates',
//             //     'meta_query'  => array(
//             //         'relation' => 'OR', // Match if either NIP or Title matches
//             //         // array(
//             //         //     'key'   => 'nip',
//             //         //     'value' => $nip,
//             //         //     'compare' => '=',
//             //         // ),
//             //         array(
//             //             'key'   => 'nr_certyfikatu',
//             //             'value' => $title,
//             //             'compare' => '=',
//             //         ),
//             //     ),
//             //     'numberposts' => -1, // Fetch all matching posts
//             //     'fields'      => 'ids', // Get only the IDs for performance
//             // ));

//             // if (!empty($existing_posts)) {
//                 // Delete all duplicate posts
//                 foreach ($existing_posts as $post_id) {
//                     wp_delete_post($post_id, true); // Permanently delete
//                 }
//             // }

//             // Step 4: Insert new post
//             $post_id = wp_insert_post(array(
//                 'post_title'   => $title,
//                 'post_content' => $cert['zakres'],
//                 'post_type'    => 'certificates',
//                 'post_status'  => 'publish',
//             ));

//             // Step 5: Add meta fields
//             if ($post_id) {
//                 update_post_meta($post_id, 'nr_certyfikatu', $title);
//                 update_post_meta($post_id, 'nr_uczestnika', $cert['nr_uczestnika']);
//                 update_post_meta($post_id, 'nazwa_firmy', $cert['nazwa_firmy']);
//                 update_post_meta($post_id, 'adres_firmy', $cert['adres_firmy']);
//                 update_post_meta($post_id, 'wazny_od', $cert['wazny_od']);
//                 update_post_meta($post_id, 'wazny_do', $cert['wazny_do']);
//                 update_post_meta($post_id, 'nip', $nip);
//                 update_post_meta($post_id, 'zakres', $cert['zakres']);
//                 update_post_meta($post_id, 'uwagi', $cert['uwagi']);
//                 update_post_meta($post_id, 'jednostka_certyfikujaca', $cert['jednostka_certyfikujaca']);
//                 update_post_meta($post_id, 'status_certyfikatu', $cert['status_certyfikatu']);
//                 update_post_meta($post_id, 'plik_certyfikat', $cert['plik_certyfikat']);
//                 update_post_meta($post_id, 'plik_raport', $cert['plik_raport']);
//                 update_post_meta($post_id, 'obszary', $cert['obszary']);
//                 update_post_meta($post_id, 'lista_lokalizacji', $cert['lista_lokalizacji']);
//             }
//         }

//         // Optional: Add a delay between batches to reduce server load
//         sleep(8); // Pause for 8 seconds
//     }
// }
function import_certificates($token) {
    // Fetch certificates from API
    $certificates = fetch_certificates_data($token);
   

    global $wpdb;
    $post_type = 'certificates';

    // Bulk delete posts and related data
    $wpdb->query(
        $wpdb->prepare("DELETE FROM {$wpdb->posts} WHERE post_type = %s", $post_type)
    );
    $wpdb->query(
        $wpdb->prepare(
            "DELETE pm FROM {$wpdb->postmeta} pm
            INNER JOIN {$wpdb->posts} p ON p.ID = pm.post_id
            WHERE p.post_type = %s",
            $post_type
        )
    );
    $wpdb->query(
        $wpdb->prepare(
            "DELETE tr FROM {$wpdb->term_relationships} tr
            INNER JOIN {$wpdb->posts} p ON p.ID = tr.object_id
            WHERE p.post_type = %s",
            $post_type
        )
    );

    // Batch Insert Posts
    $insert_posts = [];
    $insert_meta = [];
    $current_time = current_time('mysql');

    foreach ($certificates as $index => $cert) {
        $post_title = sanitize_text_field($cert['nr_certyfikatu']);
        $post_content = sanitize_textarea_field(json_encode($cert['lista_lokalizacji'], JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));


        // Generate a slightly different post_date
        $post_date = date('Y-m-d H:i:s', strtotime($current_time) + $index);

        $insert_posts[] = $wpdb->prepare(
            "(%s, %s, %s, %s, %s, %s, %s, %s)",
            $post_title,
            $post_content,
            $post_type,
            'publish',
            $post_date,
            $post_date, // post_date_gmt
            'open',     // comment_status
            'open'      // ping_status
        );

        // Post meta mapping
        $meta_keys = [
            'nr_certyfikatu', 'nr_uczestnika', 'nazwa_firmy', 'adres_firmy', 'wazny_od',
            'wazny_do', 'nip', 'zakres','zakres_en', 'uwagi','uwagi_en', 'jednostka_certyfikujaca', 'status_certyfikatu',
            'plik_certyfikat', 'plik_raport', 'obszary','obszary_en', 'lista_lokalizacji'
        ];
        
        foreach ($meta_keys as $key) {
            if (!empty($cert[$key])) {
                // Handle lista_lokalizacji separately as JSON
                $meta_value = $key === 'lista_lokalizacji'
                    ? json_encode($cert[$key], JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE)
                    : sanitize_text_field($cert[$key]);
    
                $insert_meta[] = [
                    'meta_key' => $key,
                    'meta_value' => $meta_value,
                    'placeholder_post' => $index // Temporary mapping for post_id
                ];
            }
        }

        // foreach ($meta_keys as $key) {
        //     if (!empty($cert[$key])) {
        //         $insert_meta[] = [
        //             'meta_key'   => $key,
        //             'meta_value' => sanitize_text_field($cert[$key]),
        //             'placeholder_post' => $index // Temporary mapping for post_id
        //         ];
        //     }
        // }
    }

    if (!empty($insert_posts)) {
        // Insert Posts
        $insert_posts_query = "INSERT INTO {$wpdb->posts} 
            (post_title, post_content, post_type, post_status, post_date, post_date_gmt, comment_status, ping_status) 
            VALUES " . implode(', ', $insert_posts);

        $wpdb->query($insert_posts_query);

        // Get inserted post IDs
        $inserted_post_ids = $wpdb->get_results(
            $wpdb->prepare("SELECT ID FROM {$wpdb->posts} WHERE post_type = %s ORDER BY ID DESC LIMIT %d", $post_type, count($insert_posts)),
            ARRAY_A
        );

        $id_map = array_reverse($inserted_post_ids); // Map to meta placeholders

        // Map placeholder_post to actual post IDs
        foreach ($insert_meta as &$meta) {
            $meta['post_id'] = $id_map[$meta['placeholder_post']]['ID'];
            unset($meta['placeholder_post']);
        }

        // Insert Post Meta in Bulk
        if (!empty($insert_meta)) {
            $meta_query = "INSERT INTO {$wpdb->postmeta} (post_id, meta_key, meta_value) VALUES ";
            $meta_values = [];
            foreach ($insert_meta as $meta) {
                $meta_values[] = $wpdb->prepare("(%d, %s, %s)", $meta['post_id'], $meta['meta_key'], $meta['meta_value']);
            }
            $meta_query .= implode(', ', $meta_values);
            $wpdb->query($meta_query);
        }
    }
}






// import_certificates('20F14E67A39AC9106893');
// Schedule certificates import to run hourly.
function schedule_certificates_import() {
    if (!wp_next_scheduled('import_certificates_hourly')) {
        wp_schedule_event(time(), 'hourly', 'import_certificates_hourly');
    }
}
add_action('wp', 'schedule_certificates_import');

// Run the certificates import.
function run_hourly_certificates_import() {
    $token = '20F14E67A39AC9106893';
    import_certificates($token); // Ensure the `import_certificates` function exists and works correctly.
}
add_action('import_certificates_hourly', 'run_hourly_certificates_import');

// Clear any previously scheduled daily import events.
function unschedule_daily_certificates_import() {
    $timestamp = wp_next_scheduled('import_certificates_daily');
    if ($timestamp) {
        wp_unschedule_event($timestamp, 'import_certificates_daily');
    }
}
add_action('wp', 'unschedule_daily_certificates_import');

function add_custom_query_vars($vars) {
    $vars[] = 'paged_past'; // Register custom pagination query var for past posts
    return $vars;
}
add_filter('query_vars', 'add_custom_query_vars');

function add_custom_query_vars_feature($vars) {
    $vars[] = 'feature_paged'; // Register custom pagination query var for past posts
    return $vars;
}
add_filter('query_vars', 'add_custom_query_vars_feature');
function get_polish_genitive_month($month_nominative) {
    $months_nominative = array(
        'styczeń', 'luty', 'marzec', 'kwiecień', 'maj', 'czerwiec', 
        'lipiec', 'sierpień', 'wrzesień', 'październik', 'listopad', 'grudzień'
    );

    $months_genitive = array(
        'stycznia', 'lutego', 'marca', 'kwietnia', 'maja', 'czerwca', 
        'lipca', 'sierpnia', 'września', 'października', 'listopada', 'grudnia'
    );

    return str_replace($months_nominative, $months_genitive, $month_nominative);
}

function my_wpcf7_form_elements($html) {
    //wp_send_json($html );
    $text = 'Wybierz odbiorcę';
    $html = str_replace('—Please choose an option—',  $text, $html);

    return $html;
}
add_filter('wpcf7_form_elements', 'my_wpcf7_form_elements');