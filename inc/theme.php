<?php
/**
 * Theme setup.
 *
 * @package Create_WordPress_Theme
 */

namespace Create_WordPress_Theme;

add_action( 'after_setup_theme', __NAMESPACE__ . '\action__after_theme_setup' );
add_action( 'admin_menu', __NAMESPACE__ . '\action__admin_menu' );

/**
 * Setup theme defaults and registers support for various WordPress features.
 */
function action__after_theme_setup(): void {
	/**
	 * Add menu support.
	 */
	add_theme_support( 'menus' );
}

/**
 * Add in the Customize link to the Appearance menu.
 *
 * @return void
 */
function action__admin_menu(): void {
	// Build the customize.php URL.
	$current_url   = esc_url_raw( wp_unslash( $_SERVER['REQUEST_URI'] ) );
	$customize_url = add_query_arg( 'return', urlencode( remove_query_arg( wp_removable_query_args(), $current_url ) ), 'customize.php' );

	add_submenu_page(
		'themes.php',
		__( 'Customize', 'create-wordpress-theme' ),
		__( 'Customize', 'create-wordpress-theme' ),
		'customize',
		esc_url( $customize_url ),
		'',
		60
	);
}
