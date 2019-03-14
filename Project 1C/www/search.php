
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
          <h3><b>Searching Page</b></h3>
          <hr>
          <label for="search_input">Search:</label>
          <form class="form-group" method ="GET" id="usrform">
              <input type="text" id="search_input"class="form-control" placeholder="Search..." name="result"><br>
              <input type="submit" name="submit" value="Click Me!"class="btn btn-default" style="margin-bottom:10px">
          </form>
          <!--php query start from here -->

          <?php
            $db_error = 0;
            if (isset($_GET['result'])) {
              ?><h4><b>Matching Actors are:</b></h4><?php
              $db = new mysqli('localhost', 'cs143', '', 'CS143');
              if(mysqli_connect_errno()) {
                $db_error = 1;
                printf("Connect failed: %s\n", mysqli_connect_error());
              }
              else {
                $search = $_GET['result'];
                $search_arr = explode(" ", $search);
                if (count($search_arr) == 2) {
                  $query = "SELECT * FROM Actor WHERE (first LIKE '%$search_arr[0]%' AND last LIKE '%$search_arr[1]%') OR (first LIKE '%$search_arr[1]%' AND last LIKE '%$search_arr[0]%');";
                }
                else if (count($search_arr) == 1) {
                   $query = "SELECT * FROM Actor WHERE first LIKE '%$search_arr[0]%' OR last LIKE '%$search_arr[0]%';";
                }
                if (count($search_arr) <= 2) {
                  if (($actor = $db->query($query)) == FALSE) {
                    printf("Failed to access database <br>");
                  }
                  else {
                    echo 'Total Results: ' . $actor->num_rows . '<br>';
                    echo '<table>';
                    echo '<tr><th>Name</th><th>Date of Birth</th></tr>';
                    while ($actorinfo = $actor->fetch_row()) {
                      echo '<tr><td><a href="actor_info.php?identifier=' . $actorinfo[0] . '">' . $actorinfo[2] . ' ' . $actorinfo[1] . '</td><td>' . $actorinfo[4] . '</td></tr>';
                    }

                    echo '</table>';
                  }
                }
                else {
                  echo 'Total Results: 0<br>';
                  echo '<table>';
                  echo '<tr><th>Name</th><th>Date of Birth</th></tr>';
                  echo '</table>';
                }
              }

          ?>

          <br> <hr> <br>
          <h4><b>Matching Movie are:</b></h4>

          <?php
              if (!$db_error) {
                $query = "SELECT id,title,year FROM Movie WHERE title LIKE '%$search_arr[0]%'";
                for ($i=1;$i<count($search_arr);$i++){
                  $query = $query."AND title LIKE '%$search_arr[$i]%'";
                }
                $query.=";";
                if (($movie = $db->query($query)) == FALSE) {
                  printf("Failed to access database <br>");
                }
                else {
                  echo 'Total Results: ' . $movie->num_rows . '<br>';
                  echo '<table>';
                  echo '<tr><th>Title</th><th>Year</th></tr>';
                  while ($movieinfo = $movie->fetch_row()) {
                    echo '<tr><td><a href="movie_info.php?identifier=' . $movieinfo[0] . '">' . $movieinfo[1] . '</td><td>' . $movieinfo[2] . '</td></tr>';
                  }

                  echo '</table>';
                }

              }

            }

          ?>
          <!--php query end from here -->
        </div>
      </div>
    </div>
  

</body>
</html>
