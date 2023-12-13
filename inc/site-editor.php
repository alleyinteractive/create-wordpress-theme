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
		// Create a custom capability for menu items that should be displayed.
		Caper::grant_to( 'administrator' )->primitives( 'cwt_edit_menus' );

		// Conditionally re-grant access to the customizer.
		if ( ( 'customize.php' === $pagenow || 'index.php' === $pagenow ) && ! wp_doing_ajax() ) {
			Caper::grant_to( 'administrator' )->primitives( 'edit_theme_options' )->at_priority( 100 );
		}

		// Conditionally re-grant access to menus page.
		if ( 'nav-menus.php' === $pagenow && ! wp_doing_ajax() ) {
			Caper::grant_to( 'administrator' )->primitives( 'edit_theme_options' )->at_priority( 100 );
		}

		// Rebuild the appearance menu.
		add_action( 'admin_menu', __NAMESPACE__ . '\action__admin_menu' );
	}
}

/**
 * Remove and rebuild the appearance menu.
 */
function action__admin_menu(): void {
	// Build the customize.php URL.
	$current_url   = esc_url_raw( wp_unslash( $_SERVER['REQUEST_URI'] ) );
	$customize_url = add_query_arg( 'return', urlencode( remove_query_arg( wp_removable_query_args(), $current_url ) ), 'customize.php' );

	// Remove the "Appearance" menu items.
	remove_menu_page( 'themes.php' );
	remove_submenu_page( 'themes.php', 'site-editor.php' );
	remove_submenu_page( 'themes.php', $customize_url );
	remove_submenu_page( 'themes.php', 'nav-menus.php' );

	// Rebuild the Appearance menu.
	add_menu_page(
		__( 'Appearance', 'create-wordpress-theme' ),
		__( 'Appearance', 'create-wordpress-theme' ),
		'cwt_edit_menus',
		'themes.php',
		// @phpstan-ignore-next-line because the issue is with the docblock in WP core; we are passing the correct default value.
		'',
		'dashicons-admin-appearance',
		60 // Default themes.php menu item position.
	);

	add_submenu_page(
		'themes.php',
		__( 'Customize', 'create-wordpress-theme' ),
		__( 'Customize', 'create-wordpress-theme' ),
		'cwt_edit_menus',
		esc_url( $customize_url ),
		'',
		61
	);

	add_submenu_page(
		'themes.php',
		__( 'Menus', 'create-wordpress-theme' ),
		__( 'Menus', 'create-wordpress-theme' ),
		'cwt_edit_menus',
		'nav-menus.php',
		'',
		62
	);
}
