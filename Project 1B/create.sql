CREATE TABLE Movie(
	id INT, 
	title VARCHAR(100), 
	year INT, 
	rating VARCHAR(10), 
	company VARCHAR(50),
	PRIMARY KEY(id),
	CHECK(year BETWEEN 0 AND 2018)
) ENGINE=INNODB;
/*p1:Each movie should have a unique id. So id is the primary key here.
c1:The year should be nonnegative and at most 2018.*/

CREATE TABLE Actor(
	id INT, 
	last VARCHAR(20), 
	first VARCHAR(20), 
	sex VARCHAR(6),
	dob DATE, 
	dod DATE,
	PRIMARY KEY(id),
	CHECK(dod IS NULL OR dod>dob)
) ENGINE=INNODB;
/*p2:Each Actor has unique id. So id is the primary key.
c2:Date of Death should be after Date of Birth.*/

CREATE TABLE Director(
	id INT, 
	last VARCHAR(20), 
	first VARCHAR(20), 
	dob DATE, 
	dod DATE,
	PRIMARY KEY(id),
	CHECK(dod IS NULL OR dod>dob)
) ENGINE=INNODB;
/*p3:Each Director has unique id. So id is the primary key.
c3:Date of Death should be after Date of Birth.*/

CREATE TABLE MovieGenre(
	mid INT, 
	genre VARCHAR(20),
	FOREIGN KEY(mid) references Movie(id)
) ENGINE=INNODB;
/*f1:Movie id here should exist in Movie relation.*/

CREATE TABLE MovieDirector(
	mid iNT, 
	did INT,
	FOREIGN KEY(mid) references Movie(id), 
	FOREIGN KEY(did) references Director(id)
) ENGINE=INNODB;
/*f2:Movie id here should exist in Movie relation.
f3:Director id here should exist in Director relation.*/

CREATE TABLE MovieActor(
	mid INT, 
	aid INT, 
	role VARCHAR(50),
	FOREIGN KEY(mid) references Movie(id), 
	FOREIGN KEY(aid) references Actor(id)
) ENGINE=INNODB;
/*f4:Movie id here should exist in Movie relation.
f5:Actor id here should exist in Actor relation.*/

CREATE TABLE Review(
	name VARCHAR(20), 
	time TIMESTAMP, 
	mid INT, 
	rating INT, 
	comment VARCHAR(500),
	FOREIGN KEY(mid) references Movie(id)
) ENGINE=INNODB;
/*f6:Movie id here should exist in Movie relation.*/

CREATE TABLE MaxPersonID(id INT) ENGINE=INNODB;
CREATE TABLE MaxMovieID(id INT) ENGINE=INNODB;
