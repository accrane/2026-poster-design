<?php
/**
 * Card for a post in a listing (news index, archives, search).
 *
 * get_template_part( 'parts/post-card', null, array( 'feature' => bool, 'type_label' => '' ) )
 *
 * @package bellaworks
 */
$feature    = ! empty( $args['feature'] );
$type_label = isset( $args['type_label'] ) ? $args['type_label'] : '';
$cats       = 'post' === get_post_type() ? get_the_category() : array();
$cat        = ( $cats && 'Uncategorized' !== $cats[0]->name ) ? $cats[0] : null;
$excerpt    = wp_trim_words( wp_strip_all_tags( strip_shortcodes( get_the_excerpt() ) ), $feature ? 40 : 22, '&hellip;' );
?>
<a class="news-card<?php echo $feature ? ' news-card--feature' : ''; ?>" href="<?php the_permalink(); ?>">
	<?php if ( has_post_thumbnail() ) : ?>
	<span class="thumb-card news-card__thumb"><?php the_post_thumbnail( $feature ? 'bellaworks-banner' : 'bellaworks-work', array( 'loading' => $feature ? 'eager' : 'lazy', 'decoding' => 'async' ) ); ?></span>
	<?php else : ?>
	<span class="thumb-card news-card__thumb news-card__thumb--empty"><?php bellaworks_star( 40, 'red' ); ?></span>
	<?php endif; ?>
	<span class="news-card__body">
		<span class="news-card__meta">
			<?php if ( $type_label ) : ?><span class="label news-card__type"><?php echo esc_html( $type_label ); ?></span><?php endif; ?>
			<?php if ( 'post' === get_post_type() ) : ?><time class="label news-card__date" datetime="<?php echo esc_attr( get_the_date( 'c' ) ); ?>"><?php echo esc_html( get_the_date( 'F j, Y' ) ); ?></time><?php endif; ?>
			<?php if ( $cat ) : ?><span class="label news-card__cat"><?php echo esc_html( $cat->name ); ?></span><?php endif; ?>
		</span>
		<span class="display news-card__title"><?php the_title(); ?></span>
		<?php if ( $excerpt ) : ?><span class="news-card__excerpt"><?php echo esc_html( $excerpt ); ?></span><?php endif; ?>
	</span>
</a>
