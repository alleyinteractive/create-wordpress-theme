<?php
/**
 * Customizations for the Customizer.
 *
 * @package Create_WordPress_Theme
 */

namespace Create_WordPress_Theme\Customizer;

add_action( 'after_setup_theme', __NAMESPACE__ . '\action__custom_logo_support' );

/**
 * Add custom logo support to the customizer.
 */
function action__custom_logo_support() {
	add_theme_support( 'custom-logo' );
}
