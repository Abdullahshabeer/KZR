<?php
/**
 * Category Archive Template with Date Filter
 */

get_header();

// Get current category object
$category = get_queried_object();
$image_id = '';
if (function_exists('get_term_meta')) {
    
    $image_id = get_term_meta($category->term_id, 'category_image', true); // Change 'category_image' to the actual meta key used to store the image
   
}
// Capture search and date filters from URL parameters
$search_query = isset($_GET['ca']) ? sanitize_text_field($_GET['ca']) : '';
$date_from    = isset($_GET['date_from']) ? sanitize_text_field($_GET['date_from']) : '';
$date_to      = isset($_GET['date_to']) ? sanitize_text_field($_GET['date_to']) : '';

// Prepare date query array
$date_query = [];

if (!empty($date_from)) {
    $date_query[] = [
        'after'     => $date_from,
        'inclusive' => true,
    ];
}

if (!empty($date_to)) {
    $date_query[] = [
        'before'    => $date_to,
        'inclusive' => true,
    ];
}

// Prepare arguments for WP_Query
$paged = get_query_var('paged') ? get_query_var('paged') : 1;

$args = [
    'post_type'      => 'post',
    'posts_per_page' => 6, // Adjust as needed
    'paged'          => $paged,
    's'              => $search_query,
    'cat'            => $category->term_id,
];

// Add date query if dates are set
if (!empty($date_query)) {
    $args['date_query'] = $date_query;
}

// Execute custom query
$query = new WP_Query($args);
?>

 <section class="sub-page-header" style="background-image: url('<?php echo esc_url($image_id); ?>');">
        <div class="container">
            <div class="header-content">
               <?php custom_breadcrumbs(); ?>
                <div class="page-title">
                <h1><?php echo esc_html($category->name); ?></h1>
                    <?php if (!empty($category->description)) : ?>
                    <div class="excerpt-sec">
                    <p><?php echo esc_html($category->description); ?></p>
                    </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </section>
<main class="main-wrap">
    <div class="container">
        <!-- Filter Form -->
        <div class="filter-wrap">
            <div class="web-form">
                <form method="get" action="<?php echo esc_url(get_category_link($category->term_id)); ?>">
                    <div class="row">
                        <!-- Search Field -->
                        <div class="col-xl-6 col-md-6">
                            <div class="form-group d-flex align-items-center">
                                <label for="search-field"><?php esc_html_e('Wyszukaj:', 'kzr'); ?></label>
                                <input type="text" class="form-control" id="search-field" name="ca" value="<?php echo esc_attr($search_query); ?>" placeholder="<?php _e('Wpisz szukaną frazę', 'kzr'); ?>">
                            </div>
                        </div>

                      <!-- Date From Field -->
                        <div class="col-xl-2 col-md-4 col-sm-6">
                            <div class="form-group">
                                <input type="text" class="form-control" name="date_from" id="date_from" value="<?php echo esc_attr($date_from); ?>" placeholder="<?php _e('Data od', 'kzr'); ?>" onfocus="this.type='date'" onblur="this.type='text'" />    
                            </div>
                        </div>

                        <!-- Date To Field -->
                        <div class="col-xl-2 col-md-4 col-sm-6">
                            <div class="form-group">
                                <input type="text" class="form-control" name="date_to" id="date_to" value="<?php echo esc_attr($date_to); ?>" placeholder="<?php _e('Data do', 'kzr'); ?>" onfocus="this.type='date'" onblur="this.type='text'" />   
                            </div>
                        </div>


                        <!-- Submit Button -->
                        <div class="col-xl-2 col-md-4">
                            <div class="web-btn form-btn">
                                <button type="submit" class="btn btn-secondary"><?php esc_html_e('Szukaj', 'kzr'); ?></button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <!-- Posts Listing -->
        <div class="cards-wrap">
            <div class="row custom-space">
                <?php if ($query->have_posts()) : ?>
                    <?php while ($query->have_posts()) : $query->the_post(); ?>
                        <div class="col-xl-4 col-md-6">
                            <div class="web-card light-bg border-radius">
                                <?php if (has_post_thumbnail()) : ?>
                                    <div class="article-featured-img">
                                        <a href="<?php the_permalink(); ?>">
                                            <?php the_post_thumbnail('full', ['alt' => get_the_title()]); ?>
                                        </a>
                                    </div>
                                <?php endif; ?>
                                <div class="content">
                                    <div class="meta-sec d-flex">
                                        <p><?php echo get_the_date('d.m.Y'); ?></p>
                                    </div>
                                    <div class="web-heading">
                                        <h4><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h4>
                                    </div>
                                    <div class="web-btn d-flex justify-content-end">
                                        <a href="<?php the_permalink(); ?>" class="link-btn">
                                            <span><?php esc_html_e('Czytaj więcej', 'kzr'); ?></span>
                                            <div class="icon">
                                                <img src="<?php echo esc_url(get_template_directory_uri()); ?>/images/right.svg" alt="" aria-hidden="true">
                                            </div>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endwhile; ?>
                <?php else : ?>
                    <div class="col-12">
                        <p><?php esc_html_e('Brak postów spełniających kryteria wyszukiwania.', 'kzr'); ?></p>
                    </div>
                <?php endif; ?>
            </div>

            <!-- Pagination -->
            <div class="pagination-wrap">
                <div class="pagination-inner" role="navigation">
                    <?php
                    echo paginate_links([
                        'total'        => $query->max_num_pages,
                        'current'      => max(1, get_query_var('paged')),
                        'format'       => '?paged=%#%',
                        'show_all'     => false,
                        'type'         => 'plain',
                        'prev_text'    => __('&#8249;', 'kzr'),
                        'next_text'    => __('&#8250;', 'kzr'),
                    ]);
                    ?>
                </div>
            </div>
        </div>
    </div>
</main>

<?php
wp_reset_postdata();
get_footer();
?>
