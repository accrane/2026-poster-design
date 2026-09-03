<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="profile" href="http://gmpg.org/xfn/11">
<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<?php wp_body_open(); ?>
<div id="page" class="site">
	<a class="skip-link sr" href="#main"><?php esc_html_e( 'Skip to content', 'bellaworks' ); ?></a>

	<header id="masthead" class="site-header">
		<div class="wrapper site-header__row">
			<a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="site-logo" rel="home" aria-label="<?php echo esc_attr( get_bloginfo( 'name' ) ); ?>">
				<img src="<?php echo esc_url( get_template_directory_uri() . '/images/logo-dark.svg' ); ?>" alt="<?php echo esc_attr( get_bloginfo( 'name' ) ); ?>" width="72" height="44">
			</a>

			<button type="button" class="menu-toggle" aria-controls="site-navigation" aria-expanded="false" aria-label="<?php esc_attr_e( 'Menu', 'bellaworks' ); ?>">
				<span></span><span></span>
			</button>

			<nav id="site-navigation" class="site-nav" aria-label="<?php esc_attr_e( 'Primary', 'bellaworks' ); ?>">
				<?php
				wp_nav_menu( array(
					'theme_location' => 'primary',
					'container'      => false,
					'menu_class'     => 'site-nav__links',
					'fallback_cb'    => 'bellaworks_menu_fallback',
					'depth'          => 1,
				) );
				bellaworks_button( 'Book A Call', home_url( '/lets-do-this/' ), 'red', 'sm', false );
				?>
			</nav>
		</div>
	</header>
	<div class="site-header__spacer" aria-hidden="true"></div>

	<div id="content" class="site-content">
