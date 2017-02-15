<?php
/* Copyright (C) :JAMES DE LA CRUZ|EIJI DE LA CRUZ: - All Rights Reserved
 * Unauthorized copying of this file, via any medium is strictly prohibited
 * Proprietary and confidential
 * Written by JAMES DE LA CRUZ && EIJI DE LA CRUZ, OCTOBER 2016
 */
include_once('./../connect.php');
$userEIN = $_SESSION['admin_usr'];
////////////////////////////////////////////
//GET USER INFO VIA SESSION;
	function getName(){
		global $_CON;
		global $userEIN;
		$sqlSearch = mysqli_query($_CON,"SELECT teacher_fname, teacher_lname FROM teachers_table WHERE teacher_ein='$userEIN' ");
		$row = mysqli_fetch_array($sqlSearch);
		$fname = $row['teacher_fname'];
		$lname = $row['teacher_lname'];
		$fullname = "$fname $lname";
		return $fullname;
	}