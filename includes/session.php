<?php
	session_start();
	
	/*
	function success() {
		if (isset($_SESSION["success"])) {
			$output = "<div class=\"success\">";
            $output .= $_SESSION["success"];
			$output .= "</div>";
			
			// clear message after use
			$_SESSION["success"] = null;
			
			return $output;
		}
	}

    function warning($msg) {
		$output = "<div class=\"warning\">";
        $output .= $msg;
		$output .= "</div>";
		
        return $output;
	}
	*/
	function error() {
		if (isset($_SESSION["error"])) {
            $output = "<div class='alert alert-danger' role='alert'>";
			$output .= utf8_decode($_SESSION["error"]);
			$output .= "</div>";
			
			// clear message after use
			$_SESSION["error"] = null;
			
			return $output;
		}
	}	
?>