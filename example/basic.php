<?php

require __DIR__ . '/vendor/autoload.php';

echo '<link rel="stylesheet" href="vendor/donatj/simplecalendar/src/css/SimpleCalendar.css" />';

$calendar = new donatj\SimpleCalendar;

$calendar->setLanguages('de', false);
$calendar->setStartOfWeek('Monday');
$calendar->addDailyHtml('Sample Event', 'today', 'tomorrow');

echo $calendar->render();
