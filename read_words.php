<?php require_once("includes/session.php"); ?>
<?php require_once("includes/db_connection.php"); ?>
<?php require_once("includes/functions.php"); ?>
<?php confirm_logged_in(); ?>
<?php 
$words_set = readAllWords(1,1);
  
$data="";
     
while($word =  mysqli_fetch_assoc($words_set)){
      
    $data .= '{';
        $data .= '"id":"'  . $word['id'] . '",';
        $data .= '"text":"' . $word['text'] . '",';
        $data .= '"description":"' . decode_string($word['description']) . '",';
        $data .= '"language":"' . $word['language'] . '"';
    $data .= '}'; 
      
    $data .= ','; 
}

$data = substr($data,0,-1);
 
// json format output 
echo '{"records":[' . $data . ']}'; 
?>
<?php require_once("includes/close_db.php"); ?>