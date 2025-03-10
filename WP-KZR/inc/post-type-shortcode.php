<?php

function homepage_new_section_shortcode($atts)
{
    $atts = shortcode_atts(
        array(
            'post_type' => 'post',
            'posts_per_page' => 3,
            'categories' => '', // Default to no category filter
        ),
        $atts
    );

    $html_to_return = ''; // Initialize the variable

    ob_start();
    ?>
        <?php
            $post_type = sanitize_text_field($atts['post_type']);
            $posts_per_page = intval($atts['posts_per_page']);
            $posts_categories = intval($atts['categories']);

            $args = array(
                'post_type' => $post_type,
                'posts_per_page' =>$posts_per_page,
                'cat' =>  $posts_categories,
            );

            $custom_query = new WP_Query($args);
			 $index = 0;
        ?>
          <div class="owl-carousel owl-theme articles-carousel">
        <?php if ($custom_query->have_posts()) : ?>
            <?php while ($custom_query->have_posts()) : $custom_query->the_post();

            $thumbnail_id = get_post_thumbnail_id( get_the_ID() );

            // Get the alt text for the thumbnail image
            $thumbnail_alt = get_post_meta( $thumbnail_id, '_wp_attachment_image_alt', true );
            
            // Fallback to post title if alt text is not set
            $alt_text = $thumbnail_alt ? $thumbnail_alt : '';
            ?>
                <div class="item" data-aos="fade-up" data-aos-delay="<?php echo $index * 100; ?>" data-aos-easing="ease-out-back">
                    <div class="card-content">
                      <a href="<?php the_permalink(); ?>">
                        <div class="article-featured-img">
                            <?php the_post_thumbnail('full', array('alt' => esc_attr($alt_text),'aria-hidden' => 'true')); ?>
                        </div>
                        <div class="content">
                            <p><?php echo get_the_date(); ?></p>
                            <h3><?php the_title(); ?></h3>
                            <div class="web-btn link-btn d-flex justify-content-end">
                                <span><?php esc_html_e('Czytaj więcej', 'KZR'); ?></span>
                                <div class="icon">
                                    <img src="<?php echo get_stylesheet_directory_uri(); ?>/images/right.svg" alt="" aria-hidden="true">
                                </div>    
                            </div>
                        </div>
                      </a>  
                    </div>
                </div>
            <?php $index++; endwhile; ?>
        <?php else : ?>
            <div class="parentnone">
                <?php esc_html_e('No posts found.', 'KZR'); ?>
            </div>
        <?php endif; ?>
        <?php wp_reset_postdata(); ?>
    </div>
    <?php
    $html_to_return = ob_get_clean();

    return $html_to_return;
}

add_shortcode('homepage-new-shortcode', 'homepage_new_section_shortcode');



/**
 * 
 * API endpoint for get_post_shortcode
 */
function publications_list_custom_post_type_handler($request) {
    $params = $request->get_params();
    $content = do_shortcode("[homepage-new-shortcode post_type='{$params['postType']}' posts_per_page='{$params['postperpage']}' categories='{$params['selectedCategory']}' ]");
    

    return rest_ensure_response(array('content' => $content));
}
   add_action('rest_api_init', function () {
    register_rest_route('blocks-preview-shortvode/v1', '/homepage-new-post-shortcode-type', array(
        'methods' => 'POST',
        'callback' => 'publications_list_custom_post_type_handler',
    ));
});


function homepage_szkolenia_section_shortcode($atts)
{
    $atts = shortcode_atts(
        array(
            'post_type' => 'post',
            'posts_per_page' => 3,
            'categories' => '', // Default to no category filter
        ),
        $atts
    );

    $html_to_return = ''; // Initialize the variable

    ob_start();
    ?>
        <?php
            $post_type = sanitize_text_field($atts['post_type']);
            $posts_per_page = intval($atts['posts_per_page']);
            $posts_categories = intval($atts['categories']);
            $current_date = date('Y-m-d');
            $args = array(
                'post_type' => $post_type,
                'posts_per_page' =>$posts_per_page,
                'meta_query' => array(
                    array(
                        'key' => '_event_start_date',
                        'value' => $current_date,
                        'compare' => '>=', // Show posts where the event date is today or in the future
                        'type' => 'DATE',
                    ),
                ),
                'orderby' => 'meta_value',
                'order' => 'ASC', // Order posts by event date+
                'post_categories' =>  $posts_categories,
            );
            

            $custom_query = new WP_Query($args);
			$index = 0;
        ?>
           <div class="owl-carousel owl-theme training-carousel">
        <?php if ($custom_query->have_posts()) : ?>
            <?php while ($custom_query->have_posts()) : $custom_query->the_post(); 
             
             // Get the custom post meta value
             $event_date = get_post_meta(get_the_ID(), '_event_start_date', true);
             
            if ($event_date) {
             $day = date_i18n('j', strtotime($event_date));  // Day
             $month_nominative = date_i18n('F', strtotime($event_date)); // Month
             $month = get_polish_genitive_month($month_nominative);
             $year = date_i18n('Y', strtotime($event_date));
         } else {
             // Fallback to the post's publish date if the event date is not set
             $day = get_the_date('j');
             $month = get_the_date('F');
         }
         
            ?>
                <div class="item" data-aos="fade-up" data-aos-delay="<?php echo $index * 100; ?>" data-aos-easing="ease-out-back">
                    <div class="web-card light-bg style-2">
                        <a href="<?php the_permalink(); ?>">
                            <div class="content">
                                <div class="date-meta">
                                <h3><?php echo esc_html($day); ?></h3>
                                <p><?php echo esc_html($month); ?></p>
                                </div>
                                <h4><?php the_title(); ?></h4>
                            </div>
                        </a>
                    </div>
                </div>
            <?php $index++; endwhile; ?>
        <?php else : ?>
            <div class="parentnone">
                <?php esc_html_e('No posts found.', 'KZR'); ?>
            </div>
        <?php endif; ?>
        <?php wp_reset_postdata(); ?>
    </div>
    <?php
    $html_to_return = ob_get_clean();

    return $html_to_return;
}

add_shortcode('homepage-szkolenia-shortcode', 'homepage_szkolenia_section_shortcode');



/**
 * 
 * API endpoint for get_post_shortcode
 */
function publications_szkolenia_custom_post_type_handler($request) {
    $params = $request->get_params();
    $content = do_shortcode("[homepage-szkolenia-shortcode post_type='{$params['postType']}' posts_per_page='{$params['postperpage']}' categories='{$params['selectedCategory']}' ]");
    

    return rest_ensure_response(array('content' => $content));
}
   add_action('rest_api_init', function () {
    register_rest_route('blocks-preview-shortvode/v1', '/homepage-szkolenia-post-shortcode-type', array(
        'methods' => 'POST',
        'callback' => 'publications_szkolenia_custom_post_type_handler',
    ));
});

                



function szkolenia_section_shortcode($atts)
{
    $atts = shortcode_atts(
        array(
            'post_type' => 'post',
            'posts_per_page' => 3,
            'categories' => '', // Default to no category filter
        ),
        $atts
    );

    $html_to_return = ''; // Initialize the variable

    ob_start();
    ?>
    <div class="cards-wrap">
        <div class="row custom-space">
            <?php
            $post_type = sanitize_text_field($atts['post_type']);
            $posts_per_page = intval($atts['posts_per_page']);
            $posts_categories = intval($atts['categories']);
            $paged = get_query_var('paged') ? get_query_var('paged') : 1;
            $args = array(
                'post_type' => $post_type,
                'posts_per_page' => $posts_per_page,
                'paged'          => $paged,
                'cat' => $posts_categories,
            );

            $custom_query = new WP_Query($args);

            if ($custom_query->have_posts()) :
                while ($custom_query->have_posts()) : $custom_query->the_post();

                    // Get the custom post meta value
                    $event_date = get_post_meta(get_the_ID(), '_event_start_date', true);

                    // Format the date if it exists
                    if ($event_date) {
                        $formatted_date = date('d.m.Y', strtotime($event_date));
                    } else {
                        // Fallback to the post's publish date if the event date is not set
                        $formatted_date = get_the_date('d.m.Y');
                    }
                    ?>
                    <div class="col-md-12">
                        <div class="web-card light-bg border-radius">
                            <div class="content">
                                <div class="meta-sec d-flex">
                                    <p><?php echo esc_html($formatted_date); ?></p>
                                </div>
                                <div class="web-heading heading-divider">
                                    <h4><?php the_title(); ?></h4>
                                </div>
                                <p><?php echo get_the_excerpt(); ?></p>
                                <div class="web-btn d-flex justify-content-end">
                                    <a href="<?php the_permalink(); ?>" class="link-btn">
                                        <span><?php esc_html_e('Czytaj więcej', 'KZR'); ?></span>
                                        <div class="icon">
                                            <img src="<?php echo esc_url(get_template_directory_uri() . '/images/right.svg'); ?>" alt="icon">
                                        </div>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endwhile;
            else : ?>
                <div class="col-md-12">
                    <?php esc_html_e('No posts found.', 'KZR'); ?>
                </div>
            <?php endif;
            wp_reset_postdata();
            ?>
        </div>
    </div>
    <div class="pagination-wrap">
        <div class="pagination-inner" role="navigation">
            <?php
            // Custom pagination (if needed)
            echo paginate_links(array(
                'total' => $custom_query->max_num_pages,
                'prev_text' => '&#8249;',
                'next_text' => '&#8250;',
            ));
            ?>
        </div>
    </div>
    <?php
    $html_to_return = ob_get_clean();

    return $html_to_return;
}

add_shortcode('szkolenia-shortcode', 'szkolenia_section_shortcode');

function publications_szkolenia_post_type_handler($request) {
    $params = $request->get_params();
    $content = do_shortcode("[szkolenia-shortcode post_type='{$params['postType']}' posts_per_page='{$params['postperpage']}' categories='{$params['selectedCategory']}' ]");
    

    return rest_ensure_response(array('content' => $content));
}
   add_action('rest_api_init', function () {
    register_rest_route('blocks-preview-shortvode/v1', '/szkolenia-post-shortcode-type', array(
        'methods' => 'POST',
        'callback' => 'publications_szkolenia_post_type_handler',
    ));
});
function svg_shortcode($atts) {
    $atts = shortcode_atts(array(
        'src' => ''
    ), $atts, 'svg');

    if (empty($atts['src'])) {
        return ''; // Return empty if no source is provided
    }

    $url = esc_url($atts['src']);
    $response = wp_remote_get($url);
    
    if (is_wp_error($response)) {
        return ''; // Return empty if there's an error
    }

    $body = wp_remote_retrieve_body($response);
    
    // Check if the body is not empty
    if (empty($body)) {
        return ''; // Return empty if there's no content
    }

    return $body; // Return the SVG content
}
add_shortcode('svg', 'svg_shortcode');


// adding shortcode for certificates table.
function certificates_short_code(){
    return get_certificates_apply_filters();
}
add_shortcode('certificates_short_code', 'certificates_short_code');


function get_certificates_apply_filters_loop(){
    ob_start();
        $posts_per_page  = isset( $_GET['posts_per_page'] ) ? absint( $_GET['posts_per_page'] ) : 10;
        $paged           = (get_query_var('paged')) ? get_query_var('paged') : 1;
        $paged           = isset( $_GET['pageno'] ) ? absint( $_GET['pageno'] ) : 1;
        $nazwa_firmy     = isset( $_GET['nazwa_firmy'] ) ? sanitize_text_field( $_GET['nazwa_firmy'] ) : '';
        $nip             = isset( $_GET['nip'] ) ? sanitize_text_field( $_GET['nip'] ) : '';
        $adres_firmy     = isset( $_GET['adres_firmy'] ) ? sanitize_text_field( $_GET['adres_firmy'] ) : '';
        $nr_certyfikatu  = isset( $_GET['nr_certyfikatu'] ) ? sanitize_text_field( $_GET['nr_certyfikatu'] ) : '';
        $nr_uczestnika   = isset( $_GET['nr_uczestnika'] ) ? sanitize_text_field( $_GET['nr_uczestnika'] ) : '';
        $selectfilters      = isset($_GET['filters']) ? sanitize_text_field( $_GET['filters'] ) : '';
        $sortby             = isset($_GET['sortby']) ? sanitize_text_field( $_GET['sortby'] ) : 'ASC';
        
        if($paged == 0){
            $paged = 1;
        }
        if(! empty($selectfilters)){
            if (strpos($selectfilters, '+') !== false) {
                $selectfilters = explode('+', $selectfilters);
            } else {
                $selectfilters = explode('%2B', $selectfilters);
            }
        }
        $index              =   $posts_per_page*($paged-1);
        $args = array(
            'post_type'      => 'certificates',
            'posts_per_page' => $posts_per_page,
            'paged'          => $paged,
            'meta_query'     => array(
                'relation'   => 'AND',
            ),
        );
        if ( ! empty( $nr_certyfikatu ) ) {
            $args['meta_query'][] = array(
                'key'     => 'nr_certyfikatu',
                'value'   => $nr_certyfikatu,
                'compare' => 'LIKE',
            );
        }
        
        // if ( ! empty( $nr_uczestnika ) ) {
        //     $args['meta_query'][] = array(
        //         'key'     => 'nr_uczestnika',
        //         'value'   => '^' . $nr_uczestnika . '$', // Exact match pattern
        //         'compare' => 'REGEXP',
        //     );
        // }
        if ( ! empty( $nr_uczestnika ) ) {
            $args['meta_query'][] = array(
                'key'     => 'nr_uczestnika',
                'value'   => $nr_uczestnika, // Partial match value
                'compare' => 'LIKE', // Use LIKE for partial matching
            );
        }
        if ( ! empty( $nazwa_firmy ) ) {
            $args['meta_query'][] = array(
                'key'     => 'nazwa_firmy',
                'value'   => $nazwa_firmy,
                'compare' => 'LIKE',
            );
        }
        
        if ( ! empty( $adres_firmy ) ) {
            $args['meta_query'][] = array(
                'key'     => 'adres_firmy',
                'value'   => $adres_firmy,
                'compare' => 'LIKE',
            );
        }
        if ( ! empty( $nip ) ) {
            $args['meta_query'][] = array(
                'key'     => 'nip',
                'value'   => $nip,
                'compare' => 'LIKE',
            );
        }
        if ( ! empty( $selectfilters ) && is_array( $selectfilters ) ) {
            $meta_query_or = array(
                'relation' => 'OR',
                array(
                    'key'     => 'status_certyfikatu',
                    'value'   => $selectfilters,
                    'compare' => 'IN', 
                ),
            );
            $args['meta_query'][] = $meta_query_or;
        }
        switch( $sortby ) {
            case 'wazny_od_asc':
                $args['meta_key'] = 'wazny_od';
                $args['orderby'] = 'meta_value';
                $args['order'] = 'ASC'; 
            break;
    
            case 'wazny_od_desc':
                $args['meta_key'] = 'wazny_od';
                $args['orderby'] = 'meta_value';
                $args['order'] = 'DESC'; 
            break;

            case 'wazny_do_asc':
                $args['meta_key'] = 'wazny_do';
                $args['orderby'] = 'meta_value';
                $args['order'] = 'DESC'; 
            break;
            case 'wazny_do_desc':
                $args['meta_key'] = 'wazny_do';
                $args['orderby'] = 'meta_value';
                $args['order'] = 'DESC'; 
            break;
            case 'titleasc':
                $args['meta_key'] = 'nazwa_firmy';
                $args['orderby'] = 'meta_value';
                $args['order'] = 'ASC';
            break;
            case 'titledesc':
                $args['meta_key'] = 'nazwa_firmy';
                $args['orderby'] = 'meta_value';
                $args['order'] = 'DESC';
            break;
    
            default:
            $args['meta_key'] = 'wazny_od';
            $args['orderby'] = 'meta_value';
            $args['order'] = 'DESC'; 
            break;
        }
        $query = new WP_Query($args);
        $total_posts = $query->found_posts;
        ?>
        <table id="data-table" class="data-table" style="width:100%">
            <thead>
                <tr>
                    <th><span class="visually-hidden">Lp.</span></th>
                    <th class="all"><span class="visually-hidden">Status</span></th>
                    <th class="bigdesktop middesktop"> <?php _e('Nr certyfikatu', 'KZR'); ?></th>
                    <th class="all"> <?php _e('Nazwa Firmy', 'KZR'); ?></th>
                    <th class="bigdesktop medium"> <?php _e('Ważny od', 'KZR'); ?></th>
                    <th class="bigdesktop medium"> <?php _e('Ważny do', 'KZR'); ?></th>
                    <th class="bigdesktop middesktop"> <?php _e('Adres', 'KZR'); ?></th>
                    <th class="bigdesktop middesktop medium"> <?php _e('Certyfikat/Raport', 'KZR'); ?></th>
                    <th class="none"> <?php _e('Nr uczestnika', 'KZR'); ?></th>
                    <th class="none"> <?php _e('Lokalizacja', 'KZR') ;?></th>
                    <th class="none"> <?php _e('Zakres certyfikacji', 'KZR') ;?></th>
                    <th class="none"> <?php _e('Jednostka certyfikująca', 'KZR') ;?></th>
                    <th class="none"> <?php _e('Uwagi', 'KZR') ;?></th>
                </tr>
            </thead>
            <tbody>
                <?php
                $current_language = defined('ICL_LANGUAGE_CODE') ? ICL_LANGUAGE_CODE : 'pl'; // Default to Polish if not defined
                if ($query->have_posts()) :
                    while ($query->have_posts()) : $query->the_post();
                    $post_id = get_the_ID();
                    
                    $nr_certyfikatu         = get_post_meta($post_id , 'nr_certyfikatu' , true);
                    $nr_uczestnika          = get_post_meta($post_id , 'nr_uczestnika' , true);
                    $nazwa_firmy            = get_post_meta($post_id , 'nazwa_firmy' , true);
                    $adres_firmy            = get_post_meta($post_id , 'adres_firmy' , true);
                    $wazny_od               = get_post_meta($post_id , 'wazny_od' , true);
                    $wazny_do               = get_post_meta($post_id , 'wazny_do' , true);
                    $nip                    = get_post_meta($post_id , 'nip' , true);
                    $zakres                 = get_post_meta($post_id , 'zakres' , true);
                    $jednostka_certyfikujaca = get_post_meta($post_id , 'jednostka_certyfikujaca' , true);
                    $status_certyfikatu     = get_post_meta($post_id , 'status_certyfikatu' , true);
                    $plik_certyfikat        = get_post_meta($post_id , 'plik_certyfikat' , true);
                    $plik_raport            = get_post_meta($post_id , 'plik_raport' , true);
                    $lista_lokalizacjif        = get_post_meta($post_id , 'lista_lokalizacji',true);
                    $lista_lokalizacji = json_decode($lista_lokalizacjif, true);
                    $zakresen                = get_post_meta($post_id , 'zakres_en' , true);
                    $uwagien                = get_post_meta($post_id , 'uwagi_en' , true);
                    $obszary                = get_post_meta($post_id , 'obszary' , true);
                    $uwagi                  = get_post_meta($post_id , 'uwagi' , true);
                    $zakres_value = ($current_language === 'en') ? $zakresen : $zakres;
                    $uwagi_value = ($current_language === 'en') ? $uwagien : $uwagi;
                    $icon = '';
                    if ($status_certyfikatu === 'ważny') {
                        $icon = 'valid.svg';
                    } elseif ($status_certyfikatu === 'zawieszony') {
                        $icon = 'suspended.svg';
                    } 
                    elseif ($status_certyfikatu === 'wygasły') {
                        $icon = 'expired.svg';
                    }
                    elseif ($status_certyfikatu === 'zakończony') {
                        $icon = 'completed.svg';
                    }
                    elseif ($status_certyfikatu === 'wycofany') {
                        $icon = 'withdrawn.svg';
                    }else {
                        $icon = 'valid.svg';
                    }
                    if($index%2 == 0){
                        $row_class='odd';
                    }
                    else{
                        $row_class='even';
                    }
                    echo '<tr class="'.$row_class.'">';
                        echo '<td><span class="visually-hidden">expanded element</span><span class="visually-hidden d-none">collapsed element</span></td>';
                        echo '<td tabindex="0"><div class="status-info"><img src="'.gautan_Blocks_BASE_URL.'images/' . $icon . '" alt="status icon" aria-hidden="true"
><p class="visually-hidden">'.esc_html($status_certyfikatu).'</p></div></td>';
                        echo '<td tabindex="0"><div class="certificate">' . esc_html($nr_certyfikatu) . '</div></td>';
                        echo '<td tabindex="0">
                                <div class="nazwa_firmy">' . esc_html($nazwa_firmy) . ' </div>
                                <div class="nazwa_firmy nip">NIP: ' . esc_html($nip) . ' </div>
                            </td>';
                        echo '<td tabindex="0">' . esc_html($wazny_od) . '</td>';
                        echo '<td tabindex="0">' . esc_html($wazny_do) . '</td>';
                        echo '<td tabindex="0">
                                <a href="https://www.google.com/maps/search/' . urlencode($adres_firmy) . '" target="_blank" rel="noopener noreferrer">
                                <div class="address-info d-flex align-items-center">
                                    <div class="icon">
                                        <svg width="28" height="32" viewBox="0 0 28 32" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <path d="M19.1944 23.25H21.5L26.5 30.75H1.5L6.5 23.25H8.80562" stroke="#2F3E45" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                            <path class="hover-effect" d="M16.5 8.75C16.5 10.1306 15.3806 11.25 14 11.25C12.6194 11.25 11.5 10.1306 11.5 8.75C11.5 7.36937 12.6194 6.25 14 6.25C15.3806 6.25 16.5 7.36937 16.5 8.75Z" stroke="#2F3E45" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                            <path d="M14 21.25L20.0037 13.2456C21.1625 11.7006 21.7387 9.69374 21.4069 7.55124C20.9294 4.46874 18.4319 1.90936 15.3594 1.36936C10.6181 0.536865 6.5 4.16249 6.5 8.74999C6.5 10.4369 7.05688 11.9931 7.99625 13.2456L14 21.25Z" stroke="#2F3E45" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                        </svg>
                                    </div>
                                    ' . esc_html($adres_firmy) . '
                                </div>
                                </a>
                            </td>';
                        echo '<td>';
                            if($plik_certyfikat){
                                echo  '<div class="icon">
                                    <a href="' . esc_url($plik_certyfikat) . '" target="_blank">
                                        <span class="icon-text">'.__('pobierz certifikat' , 'KZR').'</span>
                                        <svg width="37" height="40" viewBox="0 0 37 40" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M5.16211 37.9862C5.16211 38.6709 5.71762 39.2264 6.40234 39.2264H34.9315C35.617 39.2264 36.1718 38.6709 36.1718 37.9862V7.48947C36.1718 7.16065 36.041 6.84498 35.8081 6.6121L30.3335 1.13744C30.1006 0.904558 29.7857 0.773804 29.4561 0.773804H6.40312C5.7184 0.773804 5.16288 1.32932 5.16288 2.01404V21.8608" stroke="#2F3E45" stroke-width="1.54739" stroke-linecap="round" stroke-linejoin="round"/><path d="M29.3496 0.773804V6.97574C29.3496 7.31849 29.6274 7.59624 29.9701 7.59624H36.172" stroke="#2F3E45" stroke-width="1.54739" stroke-linecap="round" stroke-linejoin="round"/><path d="M19.2989 27.4608H17.3027V32.3862" stroke="#2F3E45" stroke-width="1.54739" stroke-linecap="round" stroke-linejoin="round"/><path d="M17.3027 29.8763H19.1403" stroke="#2F3E45" stroke-width="1.54739" stroke-linecap="round" stroke-linejoin="round"/><path d="M11.6035 27.5212V32.2532" stroke="#2F3E45" stroke-width="1.54739" stroke-linecap="round" stroke-linejoin="round"/><path d="M14.9118 29.9236C14.9118 31.2505 14.1753 32.3004 13.007 32.3205C12.6178 32.3274 11.6136 32.3313 11.6136 32.3313C11.6136 32.3313 11.6074 30.5874 11.6074 29.9189C11.6074 29.3696 11.6035 27.5166 11.6035 27.5166H12.9675C14.2488 27.5166 14.9118 28.5975 14.9118 29.9243V29.9236Z" stroke="#2F3E45" stroke-width="1.54739" stroke-linecap="round" stroke-linejoin="round"/><path d="M6.38477 27.4423V32.404" stroke="#2F3E45" stroke-width="1.54739" stroke-linecap="round" stroke-linejoin="round"/><path d="M9.19328 28.8426C9.19328 29.6156 8.53873 30.243 7.76581 30.243C7.38206 30.243 6.39405 30.2492 6.39405 30.2492C6.39405 30.2492 6.38786 29.2326 6.38786 28.8426C6.38786 28.5223 6.38477 27.4423 6.38477 27.4423H7.76658C8.5395 27.4423 9.19405 28.069 9.19405 28.8426H9.19328Z" stroke="#2F3E45" stroke-width="1.54739" stroke-linecap="round" stroke-linejoin="round"/><path class="hover-effect" d="M13.7512 20.6987C11.6986 17.5297 28.8035 14.5989 27.8449 17.525C26.371 22.0218 15.2267 6.87282 20.0615 7.13433C22.8576 7.2852 15.9052 24.0241 13.7512 20.6987Z" stroke="#2F3E45" stroke-width="1.54739" stroke-linecap="round" stroke-linejoin="round"/><path d="M1.44141 22.4813V33.6449C1.44141 34.6724 2.27468 35.5057 3.30214 35.5057H22.5284C23.2139 35.5057 23.7687 34.9502 23.7687 34.2654V25.583C23.7687 24.8983 23.2132 24.3428 22.5284 24.3428H3.30214C2.27468 24.3428 1.44141 23.5095 1.44141 22.4821C1.44141 21.4546 2.27468 20.6213 3.30214 20.6213H5.16288" stroke="#2F3E45" stroke-width="1.54739" stroke-linecap="round" stroke-linejoin="round"/></svg>
										<span class="visually-hidden">download in PDF file</span>
                                    </a>
                                </div>';
                            }
                            if($plik_raport){
                                echo '<div class="icon">
                                    <a href="' . esc_url($plik_raport) . '" target="_blank">
                                        <span class="icon-text">'.__('pobierz raport' , 'KZR').'</span>
                                        <svg width="37" height="40" viewBox="0 0 37 40" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M5.16211 37.9862C5.16211 38.6709 5.71762 39.2264 6.40234 39.2264H34.9315C35.617 39.2264 36.1718 38.6709 36.1718 37.9862V7.48947C36.1718 7.16065 36.041 6.84498 35.8081 6.6121L30.3335 1.13744C30.1006 0.904558 29.7857 0.773804 29.4561 0.773804H6.40312C5.7184 0.773804 5.16288 1.32932 5.16288 2.01404V21.8608" stroke="#2F3E45" stroke-width="1.54739" stroke-linecap="round" stroke-linejoin="round"/><path d="M29.3496 0.773804V6.97574C29.3496 7.31849 29.6274 7.59624 29.9701 7.59624H36.172" stroke="#2F3E45" stroke-width="1.54739" stroke-linecap="round" stroke-linejoin="round"/><path d="M19.2989 27.4608H17.3027V32.3862" stroke="#2F3E45" stroke-width="1.54739" stroke-linecap="round" stroke-linejoin="round"/><path d="M17.3027 29.8763H19.1403" stroke="#2F3E45" stroke-width="1.54739" stroke-linecap="round" stroke-linejoin="round"/><path d="M11.6035 27.5212V32.2532" stroke="#2F3E45" stroke-width="1.54739" stroke-linecap="round" stroke-linejoin="round"/><path d="M14.9118 29.9236C14.9118 31.2505 14.1753 32.3004 13.007 32.3205C12.6178 32.3274 11.6136 32.3313 11.6136 32.3313C11.6136 32.3313 11.6074 30.5874 11.6074 29.9189C11.6074 29.3696 11.6035 27.5166 11.6035 27.5166H12.9675C14.2488 27.5166 14.9118 28.5975 14.9118 29.9243V29.9236Z" stroke="#2F3E45" stroke-width="1.54739" stroke-linecap="round" stroke-linejoin="round"/><path d="M6.38477 27.4423V32.404" stroke="#2F3E45" stroke-width="1.54739" stroke-linecap="round" stroke-linejoin="round"/><path d="M9.19328 28.8426C9.19328 29.6156 8.53873 30.243 7.76581 30.243C7.38206 30.243 6.39405 30.2492 6.39405 30.2492C6.39405 30.2492 6.38786 29.2326 6.38786 28.8426C6.38786 28.5223 6.38477 27.4423 6.38477 27.4423H7.76658C8.5395 27.4423 9.19405 28.069 9.19405 28.8426H9.19328Z" stroke="#2F3E45" stroke-width="1.54739" stroke-linecap="round" stroke-linejoin="round"/><path class="hover-effect" d="M13.7512 20.6987C11.6986 17.5297 28.8035 14.5989 27.8449 17.525C26.371 22.0218 15.2267 6.87282 20.0615 7.13433C22.8576 7.2852 15.9052 24.0241 13.7512 20.6987Z" stroke="#2F3E45" stroke-width="1.54739" stroke-linecap="round" stroke-linejoin="round"/><path d="M1.44141 22.4813V33.6449C1.44141 34.6724 2.27468 35.5057 3.30214 35.5057H22.5284C23.2139 35.5057 23.7687 34.9502 23.7687 34.2654V25.583C23.7687 24.8983 23.2132 24.3428 22.5284 24.3428H3.30214C2.27468 24.3428 1.44141 23.5095 1.44141 22.4821C1.44141 21.4546 2.27468 20.6213 3.30214 20.6213H5.16288" stroke="#2F3E45" stroke-width="1.54739" stroke-linecap="round" stroke-linejoin="round"/></svg>
										<span class="visually-hidden">download in PDF file</span>
                                    </a>
                                </div>';
                            }
                        echo '</td>';
                        echo '<td>' . esc_html($nr_uczestnika) . '</td>';
                        if (isset($lista_lokalizacji) && is_array($lista_lokalizacji)) {
                            $lokalizacje = [];
                            foreach ($lista_lokalizacji as $location) {
                                $lokalizacja = isset($location['lokalizacja']) ? esc_html($location['lokalizacja']) : 'N/A';
                                $lokalizacje[] = $lokalizacja;
                            }
                            echo '<td>'. implode('; <br>', $lokalizacje) . '</td>';
                        } else {
                            echo '<td> N/A </td>';
                        }
                        echo '<td>' . esc_html($zakres_value) . '</td>';
                        echo '<td>'.esc_html($jednostka_certyfikujaca).'</td>';
                        echo '<td>' . esc_html($uwagi_value) . '</td>';
                    echo '</tr>';
                    endwhile;
                        wp_reset_postdata();
                    endif; ?>
            </tbody>
        </table>
        <!-- Pagination -->
        <div class="pagination-wrap pagination-container">
        	<div class="pagination-inner" role="navigation">
				<?php 
				echo paginate_links(array(
					'total'   => $query->max_num_pages,
					'current' => $paged,
					'format'  => '?paged=%#%',
					'prev_text'    => __('&#8249;', 'KZR'),
                     'next_text'    => __('&#8250;', 'KZR'),
				));
				?>
        	</div>
		</div>
        <?php
        $output = ob_get_clean();
        if (wp_doing_ajax()) {
            $response = array(
                'content'           => $output,
                'total_posts'       => $total_posts,  
            );
            wp_send_json($response);
            wp_die();
        }
        else{
            echo $output;
        }
}
function isChecked($value, $selectfilters) {
    if(is_array($selectfilters)){
        return in_array($value, $selectfilters) ? 'checked' : '';
    }
    else{
        return '';
    }
}
function get_certificates_apply_filters() {
    ob_start();
        $posts_per_page  = isset( $_GET['posts_per_page'] ) ? absint( $_GET['posts_per_page'] ) : 10;
        $paged           = (get_query_var('paged')) ? get_query_var('paged') : 1;
        $paged           = isset( $_GET['pageno'] ) ? absint( $_GET['pageno'] ) : 1;
        $nazwa_firmy     = isset( $_GET['nazwa_firmy'] ) ? sanitize_text_field( $_GET['nazwa_firmy'] ) : '';
        $nip             = isset( $_GET['nip'] ) ? sanitize_text_field( $_GET['nip'] ) : '';
        $adres_firmy     = isset( $_GET['adres_firmy'] ) ? sanitize_text_field( $_GET['adres_firmy'] ) : '';
        $nr_certyfikatu  = isset( $_GET['nr_certyfikatu'] ) ? sanitize_text_field( $_GET['nr_certyfikatu'] ) : '';
        $nr_uczestnika   = isset( $_GET['nr_uczestnika'] ) ? sanitize_text_field( $_GET['nr_uczestnika'] ) : '';
        $selectfilters      = isset($_GET['filters']) ? sanitize_text_field( $_GET['filters'] ) : '';
        if(! empty($selectfilters)){
            if (strpos($selectfilters, '+') !== false) {
                $selectfilters = explode('+', $selectfilters);
            } else {
                $selectfilters = explode('%2B', $selectfilters);
            }
        }
        ?>
        <div class="filter-wrap">
                <div class="web-form">
                    <form id="filter-form" data-description-title="<?php _e('Szczegóły:' , 'KZR'); ?>">
                    
                        <div class="row">
                            <div class="col-xl-4 col-lg-6">
                                <div class="form-group">
                                    <label for="nazwa-firmy" class="visually-hidden">Nazwa firmy</label>
                                    <input type="text" class="form-control" id="nazwa-firmy" name="nazwa-firmy" value="<?php echo $nazwa_firmy ?>" placeholder="<?php _e('Nazwa firmy', 'KZR');?>">
                                </div>
                            </div>
                            <div class="col-xl-4 col-lg-6">
                                <div class="form-group">
                                    <label for="nip" class="visually-hidden">NIP</label>
                                    <input type="text" class="form-control" id="nip" value="<?php echo $nip ?>" name="nip" placeholder="<?php _e('NIP', 'KZR');?>">
                                </div>
                            </div>
                            <div class="col-xl-4 col-lg-6">
                                <div class="form-group">
                                    <label for="adres-firmy" class="visually-hidden">Adres firmy</label>
                                    <input type="text" class="form-control" id="adres-firmy" value="<?php echo $adres_firmy ?>" name="adres-firmy" placeholder="<?php _e('Adres firmy', 'KZR');?>">
                                </div>
                            </div>
                            <div class="col-xl-4 col-lg-6">
                                <div class="form-group">
                                    <label for="nr-certyfikatu" class="visually-hidden">Nr certyfikatu</label>
                                    <input type="text" class="form-control" id="nr-certyfikatu" value="<?php echo $nr_certyfikatu ?>" name="nr-certyfikatu" placeholder="<?php _e('Nr certyfikatu', 'KZR');?>">
                                </div>
                            </div>
                            <div class="col-xl-4 col-lg-6">
                                <div class="form-group">
                                    <label for="nr-uczestnika" class="visually-hidden">Nr uczestnika</label>
                                    <input type="text" class="form-control"  id="nr-uczestnika" value="<?php echo $nr_uczestnika ?>" name="nr-uczestnika" placeholder="<?php _e('Nr uczestnika', 'KZR');?>">
                                </div>
                            </div>
                            <div class="col-xl-3 col-lg-6 d-lg-none">
                                <div class="form-group">
                                    <label for="sortingselectoption" class="visually-hidden">Status</label>
                                    <select class="form-select" id="sortingselectoption">
                                        <option selected value=""><?php _e('Status', 'KZR');?></option>
                                        <option value="aktywny"><?php _e('ważny', 'KZR');?></option>
                                        <option value="zawieszony"><?php _e('zawieszony', 'KZR');?></option>
                                        <option value="wygasły"><?php _e('wygasły', 'KZR');?></option>
                                        <option value="zakończony"><?php _e('zakończony', 'KZR');?></option>
                                        <option value="wycofany"><?php _e('wycofany', 'KZR');?></option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-xl-2 col-lg-6">
                                <div class="form-group">
                                    <div class="web-btn form-btn">
                                        <button type="submit" id="submit-button" class="btn btn-secondary">
                                            <span id="button-loader" class="loader" style="display: none;"></span>
                                            <span id="button-text"><?php _e('Szukaj', 'KZR'); ?></span>
                                        </button>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-2 col-lg-6">
                                <div class="form-group">
                                    <div class="web-btn form-btn">
                                        <button type="reset" id="reset-button" class="btn btn-transparent"> <?php _e('Wyczyść', 'KZR'); ?></button>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-12 d-none d-lg-block">
                                <div class="form-group">
                                    <span><?php _e('Wybierz status:', 'KZR'); ?></span>
                                    <div class="checkbox-inline">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox"  name="filter-inputs" <?php echo isChecked('aktywny', $selectfilters); ?> value="aktywny" id="checkbox-1" >
                                            <label class="form-check-label" for="checkbox-1">
                                            <img src="<?php echo gautan_Blocks_BASE_URL; ?>images/valid.svg" alt="valid-12" aria-hidden="true"><?php _e('ważny', 'KZR'); ?></label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" name="filter-inputs" <?php echo isChecked('zawieszony', $selectfilters); ?> value="zawieszony" id="checkbox-2" >
                                            <label class="form-check-label" for="checkbox-2"><img src="<?php echo gautan_Blocks_BASE_URL; ?>images/suspended.svg" alt="suspended" aria-hidden="true"><?php _e('zawieszony', 'KZR'); ?></label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" name="filter-inputs" <?php echo isChecked('wygasły', $selectfilters); ?> value="wygasły" id="checkbox-3" >
                                            <label class="form-check-label" for="checkbox-3"><img src="<?php echo gautan_Blocks_BASE_URL; ?>images/expired.svg" alt="expired" aria-hidden="true"><?php _e('wygasły', 'KZR'); ?></label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" name="filter-inputs" <?php echo isChecked('zakończony', $selectfilters); ?> value="zakończony" id="checkbox-4" >
                                            <label class="form-check-label" for="checkbox-4"><img src="<?php echo gautan_Blocks_BASE_URL; ?>images/completed.svg" alt="completed" aria-hidden="true"><?php _e('zakończony', 'KZR'); ?></label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" name="filter-inputs" <?php echo isChecked('wycofany', $selectfilters); ?> value="wycofany" id="checkbox-5" >
                                            <label class="form-check-label" for="checkbox-5"><img src="<?php echo gautan_Blocks_BASE_URL; ?>images/withdrawn.svg" alt="withdrawn" aria-hidden="true"><?php _e('wycofany', 'KZR'); ?></label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row bottom-filters-wrap">
                            <div class="col-lg-4 col-md-6">
                                <div class="sorting-option">
                                    <label for="sortby">
                                        <?php _e('Sortuj:' , 'KZR'); ?>
                                    </label>
                                    <select name="sortby" id="sortby" class="form-select">
                                        <option value="wazny_od_desc"><?php _e('Ważne od malejącego' , 'KZR') ?></option>
                                        <option value="wazny_do_asc"><?php _e('Ważny do góry' , 'KZR') ?></option>
                                        <option value="wazny_od_asc"><?php _e('Ważne od góry' , 'KZR') ?></option>
                                        <option value="titleasc"><?php _e('Alfabetycznie - od A do Z' , 'KZR') ?></option>
                                        <option value="titledesc"><?php _e('Alfabetycznie - od Z do A' , 'KZR') ?></option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <?php
                                    
                                    $index              =   $posts_per_page*($paged-1);
                                    $args = array(
                                        'post_type'      => 'certificates',
                                        'posts_per_page' => $posts_per_page,
                                        'paged'          => $paged,
                                        'meta_query'     => array(
                                            'relation' => 'AND',
                                        ),
                                    );
                                    if ( ! empty( $nr_certyfikatu ) ) {
                                        $args['meta_query'][] = array(
                                            'key'     => 'nr_certyfikatu',
                                            'value'   => $nr_certyfikatu,
                                            'compare' => 'LIKE',
                                        );
                                    }
                                    
                                    if ( ! empty( $nr_uczestnika ) ) {
                                        $args['meta_query'][] = array(
                                            'key'     => 'nr_uczestnika',
                                            'value'   => $nr_uczestnika,
                                            'compare' => 'LIKE',
                                        );
                                    }
                                    
                                    if ( ! empty( $nazwa_firmy ) ) {
                                        $args['meta_query'][] = array(
                                            'key'     => 'nazwa_firmy',
                                            'value'   => $nazwa_firmy,
                                            'compare' => 'LIKE',
                                        );
                                    }
                                    
                                    if ( ! empty( $adres_firmy ) ) {
                                        $args['meta_query'][] = array(
                                            'key'     => 'adres_firmy',
                                            'value'   => $adres_firmy,
                                            'compare' => 'LIKE',
                                        );
                                    }
                                    if ( ! empty( $selectfilters ) && is_array( $selectfilters ) ) {
                                        $meta_query_or = array(
                                            'relation' => 'OR',
                                            array(
                                                'key'     => 'status_certyfikatu',
                                                'value'   => $selectfilters,
                                                'compare' => 'IN', 
                                            ),
                                        );
                                        $args['meta_query'][] = $meta_query_or;
                                    }
                                    $query = new WP_Query($args);
                                    $total_posts = $query->found_posts;
                                ?>
                                <div class="total-price-count">
                                    <span><?php _e('Liczba wyników: ' , 'KZR') ?></span>
                                    <span class="number-of-posts">
                                        <?php echo $total_posts; ?>
                                    </span>
                                </div>
                            </div>
                            <div class="col-lg-4 col-md-6">
                                <div class="posts-per-page">
                                    <label for="posts_per_page">
                                        <?php _e('Liczba wyników na stronie:' , 'KZR'); ?>
                                    </label>
                                    <select name="posts_per_page" id="posts_per_page" class="form-select">
                                        <option value="10">10</option>
                                        <option value="20">20</option>
                                        <option value="30">30</option>
                                        <option value="40">40</option>
                                        <option value="50">50</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <div class="status-filter">
                <div class="web-form">
                    <div class="row">
                        
                    </div>
                </div>
            </div>
            <div class="table-content-container">
                <div class="the-page-loader">
                    <span class="loader"></span>
                </div>
                <div class="table-block" id="filtesr-page-content">
                    <?php get_certificates_apply_filters_loop(); ?>
                </div>
            </div>
        <?php $output = ob_get_clean();
    return $output;
}
add_action('wp_ajax_get_certificates_apply_filters', 'get_certificates_apply_filters_loop');
add_action('wp_ajax_nopriv_get_certificates_apply_filters', 'get_certificates_apply_filters_loop');
