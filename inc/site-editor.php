<?php
/**
 * Customizations for the site editor.
 *
 * @package Create_WordPress_Theme
 */

namespace Create_WordPress_Theme\Site_Editor;

use Alley\WP\Caper;

add_action( 'after_setup_theme', __NAMESPACE__ . '\action__after_setup_theme' );

/**
 * Prevents access to the Site Editor on environments other than local and develop.
 */
function action__after_setup_theme(): void {
	global $pagenow;

	if ( ! in_array( wp_get_environment_type(), [ 'local', 'development' ], true ) ) {
		// Caper is being installed via Create WordPress Project. If it's not available, bail.
		if ( ! class_exists( 'Alley\WP\Caper' ) ) {
			return;
		}

		Caper::deny_to_all()->primitives( 'edit_theme_options' );

		if ( 'site-editor.php' !== $pagenow ) {
			Caper::grant_to( 'administrator' )->primitives( 'edit_theme_options' )->at_priority( 100 );
		}

		add_action( 'admin_menu', __NAMESPACE__ . '\action__admin_menu' );
	}
}

/**
 * Remove and rebuild the appearance menu.
 */
function action__admin_menu(): void {
	remove_submenu_page( 'themes.php', 'site-editor.php' );
}
