<?php
	function logout(){
		if(isset($_GET['out'])){
			$_SESSION = array();
			if(isset($_COOKIE["teacher_usr"]) && isset($_COOKIE["password"])) {
				setcookie("teacher_usr", '', strtotime( '-5 days' ), '/');
				setcookie("password", '', strtotime( '-5 days' ), '/');
			}
			session_destroy();
			if(isset($_SESSION['teacher_usr'])){
				header("location: login.php?session=unknown");
			}else{
				header("location: login.php?session=false");
				ob_end_clean();
			}
		}
	}