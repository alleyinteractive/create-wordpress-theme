<?php
/**
 * Theme setup.
 *
 * @package Create_WordPress_Theme
 */

namespace Create_WordPress_Theme;

add_action( 'after_setup_theme', __NAMESPACE__ . '\action__after_theme_setup' );

/**
 * Setup theme defaults and registers support for various WordPress features.
 */
function action__after_theme_setup(): void {
	/**
	 * Add menu support.
	 */
	add_theme_support( 'menus' );

	/**
	 * Enable theme customizer.
	 */
	add_action( 'customize_register', '__return_true' );
}
