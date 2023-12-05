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
		// Remove the "Editor" menu item.
		add_action( 'admin_menu', __NAMESPACE__ . '\action__admin_menu' );

		// Caper is being installed via Create WordPress Project. If it's not available, bail.
		if ( ! class_exists( 'Alley\WP\Caper' ) ) {
			return;
		}

		// Prevent direct access to the Site Editor.
		if ( 'site-editor.php' === $pagenow && ! wp_doing_ajax() ) {
			Caper::deny_to_all()->primitives( 'edit_theme_options' );
		}

	}
}

/**
 * Remove the "Editor" menu item.
 */
function action__admin_menu(): void {
	remove_submenu_page( 'themes.php', 'site-editor.php' );
}
