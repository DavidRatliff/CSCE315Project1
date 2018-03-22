
<?php
	$debug = false;
	include('CommonMethods.php');
	$COMMON = new Common($debug);
	
	
	$startDate = $_GET["startDate"];
	$endDate = $_GET["endDate"];
	$startTime = $_GET["startTime"];
	$endTime = $_GET["endTime"];
	
	//Need to join dates and times to make timestamps
	//$startDate . $startTime;
	
	//echo();
	
	
	if($_GET["highOfWeek"]) {
		//echo("In here");
		getHigh($startDate,$endDate,$startTime,$endTime);
	}
	else if($_GET["lowOfWeek"]) {
		echo("Chose low of the week");
	}
	else if($_GET["avgTF"]) {
		echo("Chose average");
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
	
	function formatDate($date,$time) {
		$timestamp = strtotime($date . " " . $time);
		$datetime = date("Y-m-d H:i", $timestamp);
		//echo($datetime);
		
		return $datetime;
	}
	
	
	function getNumUserBetween($startD,$endD,$startT,$endT) {
		$beginning = formatDate($startD,$startT);
		
		$sql = "SELECT COUNT(*) FROM `motion_data` WHERE `visit_time` BETWEEN '$beginning' AND CURRENT_TIMESTAMP";
		//echo($sql);
		
		$rs = $COMMON->executeQuery($sql, $_SERVER["SCRIPT_NAME"] );
		$row = $rs->fetch(PDO::FETCH_ASSOC);
		
		echo(gettype($row));
	}
	
	
	function getHigh($startD,$endD,$startT,$endT) {
		//global $debug; global $COMMON;
		
		//echo($startD);
		//echo($startT);
		
		$value = formatDate($startD,$startT);
		
		
		//$sql = "SELECT * FROM motion_data"
		//$rs = $COMMON->executeQuery( $sql , $_SERVER["SCRIPT_NAME"] );
		
		//$row = $rs->fetch(PDO::FETCH_ASSOC);
		
	}
	
	function getAvg($startD,$endD,$startT,$endT) {
		//global $debug; global $COMMON;
		
		//$sql = "SELECT COUNT(visit_time) FROM motion_data WHERE";
		
		
	}
	
?>



