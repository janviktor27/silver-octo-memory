
<?php
/* Copyright (C) :JAMES DE LA CRUZ|EIJI DE LA CRUZ: - All Rights Reserved
 * Unauthorized copying of this file, via any medium is strictly prohibited
 * Proprietary and confidential
 * Written by JAMES DE LA CRUZ && EIJI DE LA CRUZ, OCTOBER 2016
 */
include_once('./../connect.php');

/////////////////////////////////////////////
//View employee
	function theview(){
		global $_CON;
		$MY_ID = returnID();
		$sqlSearch = mysqli_query($_CON, "SELECT * FROM section_table WHERE teacher_id='$MY_ID' ");
		$count = mysqli_num_rows($sqlSearch);
		if($count > 0){
			$row = mysqli_fetch_array($sqlSearch);
			$_ID = mysqli_real_escape_string($_CON, $row['section_id']);
			$section_name = mysqli_real_escape_string($_CON, $row['section_name']);
			$gradelvl = mysqli_real_escape_string($_CON, $row['gradelvl']);
			$sqlSelectClass = mysqli_query($_CON,"
			SELECT
			pupil_id,
			pupil_cin,
			pupil_fname,
			pupil_lname
			FROM
			pupils_table
			WHERE
			section_id='$_ID'");
			while($rowStud=mysqli_fetch_array($sqlSelectClass)){
				$pupil_id = $rowStud['pupil_id'];
				$pupil_cin = $rowStud['pupil_cin'];
				$pupil_fname = $rowStud['pupil_fname'];
				$pupil_lname = $rowStud['pupil_lname'];
				$pupil_id_enc = urlencode(base64_encode($pupil_id));
				echo"
				 <tr>
				  <td>$pupil_cin</td>
				  <td>$pupil_lname, $pupil_fname</td>
				  <td><a href='student.grade.php?identifier=$pupil_id_enc' class='btn btn-info btn-xs'><i class='fa fa-info'></i></a></td>
				 </tr>
				";
			}
		}else{
			echo"
			 <tr>
			  <td colspan='3'>No data yet. </td>
			 </tr>
			";
		}
	}

	function returnID(){
		global $_CON;
		$_EIN = $_SESSION['teacher_usr'];
		$sqlSearch = mysqli_query($_CON, "SELECT teacher_id FROM teachers_table WHERE teacher_ein='$_EIN'");
		$row = mysqli_fetch_array($sqlSearch);
		$_MYID = $row['teacher_id'];
		return $_MYID;
	}
	
	