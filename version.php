<?php
/**
 * Uena Moodle Theme version information
 *
 * @package    theme_cdc_moodle
 * @copyright  2024
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();

$plugin->version   = 2026070301; // The current module version (Date: YYYYMMDDXX).
$plugin->requires  = 2024041600; // Requires Moodle 4.4/5.0+ (approximate version).
$plugin->component = 'theme_cdc_moodle'; // Full name of the plugin (used for diagnostics).
$plugin->dependencies = [
    'theme_boost' => 2024041600, // Requires Boost theme.
];
