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
 * Prints a particular instance of collaborate
 *
 * @package    mod_collaborate
 * @copyright  202 Richard Jones richardnz@outlook.com
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 * @see https://github.com/moodlehq/moodle-mod_simplemod
 * @see https://github.com/justinhunt/moodle-mod_simplemod
 */

namespace mod_collaborate\output;

use moodle_url;
use renderable;
use renderer_base;
use templatable;
use stdClass;

/**
 * Collaborate: Create a new showpage page renderable object
 *
 * @param stdClass collaborate - data from database.
 * @param object cm - course module.
 * @param string page - page id.
 * @copyright  2020 Richard Jones <richardnz@outlook.com>
 */

class showpage implements renderable, templatable {

    protected $collaborate;
    protected $cm;
    protected $page;

    public function __construct($collaborate, $cm, $page) {

        $this->collaborate = $collaborate;
        $this->cm = $cm;
        $this->page = $page;
    }

    /**
     * Export this data so it can be used as the context for a mustache template.
     *
     * @param renderer_base $output
     * @return stdClass
     */
    public function export_for_template(renderer_base $output) {

        $data = new stdClass();

        $data->heading = $this->collaborate->title;

        $data->user = 'User: '. strtoupper($this->page);

        // Get the content from the database.
        $content = ($this->page == 'a') ? $this->collaborate->instructionsa : $this->collaborate->instructionsb;
        $data->body = $content;

        // Get a return url back to view page.
        $urlv = new moodle_url('/mod/collaborate/view.php', ['id' => $this->cm->id]);
        $data->url_view = $urlv->out(false);

        return $data;
    }
}