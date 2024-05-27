# Movie Database Project

## Overview

This project integrates SQL and NoSQL databases to manage a movie database system. It leverages MySQL for relational data storage and MongoDB for document-oriented storage, providing a robust and scalable environment for handling complex data interactions.

### Prerequisites

- Python 3.10.12
- Make

### Installation

#### Step 1: Clone the Repository

```bash
git clone https://github.com/jpinn97/movie_database.git
cd movie_database
```

#### Step 4: Full Installation and Setup

```bash
make full-setup
```

This will install the necessary packages and dependencies for the application. The setup includes the following steps:

- Install PHP, XAMPP, Composer, and MongoDB.
- Copy PHP files to the XAMPP server directory.

#### Step 5: Start the Application

```bash
make start
```

This will start the Apache server, MySQL and MongoDB services, it will then populate the databases with the movie data.

# Usage

After starting the servers, access the application by navigating to http://localhost in your web browser. Utilize the PHP interface to interact with both MySQL and MongoDB databases by executing predefined queries.

The default credentials are required for MySQL: username is `root` and password is empty.

# MySQL and MongoDB with PHP Frontend.

## MySQL

The provided dataset consisted of 5 csv files containing data for: `Artist`, `Country`, `Movie`, `Role`, and `Internet_user`. The given schema for the database:

```
Movie (movieId, title, year, genre, summary, #producerId, #countryCode)
Country (code, name, language)
Artist (artistId, surname, name, DOB)
Role (#movieId, #actorId, roleName)
Internet_user (email, surname, name, region)
Score_movie (#email, #movieId, score)
```

A Python script performs the following tasks:

- Connects to MySQL database.
- Runs a creation_script.sql server that reads a creation_script.sql file to create the database and tables. It splits each query by the delimiter `;` and executes them. Example:

```sql
CREATE TABLE Country (
    code CHAR(2) PRIMARY KEY,
    name VARCHAR(255),
    language VARCHAR(100)
);
```

- Performs path manipulation to insert the csv files absolute location dynamically in the read SQL query.
- Inserts the data from the csv files into the tables using the `LOAD DATA INFILE` command.
- Executes a sanitization script to standardize the data.

## Frontend

The frontend consists of a simple HTML that uses HTMX to make AJAX requests to the PHP backend. It passes credentials if necessary to the predefined query that is selected by the user, which connects and retrieves the data, before displaying it in a table.

The HTMX allows for a more dynamic frontend by swapping elements, without the need for a full page reload.

```html
<button
  hx-post="/php/query_1.php"
  hx-trigger="click"
  hx-target="#result"
  hx-vals='{"username": document.getElementById("username").value, "password": document.getElementById("password").value}'
>
  Query 1
</button>
```

The query_1 button is pressed, which sends the username and password from the interface to the PHP query via the `hx-vals` attribute, it then swaps the content of the `#result` div with the result of the query via the `hx-target` attribute.

## MongoDB

Studio3t is a GUI for MongoDB that can be used to migrate data from MySQL to MongoDB. It can be downloaded from [here](https://studio3t.com/download/).

A connection is made to our current MySQL implementation, as well as our target MongoDB instance. The authentication information, hostname and ports are specified. We can then use the import wizard to migrate data from MySQL to MongoDB.

![Studio3t](/images/image_1.png)

We select the Movie and Internet_user tables from MySQL and click `Mappings`, where we can transform the tables into documents.

![Studio3t](/images/image_2.png)

Essentially, a minimal no-code approach is taken to transform the tables into documents. Moving from a relational database to a document-orientated database requires denormalization. Information that was previously stored across multiple tables is now stored in as few objects as possible, this is because to get all the information we need, we would have to perform multiple joins in a relational database.

The complexity of a query is increased by the number of joins that are required, which can slow down the query on large datasets, as well as make the query harder to read and maintain.

Given our dataset, the data is tightly coupled, we can use an object-orientated approach to store related information together to avoid expensive joins.

There is no need to define a complex schema with a document, the structure is flexible, and can be changed more easily than in relational databases. This is useful when we are working with data that is constantly changing, as we can add new fields to a document without affecting the existing documents.

For instance, after visually inspecting the dataset, we look at the database schema, to understand the relationships between the tables. The `Movie` table becomes the main document of the collection, with the `country` and `role` becoming sub-documents. We create a new sub-document, the `producer`, which maps the artists who aren't referenced by the `role` table. The `artist` table is embedded in the `role` sub-document. This makes the data more readable, easier to query and natural.

A movie has a country, a producer and a list of roles (characters) played by artists. By doing so, we've encapsulated the data that into a single document, which needn't change often, this decreases the number of write operations, as well as the number of queries required to get the data we need.

![Studio3t](/images/image_3.png)

The `Internet_user` and `Score_movie` table are moved into their own collection. Given the nature of the data, the `movie` documents are unlikely to change often. Taking into account that amount of internet user ratings are variable, and the document size limit of MongoDB, there are methods to handle this, but we needn't write endless queries to a `movie` document to update the ratings. We can simply update the `Internet_user` and `Score_movie` documents, and query the `movieId` to get the ratings. This allows us to maintain maximum read operations to the `movie` collection.

The `Score_movie` table is embedded into the `Internet_user` document, and denormalized to remove redundant data. We now have a collection of `movie` documents and a collection of `Internet_user` documents.

# Exporting, Preparing, and Importing into MongoDB

The migration can go directly into our MongoDB, but we want to ensure the document is cleansed of anything that has occurred from the MySQL database, such as carriage returns, we can export the data to a JSON file.

The exported JSON has data types from MongoDB that aren't valid JSON. We parse a few commands to replace the invalid data types with [MongoDB Extended JSON v2](https://www.mongodb.com/docs/manual/reference/mongodb-extended-json/#mongodb-extended-json--v2-)

This must be done, because to import the file we must stream it using JSON, and datatypes like "ObjectID()" aren't valid JSON.

```
sed -i 's/ISODate(\(.*\))/{"$date": \1}/g' json/Movie.json
sed -i 's/NumberInt(\(.*\))/{"$numberInt": "\1"}/g' json/Movie.json
sed -i 's/ObjectId(\(.*\))/{"$oid": \1}/g' json/Movie.json
```

# Tasks

Jamie(a), Rashid(b):

- index.php [a]
- query_1.php, query_2.php, query_3.php, [b]
- m_query_1.php, m_query_2.php, m_query_3.php [a]
- makefile [a]
- creation_script.sql [b]
- import_script.sql [a]
- sanitize_script.sql [a]
- denormalize mysql db to mongodb [a]
- xampp/mongo py script [a]

### Version: V001

### Authors

Jamie Pinnington
Abdul Rashid Omeni

## License

Not under any license.

## References:

- https://www.apachefriends.org/
