<?php
	function logout(){
		if(isset($_GET['out'])){
			$_SESSION = array();
			if(isset($_COOKIE["student_usr"])) {
				setcookie("student_usr", '', strtotime( '-5 days' ), '/');
			}
			session_destroy();
			header("location: login.php?session=false");
			ob_end_clean();
		}
	}