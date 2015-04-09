<?php
/*                                    class.datetime.php
.------------------------------------------------------.
|  Software: Kaiten - Date and Time Class              |
|   Version: 3.0                                       |
|  Git Repo: https://bitbucket.org/integrian/chakra-3  |
|      Info: http://cms.chakra.hu                      |
|   Support: cms@chakra.hu                             |
'------------------------------------------------------'
                             © 2014 integrian industries
*/
class DateAndTime {
    
	// Date format default: YYYY-MM-DD HH:II:SS
    
	function getDate ($date_time) {
		$dt = explode(" ", $date_time);
		return $dt[0];
	}
	
	function getTime ($date_time) {
		$dt = explode(" ", $date_time);
		return $dt[1];
	}
	
	function getYear ($date_time) {
		$dt = explode(" ", $date_time);
		$d = explode("-", $dt[0]);
		return $d[0];
	}
	
	function getMonth ($date_time) {
		$dt = explode(" ", $date_time);
		$d = explode("-", $dt[0]);
		return $d[1];
	}
	
	function getDay ($date_time) {
		$dt = explode(" ", $date_time);
		$d = explode("-", $dt[0]);
		return $d[2];
	}
	
	function getHours ($date_time) {
		$dt = explode(" ", $date_time);
		$t = explode(":", $dt[1]);
		return $t[0];
	}
	
	function getMinutes ($date_time) {
		$dt = explode(" ", $date_time);
		$t = explode(":", $dt[1]);
		return $t[1];
	}
	
	function getSeconds ($date_time) {
		$dt = explode(" ", $date_time);
		$t = explode(":", $dt[1]);
		return $t[2];
	}

	function getShortDatetime ($date_time) {
		$dt = explode(" ", $date_time);
		$d = explode("-", $dt[0]);
		$t = explode(":", $dt[1]);
		if (date('Y')!=$d[0]) { return $d[0].'.'.$d[1].'.'.$d[2].'. '.$t[0].':'.$t[1]; }
		else { return $d[1].'.'.$d[2].'. '.$t[0].':'.$t[1]; }
	}
	
	function getExpirationDate ($date_time, $days) {
		$dt = explode(" ", $date_time);
		$d = explode("-", $dt[0]);
		$date = new DateTime ($d[0].'-'.$d[1].'-'.$d[2]);
		$date->modify('+'.$days.' days');
		return $date->format("Y.m.d.");
	}
}