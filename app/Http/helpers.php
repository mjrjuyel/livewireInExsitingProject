<?php

use Carbon\Carbon;
use App\Models\Currency;

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

if (! function_exists('displayTime')) {

    function displayTime(?string $time): ?string
    {
        if (!$time) return null;
        $format = strpos($time, ':') !== false && strpos($time, ':', strpos($time, ':') + 1) !== false
              ? 'H:i:s'
              : 'H:i';
        
        return Carbon::createFromFormat($format, $time, 'UTC')
        ->setTimezone(config('app.timezone'))
        ->format('h:i A');

    }
}


if ( ! function_exists('currencyCahnge')) {

    function currencyChange()
    {
        $currency = Currency::first();
        return $currency->currency_icon;
    }
}

if ( ! function_exists('convertTime')) {

    function convertTime($time)
    {
        $hours = floor($time/60);
        $minutes = $time%60;
        $totalTime =  $hours ." h " . $minutes ." mins";
        return $totalTime;
    }
}