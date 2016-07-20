<?php
	function redirect_to($new_location) {
	  header("Location: " . $new_location);
	  exit;
	}

    function logout(){
        session_destroy();
        setcookie("xUt", null, time() - 3600);
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

	function logged_in() {
		return isset($_SESSION['user_id']);
	}
	
	function confirm_logged_in() {
		if (!logged_in()) {
			redirect_to("index.php");
		}
	}
    
    function redirect_to_main() {
        if (logged_in()) {
            redirect_to("main.php");
        }
    }

    function has_presence($value) {
	   return isset($value) && $value !== "";
    }

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

    function password_encrypt($password) {
        $hash_format = "$2y$10$";   // Tells PHP to use Blowfish with a "cost" of 10
        $salt_length = 22;                    // Blowfish salts should be 22-characters or more
        $salt = generate_salt($salt_length);
        $format_and_salt = $hash_format . $salt;
        $hash = crypt($password, $format_and_salt);
        return $hash;
    }
    
    function generate_salt($length) {
        // Not 100% unique, not 100% random, but good enough for a salt
        // MD5 returns 32 characters
        $unique_random_string = md5(uniqid(mt_rand(), true));
      
        // Valid characters for a salt are [a-zA-Z0-9./]
        $base64_string = base64_encode($unique_random_string);
      
        // But not '+' which is valid in base64 encoding
        $modified_base64_string = str_replace('+', '.', $base64_string);
      
        // Truncate string to the correct length
        $salt = substr($modified_base64_string, 0, $length);
      
        return $salt;
    }

    function create_user($username, $password){
        global $connection;

        $username = mysql_prep($username);
        $hashed_password = password_encrypt($password);
    
        $query  = "INSERT INTO users (";
        $query .= "  email, password";
        $query .= ") VALUES (";
        $query .= "  '{$username}', '{$hashed_password}'";
        $query .= ")";
        
        return mysqli_query($connection, $query);
    }

    function attempt_login($username, $password) {
        $user = find_user_by_username($username);
        if ($user) {
            if (password_check($password, $user["password"])) {
                return $user;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }

    function find_user_by_username($username) {
        global $connection;
        
        $safe_username = mysqli_real_escape_string($connection, $username);

        $query  = "SELECT * ";
        $query .= "FROM users ";
        $query .= "WHERE ";
        $query .= "email= '{$safe_username}' ";
        $query .= "AND actived = 1 ";
        $query .= "AND email_confirmed = 1 ";
        $query .= "LIMIT 1";

        $user_set = mysqli_query($connection, $query);
        confirm_query($user_set);
        if($user = mysqli_fetch_assoc($user_set)) {
            return $user;
        } else {
            return null;
        }
    }

    function password_check($password, $existing_hash) {
        $hash = crypt($password, $existing_hash);
        if ($hash === $existing_hash) {
            return true;
        } else {
            return false;
          }
    }

    function save_token($id){
        global $connection;

        $id = (int) $id;

        $token = generateToken();

        $query  = "UPDATE users ";
        $query .= " SET ";
        $query .= " token = '{$token}' ";
        $query .= " WHERE ";
        $query .= " id = '{$id}'";

        $result = mysqli_query($connection, $query);

        if($result){
            return $token;
        }else{
            return false;
        }
    }

    function generateToken($length = 30){
        return bin2hex(openssl_random_pseudo_bytes($length));
    }

    /*
    function getToken($user_id, $username){
        global $connection;
        
        $user_id = (int) $user_id;
        $safe_username = mysqli_real_escape_string($connection, $username);
        
        $query  = "SELECT token ";
        $query .= "FROM users ";
        $query .= "WHERE id = {$user_id} ";
        $query .= "AND email = '{$safe_username}' ";
        $query .= "LIMIT 1";
        
        $user = mysqli_query($connection, $query);
        confirm_query($user);
        
        if($user = mysqli_fetch_assoc($user)){
            return $user["token"];
        }else{
            return null;   
        }
    }
    */
?>