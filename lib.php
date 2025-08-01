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
 * Theme UFPel lib functions.
 *
 * @package    theme_ufpel
 * @copyright  2025 Universidade Federal de Pelotas
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();

/**
 * Returns the main SCSS content for the theme.
 *
 * @param theme_config $theme The theme config object.
 * @return string The SCSS content.
 */
function theme_ufpel_get_main_scss_content($theme) {
    global $CFG;
    
    $scss = '';
    $filename = !empty($theme->settings->preset) ? $theme->settings->preset : 'default.scss';
    
    // Security check for filename
    $filename = clean_param($filename, PARAM_FILE);
    
    $fs = get_file_storage();
    $context = context_system::instance();
    
    // Try to load preset file from theme settings
    if ($filename && ($presetfile = $fs->get_file($context->id, 'theme_ufpel', 'preset', 0, '/', $filename))) {
        $scss .= $presetfile->get_content();
    } else {
        // Load default preset
        $scss .= theme_ufpel_get_default_preset_content($CFG->dirroot);
    }
    
    // Append post.scss content
    $postscss = file_get_contents($CFG->dirroot . '/theme/ufpel/scss/post.scss');
    if ($postscss !== false) {
        $scss .= "\n" . $postscss;
    }
    
    return $scss;
}

/**
 * Get default preset content.
 *
 * @param string $dirroot The Moodle dirroot.
 * @return string The default preset content.
 */
function theme_ufpel_get_default_preset_content($dirroot) {
    $defaultfile = $dirroot . '/theme/ufpel/scss/preset/default.scss';
    
    if (file_exists($defaultfile) && is_readable($defaultfile)) {
        return file_get_contents($defaultfile);
    }
    
    // Fallback to Boost's default
    $boostdefault = $dirroot . '/theme/boost/scss/preset/default.scss';
    if (file_exists($boostdefault) && is_readable($boostdefault)) {
        return file_get_contents($boostdefault);
    }
    
    return '';
}

/**
 * Get compiled CSS.
 *
 * @param theme_config $theme The theme config object.
 * @return string The CSS.
 */
function theme_ufpel_get_pre_scss($theme) {
    $scss = '';
    $configurable = [];
    
    // Primary color (formerly brand color) with validation
    $primarycolor = get_config('theme_ufpel', 'primarycolor');
    // Check for legacy brandcolor setting if primarycolor is not set
    if (empty($primarycolor)) {
        $primarycolor = get_config('theme_ufpel', 'brandcolor');
    }
    
    if (!empty($primarycolor) && preg_match('/^#[a-f0-9]{6}$/i', $primarycolor)) {
        $configurable['primarycolor'] = $primarycolor;
        $configurable['brandcolor'] = $primarycolor; // Keep for backward compatibility
    } else {
        $configurable['primarycolor'] = '#003366'; // UFPel default blue
        $configurable['brandcolor'] = '#003366';
    }
    
    // Secondary color with validation
    $secondarycolor = get_config('theme_ufpel', 'secondarycolor');
    if (!empty($secondarycolor) && preg_match('/^#[a-f0-9]{6}$/i', $secondarycolor)) {
        $configurable['secondarycolor'] = $secondarycolor;
        $configurable['ufpel-secondary'] = $secondarycolor;
    } else {
        $configurable['secondarycolor'] = '#0066cc';
        $configurable['ufpel-secondary'] = '#0066cc';
    }
    
    // Background color
    $backgroundcolor = get_config('theme_ufpel', 'backgroundcolor');
    if (!empty($backgroundcolor) && preg_match('/^#[a-f0-9]{6}$/i', $backgroundcolor)) {
        $configurable['backgroundcolor'] = $backgroundcolor;
    } else {
        $configurable['backgroundcolor'] = '#ffffff';
    }
    
    // Highlight color
    $highlightcolor = get_config('theme_ufpel', 'highlightcolor');
    if (!empty($highlightcolor) && preg_match('/^#[a-f0-9]{6}$/i', $highlightcolor)) {
        $configurable['highlightcolor'] = $highlightcolor;
    } else {
        $configurable['highlightcolor'] = '#ffc107';
    }
    
    // Content text color
    $contenttextcolor = get_config('theme_ufpel', 'contenttextcolor');
    if (!empty($contenttextcolor) && preg_match('/^#[a-f0-9]{6}$/i', $contenttextcolor)) {
        $configurable['contenttextcolor'] = $contenttextcolor;
    } else {
        $configurable['contenttextcolor'] = '#212529';
    }
    
    // Highlight text color
    $highlighttextcolor = get_config('theme_ufpel', 'highlighttextcolor');
    if (!empty($highlighttextcolor) && preg_match('/^#[a-f0-9]{6}$/i', $highlighttextcolor)) {
        $configurable['highlighttextcolor'] = $highlighttextcolor;
    } else {
        $configurable['highlighttextcolor'] = '#ffffff';
    }
    
    // Additional theme colors
    $configurable['ufpel-primary'] = $configurable['primarycolor'];
    
    // Build SCSS variables
    foreach ($configurable as $configkey => $configval) {
        $scss .= sprintf('$%s: %s !default;' . "\n", $configkey, $configval);
    }
    
    // Prepend custom pre-scss
    if (!empty($theme->settings->rawscsspre)) {
        $scss .= "\n" . $theme->settings->rawscsspre . "\n";
    }
    
    return $scss;
}

/**
 * Get extra SCSS to append.
 *
 * @param theme_config $theme The theme config object.
 * @return string The extra SCSS.
 */
function theme_ufpel_get_extra_scss($theme) {
    $scss = '';
    
    // Add custom SCSS
    if (!empty($theme->settings->rawscss)) {
        $scss .= "\n" . $theme->settings->rawscss;
    }
    
    return $scss;
}

/**
 * Post process the CSS.
 *
 * @param string $css The CSS.
 * @param theme_config $theme The theme config object.
 * @return string The processed CSS.
 */
function theme_ufpel_process_css($css, $theme) {
    // Replace login background image placeholder
    $css = theme_ufpel_set_loginbackgroundimage($css, $theme);
    
    // Add custom CSS
    if (!empty($theme->settings->customcss)) {
        $css .= "\n" . $theme->settings->customcss;
    }
    
    return $css;
}

/**
 * Sets the login background image.
 *
 * @param string $css The CSS.
 * @param theme_config $theme The theme config object.
 * @return string The updated CSS.
 */
function theme_ufpel_set_loginbackgroundimage($css, $theme) {
    // Check if we have a login background image setting
    $loginbgimg = $theme->settings->loginbackgroundimage ?? '';
    
    if (!empty($loginbgimg)) {
        try {
            // Get the URL for the image
            $loginbgimgurl = $theme->setting_file_url('loginbackgroundimage', 'loginbackgroundimage');
            
            if (!empty($loginbgimgurl)) {
                // Check if it's already a string or a moodle_url object
                if (is_string($loginbgimgurl)) {
                    $url = $loginbgimgurl;
                } else if (is_object($loginbgimgurl) && method_exists($loginbgimgurl, 'out')) {
                    $url = $loginbgimgurl->out(false);
                } else {
                    // Fallback - remove placeholder
                    $css = str_replace('[[setting:loginbackgroundimage]]', 'none', $css);
                    return $css;
                }
                
                // Escape single quotes in URL for CSS
                $url = str_replace("'", "\\'", $url);
                $replacement = "url('$url')";
                $css = str_replace('[[setting:loginbackgroundimage]]', $replacement, $css);
            } else {
                // No URL available - remove placeholder
                $css = str_replace('[[setting:loginbackgroundimage]]', 'none', $css);
            }
        } catch (Exception $e) {
            // If any error occurs, just remove the placeholder
            $css = str_replace('[[setting:loginbackgroundimage]]', 'none', $css);
            debugging('Error processing login background image: ' . $e->getMessage(), DEBUG_DEVELOPER);
        }
    } else {
        // No image set - remove the placeholder
        $css = str_replace('[[setting:loginbackgroundimage]]', 'none', $css);
    }
    
    return $css;
}

/**
 * Serves any files associated with the theme settings.
 *
 * @param stdClass $course The course object.
 * @param stdClass $cm The course module object.
 * @param context $context The context.
 * @param string $filearea The file area.
 * @param array $args The arguments.
 * @param bool $forcedownload Whether to force download.
 * @param array $options Additional options.
 * @return bool|void
 */
function theme_ufpel_pluginfile($course, $cm, $context, $filearea, $args, $forcedownload, array $options = array()) {
    // Check context level
    if ($context->contextlevel != CONTEXT_SYSTEM) {
        return false;
    }
    
    // Validate file areas - added 'logo' to allowed areas
    $allowedareas = ['loginbackgroundimage', 'preset', 'favicon', 'logo'];
    if (!in_array($filearea, $allowedareas)) {
        return false;
    }
    
    $theme = theme_config::load('ufpel');
    return $theme->setting_file_serve($filearea, $args, $forcedownload, $options);
}

/**
 * Get the current user preferences that are available for the theme.
 *
 * @return array The preferences
 */
function theme_ufpel_get_user_preferences() {
    return [
        'drawer-open-index' => [
            'type' => PARAM_BOOL,
            'null' => NULL_NOT_ALLOWED,
            'default' => true,
            'permissioncallback' => [core_user::class, 'is_current_user'],
        ],
        'drawer-open-block' => [
            'type' => PARAM_BOOL,
            'null' => NULL_NOT_ALLOWED,
            'default' => false,
            'permissioncallback' => [core_user::class, 'is_current_user'],
        ],
    ];
}

/**
 * CSS tree post processor.
 *
 * @param string $css The CSS.
 * @param theme_config $theme The theme config.
 * @return string The processed CSS.
 */
function theme_ufpel_css_tree_post_processor($css, $theme) {
    return theme_ufpel_process_css($css, $theme);
}

/**
 * Get list of available presets.
 *
 * @return array Array of preset choices.
 */
function theme_ufpel_get_presets_list() {
    global $CFG;
    
    $choices = [];
    $presetsdir = $CFG->dirroot . '/theme/ufpel/scss/preset/';
    
    if (is_dir($presetsdir)) {
        $presets = scandir($presetsdir);
        foreach ($presets as $preset) {
            if (substr($preset, -5) === '.scss' && $preset !== '.' && $preset !== '..') {
                $presetname = substr($preset, 0, -5);
                $choices[$preset] = ucfirst(str_replace('_', ' ', $presetname));
            }
        }
    }
    
    // Ensure default is always available
    if (!isset($choices['default.scss'])) {
        $choices['default.scss'] = get_string('default', 'theme_ufpel');
    }
    
    return $choices;
}