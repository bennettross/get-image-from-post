<?php
/*
Plugin Name: Get Image from Post
Plugin URI: http://thisismyurl.com/software/web-based/wordpress-plugins/get-image-from-posts/
Description: Used to fetch images from your posts to display as part of the excerpt.
Author: Christopher Ross
Tags: future, upcoming posts, upcoming post, upcoming, draft, Post, scheduled, preview
Author URI: http://thisismyurl.com
Version: 2.1.0
*/

/*  Copyright 2011  Christopher Ross  (email : info@christopherross.ca)

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published by
    the Free Software Foundation; either version 2 of the License, or
    (at your option) any later version.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program; if not, write to the Free Software
    Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/

function thisismyurl_get_image_from_post( $options = '' ) {
    global $post, $wpdb;

	$ns_options = array(
	    "image" => "1",
	    "show" => false,
	    "link" => false,
	    "width" => false,
	    "height" => false,
	    "strip" => false,
        );

	$options = explode( "&", $options );

	foreach ( $options as $option ) {
		$parts = explode( "=", $option );
		if ( $parts[1] )
		    $ns_options[$parts[0]] = $parts[1];
	}

	global $more;
	$more = 1;
	$content = strtolower( get_the_content() );
	$content = explode( "<img", $content ) ;

	if ( $content ) {
		foreach ( $content as $image ) {
			$newimage = explode( ">", $image );
			$thisimage[] = 	"<img ".$newimage[0]."/>";
		}

		$more = 0;
		$link = get_permalink();

		if ( $strip )
		    $thisimage[$ns_options['image']] = thisismyurl_strip_tags_attributes( $thisimage[$ns_options['image']], "img", "src" );
		if ( $show )
		    echo $thisimage[$ns_options['image']];} else {return  $thisimage[$ns_options['image']];
	}
}

function thisismyurl_strip_tags_attributes( $string, $allowtags = NULL, $allowattributes = NULL ){
    $string = strip_tags( $string, $allowtags );
    if ( ! is_null( $allowattributes ) ) {
        if( ! is_array( $allowattributes ) )
            $allowattributes = explode( ",",  $allowattributes );
        if( is_array( $allowattributes ) )
            $allowattributes = implode( ")(?<!", $allowattributes );
        if ( strlen( $allowattributes ) > 0 )
            $allowattributes = "(?<!".$allowattributes.")";
        $string = preg_replace_callback( "/<[^>]*>/i", create_function(
            '$matches',
            'return preg_replace("/ [^ =]*'.$allowattributes.'=(\"[^\"]*\"|\'[^\']*\')/i", "", $matches[0]);'
        ), $string );
    }
    return $string;
}

?>
