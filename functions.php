<?php
/**
 * Create WordPress Theme functions and definitions
 *
 * @package Create_WordPress_Theme
 */

namespace Alley\WP\Create_WordPress_Theme;

define( 'CREATE_WORDPRESS_THEME_DIR', __DIR__ );
define( 'CREATE_WORDPRESS_THEME_URL', get_template_directory_uri() );

// Assets.
require_once CREATE_WORDPRESS_THEME_DIR . '/inc/assets.php';

// Block customizations.
require_once CREATE_WORDPRESS_THEME_DIR . '/inc/blocks.php';

// Theme setup.
require_once CREATE_WORDPRESS_THEME_DIR . '/inc/theme.php';

// Site editor customizations.
require_once CREATE_WORDPRESS_THEME_DIR . '/inc/site-editor.php';

// Customizer setup.
require_once CREATE_WORDPRESS_THEME_DIR . '/inc/customizer.php';

// Load asset scripts.
Assets\load_scripts();
