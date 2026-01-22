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
 * Mock class for vat checking with external platforms.
 *
 * @package    local_wunderbyte_table
 * @copyright  2026 Wunderbyte Gmbh <info@wunderbyte.at>
 * @author     Andrii Semenets
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

namespace local_wunderbyte_table\tests;

use local_wunderbyte_table\wunderbyte_table;
use local_wunderbyte_table\output\table;

/**
 * Mock class for vat checking with external platforms.
 *
 * @package    local_wunderbyte_table
 * @copyright  2026 Wunderbyte Gmbh <info@wunderbyte.at>
 * @author     Andrii Semenets
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class wunderbyte_table_mock extends wunderbyte_table {
    /**
     * Finish output
     *
     * @param bool $closeexportclassdoc
     * @param string $encodedtable
     *
     * @return table|null
     *
     */
    public function finish_output($closeexportclassdoc = true, $encodedtable = ''): table|null {
        if ($this->exportclass !== null) {
            // Still generate the download content.
            $this->exportclass->finish_table();

            // IMPORTANT: do not call finish_document() to avoid exit().
            return null;
        }
        return parent::finish_output($closeexportclassdoc, $encodedtable);
    }
}
