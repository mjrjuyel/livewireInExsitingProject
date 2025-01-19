<?php

use Carbon\Carbon;

if (! function_exists('formatDate')) {
    /**
     * Format a given date.
     *
     * @param string $date
     * @return string
     */
    function formatDate($date)
    {
        return Carbon::createFromFormat('Y-m-d H:i:s', $date, 'UTC')
                     ->timezone(config('app.timezone'))
                     ->format('d-M-Y | h:i:s A');
    }
}