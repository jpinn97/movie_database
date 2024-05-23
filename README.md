Movie Database Project
=======================


Overview
----------

This project integrates SQL and NoSQL databases to manage a movie database system. It leverages MySQL for relational data storage and MongoDB for document-oriented storage, providing a robust and scalable environment for handling complex data interactions. The project is developed using PHP and is hosted locally using XAMPP to simulate a real-world web application.

### Prerequisites
- XAMPP: Provides an Apache server, MySQL database, PHP, and Perl.
- Conda: Required for managing Python dependencies.
- Python 3.9+: For running Python scripts.
- MongoDB Community Edition: For NoSQL database functionality.
- Homebrew: Used for installing MongoDB on macOS.

### Installation

#### Step 1: Clone the Repository
- Clone the repository to your local machine:

```bash
git clone https://github.com/jpinn97/movie_database.git
cd movie_database
```

#### Step 2: Set Up the Environment

Create a Conda environment to manage Python dependencies:

```bash
conda create -n movie_env --yes
conda config --env --add channels conda-forge
conda config --env --set channel_priority strict
conda install -n movie_env --file requirements.txt --yes
```

To remove the Conda environment:

```bash
conda env remove -n movie_env --yes
```

#### Install Python packages using pip:

```bash
   pip3.9 install -r requirements.txt
```


#### To remove installed packages:

```bash
   pip freeze | xargs pip uninstall -y
```

#### Step 3: Install XAMPP and MongoDB

- Download and install XAMPP:

```bash
wget https://sourceforge.net/projects/xampp/files/XAMPP%20Linux/8.2.12/xampp-linux-x64-8.2.12-0-installer.run
chmod +x xampp-linux-x64-8.2.12-0-installer.run
sudo ./xampp-linux-x64-8.2.12-0-installer.run
```
- Install MongoDB:

```bash
  brew tap mongodb/brew
  brew install mongodb-community
```


#### Step 4: Full Setup

Run the full setup to configure the local environment:

```bash
make full-setup

```

This should:

- Copy PHP files to the XAMPP server directory.
- Start the XAMPP and MongoDB services.
- Run initial setup scripts for both databases.

#### Step 5: Start the Application

To start the XAMPP servers:


```bash
sudo /Applications/XAMPP/xamppfiles/xampp start
```

# Usage
After starting the servers, access the application by navigating to http://localhost in your web browser. Utilize the PHP interface to interact with both MySQL and MongoDB databases, executing predefined queries or custom interactions.

### Version: V001

### Authors
Jamie Pinnington
Abdul Rashid Omeni


## License
Not under any license.


## References: 
- https://www.apachefriends.org/
- https://conda.io/projects/conda/en/latest/user-guide/getting-started.html



# MySQL and MongoDB with PHP Frontend.

## PHP

## MySQL

## MongoDB

Studio3t is a GUI for MongoDB that can be used to migrate data from MySQL to MongoDB. It can be downloaded from [here](https://studio3t.com/download/).

A connection is made to our current MySQL implementation, as well as our target MongoDB instance. The authentication information, hostname and ports are specified. We can then use the import wizard to migrate data from MySQL to MongoDB.

![Studio3t](/images/image_1.png)

We select the Movie and Internet_user tables from MySQL and click `Mappings`, where we can transform the tables into documents.

![Studio3t](/images/image_2.png)

Essentially, a minimal no-code approach is taken to transform the tables into documents. Moving from a relational database to a document-orientated database requires denormalization. Information that was previously stored in multiple tables is now stored in a single document, this is because to get all the information we need, we would have to perform multiple joins in a relational database.

The complexity of a query is increased by the number of joins that are required, which can slow down the query on large datasets, as well as make the query harder to read and maintain.

Given our dataset, the data is tightly coupled, we can use an object-orientated approach via documents to store related information together to avoid expensive joins.

There is no need to define a complex schema, the structure of a document is flexible, and can be changed at any time. This is useful when we are working with data that is constantly changing, as we can add new fields to a document without affecting the existing documents.

For instance, after visually inspecting the dataset, we look at the database schema, to understand the relationships between the tables. The `Movie` table becomes the main document of the collection, with the `country` and `role` becoming sub-documents. We create a new sub-document, the `producer`, which maps the artists who aren't referenced by the `role` table. The `artist` table is embedded in the `role` sub-document. This makes the data more readable, easier to query and natural.

A movie has a country, a producer and a list of roles (characters) played by artists. By doing so, we've encapsulated the data that into a single document, which needn't change often, this decreases the number of write operations, as well as the number of queries required to get the data we need.

![Studio3t](/images/image_3.png)

The `Internet_user` and `Score_movie` table are moved into their own collection. Given the nature of the data, the `movie` documents are unlikely to change often. Taking into account that amount of internet user ratings are variable, and the document size limit of MongoDB, there are methods to handle this, but we needn't write endless queries to a `movie` document to update the ratings. We can simply update the `Internet_user` and `Score_movie` documents, and query the `movieId` to get the ratings. This allows us to maintain maximum read operations to the `movie` collection.

The `Score_movie` table is embedded into the `Internet_user` document, and denormalized to remove redundant data. We now have a collection of `movie` documents and a collection of `Internet_user` documents.

# Exporting, Preparing, and Importing into MongoDB

The migration can go directly into our MongoDB, but we want to check it over and remove anything that has occurred from the MySQL database, such as carriage returns, we can export the data to a JSON file. Before we do that, Studio3t has given us JSON that has data types from MongoDB that aren't valid JSON. We parse a few commands to replace the invalid data types with [MongoDB Extended JSON v2](https://www.mongodb.com/docs/manual/reference/mongodb-extended-json/#mongodb-extended-json--v2-)

```
sed -i 's/ISODate(\(.*\))/{"$date": \1}/g' json/Movie.json
sed -i 's/NumberInt(\(.*\))/{"$numberInt": "\1"}/g' json/Movie.json
sed -i 's/ObjectId(\(.*\))/{"$oid": \1}/g' json/Movie.json
```
