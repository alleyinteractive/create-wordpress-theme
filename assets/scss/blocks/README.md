# Block Styles
The `blocks` directory should contain custom styles that extend block styles. These include core and custom block styles that can not be added to the `theme.json` configuration file (due to it's limitations or otherwise), and styles for custom blocks.

## Block Entry Points
Each file added to a subdirectory will be built and enqueued when that block is used on the page via the `wp_enqueue_block_style` function.

## Naming Conventions
The directory and file name should mirror the name of the block. For example:

- `core/heading.scss` - used for the `core/heading` block
- `core/media-text.scss` - used for the `core/media-text` block
- `create-wordpress-plugin/custom-block.scss` - used for the `create-wordpress-plugin/custom-block` block

```shell
.
└── assets/
    └── scss/
        └── blocks/
            ├── core/
            │   ├── heading.scss
            │   ├── media-text.scss
            └── create-wordpress-plugin/
                └── custom-block.scss
```
