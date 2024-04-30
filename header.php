<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no, viewport-fit=cover">
	<!-- FA added -->
	<script src="https://kit.fontawesome.com/c20cab8581.js" crossorigin="anonymous"></script>
	<?php wp_head(); ?>
</head>

<?php
	$navbar_scheme = get_theme_mod( 'navbar_scheme', 'navbar-light bg-light' ); // get custom meta-value
	$navbar_position = get_theme_mod( 'navbar_position', 'static' ); // get custom meta-value

	$search_enabled = get_theme_mod( 'search_enabled', '1' ); // get custom meta-value
?>

<body <?php body_class(); ?>>

		<?php 
		if ( function_exists( 'wp_body_open' ) ) {
			wp_body_open(); 
		}
		?>

		<a class="skip-link button" href="#site-content"><?php _e( 'Skip to the content', 'rosewood' ); ?></a>

		<header class="site-header group">


			<h1 class="site-title"><a href="<?php echo esc_url( home_url() ); ?>" class="site-name"><?php bloginfo( 'name' ); ?></a></h1>

			<?php if ( get_bloginfo( 'description' ) ) : ?>

				<div class="site-description"><?php echo wpautop( get_bloginfo( 'description' ) ); ?></div>

			<?php endif; ?>
			<!-- nav toggle -->
			<div class="nav-toggle">
				<div class="bar"></div>
				<div class="bar"></div>
			</div>
			<!-- menu wrapper -->
			<div class="menu-wrapper">

				<ul class="main-menu desktop">

					<?php

					if ( has_nav_menu( 'main-menu' ) ) {

						$main_menu_args = array(
							'container' 		=> '',
							'items_wrap' 		=> '%3$s',
							'theme_location' 	=> 'main-menu',
						);

						wp_nav_menu( $main_menu_args );

					} else {

						$fallback_args = array(
							'container' => '',
							'title_li' 	=> '',
						);

						wp_list_pages( $fallback_args );
					}
					?>
				</ul>

			</div><!-- .menu-wrapper -->

			<?php if ( has_nav_menu( 'social-menu' ) || ( ! get_theme_mod( 'rosewood_hide_social' ) || is_customize_preview() ) ) : ?>

				<div class="social-menu desktop">

					<ul class="social-menu-inner">

						<li class="social-search-wrapper"><a href="<?php echo esc_url( home_url( '?s=' ) ); ?>"></a></li>

						<?php

						$social_args = array(
							'theme_location'	=> 'social-menu',
							'container'			=> '',
							'container_class'	=> 'menu-social group',
							'items_wrap'		=> '%3$s',
							'menu_id'			=> 'menu-social-items',
							'menu_class'		=> 'menu-items',
							'depth'				=> 1,
							'link_before'		=> '<span class="screen-reader-text">',
							'link_after'		=> '</span>',
							'fallback_cb'		=> '',
						);

						wp_nav_menu( $social_args );

						?>

					</ul><!-- .social-menu-inner -->

				</div><!-- .social-menu -->

			<?php endif; ?>

		</header><!-- header -->

		<div class="mobile-menu-wrapper">

			<ul class="main-menu mobile">
				<?php
				if ( has_nav_menu( 'main-menu' ) ) {
					wp_nav_menu( $main_menu_args );
				} else {
					wp_list_pages( $fallback_args );
				}
				if ( ! get_theme_mod( 'rosewood_hide_social', false ) ) : ?>
					<li class="toggle-mobile-search-wrapper"><a href="#" class="toggle-mobile-search"><?php _e( 'Search', 'rosewood' ); ?></a></li>
				<?php endif; ?>
			</ul><!-- .main-menu.mobile -->

			<?php if ( has_nav_menu( 'social-menu' ) && ( ! get_theme_mod( 'rosewood_hide_social', false ) || is_customize_preview() ) ) : ?>

				<div class="social-menu mobile">

					<ul class="social-menu-inner">

						<?php wp_nav_menu( $social_args ); ?>

					</ul><!-- .social-menu-inner -->

				</div><!-- .social-menu -->

			<?php endif; ?>

		</div><!-- .mobile-menu-wrapper -->

		<?php if ( ! get_theme_mod( 'rosewood_hide_social', false ) ) : ?>

			<div class="mobile-search">

				<div class="untoggle-mobile-search"></div>

				<?php get_search_form(); ?>

				<div class="mobile-results">

					<div class="results-wrapper"></div>

				</div>

			</div><!-- .mobile-search -->

			<div class="search-overlay">

				<?php get_search_form(); ?>

			</div><!-- .search-overlay -->

		<?php endif; ?>

		<main class="site-content" id="site-content">