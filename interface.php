<!DOCTYPE HTML>
<html>
<script>
	window.onload = toggleEndDate;
	
	// Disables end date form field if user enables "single day" checkbox
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
		<input type = "submit" value = "Analyze">
	</form>
</body>
</html>