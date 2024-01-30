<?php
/**
 * Manage block-related logic.
 *
 * @package Create_WordPress_Theme
 */

namespace Create_WordPress_Theme\Blocks;

add_filter( 'render_block_core/template-part', __NAMESPACE__ . '\remove_core_template_part_wrapper', 10, 2 );
add_filter( 'render_block_core/post-featured-image', __NAMESPACE__ . '\render_core_post_featured_image', 10, 2 );

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

/**
 * Filters the content of the 'core/post-featured-image' block.
 *
 * @param string $block_content The block content.
 * @param array  $block         The full block, including name and attributes.
 * @return string
 */
function render_core_post_featured_image( $block_content, $block ) {
	$aria_hidden = $block['attrs']['ariaHidden'] ?? false;

	/*
	 * Allow passing "ariaHidden": true with post featured image block to remove
	 * the tab stop and hide the image from screen readers.
	 * 
	 * This is useful when linked within archive listings or card components,
	 * since the post title serves as the post link.
	 */
	if ( true === $aria_hidden ) {
		$proc = new \WP_HTML_Tag_Processor( $block_content );

		if ( $proc->next_tag( 'figure' ) ) {
			$proc->set_attribute( 'aria-hidden', 'true' );
		}

		if ( $proc->next_tag( 'a' ) ) {
			$proc->set_attribute( 'aria-hidden', 'true' );
			$proc->set_attribute( 'tabIndex', '-1' );
		}

		/*
		 * Since the image is hidden, it can no longer be considered content,
		 * so it only needs an empty 'alt' attribute.
		 */
		if ( $proc->next_tag( 'img' ) ) {
			$proc->set_attribute( 'alt', '' );
		}

		return $proc->get_updated_html();
	}

	return $block_content;
}
