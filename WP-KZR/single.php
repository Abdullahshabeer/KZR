<?php
/**
 **  
 */
get_header();
?>
<section class="sub-page-header" style="background-image: url('<?php echo esc_url(get_the_post_thumbnail_url(get_the_ID(), 'full')); ?>');">
    <div class="container">
        <div class="header-content">
            <div class="page-title">
                <h1><?php the_title(); ?></h1>
            </div>
        </div>
    </div>
</section>

<main class="main-wrap">
    <div class="container">
        <div class="row sub-page-row custom-space">
            <!-- Sidebar -->
            <div class="col-xl-3 d-none d-xl-block">
            <div class="sidebar">
                <div class="web-heading heading-divider">
                   <h2><?php _e('Polecane','KZR'); ?></h2>
                </div>
                <div class="sidebar-articles">
                    <div class="row">
                        <?php
                        // Fetch and display related posts
                        $categories = get_the_category();
                        if ($categories) {
                            $category_ids = array_map(function($category) {
                                return $category->term_id;
                            }, $categories);

                            $related_args = array(
                                'category__in'   => $category_ids,
                                'post__not_in'   => array(get_the_ID()),
                                'posts_per_page' => 3, // Adjust the number of related posts
                            );

                            $related_query = new WP_Query($related_args);

                            if ($related_query->have_posts()) :
                                while ($related_query->have_posts()) : $related_query->the_post(); ?>
                                    <div class="col-xl-12">
                                        <div class="web-card light-bg border-radius">
                                            <div class="content">
                                                <div class="meta-sec d-flex">
                                                    <p><?php echo get_the_date('d.m.Y'); ?></p>
                                                </div>
                                                <div class="web-heading">
                                                    <h5><?php the_title(); ?></h5>
                                                </div>
                                                <div class="web-btn d-flex justify-content-end">
                                                    <a href="<?php the_permalink(); ?>" class="link-btn">
                                                        <span>Czytaj więcej</span>
                                                        <div class="icon">
                                                            <img src="<?php echo esc_url(get_template_directory_uri() . '/images/right.svg'); ?>" alt="">
                                                        </div>
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                <?php endwhile;
                                wp_reset_postdata();
                            else : ?>
                                <div class="col-xl-12">
                                    <p><?php esc_html_e('No related posts found.', 'KZR'); ?></p>
                                </div>
                            <?php endif;
                        }
                        ?>
                    </div>
                </div>
            </div>
        </div>

            <!-- Main Content -->
            <div class="col-xl-9">
                <?php
                if (have_posts()) :
                    while (have_posts()) : the_post();?>
                    <div class="date-sec text-end mb-2">
                        <p><?php echo get_the_date('d.m.Y'); ?></p>
                    </div>
                     <?php   the_content();
                    endwhile;
                else :
                    echo '<p>' . esc_html__('No content found.', 'KZR') . '</p>';
                endif;
                ?>
            </div>
        </div>
    </div>
</main>


<?php
get_footer()
?>