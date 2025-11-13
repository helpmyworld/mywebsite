<?php

namespace App\Support;

use Carbon\CarbonImmutable;

class Quarter
{
    /**
     * Resolve period and (optional) custom range.
     * @param string $label 'this'|'last'|'ytd'|'YYYY-Q[1-4]'|'custom'
     * @param string|null $from 'YYYY-MM-DD' (only used when $label === 'custom')
     * @param string|null $to   'YYYY-MM-DD' (only used when $label === 'custom')
     * @return array [start: CarbonImmutable, end: CarbonImmutable, label: string]
     */
    public static function bounds(string $label = 'this', ?string $from = null, ?string $to = null): array
    {
        $tz  = config('reporting.timezone', 'Africa/Johannesburg');
        $now = CarbonImmutable::now($tz);

        // YTD
        if ($label === 'ytd') {
            $start = $now->startOfYear()->startOfDay();
            $end   = $now->endOfDay();
            return [$start, $end, sprintf('%d-YTD', $now->year)];
        }

        // Last quarter
        if ($label === 'last') {
            $q = $now->subQuarter();
            $start = $q->startOfQuarter()->startOfDay();
            $end   = $q->endOfQuarter()->endOfDay();
            return [$start, $end, sprintf('%d-Q%d', $q->year, (int)ceil($q->month / 3))];
        }

        // Specific quarter like "2025-Q3"
        if (preg_match('/^(\d{4})-Q([1-4])$/', $label, $m)) {
            $y = (int)$m[1];
            $q = (int)$m[2];
            $month = ($q - 1) * 3 + 1;
            $start = CarbonImmutable::create($y, $month, 1, 0, 0, 0, $tz)->startOfDay();
            $end   = $start->addMonths(3)->subSecond();
            return [$start, $end, $label];
        }

        // Custom range
        if ($label === 'custom' && $from && $to) {
            $start = CarbonImmutable::parse($from, $tz)->startOfDay();
            $end   = CarbonImmutable::parse($to,   $tz)->endOfDay();
            return [$start, $end, 'custom'];
        }

        // Default: this quarter
        $start = $now->startOfQuarter()->startOfDay();
        $end   = $now->endOfQuarter()->endOfDay();
        return [$start, $end, sprintf('%d-Q%d', $now->year, (int)ceil($now->month / 3))];
    }
}
