<?php
/**
 * Create WordPress Theme functions and definitions
 *
 * @package Create_WordPress_Theme
 */

namespace Create_WordPress_Theme;

define( 'CUSTOM_WORDPRESS_THEME_PATH', __DIR__ );
define( 'CUSTOM_WORDPRESS_URL', get_template_directory_uri() );

// Theme customizer.
require_once CUSTOM_WORDPRESS_THEME_PATH . '/inc/customizer.php';
