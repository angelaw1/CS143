<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <title>CS143 Project 1C</title>

    <!-- Bootstrap
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/project1c.css" rel="stylesheet"> -->

    <style>
      body {
        font-family: "Lato", sans-serif;
      }
      ul {
        list-style-type: none;
      }
    </style>

  </head>
  <body>

    <nav class="navbar navbar-inverse navbar-fixed-top">
      <div class="container-fluid">
        <div class="navbar-header navbar-defalt">
          <a class="navbar-brand" href="index.php">CS143 DataBase Query System <br /></a>
        </div>
      </div>
    </nav>

    <div class="container">
      <div class="row">
        <div class="col-sm-3 col-md-2 sidebar"; style="background-color:lightgray; width:300px; float:left;">
          <ul class="nav nav-sidebar">
            <p>&nbsp;&nbsp;Add New Content</p>
            <li><a href="add_actor_director.php">Add Actor/Director</a></li>
            <li><a href="add_movie.php">Add Movie Information</a></li>
            <li><a href="add_comment.php">Add Comment</a></li>
            <li><a href="add_movie_actor_r.php">Add Movie/Actor Relation</a></li>
            <li><a href="add_movie_director_r.php">Add Movie/Director Relation</a></li>
          </ul>
          <ul class="nav nav-sidebar">
            <p>&nbsp;&nbsp;Browse Content</p>
            <li><a href="actor_info.php">Show Actor Information</a></li>
            <li><a href="movie_info.php">Show Movie Information</a></li>
          </ul>
          <ul class="nav nav-sidebar">
            <p>&nbsp;&nbsp;Search Interface</p>
            <li><a href="search.php">Search Actor/Movie</a></li>
          </ul>
        </div>
        <div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
            <h3><b>Add New Movie</b></h3>
            <hr>
            <form method="GET" action="#">
                <div class="form-group">
                  <label for="title">Title</label>
                  <input type="text" class="form-control" placeholder="Text input" name="title">
                </div>
                <div class="form-group">
                  <label for="company">Company</label>
                  <input type="text" class="form-control" placeholder="Text input" name="company">
                </div>
                <div class="form-group">
                  <label for="year">Year</label>
                  <input type="text" class="form-control" placeholder="Text input" name="year">
                </div>
                <div class="form-group">
                    <label for="rating">MPAA Rating</label>
                    <select   class="form-control" name="rate">
                        <option value="G">G</option>
                        <option value="NC-17">NC-17</option>
                        <option value="PG">PG</option>
                        <option value="PG-13">PG-13</option>
                        <option value="R">R</option>
                        <option value="surrendere">surrendere</option>
                    </select>
                </div>
                <div class="form-group">
                    <label >Genre</label>
                    <input type="checkbox" name="genre[]" value="Action">Action</input>
                    <input type="checkbox" name="genre[]" value="Adult">Adult</input>
                    <input type="checkbox" name="genre[]" value="Adventure">Adventure</input>
                    <input type="checkbox" name="genre[]" value="Animation">Animation</input>
                    <input type="checkbox" name="genre[]" value="Comedy">Comedy</input>
                    <input type="checkbox" name="genre[]" value="Crime">Crime</input>
                    <input type="checkbox" name="genre[]" value="Documentary">Documentary</input>
                    <input type="checkbox" name="genre[]" value="Drama">Drama</input>
                    <input type="checkbox" name="genre[]" value="Family">Family</input>
                    <input type="checkbox" name="genre[]" value="Fantasy">Fantasy</input>
                    <input type="checkbox" name="genre[]" value="Horror">Horror</input>
                    <input type="checkbox" name="genre[]" value="Musical">Musical</input>
                    <input type="checkbox" name="genre[]" value="Mystery">Mystery</input>
                    <input type="checkbox" name="genre[]" value="Romance">Romance</input>
                    <input type="checkbox" name="genre[]" value="Sci-Fi">Sci-Fi</input>
                    <input type="checkbox" name="genre[]" value="Short">Short</input>
                    <input type="checkbox" name="genre[]" value="Thriller">Thriller</input>
                    <input type="checkbox" name="genre[]" value="War">War</input>
                    <input type="checkbox" name="genre[]" value="Western">Western</input>
                </div>
                <button type="submit" name="submit" class="btn btn-default">Add!</button>
            </form>
        </div>
      </div>
    </div>

    <?php

      if (isset($_GET['submit'])) {

          $title = $_GET['title'];
          $company = $_GET['company'];
          $year = $_GET['year'];
          $rate = $_GET['rate'];
          $genre = $_GET['genre'];

          $error = 0;

          if ($title == null || $title == "") {
            printf("Please enter movie title <br>");
            $error = 1;
          }
          if ($company == null || $company == "") {
            printf("Please enter company name <br>");
            $error = 1;
          }
          if ($year == null || $year == "") {
            printf("Please enter year <br>");
            $error = 1;
          }
          else if (strlen($year) != 4 || !preg_match("/^([0-9])+$/", $year)) {
            printf("Cannot have year %s<br>", $year);
            $error = 1;
          }
          if ($error) {
            exit();
          }

          $db = new mysqli('localhost', 'cs143', '', 'CS143');
          if(mysqli_connect_errno()){
              printf("Connect failed: %s\n", mysqli_connect_error());
          }
    
          else if (($result = $db->query("UPDATE MaxMovieID SET id = id + 1;")) == FALSE) {
            printf("Error Message: %s\n", $db->error);
            $result->close();
          }
    
          else if (($result = $db->query("SELECT id FROM MaxMovieID")) == FALSE) {
            printf("Error Message: %s\n", $db->error);
            $result->close();
          }

          else {
            $row = $result->fetch_row();
            $new_id = $row[0];

            $result->close();
            $query = "INSERT INTO Movie VALUES($new_id, '$title', $year, '$rate', '$company');";
            if (($result = $db->query($query)) == FALSE) {
              printf($db->error);
            }
            else {
              echo "New movie " . $title . " Added! <br>";
              foreach($genre as &$value) {
                $query = "INSERT INTO MovieGenre VALUES($new_id, '$value');";
                if (($result = $db->query($query)) == FALSE) {
                  printf("Error associating the movie %s with the genre %s <br>", $title, $value);
                }
                else {
                  echo "Added movie " . $title . " to genre " . $value . "<br>";
                }
              }
            }
            $result->close();
          }
          $db->close();
      }

    ?>
  
</body>
</html>