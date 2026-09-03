<?php
/**
 * Default page template.
 *
 * @package bellaworks
 */

get_header(); ?>

<div id="primary" class="content-area">
	<main id="main" class="site-main" role="main">
		<?php while ( have_posts() ) : the_post(); ?>
			<section class="section section--tan page-body">
				<div class="wrapper">
					<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
						<h1 class="display"><?php the_title(); ?></h1>
						<div class="entry-content"><?php the_content(); ?></div>
					</article>
				</div>
			</section>
		<?php endwhile; ?>
	</main>
</div>

<?php get_footer(); ?>
