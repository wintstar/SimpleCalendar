<?php
/**
 * Simple Calendar
 *
 * @author Jesse G. Donat <donatj@gmail.com>
 * @see https://donatstudios.com
 * @license http://opensource.org/licenses/mit-license.php
 * 
 * Based of phpBB.
 * Übersetzung durch die Übersetzer-Gruppe von phpBB.de.
 */

if (empty($lang) || !is_array($lang))
{
	$lang = array();
}

// DEVELOPERS PLEASE NOTE
//
// All language files should use UTF-8 as their encoding and the files must not contain a BOM.
//
// Placeholders can now contain order information, e.g. instead of
// 'Page %s of %s' you can (and should) write 'Page %1$s of %2$s', this allows
// translators to re-order the output of data while ensuring it remains correct
//
// You do not need this where single placeholders are used, e.g. 'Message %d' is fine
// equally where a string contains only two placeholders which are used to wrap text
// in a url you again do not need to specify an order e.g., 'Click %sHERE%s' is fine
//
// Some characters you may want to copy&paste:
// ’ » “ ” …
//

$lang = array_merge($lang, array(
	'datetime'			=> array(
		'Sunday'	=> 'Sonntag',
		'Monday'	=> 'Montag',
		'Tuesday'	=> 'Dienstag',
		'Wednesday'	=> 'Mittwoch',
		'Thursday'	=> 'Donnerstag',
		'Friday'	=> 'Freitag',
		'Saturday'	=> 'Samstag',

		'Sun'		=> 'So',
		'Mon'		=> 'Mo',
		'Tue'		=> 'Di',
		'Wed'		=> 'Mi',
		'Thu'		=> 'Do',
		'Fri'		=> 'Fr',
		'Sat'		=> 'Sa',

		'January'	=> 'Januar',
		'February'	=> 'Februar',
		'March'		=> 'März',
		'April'		=> 'April',
		'May'		=> 'Mai',
		'June'		=> 'Juni',
		'July'		=> 'Juli',
		'August'	=> 'August',
		'September' => 'September',
		'October'	=> 'Oktober',
		'November'	=> 'November',
		'December'	=> 'Dezember',

		'Jan'		=> 'Jan',
		'Feb'		=> 'Feb',
		'Mar'		=> 'Mär',
		'Apr'		=> 'Apr',
		'May_short'	=> 'Mai',	// Short representation of "May". May_short used because in English the short and long date are the same for May.
		'Jun'		=> 'Jun',
		'Jul'		=> 'Jul',
		'Aug'		=> 'Aug',
		'Sep'		=> 'Sep',
		'Oct'		=> 'Okt',
		'Nov'		=> 'Nov',
		'Dec'		=> 'Dez',
	),
));
