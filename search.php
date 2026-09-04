<?php
/**
 * Search results across news, pages, services and projects.
 *
 * @package bellaworks
 */

get_header();

$term   = get_search_query();
$total  = (int) $GLOBALS['wp_query']->found_posts;
$paged  = max( 1, (int) get_query_var( 'paged' ) );
$labels = array( 'post' => __( 'News', 'bellaworks' ), 'page' => __( 'Page', 'bellaworks' ), 'service' => __( 'Service', 'bellaworks' ), 'portfolio' => __( 'Project', 'bellaworks' ) );
?>

<div id="primary" class="content-area">
	<main id="main" class="site-main" role="main">

		<section class="section section--tan page-hero news-index search-results">
			<?php bellaworks_watermark( 'rings', 'brown', 0.10, 'right: -160px; top: -120px; width: 620px; height: 620px;' ); ?>
			<div class="wrapper news-index__inner">
				<div class="page-hero__grid news-index__head">
					<div class="page-hero__copy">
						<div class="page-hero__eyebrow">
							<?php bellaworks_star( 18, 'red' ); ?>
							<span class="label"><?php esc_html_e( 'Search', 'bellaworks' ); ?></span>
						</div>
						<?php if ( $term ) : ?>
						<h1 class="display page-hero__title"><?php esc_html_e( 'Results for', 'bellaworks' ); ?><br><span class="text-red">&ldquo;<?php echo esc_html( $term ); ?>&rdquo;</span></h1>
						<p class="label search-results__count"><?php echo esc_html( sprintf( _n( '%d match', '%d matches', $total, 'bellaworks' ), $total ) ); ?></p>
						<?php else : ?>
						<h1 class="display page-hero__title"><?php esc_html_e( 'What are you looking for?', 'bellaworks' ); ?></h1>
						<?php endif; ?>
					</div>
					<div class="page-hero__art-col news-index__search">
						<?php get_template_part( 'parts/site-search', null, array( 'label' => __( 'Try another search', 'bellaworks' ) ) ); ?>
					</div>
				</div>

				<?php if ( have_posts() ) : ?>
				<div class="news-index__grid">
					<?php while ( have_posts() ) : the_post();
						get_template_part( 'parts/post-card', null, array( 'type_label' => isset( $labels[ get_post_type() ] ) ? $labels[ get_post_type() ] : '' ) );
					endwhile; ?>
				</div>
				<?php get_template_part( 'parts/pager', null, array( 'current' => $paged ) ); ?>
				<?php else : ?>
				<div class="search-results__empty">
					<?php bellaworks_star_rule( 'brown' ); ?>
					<h2 class="display"><?php esc_html_e( 'Nothing turned up.', 'bellaworks' ); ?></h2>
					<p><?php esc_html_e( 'Try a different word, or start from one of these.', 'bellaworks' ); ?></p>
					<div class="search-results__links">
						<?php bellaworks_button( 'Our Services', home_url( '/services/' ), 'brown' ); ?>
						<?php bellaworks_button( 'Our Work', home_url( '/our-work/' ), 'brown' ); ?>
						<?php bellaworks_button( 'The News', home_url( '/news/' ), 'brown' ); ?>
					</div>
				</div>
				<?php endif; ?>
			</div>
		</section>

		<?php get_template_part( 'parts/closer' ); ?>

	</main>
</div>

<?php get_footer(); ?>
