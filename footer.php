
	</div><!-- #content -->

	<footer id="colophon" class="site-footer section section--red" role="contentinfo">
		<?php bellaworks_watermark( 'halftone', 'tan', 0.16, 'right: -140px; bottom: -160px; width: 480px; height: 480px;' ); ?>
		<div class="wrapper">
			<div class="site-footer__row">
				<div class="site-footer__brand">
					<a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home">
						<img src="<?php echo esc_url( get_template_directory_uri() . '/images/logo-cream.svg' ); ?>" alt="<?php echo esc_attr( get_bloginfo( 'name' ) ); ?>" width="78" height="48">
					</a>
					<p class="site-footer__address">Bellaworks Web Design<br>436 E 36th Street<br>Charlotte, North Carolina 28205<br>P <a href="tel:+17043750831">704.375.0831</a><br>E <?php echo antispambot( 'info@bellaworksweb.com' ); ?></p>
				</div>
				<nav class="site-footer__nav" aria-label="<?php esc_attr_e( 'Footer', 'bellaworks' ); ?>">
					<?php
					wp_nav_menu( array(
						'theme_location' => 'footer',
						'container'      => false,
						'menu_class'     => 'site-footer__links',
						'fallback_cb'    => 'bellaworks_menu_fallback',
						'depth'          => 1,
					) );
					?>
				</nav>
			</div>
			<div class="site-footer__bottom">
				<span class="label">Charlotte</span>
				<?php bellaworks_star( 16, 'brown' ); ?>
				<span class="label">North Carolina</span>
			</div>
		</div>
	</footer>
</div><!-- #page -->

<?php wp_footer(); ?>
</body>
</html>
