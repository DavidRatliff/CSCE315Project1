import pyfirmata
import time
import threading
import sys

board = None;
board_port = "COM1";
pir_pin = None;

# Sets up Arduino
# Preconditions: Arduino is connected to PC port COM1
# Postconditions: Board is initialized, pir_pin contains reference to digital input pin 13
def arduino_setup():
	board = pyfirmata.Arduino(board_port)

	it = pyfirmata.util.Iterator(board)
	it.start()

	pir_pin = board.get_pin('d:13:i')
	pir_pin.enable_reporting()

# Monitors PIR sensor for motion
# Preconditions: setup() has completed successfully, pir_pin is connected to the PIR sensor
# Postconditions: Function does not exit. Calls motion_detected() on HIGH input from PIR.
def arduino_loop():
	while pir_pin.read() is None:
		pass

	while(True):
		if pir_pin.read() is True:
			motion_detected()
			time.sleep(4) # PIR output is HIGH for around 3-4 seconds after motion

# Callback for detecting motion with PIR
# Creates thread to send motion data to project DB
# Preconditions: PIR detected motion
# Postconditions: DB comms thread started
def motion_detected():
	threading.Thread(target=post_db_data).start()