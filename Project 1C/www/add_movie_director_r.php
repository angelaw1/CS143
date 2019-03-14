
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
          <h3><b>Add Director to Movie</b></h3>
          <hr>
          <form method = 'GET' action='#'>
            <div class="form-group">
              <label for="movieid">Movie Title</label>
              <select class="form-control" name='movieid'>
                <option value=NULL> </option>
                <?php
                  $db = new mysqli('localhost', 'cs143', '', 'CS143');
                  if(mysqli_connect_errno()){
                      printf("Connect failed: %s\n", mysqli_connect_error());
                  }
                  if (($result = $db->query("SELECT title, year, id FROM Movie;")) == FALSE) {
                    printf("Failed to access database <br>");
                  }
                  else {
                    while ($row = $result->fetch_row()) {
                      echo "<option value=" . $row[2] . ">" . $row[0] . " (" . $row[1] . ")</option>";
                    }
                  }
                  $result->close();
                  $db->close();
                ?>
              </select>
            </div>
            <br>

            <div class="form-group">
              <label for="directorid">Director</label>
              <select class="form-control" name='directorid'>
                <option value=NULL></option>
                <?php
                  $db = new mysqli('localhost', 'cs143', '', 'CS143');
                  if(mysqli_connect_errno()){
                      printf("Connect failed: %s\n", mysqli_connect_error());
                  }
                  if (($result = $db->query("SELECT first, last, dob, id FROM Director;")) == FALSE) {
                    printf("Failed to access database <br>");
                  }
                  else {
                    while ($row = $result->fetch_row()) {
                      echo "<option value=" . $row[3] . ">" . $row[0] . " " . $row[1] . " " . "(" . $row[2] . ")" . "</option>";
                    }
                  }
                  $result->close();
                  $db->close();
                ?>
              </select>
            </div>
            <br>

            <div class="form-group">
              <input type='submit' name='submit' class="btn btn-default" value='Click me!'>
            </div>

          </form>
        </div>
      </div>
    </div>

    <?php
      
      if (isset($_GET['submit'])) {
        $movieid = $_GET['movieid'];
        $directorid = $_GET['directorid'];

        $error = 0;

        if ($movieid == 'NULL') {
          echo "Please select a movie <br>";
          $error = 1;
        } 
        if ($directorid == 'NULL') {
          echo "Please select a director <br>";
          $error = 1;
        }

        if ($error == 1) {
          exit();
        }

        $db = new mysqli('localhost', 'cs143', '', 'CS143');
        if(mysqli_connect_errno()) {
          printf("Connect failed: %s\n", mysqli_connect_error());
        }
        else {
          $query = "INSERT INTO MovieDirector VALUES($movieid, $directorid);";
          if (($result = $db->query($query)) == FALSE) {
            printf("Error adding director to movie");
          }
          else {
            $result = $db->query("SELECT title FROM Movie WHERE id = $movieid;");
            $movie = $result->fetch_row();
            $result = $db->query("SELECT first, last FROM Director WHERE id = $directorid;");
            $actor = $result->fetch_row();
            echo "Added director " . $actor[0] . " " . $actor[1] . " to movie " . $movie[0] . "<br>";
          }
        }
        $result->close();
        $db->close();
      }

    ?>

  </body>
</html>