<?php
    
	define("DB_SERVER", "localhost");
	define("DB_USER", "root");
	define("DB_PASS", "");
	define("DB_NAME", "my_dictionary");
    
    
    /*
    define("DB_SERVER", "mysql.hostinger.com.br");
	define("DB_USER", "u634392222_rsa");
	define("DB_PASS", "15263897");
	define("DB_NAME", "u634392222_sql");
    */
    
  // 1. Create a database connection
  $connection = mysqli_connect(DB_SERVER, DB_USER, DB_PASS, DB_NAME);
  // Test if connection succeeded
  if(mysqli_connect_errno()) {
    die("Database connection failed: " . 
         mysqli_connect_error() . 
         " (" . mysqli_connect_errno() . ")"
    );
  }
?>
