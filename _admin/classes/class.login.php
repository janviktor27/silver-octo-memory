<?php
/* Copyright (C) :JAMES DE LA CRUZ|EIJI DE LA CRUZ: - All Rights Reserved
 * Unauthorized copying of this file, via any medium is strictly prohibited
 * Proprietary and confidential
 * Written by JAMES DE LA CRUZ && EIJI DE LA CRUZ, OCTOBER 2016
 */
	
	function loginUser(){
		if (isset($_POST['inpEIN']) && isset($_POST['inpPass'])){
			require_once('./../connect.php');
			$usrCIN = mysqli_real_escape_string($_CON, $_POST['inpEIN']);
			$password = mysqli_real_escape_string($_CON, $_POST['inpPass']);
			$pass = md5($password);
			$query = "SELECT * FROM teachers_table WHERE teacher_ein='$usrCIN' AND teacher_pwd='$pass' AND user_type='1' ";
			$result = mysqli_query($_CON,$query) or die(mysqli_connect_error());
			$count = mysqli_num_rows($result);
			if($count == 1){
				$_SESSION['admin_usr'] = $usrCIN;
			}else{
				header("location: login.php?credentials=false");
				ob_end_clean();
			}
		}
		///////////
		//Check if Session is Set Then redirects to index?session=true
		if(isset($_SESSION['admin_usr'])){
		$usrCIN = $_SESSION['admin_usr'];
		$password = $_SESSION['password'];
		setcookie("admin_usr", $usrCIN, strtotime( '+30 days' ), "/", "", "", TRUE);
		setcookie("password", $password, strtotime( '+30 days' ), "/", "", "", TRUE);
		header("location: ./index.php?session=loggedin");
		}
	}