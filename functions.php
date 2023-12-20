<?php
/**
 * Create WordPress Theme functions and definitions
 *
 * @package Create_WordPress_Theme
 */

namespace Create_WordPress_Theme;

define( 'CREATE_WORDPRESS_THEME_PATH', __DIR__ );
define( 'CREATE_WORDPRESS_THEME_URL', get_template_directory_uri() );

// Block customizations.
require_once CREATE_WORDPRESS_THEME_PATH . '/inc/blocks.php';

// Theme setup.
require_once CREATE_WORDPRESS_THEME_PATH . '/inc/theme.php';

// Site editor customizations.
require_once CREATE_WORDPRESS_THEME_PATH . '/inc/site-editor.php';
