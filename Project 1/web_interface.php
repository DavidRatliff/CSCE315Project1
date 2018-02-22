<!DOCTYPE html>
<html>
<body>
	<?php
	// Returns the number of visitors between time begin and end
	// Uses the present time as default end value
	// Preconditions: Successful connection to SQL database, $begin>epoch, $end<current time
	// Postconditions: Returns visit count
	function visitors_between($begin, $end="CURRENT_TIMESTAMP") {

	}


	// Returns list of visit times between time begin and end
	// Uses present time as default end value
	// Preconditions: Successful connection to SQL database, $begin>epoch, $end<current time
	// Postconditions: Returns list of visit times
	function visit_times_between($begin, $end="CURRENT_TIMESTAMP") {

	}
	?>
</body>
</html>