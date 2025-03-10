<?php

/**
 **  Template Name: Search Page
 */
get_header();

?>
<section class="sub-page-header" style="background-image: url(<?php echo get_stylesheet_directory_uri(); ?>/images/page-banner-1.png);">
	<div class="container">
		<div class="header-content">
		    <?php custom_breadcrumbs(); ?>
			<div class="page-title">
				<h1><?php _e('Wyniki wyszukiwania', 'KZR'); ?></h1>
			</div>
		</div>
	</div>
</section>
	<main class="main-wrap">
		<div class="container">
			<?php
				if (is_active_sidebar('search-sidebar')) {
					?>
					<div class="info-card">
						<?php dynamic_sidebar('search-sidebar'); ?>
					</div>
					<?php
				}
			?>

			<!-- Search Result Wrapper -->
			<div class="search-result-wrap">
				<!-- Search Form -->
				<div class="filter-wrap">
					<div class="web-form">
					<form role="search" method="get" class="search-form" action="<?php echo esc_url(home_url('/')); ?>">
						<div class="row">
							<div class="col-xl-4 col-md-6">
								<div class="form-group d-flex align-items-center">
									<label for="search-field"><?php _e('Wyszukaj:', 'KZR'); ?></label>
									<input type="text" id="search-field" class="form-control" name="s" placeholder="Wpisz szukaną fazę" autocomplete="off" value="<?php echo get_search_query(); ?>">
								</div>
							</div>
							<div class="col-xl-2 col-md-6">
								<div class="form-group">
									<select class="form-select" name="category">
										<option value=""><?php _e('Kategoria', 'KZR'); ?></option>
										<?php
										 $selected_category = isset($_GET['category']) ? $_GET['category'] : ''; // Get the selected category
										print_r($selected_category);
										$categories = get_categories();
										foreach ($categories as $category) {
											$selected = ($category->term_id == $selected_category) ? 'selected' : '';
											echo '<option value="' . esc_attr($category->term_id) . '" ' . $selected . '>' . esc_html($category->name) . '</option>';
										}
										?>
									</select>
								</div>
							</div>
							<div class="col-xl-2 col-md-4 col-sm-6">
								<div class="form-group">
									<input type="text" class="form-control" name="date_from" id="date_from" value="<?php echo isset($_GET['date_from']) ? esc_attr($_GET['date_from']) : ''; ?>" placeholder="<?php _e('Data od', 'kzr'); ?>" onfocus="this.type='date'" onblur="this.type='text'" />    
								</div>
							</div>

							<!-- Date To Field -->
							<div class="col-xl-2 col-md-4 col-sm-6">
								<div class="form-group">
									<input type="text" class="form-control" name="date_to" id="date_to" value="<?php echo isset($_GET['date_to']) ? esc_attr($_GET['date_to']) : ''; ?>" placeholder="<?php _e('Data do', 'kzr'); ?>" onfocus="this.type='date'" onblur="this.type='text'" />   
								</div>
							</div>
							<div class="col-xl-2 col-md-4">
								<div class="web-btn form-btn">
									<button type="submit" class="btn btn-secondary"><?php _e('Szukaj', 'KZR'); ?></button>
								</div>
							</div>
						</div>
					</form>

					</div>
				</div>

				<!-- Search Results Info -->
				<div class="search-result-info d-flex align-items-center justify-content-between">
				<div class="search-for">
						<p><?php printf('Wyniki wyszukiwania dla „%s”', get_search_query()); ?></p>
					</div>
					<div class="view-more-filter">
						<form action="<?php echo esc_url(home_url('/')); ?>" method="get">
							<?php
							// Retain all the query parameters in the form submission
							foreach ($_GET as $key => $value) {
								if ($key !== 'results_per_page') { // Exclude 'results_per_page' as it will be set by the dropdown
									echo '<input type="hidden" name="' . esc_attr($key) . '" value="' . esc_attr($value) . '">';
								}
							}
							?>
							<div class="form-group d-flex align-items-center justify-content-end">
								<label for="result-view"><?php _e('Wyniki wyszukiwania', 'KZR'); ?></label>
								<select class="form-select" name="results_per_page" id="result-view" onchange="this.form.submit()">
									<option value="10" <?php selected(isset($_GET['results_per_page']) ? $_GET['results_per_page'] : '10', '10'); ?>>10</option>
									<option value="25" <?php selected(isset($_GET['results_per_page']) ? $_GET['results_per_page'] : '10', '25'); ?>>25</option>
									<option value="50" <?php selected(isset($_GET['results_per_page']) ? $_GET['results_per_page'] : '10', '50'); ?>>50</option>
									<option value="100" <?php selected(isset($_GET['results_per_page']) ? $_GET['results_per_page'] : '10', '100'); ?>>100</option>
								</select>
							</div>
						</form>
					</div>
				</div>

				<!-- Search Results -->
				<div class="cards-wrap">
					<?php if (have_posts()) : ?>
						<div class="row custom-space">
							<?php while (have_posts()) : the_post(); 
							 $event_date = get_post_meta(get_the_ID(), 'event_start_date', true);
             
							 // Format the date if it exists
							 if ($event_date) {
								$day = date('d.m.Y', strtotime($event_date));
							 } else {
								 // Fallback to the post's publish date if the event date is not set
								 $day = get_the_date('d.m.Y');  
								 
							 }
							?>

								<div class="col-md-12">
									<div class="web-card light-bg border-radius">
										<div class="content">
											<div class="meta-sec d-flex">
												<p><?php echo $day; ?></p>
												<div class="category-sec">
													<?php
													if (get_post_type() === 'post') {
														if (has_category()) {
															the_category(', ');
														} else {
															the_title();
														}
													} elseif (get_post_type() === 'page') {
														echo __('Strona', 'KZR');
													} else {
														if (has_category()) {
															the_category(', ');
														} else {
															the_title();
														}
													}
													?>
												</div>
											</div>
											<div class="web-heading">
												<h4><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h4>
											</div>
											<p><?php echo wp_trim_words(get_the_excerpt(), 30); ?></p>
											<div class="web-btn d-flex justify-content-end">
												<a href="<?php the_permalink(); ?>" class="link-btn">
													<span><?php _e('Czytaj więcej', 'KZR'); ?></span>
													<div class="icon">
														<img src="<?php echo get_template_directory_uri(); ?>/images/right.svg" alt="">
													</div>
												</a>
											</div>
										</div>
									</div>
								</div>
							<?php endwhile; ?>
						</div>
					<?php else : ?>
						<div class="no-result">
							<p><?php _e('Brak wyników dla poszukiwanej frazy. Prosimy zmienić słowa kluczowe i spróbować ponownie.', 'KZR'); ?></p>
						</div>
					<?php endif; ?>
				</div>

				<!-- Pagination -->
				<div class="pagination-wrap">
					<div class="pagination-inner" role="navigation">
						<?php
						the_posts_pagination(array(
							'mid_size' => 2,
							'prev_text' => '&#8249;',
							'next_text' => '&#8250;',
							
						));
						?>
					</div>
				</div>
			</div>
		</div>
	</main>     
<?php
get_footer();
?>

        