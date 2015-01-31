<?php
/**
 * You probably don't need to touch this file. It requires plugins, but it doesn't install them (the way it's configured)
 * All you need is to activate the plugins from your admin panel, if you want that functionality!
 */
/**
 * Include the TGM_Plugin_Activation class.
 */
require_once ( dirname( __FILE__ ) . '/TGM_Plugin_Activation.class.php' );

function village_required_plugins() {


	/**
	 * Array of plugin arrays. Required keys are name and slug.
	 * If the source is NOT from the .org repo, then source is also required.
	 */
	$template_directory = get_template_directory();
	
	$plugins = array(

		// This is an example of how to include a plugin pre-packaged with a theme
		// array(
		// 	'name'     				=> 'Enable Village Portfolio', // The plugin name
		// 	'slug'     				=> 'village-mellow-portfolio', // The plugin slug (typically the folder name)
		// 	'source'   				=> get_stylesheet_directory() . '/inc/plugins/village-mellow-portfolio.zip', // The plugin source
		// 	'required' 				=> false, // If false, the plugin is only 'recommended' instead of required
		// 	'version' 				=> '', // E.g. 1.0.0. If set, the active plugin must be this version or higher, otherwise a notice is presented
		// 	'force_activation' 		=> false, // If true, plugin is activated upon theme activation and cannot be deactivated until theme switch
		// 	'force_deactivation' 	=> false, // If true, plugin is deactivated upon theme switch, useful for theme-specific plugins
		// 	'external_url' 			=> '', // If set, overrides default API URL and points to an external URL
		// ),
		array(
			'name'     				=> 'Village Shortcodes', 
			'slug'     				=> 'village-shortcodes', 
			'source'   				=> $template_directory . '/assets/plugins/village-shortcodes.zip', 
			'required' 				=> true, 
			'version' 				=> '1.0.0', 
			'force_activation' 		=> false, 
			'force_deactivation' 	=> false, 
		),

		array(
			'name' 		=> 'Aqua Page Builder',
			'slug' 		=> 'aqua-page-builder',
			'version' 	=> '1.1.2',
			'required' 	=> true,
			'force_activation' 		=> true, 
	    ),

		array(
			'name' 		=> 'Redux Framework',
			'slug' 		=> 'redux-framework',
			'version' 	=> '3.1.8',
			'required' 	=> true,
	    ),		
		

		array(
			'name' 		=> 'Advanced Custom Fields',
			'slug' 		=> 'advanced-custom-fields',
			'version' 	=> '4.3.4',
			'required' 	=> true,
		),
	
		array(
			'name' 		=> 'Contact Form 7',
			'slug' 		=> 'contact-form-7',
			'required' 	=> false,
		),
		array(
			'name' 		=> 'Widget Shortcode',
			'slug' 		=> 'widget-shortcode',
			'required' 	=> false,
		),
		array(
			'name' 		=> 'Font Awesome More Icons',
			'slug' 		=> 'font-awesome-more-icons',
			'required' 	=> false,
		),
		array(
		      'name' => 'Simple Social Icons',
		      'slug' => 'simple-social-icons',
		      'required' => false,
		      ),
	);

	
	$config = array(
		'domain'       		=> "village",         
		'default_path' 		=> '',                         
		'parent_menu_slug' 	=> 'themes.php', 			
		'parent_url_slug' 	=> 'themes.php', 			
		'menu'         		=> 'install-required-plugins', 
		'has_notices'      	=> true,                       
		'is_automatic'    	=> true,					   
		'message' 			=> '',						
		'strings'      		=> array(
			'page_title'                       			=> __( 'Install Required Plugins', 'village' ),
			'menu_title'                       			=> __( 'Install Plugins', 'village' ),
			'installing'                       			=> __( 'Installing Plugin: %s', 'village' ), // %1$s = plugin name
			'oops'                             			=> __( 'Something went wrong with the plugin API.', 'village' ),
			'notice_can_install_required'     			=> _n_noop( 'This theme requires the following plugin: %1$s.', 'This theme requires the following plugins: %1$s.' ), // %1$s = plugin name(s)
			'notice_can_install_recommended'			=> _n_noop( 'This theme recommends the following plugin: %1$s.', 'This theme recommends the following plugins: %1$s.' ), // %1$s = plugin name(s)
			'notice_cannot_install'  					=> _n_noop( 'Sorry, but you do not have the correct permissions to install the %s plugin. Contact the administrator of this site for help on getting the plugin installed.', 'Sorry, but you do not have the correct permissions to install the %s plugins. Contact the administrator of this site for help on getting the plugins installed.' ), // %1$s = plugin name(s)
			'notice_can_activate_required'    			=> _n_noop( 'The following required plugin is currently inactive: %1$s.', 'The following required plugins are currently inactive: %1$s.' ), // %1$s = plugin name(s)
			'notice_can_activate_recommended'			=> _n_noop( 'The following recommended plugin is currently inactive: %1$s.', 'The following recommended plugins are currently inactive: %1$s.' ), // %1$s = plugin name(s)
			'notice_cannot_activate' 					=> _n_noop( 'Sorry, but you do not have the correct permissions to activate the %s plugin. Contact the administrator of this site for help on getting the plugin activated.', 'Sorry, but you do not have the correct permissions to activate the %s plugins. Contact the administrator of this site for help on getting the plugins activated.' ), // %1$s = plugin name(s)
			'notice_ask_to_update' 						=> _n_noop( 'The following plugin needs to be updated to its latest version to ensure maximum compatibility with this theme: %1$s.', 'The following plugins need to be updated to their latest version to ensure maximum compatibility with this theme: %1$s.' ), // %1$s = plugin name(s)
			'notice_cannot_update' 						=> _n_noop( 'Sorry, but you do not have the correct permissions to update the %s plugin. Contact the administrator of this site for help on getting the plugin updated.', 'Sorry, but you do not have the correct permissions to update the %s plugins. Contact the administrator of this site for help on getting the plugins updated.' ), // %1$s = plugin name(s)
			'install_link' 					  			=> _n_noop( 'Begin installing plugin', 'Begin installing plugins' ),
			'activate_link' 				  			=> _n_noop( 'Activate installed plugin', 'Activate installed plugins' ),
			'return'                           			=> __( 'Return to Required Plugins Installer', 'village' ),
			'plugin_activated'                 			=> __( 'Plugin activated successfully.', 'village' ),
			'complete' 									=> __( 'All plugins installed and activated successfully. %s', 'village' ), // %1$s = dashboard link
			'nag_type'									=> 'updated' // Determines admin notice type - can only be 'updated' or 'error'
		)
	);
	

	/* -----------------------------------------------------------------*/
	/* 		Apply 'register_village_plugins' filters
	/* 		So that Other plugins can tap in and require more plugins
	/* -----------------------------------------------------------------*/			
	// $plugins = apply_filters( 'register_village_plugins', $plugins );
	tgmpa( $plugins, $config );

}
add_action( 'tgmpa_register', 'village_required_plugins' );
