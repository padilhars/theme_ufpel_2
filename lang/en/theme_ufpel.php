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
 * Language file for theme_ufpel
 *
 * @package    theme_ufpel
 * @copyright  2025 Universidade Federal de Pelotas
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();

// General strings.
$string['pluginname'] = 'UFPel';
$string['choosereadme'] = 'UFPel is a modern theme based on Boost, customized for the Federal University of Pelotas.';

// Settings page strings.
$string['configtitle'] = 'UFPel theme settings';
$string['generalsettings'] = 'General settings';
$string['advancedsettings'] = 'Advanced settings';
$string['features'] = 'Features';
$string['default'] = 'Default';

// Preset settings.
$string['preset'] = 'Theme preset';
$string['preset_desc'] = 'Pick a preset to broadly change the look of the theme.';
$string['presetfiles'] = 'Additional theme preset files';
$string['presetfiles_desc'] = 'Preset files can be used to dramatically alter the appearance of the theme. See <a href="https://docs.moodle.org/dev/Boost_Presets">Boost presets</a> for information on creating and sharing your own preset files.';

// Color settings.
$string['primarycolor'] = 'Primary color';
$string['primarycolor_desc'] = 'The primary color for the theme. This will be used for main elements like the header and buttons.';
$string['secondarycolor'] = 'Secondary color';
$string['secondarycolor_desc'] = 'The secondary color for the theme. Used for links and secondary elements.';
$string['backgroundcolor'] = 'Background color';
$string['backgroundcolor_desc'] = 'The main background color for the site pages.';
$string['highlightcolor'] = 'Highlight color';
$string['highlightcolor_desc'] = 'The color used for highlighting important elements and accents.';
$string['contenttextcolor'] = 'Content text color';
$string['contenttextcolor_desc'] = 'The color for general text content throughout the site.';
$string['highlighttextcolor'] = 'Highlight text color';
$string['highlighttextcolor_desc'] = 'The color for text that appears on primary colored backgrounds.';

// Logo settings.
$string['logo'] = 'Logo';
$string['logo_desc'] = 'Upload your institution logo. This will replace the site name in the navigation bar.';

// Custom CSS settings.
$string['customcss'] = 'Custom CSS';
$string['customcss_desc'] = 'Whatever CSS rules you add to this textarea will be reflected in every page, making for easier customization of this theme.';

// Login page settings.
$string['loginbackgroundimage'] = 'Login page background image';
$string['loginbackgroundimage_desc'] = 'An image that will be stretched to fill the background of the login page.';

// Favicon settings.
$string['favicon'] = 'Favicon';
$string['favicon_desc'] = 'Upload a custom favicon. Should be an .ico, .png or .svg file.';

// Font settings.
$string['customfonts'] = 'Custom fonts URL';
$string['customfonts_desc'] = 'Enter URL to import custom fonts (e.g., Google Fonts). Use the complete @import tag.';

// Advanced settings.
$string['rawscss'] = 'Raw SCSS';
$string['rawscss_desc'] = 'Use this field to provide SCSS code which will be injected at the end of the stylesheet.';
$string['rawscsspre'] = 'Raw initial SCSS';
$string['rawscsspre_desc'] = 'In this field you can provide initializing SCSS code, it will be injected before everything else. Most of the time you will use this setting to define variables.';

// Feature settings.
$string['showcourseimage'] = 'Show course image';
$string['showcourseimage_desc'] = 'Display the course image in the header of course pages.';
$string['showteachers'] = 'Show teachers';
$string['showteachers_desc'] = 'Display teacher names in the header of course pages.';
$string['courseheaderoverlay'] = 'Course header overlay';
$string['courseheaderoverlay_desc'] = 'Add a dark overlay to the course header to improve text readability.';
$string['footercontent'] = 'Footer content';
$string['footercontent_desc'] = 'Custom HTML content to display in the site footer.';

// Privacy strings.
$string['privacy:metadata'] = 'The UFPel theme does not store any personal data.';

// Region strings.
$string['region-side-pre'] = 'Left';
$string['region-side-post'] = 'Right';

// Course page strings.
$string['teacher'] = 'Teacher';
$string['teachers'] = 'Teachers';

// Template strings.
$string['courseheader'] = 'Course header';

// Accessibility strings.
$string['skipto'] = 'Skip to {$a}';