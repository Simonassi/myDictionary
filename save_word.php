<?php require_once("includes/session.php"); ?>
<?php require_once("includes/db_connection.php"); ?>
<?php require_once("includes/functions.php"); ?>
<?php confirm_logged_in(); ?>
<?php
$data = json_decode(file_get_contents("php://input"));
$dictionary_id = $data->dictionary_id;
$language_id   = $data->language_id;
$text          = $data->text ;
$description   = $data->description;

$id = saveWord($dictionary_id, $language_id, $text, $description);

if($id > 0){
	$arr = array('text' => $text, 'description' => $description, 'msg' => 'Word saved!', 'error' => '');
}else{
	$arr = array( 'msg' => '', 'error' => 'An error occurred. Please try to reload and try again later. Sorry for the inconvenience.');
}
$jsn = json_encode($arr);
print_r($jsn);
?>
<?php require_once("includes/close_db.php"); ?>