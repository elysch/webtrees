<?php

/**
 * webtrees: online genealogy
 * Copyright (C) 2025 webtrees development team
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU General Public License for more details.
 * You should have received a copy of the GNU General Public License
 * along with this program. If not, see <https://www.gnu.org/licenses/>.
 */

declare(strict_types=1);

namespace Fisharebest\Webtrees\Census;

use Fisharebest\Webtrees\TestCase;
use PHPUnit\Framework\Attributes\CoversClass;

#[CoversClass(RegisterOfWales1939::class)]
#[CoversClass(AbstractCensusColumn::class)]
class RegisterOfWales1939Test extends TestCase
{
    public function testPlaceAndDate(): void
    {
        $census = new RegisterOfWales1939();

        self::assertSame('Wales', $census->censusPlace());
        self::assertSame('29 SEP 1939', $census->censusDate());
    }

    public function testColumns(): void
    {
        $census  = new RegisterOfWales1939();
        $columns = $census->columns();

        self::assertCount(8, $columns);
        self::assertInstanceOf(CensusColumnNull::class, $columns[0]);
        self::assertInstanceOf(CensusColumnNull::class, $columns[1]);
        self::assertInstanceOf(CensusColumnSurnameGivenNames::class, $columns[2]);
        self::assertInstanceOf(CensusColumnNull::class, $columns[3]);
        self::assertInstanceOf(CensusColumnSexMF::class, $columns[4]);
        self::assertInstanceOf(CensusColumnBirthDayMonthYear::class, $columns[5]);
        self::assertInstanceOf(CensusColumnConditionEnglish::class, $columns[6]);
        self::assertInstanceOf(CensusColumnOccupation::class, $columns[7]);

        self::assertSame('Schedule', $columns[0]->abbreviation());
        self::assertSame('SubNum', $columns[1]->abbreviation());
        self::assertSame('Name', $columns[2]->abbreviation());
        self::assertSame('Role', $columns[3]->abbreviation());
        self::assertSame('Sex', $columns[4]->abbreviation());
        self::assertSame('DOB', $columns[5]->abbreviation());
        self::assertSame('MC', $columns[6]->abbreviation());
        self::assertSame('Occupation', $columns[7]->abbreviation());

        self::assertSame('Schedule Number', $columns[0]->title());
        self::assertSame('Schedule Sub Number', $columns[1]->title());
        self::assertSame('Surname & other names', $columns[2]->title());
        self::assertSame('For institutions only – for example, Officer, Visitor, Servant, Patient, Inmate', $columns[3]->title());
        self::assertSame('Male or Female', $columns[4]->title());
        self::assertSame('Date of birth', $columns[5]->title());
        self::assertSame('Marital Condition - Married, Single, Unmarried, Widowed or Divorced', $columns[6]->title());
        self::assertSame('Occupation', $columns[7]->title());
    }
}
