<?php
/**
 * Template for the Contact page (slug: contact-us).
 * No ACF fields on this page today; copy mirrors the live site.
 *
 * @package bellaworks
 */

get_header(); ?>

<div id="primary" class="content-area">
	<main id="main" class="site-main" role="main">

		<!-- PAGE HERO -->
		<section class="section section--tan page-hero contact-hero">
			<?php bellaworks_watermark( 'halftone', 'brown', 0.12, 'left: -120px; bottom: -140px; width: 460px; height: 460px;' ); ?>
			<div class="wrapper page-hero__grid">
				<div class="page-hero__copy">
					<div class="page-hero__eyebrow">
						<?php bellaworks_star( 18, 'red' ); ?>
						<span class="label">Charlotte, North Carolina</span>
					</div>
					<h1 class="display page-hero__title"><?php the_title(); ?></h1>
					<address class="contact-hero__address">
						<strong>Bellaworks Web Design</strong><br>
						436 E 36th Street<br>
						Charlotte, North Carolina 28205
					</address>
					<div class="contact-hero__lines">
						<a class="contact-hero__line" href="tel:+17043750831">
							<span class="label">P</span>
							<span class="contact-hero__value">704.375.0831</span>
						</a>
						<a class="contact-hero__line" href="mailto:<?php echo antispambot( 'info@bellaworksweb.com' ); ?>">
							<span class="label">M</span>
							<span class="contact-hero__value"><?php echo antispambot( 'info@bellaworksweb.com' ); ?></span>
						</a>
					</div>
				</div>
				<div class="page-hero__art-col">
					<div class="page-hero__art retro-object retro-object--phone">
						<?php bellaworks_retro_info( 'This is what used to be known as a telephone.', 'phone' ); ?>
						<img src="<?php echo esc_url( get_template_directory_uri() . '/images/contact-phone.png' ); ?>" alt="" width="520" height="520">
					</div>
				</div>
			</div>
			<div class="label page-hero__vertical">Simple • Beautiful • Secure</div>
		</section>

		<!-- TWO WAYS IN -->
		<section class="section section--brown contact-ctas">
			<?php bellaworks_watermark( 'star', 'tan', 0.10, 'left: -150px; top: -150px; width: 560px; height: 560px; transform: rotate(-14deg);' ); ?>
			<?php bellaworks_watermark( 'halftone', 'tan', 0.18, 'right: -140px; bottom: -160px; width: 480px; height: 480px;' ); ?>
			<div class="wrapper contact-ctas__grid">
				<div class="contact-ctas__item">
					<?php bellaworks_star( 26, 'red' ); ?>
					<h2 class="display">Ready to start a project?</h2>
					<?php bellaworks_button( 'Contact Us', home_url( '/lets-do-this/' ), 'tan' ); ?>
				</div>
				<div class="contact-ctas__item">
					<?php bellaworks_star( 26, 'red' ); ?>
					<h2 class="display">Existing customer?</h2>
					<p>Need to submit a work order?</p>
					<?php bellaworks_button( 'Submit Order Here', home_url( '/work-order-request/' ), 'tan' ); ?>
				</div>
			</div>
		</section>

	</main>
</div>

<?php get_footer(); ?>
