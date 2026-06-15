<?php
/**
 * Simple Calendar
 *
 * @author Jesse G. Donat <donatj@gmail.com>
 * @see https://donatstudios.com
 * @license http://opensource.org/licenses/mit-license.php
 * 
 * Based of phpBB.
 * Nederlandse vertaling door Raimon.nl
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
	'datetime'			=> array(
		'Sunday'	=> 'zondag',
		'Monday'	=> 'maandag',
		'Tuesday'	=> 'dinsdag',
		'Wednesday'	=> 'woensdag',
		'Thursday'	=> 'donderdag',
		'Friday'	=> 'vrijdag',
		'Saturday'	=> 'zaterdag',

		'Sun'		=> 'zo',
		'Mon'		=> 'ma',
		'Tue'		=> 'di',
		'Wed'		=> 'wo',
		'Thu'		=> 'do',
		'Fri'		=> 'vr',
		'Sat'		=> 'za',

		'January'	=> 'januari',
		'February'	=> 'februari',
		'March'		=> 'maart',
		'April'		=> 'april',
		'May'		=> 'mei',
		'June'		=> 'juni',
		'July'		=> 'juli',
		'August'	=> 'augustus',
		'September' => 'september',
		'October'	=> 'oktober',
		'November'	=> 'november',
		'December'	=> 'december',

		'Jan'		=> 'jan',
		'Feb'		=> 'feb',
		'Mar'		=> 'mar',
		'Apr'		=> 'apr',
		'May_short'	=> 'mei',	// Short representation of "May". May_short used because in English the short and long date are the same for May.
		'Jun'		=> 'jun',
		'Jul'		=> 'jul',
		'Aug'		=> 'aug',
		'Sep'		=> 'sep',
		'Oct'		=> 'okt',
		'Nov'		=> 'nov',
		'Dec'		=> 'dec',
	),
));
