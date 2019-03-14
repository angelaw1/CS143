CREATE TABLE Movie(
	id INT NOT NULL,
	title VARCHAR(100) NOT NULL,
	year INT,
	rating VARCHAR(10),
	company VARCHAR(50),
	PRIMARY KEY(id),
	CHECK(year BETWEEN 1000 AND 9999)
) ENGINE = INNODB;
-- The year needs to be 4 digits
-- All movies have different id so it is the primary key

CREATE TABLE Actor(
	id INT NOT NULL,
	last VARCHAR(20) NOT NULL,
	first VARCHAR(20) NOT NULL,
	sex VARCHAR(6), 
	dob DATE NOT NULL,
	dod DATE CHECK(dod IS NULL OR dod > dob),
	PRIMARY KEY(id)
) ENGINE = INNODB;
-- All actors have different id so it is the primary key

CREATE TABLE Director(
	id INT NOT NULL,
	last VARCHAR(20) NOT NULL,
	first VARCHAR(20) NOT NULL,
	dob DATE NOT NULL,
	dod DATE CHECK(dod IS NULL OR dod > dob),
	PRIMARY KEY(id)
) ENGINE = INNODB;
-- The date of death needs to be either NULL or after the date of birth
-- All directors have different id so it is the primary key

CREATE TABLE MovieGenre(
	mid INT NOT NULL,
	genre VARCHAR(20) NOT NULL,
	FOREIGN KEY(mid) REFERENCES Movie(id)
) ENGINE = INNODB;
-- A movie can have multiple genres but it shouldn't appear more than once with the same genre
-- The movie id needs to appear as an id in the Movie table

CREATE TABLE MovieDirector(
	mid INT NOT NULL,
	did INT NOT NULL,
	FOREIGN KEY(mid) REFERENCES Movie(id),
	FOREIGN KEY(did) REFERENCES Director(id)
) ENGINE = INNODB;
-- A director can be associated with multiple movies but he/she shouldn't appear more than once with the same movie
-- The movie id needs to appear as an id in the Movie table
-- The director id needs to appear as an id in the Director table

CREATE TABLE MovieActor(
	mid INT NOT NULL,
	aid INT NOT NULL,
	role VARCHAR(50),
	FOREIGN KEY(mid) REFERENCES Movie(id),
	FOREIGN KEY(aid) REFERENCES Actor(id)
) ENGINE = INNODB;
-- An actor can be in multiple movies but he/she shouldn't appear more than once with the same movie
-- The movie id needs to appear as an id in the Movie table
-- The actor id needs to appear as an id in the Actor table

CREATE TABLE Review(
	name VARCHAR(20) NOT NULL,
	time TIMESTAMP NOT NULL,
	mid INT NOT NULL,
	rating INT NOT NULL,
	comment VARCHAR(500),
	FOREIGN KEY(mid) REFERENCES Movie(id)
) ENGINE = INNODB;
-- The movie id needs to appear as an id in the Movie table

CREATE TABLE MaxPersonID(
	id INT NOT NULL
) ENGINE = INNODB;

CREATE TABLE MaxMovieID(
	id INT NOT NULL
) ENGINE  INNODB;