<?php get_header(); ?>
<main class="main-wrap">
        <div class="container">
            <div class="error-page-wrap">
				<div class="image-404 text-center">
                <img src="<?php echo get_stylesheet_directory_uri(); ?>/images/404.svg" alt="<?php _e('error-404', 'KZR') ?>">
					
				</div>
				<div class="error-page-content text-center">
					<div class="web-heading">
						<h1><?php _e('Nie znaleziono strony', 'KZR') ?></h1>
					</div>
					<div class="web-btn d-flex justify-content-center">
	                    <a href="<?php echo esc_url(home_url('/')); ?>" class="btn btn-secondary"><img src="<?php echo get_stylesheet_directory_uri(); ?>/images/right.svg" alt="<?php _e('icon', 'KZR') ?>"><?php _e('wróć do strony głównej', 'KZR') ?></a>
	                </div>
				</div>
			</div>	
        </div>
    </main>
<?php get_footer(); ?>

