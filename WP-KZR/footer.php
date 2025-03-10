    <footer>
		<div class="footer-top">
			<div class="container">
				<div class="row">
					<div class="col-md-6" data-aos="fade-right" data-aos-easing="ease-out-back">
						<div class="row">
							<div class="col-xl-6">
								<div class="widget">
								<?php
									if (is_active_sidebar('footer-sidebar')) {
										dynamic_sidebar('footer-sidebar');
									}
								?>
								</div>
							</div>
							<div class="col-xl-6">
								<div class="map-sec">
									<?php
										if (is_active_sidebar('footer-sidebar-2')) {
											dynamic_sidebar('footer-sidebar-2');
										}
									?>
								</div>
							</div>
						</div>
					</div>
					<div class="col-md-6" data-aos="fade-left" data-aos-easing="ease-out-back">
						<div class="footer-menu">
							<?php 	
							wp_nav_menu(
								array(
									'theme_location' => 'footermenu',
									'container' => '',
									'menu_class' => '',
								)
								);
							?>
							
						</div>
						<?php 
						 $Registration_text = get_theme_mod( 'Registration_text' );
						 $Registration_url = get_theme_mod( 'Registration_url' );
						 $Registration_icon = get_theme_mod( 'Registration_icon' );
								if ( $Registration_url ) { ?>
						<div class="regs-login-btn">
							<a href="<?php echo $Registration_url ?>" class="btn btn-secondary"><img src="<?php echo $Registration_icon; ?>" alt="user"><?php if ( ! empty( $Registration_text ) ) { // Ensure the variable is checked properly ?>
										<?php echo esc_html( $Registration_text ); // Output the translated text safely ?>
									<?php } else { ?>
										<?php _e( 'Rejestracja/logowanie', 'KZR' ); // Fallback text if no translation is available ?>
									<?php } ?></a>
						    
						</div>
						<?php	} ?>
					</div>
				</div>	
			</div>
		</div>
		<div class="footer-bottom">
			<div class="container">
				<div class="footer-bottom-inner d-flex align-items-center justify-content-between" data-aos="fade-up" data-aos-offset="0" data-aos-duration="600" data-aos-anchor-placement="top-bottom">
					<div class="copy-right">
					  <p>Copyright © <?php echo date('Y'); ?> INiG – PIB</p>
					</div>
					<div class="footer-bottom-menu">
					   <?php 	
							wp_nav_menu(
								array(
									'theme_location' => 'footer-bottom-menu',
									'container' => '',
									'menu_class' => '',
								)
								);
							?>
					</div>
				</div>	
			</div>
		</div>
	</footer>
	<?php wp_footer(); ?>
  </body>
</html>