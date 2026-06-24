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
 * Tests for the exact column filter type.
 *
 * @package local_wunderbyte_table
 * @copyright 2026 Wunderbyte Gmbh <info@wunderbyte.at>
 * @license http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

namespace local_wunderbyte_table\filters\types;

use local_wunderbyte_table\wunderbyte_table;
use moodle_exception;
use PHPUnit\Framework\TestCase;

/**
 * Unit tests for exactcolumn class.
 */
final class exactcolumn_test extends TestCase {
    /**
     * Test add_to_categoryobject() ignores filter settings without the exactcolumn marker.
     *
     * @covers \local_wunderbyte_table\filters\types\exactcolumn::add_to_categoryobject
     */
    public function test_add_to_categoryobject_ignores_unconfigured_filter(): void {
        $categoryobject = [];
        $filtersettings = [
            'username' => [
                'localizedname' => 'User name',
                'wbfilterclass' => exactcolumn::class,
            ],
        ];

        exactcolumn::add_to_categoryobject($categoryobject, $filtersettings, 'username', ['teacher' => 1]);

        $this->assertSame([], $categoryobject);
    }

    /**
     * Test add_to_categoryobject() marks the category object for exact column rendering.
     *
     * @covers \local_wunderbyte_table\filters\types\exactcolumn::add_to_categoryobject
     */
    public function test_add_to_categoryobject_marks_exactcolumn_filter(): void {
        $categoryobject = [];
        $filtersettings = [
            'username' => [
                exactcolumn::class => true,
            ],
        ];

        exactcolumn::add_to_categoryobject($categoryobject, $filtersettings, 'username', ['teacher' => 1]);

        $this->assertTrue($categoryobject['exactcolumn']);
    }

    /**
     * Test add_filter() adds exactcolumn-specific filter metadata.
     *
     * @covers \local_wunderbyte_table\filters\types\exactcolumn::add_filter
     */
    public function test_add_filter(): void {
        $filter = [];
        $exactcolumn = new exactcolumn('username', 'User name');

        $exactcolumn->add_filter($filter);

        $this->assertArrayHasKey('username', $filter);
        $this->assertSame('User name', $filter['username']['localizedname']);
        $this->assertTrue($filter['username'][exactcolumn::class]);
        $this->assertSame(1, $filter['username']['username_wb_checked']);
        $this->assertSame(exactcolumn::class, $filter['username']['wbfilterclass']);
    }

    /**
     * Test add_filter() prevents duplicate filters for the same column.
     *
     * @covers \local_wunderbyte_table\filters\types\exactcolumn::add_filter
     */
    public function test_add_filter_throws_exception_for_duplicate_column(): void {
        $filter = [];
        $exactcolumn = new exactcolumn('username', 'User name');
        $exactcolumn->add_filter($filter);

        $this->expectException(moodle_exception::class);
        $exactcolumn->add_filter($filter);
    }

    /**
     * Test apply_filter() adds an exact equality condition and stores a lowercase parameter.
     *
     * @covers \local_wunderbyte_table\filters\types\exactcolumn::apply_filter
     */
    public function test_apply_filter_adds_exact_column_condition(): void {
        $table = $this->createMock(wunderbyte_table::class);
        $table->expects($this->once())
            ->method('set_params')
            ->with('teacher')
            ->willReturn('param1');

        $filter = 'existing filter AND ';
        $exactcolumn = new exactcolumn('username', 'User name');

        $exactcolumn->apply_filter($filter, 'u.username', 'Teacher', $table);

        $this->assertSame('existing filter AND u.username = :param1', $filter);
    }

    /**
     * Test apply_filter() ignores empty and non-string category values.
     *
     * @dataProvider invalid_categoryvalue_provider
     * @covers \local_wunderbyte_table\filters\types\exactcolumn::apply_filter
     *
     * @param mixed $categoryvalue
     */
    public function test_apply_filter_ignores_invalid_categoryvalue($categoryvalue): void {
        $table = $this->createMock(wunderbyte_table::class);
        $table->expects($this->never())->method('set_params');
        $filter = 'existing filter';
        $exactcolumn = new exactcolumn('username', 'User name');

        $exactcolumn->apply_filter($filter, 'u.username', $categoryvalue, $table);

        $this->assertSame('existing filter', $filter);
    }

    /**
     * Data provider for category values which should not produce an exactcolumn SQL condition.
     *
     * @return array[]
     */
    public static function invalid_categoryvalue_provider(): array {
        return [
            'empty string' => [''],
            'array value' => [['Teacher']],
            'integer value' => [123],
            'null value' => [null],
        ];
    }
}
