<?php require_once("../includes/init.php"); ?>
<?php confirm_logged_in(); ?>
<?php echo pagination( $_POST['token']); ?>
<?php require_once("../includes/close_db.php"); ?>