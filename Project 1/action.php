
<?php

	$debug = false;
	include('CommonMethods.php');
	$COMMON = new Common($debug);
	
	
	$startDate = $_GET["startDate"];
	$endDate = $_GET["endDate"];
	$startTime = $_GET["startTime"];
	$endTime = $_GET["endTime"];

		
	if($_GET["highOfWeek"]) 
	{
		getHigh($startDate,$endDate,$startTime,$endTime);
	}
	else if($_GET["lowOfWeek"]) 
	{
		getLow($startDate,$endDate,$startTime,$endTime);
	}
	else if($_GET["avgTF"]) 
	{
		getAvg($startDate,$endDate,$startTime,$endTime);
	}
	else if($_GET["visualRep"]) 
	{
		
	}
	else if($_GET["numInTF"]) 
	{
		getNumUserBetween($startDate,$endDate,$startTime,$endTime);
	}
	else 
	{
		echo("Error: Unknown Option Selected");
	}
	
	
	//Helper function used to convert string arguments to SQL date format
	function formatDate($date,$time) 
	{
		$timestamp = strtotime($date . " " . $time);
		$datetime = date("Y-m-d H:i", $timestamp);
		
		return $datetime;
	}
	
	
	
	// Finished
	function getNumUserBetween($startD,$endD,$startT,$endT) 
	{
		global $debug; global $COMMON;
		
		$beginning = formatDate($startD,$startT);
		$end = formatDate($endD, $endT);
		$sql = "SELECT COUNT(*) FROM `motion_data` WHERE `visit_time` BETWEEN '$beginning' AND '$end'";
		
		$rs = $COMMON->executeQuery($sql, $_SERVER["SCRIPT_NAME"] );
		$row = $rs->fetch(PDO::FETCH_NUM);

		echo("<h3> Number of students between " . $startD . " at " . $startT . " and " . $endD . " at " . $endT . ": " . $row[0] . "</h3>");

	}
	
	// Finished
	function getLow($startD, $endD, $startT, $endT) 
	{
		global $debug; global $COMMON;
		
		$sql = "SELECT MIN(COUNT)FROM ( SELECT COUNT(*) AS COUNT FROM `motion_data` WHERE (CAST(visit_time AS DATE) BETWEEN '$startD' AND '$endD') AND (CAST(visit_time AS TIME) BETWEEN '$startT' AND '$endT') GROUP BY CAST(visit_time AS DATE) ) AS COUNTS";
		$rs = $COMMON->executeQuery($sql, $_SERVER["SCRIPT_NAME"]);
		$row = $rs->fetch(PDO::FETCH_NUM);
		
		echo("<h3> The low point of the time frame was: " . $row[0] . " visit(s). </h3>");
		
	}
	
	
	// Finished
	function getHigh($startD,$endD,$startT,$endT) 
	{
		global $debug; global $COMMON;

		$sql = "SELECT MAX(COUNT)FROM ( SELECT COUNT(*) AS COUNT FROM `motion_data` WHERE (CAST(visit_time AS DATE) BETWEEN '$startD' AND '$endD') AND (CAST(visit_time AS TIME) BETWEEN '$startT' AND '$endT') GROUP BY CAST(visit_time AS DATE) ) AS COUNTS";
		$rs = $COMMON->executeQuery($sql, $_SERVER["SCRIPT_NAME"] );
		$row = $rs->fetch(PDO::FETCH_NUM);

		echo("<h3> The high point of the time frame was: " . $row[0] . " visit(s). </h3>");
		
	}
	
	
	// Finished
	function getAvg($startD,$endD,$startT,$endT) 
	{
		global $debug; global $COMMON;
		
		$beginning = formatDate($startD,$startT);
		$end = formatDate($endD, $endT);

		$sql = "SELECT AVG(COUNT)FROM ( SELECT COUNT(*) AS COUNT FROM `motion_data` WHERE (CAST(visit_time AS DATE) BETWEEN '$startD' AND '$endD') AND (CAST(visit_time AS TIME) BETWEEN '$startT' AND '$endT') GROUP BY CAST(visit_time AS DATE) ) AS COUNTS";
		$rs = $COMMON->executeQuery($sql, $_SERVER["SCRIPT_NAME"] );
		$row = $rs->fetch(PDO::FETCH_NUM);

		echo("<h3> Average number of students between " . $startD . "-" . $endD . " during " . $startT . "-" . $endT . ": " . $row[0] . "</h3>");
	}
	
	
	//Needs implementation. Suggested on piazza to look into google charts.
	function visualRepresentation() 
	{

	}
	
?>



