<?php
/**
 * Pagination. get_template_part( 'parts/pager', null, array( 'query' => WP_Query|null, 'current' => int ) )
 *
 * @package bellaworks
 */
$query   = ( isset( $args['query'] ) && $args['query'] instanceof WP_Query ) ? $args['query'] : $GLOBALS['wp_query'];
$current = isset( $args['current'] ) ? max( 1, (int) $args['current'] ) : max( 1, (int) get_query_var( 'paged' ) );
if ( $query->max_num_pages < 2 ) {
	return;
}
$arrow = '<svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.6" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M5 12h14"></path><path d="M13 6l6 6-6 6"></path></svg>';
$links = paginate_links( array(
	'total'     => $query->max_num_pages,
	'current'   => $current,
	'type'      => 'array',
	'mid_size'  => 1,
	'prev_text' => '<span class="pager__flip">' . $arrow . '</span><span class="sr">' . esc_html__( 'Previous', 'bellaworks' ) . '</span>',
	'next_text' => '<span class="sr">' . esc_html__( 'Next', 'bellaworks' ) . '</span>' . $arrow,
) );
if ( ! $links ) {
	return;
}
?>
<nav class="pager" aria-label="<?php esc_attr_e( 'Pagination', 'bellaworks' ); ?>">
	<?php echo implode( "\n", $links ); // phpcs:ignore -- core markup ?>
</nav>
