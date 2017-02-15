
<?php
/* Copyright (C) :JAMES DE LA CRUZ|EIJI DE LA CRUZ: - All Rights Reserved
 * Unauthorized copying of this file, via any medium is strictly prohibited
 * Proprietary and confidential
 * Written by JAMES DE LA CRUZ && EIJI DE LA CRUZ, OCTOBER 2016
 */
include_once('./../connect.php');
date_default_timezone_set('Asia/Manila');
$_NOW = date("Y-m-d H:i:s");
$_YEAR = date("Y");

/////////////////////////////////////////////
//View employee
	function theview(){
		global $_CON;
		global $_YEAR;
		$last_year = $_YEAR - 1;
		$sy = $last_year."-".$_YEAR;
		$MY_ID = returnID();
		$sqlSearch = mysqli_query($_CON, "SELECT * FROM schedule_table WHERE teacher_id='$MY_ID' AND school_year='$sy'");
		$count = mysqli_num_rows($sqlSearch);
		if($count > 0){
			while($row=mysqli_fetch_array($sqlSearch)){
				$_ID = mysqli_real_escape_string($_CON, $row['sched_id']);
				$SUBJ_ID = mysqli_real_escape_string($_CON, $row['subject_id']);
				$section_id = mysqli_real_escape_string($_CON, $row['section_id']);
				$days = $row['days'];
				$startTime = mysqli_real_escape_string($_CON, $row['start_time']);
				$endTime = mysqli_real_escape_string($_CON, $row['end_time']);
				$startTime = date('h:i:A', strtotime($startTime));
				$endTime = date('h:i:A', strtotime($endTime));
				//GET SUBJECT INFO
				$sqlSubj = mysqli_query($_CON,"SELECT subject_code,subject_name FROM subjects_table WHERE subject_id='$SUBJ_ID' ");
				$_row = mysqli_fetch_array($sqlSubj);
				$subj_name = $_row['subject_name'];
				$subj_code = $_row['subject_code'];
				//GET SECTION INFO
				$sqlSect = mysqli_query($_CON,"SELECT section_name, gradelvl FROM section_table WHERE section_id='$section_id' ");
				$r_ow = mysqli_fetch_array($sqlSect);
				$section_name = $r_ow['section_name'];
				$gradelvl = $r_ow['gradelvl'];
				//COUNT STUDENTS
				$sq_lCount = mysqli_query($_CON, "SELECT COUNT(section_id) as stud_count FROM pupils_table WHERE section_id='$section_id' ");
				$row_count = mysqli_fetch_array($sq_lCount);
				$stud_count = $row_count['stud_count'];
				$hash_sub_id = urlencode(base64_encode($SUBJ_ID));
				$hash_sect_id = urlencode(base64_encode($section_id));
				echo"
				 <tr>
				  <td>$subj_code</td>
				  <td>$subj_name</td>
				  <td>$gradelvl - $section_name($stud_count)</td>
				  <td>$days | $startTime - $endTime</td>
				  <td align='center'>
				   <a class='btn btn-info btn-xs' href='view-this-class.php?this_sect=$hash_sect_id&this_subject=$hash_sub_id'><i class='glyphicon glyphicon-list'></i></a>
				  </td>
				 </tr>
				";
			}
		}else{
			echo"
			 <tr>
			  <td colspan='5'>No data yet. </td>
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
	
	