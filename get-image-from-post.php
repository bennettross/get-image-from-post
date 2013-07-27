<?php
/*
Plugin Name: Get Image from Post
Plugin URI: http://thisismyurl.com/plugins/get-image-from-posts/
Description: Used to fetch images from your posts to display as part of the excerpt.
Tags: future, upcoming posts, upcoming post, upcoming, draft, Post, scheduled, preview
Author: Christopher Ross
Author URI: http://thisismyurl.com/
Version: 3.0.01-beta
*/






/**
 * Get Image from Post core file
 *
 * This file contains all the logic required for the plugin
 *
 * @link		http://wordpress.org/extend/plugins/stop-pinging-yourself-for-wordpress/
 *
 * @package 	Get Image from Post
 * @copyright	Copyright (c) 2008, Chrsitopher Ross
 * @license		http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU General Public License, v2 (or newer)
 *
 * @since 		Get Image from Post 1.0
 */




$text_domain = strtolower( str_replace( '-', '_', basename( __FILE__ ) ) );

$settings = array(	'plugin_name'		=> __( 'Get Image from Post', $text_domain ),
					'plugin_menu_name'	=> __( 'Get Image', $text_domain ),
					'plugin_dir'		=> plugin_dir_path( __FILE__ ),
					'plugin_file'		=> basename( __FILE__ ),
					'plugin_url'		=> plugin_dir_url( __FILE__ ),
					'plugin_text_domain'=> $text_domain,
					'plugin_settings'	=> FALSE
			);

require_once( $settings['plugin_dir'] . 'wordpress-plugins-common/thisismyurl-common-functions.php' );
$gifp_common = new THISISMYURLCommonFunctions_v_0_1 ( $settings );



if ( ! class_exists( 'THISISMYURL_StopPingingYourselfforWordPress' ) ) {
class THISISMYURL_StopPingingYourselfforWordPress {

	/**
	* The public contructor class for the plugin
	*
	* @uses foreach
	* @uses add_shortcode
	*
	* @since 1.0.0
	* @package Get Image from Post
	* @version 1.0.0
	*
	* @author Christopher Ross <info@thisismyurl.com>
	* @copyright Copyright (c) 2013, Christopher Ross
	* @license http://www.gnu.org/licenses/old-licenses/gpl-2.0.html
	*
	*/
	public function __construct( $settings ) {

		/* assign the settings to $this */
		foreach ( $settings as $label=>$setting ) { $this->$label = $setting; }

		/* remove the pre ping */
		add_action( 'pre_ping', array( $this, 'no_self_ping' ) );

	} /* __construct() */


	/**
	* Removes the self ping
	*
	* @uses foreach
	* @uses unset
	* @uses get_option
	*
	* @since 1.0.0
	* @package Get Image from Post
	* @version 1.0.0
	*
	* @author Christopher Ross <info@thisismyurl.com>
	* @copyright Copyright (c) 2013, Christopher Ross
	* @license http://www.gnu.org/licenses/old-licenses/gpl-2.0.html
	*
	*/
	public function get_image_from_post( $options = NULL ) {

		global $post;

		/* set the defaults for the function */
		$defaults = $this->get_settings();
		$options = wp_parse_args( $options, $defaults );


		/** set legacy conversion **/
		$legacy_option = array(
							array( 'id', 'ID' ),
						);


		/** check legacy options **/
		foreach ( $legacy_option as $option_test ) {

			if ( isset( $options[ $option_test[0] ] ) )
				$options[ $option_test[1] ] = $options[ $option_test[0] ];
		}

		if ( ! isset( $options['ID'] ) )
			$options['ID'] = $post->ID;


		if ( isset( $options['ID'] ) )
			$post_details = get_post( $options['ID'] );

		if ( isset( $post_details ) ) {

			preg_match_all('/<img[^>]+>/i', $post_details->post_content , $images );

			if ( isset( $images ) )
				$images_from_post = $images[0];

			if ( isset( $images_from_post ) ) {
				$image_contents = new DOMDocument();
				$image_contents->loadHTML( $images_from_post[ $options['image'] ]);
				$image_attributes = $image_contents->getElementsByTagName('img');

				foreach( $image_attributes as $image_attribute ) {
					$scr_attribute = $image_attribute->getAttribute('src');
				}

				if ( isset( $scr_attribute ) ){
					if ( TRUE === $options[ 'show' ] )
						echo $scr_attribute;
					else
						return $scr_attribute;
				}
			}

		}
	}

	/**
	* Sets the default values for the plugin
	*
	*
	* @since 3.0.01
	* @package Get Image from Post
	* @version 1.0.0
	*
	* @author Christopher Ross <info@thisismyurl.com>
	* @copyright Copyright (c) 2013, Christopher Ross
	* @license http://www.gnu.org/licenses/old-licenses/gpl-2.0.html
	*
	*
	*/
	public function get_settings( $args = NULL ) {

		$defaults = array(
					'image' => 	1,
					'show' => 	FALSE,
					'link' => 	FALSE,
					'width' => 	FALSE,
					'height' => FALSE,
					'strip' => 	FALSE,
					'ID' => 	NULL,
		);

		return $defaults;

	} /* get_settings() */


}
}
$gifp_plugin = new THISISMYURL_StopPingingYourselfforWordPress ( $settings );



/**
 ****************************************************************************************************************
 *
 * Legacy functions
 *
 ****************************************************************************************************************
 */


if ( ! function_exists( 'thisismyurl_get_better_excerpt' ) ) {

	function thisismyurl_get_image_from_post( $options = '' ) {

		global $gifp_plugin;

		$gifp_plugin->get_image_from_post( $options );

	} /* thisismyurl_get_image_from_post() */

} /* end if */
