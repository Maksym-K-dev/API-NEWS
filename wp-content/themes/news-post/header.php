<?php
/**
 * The header for our theme
 *
 * This is the template that displays all of the <head> section and everything up until <div id="content">
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package News Post
 */

?>
<!doctype html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="profile" href="https://gmpg.org/xfn/11">

	<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
	<?php wp_body_open(); ?>
	<div id="page" class="site">
		<a class="skip-link screen-reader-text" href="#primary-content"><?php esc_html_e( 'Skip to content', 'news-post' ); ?></a>

		<div id="loader">
			<div class="loader-container">
				<div id="preloader">
					<div class="pre-loader-3"></div>
				</div>
			</div>
		</div><!-- #loader -->

		<?php $topbar_section = get_theme_mod( 'news_post_topbar_section_enable', true ); ?>

		<header id="masthead" class="site-header">

			<?php if ( $topbar_section === true ) { ?>
				<div class="theme-top-header">
					<div class="site-container-width">
						<div class="theme-top-header-wrapper">
							<div class="top-header-left">
								<span class="header-date"><?php echo esc_html( wp_date( 'D, M j, Y' ) ); ?></span>
								<div class="social-icons">
									<?php
									if ( has_nav_menu( 'social' ) ) {
										wp_nav_menu(
											array(
												'menu_class'  => 'menu social-links',
												'link_before' => '<span class="screen-reader-text">',
												'link_after'  => '</span>',
												'theme_location' => 'social',
											)
										);
									}
									?>
								</div>
							</div>
							<div class="top-header-right">
								<?php
								$header_btn     = get_theme_mod( 'news_post_header_button_label', __( 'Sign In', 'news-post' ) );
								$header_btn_url = get_theme_mod( 'news_post_header_button_url', '#' );
								?>
								<div class="header-search">
									<div class="header-search-wrap">
										<a href="#" title="Search" class="header-search-icon">
											<i class="fa fa-search"></i>
										</a>
										<div class="header-search-form">
											<?php get_search_form(); ?>
										</div>
									</div>
								</div>
								<span class="header-button">
									<a href="<?php echo esc_url( $header_btn_url ); ?>"><?php echo esc_html( $header_btn ); ?></a>
								</span>
							</div>
						</div>
					</div>
				</div>
			<?php } ?>

			<div class="middle-header-quick-menu">
				<?php if ( ! empty( get_header_image() ) ) { ?>
					<div class="theme-header-img">
						<img src="<?php echo esc_url( get_header_image() ); ?>" alt="<?php esc_attr_e( 'Header Image', 'news-post' ); ?>">
					</div>
				<?php } ?>
				<div class="site-middle-header">
					<div class="site-container-width">
						<div class="site-middle-header-wrapper">
							<div class="site-branding">
								<?php if ( has_custom_logo() ) { ?>
									<div class="site-logo">
										<?php the_custom_logo(); ?>
									</div>
									<?php
								}
									if ( get_theme_mod( 'news_post_header_text_display', true ) === true ) {
									?>
									<div class="site-identity">
										<?php if ( is_front_page() && is_home() ) : ?>
										<h1 class="site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></h1>
											<?php
										else :
											?>
											<p class="site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></p>
											<?php
										endif;
										$news_post_description = get_bloginfo( 'description', 'display' );
										if ( $news_post_description || is_customize_preview() ) :
											?>
											<p class="site-description"><?php echo $news_post_description; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></p>
											<?php
										endif;
										?>
									</div>
								<?php } ?>
							</div>
						</div>
					</div>
				</div>
			</div>

			<div class="theme-main-header">
				<div class="site-container-width">
					<div class="theme-main-header-wrapper">
						<div class="primary-nav">
							<div class="primary-nav-container">
								<div class="header-nav">
									<nav id="site-navigation" class="main-navigation">
										<button class="menu-toggle" aria-controls="primary-menu" aria-expanded="false">
											<span></span>
											<span></span>
											<span></span>
										</button>
										<?php
										if ( has_nav_menu( 'primary' ) ) {
											wp_nav_menu(
												array(
													'theme_location' => 'primary',
													'menu_id' => 'primary-menu',
												)
											);
										}
										?>
									</nav><!-- #site-navigation -->
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>

		</header><!-- #masthead -->

		<div id="primary-content" class="primary-site-content">
			
			<?php

			if ( ! is_front_page() || is_home() ) {

				if ( is_front_page() ) {

					require get_template_directory() . '/inc/frontpage-sections/sections.php';

				}

				?>

				<div id="content" class="site-content site-container-width">
					<div class="theme-wrapper">

					<?php } ?>
