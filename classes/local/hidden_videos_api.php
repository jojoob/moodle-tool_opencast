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
 * Hidden videos API for opencast
 *
 * @package    tool_opencast
 * @copyright  2022 Tamara Gunkel <tamara.gunkel@wi.uni-muenster.de>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

namespace tool_opencast\local;

use local_chunkupload\chunkupload_form_element;
use local_chunkupload\local\chunkupload_file;
use tool_opencast\empty_configuration_exception;

defined('MOODLE_INTERNAL') || die;

require_once($CFG->dirroot . '/lib/filelib.php');

/**
 * Hidden videos API for opencast
 *
 * @package    tool_opencast
 * @copyright  2022 Tamara Gunkel <tamara.gunkel@wi.uni-muenster.de>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class hidden_videos_api
{

    public static function is_video_hidden($ocinstanceid, $seriesid, $episodeid) {
        global $DB;
        $ishidden = $DB->get_record('tool_opencast_hidden_videos',
            array('ocinstanceid' => $ocinstanceid, 'seriesid' => $seriesid, 'episodeid' => $episodeid));
        return $ishidden != false;
    }

    public static function hide_video($ocinstanceid, $seriesid, $episodeid) {
        global $DB;
        $entry = (object)[
            'ocinstanceid' => $ocinstanceid,
            'seriesid' => $seriesid,
            'episodeid' => $episodeid
        ];

        $DB->insert_record('tool_opencast_hidden_videos', $entry);
    }

    public static function unhide_video($ocinstanceid, $seriesid, $episodeid) {
        global $DB;

        $DB->delete_records('tool_opencast_hidden_videos',
            array('ocinstanceid' => $ocinstanceid, 'seriesid' => $seriesid, 'episodeid' => $episodeid));
    }
}
