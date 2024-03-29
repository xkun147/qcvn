<?php
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
/**
 * Module Name: Image
 * Description: Display Image content
 */

///////////////////////////////////////
// Module Options
///////////////////////////////////////
$image_sizes = themify_get_image_sizes_list( false );

$this->modules['image'] = apply_filters( 'themify_builder_module_image', array(
	'name' => __('Image', 'themify'),
	'options' => array(
		array(
			'id' => 'mod_title_image',
			'type' => 'text',
			'label' => __('Module Title', 'themify'),
			'class' => 'large'
		),
		array(
			'id' => 'style_image',
			'type' => 'layout',
			'label' => __('Image Style', 'themify'),
			'options' => array(
				array('img' => 'image-top.png', 'value' => 'image-top', 'label' => __('Image Top', 'themify')),
				array('img' => 'image-left.png', 'value' => 'image-left', 'label' => __('Image Left', 'themify')),
				array('img' => 'image-right.png', 'value' => 'image-right', 'label' => __('Image Right', 'themify')),
				array('img' => 'image-overlay.png', 'value' => 'image-overlay', 'label' => __('Image Overlay', 'themify'))
			)
		),
		array(
			'id' => 'url_image',
			'type' => 'image',
			'label' => __('Image URL', 'themify'),
			'class' => 'xlarge'
		),
		array(
			'id' => 'appearance_image',
			'type' => 'checkbox',
			'label' => __('Image Appearance', 'themify'),
			'default' => 'rounded',
			'options' => array(
				array( 'name' => 'rounded', 'value' => __('Rounded', 'themify')),
				array( 'name' => 'drop-shadow', 'value' => __('Drop Shadow', 'themify')),
				array( 'name' => 'bordered', 'value' => __('Bordered', 'themify')),
				array( 'name' => 'circle', 'value' => __('Circle', 'themify'), 'help' => __('(square format image only)', 'themify'))
			)
		),
		array(
			'id' => 'image_size_image',
			'type' => 'select',
			'label' => $this->is_img_php_disabled() ? __('Image Size', 'themify') : false,
			'empty' => array(
				'val' => '',
				'label' => ''
			),
			'hide' => $this->is_img_php_disabled() ? false : true,
			'options' => $image_sizes
		),
		array(
			'id' => 'width_image',
			'type' => 'text',
			'label' => __('Width', 'themify'),
			'class' => 'xsmall',
			'help' => 'px',
			'value' => 300
		),
		array(
			'id' => 'height_image',
			'type' => 'text',
			'label' => __('Height', 'themify'),
			'class' => 'xsmall',
			'help' => 'px',
			'value' => 200
		),
		array(
			'id' => 'title_image',
			'type' => 'text',
			'label' => __('Image Title', 'themify'),
			'class' => 'fullwidth'
		),
		array(
			'id' => 'link_image',
			'type' => 'text',
			'label' => __('Image Link', 'themify'),
			'class' => 'fullwidth'
		),
		array(
			'id' => 'param_image',
			'type' => 'checkbox',
			'label' => false,
			'pushed' => 'pushed',
			'options' => array(
				array( 'name' => 'lightbox', 'value' => __('Open link in lightbox', 'themify')),
				array( 'name' => 'zoom', 'value' => __('Show zoom icon', 'themify')),
				array( 'name' => 'newtab', 'value' => __('Open link in new tab', 'themify'))
			),
			'new_line' => false
		),
		array(
			'id' => 'caption_image',
			'type' => 'textarea',
			'label' => __('Image Caption', 'themify'),
			'class' => 'fullwidth'
		)
	),

	// Styling
	'styling' => array(
		array(
			'id' => 'separator_image_background',
			'title' => '',
			'description' => '',
			'type' => 'separator',
			'meta' => array('html'=>'<h4>'.__('Background', 'themify').'</h4>'),
		),
		array(
			'id' => 'background_color',
			'type' => 'color',
			'label' => __('Background Color', 'themify'),
			'class' => 'small'
		),
		// Font
		array(
			'type' => 'separator',
			'meta' => array('html'=>'<hr />')
		),
		array(
			'id' => 'separator_font',
			'type' => 'separator',
			'meta' => array('html'=>'<h4>'.__('Font', 'themify').'</h4>'),
		),
		array(
			'id' => 'font_family',
			'type' => 'select',
			'label' => __('Font Family', 'themify'),
			'class' => 'font-family-select',
			'meta' => array_merge( themify_get_web_safe_font_list(), themify_get_google_web_fonts_list() )
		),
		array(
			'id' => 'font_color',
			'type' => 'color',
			'label' => __('Font Color', 'themify'),
			'class' => 'small'
		),
		array(
			'id' => 'multi_font_size',
			'type' => 'multi',
			'label' => __('Font Size', 'themify'),
			'fields' => array(
				array(
					'id' => 'font_size',
					'type' => 'text',
					'class' => 'xsmall'
				),
				array(
					'id' => 'font_size_unit',
					'type' => 'select',
					'meta' => array(
						array('value' => '', 'name' => ''),
						array('value' => 'px', 'name' => __('px', 'themify')),
						array('value' => 'em', 'name' => __('em', 'themify'))
					)
				)
			)
		),
		array(
			'id' => 'multi_line_height',
			'type' => 'multi',
			'label' => __('Line Height', 'themify'),
			'fields' => array(
				array(
					'id' => 'line_height',
					'type' => 'text',
					'class' => 'xsmall'
				),
				array(
					'id' => 'line_height_unit',
					'type' => 'select',
					'meta' => array(
						array('value' => '', 'name' => ''),
						array('value' => 'px', 'name' => __('px', 'themify')),
						array('value' => 'em', 'name' => __('em', 'themify')),
						array('value' => '%', 'name' => __('%', 'themify'))
					)
				)
			)
		),
		// Link
		array(
			'type' => 'separator',
			'meta' => array('html'=>'<hr />')
		),
		array(
			'id' => 'separator_link',
			'type' => 'separator',
			'meta' => array('html'=>'<h4>'.__('Link', 'themify').'</h4>'),
		),
		array(
			'id' => 'link_color',
			'type' => 'color',
			'label' => __('Color', 'themify'),
			'class' => 'small'
		),
		array(
			'id' => 'text_decoration',
			'type' => 'select',
			'label' => __( 'Text Decoration', 'themify' ),
			'meta'	=> array(
				array('value' => '',   'name' => '', 'selected' => true),
				array('value' => 'underline',   'name' => __('Underline', 'themify')),
				array('value' => 'overline', 'name' => __('Overline', 'themify')),
				array('value' => 'line-through',  'name' => __('Line through', 'themify')),
				array('value' => 'none',  'name' => __('None', 'themify'))
			)
		),
		// Padding
		array(
			'type' => 'separator',
			'meta' => array('html'=>'<hr />')
		),
		array(
			'id' => 'separator_padding',
			'type' => 'separator',
			'meta' => array('html'=>'<h4>'.__('Padding', 'themify').'</h4>'),
		),
		array(
			'id' => 'multi_padding',
			'type' => 'multi',
			'label' => __('Padding', 'themify'),
			'fields' => array(
				array(
					'id' => 'padding_top',
					'type' => 'text',
					'description' => __('top', 'themify'),
					'class' => 'xsmall'
				),
				array(
					'id' => 'padding_right',
					'type' => 'text',
					'description' => __('right', 'themify'),
					'class' => 'xsmall'
				),
				array(
					'id' => 'padding_bottom',
					'type' => 'text',
					'description' => __('bottom', 'themify'),
					'class' => 'xsmall'
				),
				array(
					'id' => 'padding_left',
					'type' => 'text',
					'description' => __('left (px)', 'themify'),
					'class' => 'xsmall'
				)
			)
		),
		// Margin
		array(
			'type' => 'separator',
			'meta' => array('html'=>'<hr />')
		),
		array(
			'id' => 'separator_margin',
			'type' => 'separator',
			'meta' => array('html'=>'<h4>'.__('Margin', 'themify').'</h4>'),
		),
		array(
			'id' => 'multi_margin',
			'type' => 'multi',
			'label' => __('Margin', 'themify'),
			'fields' => array(
				array(
					'id' => 'margin_top',
					'type' => 'text',
					'description' => __('top', 'themify'),
					'class' => 'xsmall'
				),
				array(
					'id' => 'margin_right',
					'type' => 'text',
					'description' => __('right', 'themify'),
					'class' => 'xsmall'
				),
				array(
					'id' => 'margin_bottom',
					'type' => 'text',
					'description' => __('bottom', 'themify'),
					'class' => 'xsmall'
				),
				array(
					'id' => 'margin_left',
					'type' => 'text',
					'description' => __('left (px)', 'themify'),
					'class' => 'xsmall'
				)
			)
		),
		// Border
		array(
			'type' => 'separator',
			'meta' => array('html'=>'<hr />')
		),
		array(
			'id' => 'separator_border',
			'type' => 'separator',
			'meta' => array('html'=>'<h4>'.__('Border', 'themify').'</h4>'),
		),
		array(
			'id' => 'multi_border_top',
			'type' => 'multi',
			'label' => __('Border', 'themify'),
			'fields' => array(
				array(
					'id' => 'border_top_color',
					'type' => 'color',
					'class' => 'small'
				),
				array(
					'id' => 'border_top_width',
					'type' => 'text',
					'description' => 'px',
					'class' => 'xsmall'
				),
				array(
					'id' => 'border_top_style',
					'type' => 'select',
					'description' => __('top', 'themify'),
					'meta' => array(
						array( 'value' => '', 'name' => '' ),
						array( 'value' => 'solid', 'name' => __( 'Solid', 'themify' ) ),
						array( 'value' => 'dashed', 'name' => __( 'Dashed', 'themify' ) ),
						array( 'value' => 'dotted', 'name' => __( 'Dotted', 'themify' ) ),
						array( 'value' => 'double', 'name' => __( 'Double', 'themify' ) )
					)
				)
			)
		),
		array(
			'id' => 'multi_border_right',
			'type' => 'multi',
			'label' => '',
			'fields' => array(
				array(
					'id' => 'border_right_color',
					'type' => 'color',
					'class' => 'small'
				),
				array(
					'id' => 'border_right_width',
					'type' => 'text',
					'description' => 'px',
					'class' => 'xsmall'
				),
				array(
					'id' => 'border_right_style',
					'type' => 'select',
					'description' => __('right', 'themify'),
					'meta' => array(
						array( 'value' => '', 'name' => '' ),
						array( 'value' => 'solid', 'name' => __( 'Solid', 'themify' ) ),
						array( 'value' => 'dashed', 'name' => __( 'Dashed', 'themify' ) ),
						array( 'value' => 'dotted', 'name' => __( 'Dotted', 'themify' ) ),
						array( 'value' => 'double', 'name' => __( 'Double', 'themify' ) )
					)
				)
			)
		),
		array(
			'id' => 'multi_border_bottom',
			'type' => 'multi',
			'label' => '',
			'fields' => array(
				array(
					'id' => 'border_bottom_color',
					'type' => 'color',
					'class' => 'small'
				),
				array(
					'id' => 'border_bottom_width',
					'type' => 'text',
					'description' => 'px',
					'class' => 'xsmall'
				),
				array(
					'id' => 'border_bottom_style',
					'type' => 'select',
					'description' => __('bottom', 'themify'),
					'meta' => array(
						array( 'value' => '', 'name' => '' ),
						array( 'value' => 'solid', 'name' => __( 'Solid', 'themify' ) ),
						array( 'value' => 'dashed', 'name' => __( 'Dashed', 'themify' ) ),
						array( 'value' => 'dotted', 'name' => __( 'Dotted', 'themify' ) ),
						array( 'value' => 'double', 'name' => __( 'Double', 'themify' ) )
					)
				)
			)
		),
		array(
			'id' => 'multi_border_left',
			'type' => 'multi',
			'label' => '',
			'fields' => array(
				array(
					'id' => 'border_left_color',
					'type' => 'color',
					'class' => 'small'
				),
				array(
					'id' => 'border_left_width',
					'type' => 'text',
					'description' => 'px',
					'class' => 'xsmall'
				),
				array(
					'id' => 'border_left_style',
					'type' => 'select',
					'description' => __('left', 'themify'),
					'meta' => array(
						array( 'value' => '', 'name' => '' ),
						array( 'value' => 'solid', 'name' => __( 'Solid', 'themify' ) ),
						array( 'value' => 'dashed', 'name' => __( 'Dashed', 'themify' ) ),
						array( 'value' => 'dotted', 'name' => __( 'Dotted', 'themify' ) ),
						array( 'value' => 'double', 'name' => __( 'Double', 'themify' ) )
					)
				)
			)
		),
		// Additional CSS
		array(
			'type' => 'separator',
			'meta' => array( 'html' => '<hr/>')
		),
		array(
			'id' => 'css_image',
			'type' => 'text',
			'label' => __('Additional CSS Class', 'themify'),
			'class' => 'large exclude-from-reset-field',
			'description' => sprintf( '<br/><small>%s</small>', __( 'Add additional CSS class(es) for custom styling', 'themify' ) )
		)
	),
	'styling_selector' => array(
		'.module-image' => array(
			'background_color', 'padding', 'margin', 'border_top', 'border_right', 'border_bottom', 'border_left'
		),
		'.module-image a' => array( 'link_color', 'text_decoration' ),
		'.module-image .image-content' => array(
			'font_family', 'font_size', 'line_height', 'color',
		),
		'.module-image .image-title' => array(
			'font_family', 'color',
		),
		'.module-image .image-title a' => array(
			'font_family', 'color',
		)
	)
) );

?>