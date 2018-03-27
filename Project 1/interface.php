<!DOCTYPE HTML>
<html>
<script>
	function toggleEndDate() {
		var checkbox = document.getElementById("singleDay");
		var field = document.getElementById("endDate");
		if(checkbox.checked) {
			field.disabled = true;
		}
		else
			field.disabled = false;
	}
</script>
<body>
	<h3> Select Timeframe: </h3>
	
    <form action = "action.php" method = "get">
    	Single Day: <input type = "checkbox" name = "singleDay" id = "singleDay" onChange = "toggleEndDate()"> <br>
		Select Start Date: <input type = "date" name = "startDate" required>
		Select End Date: <input type = "date" name = "endDate" id = "endDate" required> <br>
		Select Start Time: <input type = "time" name = "startTime" required>
		Select End Time: <input type = "time" name = "endTime" required> <br> <br>

		Generate Histogram: <input type = "checkbox" name = "histogram"> <br>
		<input type = "submit" value = "Analyze">
	</form>
</body>
</html>