<?php require_once("../includes/init.php"); ?>
<?php
$error_message = "Invalid email or password. Try again.";;

if (isset($_POST['submit'])) {
    $required_fields = array("email", "password");
    
    if(validate_presences($required_fields)){
        $_SESSION["error"] = $error_message;
        redirect_to("index.php");
    }
    
    $email    = $_POST["email"];
    $password = $_POST["password"];

    $user = attempt_login($email, $password);
        
    if($user){
        $_SESSION["user_id"] = $user["id"];
        $_SESSION["dictionary_id"] = 1;

        $token = save_token($_SESSION["user_id"]);

        setcookie("xUt", $token, time() + 3600*24);
        
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
<?php require_once("../includes/close_db.php"); ?>