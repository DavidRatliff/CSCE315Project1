# Function Signatures:

	# Sets up Arduino
	# Preconditions: Arduino is connected to PC port COM1
	# Postconditions: Board is initialized, pir_pin contains reference to digital input pin 13
	# def arduino_setup():

	# Monitors PIR sensor for motion
	# Preconditions: setup() has completed successfully, pir_pin is connected to the PIR sensor
	# Postconditions: Function does not exit. Calls motion_detected() on HIGH input from PIR.
	# def arduino_loop():

	# Callback for detecting motion with PIR
	# Creates thread to send motion data to project DB
	# Preconditions: PIR detected motion
	# Postconditions: DB comms thread created
	# def motion_detected():

	# Connects to and ensures correct configuration of DB
	# Preconditions: Specified host is MySQL server, credentials are correct, DB named DB_NAME and table named TABLE_NAME already exist
	# Postconditions: db_connection is alive
	# def db_setup():

	# Forms and sends SQL query to DB
	# Preconditions: db_setup() has completed successfully, db_connection is still alive
	# Postconditions: DB has received and added data
	# def post_db_data():


import pytest

# Test Cases:

# Case 1: Disconnected board
# Preconditions: Board is not connected
# Expected results: Error written to log, program exits
def test1():
	with pytest.raises(DisconnectedBoardError):
		arduino_setup()

# Case 2: Disconnected PIR sensor
# Preconditions: PIR sensor is not connected, or connected to wrong pin
# Expected results: After 60 seconds of no data, program will write error to log and exit
def test2():
	with pytest.raises(DisconnectedSensorError):
		arduino_setup()
		arduino_loop()

# Case 3: Uninitialized board
# Preconditions: arduino_setup() is never called
# Expected results: Program writes error to log and exits
def test3():
	with pytest.raises(UninitializedBoardError):
		arduino_loop()

# Case 4: Several threads posting to DB at once
# Preconditions: db_setup() has completed successfully
# Expected results: 10 valid records posted to DB
def test4():
	for i in range(10):
		motion_detected()

# Case 5: Invalid DB host name
# Preconditions: host name supplied to db_setup() is invalid
# Expected results: Error written to log, program exits
def test5():
	with pytest.raises(CR_WRONG_HOST_INFO):
		db_setup()

# Case 6: Invalid DB server credentials
# Preconditions: server credentials supplied to db_setup() are invalid
# Expected results: Error written to log, program exits
def test6():
	with pytest.raises(ER_ACCESS_DENIED_ERROR):
		db_setup()

# Case 7: DB does not exist
# Preconditions: DB_NAME supplied to db_setup() does not exist
# Expected results: Error written to log, program exits
def test7():
	with pytest.raises(ER_BAD_DB_ERROR):
		db_setup()

# Case 8: Table does not exist
# Preconditions: TABLE_NAME does not exist in DB_NAME, db_connection initialized successfully
# Expected results: Table created, program continues
def test8():
	db_setup()

# Case 9: Posting data with dead db_connection
# Preconditions: db_setup() was never called
# Expected results: Error written to log, program exits
def test9():
	with pytest.raises(CR_SERVER_GONE_ERROR):
		post_db_data()

# Case 10: Nominal
# Preconditions: main.py executed as __main__, walk in front of motion sensor 5 times
# Expected results: 5 valid records posted to DB