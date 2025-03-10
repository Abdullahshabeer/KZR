<?php
/**
 * Template Name: Szkolenia Categories
 */

get_header();

$page_id = get_the_ID();

// Retrieve the title, featured image, and excerpt
$page_title = get_the_title($page_id);
$page_excerpt = get_the_excerpt($page_id);
$featured_image_url = get_the_post_thumbnail_url($page_id, 'full');

function translate_month_to_polish_genitive($month_nominative) {
    $months = array(
        'styczeń'    => 'stycznia',
        'luty'       => 'lutego',
        'marzec'     => 'marca',
        'kwiecień'   => 'kwietnia',
        'maj'        => 'maja',
        'czerwiec'   => 'czerwca',
        'lipiec'     => 'lipca',
        'sierpień'   => 'sierpnia',
        'wrzesień'   => 'września',
        'październik'=> 'października',
        'listopad'   => 'listopada',
        'grudzień'   => 'grudnia',
    );

    // Return the genitive case if available
    return isset($months[$month_nominative]) ? $months[$month_nominative] : $month_nominative;
}
?>

<section class="sub-page-header" style="background-image: url('<?php echo esc_url($featured_image_url); ?>');">
    <div class="container">
        <div class="header-content">
            <div class="page-title">
                <h1><?php echo esc_html($page_title); ?></h1>
                <div class="excerpt-sec">
                    <?php echo esc_html($page_excerpt); ?>
                </div>
            </div>
        </div>
    </div>
</section>

<?php
// Capture search and date filters from URL parameters
$search_query = isset($_GET['ca']) ? sanitize_text_field($_GET['ca']) : '';
$date_from    = isset($_GET['date_from']) ? sanitize_text_field($_GET['date_from']) : '';
$date_to      = isset($_GET['date_to']) ? sanitize_text_field($_GET['date_to']) : '';

// Prepare the date query array
$meta_query = [];
if (!empty($date_from)) {
    $meta_query[] = [
        'key'     => '_event_start_date',
        'value'   => $date_from,
        'compare' => '>=', // Events starting from this date
        'type'    => 'DATE',
    ];
}
if (!empty($date_to)) {
    $meta_query[] = [
        'key'     => '_event_start_date',
        'value'   => $date_to,
        'compare' => '<=', // Events before this date
        'type'    => 'DATE',
    ];
}

// Handle pagination for future and past posts
$paged_future = get_query_var('paged') ? get_query_var('paged') : 1;
$paged_past = get_query_var('paged_past') ? get_query_var('paged_past') : 1;

// Get current date
$current_date = date('Y-m-d');

// Set up the custom query for future posts
$args_future = [
    'post_type'      => 'szkolenia',
    'posts_per_page' => 6,
    's'              => $search_query,
    'paged'          => $paged_future,
    'meta_query'     => array_merge($meta_query, [
        [
            'key'     => '_event_start_date',
            'value'   => $current_date,
            'compare' => '>=', // Show future events
            'type'    => 'DATE',
        ],
    ]),
    'meta_key'       => '_event_start_date',
    'orderby'        => 'meta_value',
    'order'          => 'ASC',
];

$query_future = new WP_Query($args_future);

// Set up the custom query for past posts
$args_past = [
    'post_type'      => 'szkolenia',
    'posts_per_page' => 6,
    's'              => $search_query,
    'paged'          => $paged_past,
    'meta_query'     => array_merge($meta_query, [
        [
            'key'     => '_event_start_date',
            'value'   => $current_date,
            'compare' => '<', // Show past events
            'type'    => 'DATE',
        ],
    ]),
    'meta_key'       => '_event_start_date',
    'orderby'        => 'meta_value',
    'order'          => 'DSC',
];

$query_past = new WP_Query($args_past);
?>

<main class="main-wrap">
    <div class="container">
        <div class="filter-wrap">
            <div class="web-form">
                <form method="get" action="">
                    <div class="row">
                        <!-- Search Field -->
                        <div class="col-xl-6 col-md-6">
                            <div class="form-group d-flex align-items-center">
                                <label for="search-field"><?php esc_html_e('Wyszukaj:', 'KZR'); ?></label>
                                <input type="text" class="form-control" id="search-field" name="ca" value="<?php echo esc_attr($search_query); ?>" placeholder="<?php esc_attr_e('Wpisz szukaną frazę', 'KZR'); ?>">
                            </div>
                        </div>

                        <!-- Date From Field -->
                        <div class="col-xl-2 col-md-4 col-sm-6">
                            <div class="form-group">
                                <input type="date" class="form-control" name="date_from" value="<?php echo esc_attr($date_from); ?>" placeholder="<?php esc_attr_e('Data od', 'KZR'); ?>">
                            </div>
                        </div>

                        <!-- Date To Field -->
                        <div class="col-xl-2 col-md-4 col-sm-6">
                            <div class="form-group">
                                <input type="date" class="form-control" name="date_to" value="<?php echo esc_attr($date_to); ?>" placeholder="<?php esc_attr_e('Data do', 'KZR'); ?>">
                            </div>
                        </div>

                        <!-- Submit Button -->
                        <div class="col-xl-2 col-md-4">
                            <div class="web-btn form-btn">
                                <button type="submit" class="btn btn-secondary"><?php esc_html_e('Szukaj', 'KZR'); ?></button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <div class="web-heading heading-divider">
            <h2><?php esc_html_e('Nadchodzące szkolenia', 'KZR'); ?></h2>
        </div>

        <?php if ($query_future->have_posts()) : ?>
            <div class="cards-wrap">
                <div class="row custom-space">
                    <?php while ($query_future->have_posts()) : $query_future->the_post();
                        // Get the custom post meta value
                        $event_date = get_post_meta(get_the_ID(), '_event_start_date', true);
                       
                        // Format the date if it exists
                        if ($event_date) {
                           
                            $day = date_i18n('j', strtotime($event_date));  // Day
                            $month_nominative = date_i18n('F', strtotime($event_date)); // Month
                            $month = get_polish_genitive_month($month_nominative);
                            $year = date_i18n('Y', strtotime($event_date));
                        } else {
                            $day = get_the_date('j');
                            $month = get_the_date('F');
                        }
                    ?>
                        <div class="col-xl-4 col-md-6">
                            <div class="web-card light-bg style-2">
                                <a href="<?php the_permalink(); ?>">
                                    <div class="content">
                                        <div class="date-meta">
                                            <h4><?php echo esc_html($day); ?></h4>
                                            <p><?php echo esc_html($month); ?><br> <?php echo esc_html($year); ?></p>
                                        </div>
                                        <h5><?php the_title(); ?></h5>
                                    </div>
                                </a>
                            </div>
                        </div>
                    <?php endwhile; ?>
                </div>
            </div>
            <!-- Pagination for upcoming trainings -->
            <div class="pagination-wrap">
                <div class="pagination-inner" role="navigation">
                    <?php
                    echo paginate_links([
                        'total'     => $query_future->max_num_pages,
                        'current'   => $paged_future,
                        'format'    => '?paged=%#%&paged_past=' . esc_attr($paged_past) . '&ca=' . esc_attr($search_query) . '&date_from=' . esc_attr($date_from) . '&date_to=' . esc_attr($date_to),
                        'prev_text' => '&#8249;',
                        'next_text' => '&#8250;',
                    ]);
                    ?>
                </div>
            </div>
        <?php else : ?>
            <p><?php _e('Brak wyników Nadchodzące szkolenia', 'KZR'); ?></p>
        <?php endif; ?>

        <div class="web-heading heading-divider">
            <h2><?php esc_html_e('Przeprowadzone', 'KZR'); ?></h2>
        </div>

        <?php if ($query_past->have_posts()) : ?>
            <div class="cards-wrap">
                <div class="row custom-space">
                    <?php while ($query_past->have_posts()) : $query_past->the_post();
                        // Get the custom post meta value
                        $event_date = get_post_meta(get_the_ID(), '_event_start_date', true);
                        $date = get_the_date();
                        
                        // Format the date if it exists
                        if ($event_date) {
                            $day = date_i18n('j', strtotime($event_date));  // Day
                            $month_nominative = date_i18n('F', strtotime($event_date)); // Month
                            $month = get_polish_genitive_month($month_nominative);
                            $year = date_i18n('Y', strtotime($event_date));
                        } else {
                            $day = get_the_date('j');
                            $month = get_the_date('F');
                        }
                    ?>
                        <div class="col-xl-4 col-md-6">
                            <div class="web-card light-bg style-2">
                                <a href="<?php the_permalink(); ?>">
                                    <div class="content">
                                        <div class="date-meta">
                                            <h4><?php echo esc_html($day); ?></h4>
                                            <p><?php echo esc_html($month); ?><br> <?php echo esc_html($year); ?></p>
                                        </div>
                                        <h5><?php the_title(); ?></h5>
                                    </div>
                                </a>
                            </div>
                        </div>
                    <?php endwhile; ?>
                </div>
            </div>
            <!-- Pagination for carried out trainings -->
            <div class="pagination-wrap">
                <div class="pagination-inner" role="navigation">
                    <?php
                    echo paginate_links([
                        'total'     => $query_past->max_num_pages,
                        'current'   => $paged_past,
                        'format'    => '?paged_past=%#%&paged=' . esc_attr($paged_future) . '&ca=' . esc_attr($search_query) . '&date_from=' . esc_attr($date_from) . '&date_to=' . esc_attr($date_to),
                        'prev_text' => '&#8249;',
                        'next_text' => '&#8250;',
                    ]);
                    ?>
                </div>
            </div>
        <?php else : ?>
            <p><?php _e('Nie znaleziono Przeprowadzone szkoleń.', 'KZR'); ?></p>
        <?php endif; ?>

        <?php wp_reset_postdata(); ?>
    </div>
</main>

<?php get_footer(); ?>
