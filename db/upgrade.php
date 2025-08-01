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
 * Theme UFPel upgrade script.
 *
 * @package    theme_ufpel
 * @copyright  2025 Universidade Federal de Pelotas
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();

/**
 * Upgrade function for theme_ufpel.
 *
 * @param int $oldversion The version we are upgrading from.
 * @return bool Result of upgrade.
 */
function xmldb_theme_ufpel_upgrade($oldversion) {
    global $DB, $CFG;
    
    $dbman = $DB->get_manager();
    
    // Version 2025072901 - Migrate brandcolor to primarycolor
    if ($oldversion < 2025072901) {
        // Migrate brandcolor setting to primarycolor if it exists
        $brandcolor = get_config('theme_ufpel', 'brandcolor');
        if ($brandcolor !== false && get_config('theme_ufpel', 'primarycolor') === false) {
            set_config('primarycolor', $brandcolor, 'theme_ufpel');
            // Keep brandcolor for backward compatibility
        }
        
        // Set default values for new color settings if not already set
        if (get_config('theme_ufpel', 'backgroundcolor') === false) {
            set_config('backgroundcolor', '#ffffff', 'theme_ufpel');
        }
        
        if (get_config('theme_ufpel', 'highlightcolor') === false) {
            set_config('highlightcolor', '#ffc107', 'theme_ufpel');
        }
        
        if (get_config('theme_ufpel', 'contenttextcolor') === false) {
            set_config('contenttextcolor', '#212529', 'theme_ufpel');
        }
        
        if (get_config('theme_ufpel', 'highlighttextcolor') === false) {
            set_config('highlighttextcolor', '#ffffff', 'theme_ufpel');
        }
        
        // Clear all theme caches to ensure new styles are loaded
        theme_reset_all_caches();
        
        upgrade_plugin_savepoint(true, 2025072901, 'theme', 'ufpel');
    }
    
    // Version 2025080100 - Add new settings migration example
    if ($oldversion < 2025080100) {
        // Example: Migrate old setting to new setting format
        $oldsetting = get_config('theme_ufpel', 'oldsettingname');
        if ($oldsetting !== false) {
            set_config('newsettingname', $oldsetting, 'theme_ufpel');
            unset_config('oldsettingname', 'theme_ufpel');
        }
        
        // Clear theme caches
        theme_reset_all_caches();
        
        upgrade_plugin_savepoint(true, 2025080100, 'theme', 'ufpel');
    }
    
    // Version 2025090100 - Cache definition update
    if ($oldversion < 2025090100) {
        // Purge caches if cache definitions have changed
        cache_helper::purge_by_definition('theme_ufpel', 'courseteachers');
        cache_helper::purge_by_definition('theme_ufpel', 'themesettings');
        
        upgrade_plugin_savepoint(true, 2025090100, 'theme', 'ufpel');
    }
    
    // Always clear theme caches at the end of upgrade
    theme_reset_all_caches();
    
    return true;
}