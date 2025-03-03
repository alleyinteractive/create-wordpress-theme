<?php
/**
 * Entry point "global" script registration and enqueue.
 *
 * This file will be copied to the assets output directory
 * with Webpack using wp-scripts build. The build command must
 * be run before this file will be available.
 *
 * This file must be included from the build output directory in a project.
 * and will be loaded from there.
 *
 * @package create-wordpress-theme
 */

/**
 * Register the global entry point assets so that they can be enqueued.
 */
function create_wordpress_theme_register_global_scripts(): void {
	// Automatically load dependencies and version.
	$asset_file = include __DIR__ . '/index.asset.php';

	if (
		! is_array( $asset_file )
		|| ! isset( $asset_file['dependencies'], $asset_file['version'] )
		|| ! is_array( $asset_file['dependencies'] )
		|| ! is_string( $asset_file['version'] )
	) {
		return;
	}

	// Register the global script.
	wp_register_script(
		'create-wordpress-theme-global-js',
		get_template_directory_uri() . '/build/global/index.js',
		array_filter( $asset_file['dependencies'], 'is_string' ),
		$asset_file['version'],
		true
	);
	wp_set_script_translations( 'create-wordpress-theme-global-js', 'create-wordpress-theme' );

	// Register the global style.
	wp_register_style(
		'create-wordpress-theme-global-css',
		get_template_directory_uri() . '/build/global/index.css',
		[],
		$asset_file['version'],
	);
}
add_action( 'init', 'create_wordpress_theme_register_global_scripts' );

/**
 * Enqueue scripts for the global entry point.
 */
function create_wordpress_theme_enqueue_global_scripts(): void {
	wp_enqueue_script( 'create-wordpress-theme-global-js' );
}
add_action( 'wp_enqueue_scripts', 'create_wordpress_theme_enqueue_global_scripts' );

/**
 * Enqueue styles for the global entry point.
 */
function create_wordpress_theme_enqueue_global_styles(): void {
	wp_enqueue_style( 'create-wordpress-theme-global-css' );
}
add_action( 'wp_enqueue_scripts', 'create_wordpress_theme_enqueue_global_styles' );
