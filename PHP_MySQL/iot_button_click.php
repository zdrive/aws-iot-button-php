<?php

// If your clicks are not in synch with the current time zone, then uncomment one of the following  

// date_default_timezone_set("America/New_York"); // Eastern Time
// date_default_timezone_set("America/Chicago"); // Central Time
// date_default_timezone_set("America/Denver"); // Mountain Time
// date_default_timezone_set("America/Phoenix"); // Mountain Time (no DST) 
date_default_timezone_set("America/Los_Angeles"); // Pacific Time
// date_default_timezone_set("America/Anchorage"); // Alaska Time 
// date_default_timezone_set("America/Adak"); // Hawaii-Aleutian 
// date_default_timezone_set("Pacific/Honolulu"); // Hawaii-Aleutian Time (no DST) 

// For other time zones see: http://php.net/manual/en/timezones.php (for a better list, use your favorite search engine)

	$num_set = 0;

	if (isset($_POST['clickType'])){
		$clickType = filter_var(strip_tags(substr($_POST['clickType'], 0, 6)), FILTER_SANITIZE_STRING);
		$num_set++;
	}

	if (isset($_POST['serialNumber'])){
		$serialNumber = filter_var(strip_tags(substr($_POST['serialNumber'], 0, 16)), FILTER_SANITIZE_STRING);
		$num_set++;
	}

	if (isset($_POST['batteryVoltage'])){
		$batteryVoltage = filter_var(strip_tags(substr($_POST['batteryVoltage'], 0, 6)), FILTER_SANITIZE_STRING);
		$num_set++;
	}


	if ($num_set == 3) {
		require_once ('db.php'); 
		$dbMain = new db();
	    $dbMain->button_tracker($clickType, $serialNumber, $batteryVoltage);
	}

?>