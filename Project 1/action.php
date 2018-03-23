
<?php

	$debug = false;
	include('CommonMethods.php');
	$COMMON = new Common($debug);
	
	
	$startDate = $_GET["startDate"];
	$endDate = $_GET["endDate"];
	$startTime = $_GET["startTime"];
	$endTime = $_GET["endTime"];

		
	if($_GET["highOfWeek"]) {
		getHigh($startDate,$endDate,$startTime,$endTime);
	}
	else if($_GET["lowOfWeek"]) {
		echo("Chose low of the week");
	}
	else if($_GET["avgTF"]) {
		getAvg($startDate,$endDate,$startTime,$endTime);
	}
	else if($_GET["medTF"]) {
		echo("Chose median");
	}
	else if($_GET["modeTF"]) {
	
	}
	else if($_GET["visualRep"]) {
		
	}
	else if($_GET["numInTF"]) {
		getNumUserBetween($startDate,$endDate,$startTime,$endTime);
	}
	else {
		echo("Error: Unknown Option Selected");
	}
	
	
	//Helper function used to convert string arguments to SQL date format
	function formatDate($date,$time) {
		$timestamp = strtotime($date . " " . $time);
		$datetime = date("Y-m-d H:i", $timestamp);
		//echo($datetime);
		
		return $datetime;
	}
	
	
	
	//Finished
	function getNumUserBetween($startD,$endD,$startT,$endT) {
		global $debug; global $COMMON;
		
		$beginning = formatDate($startD,$startT);
		$end = formatDate($endD, $endT);
		$sql = "SELECT COUNT(*) FROM `motion_data` WHERE `visit_time` BETWEEN '$beginning' AND '$end'";
		
		$rs = $COMMON->executeQuery($sql, $_SERVER["SCRIPT_NAME"] );
		$row = $rs->fetch(PDO::FETCH_NUM);

		echo("<h3>Number of students between " . $beginning . " and " . $end . ": " . $row[0] ."</h3>");
	}
	
	
	//Needs implementation
	function getHigh($startD,$endD,$startT,$endT) {
		global $debug; global $COMMON;

		$beginning = formatDate($startD,$startT);
		$end = formatDate($endD, $endT);
		
		
	}
	
	
	//Needs implementation
	function getAvg($startD,$endD,$startT,$endT) {
		global $debug; global $COMMON;
		
		$beginning = formatDate($startD,$startT);
		$end = formatDate($endD, $endT);
		
		$sql = "SELECT COUNT(*) FROM `motion_data` WHERE `visit_time` BETWEEN '$beginning' AND '$end'";
		$rs = $COMMON->executeQuery($sql, $_SERVER["SCRIPT_NAME"] );
		$row = $rs->fetch(PDO::FETCH_NUM);
	
		
	
		echo($row[0]);
	}
	
	
	//Needs implementation. Suggested on piazza to look into google charts.
	function visualRepresentation() {

	}
	
?>



