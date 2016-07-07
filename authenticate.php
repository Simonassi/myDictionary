<?php require_once("includes/session.php"); ?>
<?php require_once("includes/db_connection.php"); ?>
<?php require_once("includes/functions.php"); ?>
<?php
$error_message = "Invalid email or password. Try again.";;

if (isset($_POST['submit'])) {
    $required_fields = array("email", "password");
    
    if(validate_presences($required_fields)){
        $_SESSION["error"] = $error_message;
        redirect_to("index.php");
    }
    
    $email = mysql_prep($_POST["email"]);
    $password = mysql_prep($_POST["password"]);
    
    $query  = "SELECT * ";
	$query .= "FROM users ";
	$query .= "WHERE ";
    $query .= "email= '{$email}' ";
    $query .= "AND password = '{$password}' ";
    $query .= "AND actived = 1 ";
    $query .= "AND email_confirmed = 1 ";
    $query .= "LIMIT 1";
        
	$user = mysqli_query($connection, $query);
	confirm_query($user);
        
    if($user = mysqli_fetch_assoc($user)){
        $_SESSION["user_id"] = $user["id"];
        redirect_to("main.php");
    }else{
        $_SESSION["error"] = $error_message;
        redirect_to("index.php");   
    }
} else {
    $_SESSION["error"] = $error_message;
    redirect_to("index.php");
}
?>
<?php require_once("includes/close_db.php"); ?>