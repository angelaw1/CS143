SELECT CONCAT(first,' ',last) 
FROM Actor,MovieActor 
WHERE id=MovieActor.aid And mid=(
	SELECT DISTINCT id 
	FROM Movie 
	WHERE title='Die Another Day');
/*The Movie id corresponding to the title 'Die Another Day' can be found by quering the Movie relation. Then we can use Movie Actor relation to obtain all IDs of actors who had a role in the corresponding movie ID. Finally we use Actor relation to find out the first and last name of the actors corresponding to the actor IDs.*/

SELECT COUNT(*) 
FROM (
	SELECT aid,count
	FROM (
		SELECT aid,COUNT(*) AS count 
		FROM MovieActor 
		GROUP BY aid) AS a1 
	WHERE count>1) AS a2;

/*First we count the number of movies played by each Actor using the MovieActor relation. Then we only select the rows with count > 1. Finally we count the total number of rows.*/

SELECT title FROM Movie WHERE year=1997;
/*Show titles of all movies made in year 1997.*/


