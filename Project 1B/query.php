<?php
if (isset($_GET['query'])) {
    $q = $_GET['query'];
}
?>

<html>
<head>
    <title>CS143 Project 1B</title>
    <style>
        table, th, td {
            border: 1px solid black;
        }
    </style>
</head>
<body>

<h1>Movie Database</h1>
Type an SQL query in the following box: 
<p>
Example: <tt>SELECT * FROM Actor WHERE id=10;</tt><br />
<p>
<form action="" method="GET">
<textarea name="query" cols="60" rows="8">
<?php echo $q; ?>
</textarea><br />
<input type="submit" value="Submit" />
</form>
</p>

<?php
	$query = $_GET['query'];
	if (!empty($query)) {

		$db = new mysqli('localhost', 'cs143', '', 'CS143');

        if(mysqli_connect_errno()){
            printf("Connect failed: %s\n", mysqli_connect_error());
            exit();
        }
        
        if ($result = $db->query($query)) {
            $num_rows = $result->num_rows; ?>
            <h3>Results from MySQL:</h3>
            <?php
            echo 'Total results: ' . $num_rows . '<br>';
            $finfo = $result->fetch_fields();
            echo '<table>';
            echo '<tr>';
            foreach($finfo as $val) {
                echo '<th align="center">' . $val->name . '</th>';
            }
            echo '</tr>';
            if ($num_rows > 0){
                while ($row = $result->fetch_row()) {
                    echo '<tr>';
                    for ($x = 0; $x != count($row); $x++) {
                        if ($row[$x] == "") {
                            echo '<td> N/A </td>';
                        }
                        else {
                            echo '<td>' . $row[$x] . '</td>';
                        }
                    }
                    echo '</tr>';
                }
                echo '</table>';
            }
    
            $result->close();
        }
    	$db->close();
	}
?>


</body>
</html>