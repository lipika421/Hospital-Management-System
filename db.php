<?php
    define('DB_NAME', 'HMS');
    define('DB_USER', 'root');
    define('DB_PASSWORD', '');
    define('DB_HOST', 'localhost');

	$mysqli=mysqli_connect(DB_HOST,DB_USER,DB_PASSWORD,DB_NAME);

	if (mysqli_connect_errno())
	{
		die("Could not connect to database.");
	}
?>