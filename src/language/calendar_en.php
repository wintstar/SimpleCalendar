<?php
/**
 * Simple Calendar
 *
 * @author Jesse G. Donat <donatj@gmail.com>
 * @see https://donatstudios.com
 * @license http://opensource.org/licenses/mit-license.php
 * 
 * Based of phpBB.
 * 
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
	'TRANSLATION_INFO'	=> '',

	'datetime'			=> array(
		'Sunday'	=> 'Sunday',
		'Monday'	=> 'Monday',
		'Tuesday'	=> 'Tuesday',
		'Wednesday'	=> 'Wednesday',
		'Thursday'	=> 'Thursday',
		'Friday'	=> 'Friday',
		'Saturday'	=> 'Saturday',

		'Sun'		=> 'Sun',
		'Mon'		=> 'Mon',
		'Tue'		=> 'Tue',
		'Wed'		=> 'Wed',
		'Thu'		=> 'Thu',
		'Fri'		=> 'Fri',
		'Sat'		=> 'Sat',

		'January'	=> 'January',
		'February'	=> 'February',
		'March'		=> 'March',
		'April'		=> 'April',
		'May'		=> 'May',
		'June'		=> 'June',
		'July'		=> 'July',
		'August'	=> 'August',
		'September' => 'September',
		'October'	=> 'October',
		'November'	=> 'November',
		'December'	=> 'December',

		'Jan'		=> 'Jan',
		'Feb'		=> 'Feb',
		'Mar'		=> 'Mar',
		'Apr'		=> 'Apr',
		'May_short'	=> 'May',	// Short representation of "May". May_short used because in English the short and long date are the same for May.
		'Jun'		=> 'Jun',
		'Jul'		=> 'Jul',
		'Aug'		=> 'Aug',
		'Sep'		=> 'Sep',
		'Oct'		=> 'Oct',
		'Nov'		=> 'Nov',
		'Dec'		=> 'Dec',
	),
));
