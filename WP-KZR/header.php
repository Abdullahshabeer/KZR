<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
     <meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title><?php wp_title('|', true, 'right'); bloginfo('name'); ?></title>
	<link rel="preconnect" href="https://fonts.googleapis.com">
	<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
	<link href="https://fonts.googleapis.com/css2?family=Inter:ital,opsz,wght@0,14..32,100..900;1,14..32,100..900&display=swap" rel="stylesheet">
	<?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
	<header class="main-header">
		<a class="skip-link screen-reader-text" href="#content-full"><?php _e('przejdź do treści' , 'kzr') ?></a>
		<div class="top-header">
			<div class="container">
				<div class="main-header-inner d-flex align-items-center justify-content-between">
				   <div class="logo-sec" data-aos="fade-down">
					   <?php
						if ( function_exists( 'has_custom_logo' ) && has_custom_logo() ) {
							$logo = wp_get_attachment_image_src( get_theme_mod( 'custom_logo' ), 'full' );
							$alt_text = __('logo kzr link do strony głównej', 'kzr');
							echo '<a href="' . esc_url( home_url( '/' ) ) . '" title="'. esc_attr( $alt_text ) .'"><img src="' . esc_url( $logo[0] ) . '" alt="' . esc_attr( $alt_text ) . '"></a>';
						} else {
							echo '<h1><a href="' . esc_url( home_url( '/' ) ) . '">' . get_bloginfo( 'name' ) . '</a></h1>';
						}
						?>
					</div>
					<div class="header-right-sec d-flex align-items-center">
						<div class="search-form-wrap" data-aos="fade-down">
							<div class="search-form-sec">
								<form class="search-form" action="<?php  echo home_url()  ?>">
								<?php 
                                        if(isset($_GET['s'])){
                                            $value = $_GET['s'];
                                        }
                                        else{
                                            $value = '';
                                        }
                                    ?>
									<input class="form-control" type="text" name ='s' placeholder="<?php _e('Szukaj' , 'KZR') ?>" aria-label="Szukaj" minlength="3" required value="<?php echo $value ?>">
									<img src="<?php echo get_stylesheet_directory_uri(); ?>/images/search-icon.svg" alt="<?php _e('Wyszukaj' , 'kzr') ?>">
								</form>
							</div>
						</div>
						<div class="language-btn site-navigation" data-aos="fade-down" data-aos-delay="200">
							<div class="globe-icon">
								<img src="<?php echo get_stylesheet_directory_uri(); ?>/images/globe.svg" alt="<?php _e('wybierz język' , 'kzr') ?>">
							</div> 
							<?php
							wp_nav_menu(
								array(
									'theme_location' => 'languagechange',
									'container' => '',
								)
							); ?>
							
						</div>
						 <?php 
						 $Registration_text = get_theme_mod( 'Registration_text' );
						 $Registration_url = get_theme_mod( 'Registration_url' );
						 $Registration_icon = get_theme_mod( 'Registration_icon' );
						 
						 // Apply translation filter for WPML
						//  $Registration_text_translated = apply_filters( 'wpml_translate_single_string', $Registration_text, 'Theme Customizer', 'Registration_text' );
						 
						 if ( $Registration_url ) { ?>
							 <div class="regs-login-btn" data-aos="fade-down" data-aos-delay="400">
							 <a href="<?php echo esc_url( $Registration_url ); ?>" class="btn btn-secondary">
									<img src="<?php echo esc_url( $Registration_icon ); ?>" aria-label="<?php esc_attr_e( 'link zewnętrzny', 'kzr' ); ?>" alt="">
									
									<?php 
										// Retrieve translated text
										$registration_text_translated = function_exists( 'icl_t' ) ? icl_t( 'Theme Customizer', 'Registration_text', $Registration_text ) : $Registration_text;

										if ( ! empty( $registration_text_translated ) ) {
											echo esc_html( $registration_text_translated ); // Output the translated text safely
										} else {
											_e( 'Rejestracja/logowanie', 'kzr' ); // Fallback text if no translation is available
										}
									?>
								</a>
							 </div>
						 <?php }?>
						<div class="toggle-button hidden-destop" data-aos="fade-down" data-aos-delay="300">
							<span class="line one"></span>
							<span class="line two"></span>
							<span class="line three"></span>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="site-navigation-wrap">
			<div class="container">
				<div class="site-navigation align-items-center justify-content-end">
					<div class="search-form-wrap hidden-destop">
						<div class="search-form-sec">
							<form class="search-form" role="search" action="<?php  echo home_url()  ?>">
							<input class="form-control" type="text" name ='s' placeholder="Szukaj" aria-label="Szukaj" value="<?php echo $value ?>">
								<img src="<?php echo get_stylesheet_directory_uri(); ?>/images/search-icon.svg" alt="search icon">
							</form>
						</div>
					</div>
					<div class="language-btn mobile-lang hidden-destop">
						<div class="globe-icon">
						<img src="<?php echo get_stylesheet_directory_uri(); ?>/images/globe.svg" alt="ln">
						</div>
						<?php
							wp_nav_menu(
								array(
									'theme_location' => 'mobilelanguagechange',
									'container' => '',
								)
							); ?>  
					</div>
					<div class="main-menu-wrap d-flex align-items-center" data-aos="fade-down" data-aos-delay="300">
					<?php 	
					class Custom_Menu_Walker extends Walker_Nav_Menu {
						// Start element output
						function start_el(&$output, $item, $depth = 0, $args = null, $id = 0) {
							$icon_url = get_post_meta($item->ID, '_cutstom_icon_url', true);
							$content = $icon_url ? '<img class="svg" src="' . esc_url($icon_url) . '" alt="SVG Image">' : '';
							// $svgcontent =   wp_remote_get($icon_url);
							
							$output .= '<li class="' . implode(' ', $item->classes) . '">';
							$output .= '<a href="' . esc_url($item->url) . '">' . $content . $item->title . '</a>';
						}
						
						// End element output
						function end_el(&$output, $item, $depth = 0, $args = null) {
							$output .= '</li>';
						}
					}
					
					wp_nav_menu(
						array(
							'theme_location' => 'primary',
							'container' => '',
							'menu_class' => 'd-flex align-items-center',
							'walker' => new Custom_Menu_Walker(), // Custom walker now defined
						)
					);
					
					
						?>
						<?php
						if ( $Registration_url ) { ?>
						<div class="regs-login-btn d-none">
							<a href="<?php echo $Registration_url ?>" class="btn btn-secondary" aria-label="<?php _e('link zewnętrzny' , 'kzr') ?>"><img src="<?php echo $Registration_icon; ?>" alt=""><?php echo $Registration_text ?></a>
						    
						</div>
						<?php	} ?>
					</div>
					
				</div>
			</div>
		</div>
	</header>
	<div id="content-full"></div>
	
