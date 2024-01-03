<?php

namespace LeoPersan\Tests;

use LeoPersan\CalendarioTagmar\Calendar;
use PHPUnit\Framework\TestCase;

class CalendarTest extends TestCase
{
    /**
     * @dataProvider providerNormalize
     */
    public function test(array $data): void
    {
        $calendar = new Calendar($data['date']);
        $this->assertEquals($data['absoluteDay'], $calendar->absoluteDay);
        $this->assertEquals($data['yearDay'], $calendar->yearDay);
        $this->assertEquals($data['monthDay'], $calendar->monthDay);
        $this->assertEquals($data['firstWeekDayOfYear'], $calendar->firstWeekDayOfYear);
        $this->assertEquals($data['weekOfYear'], $calendar->weekOfYear);
        $this->assertEquals($data['weekDay'], $calendar->weekDay);
        $this->assertEquals($data['weekDayName'], $calendar->weekDayName);
        $this->assertEquals($data['month'], $calendar->month);
        $this->assertEquals($data['monthName'], $calendar->monthName);
        $this->assertEquals($data['year'], $calendar->year);
        $this->assertEquals($data['moonPhase'], $calendar->moonPhase);
        $this->assertEquals($data['moonPhaseName'], $calendar->moonPhaseName);
    }

    public static function providerNormalize(): array
    {
        return [
            '01/01/0001' => [
                'data' => [
                    'date' => '01/01/0001',
                    'absoluteDay' => 1,
                    'yearDay' => 1,
                    'monthDay' => 1,
                    'firstWeekDayOfYear' => 1,
                    'weekOfYear' => 1,
                    'weekDay' => 1,
                    'weekDayName' => 'Anaesi',
                    'month' => 1,
                    'monthName' => 'Blator',
                    'year' => '0001',
                    'moonPhase' => 1,
                    'moonPhaseName' => 'Crescente',
                ],
            ],
            '01/01/0002' => [
                'data' => [
                    'date' => '01/01/0002',
                    'absoluteDay' => 362,
                    'yearDay' => 1,
                    'monthDay' => 1,
                    'firstWeekDayOfYear' => 5,
                    'weekOfYear' => 1,
                    'weekDay' => 5,
                    'weekDayName' => 'Saegaeti',
                    'month' => 1,
                    'monthName' => 'Blator',
                    'year' => '0002',
                    'moonPhase' => 4,
                    'moonPhaseName' => 'Nova',
                ],
            ],
            '05/01/0002' => [
                'data' => [
                    'date' => '05/01/0002',
                    'absoluteDay' => 366,
                    'yearDay' => 5,
                    'monthDay' => 5,
                    'firstWeekDayOfYear' => 5,
                    'weekOfYear' => 2,
                    'weekDay' => 2,
                    'weekDayName' => 'Basvo',
                    'month' => 1,
                    'monthName' => 'Blator',
                    'year' => '0002',
                    'moonPhase' => 1,
                    'moonPhaseName' => 'Crescente',
                ],
            ],
            '01/01/0003' => [
                'data' => [
                    'date' => '01/01/0003',
                    'absoluteDay' => 723,
                    'yearDay' => 1,
                    'monthDay' => 1,
                    'firstWeekDayOfYear' => 2,
                    'weekOfYear' => 1,
                    'weekDay' => 2,
                    'weekDayName' => 'Basvo',
                    'month' => 1,
                    'monthName' => 'Blator',
                    'year' => '0003',
                    'moonPhase' => 4,
                    'moonPhaseName' => 'Nova',
                ],
            ],
        ];
    }
}
