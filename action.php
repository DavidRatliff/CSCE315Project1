<html>
	<body>
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


			echo("<h3> Traffic Analysis for " . $startDate . " " . $startTime . " through " . $endDate . " " . $endTime . ": </h3>");
			if(validDateRange($startDate,$endDate)) {
				$totalVisits = getVisitsBetween($startDate,$endDate,$startTime,$endTime);

				if($totalVisits != -1)
					echo("Total visits during timeframe: " . $totalVisits . "<br>");
				else
					echo("No visits during timeframe <br>");


				if(continuousTimeRange($startT,$endT)) {
					list($highVisits, $highDate) = getHigh($startDate,$endDate,$startTime,$endTime);
					list($lowVisits, $lowDate) = getLow($startDate,$endDate,$startTime,$endTime);
					$avgVists = getAvg($startDate,$endDate,$startTime,$endTime);

					if($highVisits != -1)
					echo("Highest traffic point occured on " . $highDate . " with " . $highVisits . " visits <br>");
					else
						echo("Insufficient traffic to determine high point <br>");
					if($lowVists != -1)
						echo("Lowest traffic point occured on " . $lowDate . " with " . $lowVisits . " visits <br>");
					else
						echo("Insufficient traffic to determine low point <br>");
					if($avgVisits != -1)
						echo("Average traffic during this timeframe is " . $avgVists . " visits <br>");
					else
						echo("Insufficient traffic to determine average <br>");
				}
				
				$lineGraphData = getLineGraphData($startDate,$endDate,$startTime,$endTime);
			}
			else
				echo("Invalid date range");
			
			function validDateRange($startD,$endD) {
				return (strtotime($startD)<=strtotime($endD));
			}

			function continuousTimeRange($startT,$endT) {
				return (strtotime($startT)<=strtotime($endT));
			}

			// Echoes the number of visitors entering rec between start and end datetimes
			// Precondition: all input parameters are valid dates/times
			// Postconditions: number of visitors echoed
			function getVisitsBetween($startD,$endD,$startT,$endT) 
			{
				global $debug; global $COMMON;
				$sql = "SELECT COUNT(*) FROM `motion_data` WHERE `visit_time` BETWEEN '$startD " . $startT . "' AND '$endD " . $endT . "'";
				
				$rs = $COMMON->executeQuery($sql, $_SERVER["SCRIPT_NAME"] );
				$row = $rs->fetch(PDO::FETCH_NUM);
				if(!$row) {
					return -1;
				}

				$numVisits = $row[0];
				return $numVisits;
			}
			
			// Finds traffic stats for time ranges between $startT and $endT on dates between $startD and $endD
			// Echoes number of visitors and time for least busy time range
			// Precondition: all input parameters are valid dates/times
			// Postconditions: traffic and time of low point echoed
			function getLow($startD, $endD, $startT, $endT) 
			{
				global $debug; global $COMMON;
				
				$sql = "SELECT * FROM (SELECT COUNT(*) AS COUNT,CAST(visit_time AS DATE) AS date FROM `motion_data` WHERE (CAST(visit_time AS DATE) BETWEEN '$startD' AND '$endD') AND (CAST(visit_time AS TIME) BETWEEN '$startT' AND '$endT') GROUP BY CAST(visit_time AS DATE)) AS COUNTS ORDER BY COUNT ASC";
				$rs = $COMMON->executeQuery($sql, $_SERVER["SCRIPT_NAME"]);
				$row = $rs->fetch(PDO::FETCH_NUM);
				if(!$row) {
					return -1;
				}
				
				$numVisits = $row[0];
				$lowDate = $row[1];
				return array($numVisits,$lowDate);
			}
			
			// Finds traffic stats for time ranges between $startT and $endT on dates between $startD and $endD
			// Echoes number of visitors and time for most busy time range
			// Precondition: all input parameters are valid dates/times
			// Postconditions: traffic and time of high point echoed
			function getHigh($startD,$endD,$startT,$endT) 
			{
				global $debug; global $COMMON;

				$sql = "SELECT * FROM (SELECT COUNT(*) AS COUNT,CAST(visit_time AS DATE) AS date FROM `motion_data` WHERE (CAST(visit_time AS DATE) BETWEEN '$startD' AND '$endD') AND (CAST(visit_time AS TIME) BETWEEN '$startT' AND '$endT') GROUP BY CAST(visit_time AS DATE)) AS COUNTS ORDER BY COUNT DESC";
				$rs = $COMMON->executeQuery($sql, $_SERVER["SCRIPT_NAME"] );
				$row = $rs->fetch(PDO::FETCH_NUM);
				if(!$row) {
					return -1;
				}

				$numVisits = $row[0];
				$highDate = $row[1];
				return array($numVisits,$highDate);
			}
			
			// Finds traffic stats for time ranges between $startT and $endT on dates between $startD and $endD
			// Echoes average number of visitors for given time range
			// Precondition: all input parameters are valid dates/times
			// Postconditions: average traffic echoed
			function getAvg($startD,$endD,$startT,$endT) 
			{
				global $debug; global $COMMON;
				
				$sql = "SELECT AVG(COUNT) FROM ( SELECT COUNT(*) AS COUNT FROM `motion_data` WHERE (CAST(visit_time AS DATE) BETWEEN '$startD' AND '$endD') AND (CAST(visit_time AS TIME) BETWEEN '$startT' AND '$endT') GROUP BY CAST(visit_time AS DATE) ) AS COUNTS";
				$rs = $COMMON->executeQuery($sql, $_SERVER["SCRIPT_NAME"] );
				$row = $rs->fetch(PDO::FETCH_NUM);
				if(!$row) {
					return -1;
				}

				$numVisits = $row[0];
				return $numVisits;
			}

			// Gets hour-by-hour traffic data of timeframe to populate line graph
			// Preconditions: start and end date are valid
			// Postconditions: returns json encoded array of date/time and traffic
			function getLineGraphData($startD,$endD,$startT,$endT) {
				$hourLength = 3600; //3600 = number of seconds in hour
				$data = array();

				//round begin time down to nearest hour
				$begin_ts = strtotime($startD . " " . $startT);
				$begin_ts = $begin_ts - ($begin_ts%$hourLength);

				//round end time up to nearest hour
				$end_ts = strtotime($endD . " " . $endT);
				$end_ts = $end_ts - ($end_ts%$hourLength);
				$roundedEndD = date("Y-m-d", $end_ts);
				$roundedEndT = date("H:i", $end_ts);

				$current_ts = $begin_ts;
				while($current_ts<$end_ts) {
					$currentD = date("Y-m-d", $current_ts);
					$currentT = date("H:i", $current_ts);
					$currentDT = $currentD . " " . $currentT;

					$nextHour_ts = $current_ts+3600;
					$nextHourD = date("Y-m-d", $nextHour_ts);
					$nextHourT = date("H:i", $nextHour_ts);

					$traffic = getVisitsBetween($currentD,$nextHourD,$currentT,$nextHourT);
					if($traffic != -1) 
						$data[$currentDT] = $traffic;
					else
						$data[$currentDT] = 0;

					$current_ts += $hourLength;
				}

				return json_encode($data);
			}
		?>

		<div id="lineChart" style="width: 900px; height: 500px"></div>
	</body>
	<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
	<script type="text/javascript">
		google.charts.load('current', {'packages':['corechart']});
		google.charts.setOnLoadCallback(drawTrafficLineGraph);


		// Draws a line graph representing traffic for the given timeframe
		// Preconditions: getLineGraphData() has already been called
		// Postconditions: a nice graph is on the screen
		function drawTrafficLineGraph() {
			var plotData = [];
			plotData.push(['Date/Time', 'Visitors']); //initialize array with legend data

			var array = JSON.parse('<?php echo $lineGraphData?>'); //parse data from php function
			for(var date in array) {
				plotData.push([date, parseInt(array[date])]);
			}
			var plotDataTable = google.visualization.arrayToDataTable(plotData); //convert to google chart usable format

			var options = {
				hAxis: {
					title: 'Date/Time'
				},
				vAxis: {
					title: 'Traffic'
				}
			};

			var chart = new google.visualization.LineChart(document.getElementById("lineChart"));
			chart.draw(plotDataTable, options);
		}
	</script>
</html>