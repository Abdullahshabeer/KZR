<?php 
function custom_post_type_Multimedia()
{

    $labels = array(
        'name' => _x('Szkolenia', 'Post Type General Name', 'KZR'),
        'singular_name' => _x('Szkolenia', 'Post Type Singular Name', 'KZR'),
        'menu_name' => __('Szkolenia', 'KZR'),
        'name_admin_bar' => __('Szkolenia', 'KZR'),
        'archives' => __('Archiwum Szkolenia', 'KZR'),
        
        'parent_item_colon' => __('Rodzic Szkoleniai:', 'KZR'),
        'all_items' => __('Wszystkie Szkolenia', 'KZR'),
        'add_new_item' => __('Dodaj nowy Szkoleniaę', 'KZR'),
        'add_new' => __('Dodaj nowy', 'KZR'),
        'new_item' => __('Nowa Szkolenia', 'KZR'),
        'edit_item' => __('Edytuj Szkolenia', 'KZR'),
        'update_item' => __('Aktualizuj Szkolenia', 'KZR'),
        'view_item' => __('Zobacz Szkolenia', 'KZR'),
        'view_items' => __('Zobacz Szkolenia', 'KZR'),
        'search_items' => __('Szukaj', 'KZR'),
        'not_found' => __('Nic nie znaleziono', 'KZR'),
        'not_found_in_trash' => __('Nic nie znaleziono w koszu', 'KZR'),
        'featured_image' => __('Obrazek wyróżniający', 'KZR'),
        'set_featured_image' => __('Ustaw obrazek wyróżniający', 'KZR'),
        'remove_featured_image' => __('Usuń obrazek wyróżniający', 'KZR'),
        'use_featured_image' => __('Użyj jako obrazek wyróżniający', 'KZR'),
        'insert_into_item' => __('Wstaw do Szkoleniai', 'KZR'),
        'uploaded_to_this_item' => __('Dodano do Szkoleniai', 'KZR'),
        'items_list' => __('Lista Szkoleniai', 'KZR'),
        'items_list_navigation' => __('Nawigacja po liście Szkoleniai', 'KZR'),
        'filter_items_list' => __('Filtruj listę Szkoleniai', 'KZR'),
    );
    $args = array(
        'label' => __('Szkolenia', 'KZR'),
        'description' => __('Szkolenia', 'KZR'),
        'labels' => $labels,
       'supports' => array('title', 'author', 'editor', 'thumbnail', 'custom-fields', 'excerpt', 'page-attributes', 'comments'),
        'show_in_rest' => true,
        // Enable Gutenberg editor support
        'hierarchical' => false,
        'public' => true,
        'show_ui' => true,
        'show_in_menu' => true,
        'menu_position' => 5,
        'menu_icon' => 'dashicons-editor-table',
        'show_in_admin_bar' => true,
		'rewrite'       => array('slug' => 'szkolen'),
        'show_in_nav_menus' => true,
        'can_export' => true,
        'has_archive' => true,
        'exclude_from_search' => false,
        'publicly_queryable' => true,
        'capability_type' => 'post',
        
    );
    register_post_type('szkolenia', $args);
}
add_action('init', 'custom_post_type_Multimedia', 0);

function custom_taxonomy() {

    $labels = array(
        'name' => _x('action', 'taxonomy general name', 'KZR'),
        'singular_name' => _x('action', 'taxonomy singular name', 'KZR'),
        'search_items' => __('Szukaj', 'KZR'),
        'all_items' => __('All action Categories', 'KZR'),
        'parent_item' => __('Parent action Category', 'KZR'),
        'parent_item_colon' => __('Parent action Category:', 'KZR'),
        'edit_item' => __('Edit action Category', 'KZR'),
        'update_item' => __('Update action Category', 'KZR'),
        'add_new_item' => __('Add New action Category', 'KZR'),
        'new_item_name' => __('New action Category Name', 'KZR'),
        'menu_name' => __('Działania', 'KZR'),
    );

    $args = array(
        'hierarchical' => true,
        'labels' => $labels,
        'show_ui' => true,
        'show_in_rest' => true, // Enable Gutenberg support
        
        'rewrite' => array('slug' => 'szkolenia_categories'),
    );

    register_taxonomy('action-categories', 'szkolenia', $args);

   


    
}

// Hook into the init action and register the taxonomy
add_action('init', 'custom_taxonomy');


function szkolenia_add_custom_meta_box() {
    add_meta_box(
        'szkolenia_meta_box',             // ID of the meta box
        __('Event Details', 'textdomain'), // Title of the meta box
        'szkolenia_meta_box_callback',     // Callback function
        'szkolenia',                       // Post type
        'normal',                          // Context (where to show the box)
        'high'                             // Priority
    );
}
add_action('add_meta_boxes', 'szkolenia_add_custom_meta_box');

function szkolenia_meta_box_callback($post) {
    wp_nonce_field('szkolenia_save_meta_box_data', 'szkolenia_meta_box_nonce');

    $event_start_date = get_post_meta($post->ID, '_event_start_date', true);
    $event_start_time = get_post_meta($post->ID, '_event_start_time', true);
    $event_location   = get_post_meta($post->ID, '_event_location', true);
    ?>
    <p>
        <label for="event_start_date"><?php _e('Event start date (Data rozpoczęcia)', 'textdomain'); ?></label>
        <input type="date" id="event_start_date" name="event_start_date" value="<?php echo esc_attr($event_start_date); ?>" />
    </p>
    <p>
        <label for="event_start_time"><?php _e('Event start time (Godzina rozpoczęcia)', 'textdomain'); ?></label>
        <input type="time" id="event_start_time" name="event_start_time" value="<?php echo esc_attr($event_start_time); ?>" />
    </p>
    <p>
        <label for="event_location"><?php _e('Event location (Miejsce)', 'textdomain'); ?></label>
        <input type="text" id="event_location" name="event_location" value="<?php echo esc_attr($event_location); ?>" />
    </p>
    <?php
}

function szkolenia_save_meta_box_data($post_id) {
    if (!isset($_POST['szkolenia_meta_box_nonce']) ||
        !wp_verify_nonce($_POST['szkolenia_meta_box_nonce'], 'szkolenia_save_meta_box_data')) {
        return;
    }

    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
        return;
    }

    if (isset($_POST['event_start_date'])) {
        update_post_meta($post_id, '_event_start_date', sanitize_text_field($_POST['event_start_date']));
    }

    if (isset($_POST['event_start_time'])) {
        update_post_meta($post_id, '_event_start_time', sanitize_text_field($_POST['event_start_time']));
    }

    if (isset($_POST['event_location'])) {
        update_post_meta($post_id, '_event_location', sanitize_text_field($_POST['event_location']));
    }
}
add_action('save_post', 'szkolenia_save_meta_box_data');


$event_start_date = get_post_meta(get_the_ID(), '_event_start_date', true);
$event_start_time = get_post_meta(get_the_ID(), '_event_start_time', true);
$event_location   = get_post_meta(get_the_ID(), '_event_location', true);

if ($event_start_date) {
    echo '<p>' . __('Event Date:', 'textdomain') . ' ' . esc_html($event_start_date) . '</p>';
}

if ($event_start_time) {
    echo '<p>' . __('Event Time:', 'textdomain') . ' ' . esc_html($event_start_time) . '</p>';
}

if ($event_location) {
    echo '<p>' . __('Location:', 'textdomain') . ' ' . esc_html($event_location) . '</p>';
}
