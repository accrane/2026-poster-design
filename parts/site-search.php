<?php
/**
 * Site search field. get_template_part( 'parts/site-search', null, array( 'label' => '', 'value' => '' ) )
 *
 * @package bellaworks
 */
$label = isset( $args['label'] ) ? $args['label'] : __( 'Search the site', 'bellaworks' );
$value = isset( $args['value'] ) ? $args['value'] : get_search_query();
$id    = 'site-search-' . wp_unique_id();
?>
<form class="site-search" role="search" method="get" action="<?php echo esc_url( home_url( '/' ) ); ?>">
	<?php if ( $label ) : ?><label class="label" for="<?php echo esc_attr( $id ); ?>"><?php echo esc_html( $label ); ?></label><?php endif; ?>
	<div class="site-search__field">
		<input id="<?php echo esc_attr( $id ); ?>" type="search" name="s" value="<?php echo esc_attr( $value ); ?>" placeholder="<?php esc_attr_e( 'What are you looking for?', 'bellaworks' ); ?>">
		<button type="submit" class="site-search__go" aria-label="<?php esc_attr_e( 'Search', 'bellaworks' ); ?>"><?php bellaworks_arrow(); ?></button>
	</div>
</form>
