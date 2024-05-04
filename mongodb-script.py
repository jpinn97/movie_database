from pymongo import MongoClient, UpdateOne
import json
from bson import ObjectId
import os

def load_data_from_json(file_path):
    with open(file_path, 'r') as file:
        data = json.load(file)
    # Convert all ObjectId fields if they exist
    for item in data:
        if '_id' in item and isinstance(item['_id'], dict) and '$oid' in item['_id']:
            item['_id'] = ObjectId(item['_id']['$oid'])
    return data

def upsert_documents(collection, data):
    operations = []
    for doc in data:
        # Check if '_id' exists and only then use it for upserting
        if '_id' in doc:
            operations.append(UpdateOne({'_id': doc['_id']}, {'$set': doc}, upsert=True))
        else:
            # If '_id' does not exist, we rely on MongoDB to auto-generate it
            operations.append(UpdateOne({'_id': doc.get('_id', ObjectId())}, {'$set': doc}, upsert=True))
    
    if operations:
        result = collection.bulk_write(operations, ordered=False)
        print(f"Processed {len(operations)} documents into {collection.name}.")
        print(f"Matched: {result.matched_count}, Upserted: {result.upserted_count}, Modified: {result.modified_count}")
    else:
        print("No operations to perform.")

def main():
    client = MongoClient('mongodb://localhost:27017')
    db = client['movies_database']

    base_path = '/Applications/XAMPP/xamppfiles/htdocs/movie_database/json'  # Adjust as necessary

    files_to_collections = {
        'internet_user.json': 'internet_user',
        'movie.json': 'movie',
        'movies_database.json': 'movies_database',
        'movie_db_mysql_export.json': 'mysql_export'
    }

    for filename, collection_name in files_to_collections.items():
        file_path = os.path.join(base_path, filename)
        if os.path.exists(file_path):
            data = load_data_from_json(file_path)
            upsert_documents(db[collection_name], data)
        else:
            print(f"No data file found for {filename}")

if __name__ == "__main__":
    main()














# # Connect to MongoDB (update the connection string as needed)
# import subprocess

# command = [
#     "mongoimport",
#     "--db",
#     "movies_database",
#     "--collection",
#     "internet_user",
#     "--file",
#     "json/Internet_user.json",
#     "--jsonArray",
# ]

# subprocess.run(command, check=True)

# print("Internet User Documents inserted successfully.")

# command = [
#     "mongoimport",
#     "--db",
#     "movies_database",
#     "--collection",
#     "movie",
#     "--file",
#     "json/Movie.json",
#     "--jsonArray",
# ]

# subprocess.run(command, check=True)



























# # Connect to MongoDB (update the connection string as needed)
# import subprocess

# command = [
#     "mongoimport",
#     "--db",
#     "movies_database",
#     "--collection",
#     "internet_user",
#     "--file",
#     "json/Internet_user.json",
#     "--jsonArray",
# ]

# subprocess.run(command, check=True)

# print("Internet User Documents inserted successfully.")

# command = [
#     "mongoimport",
#     "--db",
#     "movies_database",
#     "--collection",
#     "movie",
#     "--file",
#     "json/Movie.json",
#     "--jsonArray",
# ]

# subprocess.run(command, check=True)









