
<!DOCTYPE HTML>
<html>
<head>

<script>
</script>

<body>

	<h3> Choose the start/end date and start/end time. If you wish you may leave the end time empty. </h3>
	
    <form action = "action.php" method = "get">
		Select Start Date: <input type = "date" name = "startDate">
		Select End Date: <input type = "date" name = "endDate"> <br>
		Select Start Time: <input type = "time" name = "startTime">
		Select End Time: <input type = "time" name = "endTime"> <br> <br>

		Graph data points for visual representation: <input type = "submit" value = "Option 1" name = "visualRep"> <br>
		High points of the week: <input type = "submit" value = "Option 2" name = "highOfWeek"> <br>
		Low points of the week: <input type = "submit" value = "Option 3" name = "lowOfWeek"> <br>
		Mean of given time frame: <input type = "submit" value = "Option 4" name = "avgTF"> <br>
		Median of given time frame: <input type = "submit" value = "Option 5" name = "medTF"> <br>
		Mode of given time frame: <input type = "submit" value = "Option 6" name = "modeTF"> <br>
		Number of students in certain time frame: <input type = "submit" value = "Option 7" name = "numInTF"> <br>
	</form>

	<!--<form>
		<input type = "submit" name = "subButton">
	</form>
	-->
	
</body>
</head>
</html>