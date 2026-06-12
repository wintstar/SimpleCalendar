<?php

require __DIR__ . '/vendor/autoload.php';

echo '<link rel="stylesheet" href="vendor/donatj/simplecalendar/src/css/SimpleCalendar.css" />';

$calendar = new donatj\SimpleCalendar('June 2010');

$calendar->setLanguages('de');
echo $calendar->render();
