<?php

if(function_exists("register_field_group"))
{


	//-----------------------------------*/
	// Portfolio Gallery
	//-----------------------------------*/
	register_field_group(array (
		'id' => 'acf_gallery',
		'title' => 'Gallery',
		'fields' => array (
			array (
				'key' => 'field_53146d0460b10',
				'label' => 'Enable Videos ?',
				'name' => Village::$key . 'enable_video',
				'type' => 'true_false',
				'message' => 'Check this if you\'re going to use any videos in this gallery!',
				'default_value' => 0,
			),
			array (
				'key' => 'field_5314647c80f5a',
				'label' => 'Gallery',
				'name' => Village::$key . 'gallery',
				'type' => 'repeater',
				'sub_fields' => array (
					array (
						'key' => 'field_53146e2d2676a',
						'label' => 'Image',
						'name' => 'image',
						'type' => 'image',
						'instructions' => 'If you hold ctrl (Windows) or cmd &#8984; (Mac) you can select multiple images!',
						'column_width' => 20,
						'save_format' => 'object',
						'preview_size' => 'thumbnail',
						'library' => 'all',
					),
					array (
						'key' => 'field_5314700d05886',
						'label' => 'Title',
						'name' => 'title',
						'type' => 'text',
						'column_width' => '',
						'default_value' => '',
						'placeholder' => '',
						'prepend' => '',
						'append' => '',
						'formatting' => 'html',
						'maxlength' => '',
					),
					array (
						'key' => 'field_53146e602676b',
						'label' => 'Description',
						'name' => 'description',
						'type' => 'wysiwyg',
						'column_width' => 80,
						'default_value' => '',
						'toolbar' => 'basic',
						'media_upload' => 'no',
					),
					array (
						'key' => 'field_53146e772676c',
						'label' => 'Video URL',
						'name' => 'video_url',
						'type' => 'text',
						'instructions' => 'If used - the image will become a "Video Cover Image"',
						'conditional_logic' => array (
							'status' => 1,
							'rules' => array (
								array (
									'field' => 'field_53146d0460b10',
									'operator' => '==',
									'value' => '1',
								),
							),
							'allorany' => 'all',
						),
						'column_width' => 100,
						'default_value' => '',
						'placeholder' => 'for example: http://www.youtube.com/watch?v=U9BIZAzObNI',
						'prepend' => '',
						'append' => '',
						'formatting' => 'html',
						'maxlength' => '',
					),
				),
				'row_min' => '',
				'row_limit' => '',
				'layout' => 'row',
				'button_label' => 'Add Image or Video',
			),
		),
		'location' => array (
			array (
				array (
					'param' => 'post_type',
					'operator' => '==',
					'value' => 'portfolio',
					'order_no' => 0,
					'group_no' => 0,
				),
			),
		),
		'options' => array (
			'position' => 'acf_after_title',
			'layout' => 'default',
			'hide_on_screen' => array (
			),
		),
		'menu_order' => 0,
	));


	//-----------------------------------*/
	// General Page Settings
	//-----------------------------------*/
	register_field_group(array (
		'id' => 'acf_general-page-settings',
		'title' => 'General Page Settings',
		'fields' => array (
			array (
				'key' => 'field_531458f02f4ba',
				'label' => 'Background Color',
				'name' => Village::$key . 'background_color',
				'type' => 'color_picker',
				'default_value' => '',
			),
			array (
				'key' => 'field_5314583b2f4b8',
				'label' => 'Background Image',
				'name' => Village::$key . 'background_image',
				'type' => 'image',
				'save_format' => 'object',
				'preview_size' => 'thumbnail',
				'library' => 'all',
			),
			array (
				'key' => 'field_531458822f4b9',
				'label' => 'Text Color',
				'name' => Village::$key . 'style_preset',
				'type' => 'select',
				'choices' => array (
					'dark-font' => 'Dark Font',
					'light-font' => 'Light Font',
				),
				'default_value' => '',
				'allow_null' => 1,
				'multiple' => 0,
			),
		),
		'location' => array (
			array (
				array (
					'param' => 'post_type',
					'operator' => '==',
					'value' => 'page',
					'order_no' => 0,
					'group_no' => 0,
				),
			),
		),
		'options' => array (
			'position' => 'side',
			'layout' => 'default',
			'hide_on_screen' => array (
			),
		),
		'menu_order' => 1,
	));



	//-----------------------------------*/
	// Options for "Template Name Fullscreen"
	//-----------------------------------*/


	// Enter Site Group
	register_field_group(array (
		'id' => 'enter_site_options',
		'title' => 'Enter Site Button',
		'fields' => array (
			array (
				'key' => 'field_5356c664820c8',
				'label' => 'Text',
				'name' => 'enter_site_text',
				'type' => 'text',
				'default_value' => '',
				'placeholder' => 'Enter Site',
				'prepend' => '',
				'append' => '',
				'formatting' => 'html',
				'maxlength' => '',
				'instructions' => 'The Link text. If an Image is used it will display this text in the alt attribute of the image ' . htmlentities(' ( <img src="" alt="Enter Site"> )'),
			),
			array (
				'key' => 'field_5356c61d820c7',
				'label' => 'Image',
				'name' => 'enter_site_image',
				'type' => 'image',
				'save_format' => 'object',
				'preview_size' => 'thumbnail',
				'library' => 'all',
			),


			array (
				'key' => 'field_5356e95c1c468',
				'label' => 'Link Type',
				'name' => 'link_type',
				'type' => 'select',
				'choices' => array (
					'page' => 'Wordpress Page',
					'custom' => 'Custom Link',
				),
				'default_value' => 'page',
				'allow_null' => 1,
				'multiple' => 0,
				'instructions' => 'Are you linking to a wordpress page or do you prefer your own custom link ? If you don\'t select anything, the default "Theme Options -> Home URL" is going to be used',
			),
			array (
				'key' => 'field_5356ea301c46a',
				'label' => 'Wordpress Page to link to',
				'name' => 'enter_site_link',
				'type' => 'page_link',
				'conditional_logic' => array (
					'status' => 1,
					'rules' => array (
						array (
							'field' => 'field_5356e95c1c468',
							'operator' => '==',
							'value' => 'page',
						),
					),
					'allorany' => 'all',
				),
				'post_type' => array (
					0 => 'page',
				),
				'allow_null' => 0,
				'multiple' => 0,
			),
			array (
				'key' => 'field_5356e9a51c469',
				'label' => 'Custom Link',
				'name' => 'enter_site_link',
				'type' => 'text',
				'instructions' => 'Enter a custom link ( including the http:// ) <br>
	Keep in mind that Wordpress isn\'t going to keep track of the link for you. If the destination URL changes - you will have to update this link!',
				'conditional_logic' => array (
					'status' => 1,
					'rules' => array (
						array (
							'field' => 'field_5356e95c1c468',
							'operator' => '==',
							'value' => 'custom',
						),
					),
					'allorany' => 'all',
				),
				'default_value' => '',
				'placeholder' => '',
				'prepend' => '',
				'append' => '',
				'formatting' => 'html',
				'maxlength' => '',
			),




		),
		'location' => array (
			array (
				array (
					'param' => 'post_type',
					'operator' => '==',
					'value' => 'page',
					'order_no' => 0,
					'group_no' => 0,
				),
				array (
					'param' => 'page_template',
					'operator' => '==',
					'value' => 'templates/page-fullscreen.php',
					'order_no' => 1,
					'group_no' => 0,
				),
			),
		),
		'options' => array (
			'position' => 'acf_after_title',
			'layout' => 'default',
			'hide_on_screen' => array(),
		),
		'menu_order' => 0,
	));



	// Background Options
	register_field_group(array (
		'id' => 'acf_fullscreen-slider-options',
		'title' => 'Overlay / Slider Options',
		'fields' => array (
			array (
				'key' => 'field_5356a6c155f49',
				'label' => 'Logo / Overlay Image',
				'name' => 'overlay_image',
				'type' => 'image',
				'instructions' => 'Image will be displayed above your "Enter Site" link.',
				'save_format' => 'object',
				'preview_size' => 'thumbnail',
				'library' => 'all',
			),
			array (
				'key' => 'field_5356a6de55f4a',
				'label' => 'Background Color',
				'name' => 'background_color',
				'type' => 'color_picker',
				'instructions' => 'In case you have no background slider or the background images haven\'t loaded.',
				'default_value' => '',
			),
			array (
				'key' => 'field_5356a638f29cc',
				'label' => 'Background Slider Images',
				'name' => 'slider_images',
				'type' => 'repeater',
				'instructions' => 'Upload or select images to be used in the background.
	<strong> Start by clicking "Add Image" </strong>',
				'sub_fields' => array (
					array (
						'key' => 'field_5356a66df29cd',
						'label' => 'Image',
						'name' => 'image',
						'type' => 'image',
						'column_width' => 100,
						'save_format' => 'object',
						'preview_size' => 'thumbnail',
						'library' => 'all',
					),
				),
				'row_min' => '',
				'row_limit' => '',
				'layout' => 'table',
				'button_label' => 'Add Image',
			),
		),
		'location' => array (
			array (
				array (
					'param' => 'post_type',
					'operator' => '==',
					'value' => 'page',
					'order_no' => 0,
					'group_no' => 0,
				),
				array (
					'param' => 'page_template',
					'operator' => '==',
					'value' => 'templates/page-fullscreen.php',
					'order_no' => 1,
					'group_no' => 0,
				),
			),
		),
		'options' => array (
			'position' => 'acf_after_title',
			'layout' => 'default',
			'hide_on_screen' => array (
				'excerpt',
				'the_content',
				// 'custom_fields',
				'discussion',
				'comments',
				'featured_image',
				'categories',
				'tags',
				'send-trackbacks',
			),
		),
		'menu_order' => 0,
	));



}
