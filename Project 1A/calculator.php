<html>
<head><title>Calculator</title></head>
<body>

<h1>Calculator</h1>
Type an expression in the following box (e.g., 10.5+20*3/25).
<form action="calculator.php" method="GET">
        <input type="text" name="expr">
        <input type="submit" value="Calculate">
</form>

<?php
	$invalid_msg = "Invalid Expression!";
	$zero_div_msg = "Division by zero error!";
	$expr = $_GET["expr"];

	$new_expr = str_replace(" ", "", $expr);
	$new_expr = str_replace("+-", "-", $new_expr);
	$new_expr = str_replace("--", "+", $new_expr);

	$valid_expr = preg_match("/^(\-?[0-9]+(\.[0-9]+)?[\+\-\*\/])*(\-?[0-9]+(\.[0-9]+)?)$/", $new_expr);
	$zero_div = preg_match("/^(\-?[0-9]+(\.[0-9]+)?[\+\-\*\/])*(\-?[0-9]+(\.[0-9]+)?)\/0([\+\-\*\/](\-?[0-9]+(\.[0-9]+)?))*$/", $new_expr);
	$dots = preg_match("/^\.+$/", $expr);
	$spaces = ($new_expr == "" and $expr != "");

	if ($dots or $spaces) {		?>
		<h2>Result</h2>
		<?php
		echo $invalid_msg;
	} elseif ($expr != "") {	?>
		<h2>Result</h2>
		<?php

		if ($valid_expr) {
			$valid = @eval("\$result = $new_expr;");
			if ($zero_div) {
				echo $zero_div_msg;
			} elseif ($valid === FALSE) {
				echo $invalid_msg;
			} else {
				echo $expr." = ".$result;
			}
		} else {
			echo $invalid_msg;
		}
	}
?>