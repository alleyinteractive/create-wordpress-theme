<?php
/**
 * Manage block-related logic.
 *
 * @package Create_WordPress_Theme
 */

namespace Create_WordPress_Theme\Blocks;

add_filter( 'render_block_core/template-part', __NAMESPACE__ . '\remove_core_template_part_wrapper', 10, 2 );

/**
 * Filters the content of a 'core/template-part' block.
 *
 * @param string $block_content The block content.
 * @param array  $block         The full block, including name and attributes.
 * @return string
 */
function remove_core_template_part_wrapper( $block_content, $block ) {
	$skip_wrapper = $block['attrs']['skipWrapper'] ?? false;

	/*
	 * Allow passing "skipWrapper": true with template part block to remove the
	 * the wrapper automatically added by core. This is useful to avoid extra
	 * wrappers, as template part blocks do not currently support an `ID`
	 * attribute. This also allows the block to more closely mimic the
	 * `get_template_part()` function.
	 */
	if ( true === $skip_wrapper ) {
		$proc = new \WP_HTML_Tag_Processor( $block_content );

		if ( true === $proc->next_tag() ) {
			$block_content = trim( $block_content );

			// Remove opening tag.
			$block_content = substr(
				$block_content,
				strpos( $block_content, '>' ) + 1
			);

			// Remove closing tag.
			$block_content = substr(
				$block_content,
				0,
				strlen( $block_content ) - strlen( "</{$proc->get_tag()}>" ),
			);

			$block_content = trim( $block_content );
		}
	}

	return $block_content;
}
