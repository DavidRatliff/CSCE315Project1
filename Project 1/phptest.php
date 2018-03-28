<?php
	
// Function Signatures:

	// Returns the number of visitors in the time frame given
	// Uses start date, end date, start time, and end time given by user
	// Preconditions: Successful connection to SQL database, parameters are timestamps in string form, $startD>epoch, $end<current time, $startT and $endT are valid times
	// Postconditions: Display number of visitors in time frame
	// function echoVisitsBetween($startD, $endD, $startT, $endT)

	
	// Returns the low point in the time frame given
	// Uses start date, end date, start time, and end time given by user
	// Preconditions: Successful connection to SQL database, parameters are timestamps in string form, $startD>epoch, $end<current time, $startT and $endT are valid times
	// Postconditions: Displays least number of visits and corresponding date
	// function echoLow($startD, $endD, $startT, $endT)
	
	
	// Returns the high point in the time frame given
	// Uses start date, end date, start time, and end time given by user
	// Preconditions: Successful connection to SQL database, parameters are timestamps in string form, $startD>epoch, $end<current time, $startT and $endT are valid times
	// Postconditions: Displays greatest number of visits and corresponding date
	// function echoHigh($startD, $endD, $startT, $endT)
	
	
	// Returns the average number of visits in the time frame given
	// Uses start date, end date, start time, and end time given by user
	// Preconditions: Successful connection to SQL database, parameters are timestamps in string form, $startD>epoch, $end<current time, $startT and $endT are valid times
	// Postconditions: Displays average number of visits
	// function echoAvg($startD, $endD, $startT, $endT)
	

use PHPUnit\Framework\TestCase;

final class ProjectTest extends TestCase {

	// Cases 1-4: Invalid parameter types
	public function test1(): void {
		$this->expectException(InvalidArgumentException::class);

		echoVisitsBetween(1, TRUE, 2, FALSE);
	}

	public function test2(): void {
		$this->expectException(InvalidArgumentException::class);
		
		echoHigh(1, TRUE, 2, FALSE);
	}
	
	
	public function test3(): void {
		$this->expectException(InvalidArgumentException::class);
		
		echoLow(1, TRUE, 2, FALSE);
	}
	
	public function test4(): void {
		$this->expectException(InvalidArgumentException::class);
		
		echoAvg(1, TRUE, 2, FALSE);
	}
	

	// Case 5-8: Future date
	public function test5(): void {
		$this->expectException(InvalidArgumentException::class);

		echoVisitsBetween("2017-02-05", "2021-02-05", "13:27:07", "13:27:07");
	}

	public function test6(): void {
		$this->expectException(InvalidArgumentException::class);

		echoHigh("2017-02-05", "2021-02-05", "13:27:07", "13:27:07");
	}
	
	public function test7(): void {
		$this->expectException(InvalidArgumentException::class);

		echoLow("2017-02-05", "2021-02-05", "13:27:07", "13:27:07");
	}
	
	public function test8(): void {
		$this->expectException(InvalidArgumentException::class);

		echoAvg("2017-02-05", "2021-02-05", "13:27:07", "13:27:07");
	}


	// Case 9-12: Date before epoch
	public function test9(): void {
		$this->expectException(InvalidArgumentException::class);

		echoVisitsBetween("1917-02-05", "2016-02-05", "13:27:07", "13:27:07");
	}
	
	public function test10(): void {
		$this->expectException(InvalidArgumentException::class);

		echoHigh("1917-02-05", "2016-02-05", "13:27:07", "13:27:07");
	}	
	
	public function test11(): void {
		$this->expectException(InvalidArgumentException::class);

		echoLow("1917-02-05", "2016-02-05", "13:27:07", "13:27:07");
	}	
	
	public function test12(): void {
		$this->expectException(InvalidArgumentException::class);

		echoAvg("1917-02-05", "2016-02-05", "13:27:07", "13:27:07");
	}	

	// Case 13-16: Begin date after end date
	public function test13(): void {
		$this->expectException(InvalidArgumentException::class);

		echoVisitsBetween("2017-02-05", "2015-02-05", "13:27:07", "13:27:07");
	}
	
	public function test14(): void {
		$this->expectException(InvalidArgumentException::class);

		echoHigh("2017-02-05", "2015-02-05", "13:27:07", "13:27:07");
	}
	
	public function test15(): void {
		$this->expectException(InvalidArgumentException::class);

		echoLow("2017-02-05", "2015-02-05", "13:27:07", "13:27:07");
	}
	
	public function test16(): void {
		$this->expectException(InvalidArgumentException::class);

		echoAvg("2017-02-05", "2015-02-05", "13:27:07", "13:27:07");
	}
	
}
