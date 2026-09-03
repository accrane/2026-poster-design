<?php
/**
 * bellaworks 2026 functions and definitions.
 *
 * @package bellaworks
 */

/**
 * Theme supports, menus, image sizes.
 */
require get_template_directory() . '/inc/theme-setup.php';

/**
 * Enqueue scripts and styles.
 */
require get_template_directory() . '/inc/scripts.php';

/**
 * Custom Post Types.
 */
require get_template_directory() . '/inc/post-types.php';

/**
 * Reusable output functions (stars, stamps, buttons, watermarks...).
 */
require get_template_directory() . '/inc/template-tags.php';

/**
 * Helpers that act independently of the templates.
 */
require get_template_directory() . '/inc/extras.php';

require get_template_directory() . '/inc/anti-email-spam.php';

/**
 * Theme specific additions.
 */
require get_template_directory() . '/inc/theme.php';

/**
 * Block & disable all new user registrations & comments completely.
 */
require get_template_directory() . '/inc/block-all-registration-and-comments.php';
