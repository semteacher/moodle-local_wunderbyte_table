# Wunderbyte Table #
Wunderbyte Table can be used instead of the table_sql class and then supports all the actions via Ajax.

This local plugin was developed to allow the use of the table_sql class within modals and tabs.
There is no special configuration required, BUT with special configuration, your table will be much more powerful.
After the installation of the local_wunderbyte_table, you can create an
extended class to wunderbyte_table (instead of table_sql).

    class booking_table extends wunderbyte_table {}

If your extended table class contains another class (eg myplugin_class), make sure you can instantiate it with only the cmid. Errors will be thrown if this is not possible.

From 1.1.1 on, wunderbyte_table is loaded only once the corresponding div and none of it's parent is hidden (display:none) and it will add a visbility listener on the next hidden parent element. Unhiding will trigger loading of the table.

The included demo.php is only meant to demonstrate the working of the table.

That's all it takes. Switching pages, sorting, hiding columns and downloading will now run via ajax.

## Multiple custom templates
Wunderbyte Table comes with a responsive table template, but it can and should be overriden in your project. To do so, set in your instance of your extended class (eg $yourtable) the template to your proper template, like

    $yourtable->tabletemplate = 'mod_yourtemplate/yourtable'

where yourtable corresponds to yourtable.mustache in your own project.

With Version 1.2.1 Wunderbyte Table supports multiple templates in one project. The structure has to be like this:
- A yourfirsttable_container.mustache includes possible search, filter and sort components
- This container also contains yourfirsttable.mustache
- This table mustache contains yourfirsttable_row.mustache.
Only by obeing this structure in your own project, the reloading triggered by filter, search etc. will work.

## Caching
One new feature is caching. Wunderbyte_table will automatically pass every sql call to the MODE_APPLICATION cache with the key being the hashed request.

A request for page one will be cached with a different key than a request for page 2 etc.

Invalidation of the cache is being done by

    cache_helper::purge_by_event('changesinwunderbytetable');

If you don't run this every time your table changes, you won't see the changes in your DB reflected in the
output of wunderbyte table, unless you otherwise purge the cache.

If you use more than one table in your plugin or if there is a possibility that more than one
Plugin uses local_wunderbyte_table on your system, you should provide your own cache definitons
in your plugin. Use the define_cache('mod_myplugin', 'mycachename') function to set your own caches.

## JavaScript
This description is only relevant in one case: If you override a value from your table via the col_mycolumn function in the wunderbyte_table class and you use a mustache template and renderer to echo html (eg. to render a button or a modal etc.) AND if this mustache template includes javascript, then you will encounter the problem, that the JS won't be automatically included.
The reason is that the js would be added to the page footer via the renderer, but it is simply skipped in this particular usecase. Therefore, you need to add the JS instead of your column template to the table template.
Any JS which is on this labe (corresponding to table.mustache in the wunderbyte_table project), will be executed after the table is correctly rendered.
You have to make sure to write your js in a way that your can find the necessary variables (eg. the ids of your rows) without being able to pass them directly via the mustache template.

## Action buttons
You can add a number of action buttons to your table. If you combine them with "$yourtable->addcheckbox = true", you will be able to select single lines and execute your function with it. The methods will need to be implemented in your child class of wunderbyte table and they will be called via ajax. Example:

    $mytable->addcheckbox = true;
    $mytable->actionbuttons = [
        'label' => get_string('deleterow', 'mod_myproject'), // Name of your action button.
        'methodname' => 'deleterow', // The method needs to be added to your child of wunderbyte_table class.
        'data' => [ // Will be added eg as data-id = $values->id, so values can be transmitted to the method above.
            'id' => 'id'
        ]
    ];

## Filter, Sort and Search
WB Table provides direct filter, search and sort functionality.

    $table->define_filtercolumns(['id', 'username', 'firstname', 'lastname', 'email']);
    $table->define_fulltextsearchcolumns(['username', 'firstname', 'lastname']);
    $table->define_sortablecolumns(['id', 'username', 'firstname', 'lastname']);

In order for them to work, you must obey some rules: Filter basically just add another 'where' to the sql. The column name must therefor be like the filtercolumn. If the "WHERE columnname like '%myname%'" doesn't work, because you would need to write "WHERE s1.columnname like '%myname%'", then the filter will not work. You would need to wrap your SQL so to eliminate the need for the columnname prefix.

As for the filter, you have these further functionalities:
- localize labels and results
- sort possible results in the filter panel (eg to have weekdays in order)

Here is an example how to set this up:
By the way: 'id' will aways be obmitted, as it is not a useful filter in any case.

    $table->define_filtercolumns([
        'id', 'sport' => [
            'localizedname' => get_string('sport', 'mod_myplugin')
        ], 'dayofweek' => [
            'localizedname' => get_string('dayofweek', 'mod_myplugin'),
            'monday' => get_string('monday', 'mod_myplugin'),
            'tuesday' => get_string('tuesday', 'mod_myplugin'),
            'wednesday' => get_string('wednesday', 'mod_myplugin'),
            'thursday' => get_string('thursday', 'mod_myplugin'),
            'friday' => get_string('friday', 'mod_myplugin'),
            'saturday' => get_string('saturday', 'mod_myplugin'),
            'sunday' => get_string('sunday', 'mod_myplugin')
        ],  'location' => [
            'localizedname' => get_string('location', 'mod_myplugin')
        ],
    ]);

If the output template you want to use doesn't support clickable headers to sort (eg because you use cards), you might want to use the sort select. Just add

    $table->cardsort = true;

to your wunderbyte_table classs (look in the _container templates to understand how this works).

### Exploding strings for columns storing multiple values
The define_filtercolumns function also supports columns with multiple values stored as string with a separator.

You can define the separator like this:

    $table->define_filtercolumns([
        'mycolname' => [
            'localizedname' => get_string('mystring', 'mod_myplugin'),
            'explode' => ',', // In this example, a comma is the separator, you might need another one.
        ],
    ]);

### Handle JSON objects
The define_filtercolumns function also supports columns storing one or multiple JSON objects.
You can define the attribute of the JSON object which should be used for the filter:

    $table->define_filtercolumns([
        'mycolname' => [
            'localizedname' => get_string('mystring', 'mod_myplugin'),
            'jsonattribute' => 'name', // Replace 'name' with the actual attribute name.
        ],
    ]);


## Lazy loading vs. direct out
To lazy load wunderbyte table (eg. for loading in tabs or modals) you need to call $table->lazyout() instead of $table->out. While out will return the html to echo, lazyout echos right away. If you want the html of lazyout, use $table->lazyouthtml();

## Installing via uploaded ZIP file ##
1. Log in to your Moodle site as an admin and go to _Site administration >
   Plugins > Install plugins_.
2. Upload the ZIP file with the plugin code. You should only be prompted to add
   extra details if your plugin type is not automatically detected.
3. Check the plugin validation report and finish the installation.

## Installing manually ##
The plugin can be also installed by putting the contents of this directory to

    {your/moodle/dirroot}/local/wunderbyte_table}

Afterwards, log in to your Moodle site as an admin and go to _Site administration >
Notifications_ to complete the installation.

Alternatively, you can run

    $ php admin/cli/upgrade.php

to complete the installation from the command line.

## License ##
2023 Wunderbyte GmbH <info@wunderbyte.at>

This program is free software: you can redistribute it and/or modify it under
the terms of the GNU General Public License as published by the Free Software
Foundation, either version 3 of the License, or (at your option) any later
version.

This program is distributed in the hope that it will be useful, but WITHOUT ANY
WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR A
PARTICULAR PURPOSE.  See the GNU General Public License for more details.

You should have received a copy of the GNU General Public License along with
this program.  If not, see <https://www.gnu.org/licenses/>.
