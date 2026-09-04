<?php
/**
 * 404: nothing here.
 *
 * @package bellaworks
 */

get_header(); ?>

<div id="primary" class="content-area">
	<main id="main" class="site-main" role="main">

		<section class="section section--tan page-hero notfound">
			<?php bellaworks_watermark( 'rings', 'brown', 0.10, 'right: -160px; top: -120px; width: 620px; height: 620px;' ); ?>
			<?php bellaworks_watermark( 'halftone', 'brown', 0.12, 'left: -120px; bottom: -140px; width: 460px; height: 460px;' ); ?>
			<div class="wrapper page-hero__grid">
				<div class="page-hero__copy">
					<div class="page-hero__eyebrow">
						<?php bellaworks_star( 18, 'red' ); ?>
						<span class="label"><?php esc_html_e( 'Error 404', 'bellaworks' ); ?></span>
					</div>
					<h1 class="display page-hero__title">You must<br>be lost.<span class="script page-hero__script">This is how we used to ask for directions.</span></h1>
					<div class="page-hero__text">
						<p><?php esc_html_e( 'The page you were after has moved on, or never existed. Roll on back to the homepage, or holler and we\'ll point you the right way.', 'bellaworks' ); ?></p>
					</div>
					<div class="notfound__actions">
						<?php bellaworks_button( 'Back To The Homepage', home_url( '/' ), 'brown' ); ?>
						<?php bellaworks_button( 'Ask For Directions', home_url( '/contact-us/' ), 'red' ); ?>
					</div>
					<?php get_template_part( 'parts/site-search', null, array( 'label' => __( 'Or search the site', 'bellaworks' ), 'value' => '' ) ); ?>
				</div>
				<div class="page-hero__art-col">
					<div class="page-hero__art retro-object retro-object--crank">
						<?php bellaworks_retro_info( 'Can you imagine having to roll your window down manually?', 'crank' ); ?>
						<img src="<?php echo esc_url( get_template_directory_uri() . '/images/notfound-crank.png' ); ?>" alt="" width="520" height="520">
					</div>
				</div>
			</div>
			<div class="label page-hero__vertical">Simple • Beautiful • Secure</div>
		</section>

	</main>
</div>

<?php get_footer(); ?>
