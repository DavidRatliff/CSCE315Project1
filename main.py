def main():
	with open('log.txt', 'w') as log_file:
		# redirect stdout to log file
		sys.stdout = log_file

		arduino_setup()
		db_setup()
		
		arduino_loop()

if __name__ == '__main__':
	main()