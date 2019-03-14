<?php
if (isset($_GET['MovieID'])) {
    $mid = $_GET['MovieID'];
}
?>

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
          <form method="GET" id="userform">
            <h3><b>Add New Comment Here</b></h3> 
            <hr>
            <div class="form-group">
              <label for="ID">Movie Title</label>
              <select  name="MovieID" id="ID">
                  <?php
                    if (isset($_GET['MovieID']) && $_GET['MovieID'] != 'NULL') { ?>
                      <option value=<?php echo $mid ?>>
                      <?php
                      $db = new mysqli('localhost', 'cs143', '', 'CS143');
                      if(mysqli_connect_errno()){
                          printf("Connect failed: %s\n", mysqli_connect_error());
                      }
                      if (($result = $db->query("SELECT title, year FROM Movie WHERE id = $mid;")) == FALSE) {
                        printf("Failed to access database <br>");
                      }
                      else {
                        while ($row = $result->fetch_row()) {
                          echo $row[0] . " (" . $row[1] . ") <br>";
                        }
                      }
                      if (($result = $db->query("SELECT title, year, id FROM Movie WHERE id <> $mid;")) == FALSE) {
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
                      </option> <?php
                    }
                    else { ?> 
                      <option value=NULL></option>
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
                    }
                ?>
              </select>
            </div>
            <div class="form-group">
              <label for="title">Your Name</label>
              <input type="text" name="viewer"class="form-control" value="Mr. Anonymous" id="title">
            </div>
            <div class="form-group">
              <label for="rating">Rating</label>
              <select  class="form-control" name="score" id="rating">
                <option value="1">1</option>
                <option value="2">2</option>
                <option value="3">3</option>
                <option value="4">4</option>
                <option value="5">5</option>
              </select>
            </div>
            <div class="form-group">
              <textarea class="form-control" name="comment" cols="80" rows="8" placeholder="Type comment here..."></textarea><br> 
            </div>
            <button type="submit" name="submit" class="btn btn-default">Rating it!</button>
          </form>
        </div>
      </div>
    </div>
  
    <?php
      if (isset($_GET['submit'])) {
        $name = $_GET['viewer'];
        $rating = $_GET['score'];
        $comment = $_GET['comment'];

        $error = 0;

        if (strlen(trim($name)) == 0) {
          $name = "Mr.Anonymous";
        }
        else if (strlen($name) > 20) {
          echo "Please enter shorter name <br>";
          $error = 1;
        }
        if ($_GET['MovieID'] == 'NULL') {
          echo "Please select movie <br>";
          $error = 1;
        }
        if (strlen(trim($comment)) == 0) {
          echo "Please enter comment <br>";
          $error = 1;
        }
        else if (strlen($comment) > 500) {
          echo "Please limit comment to 500 characters <br>";
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
          $query = "INSERT INTO Review VALUES('$name', (SELECT NOW()), $mid, $rating, '$comment');";
          if (($result = $db->query($query)) == FALSE) {
            printf("Failed to access database <br>");
          }
          else {
            echo "Comment Added <br>";
          }
        }

        $db->close();

      }
    ?>

</body>
</html>
