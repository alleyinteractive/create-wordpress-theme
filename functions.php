<?php
/**
 * Create WordPress Theme functions and definitions
 *
 * @package Create_WordPress_Theme
 */

namespace Create_WordPress_Theme;

define( 'CREATE_WORDPRESS_THEME_PATH', __DIR__ );
define( 'CREATE_CUSTOM_WORDPRESS_URL', get_template_directory_uri() );

// Theme setup.
require_once CREATE_WORDPRESS_THEME_PATH . '/inc/theme.php';

