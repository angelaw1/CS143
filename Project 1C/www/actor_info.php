
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
          <h3><b> Actor Information Page</b></h3>
          <hr>
          <form class="form-group" action="#" method ="GET" id="usrform">
              <input type="hidden" id="search_input" class="form-control" name="identifier">
          </form>

          <?php
            if (isset($_GET['identifier'])) {
              $identifier = $_GET['identifier'];
              ?>
              <h4><b>Actor Information is:</b></h4>
              <?php
              $db = new mysqli('localhost', 'cs143', '', 'CS143');
              if(mysqli_connect_errno()){
                  printf("Connect failed: %s\n", mysqli_connect_error());
              }
              if (($result = $db->query("SELECT * FROM Actor WHERE id = $identifier;")) == FALSE) {
                printf("Failed to access database <br>");
              }
              else {
                $row = $result->fetch_row();
                if ($row[5] == "") {
                  $dod = "Still Alive";
                }
                else {
                  $dod = $row[5];
                }
                echo '<table>';
                echo '<tr><th>Name</th><th>Sex</th><th>Date of Birth</th><th>Date of Death</th></tr>';
                if ($row[0] != "") {
                  echo '<tr><td>' . $row[2] . ' ' . $row[1] . '</td><td>' . $row[3] . '</td><td>' . $row[4] . '</td><td>' . $dod . '</td></td>';
                }
                echo '</table>';
              }
              ?>
              <hr>
              <h4><b>Actor's Movies and Role:</b></h4>
              <?php

              if (($result = $db->query("SELECT * FROM MovieActor WHERE aid = $identifier;")) == FALSE) {
                printf("Failed to access database <br>");
              }
              else {
                $num_rows = $result->num_rows;
                echo '<table>';
                echo '<tr><th>Role</th><th>Movie Title</th></tr>';
                if ($num_rows > 0) {
                  while ($row = $result->fetch_row()) {
                    if (($movie = $db->query("SELECT title, id FROM Movie WHERE id = $row[0];")) == FALSE) {
                      printf("Failed to access database <br>");
                    }
                    else {
                      $movietitle = $movie->fetch_row();
                      echo '<tr><td>' . $row[2] . '</td><td><a href="movie_info.php?identifier=' . $movietitle[1] . '">' . $movietitle[0] . '</td></tr>';
                    }
                  }
                }
                echo '</table>';
              }

              $result->close();
              $db->close();
              echo '<hr>';
            }

          ?>

          <label for="search_input">Search:</label>
          <form class="form-group" action="search.php" method ="GET" id="usrform">
              <input type="text" id="search_input" class="form-control" placeholder="Search..." name="result"><br>
              <input type="submit" name="submit" value="Click Me!" class="btn btn-default" style="margin-bottom:10px">
          </form>

        </div>
      </div>
    </div>
  

</body>
</html>
