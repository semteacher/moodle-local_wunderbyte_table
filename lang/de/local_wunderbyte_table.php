<?php
// This file is part of Moodle - https://moodle.org/
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
// along with Moodle.  If not, see <https://www.gnu.org/licenses/>.

/**
 * German plugin strings are defined here.
 *
 * @package     local_wunderbyte_table
 * @category    string
 * @copyright   2023 Wunderbyte GmbH <info@wunderbyte.at>
 * @license     https://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();

$string['pluginname'] = 'Wunderbyte Table';
$string['loading'] = 'Laden...';
$string['search'] = 'Suchen';
$string['sortby'] = 'Sortieren nach...';
$string['changesortorder'] = "Ändere die Sortierungsrichtung";
$string['orderup'] = "Von A nach Z sortiert";
$string['orderdown'] = "Von Z nach A sortiert";

$string['noentriesfound'] = "Keine Einträge gefunden";

$string['reload'] = "Tabelle neu laden";
$string['print'] = "Tabelle herunterladen";
$string['downloadas'] = "Tabelle laden als";

// Caches.
$string['cachedef_cachedfulltable'] = 'Cache für die ganze Tabelle';
$string['cachedef_cachedrawdata'] = "Wunderbyte Table Standard Cache";
$string['cachedef_encodedtables'] = 'Cache für enkodierte Tabellen';

$string['countlabel'] = '{$a->filteredrecords} von {$a->totalrecords} Einträgen gefunden';

$string['checkallcheckbox'] = "Alles auswählen";
$string['functiondoesntexist'] = "Funktion des Aktionsbuttons exisitert nicht.";
$string['tableheadercheckbox'] = '<input type="checkbox" class="tableheadercheckbox">';

// Test and example strings.
$string['deletedatatitle'] = 'Möchten Sie diese Daten wirklich löschen?';
$string['deletedatabody'] = 'Sie sind dabei, diese Daten zu löschen: <br> "{$a->data}"';
$string['deletedatasubmit'] = 'Löschen';

$string['generictitle'] = 'Möchten Sie wirklich diese Daten bearbeiten?';
$string['genericbody'] = 'Sie sind dabei, diese Zeilen zu bearbeiten: <br> "{$a->data}"';
$string['genericsubmit'] = 'Bestätigen';

$string['somethingwentwrong'] = 'Etwas ist schiefgelaufen. Melden Sie den Fehler ihrem Admin';
$string['nocheckboxchecked'] = 'Keine checkbox ausgewählt';
$string['checkbox'] = 'Checkbox';
$string['module'] = 'Modul';
$string['apply_filter'] = 'Filter anwenden';

$string['pagelabel'] = 'Zeige {$a} Zeilen';

$string['table1name'] = 'Users';
$string['table2name'] = 'Course';
$string['table3name'] = 'Course_Modules';
$string['table4name'] = 'Users_InfiniteScroll';
$string['id'] = 'ID';

// Filter for timespan.
$string['displayrecords'] = 'Zeige Daten';
$string['within'] = 'innerhalb';
$string['overlapboth'] = 'überlappend mit';
$string['overlapstart'] = 'Beginn überlappend';
$string['overlapend'] = 'Ende überlappend';
$string['before'] = 'vor';
$string['after'] = 'nach';
$string['startvalue'] = 'Anfang';
$string['endvalue'] = 'Ende';
$string['selectedtimespan'] = 'gewählter Zeitspanne';
$string['timespan'] = 'Zeitspanne';

// Action Buttons demo names.
$string['nmmcns'] = 'NoModal, MultipleCall, NoSelection';
$string['nmscns'] = 'NoModal, SingleCall, NoSelection';
$string['ymmcns'] = '+Modal, MultipleCall, NoSelection';
$string['ymscns'] = '+Modal, SingleCall, NoSelection';
$string['nmmcys'] = 'NoModal, MultipleCall, Selection';
$string['nmscys'] = 'NoModal, SingleCall, Selection';
$string['ymmcys'] = '+Modal, MultipleCall, Selection';
$string['ymscys'] = '+Modal, SingleCall, Selection';
