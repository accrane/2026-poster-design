<?php
/**
 * Archives: category, tag, date, author. Same listing as the News page.
 *
 * @package bellaworks
 */

get_header();

$term  = get_queried_object();
$title = is_category() || is_tag() ? single_term_title( '', false ) : wp_strip_all_tags( get_the_archive_title() );
$desc  = get_the_archive_description();
$paged = max( 1, (int) get_query_var( 'paged' ) );
?>

<div id="primary" class="content-area">
	<main id="main" class="site-main" role="main">

		<section class="section section--tan page-hero news-index">
			<?php bellaworks_watermark( 'halftone', 'brown', 0.12, 'left: -120px; bottom: -140px; width: 460px; height: 460px;' ); ?>
			<div class="wrapper news-index__inner">
				<div class="page-hero__grid news-index__head">
					<div class="page-hero__copy">
						<div class="page-hero__eyebrow">
							<?php bellaworks_star( 18, 'red' ); ?>
							<a class="label" href="<?php echo esc_url( home_url( '/news/' ) ); ?>"><?php esc_html_e( 'News', 'bellaworks' ); ?></a>
						</div>
						<h1 class="display page-hero__title"><?php echo esc_html( $title ); ?></h1>
						<?php if ( $desc ) : ?><div class="page-hero__text"><?php echo wp_kses_post( $desc ); ?></div><?php endif; ?>
					</div>
					<div class="page-hero__art-col news-index__search">
						<?php get_template_part( 'parts/site-search', null, array( 'label' => __( 'Search the news', 'bellaworks' ) ) ); ?>
					</div>
				</div>

				<?php get_template_part( 'parts/news-filters', null, array( 'active' => is_category() && $term ? (int) $term->term_id : -1 ) ); ?>

				<?php if ( have_posts() ) : ?>
				<div class="news-index__grid">
					<?php $i = 0; while ( have_posts() ) : the_post(); $i++;
						get_template_part( 'parts/post-card', null, array( 'feature' => ( 1 === $i && 1 === $paged ) ) );
					endwhile; ?>
				</div>
				<?php get_template_part( 'parts/pager', null, array( 'current' => $paged ) ); ?>
				<?php else : ?>
				<p><?php esc_html_e( 'Nothing here yet.', 'bellaworks' ); ?></p>
				<?php endif; ?>
			</div>
		</section>

		<?php get_template_part( 'parts/closer' ); ?>

	</main>
</div>

<?php get_footer(); ?>
