<?php

// Exit if accessed directly
if ( !defined('ABSPATH')) exit;

define( 'FW_VER', '1.0' );

define( 'FW_DIR', trailingslashit(THEME_DIR.'framework'));
define( 'FW_URL', trailingslashit(THEME_URL.'framework'));

define( 'FW_EXT_DIR', trailingslashit( FW_DIR . 'extensions' ) );
define( 'FW_EXT_URL', trailingslashit( FW_URL . 'extensions' ) );

define( 'FW_PLUGINS_DIR', trailingslashit( FW_DIR . 'plugins' ) );

define( 'FW_EXT_CUSTOM_DIR', trailingslashit( FW_DIR . 'extensions-custom' ) );
define( 'FW_EXT_CUSTOM_URL', trailingslashit( FW_URL . 'extensions-custom' ) );


define( 'FW_WIDGETS', trailingslashit( FW_DIR . 'widgets' ) );

define( 'FW_ASSETS', trailingslashit( FW_URL . 'assets' ) );
define( 'FW_JS', trailingslashit( FW_ASSETS . 'js' ) );
define( 'FW_CSS', trailingslashit( FW_ASSETS . 'css' ) );
define( 'FW_IMG', trailingslashit( FW_ASSETS . 'images' ) );
define( 'FW_LIBS', trailingslashit( FW_ASSETS . 'libs' ) );

define( 'FW_CLASS', trailingslashit( FW_DIR . 'class' ) );
define( 'FW_DATA', trailingslashit( FW_DIR . 'data' ) );


/**
 * All ajax functions
 *
 */
require_once ( FW_DIR . 'ajax.php' );


/**
 * Get plugin require for theme
 *
 */
require_once ( FW_CLASS . 'class-tgm-plugin-activation.php' );



/**
 * Include Widgets register and define all sidebars.
 *
 */
require_once ( FW_DIR . 'widgets.php' );

/**
 * Get all functions for frontend
 *
 */
require_once ( FW_DIR . 'frontend.php' );

/**
 * Get functions for framework
 *
 */
require_once ( FW_DIR . 'functions.php' );

/**
 * Get class helpers in framework
 *
 */
require_once ( FW_DIR . 'helpers.php' );


/**
 * Add scripts for backend
 *
 */
require_once ( FW_DIR . 'scripts.php' );

/**
 * Breadcrumbs
 *
 */
require_once ( FW_DIR . 'breadcrumbs.php' );



/**
 * get custom walker for wp_nav_menu
 *
 */
require_once ( FW_EXT_DIR .'nav/nav_custom_walker.php' );

/**
 * include Shortcode
 *
 */
require_once ( FW_EXT_DIR .'shortcodes/shortcodes.php' );

/**
 * Include the meta-box plugin.
 *
 */


define( 'RWMB_URL', trailingslashit( FW_EXT_URL . 'meta-box' ) );
define( 'RWMB_DIR', trailingslashit( FW_EXT_DIR . 'meta-box' ) );

require_once (RWMB_DIR . 'meta-box.php');

if ( class_exists( 'RW_Meta_Box' ) ) {
    
    // Add fields to metabox
    require_once (FW_EXT_CUSTOM_DIR . 'meta-box-custom.php');
    
    // Make sure there's no errors when the plugin is deactivated or during upgrade
	require_once (FW_DATA . 'data-meta-box.php');
    
}


/**
 * Include the redux-framework.
 * 
 */




if ( !class_exists( 'ReduxFramework' ) && file_exists( FW_EXT_DIR . 'ReduxCore/framework.php' ) ) {
    require_once( FW_EXT_DIR . 'ReduxCore/framework.php' );
}



if(!function_exists('redux_register_custom_extension_loader')) :
	function redux_register_custom_extension_loader($ReduxFramework) {
		$path = FW_EXT_DIR . '/ReduxCoreExt/';
		$folders = scandir( $path, 1 );		   
		foreach($folders as $folder) {
			if ($folder === '.' or $folder === '..' or !is_dir($path . $folder) ) {
				continue;	
			} 
			$extension_class = 'ReduxFramework_Extension_' . $folder;
			if( !class_exists( $extension_class ) ) {
				// In case you wanted override your override, hah.
				$class_file = $path . $folder . '/extension_' . $folder . '.php';
				$class_file = apply_filters( 'redux/extension/'.$ReduxFramework->args['opt_name'].'/'.$folder, $class_file );
				if( $class_file ) {
					require_once( $class_file );
					$extension = new $extension_class( $ReduxFramework );
				}
			}
		}
	}
	// Modify {$redux_opt_name} to match your opt_name
	add_action("redux/extensions/".THEME_OPTIONS."/before", 'redux_register_custom_extension_loader', 0);
endif;


add_action('init', 'kt_admin_options_init');
function  kt_admin_options_init(){
    if (file_exists( FW_DATA . 'data-options.php' ) ) {
        require_once( FW_DATA . 'data-options.php' );
    }
}

if (is_admin() ) {
    
    /**
	 * Install Plugins
     * 
	 */ 
 	require_once (FW_DATA . 'data-plugins.php');
    
    /**
	 * Include meta-box.
     * 
	 */ 
    require_once (FW_DATA . 'data-meta-box.php');
    
    
    /**
     * Get Navigation nav
     *
     */
    require_once ( FW_EXT_DIR . 'nav/nav.php' );
    

}
  
/**
 * Force Visual Composer to initialize as "built into the theme". 
 * This will hide certain tabs under the Settings->Visual Composer page
 */

add_action( 'vc_before_init', 'kt_vcSetAsTheme' );
function kt_vcSetAsTheme() {
    vc_set_as_theme();
}


/**
 * Initialising Visual Composer
 * 
 */ 
if ( class_exists( 'Vc_Manager', false ) ) {
    
    if ( ! function_exists( 'js_composer_bridge_admin' ) ) {
		function js_composer_bridge_admin( $hook ) {
			wp_enqueue_style( 'js_composer_bridge', FW_CSS . 'js_composer_bridge.css', array(), FW_VER );
		}
	}
    add_action( 'admin_enqueue_scripts', 'js_composer_bridge_admin', 15 );


    if ( !function_exists('kt_js_composer_bridge') ) {
		function kt_js_composer_bridge() {
			require_once(FW_DIR . 'js_composer/js_composer_parrams.php');
            require_once(FW_DIR . 'js_composer/js_composer_bridge.php');
		}

        if ( function_exists( 'vc_set_shortcodes_templates_dir' ) ) {
            vc_set_shortcodes_templates_dir( THEME_TEMP . '/vc_templates' );
        }
	}
    add_action( 'init', 'kt_js_composer_bridge', 20 );
}


/**
 * Include js_composer update param
 *
 */
require_once ( FW_DIR . 'js_composer/js_composer_update.php' );

/**
 * support for woocommerce helpers
 *
 */
require_once ( FW_DIR . 'woocommerce.php' );

/**
 * Add image icon for product categories
 *
 */
require_once ( FW_DIR . 'product-cat-meta.php' );

/**
 * Add importer
 *
 */
require_once ( FW_DIR . 'importer.php' );


