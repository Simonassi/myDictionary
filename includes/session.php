<?php
	session_start();

	function error() {
		if (isset($_SESSION["error"])) {
            $output = "<div class='alert alert-danger' role='alert'>";
            $output .= "<span class='glyphicon glyphicon-exclamation-sign' aria-hidden='true'></span>";
            $output .= "<span class='sr-only'>Error:</span>";
			$output .= utf8_decode($_SESSION["error"]);
			$output .= "</div>";
			
			// clear message after use
			$_SESSION["error"] = null;
			
			return $output;
		}
	}	
	
?>