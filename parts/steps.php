<?php
/**
 * "Get started in three easy steps" band.
 *
 * Usage: get_template_part( 'parts/steps', null, array( 'color' => 'brown' | 'tan' ) );
 *
 * @package bellaworks
 */
$color = ( isset( $args['color'] ) && 'tan' === $args['color'] ) ? 'tan' : 'brown';
$ink   = 'tan' === $color ? 'brown' : 'tan';
?>
<section class="section section--<?php echo esc_attr( $color ); ?> steps<?php echo 'tan' === $color ? ' steps--tan' : ''; ?>">
	<?php bellaworks_watermark( 'rings', $ink, 0.08, 'left: 50%; top: -40px; width: 900px; height: 900px; margin-left: -450px;' ); ?>
	<?php if ( 'brown' === $color ) { bellaworks_watermark( 'halftone', 'tan', 0.14, 'left: -180px; bottom: -180px; width: 520px; height: 520px;' ); } ?>
	<div class="wrapper steps__inner">
		<div class="steps__head">
			<div class="script steps__script">Get Started in</div>
			<h2 class="display">Three easy steps</h2>
		</div>
		<div class="steps__grid">
			<div class="steps__item">
				<?php bellaworks_starburst( '01', '', 'red', 'tan', 16, 140 ); ?>
				<p><strong>Connect with us</strong> and dive into your website needs.</p>
			</div>
			<div class="steps__item">
				<?php bellaworks_starburst( '02', '', 'red', 'tan', 16, 140 ); ?>
				<p><strong>Receive a proposal</strong> for your business goals</p>
			</div>
			<div class="steps__item">
				<?php bellaworks_starburst( '03', '', 'red', 'tan', 16, 140 ); ?>
				<p><strong>Proudly share</strong> your website with the world and focus on what you enjoy</p>
			</div>
		</div>
		<?php bellaworks_button( 'Book A Call', home_url( '/lets-do-this/' ), 'red', 'lg' ); ?>
	</div>
</section>
