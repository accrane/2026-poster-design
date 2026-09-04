<?php
/**
 * Single news post.
 *
 * Tan article (eyebrow, title, byline, banner image, prose) with previous /
 * next links, then a brown "More news" band with the three latest posts.
 *
 * @package bellaworks
 */

get_header();
the_post();

$cats     = get_the_category();
$cat      = ( $cats && 'Uncategorized' !== $cats[0]->name ) ? $cats[0] : null;
$words    = str_word_count( wp_strip_all_tags( get_the_content() ) );
$minutes  = max( 1, (int) round( $words / 200 ) );
$author   = ucfirst( get_the_author() );
$prev     = get_previous_post();
$next     = get_next_post();
$share    = rawurlencode( get_permalink() );
$share_t  = rawurlencode( get_the_title() );

$more_news = new WP_Query( array(
	'post_type'           => 'post',
	'post_status'         => 'publish',
	'posts_per_page'      => 3,
	'post__not_in'        => array( get_the_ID() ),
	'meta_key'            => '_thumbnail_id',
	'ignore_sticky_posts' => true,
	'no_found_rows'       => true,
) );
?>

<div id="primary" class="content-area">
	<main id="main" class="site-main" role="main">

		<article id="post-<?php the_ID(); ?>" <?php post_class( 'section section--tan post' ); ?>>
			<?php bellaworks_watermark( 'halftone', 'brown', 0.10, 'left: -140px; top: -120px; width: 460px; height: 460px;' ); ?>
			<div class="wrapper post__inner">

				<header class="post__head">
					<div class="page-hero__eyebrow post__eyebrow">
						<?php bellaworks_star( 18, 'red' ); ?>
						<a class="label" href="<?php echo esc_url( home_url( '/news/' ) ); ?>"><?php esc_html_e( 'News', 'bellaworks' ); ?></a>
						<?php if ( $cat ) : ?>
						<span class="label post__sep" aria-hidden="true">&bull;</span>
						<a class="label" href="<?php echo esc_url( get_category_link( $cat ) ); ?>"><?php echo esc_html( $cat->name ); ?></a>
						<?php endif; ?>
					</div>
					<h1 class="display post__title"><?php the_title(); ?></h1>
					<div class="post__meta">
						<span class="label"><?php echo esc_html( sprintf( __( 'By %s', 'bellaworks' ), $author ) ); ?></span>
						<time class="label" datetime="<?php echo esc_attr( get_the_date( 'c' ) ); ?>"><?php echo esc_html( get_the_date( 'F j, Y' ) ); ?></time>
						<span class="label"><?php echo esc_html( sprintf( _n( '%d min read', '%d min read', $minutes, 'bellaworks' ), $minutes ) ); ?></span>
					</div>
				</header>

				<?php if ( has_post_thumbnail() ) : ?>
				<figure class="thumb-card post__banner">
					<?php the_post_thumbnail( 'bellaworks-banner', array( 'loading' => 'eager', 'decoding' => 'async' ) ); ?>
				</figure>
				<?php endif; ?>

				<div class="post__body prose">
					<?php the_content(); ?>
				</div>

				<footer class="post__foot">
					<div class="post__share">
						<span class="label"><?php esc_html_e( 'Share', 'bellaworks' ); ?></span>
						<a class="label" href="https://www.linkedin.com/sharing/share-offsite/?url=<?php echo $share; ?>" target="_blank" rel="noopener">LinkedIn</a>
						<a class="label" href="https://www.facebook.com/sharer/sharer.php?u=<?php echo $share; ?>" target="_blank" rel="noopener">Facebook</a>
						<a class="label" href="https://x.com/intent/post?url=<?php echo $share; ?>&amp;text=<?php echo $share_t; ?>" target="_blank" rel="noopener">X</a>
						<a class="label" href="mailto:?subject=<?php echo $share_t; ?>&amp;body=<?php echo $share; ?>">Email</a>
					</div>
					<?php if ( $prev || $next ) : ?>
					<nav class="project-nav__row post__nav" aria-label="<?php esc_attr_e( 'More posts', 'bellaworks' ); ?>">
						<?php if ( $prev ) : ?>
						<a class="project-nav__link project-nav__link--prev" href="<?php echo esc_url( get_permalink( $prev ) ); ?>"><span class="label"><?php esc_html_e( 'Previous', 'bellaworks' ); ?></span><span class="display"><?php echo esc_html( get_the_title( $prev ) ); ?></span></a>
						<?php endif; ?>
						<?php if ( $next ) : ?>
						<a class="project-nav__link project-nav__link--next" href="<?php echo esc_url( get_permalink( $next ) ); ?>"><span class="label"><?php esc_html_e( 'Next', 'bellaworks' ); ?></span><span class="display"><?php echo esc_html( get_the_title( $next ) ); ?></span></a>
						<?php endif; ?>
					</nav>
					<?php endif; ?>
				</footer>
			</div>
		</article>

		<!-- MORE NEWS -->
		<?php if ( $more_news->have_posts() ) : ?>
		<section class="section section--brown more-news">
			<?php bellaworks_watermark( 'rings', 'tan', 0.08, 'right: -200px; top: -160px; width: 700px; height: 700px;' ); ?>
			<div class="wrapper more-news__inner">
				<div class="more-news__head">
					<h2 class="display"><?php esc_html_e( 'More news', 'bellaworks' ); ?></h2>
					<?php bellaworks_star( 44, 'red' ); ?>
				</div>
				<div class="more-news__grid">
					<?php while ( $more_news->have_posts() ) : $more_news->the_post(); ?>
					<a class="news-card" href="<?php the_permalink(); ?>">
						<span class="thumb-card news-card__thumb"><?php the_post_thumbnail( 'bellaworks-work', array( 'loading' => 'lazy', 'decoding' => 'async' ) ); ?></span>
						<time class="label news-card__date" datetime="<?php echo esc_attr( get_the_date( 'c' ) ); ?>"><?php echo esc_html( get_the_date( 'F j, Y' ) ); ?></time>
						<span class="display news-card__title"><?php the_title(); ?></span>
					</a>
					<?php endwhile; wp_reset_postdata(); ?>
				</div>
				<?php bellaworks_button( 'All News', home_url( '/news/' ), 'tan' ); ?>
			</div>
		</section>
		<?php endif; ?>

	</main>
</div>

<?php get_footer(); ?>
