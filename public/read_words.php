<?php require_once("../includes/init.php"); ?>
<?php confirm_logged_in(); ?>
<?php 

$page = isset($_GET['page']) ? $_GET['page'] : 1;
$words_set = readAllWords(1,1, $page);

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