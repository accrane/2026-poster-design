<?php
/**
 * Category filter row for the news listing. array( 'active' => term_id )
 *
 * @package bellaworks
 */
$active = isset( $args['active'] ) ? (int) $args['active'] : 0;
$cats   = get_categories( array( 'hide_empty' => true, 'exclude' => array( 1 ), 'orderby' => 'count', 'order' => 'DESC' ) );
$news   = get_page_by_path( 'news' );
$all    = $news ? get_permalink( $news ) : home_url( '/news/' );
?>
<nav class="news-index__filters" aria-label="<?php esc_attr_e( 'Categories', 'bellaworks' ); ?>">
	<span class="label news-index__filters-label"><?php esc_html_e( 'Filter', 'bellaworks' ); ?></span>
	<a class="label<?php echo 0 === $active ? ' is-active' : ''; ?>" href="<?php echo esc_url( $all ); ?>"><?php esc_html_e( 'All', 'bellaworks' ); ?></a>
	<?php foreach ( $cats as $c ) : ?>
	<a class="label<?php echo $active === (int) $c->term_id ? ' is-active' : ''; ?>" href="<?php echo esc_url( get_category_link( $c ) ); ?>"><?php echo esc_html( $c->name ); ?></a>
	<?php endforeach; ?>
</nav>
