import mysql.connector

# Create a connection to the database
cnx = mysql.connector.connect(
    user="root", password="", host="localhost", allow_local_infile=True
)

# Create a cursor object using the cursor() method
cursor = cnx.cursor()

with open("scripts/creation_script.sql", "r") as file:
    sql = file.read()

for statement in sql.split(";"):
    if statement.strip() != "":
        cursor.execute(statement)
        cnx.commit()

with open("scripts/import_script.sql", "r") as file:
    sql = file.read()

for statement in sql.split(";"):
    if statement.strip() != "":
        cursor.execute(statement)
        cnx.commit()

cursor.close()
cnx.close()
