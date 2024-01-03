<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 *
 * @author      Webjump Core Team <dev@webjump.com.br>
 * @copyright   2024 Webjump (http://www.webjump.com.br)
 * @license     http://www.webjump.com.br Copyright
 * @link        http://www.webjump.com.br
 */

namespace LeoPersan\CalendarioTagmar;

class Calendar
{
    public const MONTHS      = [
        1  => 'Blator',
        2  => 'Ganis',
        3  => 'Selimon',
        4  => 'Sevides',
        5  => 'Cambu',
        6  => 'Parom',
        7  => 'Plandis',
        8  => 'Crezir',
        9  => 'Palier',
        10 => 'Lena',
        11 => 'Maira',
        12 => 'Crizagom',
    ];
    public const WEEK_DAYS   = [
        1 => 'Anaesi',
        2 => 'Basvo',
        3 => 'Calcato',
        4 => 'Moldio',
        5 => 'Saegaeti',
        6 => 'Saverieto',
        7 => 'Sivonte',
    ];
    public const MOON_PHASES = [
        1 => 'Crescente',
        2 => 'Cheia',
        3 => 'Minguante',
        4 => 'Nova',
    ];
    public readonly array  $date;
    public readonly int    $absoluteDay;
    public readonly int    $yearDay;
    public readonly int    $monthDay;
    public readonly int    $firstWeekDayOfYear;
    public readonly int    $weekOfYear;
    public readonly int    $weekDay;
    public readonly string $weekDayName;
    public readonly int $month;
    public readonly string $monthName;
    public readonly string $year;
    public readonly int $moonPhase;
    public readonly string $moonPhaseName;

    public function __construct(string $date = null)
    {
        $date                = $date ?? date('01/01/0001');
        $this->date          = $this->normalize($date);
        $this->year          = $this->getYear();
        $this->absoluteDay   = $this->getAbsoluteDay();
        $this->yearDay       = $this->getYearDay();
        $this->monthDay      = $this->getMonthDay();
        $this->firstWeekDayOfYear = $this->getFirstWeekDayOfYear();
        $this->weekOfYear    = $this->getWeekOfYear();
        $this->weekDay       = $this->getWeekDay();
        $this->weekDayName   = $this->getWeekDayName();
        $this->month         = $this->getMonth();
        $this->monthName         = $this->getMonthName();
        $this->moonPhase     = $this->getMoonPhase();
        $this->moonPhaseName = $this->getMoonPhaseName();
    }

    public function normalize(string $date): array
    {
        if (str_contains($date, '/')) {
            $date = explode('/', $date);
        } elseif (str_contains($date, '-')) {
            $date = explode('-', $date);
        } elseif (str_contains($date, ' ')) {
            $date = array_filter(
                explode(' ', $date),
                fn($part) => !in_array($part, ['', 'de'])
            );
            $date = array_map(fn($part) => trim($part, " \n\r\t\v\0,-/"), $date);
        }

        return [
            'year'  => (int) $date[2],
            'month' => $this->getMonth($date[1]),
            'day'   => (int) $date[0],
        ];
    }

    public function getMonth(int|string $month = null): int
    {
        if ($month === null) {
            $month = $this->date['month'];
        }

        if (in_array($month, self::MONTHS)) {
            return array_flip(self::MONTHS)[$month];
        }

        $month = (int) $month;
        if (array_key_exists($month, self::MONTHS)) {
            return $month;
        }

        throw new \Exception('Invalid month');
    }

    public function getMonthName(int|string $month = null): string
    {
        if ($month === null) {
            $month = $this->date['month'];
        }

        if (array_key_exists($month, self::MONTHS)) {
            return self::MONTHS[$month];
        }

        if (in_array($month, self::MONTHS)) {
            return $month;
        }

        throw new \Exception('Invalid month');
    }

    public function getAbsoluteDay(): int
    {
        return (int) (($this->date['year'] - 1) * 361) + $this->getYearDay();
    }

    public function getYearDay(): int
    {
        return (int) (($this->date['month'] - 1) * 30) + $this->getMonthDay();
    }

    public function getMonthDay(): int
    {
        return (int) $this->date['day'];
    }

    public function getWeekDay(): int
    {
        return match ($this->absoluteDay % 7) {
            0       => 7,
            default => $this->absoluteDay % 7,
        };
    }

    public function getYear(): string
    {
        return str_pad($this->date['year'], 4, '0', STR_PAD_LEFT);
    }

    public function getWeekOfYear(): int
    {
        return (int) ceil(($this->yearDay + $this->firstWeekDayOfYear) / 7);
    }

    public function getWeekDayName(): string
    {
        return self::WEEK_DAYS[$this->weekDay];
    }

    public function getMoonPhase(): int
    {
        return match ($moonPhase = ceil($this->absoluteDay / 7) % 4) {
            0       => 4,
            default => $moonPhase,
        };
    }

    public function getMoonPhaseName(): string
    {
        return self::MOON_PHASES[$this->moonPhase];
    }

    public function getFirstWeekDayOfYear(): int
    {
        $module = ($this->date['year'] % 28 ?: 28) - 1;
        $firstWeekDayOfYear = 8 + ((($module * -3) - 7) % 7);
        return $firstWeekDayOfYear === 8 ? 1 : $firstWeekDayOfYear;
    }
}