<?php require_once("../includes/init.php"); ?>
<?php confirm_logged_in(); ?>
<?php
$data = json_decode(file_get_contents("php://input"));

$dictionary_id = $_SESSION['dictionary_id'];
$language_id   = $data->language_id;
$text          = $data->text;
$description   = $data->description;
$token         = $data->token;

if(!wordExists($dictionary_id, $language_id, $text)){	

	$id = saveWord($dictionary_id, $language_id, $text, $description, $token);

	if($id > 0){
		$arr = array('text' => $text, 'description' => $description, 'msg' => 'Word saved!', 'error' => '', 'id' => $id);
	}else{
		$arr = array( 'msg' => '', 'error' => 'An error occurred. Please try to reload and try again later. Sorry for the inconvenience.');
	}
}else{
	$arr = array( 'msg' => '', 'warning' => 'Word already registred!');
}
$jsn = json_encode($arr);
print_r($jsn);
?>
<?php require_once("../includes/close_db.php"); ?>