<?php require_once("../includes/init.php"); ?>
<?php confirm_logged_in(); ?>
<?php 
$data = json_decode(file_get_contents("php://input"));

$token = $data->token;

$words_set = readAllWords($_SESSION["dictionary_id"], $_SESSION["user_id"], $token);

$data="";

while($word =  mysqli_fetch_assoc($words_set)){
      
    $data .= '{';
        $data .= '"id":"'  . $word['id'] . '",';
        $data .= '"text":"' . decode_string($word['text']) . '",';
        $data .= '"description":"' . decode_string($word['description']) . '",';
        $data .= '"language":"' . $word['language'] . '"';
    $data .= '}'; 
      
    $data .= ','; 
}

$data = substr($data,0,-1);
 
// json format output 
echo '{"records":[' . $data . ']}'; 
?>
<?php require_once("../includes/close_db.php"); ?>