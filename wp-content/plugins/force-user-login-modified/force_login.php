<?php
/*
	Plugin Name: Force User Login
	Plugin URI: http://URI_Of_Page_Describing_Plugin_and_Updates
	Description: A really small plugin that forces a user to login before being able to view any blog content.
	Version: 1.0
    Modification Author: Mateusz Sobczak
    Modification Author URI: http://amazingdiscoveries.org
	Original Author: The Integer Group Development Team
	Original Author URI: http://www.integer.com

    Modification: use get_site_url() to redirect to the login page properly when
    Wordpress is located in a subdirectory.


	Copyright 2009 The Integer Group Dev Team  (email : development@integerdenver.com)

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
	
	add_action( 'template_redirect', 'force_login' );
	
	function force_login() {
		$redirect_to = $_SERVER['REQUEST_URI']; // Change this line to change to where logging in redirects the user, i.e. '/', '/wp-admin', etc.
		
		if ( ! is_user_logged_in() ) {
			if ( is_feed() ) {
				$credentials = array();
				$credentials['user_login'] = $_SERVER['PHP_AUTH_USER'];
				$credentials['user_password'] = $_SERVER['PHP_AUTH_PW'];

				$user = wp_signon( $credentials );

				if ( is_wp_error( $user ) ) {
					header( 'WWW-Authenticate: Basic realm="' . $_SERVER['SERVER_NAME'] . '"' );
					header( 'HTTP/1.0 401 Unauthorized' );
					die();
				}
			}
			else {
		  		header( 'Location: ' . get_site_url() . '/wp-login.php?redirect_to=' . $redirect_to );
				die();
			}
	  	}
	}

?>
