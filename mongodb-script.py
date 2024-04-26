import json
from pymongo import MongoClient

# Create a client
client = MongoClient("mongodb://localhost:27017/")

# Connect to your database
db = client["movies_database"]

collection = db["movies"]

with open("json/movies_database.json", "r") as file:
    file_data = json.load(file)

collection.insert_many(file_data)

print(collection.find_one())

client.close()
