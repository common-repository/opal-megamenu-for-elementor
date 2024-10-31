<?php

defined( 'ABSPATH' ) || exit();

class OSF_Megamenu_Frontend {

	/**
	 *  
	 */
	function __construct() {
		add_action('elementor/frontend/after_register_styles', [$this, 'register_style_frontend'], 99 );
		add_action('elementor/frontend/after_register_scripts', [$this, 'register_script_frontend']);
	}

	/**
	 * enqueue editor.js for edit mode
	 */
	public function register_style_frontend() {
		$load = apply_filters( 'osf_megamenu_load_frontend_style', true );
        if( $load ){

            wp_register_style('opal-megamenu-frontend', trailingslashit(OM_PLUGIN_URI) . 'assets/css/frontend.css');
            wp_enqueue_style( 'opal-megamenu-frontend' );
            wp_enqueue_script('smartmenus', trailingslashit(OM_PLUGIN_URI) . 'assets/js/libs/jquery.smartmenus.min.js', array('jquery'), false, true);
			wp_enqueue_script('opal-megamenu-frontend', trailingslashit(OM_PLUGIN_URI) . 'assets/js/frontend.js', array('jquery'), false, true); 

        }
	}

	public function register_script_frontend(){  

		
	}

}

new OSF_Megamenu_Frontend();

