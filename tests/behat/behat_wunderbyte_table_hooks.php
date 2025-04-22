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
 * Defines behat wunderbyte table hooks
 *
 * @package local_wunderbyte_table
 * @copyright 2025 Wunderbyte GmbH <info@wunderbyte.at>
 * @author Andrii Semenets
 * @license http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

//namespace local_wunderbyte_table\behat;

use Behat\Behat\Hook\Scope\BeforeScenarioScope;
use Behat\Behat\Hook\Scope\AfterScenarioScope;
//use cache_helper;
//use context_system;
//use behat_base;

/**
 * Hook definitions for local_wunderbyte_table.
 */
class behat_wunderbyte_table_hooks implements \Behat\Behat\Context\Context {

    /**
     * Clean plugin-specific data and reset session before each scenario.
     * @BeforeScenario @local_wunderbyte_table
     */
    public function before_scenario(BeforeScenarioScope $scope) {
        global $DB;
        echo "Cleaning up wunderbyte table and cache...\n";
        $records = $DB->get_records('local_wunderbyte_table');
        echo "Found " . count($records) . " cached records before cleanup.\n";
        //behat_local_wunderbyte_table->i_clean_wbtable_cache(); // Your custom method
        // Clean up Moodle plugin data.
        cache_helper::purge_by_event('changesinwunderbytetable');
        cache_helper::purge_by_event('setbackencodedtables');
        cache_helper::purge_by_event('setbackfilters');
        cache_helper::purge_all();

        $DB->delete_records_select('local_wunderbyte_table', "hash LIKE '%_filterjson' OR hash LIKE '%_sqlquery'");
        $sql = "DELETE FROM {local_wunderbyte_table}";
        $DB->execute($sql);
        $_POST = [];

        // Force logout current user.
        \core\session\manager::terminate_current();
        \core\session\manager::destroy_all();
    }

    /**
     * Optionally clean after each scenario.
     * @AfterScenario @local_wunderbyte_table
     */
    public function after_scenario(AfterScenarioScope $scope) {
        global $DB;

        $DB->delete_records_select('local_wunderbyte_table', "hash LIKE '%_filterjson' OR hash LIKE '%_sqlquery'");
        $sql = "DELETE FROM {local_wunderbyte_table}";
        $DB->execute($sql);

        cache_helper::purge_by_event('changesinwunderbytetable');
        cache_helper::purge_by_event('setbackencodedtables');
        cache_helper::purge_by_event('setbackfilters');
        cache_helper::purge_all();

        $_POST = [];

        \core\session\manager::terminate_current();
        \core\session\manager::destroy_all();
    }
}
