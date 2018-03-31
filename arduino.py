import pyfirmata
import time
import threading
import sys

BOARD = None
BOARD_PORT = "COM1"
PIR_PIN = None

# Sets up Arduino
# Preconditions: Arduino is connected to PC port COM1
# Postconditions: BOARD is initialized, PIR_PIN contains reference to PIR sensor on pin 13
def arduino_setup():
	BOARD = pyfirmata.Arduino(BOARD_PORT)

	it = pyfirmata.util.Iterator(BOARD)
	it.start()

	PIR_PIN = BOARD.get_pin('d:13:i')
	PIR_PIN.enable_reporting()

# Monitors PIR sensors for one-way motion
# Calls motion_detected() if pir detects motion
# Preconditions: setup() has completed successfully, PIR_PIN connected to PIR sensor
# Postconditions: Function does not exit. Calls motion_detected() on HIGH input from PIR.
def arduino_loop():
	while PIR_PIN.read() is None:
		pass

	while True:
		if PIR_PIN.read() is True:
			motion_detected()


# Callback for detecting motion with PIR
# Creates thread to send motion data to project DB
# Preconditions: PIR detected motion
# Postconditions: DB comms thread started
def motion_detected():
	threading.Thread(target=post_db_data).start()