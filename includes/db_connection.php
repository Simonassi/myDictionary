<?php
  
	define("DB_SERVER", "localhost");
	define("DB_USER", "root");
	define("DB_PASS", "");
	define("DB_NAME", "my_dictionary");
  
  /*
  define("DB_SERVER", "sql8.freemysqlhosting.net");
	define("DB_USER", "sql8131377");
	define("DB_PASS", "1muFAizZQz");
	define("DB_NAME", "sql8131377");
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
