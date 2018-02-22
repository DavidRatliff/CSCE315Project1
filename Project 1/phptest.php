<?php
	
// Function Signatures:

	// Returns the number of visitors between time begin and end
	// Uses the present time as default end value
	// Preconditions: Successful connection to SQL database, parameters are timestamps in string form, $begin>epoch, $end<current time, $begin<$end
	// Postconditions: Returns visit count
	// function visitors_between($begin, $end="CURRENT_TIMESTAMP")


	// Returns list of visit times between time begin and end
	// Uses present time as default end value
	// Preconditions: Successful connection to SQL database, parameters are timestamps in string form, $begin>epoch, $end<current time
	// Postconditions: Returns list of visit times
	// function visit_times_between($begin, $end="CURRENT_TIMESTAMP")



use PHPUnit\Framework\TestCase;

final class ProjectTest extends TestCase {

	// Case 1: Invalid parameter types
	public function test1(): void {
		$this->expectException(InvalidArgumentException::class);

		visitors_between(1, TRUE)
	}

	// Case 2: Future date
	public function test2(): void {
		$this->expectException(InvalidArgumentException::class);

		visitors_between("2017-02-05 13:27:07", "2021-02-05 13:27:07")
	}

	// Case 3: Date before epoch
	public function test3(): void {
		$this->expectException(InvalidArgumentException::class);

		visitors_between("1917-02-05 13:27:07", "2016-02-05 13:27:07")
	}

	// Case 4: Begin date after end date
	public function test4(): void {
		$this->expectException(InvalidArgumentException::class);

		visitors_between("2017-02-05 13:27:07", "2015-02-05 13:27:07")
	}
}