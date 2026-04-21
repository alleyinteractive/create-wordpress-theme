<?php
/**
 * Manage block-related logic.
 *
 * @package Create_WordPress_Theme
 */

namespace Alley\WP\Create_WordPress_Theme\Blocks;

use function Alley\WP\Create_WordPress_Theme\Assets\get_entry_dir_path;
use function Alley\WP\Create_WordPress_Theme\Assets\get_asset_dependency_array;
use function Alley\WP\Create_WordPress_Theme\Assets\get_asset_version;

add_action( 'after_setup_theme', __NAMESPACE__ . '\enqueue_block_styles' );

/**
 * Enqueue stylesheets for blocks. Each stylesheet will be enqueued on-render.
 *
 * @see https://developer.wordpress.org/reference/functions/wp_enqueue_block_style/
 */
function enqueue_block_styles(): void {
	$folder_path = get_entry_dir_path( 'block-styles', true );

	if ( $folder_path === '' || $folder_path === '0' ) {
		return;
	}

	$directories = scandir( $folder_path );

	// Return if no directories.
	if ( ! $directories ) {
		return;
	}

	$named_directories = array_filter(
		$directories,
		fn ( string $item ): bool => is_dir( $folder_path . '/' . $item ) && ! in_array( $item, [ '.', '..' ], true )
	);

	$block_entries = [];

	// Loop over each directory.
	foreach ( $named_directories as $dir ) {
		$folder          = $folder_path . $dir;
		$folder_contents = scandir( $folder );

		// Return if no sub-folders.
		if ( ! $folder_contents ) {
			return;
		}

		$block_directories = array_filter(
			$folder_contents,
			fn ( string $item ): bool => is_dir( $folder . '/' . $item ) && ! in_array( $item, [ '.', '..' ], true )
		);

		// Create entry details for each block directory.
		foreach ( $block_directories as $block_dir ) {
			$block_folder   = $folder . '/' . $block_dir;
			$index_css_path = $block_folder . '/index.css';

			// Check if index.css exists in the block directory.
			if ( file_exists( $index_css_path ) ) {
				$block_entries[] = [
					'block_name'      => $block_dir,
					'block_namespace' => $dir . '/' . $block_dir,
					'file_name'       => 'index.css',
					'file_path'       => $block_folder,
					'handle'          => get_template() . '-' . $dir . '-' . $block_dir,
				];
			}
		}
	}

	foreach ( $block_entries as $block ) {
		$entry_dir = 'block-styles/' . $block['block_namespace'];

		wp_enqueue_block_style(
			$block['block_namespace'],
			[
				'handle' => $block['handle'] . '-styles', // Ex: `create-wordpress-theme-core-paragraph-styles`.
				'src'    => get_template_directory_uri() . '/build/' . trailingslashit( $entry_dir ) . $block['file_name'],
				'deps'   => get_asset_dependency_array( $entry_dir ),
				'ver'    => get_asset_version( $entry_dir ),

				// Adding "path" allows inlining of block styles on the frontend when possible.
				'path'   => $block['file_path'] . $block['file_name'],
			]
		);
	}
}
