<?php
/**
 * Create WordPress Theme Tests: Bootstrap
 *
 * phpcs:disable Squiz.Commenting.InlineComment.InvalidEndChar
 *
 * @package create-wordpress-theme
 */

/**
 * Visit {@see https://mantle.alley.com/testing/test-framework.html} to learn more.
 */
\Mantle\Testing\manager()
	// Rsync the theme to themes/create-wordpress-theme when testing.
	->maybe_rsync_theme()
	->install();
