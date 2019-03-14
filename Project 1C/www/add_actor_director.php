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
            <h3><b>Add New Actor/Director</b></h3>
            <hr>
            <form method = "GET" action="#">
                <label class="radio-inline">
                    <input type="radio" checked="checked" name="identity" value="Actor"/>
                    Actor
                </label>
                <label class="radio-inline">
                    <input type="radio" name="identity" value="Director"/>Director
                </label>
                <div class="form-group">
                  <label for="first_name">First Name</label>
                  <input type="text" class="form-control" placeholder="Text input"  name="fname"/>
                </div>
                <div class="form-group">
                  <label for="last_name">Last Name</label>
                  <input type="text" class="form-control" placeholder="Text input" name="lname"/>
                </div>
                <label class="radio-inline">
                    <input type="radio" name="sex" checked="checked" value="male">Male
                </label>
                <label class="radio-inline">
                    <input type="radio" name="sex" value="female">Female
                </label>
                <div class="form-group">
                  <label for="DOB">Date of Birth</label>
                  <input type="text" class="form-control" placeholder="Text input" name="dateb">ie: 1997-05-05<br>
                </div>
                <div class="form-group">
                  <label for="DOD">Date of Die</label>
                  <input type="text" class="form-control" placeholder="Text input" name="dated">(leave blank if alive now)<br>
                </div>
                <button type="submit" name="submit" class="btn btn-default">Add!</button>
            </form>
        </div>
      </div>
    </div>

    <?php
      if (isset($_GET['submit'])) {
        function checkDateFormat($date) {
          $dateArr = explode('-', $date);
          return checkdate($dateArr[1], $dateArr[2], $dateArr[0]);
        }
  
        $identity = $_GET['identity'];
        $fname = trim($_GET['fname']);
        $lname = trim($_GET['lname']);
        $sex = $_GET['sex'];
        $dateb = $_GET['dateb'];
        $dated = $_GET['dated'];
  
        $error = 0;
  
  
        if ($fname == null || $fname == "" ) {
          printf("Please enter first name <br>");
          $error = 1;
        }
        if ($lname == null || $lname == "") {
          printf("Please enter last name <br>");
          $error = 1;
        }
        if (strlen($dateb) != 10 || !preg_match("/^[0-9][0-9][0-9][0-9]\-[0-9][0-9]\-[0-9][0-9]$/", $dateb) || !checkDateFormat($dateb)) {
          if (strlen($dateb) == 0) {
            printf("Please enter date of birth <br>");
          }
          else {
            printf("Date of birth is in wrong format <br>");
          }
          $error = 1;
        }
        if ($dated != null && $dated != "") {
          if (strlen($dated) != 10 || !preg_match("/^[0-9][0-9][0-9][0-9]\-[0-9][0-9]\-[0-9][0-9]$/", $dated) || !checkDateFormat($dated)) {
                printf("Date of death is in wrong format <br>");
                $error = 1;
          }
          if (strcmp($dated, $dateb) < 0) {
            printf("Date of death cannot be before date of birth <br>");
            $error = 1;
          }
        }
        if ($error) {
          exit();
        }
  
        $db = new mysqli('localhost', 'cs143', '', 'CS143');
        if(mysqli_connect_errno()){
            printf("Connect failed: %s\n", mysqli_connect_error());
        }
  
        else if (($result = $db->query("UPDATE MaxPersonID SET id = id + 1;")) == FALSE) {
          printf("Error Message: %s\n", $db->error);
          $result->close();
        }
  
        else if (($result = $db->query("SELECT id FROM MaxPersonID")) == FALSE) {
          printf("Error Message: %s\n", $db->error);
          $result->close();
        }
  
        else {
          $row = $result->fetch_row();
          $new_id = $row[0];
  
          if ($identity == 'Actor') {
            if ($dated == '')
              $query = "INSERT INTO Actor VALUES($new_id, '$lname', '$fname', '$sex', '$dateb', NULL);";
            else
              $query = "INSERT INTO Actor VALUES($new_id, '$lname', '$fname', '$sex', '$dateb', '$dated');";
          }
          else {
            if ($dated == '')
              $query = "INSERT INTO Director VALUES($new_id, '$lname', '$fname', '$dateb', NULL);";
            else
              $query = "INSERT INTO Director VALUES($new_id, '$lname', '$fname', '$dateb', '$dated');";
          }
  
          $result->close();
          if (($result = $db->query($query)) == FALSE) {
            echo $fname;
            printf($db->error);
          }
          else {
            echo "New " . $identity . " " . $fname. " " . $lname . " Added!";
          }
          $result->close();
        }
        $db->close();
      }

    ?>

  </body>
</html>
