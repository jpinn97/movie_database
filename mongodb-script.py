import subprocess
from pymongo import MongoClient

client = MongoClient("localhost", 27017)

db = client["movies_database"]

client.drop_database("movies_database")

print("movies_database has been dropped successfully.")

command = [
    "mongoimport",
    "--db",
    "movies_database",
    "--collection",
    "internet_user",
    "--file",
    "json/Internet_user.json",
    "--jsonArray",
]
subprocess.run(command, check=True)

print("Internet User Documents inserted successfully.")
command = [
    "mongoimport",
    "--db",
    "movies_database",
    "--collection",
    "movie",
    "--file",
    "json/Movie.json",
    "--jsonArray",
]
subprocess.run(command, check=True)
print("Movie Documents inserted successfully.")
