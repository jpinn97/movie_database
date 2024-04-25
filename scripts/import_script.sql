USE movies_database;
SET foreign_key_checks = 0;
LOAD DATA LOCAL INFILE '/home/jpinn/movie_database/csv/Country-table.csv' INTO TABLE Country FIELDS TERMINATED BY ',' ENCLOSED BY '"' ESCAPED BY '"' LINES TERMINATED BY '\n' IGNORE 1 LINES (code, name, language);
LOAD DATA LOCAL INFILE '/home/jpinn/movie_database/csv/Movie-table.csv' INTO TABLE Movie FIELDS TERMINATED BY ',' ENCLOSED BY '"' ESCAPED BY '"' LINES TERMINATED BY '\n' IGNORE 1 LINES (
    movieId,
    title,
    year,
    producerId,
    genre,
    summary,
    countryCode
);
LOAD DATA LOCAL INFILE '/home/jpinn/movie_database/csv/Artist-table.csv' INTO TABLE Artist FIELDS TERMINATED BY ',' ENCLOSED BY '"' ESCAPED BY '"' LINES TERMINATED BY '\n' IGNORE 1 LINES (artistId, surname, name, DOB);
LOAD DATA LOCAL INFILE '/home/jpinn/movie_database/csv/Role-table.csv' INTO TABLE Role FIELDS TERMINATED BY ',' ENCLOSED BY '"' ESCAPED BY '"' LINES TERMINATED BY '\n' IGNORE 1 LINES (movieId, actorId, roleName);
LOAD DATA LOCAL INFILE '/home/jpinn/movie_database/csv/Internet-user-table.csv' INTO TABLE Internet_user FIELDS TERMINATED BY ',' ENCLOSED BY '"' ESCAPED BY '"' LINES TERMINATED BY '\n' IGNORE 1 LINES (email, surname, name, region);
-- Enable foreign key checks
SET foreign_key_checks = 1;