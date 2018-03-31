<?php
	
// Function Signatures:

	// Returns the number of visitors in the time frame given
	// Uses start date, end date, start time, and end time given by user
	// Preconditions: Successful connection to SQL database, parameters are timestamps in string form, $startD>epoch, $end<current time, $startT and $endT are valid times
	// Postconditions: Display number of visitors in time frame
	// function getVisitsBetween($startD, $endD, $startT, $endT)

	
	// Returns the low point in the time frame given
	// Uses start date, end date, start time, and end time given by user
	// Preconditions: Successful connection to SQL database, parameters are timestamps in string form, $startD>epoch, $end<current time, $startT and $endT are valid times
	// Postconditions: Displays least number of visits and corresponding date
	// function getLow($startD, $endD, $startT, $endT)
	
	
	// Returns the high point in the time frame given
	// Uses start date, end date, start time, and end time given by user
	// Preconditions: Successful connection to SQL database, parameters are timestamps in string form, $startD>epoch, $end<current time, $startT and $endT are valid times
	// Postconditions: Displays greatest number of visits and corresponding date
	// function getHigh($startD, $endD, $startT, $endT)
	
	
	// Returns the average number of visits in the time frame given
	// Uses start date, end date, start time, and end time given by user
	// Preconditions: Successful connection to SQL database, parameters are timestamps in string form, $startD>epoch, $end<current time, $startT and $endT are valid times
	// Postconditions: Displays average number of visits
	// function getAvg($startD, $endD, $startT, $endT)
	

use PHPUnit\Framework\TestCase;

final class ProjectTest extends TestCase {

	// Cases 1-4: Invalid parameter types
	public function test1(): void {
		$this->expectException(InvalidArgumentException::class);

		getVisitsBetween(1, TRUE, 2, FALSE);
	}

	public function test2(): void {
		$this->expectException(InvalidArgumentException::class);
		
		getHigh(1, TRUE, 2, FALSE);
	}
	
	
	public function test3(): void {
		$this->expectException(InvalidArgumentException::class);
		
		getLow(1, TRUE, 2, FALSE);
	}
	
	public function test4(): void {
		$this->expectException(InvalidArgumentException::class);
		
		getAvg(1, TRUE, 2, FALSE);
	}
	

	// Case 5-8: Future date
	public function test5(): void {
		$this->expectException(InvalidArgumentException::class);

		getVisitsBetween("2017-02-05", "2021-02-05", "13:27:07", "13:27:07");
	}

	public function test6(): void {
		$this->expectException(InvalidArgumentException::class);

		getHigh("2017-02-05", "2021-02-05", "13:27:07", "13:27:07");
	}
	
	public function test7(): void {
		$this->expectException(InvalidArgumentException::class);

		getLow("2017-02-05", "2021-02-05", "13:27:07", "13:27:07");
	}
	
	public function test8(): void {
		$this->expectException(InvalidArgumentException::class);

		getAvg("2017-02-05", "2021-02-05", "13:27:07", "13:27:07");
	}


	// Case 9-12: Date before epoch
	public function test9(): void {
		$this->expectException(InvalidArgumentException::class);

		getVisitsBetween("1917-02-05", "2016-02-05", "13:27:07", "13:27:07");
	}
	
	public function test10(): void {
		$this->expectException(InvalidArgumentException::class);

		getHigh("1917-02-05", "2016-02-05", "13:27:07", "13:27:07");
	}	
	
	public function test11(): void {
		$this->expectException(InvalidArgumentException::class);

		getLow("1917-02-05", "2016-02-05", "13:27:07", "13:27:07");
	}	
	
	public function test12(): void {
		$this->expectException(InvalidArgumentException::class);

		getAvg("1917-02-05", "2016-02-05", "13:27:07", "13:27:07");
	}	

	// Case 13-16: Begin date after end date
	public function test13(): void {
		$this->expectException(InvalidArgumentException::class);

		getVisitsBetween("2017-02-05", "2015-02-05", "13:27:07", "13:27:07");
	}
	
	public function test14(): void {
		$this->expectException(InvalidArgumentException::class);

		getHigh("2017-02-05", "2015-02-05", "13:27:07", "13:27:07");
	}
	
	public function test15(): void {
		$this->expectException(InvalidArgumentException::class);

		getLow("2017-02-05", "2015-02-05", "13:27:07", "13:27:07");
	}
	
	public function test16(): void {
		$this->expectException(InvalidArgumentException::class);

		getAvg("2017-02-05", "2015-02-05", "13:27:07", "13:27:07");
	}
	
	//Cases 17-19: Valid argument types
	
	public function test17(): void {
		$this->expectException(InvalidArgumentException::class);
		
		validDateRange(0,True);
	}
	
	public function test18(): void {
		$this->expectException(InvalidArgumentException::class);
		
		continuousTimeRange(0,True);
	}
	
	public function test19(): void {
		$this->expectException(InvalidArgumentException::class);
		
		getLineGraphData(0,True,1,False);
	}
	
	
}
