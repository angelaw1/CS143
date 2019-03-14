INSERT INTO Movie VALUES(272,"redundant",1997,"PG","Paramount");
/*p1:primary key constraint for Movie relation*/

INSERT INTO Movie VALUES(4751,"movie",6666,"PG","Paramount");
/*c1:year of movie > 2018*/

INSERT INTO Actor VALUES(1,"redundant","redundant","Female",1997,\N);
/*p2:primary key constraint for Actor*/

INSERT INTO Actor VALUES(69001,"new1","new1","Male",2017,2012);
/*c2:actor's dob > dod*/

INSERT INTO Director VALUES(37146,"redundant2","redundant2",1997,\N);
/*p3:primary key constraint for Director*/

INSERT INTO Director VALUES (69002,"new2","new2","Female",2017,2012);
/*c3:director's dob > dod*/

INSERT INTO MovieGenre VALUES (5000,"UNKNOWN");
/*f1:refer to a movie id that doesn't exist in Movie relation*/

INSERT INTO MovieDirector VALUES(5000,37146);
/*f2:refer to a movie that doesn't exist in Movie relation*/

INSERT INTO MovieDirector VALUES(272,70000); 
/*f3:refer to a director that doesn't exist in Director relation*/

INSERT INTO MovieActor VALUES(5000,1,"N/A");
/*f4:refer to a movie that doesn't exist in Movie relation*/

INSERT INTO MovieActor VALUES(272,70000,"N/A");
/*f5:reer to an actor that doesn't exist in Actor relation*/

INSERT INTO Review (mid) VALUES(5000);
/*f6:refer to a movie that doesn't exist in Movie relation*/
