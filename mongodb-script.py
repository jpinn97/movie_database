# Connect to MongoDB (update the connection string as needed)
import subprocess

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

# collection = db["internet_user"]
#
# print("Internet User Documents inserted successfully.")
#
## Load the JSON file
# with open("json/Movie_user.json", "r") as file:
#    data = json.load(file)
#
## Insert the data into the collection
# collection.insert_many(data)
#
# print("Movie Documents inserted successfully.")
