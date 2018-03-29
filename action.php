<?php
	$debug = false;
	include('CommonMethods.php');
	$COMMON = new Common($debug);
	
	$startDate = $_GET["startDate"];
	$endDate = $_GET["endDate"];
	$startTime = $_GET["startTime"];
	$endTime = $_GET["endTime"];
	
	if($_GET["singleDay"]) {
		$endDate = $startDate;	
	}
	echo("<h3> Traffic Analysis: </h3>");
	echoVisitsBetween($startDate,$endDate,$startTime,$endTime);
	echoHigh($startDate,$endDate,$startTime,$endTime);
	echoLow($startDate,$endDate,$startTime,$endTime);
	echoAvg($startDate,$endDate,$startTime,$endTime);
	
	if($_GET["histogram"]) {
		//display histogram
	}
		
	// Echoes the number of visitors entering rec between start and end datetimes
	// Precondition: all input parameters are valid dates/times
	// Postconditions: number of visitors echoed
	function echoVisitsBetween($startD,$endD,$startT,$endT) 
	{
		global $debug; global $COMMON;
		$sql = "SELECT COUNT(*) FROM `motion_data` WHERE `visit_time` BETWEEN '$startD " . $startT . "' AND '$endD " . $endT . "'";
		
		$rs = $COMMON->executeQuery($sql, $_SERVER["SCRIPT_NAME"] );
		$row = $rs->fetch(PDO::FETCH_NUM);
		if(!$row) {
			echo("No visits in selected timeframe");
		}

		echo("<h4> Visits between " . $startD . " at " . $startT . " and " . $endD . " at " . $endT . ": " . $row[0] . "</h4>");
	}
	
	// Finds traffic stats for time ranges between $startT and $endT on dates between $startD and $endD
	// Echoes number of visitors and time for least busy time range
	// Precondition: all input parameters are valid dates/times
	// Postconditions: traffic and time of low point echoed
	function echoLow($startD, $endD, $startT, $endT) 
	{
		global $debug; global $COMMON;
		
		$sql = "SELECT * FROM (SELECT COUNT(*) AS COUNT,CAST(visit_time AS DATE) AS date FROM `motion_data` WHERE (CAST(visit_time AS DATE) BETWEEN '$startD' AND '$endD') AND (CAST(visit_time AS TIME) BETWEEN '$startT' AND '$endT') GROUP BY CAST(visit_time AS DATE)) AS COUNTS ORDER BY COUNT ASC";
		$rs = $COMMON->executeQuery($sql, $_SERVER["SCRIPT_NAME"]);
		$row = $rs->fetch(PDO::FETCH_NUM);
		if(!$row) {
			echo("Insufficient traffic to analyze low point <br>");
			return;
		}
		
		echo("<h4> The low point of the time frame was: " . $row[0] . " visit(s) on " . $row[1] . "</h4>");	
	}
	
	// Finds traffic stats for time ranges between $startT and $endT on dates between $startD and $endD
	// Echoes number of visitors and time for most busy time range
	// Precondition: all input parameters are valid dates/times
	// Postconditions: traffic and time of high point echoed
	function echoHigh($startD,$endD,$startT,$endT) 
	{
		global $debug; global $COMMON;

		$sql = "SELECT * FROM (SELECT COUNT(*) AS COUNT,CAST(visit_time AS DATE) AS date FROM `motion_data` WHERE (CAST(visit_time AS DATE) BETWEEN '$startD' AND '$endD') AND (CAST(visit_time AS TIME) BETWEEN '$startT' AND '$endT') GROUP BY CAST(visit_time AS DATE)) AS COUNTS ORDER BY COUNT DESC";
		$rs = $COMMON->executeQuery($sql, $_SERVER["SCRIPT_NAME"] );
		$row = $rs->fetch(PDO::FETCH_NUM);
		if(!$row) {
			echo("Insufficient traffic to analyze high point <br>");
			return;
		}

		echo("<h4> The high point of the time frame was: " . $row[0] . " visit(s) on " . $row[1] . "</h4>");
	}
	
	// Finds traffic stats for time ranges between $startT and $endT on dates between $startD and $endD
	// Echoes average number of visitors for given time range
	// Precondition: all input parameters are valid dates/times
	// Postconditions: average traffic echoed
	function echoAvg($startD,$endD,$startT,$endT) 
	{
		global $debug; global $COMMON;
		
		$sql = "SELECT AVG(COUNT) FROM ( SELECT COUNT(*) AS COUNT FROM `motion_data` WHERE (CAST(visit_time AS DATE) BETWEEN '$startD' AND '$endD') AND (CAST(visit_time AS TIME) BETWEEN '$startT' AND '$endT') GROUP BY CAST(visit_time AS DATE) ) AS COUNTS";
		$rs = $COMMON->executeQuery($sql, $_SERVER["SCRIPT_NAME"] );
		$row = $rs->fetch(PDO::FETCH_NUM);
		if(!$row) {
			echo("Insufficient traffic to analyze average <br>");
			return;
		}

		echo("<h4> Average traffic during the time frame was: " . $row[0] . " visit(s) </h4>");
	}
	
	//Needs implementation. Suggested on piazza to look into google charts.
	function visualRepresentation() 
	{

	}	
?>