# Simple Calendar

[![Latest Stable Version](https://poser.pugx.org/donatj/simplecalendar/version)](https://packagist.org/packages/donatj/simplecalendar)
[![License](https://poser.pugx.org/donatj/simplecalendar/license)](https://packagist.org/packages/donatj/simplecalendar)
[![ci.yml](https://github.com/donatj/SimpleCalendar/actions/workflows/ci.yml/badge.svg)](https://github.com/donatj/SimpleCalendar/actions/workflows/ci.yml)


A very simple, easy to use PHP calendar rendering class.

## Requirements

- **php**: >=7.2 <= 8.5
- **ext-calendar**: *

## Installing

Install the latest version with:

```bash
composer require 'donatj/simplecalendar'
```


## Parameters / options

| Parameter     | Description                                          | Default                            | Valid values                                                                                                |
|---------------|------------------------------------------------------|------------------------------------|-------------------------------------------------------------------------------------------------------------|
| `calendarTimezone`<br>string    |  Sets the default timezone                          | `UTC`                             | The timezone identifier, like UTC, America/Vancouver, Asia/Hong_Kong, or Europe/Berlin etc. Look [List of Supported Timezones](https://www.php.net/manual/en/timezones.php).                                 |
| `calendarWeekStart`<br>int or string        | Sets the first day of the week                                        | `$offset`            | `Day the week starts on. ex: "Monday" or 0-6 where 0 is Sunday` |
| `calendarDate`<br>\DateTimeInterface false or string or null      | Sets the date for the calendar                                          | `null`             |  `$date` - DateTimeInterface for the calendar date. If null set to current timestamp.                                                                            |
| `calendarToday`<br>\DateTimeInterface or string or null           | Sets "today"'s date. Defaults to today. | `null`                                  |  `$today` - `null` will default to today, false will disable the rendering of Today.                                                                                                        |
| `calenderLang`<br>string | Sets the User Language for text strings                                    | `en` | `de`<br>To add another language, create a translation and name the file according to this template<br>calendar_`fr`.php<br>For example, for French.  Insert the language file into the `vendor/donatj/simplecalendar/src/ directory/language`.                                       |
| `shortWeekname`<br>bool     | Sets the display of weekday names in short or full form                                     | `true`          | `true` for short weekday names<br>`false` for long weekday names  
|   `calendar`<br>`leading_day`<br>`trailing_day`<br>`today`<br>`event`<br>`events`<br>array<string,string>      | Sets the class names used in the calendar                                     | `SimpleCalendar`<br>`SCprefix`<br>`SCsuffix`<br>`today`<br>`event`<br>`events`<br>Map of element to class names used by the calendar           | Take a look at the file `vendor/donatj/simplecalendar/src/css/SimpleCalendar.css` to see how the parameters are used.  
 

## Basic usage

##### Standard Settings:
- ***Timezone:*** UTC
- ***Weekstart:*** Sunday
- ***calendarDate:*** Current date
- ***User langage:*** en
- ***Display Weekname:*** short form
```php
<?php
require __DIR__ . '/vendor/autoload.php';

echo '<link rel="stylesheet" href="vendor/donatj/simplecalendar/src/css/SimpleCalendar.css" />';

$calendar = new donatj\SimpleCalendar();

echo $calendar->render();
```

## Examples


##### Standard Settings:
- ***calendarDate:*** Current date

##### Custom Settings:
- ***Timezone:*** Europe/Berlin
- ***Weekstart:*** Monday
- ***User langage:*** de
- ***Display Weekname:*** long form
```php
<?php

require __DIR__ . '/vendor/autoload.php';

echo '<link rel="stylesheet" href="vendor/donatj/simplecalendar/src/css/SimpleCalendar.css" />';

$calendar = new donatj\SimpleCalendar([
   'calendarTimezone'   => 'Europe/Berlin',
   'calendarWeekStart'  => 'Monday',
   'locacalenderLangle' => 'de',
   'shortWeekname'      => false,

]);

echo $calendar->render();

```

##### Standard Settings:
- ***Timezone:*** UTC
- ***User langage:*** en
- ***Display Weekname:*** short form

##### Custom Settings:
- ***calendarDate:*** June 2010
- ***Weekstart:*** Monday
- ***User langage:*** de
- ***Display Weekname:*** long form

##### Create Events

```php
<?php

require __DIR__ . '/vendor/autoload.php';

echo '<link rel="stylesheet" href="vendor/donatj/simplecalendar/src/css/SimpleCalendar.css" />';;

$calendar = new donatj\SimpleCalendar([
   'calendarDate' => 'June 2010',
   'calendarWeekStart' => 'Sunday'
]);

$calendar->addDailyHtml('Sample Event', 'today', 'tomorrow');

echo $calendar->render();

```

##### Daily event

```php
$calendar->addDailyHtml(string $html, $startDate [, $endDate = null]) : void
```

Add a daily event to the calendar

###### Parameters:

- ***string*** `$html` - The raw HTML to place on the calendar for this event
- ***\DateTimeInterface*** | ***int*** | ***string*** `$startDate` - Date string for when the event starts
- ***\DateTimeInterface*** | ***int*** | ***string*** | ***null*** `$endDate` - Date string for when the event ends. Defaults to start date

**Throws**: `\Exception`

---

##### Clear events

```php
$calendar->clearDailyHtml() : void
```

Clear all daily events for the calendar

---

#### Display Calendar

```php
$calendar->show([ bool $echo = true]) : string
```

Returns/Outputs the Calendar

##### DEPRECATED

Use `render()` method instead.

##### Parameters:

- ***bool*** `$echo` - Whether to echo resulting calendar

##### Returns:

- ***string*** - HTML of the Calendar

---

##### Method: SimpleCalendar->render

```php
$calendar->render() : string
```

Returns the generated Calendar