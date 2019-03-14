
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>CS143 Project 1C</title>


    <style>
      body {
        font-family: "Lato", sans-serif;
      }
      table, th, td {
          border: 1px solid black;
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
          <h3><b> Movie Information Page</b></h3>
          <hr>

          <form class="form-group" action="#" method ="GET" id="usrform">
              <input type="hidden" id="search_input" class="form-control" name="identifier">
          </form>

          <?php
            if (isset($_GET['identifier'])) {
              $identifier = $_GET['identifier'];
              ?>
              <h4><b>Movie Information is:</b></h4>
              <?php
              $db = new mysqli('localhost', 'cs143', '', 'CS143');
              if(mysqli_connect_errno()){
                  printf("Connect failed: %s\n", mysqli_connect_error());
              }
              else if (($result = $db->query("SELECT * FROM Movie WHERE id = $identifier;")) == FALSE) {
                printf("Failed to access database <br>");
              }
              else {
                $row = $result->fetch_row();
                echo 'Title: ' . $row[1] . ' (' . $row[2] . ')<br>';
                echo 'Producer: ' . $row[4] . '<br>';
                echo 'MPAA Rating: ' . $row[3] . '<br>';

                echo 'Director: ';
                if (($director = $db->query("SELECT did FROM MovieDirector WHERE mid = $identifier;")) == FALSE) {
                  printf("Failed to access database <br>");
                }
                else {
                  $directorrow = $director->fetch_row();
                  if ($director->num_rows == 0) {
                    echo "Unknown";
                  }
                  else if (($directorinfo = $db->query("SELECT first, last FROM Director WHERE id = $directorrow[0];")) == FALSE) {
                    printf("Failed to access database <br>");
                  }
                  else {
                    $directorname = $directorinfo->fetch_row();
                    echo $directorname[0] . ' ' . $directorname[1];
                  }
                }
                echo '<br>';

                echo 'Genre: ';
                if (($genre = $db->query("SELECT genre FROM MovieGenre WHERE mid = $identifier;")) == FALSE) {
                  printf("Failed to access database <br>");
                }
                else {
                  while ($genrerow = $genre->fetch_row()) {
                    echo $genrerow[0] . ' ';
                  }
                }
                echo '<br>';
              }
              ?>

              <hr>
              <h4><b>Actors in this Movie:</b></h4>
              <?php

              if (($result = $db->query("SELECT * FROM MovieActor WHERE mid = $identifier;")) == FALSE) {
                printf("Failed to access database <br>");
              }
              else {
                $num_rows = $result->num_rows;
                echo '<table>';
                echo '<tr><th>Name</th><th>Role</th></tr>';
                if ($num_rows > 0) {
                  while ($row = $result->fetch_row()) {
                    if (($actor = $db->query("SELECT first, last, id FROM Actor WHERE id = $row[1];")) == FALSE) {
                      printf("Failed to access database <br>");
                    }
                    else {
                      $actorinfo = $actor->fetch_row();
                      echo '<tr><td><a href="actor_info.php?identifier=' . $actorinfo[2] . '">' . $actorinfo[0] . " " . $actorinfo[1] . '</td><td>' . $row[2] . '</td></tr>';
                    }
                  }
                }
                echo '</table>';
              }
              ?>

              <hr>
              <h4><b>User Reviews:</b></h4>
              <?php
              if (($result = $db->query("SELECT COUNT(*), AVG(rating) FROM Review WHERE mid = $identifier;")) == FALSE) {
                printf("Failed to access database <br>");
              }
              else {
                $rating = $result->fetch_row();
                if ($rating[0] == 0) {
                  echo '<a href="add_comment.php?MovieID=' . $identifier . '">No one has left a review. Be the first one to give a review!<br></a>';
                }
                else {
                  echo 'Average score for this movie is ' . $rating[1] . '/5 based on ' . $rating[0] . ' people\'s reviews<br>';
                  echo '<a href="add_comment.php?MovieID=' . $identifier . '">Leave your review as well!<br></a>';
                }
              }              
              
              ?>

              <hr>
              <h4><b>Comments:</b></h4>

              <?php
              if ($rating[0] == 0) {
                echo '<a href="add_comment.php?MovieID=' . $identifier . '">No comments yet. Leave one here!<br></a>';
              }
              else if (($result = $db->query("SELECT * FROM Review WHERE mid = $identifier;")) == FALSE) {
                printf("Failed to access database <br>");
              }
              else {
                while ($row = $result->fetch_row()) {
                  echo '<b>' . $row[0] . '</b> rates this movie with a score of <b>' . $row[3] . '/5</b><br>';
                  echo $row[1] . '<br>';
                  echo 'Comment:<br>' . $row[4] . '<br>';
                }
              }

              $result->close();
              $db->close();
              echo '<hr>';
            }

          ?>

          <label for="search_input">Search:</label>
          <form class="form-group" action="search.php" method ="GET" id="usrform">
              <input type="text" id="search_input"class="form-control" placeholder="Search..." name="result"><br>
              <input type="submit" name="submit" value="Click Me!" class="btn btn-default" style="margin-bottom:10px">
          </form>
        </div>
      </div>
    </div>
  

</body>
</html>
