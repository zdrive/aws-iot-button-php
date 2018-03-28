<?php

/**
 * Settings for AWS IoT Button to PHP demo
 * 
 */

	$AWSbuttonSN = 'A123BC456789DEFG';  // AWS IoT Button serial number

	$dbHost = 'localhost';  // MySQL database host name or IP address
	$dbName = 'iotDB';  // MySQL database name
	$dbUsername = 'user';  // MySQL database user with read/write priveleges to the database defined above
	$dbPassword = 'password';  // Password for MySQL database user defined above

	$dbPort = ini_get("mysqli.default_port"); 
	$dbSocket = ini_get("mysqli.default_socket"); 

/* End of file _settings.php */
?>