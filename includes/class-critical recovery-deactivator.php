<?php

/**
 * Fired during plugin deactivation
 *
 * @link       https://relyonskill.com
 * @since      1.0.0
 *
 * @package    Critical_Recovery
 * @subpackage Critical_Recovery/includes
 */

/**
 * Fired during plugin deactivation.
 *
 * This class defines all code necessary to run during the plugin's deactivation.
 *
 * @since      1.0.0
 * @package    Critical_Recovery
 * @subpackage Critical_Recovery/includes
 * @author     Maruf Hossain <marufhossainwp@gmail.com>
 */
<?php

class Critical_Recovery_Deactivator {
    public static function deactivate() {
        // Code to execute during deactivation
        delete_transient('critical_recovery_mode');
    }
}




