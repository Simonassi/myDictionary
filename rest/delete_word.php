<?php require_once("../includes/init.php"); ?>
<?php confirm_logged_in(); ?>
<?php
$data = json_decode(file_get_contents("php://input"));

$token = $data->token;
$id = deleteWord($data->word_id, $_SESSION['dictionary_id'], $token);

if($id > 0){
	$arr = array( 'msg' => 'Word deleted!', 'error' => '');
}else{
	$arr = array( 'msg' => '', 'error' => 'An error occurred. Please try to reload and try again later. Sorry for the inconvenience.');
}
$jsn = json_encode($arr);
print_r($jsn);
?>
<?php require_once("../includes/close_db.php"); ?>