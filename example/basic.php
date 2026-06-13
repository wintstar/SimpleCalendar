<?php

require __DIR__ . '/vendor/autoload.php';

echo '<link rel="stylesheet" href="vendor/donatj/simplecalendar/src/css/SimpleCalendar.css" />';

$calendar = new donatj\SimpleCalendar([
    'calendarWeekStart' => 'Monday',
    'calenderLang'      => 'de',
    'shortWeekname'     => false
]);

$calendar->addDailyHtml('Sample Event', 'today', 'tomorrow');

echo $calendar->render();
