<?php
	function redirect_to($new_location) {
	  header("Location: " . $new_location);
	  exit;
	}

    function logout(){
        session_destroy();
        redirect_to("index.php");
    }

	function mysql_prep($string) {
		global $connection;
		
		$escaped_string = mysqli_real_escape_string($connection, $string);
        $escaped_string = utf8_encode($escaped_string);
		return $escaped_string;
	}
	
	function confirm_query($result_set) {
		if (!$result_set) {
			die("Database query failed.");
		}
	}
	
    function decode_string($str){
        return html_entity_decode(utf8_decode($str));
    }

    function readAllWords($dictionary_id, $user_id, $page){
 
        global $connection;
        
        $dictionary_id = (int) $dictionary_id;
        $user_id       = (int) $user_id;
        $page          = (int) $page;

        $row_count = 10;
        $offset = ($page - 1)*$row_count;
        

        $query  = "SELECT w.id, w.text, w.description, l.language ";
        $query .= "FROM words w ";
        $query .= "JOIN languages l ON l.id = w.language_id ";
        $query .= "JOIN dictionary d ON d.id = w.dictionary_id ";
        $query .= "WHERE d.id = {$dictionary_id} ";
        $query .= "AND d.user_id = {$user_id} ";
        $query .= "ORDER BY w.text ASC ";
        //$query .= "LIMIT {$offset}, {$row_count}";
        
        $words_set = mysqli_query($connection, $query);
        confirm_query($words_set);
        
        return $words_set;
    }
	
    function saveWord($dictionary_id, $language_id, $text, $description){
        global $connection;
		
        $dictionary_id = (int) $dictionary_id;
        $language_id   = (int) $language_id;
        $text          = mysql_prep($text);
        $description   = mysql_prep($description);
        
		$query  = "INSERT INTO words ";
		$query .= "(dictionary_id, language_id, text, description) ";
		$query .= "VALUES ";
        $query .= "('$dictionary_id', '$language_id', '$text', '$description')";
        
		mysqli_query($connection, $query);
        $id = mysqli_insert_id($connection);
        
        return $id;
    }
    
    /*
    function find_user_by_id($user_id){
        global $connection;
		
        $user_id = (int) $user_id;
        
		$query  = "SELECT * ";
		$query .= "FROM users ";
		$query .= "WHERE id = {$user_id} ";
        $query .= "LIMIT 1";
        
		$user = mysqli_query($connection, $query);
		confirm_query($user);
        
        if($user = mysqli_fetch_assoc($user)){
            return $user;
        }else{
            return null;   
        }
    }
    */
	function logged_in() {
		return isset($_SESSION['user_id']);
	}
	
	function confirm_logged_in() {
		if (!logged_in()) {
			redirect_to("index.php");
		}
	}
    
    function has_presence($value) {
	   return isset($value) && $value !== "";
    }

    /*
    function question_is_invalid($question_id){
        global $connection;
		
        $question_id = (int) $question_id;
        
		$query  = "SELECT * ";
		$query .= "FROM questions ";
		$query .= "WHERE id = {$question_id} ";
        $query .= "AND used = 1 ";
        $query .= "LIMIT 1";
        
		$question = mysqli_query($connection, $query);
		confirm_query($question);
        
        return mysqli_num_rows($question);
    }
    */
    function validate_presences($required_fields) {
        $errors = 0;
        foreach($required_fields as $field) {
            $value = trim($_POST[$field]);
            if (!has_presence($value)) {
                $errors++;
            }
            return $errors;
        }
    }
?>