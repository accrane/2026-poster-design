<?php
/**
 * The main template file (fallback).
 *
 * @package bellaworks
 */

get_header(); ?>

<div id="primary" class="content-area">
	<main id="main" class="site-main" role="main">
		<section class="section section--tan page-body">
			<div class="wrapper">
				<?php if ( have_posts() ) : ?>
					<?php while ( have_posts() ) : the_post(); ?>
						<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
							<h1 class="display"><?php the_title(); ?></h1>
							<div class="entry-content"><?php the_content(); ?></div>
						</article>
					<?php endwhile; ?>
				<?php else : ?>
					<h1 class="display"><?php esc_html_e( 'Nothing found', 'bellaworks' ); ?></h1>
				<?php endif; ?>
			</div>
		</section>
	</main>
</div>

<?php get_footer(); ?>
