<?php

namespace donatj;

use DateTimeImmutable;

/**
 * Simple Calendar
 *
 * @author Jesse G. Donat <donatj@gmail.com>
 * @see https://donatstudios.com
 * @license http://opensource.org/licenses/mit-license.php
 */
class SimpleCalendar {

	/**
	 * Array of options
	 *
	 * @var array
	 */
	public $options;

	/**
	 * Array of Week Day Names
	 *
	 * @var string[]|null
	 */
	private $weekDayNames;

	/**
	 * Array of Month Day Names
	 *
	 * @var string[]|null
	 */
	private $monthDayNames;

	/**
	 * Array of languages string
	 *
	 * @var array
	 */
	public $lang;

	/** @var array<int, array<int, array<int, array<int, string>>>> */
	private $dailyHtml = [];

	/** @var int */
	private $offset = 0;

	/**
	 * @param \DateTimeInterface|int|string|null       $calendarDate
	 * @param \DateTimeInterface|false|int|string|null $today
	 *
	 * @see setDate
	 * @see setToday
	 */
	public function __construct( array $options = [] ) {
		$this->setOptions($options);

		$this->setStartOfWeek($this->options['calendarWeekStart']);
	}

	/**
	 * @param \DateTimeInterface|int|string|null $date
	 * @throws \Exception
	 */
	private function parseDate( $date = null ) : ?\DateTimeInterface {
		if( $date instanceof \DateTimeInterface ) {
			return $date;
		}

		if( is_int($date) ) {
			return (new \DateTimeImmutable)->setTimestamp($date);
		}

		if( is_string($date) ) {
			return new \DateTimeImmutable($date);
		}

		return null;
	}

	/**
	 * Sets "today"'s date. Defaults to today.
	 *
	 * @param \DateTimeInterface|false|int|string|null $today `null` will default to today, `false` will disable the
	 *                                                        rendering of Today.
	 * @throws \Exception
	 */
	public function setToday( $today = null ) : null|object {
		if( $today === false ) {
			return null;
		} elseif( $today === null ) {
			return new \DateTimeImmutable;
		} else {
			return $this->parseDate($today);
		}
	}

	/**
	 * @param string[]|null $weekDayNames
	 */
	public function setWeekDayNames() : void {
		if ($this->options['shortWeekname'] == true)
		{
			$weekDayNames = array(
				$this->lang['datetime']['Sun'], 
				$this->lang['datetime']['Mon'], 
				$this->lang['datetime']['Tue'], 
				$this->lang['datetime']['Wed'], 
				$this->lang['datetime']['Thu'],
				$this->lang['datetime']['Fri'], 
				$this->lang['datetime']['Sat']
			);
		} else {
			$weekDayNames = array(
				$this->lang['datetime']['Sunday'], 
				$this->lang['datetime']['Monday'], 
				$this->lang['datetime']['Tuesday'], 
				$this->lang['datetime']['Wednesday'], 
				$this->lang['datetime']['Thursday'],
				$this->lang['datetime']['Friday'], 
				$this->lang['datetime']['Saturday']
			);
		}

		$this->weekDayNames = $weekDayNames;
	}

	/**
	 * @param string[]|null $monthDayNames
	 */
	public function setMonthDayNames(): void
	{
		$monthDayNames = array(
			1 => $this->lang['datetime']['January'],
			2 => $this->lang['datetime']['February'],
			3 => $this->lang['datetime']['March'],
			4 => $this->lang['datetime']['April'],
			5 => $this->lang['datetime']['May'], 
			6 => $this->lang['datetime']['June'],
			7 => $this->lang['datetime']['July'],
			8 => $this->lang['datetime']['August'],
			9 => $this->lang['datetime']['September'],
			10 => $this->lang['datetime']['October'],
			11 => $this->lang['datetime']['November'],
			12 => $this->lang['datetime']['December']
		);

		$this->monthDayNames = $monthDayNames;
	}

	/**
	 * Add a daily event to the calendar
	 *
	 * @param string                             $html      The raw HTML to place on the calendar for this event
	 * @param \DateTimeInterface|int|string      $startDate Date string for when the event starts
	 * @param \DateTimeInterface|int|string|null $endDate   Date string for when the event ends. Defaults to start date
	 * @throws \Exception
	 */
	public function addDailyHtml( string $html, $startDate, $endDate = null ) : void {
		/** @var int $htmlCount */
		static $htmlCount = 0;

		$start = $this->parseDate($startDate);
		if( !$start ) {
			throw new \InvalidArgumentException('invalid start time');
		}

		$end = $start;
		if( $endDate ) {
			$end = $this->parseDate($endDate);
		}

		if( !$end ) {
			throw new \InvalidArgumentException('invalid end time');
		}

		if( $end->getTimestamp() < $start->getTimestamp() ) {
			throw new \InvalidArgumentException('end must come after start');
		}

		$working = (new \DateTimeImmutable)->setTimestamp($start->getTimestamp());

		do {
			$tDate = getdate($working->getTimestamp());

			$this->dailyHtml[$tDate['year']][$tDate['mon']][$tDate['mday']][$htmlCount] = $html;

			$working = $working->add(new \DateInterval('P1D'));
		} while( $working->getTimestamp() < $end->getTimestamp() + 1 );

		$htmlCount++;
	}

	/**
	 * Clear all daily events for the calendar
	 */
	public function clearDailyHtml() : void {
		$this->dailyHtml = [];
	}

	/**
	 * Sets the first day of the week
	 *
	 * @param int|string $offset Day the week starts on. ex: "Monday" or 0-6 where 0 is Sunday
	 */
	public function setStartOfWeek( $offset ) : void {
		if( is_int($offset) ) {
			$this->offset = $offset % 7;
		} elseif( $this->weekDayNames !== null && ($weekOffset = array_search($offset, $this->weekDayNames, true)) !== false ) {
			assert(is_int($weekOffset));
			$this->offset = $weekOffset;
		} else {
			$weekTime = strtotime($offset);
			if( $weekTime === 0 || $weekTime === false ) {
				throw new \InvalidArgumentException('invalid offset');
			}

			$date = date('N', $weekTime);
			assert($date !== false);

			$this->offset = intval($date) % 7;
		}
	}

	/**
	 * Returns the generated Calendar
	 */
	public function render() : string {
		// translated week names
		$this->setWeekDayNames();
		// translated month names
		$this->setMonthDayNames();

		$now   = getdate($this->options['now']->getTimestamp());
		$today = [ 'mday' => -1, 'mon' => -1, 'year' => -1 ];
		if( $this->options['today'] !== null ) {
			$today = getdate($this->options['today']->getTimestamp());
		}

		$daysOfWeek = $this->weekdays();
		$this->rotate($daysOfWeek, $this->offset);

		$time = mktime(0, 0, 1, $now['mon'], 1, $now['year']);
		assert($time !== false);

		$weekDayIndex = date('N', $time) - $this->offset;
		$daysInMonth  = cal_days_in_month(CAL_GREGORIAN, $now['mon'], $now['year']);

		// Display over the calendar the current or custom date / year 
		$caption = $this->monthDayNames[$this->options['now']->format('n')] . ' ' . $this->options['now']->format('Y');

		$out = <<<TAG
<table cellpadding="0" cellspacing="0" class="{$this->options['classes']['calendar']}"><caption>{$caption}</caption><thead><tr>
TAG;

		foreach( $daysOfWeek as $dayName ) {
			$out .= "<th>{$dayName}</th>";
		}

		$out .= <<<'TAG'
</tr></thead>
<tbody>
<tr>
TAG;

		$weekDayIndex = ($weekDayIndex + 7) % 7;

		// Show previous calendar days
		$out .= $this->leading_days($this->options['now']);

		$count = $weekDayIndex + 1;
		for( $i = 1; $i <= $daysInMonth; $i++ ) {
			$date = (new \DateTimeImmutable)->setDate($now['year'], $now['mon'], $i);

			// Display weeknumber
			$weeknumber = ($this->options['displayWeeknumber']) ? (($date->format('N') == 1) ? 
				sprintf('<span class="week">W%s</span>', $date->format('W')) : '') : '';

			$isToday = false;
			if( $this->options['today'] !== null ) {
				$isToday = $i == $today['mday']
					&& $today['mon'] == $date->format('n')
					&& $today['year'] == $date->format('Y');
			}

			$out .= '<td' . ($isToday ? ' class="' . $this->options['classes']['today'] . '"' : '') . '>';

			$out .= sprintf('<time datetime="%s"><span class="date">%d</span>%s</time>', $date->format('Y-m-d'), $i, $weeknumber);
			$out .= '<div class="clear"></div>';

			$dailyHTML = null;
			if( isset($this->dailyHtml[$now['year']][$now['mon']][$i]) ) {
				$dailyHTML = $this->dailyHtml[$now['year']][$now['mon']][$i];
			}

			if( is_array($dailyHTML) ) {
				$out .= '<div class="' . $this->options['classes']['events'] . '">';
				foreach( $dailyHTML as $dHtml ) {
					$out .= sprintf('<div class="%s">%s</div>', $this->options['classes']['event'], $dHtml);
				}

				$out .= '</div>';
			}

			$out .= '</td>';

			if( $count > 6 ) {
				$out   .= "</tr>\n" . ($i < $daysInMonth ? '<tr>' : '');
				$count = 0;
			}

			$count++;
		}

		if ($count !== 1)
		{
			$out .= $this->trailing_days($this->options['now']) . '</tr>';
		}

		$out .= "\n</tbody></table>\n";

		return $out;
	}

	/**
	 * @param array<int, mixed> $data
	 */
	private function rotate( array &$data, int $steps ) : void {
		$count = count($data);
		if( $steps < 0 ) {
			$steps = $count + $steps;
		}

		$steps %= $count;
		for( $i = 0; $i < $steps; $i++ ) {
			$data[] = array_shift($data);
		}
	}

	/**
	 * @return string[]
	 */
	private function weekdays() : array {
		if( $this->weekDayNames !== null ) {
			return $this->weekDayNames;
		}

		$today = (86400 * (date('N')));
		$wDays = [];
		for( $n = 0; $n < 7; $n++ ) {
			$wDays[] = date('D', time() - $today + ($n * 86400));
		}

		return $wDays;
	}

	/**
	 * Show previous calendar days
	 * 
	 * @param object $date
	 */
	private function leading_days($now)
	{
		$out = '';

		// First day of the month.
		$first_date = $now->modify('first day of this month')->format('d.m.Y');

		$date = new DateTimeImmutable($first_date);

		$is_day = $date->format('N');
		$lis_day = $date->format('l');

		$firstDays = ($is_day - 1);

		if ($is_day !=1)
		{
			$sub_day 	= 'P' . $firstDays . 'D';
			$newDate 	= $date->sub(new \DateInterval($sub_day));
			$lnow		= getdate($newDate->getTimestamp());

			for ($i = 0; $i < $firstDays; $i++) {
				$leading_date = (new DateTimeImmutable())->setDate($lnow['year'], $lnow['mon'], $lnow['mday'] + $i);

				// Display weeknumber
				$weeknumber = ($this->options['displayWeeknumber']) ? (($leading_date->format('N') == 1) ? 
					sprintf('<span class="week">W%s</span>', $leading_date->format('W')) : '') : '';

				$out .= '<td class="' . $this->options['classes']['leading_day'] . '">';

				$out .= sprintf('<time datetime="%s"><span class="date">%d</span>%s</time>', $leading_date->format('Y-m-d'), ($lnow['mday'] + $i), $weeknumber);
				$out .= '<div class="clear"></div>';

				$dailyHTML = null;
				if (isset($this->dailyHtml[$lnow['year']][$lnow['mon']][$leading_date->format('j')]))
				{
					$dailyHTML = $this->dailyHtml[$lnow['year']][$lnow['mon']][$leading_date->format('j')];
				}

				if (is_array($dailyHTML))
				{
					$out .= '<div class="' . $this->options['classes']['events'] . '">';
					foreach ($dailyHTML as $dHtml)
					{
						$out .= sprintf('<div class="%s">%s</div>', $this->options['classes']['out_event'], $dHtml);
					}

					$out .= '</div>';
				}

				$out .= '</td>';
			}
		}

		return $out;
	}

	/**
	 * Show upcoming days
	 * 
	 * @param object $date
	 */
	public function trailing_days($now)
	{
		$out = '';

		// Last day of the month.
		$last_date = $now->modify('last day of this month')->format('t.m.Y');

		$date	= new DateTimeImmutable($last_date);

		$is_day = $date->format('N');

		$lastDays = intval(7 - $is_day);

		if ($is_day !=7)
		{
			$add_day = 'P' . (7 - $is_day) . 'D';
			$newDate = $date->add(new \DateInterval($add_day));
			$lnow = getdate($newDate->getTimestamp());

			for ($i = 0; $i < $lastDays; $i++)					
			{
				$trailing_date = (new DateTimeImmutable)->setDate($lnow['year'], $lnow['mon'], 1 + $i);

				// Display weeknumber
				$weeknumber = ($this->options['displayWeeknumber']) ? (($trailing_date->format('N') == 1) ? 
					sprintf('<span class="week">W%s</span>', $trailing_date->format('W')) : '') : '';

				$out .= '<td class="' . $this->options['classes']['trailing_day'] . '">';

				$out .= sprintf('<time datetime="%s"><span class="date">%d</span>%s</time>', $trailing_date->format('Y-m-d'), $i + 1, $weeknumber);
				$out .= '<div class="clear"></div>';	

				$dailyHTML = null;
				if (isset($this->dailyHtml[$lnow['year']][$lnow['mon']][$trailing_date->format('j')]))
				{
					$dailyHTML = $this->dailyHtml[$lnow['year']][$lnow['mon']][$trailing_date->format('j')];
				}

				if (is_array($dailyHTML))
				{
					$out .= '<div class="' . $this->options['classes']['events'] . '">';
					foreach ($dailyHTML as $dHtml)
					{
						$out .= sprintf('<div class="%s">%s</div>', $this->options['classes']['out_event'], $dHtml);
					}

					$out .= '</div>';
				}

				$out .= '</td>';
			}
		}

		return $out;
	}

	/**
	 * Translate text to user lang
	 * 
	 * @param string $local Language code
	 * @return array
	 */
	private function setLanguages($locale): void
	{
		$lang = array();
		$lang_path = __DIR__ . DIRECTORY_SEPARATOR . 'language' . DIRECTORY_SEPARATOR;
		$ang_name = file_exists($lang_path . 'calendar_' . $this->options['locale'] . '.php') ? $this->options['locale'] : 'en';

		$include_result = include $lang_path . 'calendar_' . $ang_name . '.php';

		if ($include_result === false)
		{
			throw new \InvalidArgumentException('Language file ' . $lang_file . 'couldn\'t be opened.');
		}

		$this->lang = $lang;
	}

    public function getOptions(): array
    {
        return $this->options;
    }

    /**
     * Required for backward compatibility.
     *
     * @deprecated
     */
    public function getArgs(): array
    {
        return $this->getOptions();
    }

    public function setOptions($options = array()): void
    {
        $defaultOptions = [
			'calendarTimezone'  => 'UTC',
			'calendarWeekStart' => 0,
            'calendarDate' 		=> null,
            'calendarToday' 	=> null,
			'calenderLang' 		=> 'en',
            'shortWeekname' 	=> true,
			'displayWeeknumber'	=> false,
			'cssClass'          => array(
				'calendar'    	    => 'SimpleCalendar',
				'leading_day'  	    => 'SCprefix',
				'out_event'			=> 'out_event',
				'trailing_day' 	    => 'SCsuffix',
				'today'        	    => 'today',
				'event'        	    => 'event',
				'events'       	    => 'events',
			)
        ];

        $options = array_replace($defaultOptions, $options);

        $this->options = $this->sanitizeOptions($options);
    }

    /**
     * Performs sanity checks.
     *
     * @param array $options Arguments
     *
     * @return array Sanitized arguments
     */
    protected function sanitizeOptions(array $options): array
    {
		date_default_timezone_set($options['calendarTimezone']);

		$options['now'] = $this->parseDate($options['calendarDate']) ?: new \DateTimeImmutable;
		$options['today'] = $this->setToday($options['calendarToday']);

		foreach( $options['cssClass'] as $key => $value ) {
			if( !isset($options['cssClass'][$key]) ) {
				throw new \InvalidArgumentException("class '{$key}' not supported");
			}

			$options['classes'][$key] = $value;
		}

		$lang = array();
		$lang_path = __DIR__ . DIRECTORY_SEPARATOR . 'language' . DIRECTORY_SEPARATOR;
		$ang_name = file_exists($lang_path . 'calendar_' . $options['calenderLang'] . '.php') ? $options['calenderLang'] : 'en';
 
		$include_result = include $lang_path . 'calendar_' . $ang_name . '.php';

		if ($include_result === false)
		{
			throw new \InvalidArgumentException('Language file ' . $lang_file . 'couldn\'t be opened.');
		}

		$this->lang = $lang;

        return $options;
    }
}
