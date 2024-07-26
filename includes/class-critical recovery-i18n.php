<?php

/**
 * Define the internationalization functionality
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @link       https://relyonskill.com
 * @since      1.0.0
 *
 * @package    Critical_Recovery
 * @subpackage Critical_Recovery/includes
 */

/**
 * Define the internationalization functionality.
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @since      1.0.0
 * @package    Critical_Recovery
 * @subpackage Critical_Recovery/includes
 * @author     Maruf Hossain <marufhossainwp@gmail.com>
 */
class Critical_Recovery_i18n {


	/**
	 * Load the plugin text domain for translation.
	 *
	 * @since    1.0.0
	 */
	public function load_plugin_textdomain() {

		load_plugin_textdomain(
			'critical recovery',
			false,
			dirname( dirname( plugin_basename( __FILE__ ) ) ) . '/languages/'
		);

	}



}
