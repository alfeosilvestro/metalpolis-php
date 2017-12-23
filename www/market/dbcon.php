<?php
    $database = "metalpolis_database";  // the name of the database.
    $server = "127.0.0.1";  // server to connect to.
    $db_user = "metal_dbuser";  // mysql username to access the database with.
    $db_pass = "vackertech2018";  // mysql password to access the database with.

	$conn = mysqli_connect($server, $db_user, $db_pass ,$database);
   if (mysqli_connect_errno())
	{
		echo "Failed to connect to MySQL: " . mysqli_connect_error();
	}
?>
