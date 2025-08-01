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
 * Renderers to align UFPel theme with Moodle's bootstrap renderer.
 *
 * @package    theme_ufpel
 * @copyright  2025 Universidade Federal de Pelotas
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

namespace theme_ufpel\output;

use html_writer;
use moodle_url;
use context_course;
use cache;
use stdClass;

defined('MOODLE_INTERNAL') || die;

/**
 * Renderers to align UFPel theme with Moodle's bootstrap renderer.
 *
 * @package    theme_ufpel
 * @copyright  2025 Universidade Federal de Pelotas
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class core_renderer extends \theme_boost\output\core_renderer {
    
    /**
     * @var array Cache for course teachers to avoid multiple DB queries.
     */
    protected $teacherscache = [];
    
    /**
     * Returns the URL for the favicon.
     *
     * @return moodle_url The favicon URL
     */
    public function favicon() {
        // Check if we have a custom favicon.
        $favicon = $this->page->theme->setting_file_url('favicon', 'favicon');
        if (!empty($favicon)) {
            return $favicon;
        }
        
        return parent::favicon();
    }
    
    /**
     * Get the logo URL.
     *
     * @param int $maxwidth The maximum width, or null when the maximum width does not matter.
     * @param int $maxheight The maximum height, or null when the maximum height does not matter.
     * @return string|null The logo URL or null if not set.
     */
    public function get_logo_url($maxwidth = null, $maxheight = 200) {
        // Check if we have a custom logo from theme settings
        $logo = $this->page->theme->setting_file_url('logo', 'logo');
        if (!empty($logo)) {
            // Convert to string if it's a moodle_url object
            if (is_object($logo) && method_exists($logo, 'out')) {
                return $logo->out(false);
            }
            return (string)$logo;
        }
        
        // Fall back to parent implementation if no custom logo
        return parent::get_logo_url($maxwidth, $maxheight);
    }
    
    /**
     * Override navbar brand to use logo if available.
     *
     * @return string HTML for navbar brand
     */
    public function navbar_brand() {
        $logourl = $this->get_logo_url(null, 40);
        
        if ($logourl) {
            $sitename = format_string($this->page->course->shortname, true, 
                ['context' => context_course::instance($this->page->course->id)]);
            
            $logo = html_writer::img($logourl, $sitename, ['class' => 'logo', 'style' => 'max-height: 40px; width: auto;']);
            
            return html_writer::link(
                new moodle_url('/'),
                $logo,
                ['class' => 'navbar-brand has-logo', 'aria-label' => $sitename]
            );
        }
        
        // Fallback to text if no logo
        return parent::navbar_brand();
    }
    
    /**
     * Returns HTML to display the main header.
     *
     * @return string
     */
    public function full_header() {
        global $COURSE, $PAGE;
        
        // Get parent header first.
        $header = parent::full_header();
        
        // Check if course header should be displayed.
        if (!$this->should_display_course_header()) {
            return $header;
        }
        
        // Get course header data.
        $coursedata = $this->get_course_header_data();
        if (empty($coursedata)) {
            return $header;
        }
        
        // Render custom course header.
        $customheader = $this->render_course_header($coursedata);
        
        // Inject before the page header.
        return $customheader . $header;
    }
    
    /**
     * Check if course header should be displayed.
     *
     * @return bool
     */
    protected function should_display_course_header() {
        global $COURSE, $PAGE;
        
        // Check if feature is enabled.
        if (!get_config('theme_ufpel', 'showcourseimage')) {
            return false;
        }
        
        // Only show on course pages.
        if (!in_array($PAGE->pagelayout, ['course', 'incourse'])) {
            return false;
        }
        
        // Don't show on site home.
        if ($COURSE->id == SITEID) {
            return false;
        }
        
        return true;
    }
    
    /**
     * Get course header data.
     *
     * @return stdClass|null Course header data or null if not available.
     */
    protected function get_course_header_data() {
        global $COURSE;
        
        $data = new stdClass();
        $data->courseid = $COURSE->id;
        $data->coursename = format_string($COURSE->fullname);
        
        // Get course image if enabled.
        if (get_config('theme_ufpel', 'showcourseimage')) {
            $data->imageurl = $this->get_course_image_url();
        }
        
        // Get teachers if enabled.
        if (get_config('theme_ufpel', 'showteachers')) {
            $data->teachers = $this->get_course_teachers_cached($COURSE->id);
        }
        
        // Check if we have any content to display.
        if (empty($data->imageurl) && empty($data->teachers)) {
            return null;
        }
        
        $data->hasoverlay = get_config('theme_ufpel', 'courseheaderoverlay');
        
        return $data;
    }
    
    /**
     * Render course header.
     *
     * @param stdClass $data Course header data.
     * @return string HTML for course header.
     */
    protected function render_course_header($data) {
        $classes = ['ufpel-course-header'];
        if ($data->hasoverlay) {
            $classes[] = 'has-overlay';
        }
        
        $attributes = ['id' => 'ufpel-course-header'];
        if (!empty($data->imageurl)) {
            $attributes['style'] = 'background-image: url(\'' . s($data->imageurl) . '\');';
        }
        
        $output = html_writer::start_div(implode(' ', $classes), $attributes);
        
        if ($data->hasoverlay) {
            $output .= html_writer::div('', 'ufpel-course-header-overlay');
        }
        
        $output .= html_writer::start_div('ufpel-course-header-content');
        $output .= html_writer::tag('h1', s($data->coursename), ['class' => 'ufpel-course-title']);
        
        if (!empty($data->teachers)) {
            $teachertext = $this->format_teachers_text($data->teachers);
            $output .= html_writer::tag('p', s($teachertext), ['class' => 'ufpel-course-teachers']);
        }
        
        $output .= html_writer::end_div(); // content
        $output .= html_writer::end_div(); // header
        
        return $output;
    }
    
    /**
     * Get course image URL.
     *
     * @return string|null The course image URL or null if not available.
     */
    protected function get_course_image_url() {
        global $COURSE;
        
        $context = context_course::instance($COURSE->id);
        $fs = get_file_storage();
        $files = $fs->get_area_files($context->id, 'course', 'overviewfiles', 0, 'filename', false);
        
        if ($files) {
            foreach ($files as $file) {
                if ($file->is_valid_image()) {
                    return moodle_url::make_pluginfile_url(
                        $context->id,
                        'course',
                        'overviewfiles',
                        null,
                        '/',
                        $file->get_filename()
                    )->out();
                }
            }
        }
        
        return null;
    }
    
    /**
     * Get course teachers with caching.
     *
     * @param int $courseid Course ID.
     * @return array Array of teacher names.
     */
    protected function get_course_teachers_cached($courseid) {
        // Check memory cache first.
        if (isset($this->teacherscache[$courseid])) {
            return $this->teacherscache[$courseid];
        }
        
        // Try to get from Moodle cache.
        $cache = cache::make('theme_ufpel', 'courseteachers');
        $teachers = $cache->get($courseid);
        
        if ($teachers === false) {
            // Not in cache, fetch from database.
            $teachers = $this->get_course_teachers($courseid);
            $cache->set($courseid, $teachers);
        }
        
        // Store in memory cache.
        $this->teacherscache[$courseid] = $teachers;
        
        return $teachers;
    }
    
    /**
     * Get course teachers from database.
     *
     * @param int $courseid Course ID.
     * @return array Array of teacher names.
     */
    protected function get_course_teachers($courseid) {
        global $DB;
        
        $context = context_course::instance($courseid);
        $teachers = [];
        
        // Get teacher and editingteacher roles.
        $roleids = [];
        $roles = $DB->get_records_sql("
            SELECT id FROM {role} 
            WHERE archetype IN ('teacher', 'editingteacher')
        ");
        
        if (empty($roles)) {
            return [];
        }
        
        $roleids = array_keys($roles);
        
        // Get users with teacher roles.
        list($insql, $params) = $DB->get_in_or_equal($roleids, SQL_PARAMS_NAMED);
        $params['contextid'] = $context->id;
        
        $sql = "SELECT DISTINCT u.id, u.firstname, u.lastname, u.firstnamephonetic, 
                       u.lastnamephonetic, u.middlename, u.alternatename
                  FROM {user} u
                  JOIN {role_assignments} ra ON ra.userid = u.id
                 WHERE ra.contextid = :contextid
                   AND ra.roleid $insql
                   AND u.deleted = 0
                   AND u.suspended = 0
              ORDER BY u.lastname, u.firstname";
        
        $users = $DB->get_records_sql($sql, $params);
        
        foreach ($users as $user) {
            $teachers[] = fullname($user);
        }
        
        return $teachers;
    }
    
    /**
     * Format teachers text.
     *
     * @param array $teachers Array of teacher names.
     * @return string Formatted teachers text.
     */
    protected function format_teachers_text($teachers) {
        if (empty($teachers)) {
            return '';
        }
        
        $count = count($teachers);
        if ($count == 1) {
            $label = get_string('teacher', 'theme_ufpel');
        } else {
            $label = get_string('teachers', 'theme_ufpel');
        }
        
        return $label . ': ' . implode(', ', $teachers);
    }
    
    /**
     * Override to add custom classes to body tag.
     *
     * @param array $additionalclasses Additional classes to add.
     * @return string HTML attributes to use within the body tag.
     */
    public function body_attributes($additionalclasses = []) {
        global $PAGE;
        
        // Add theme-specific classes.
        $additionalclasses[] = 'theme-ufpel';
        
        // Add version class for CSS targeting.
        $additionalclasses[] = 'ufpel-v1';
        
        // Check if we're on the login page.
        if ($this->page->pagelayout == 'login') {
            $loginbgimg = $this->page->theme->setting_file_url('loginbackgroundimage', 'loginbackgroundimage');
            if (!empty($loginbgimg)) {
                $additionalclasses[] = 'has-login-background';
            }
        }
        
        // Add class for course pages with custom header.
        if ($this->should_display_course_header()) {
            $additionalclasses[] = 'has-course-header';
        }
        
        return parent::body_attributes($additionalclasses);
    }
    
    /**
     * Returns HTML for the login page background.
     *
     * @return string HTML to display the login background.
     */
    public function login_background() {
        if ($this->page->pagelayout !== 'login') {
            return '';
        }
        
        $loginbgimg = $this->page->theme->setting_file_url('loginbackgroundimage', 'loginbackgroundimage');
        if (empty($loginbgimg)) {
            return '';
        }
        
        // Get URL as string safely
        $url = '';
        if (is_string($loginbgimg)) {
            $url = $loginbgimg;
        } else if (is_object($loginbgimg) && method_exists($loginbgimg, 'out')) {
            $url = $loginbgimg->out(false);
        }
        
        if (empty($url)) {
            return '';
        }
        
        // Use inline style to avoid SCSS compilation issues
        $style = 'background-image: url(\'' . addslashes($url) . '\');';
        $style .= 'background-size: cover;';
        $style .= 'background-position: center;';
        $style .= 'background-repeat: no-repeat;';
        
        $output = html_writer::div('', 'login-background-image', ['style' => $style]);
        
        return $output;
    }
    
    /**
     * Returns the HTML for the footer.
     *
     * @return string HTML footer
     */
    public function footer() {
        $output = '';
        
        // Add custom footer content if configured.
        $footercontent = get_config('theme_ufpel', 'footercontent');
        if (!empty($footercontent)) {
            $output .= html_writer::div(
                format_text($footercontent, FORMAT_HTML),
                'ufpel-footer-content'
            );
        }
        
        // Add parent footer.
        $output .= parent::footer();
        
        return $output;
    }
}