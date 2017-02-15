<?php 
///////////////////////////////////////////////////////////////////////////////////
//Authentication
///////////////////////////////////////////////////////////////////////////////////
	function onlineChecker(){
		if (!isset($_SESSION['teacher_usr'])){
			header("location: login.php?session=false");
			ob_end_clean();
		}		
	}	
	function isOnline(){
		if(isset($_SESSION['teacher_usr'])){
			header("location: index.php?session=loggedin");
			ob_end_clean();
		}
	}