<?php
/**
 * Uena Moodle Theme configuration
 *
 * @package    theme_cdc_moodle
 * @copyright  2024
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();

$THEME->name = 'cdc_moodle';
$THEME->sheets = [];
$THEME->editor_sheets = [];
$THEME->parents = ['boost']; // Inherit from Boost.
$THEME->enable_dock = false;
$THEME->yuicssmodules = array();
$THEME->rendererfactory = 'theme_overridden_renderer_factory';
$THEME->requiredblocks = '';
$THEME->addblockposition = BLOCK_ADDBLOCK_POSITION_FLATNAV;
$THEME->iconsystem = \core\output\icon_system::FONTAWESOME;

// SCSS callbacks
$THEME->prescsscallback = 'theme_cdc_moodle_get_pre_scss';
$THEME->extrascsscallback = 'theme_cdc_moodle_get_main_scss_content';
