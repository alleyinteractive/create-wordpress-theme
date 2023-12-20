<?php
/**
 * Customizations for the site editor.
 *
 * @package Create_WordPress_Theme
 */

namespace Create_WordPress_Theme\Site_Editor;

add_action( 'admin_menu', __NAMESPACE__ . '\action__admin_menu' );

/**
 * Remove the Editor menu item from the appearance menu.
 */
function action__admin_menu(): void {
	global $pagenow;

	if ( ! in_array( wp_get_environment_type(), [ 'local', 'development' ], true ) ) {
		remove_submenu_page( 'themes.php', 'site-editor.php' );

		if ( $pagenow === 'site-editor.php' ) {
			wp_safe_redirect( admin_url() );
			exit;
		}
	}
}
