<?php

namespace View;

class DateTimeView {

	public function showDateTime() : string {
		date_default_timezone_set('Europe/Stockholm');

		$dayString = date('l');
		$monthAndYearString = date('jS \of F Y');
		$clockString = date('h:i:s');

		$timeString = $dayString . ', the '. $monthAndYearString . ', The time is ' . $clockString;

		return '<p>' . $timeString . '</p>';
	}
}