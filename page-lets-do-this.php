<?php
/**
 * Template for the inquiry page (slug: lets-do-this).
 * The page content holds the Gravity Form shortcode.
 *
 * @package bellaworks
 */

get_header(); ?>

<div id="primary" class="content-area">
	<main id="main" class="site-main" role="main">

		<!-- PAGE HERO (no illustration: the form is the object) -->
		<section class="section section--tan page-hero page-hero--form inquiry-hero">
			<?php bellaworks_watermark( 'halftone', 'brown', 0.12, 'right: -140px; top: -160px; width: 520px; height: 520px;' ); ?>
			<div class="wrapper inquiry-hero__inner">
				<div class="page-hero__eyebrow">
					<?php bellaworks_star( 18, 'red' ); ?>
					<span class="label"><?php the_title(); ?></span>
				</div>
				<h1 class="display page-hero__title">The start of<br>something <span class="script page-hero__script">big!</span></h1>
			</div>
		</section>

		<!-- FORM -->
		<section class="section section--tan inquiry">
			<?php bellaworks_watermark( 'rings', 'brown', 0.08, 'left: -220px; bottom: -220px; width: 640px; height: 640px;' ); ?>
			<div class="wrapper inquiry__grid">
				<div class="inquiry__form">
					<?php while ( have_posts() ) : the_post(); ?>
						<?php
						// Render the form shortcode directly: wpautop would wrap the form's
						// inline spans in <p> and sprinkle <br>, breaking the field layout.
						echo do_shortcode( get_the_content() ); // phpcs:ignore -- editor content + Gravity Forms output
						?>
					<?php endwhile; ?>
				</div>
				<aside class="inquiry__aside">
					<?php bellaworks_stamp( 'SIMPLE • BEAUTIFUL • SECURE • ', 220 ); ?>
					<address class="inquiry__address">
						<strong>Bellaworks Web Design</strong><br>
						436 E 36th Street<br>
						Charlotte, North Carolina 28205
					</address>
					<div class="inquiry__lines">
						<a href="tel:+17043750831"><span class="label">P</span> 704.375.0831</a>
						<a href="mailto:<?php echo antispambot( 'info@bellaworksweb.com' ); ?>"><span class="label">M</span> <?php echo antispambot( 'info@bellaworksweb.com' ); ?></a>
					</div>
				</aside>
			</div>
		</section>

	</main>
</div>

<?php get_footer(); ?>
