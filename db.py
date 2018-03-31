import mysql
from mysql.connector import errorcode
from datetime import date, datetime

connection = None
DB_NAME = 'xxx'
TABLE_NAME = 'xxx'

# Connects to and ensures correct configuration of DB
# Preconditions: Specified host is MySQL server, credentials are correct, DB named DB_NAME and table named TABLE_NAME already exist
# Postconditions: db_connection is alive
def db_setup():
	try:
		db_connection = mysql.connector.connect(user='xxx',
												password='xxx',
												host='',
												database=DB_NAME)
	except mysql.connector.Error as e:
		if err.errno == errorcode.ER_ACCESS_DENIED_ERROR:
			print("Credentials are invalid")
		elif err.errno == errorcode.ER_BAD_DB_ERROR:
			print("Database does not exist")
		elif err.errno == errorcode.CR_WRONG_HOST_INFO:
			print("Host info is invalid")
		else:
			print(err)

		exit('Error!')

	cursor = connection.cursor()
	cursor.execute("SHOW TABLES")
	if TABLE_NAME not in cursor:
		print("Project table does not exist")
		exit('Error!')

	cursor.close()

# Forms and sends SQL query to DB
# Preconditions: db_setup() has completed successfully, db_connection is still alive
# Postconditions: DB has received and added data
def post_db_data():
	cursor = connection.cursor()

	query = ("INSERT INTO xxx"
			 "(xxx, xxx, ...)"
			 "VALUES (xxx, xxx, ...)")

	cursor.execute(query)
	connection.commit()
	cursor.close()
