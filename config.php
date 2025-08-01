<?php
// This file is part of Moodle - http://moodle.org/
//
// Moodle is free software: you can redistribute it and/or modify
// it under the terms of the GNU General Public License as published by
// the Free Software Foundation, either version 3 of the License, or
// (at your option) any later version.
//
// Moodle is distributed in the hope that it will be useful,
// but WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
// GNU General Public License for more details.
//
// You should have received a copy of the GNU General Public License
// along with Moodle.  If not, see <http://www.gnu.org/licenses/>.

/**
 * Theme UFPel config file.
 *
 * @package    theme_ufpel
 * @copyright  2025 Universidade Federal de Pelotas
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();

// Theme name.
$THEME->name = 'ufpel';

// Theme parent - inherits all settings from Boost.
$THEME->parents = ['boost'];

// Theme sheets - editor styles are loaded separately.
$THEME->sheets = [];

// Editor sheets to load.
$THEME->editor_sheets = ['editor'];

// Use parent editor sheets from Boost.
$THEME->parentseditorsheets = ['boost'];

// Theme SCSS callback functions.
$THEME->scss = function($theme) {
    return theme_ufpel_get_main_scss_content($theme);
};

// Pre-SCSS callback - for variables.
$THEME->prescsscallback = 'theme_ufpel_get_pre_scss';

// Extra SCSS callback - for additional styles.
$THEME->extrascsscallback = 'theme_ufpel_get_extra_scss';

// CSS post-processing callback.
$THEME->csstreepostprocessor = 'theme_ufpel_css_tree_post_processor';

// Theme layouts - inherit all from Boost.
$THEME->layouts = [];

// Renderer factory.
$THEME->rendererfactory = 'theme_overridden_renderer_factory';

// Required blocks - none specific to UFPel.
$THEME->requiredblocks = '';

// Add blocks position.
$THEME->addblockposition = BLOCK_ADDBLOCK_POSITION_FLATNAV;

// Icon system - FontAwesome.
$THEME->iconsystem = \core\output\icon_system::FONTAWESOME;

// Features inherited from Boost.
$THEME->haseditswitch = true;
$THEME->usescourseindex = true;
$THEME->primary_navigation_favourites = true;

// Activity header configuration.
$THEME->activityheaderconfig = [
    'notitle' => false,
    'nocompletion' => false,
    'nodescription' => false,
    'noavailability' => false,
];

// Block RTL manipulations.
$THEME->blockrtlmanipulations = [
    'side-pre' => 'side-post',
    'side-post' => 'side-pre'
];

// UFPel specific settings.
$THEME->supportscssoptimisation = true;
$THEME->yuicssmodules = [];
$THEME->enablecourseajax = true;

// Dock is not used in modern themes.
$THEME->enable_dock = false;

// Preset files available.
$THEME->presetsfiles = [
    'default.scss',
];

// Remove blocks from some regions if needed.
$THEME->clonable_region_format = 'aside';

// Theme functions.
$THEME->extrascsscallback = 'theme_ufpel_get_extra_scss';
$THEME->prescsscallback = 'theme_ufpel_get_pre_scss';
$THEME->precompiledcsscallback = null;

// Remove any duplicate settings.
$THEME->removedprimarynavitems = [];

// Use secure login layout if required.
$THEME->securelayout = 'secure';