<?php 
get_header(); 

if (!is_front_page()) {
    if (have_posts()) {
        while (have_posts()) {
            the_post(); ?>
            <section class="sub-page-header" style="background-image: url(<?php echo esc_url(get_the_post_thumbnail_url()); ?>);">
                <div class="container">
                    <div class="header-content">
                        <?php custom_breadcrumbs(); ?>
                        <div class="page-title">
                            <h1><?php the_title(); ?></h1>
                            <div class="excerpt-sec">
                                <?php the_excerpt(); ?>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
	<main class="main-wrap">
        <div class="container">
            <?php
            the_content();?>
        </div>
	</main>
<?php			
        }
    }
} else {
    if (have_posts()) {
        while (have_posts()) {
            the_post();
            the_content();
        }
    }
}

get_footer();
?>
