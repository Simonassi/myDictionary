<?php require_once("../includes/init.php"); ?>
<?php confirm_logged_in(); ?>
<?php
$data = json_decode(file_get_contents("php://input"));

$user_id   = $data->id;
$user_name = $data->user_name;

$token = getToken($user_id, $user_name);

if(!empty($token)){
	$arr = array('token' => $token, 'msg' => 'Success', 'error' => '');
}else{
	$arr = array( 'msg' => '', 'error' => 'An error occurred. Please try to reload and try again later. Sorry for the inconvenience.');
}
$jsn = json_encode($arr);
print_r($jsn);
?>
<?php require_once("../includes/close_db.php"); ?>