<?php

namespace Jalle19\HsDebaiter\Model;

enum Timespan: string
{
    case WEEK = 'WEEK';
    case MONTH = 'MONTH';
    case YEAR = 'YEAR';
    case ALL_TIME = 'ALL_TIME';

    public function toDays(): int
    {
        return match ($this) {
            Timespan::WEEK => 7,
            Timespan::MONTH => 30,
            Timespan::YEAR => 365,
            Timespan::ALL_TIME => PHP_INT_MAX,
        };
    }
}
