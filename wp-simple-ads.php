<?php
/*
Plugin Name: WP Simple Ads
Plugin URI: http://#/
Description: A simple plugin for Ads.
Version: 1.0
Author: Shine
Author URI: http://#/
*/
/*  Copyright 2014  Simple Ads

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License, version 2, as 
    published by the Free Software Foundation.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program; if not, write to the Free Software
    Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/

$sasops = get_option( 'sas_op' );
$sasdefault = array(
	'maxadcodes'	=>	3,
	'version'		=>	'1.0'
);
include "sas_func.php";
include "script.php";

function sas_admin_page() {
	add_menu_page( 'Simple Ads', 'Simple Ads', 'manage_options', 'sas_page', 'sas_page_out' );
}
add_action( 'admin_menu', 'sas_admin_page' );

function sas_page_out() {
	global $sasdefault;
?>
	<div class="wrap">
		<h2>Simple Ads Settings <?php echo '<span class="description">Version '.$sasdefault['version'].'</span>'; ?></h2>
		<?php settings_errors(); ?>
		<form method="post" action="options.php">
			<?php
			settings_fields( 'sas_ops' );
			do_settings_sections( 'sas_page' );
			submit_button();
			?>
		</form>
	</div>
<?php
}

add_action( 'admin_init', 'sas_init' );
function sas_init() {
	register_setting( 'sas_ops', 'sas_op', 'sas_sanitize' );

	add_settings_section( 'sas_options_sec', 'Options', 'sas_options_sec', 'sas_page' );
	add_settings_section( 'sas_adcodes_sec', 'Ad Codes', 'sas_adcodes_sec', 'sas_page' );

	add_settings_field( 'sas_pos_field', 'Positions:', 'sas_pos_field', 'sas_page', 'sas_options_sec' );
	add_settings_field( 'sas_codes_field', 'Ads:', 'sas_codes_field', 'sas_page', 'sas_adcodes_sec' );
}

//Function for sanitizing
function sas_sanitize( $input ) {
	$output	=	array();
	foreach( $input as $key => $value ) {
		if( isset( $input[$key] ) ) {
			$output[$key]	=	$input[$key];
		}
	}
	return apply_filters( 'sas_sanitize', $output, $input );
}