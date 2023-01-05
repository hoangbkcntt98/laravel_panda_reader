<?php

use Carbon\Carbon;

if (!function_exists('formatDate')) {
    function formatDate($date, string $format = 'Y/m/d')
    {
        if ($date instanceof \Carbon\Carbon) {
            return $date->format($format);
        }
        return $date;
    }
}

if(!function_exists('getNotificationTime')){
    function getNotificationTime($datetime)
    {
        $time = Carbon::parse($datetime);
        $now = Carbon::now();
        $diffInDay = $time->diffInDays($now, true);
        $diffInHour = $time->diffInHours($now, true);
        $diffInMinutes = $time->diffInMinutes($now, true);
        $diffInSeconds = $time->diffInSeconds($now, true);
        if($diffInDay > 0 ) return $diffInDay. ' days ago';
        if($diffInHour > 0 ) return $diffInHour. ' hours ago';
        if($diffInMinutes > 0 ) return $diffInMinutes. ' mins ago';
        return $diffInSeconds. ' seconds ago';
    }
}