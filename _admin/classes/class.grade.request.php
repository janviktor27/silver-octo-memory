<?php
/* Copyright (C) :JAMES DE LA CRUZ|EIJI DE LA CRUZ: - All Rights Reserved
 * Unauthorized copying of this file, via any medium is strictly prohibited
 * Proprietary and confidential
 * Written by JAMES DE LA CRUZ && EIJI DE LA CRUZ, OCTOBER 2016
 */
include_once('./../connect.php');
date_default_timezone_set('Asia/Manila');
$_NOW = date("Y-m-d h:i:s");


/////////////////////////////////////////////
//View employee
	function theview(){
		global $_CON;
		$sqlSearch = mysqli_query($_CON, "
		SELECT *
		FROM
		change_grades_table");
		$count = mysqli_num_rows($sqlSearch);
		if($count > 0){
			while($row=mysqli_fetch_array($sqlSearch)){
				$_ID = mysqli_real_escape_string($_CON, $row['change_grade_id']);
				$student_id = mysqli_real_escape_string($_CON, $row['student_id']);
				////////////////////////////////////////
				//GET PUPIL NAME 
				$sqlStudent = mysqli_query($_CON,"SELECT 
				pupil_fname,
				pupil_lname
				FROM
				pupils_table
				WHERE
				pupil_id='$student_id'");
				$row_pupil = mysqli_fetch_array($sqlStudent);
				$pupil_fname = $row_pupil['pupil_fname'];
				$pupil_lname = $row_pupil['pupil_lname'];
				////////////////////////////////////////
				$teacher_id = mysqli_real_escape_string($_CON, $row['teacher_id']);
				////////////////////////////////////////
				//GET TEACHER NAME
				$sqlTeacher = mysqli_query($_CON,"SELECT 
				teacher_fname,
				teacher_lname
				FROM
				teachers_table
				WHERE
				teacher_id='$teacher_id'");
				$row_teacher = mysqli_fetch_array($sqlTeacher);
				$teacher_fname = $row_teacher['teacher_fname'];
				$teacher_lname = $row_teacher['teacher_lname'];
				////////////////////////////////////////
				$subject_id = mysqli_real_escape_string($_CON, $row['subject_id']);
				////////////////////////////////////////
				//GET SUBJECT NAME
				$sqlSubj = mysqli_query($_CON,"SELECT 
				subject_name
				FROM
				subjects_table 
				WHERE
				subject_id='$subject_id'");
				$row_subj = mysqli_fetch_array($sqlSubj);
				$subject_name = $row_subj['subject_name'];
				////////////////////////////////////////
				$grading_period = mysqli_real_escape_string($_CON, $row['grading_period']);
				$school_year = mysqli_real_escape_string($_CON, $row['school_year']);
				$isMAPEH = mysqli_real_escape_string($_CON, $row['isMAPEH']);
				$oldGrd = oldGrade($student_id,$teacher_id,$subject_id,$grading_period,$school_year,$isMAPEH);
				$pupil_grade_lvl = mysqli_real_escape_string($_CON, $row['pupil_grade_lvl']);
				$section_name = mysqli_real_escape_string($_CON, $row['section_name']);
				$date_graded = mysqli_real_escape_string($_CON, $row['date_graded']);
				
				//MUSIC
				$written_word = mysqli_real_escape_string($_CON, $row['written_word']);
				$highest_ww = mysqli_real_escape_string($_CON, $row['highest_ww']);
				$performance_task = mysqli_real_escape_string($_CON, $row['performance_task']);
				$highest_pt = mysqli_real_escape_string($_CON, $row['highest_pt']);
				$periodical_exam = mysqli_real_escape_string($_CON, $row['periodical_exam']);
				$highest_pe = mysqli_real_escape_string($_CON, $row['highest_pe']);
				//ARTS
				$written_word_ARTS = mysqli_real_escape_string($_CON, $row['written_word_ARTS']);
				$highest_ww_ARTS = mysqli_real_escape_string($_CON, $row['highest_ww_ARTS']);
				$performance_task_ARTS = mysqli_real_escape_string($_CON, $row['performance_task_ARTS']);
				$highest_pt_ARTS = mysqli_real_escape_string($_CON, $row['highest_pt_ARTS']);
				$periodical_exam_ARTS = mysqli_real_escape_string($_CON, $row['periodical_exam_ARTS']);
				$highest_pe_ARTS = mysqli_real_escape_string($_CON, $row['highest_pe_ARTS']);
				//PE
				$written_word_PE = mysqli_real_escape_string($_CON, $row['written_word_PE']);
				$highest_ww_PE = mysqli_real_escape_string($_CON, $row['highest_ww_PE']);
				$performance_task_PE = mysqli_real_escape_string($_CON, $row['performance_task_PE']);
				$highest_pt_PE = mysqli_real_escape_string($_CON, $row['highest_pt_PE']);
				$periodical_exam_PE = mysqli_real_escape_string($_CON, $row['periodical_exam_PE']);
				$highest_pe_PE = mysqli_real_escape_string($_CON, $row['highest_pe_PE']);
				//HEALTH-----------//
				$written_word_HEALTH = mysqli_real_escape_string($_CON, $row['written_word_HEALTH']);
				$highest_ww_HEALTH = mysqli_real_escape_string($_CON, $row['highest_ww_HEALTH']);
				$performance_task_HEALTH = mysqli_real_escape_string($_CON, $row['performance_task_HEALTH']);
				$highest_pt_HEALTH = mysqli_real_escape_string($_CON, $row['highest_pt_HEALTH']);
				$periodical_exam_HEALTH = mysqli_real_escape_string($_CON, $row['periodical_exam_HEALTH']);
				$highest_pe_HEALTH = mysqli_real_escape_string($_CON, $row['highest_pe_HEALTH']);
				if($isMAPEH == 1){
					$writtenwork = .20;
					$perftask = .60;
					$periodical = .20;
					//-----------MUSIC----------//
					//////////////////////////////
					// WRITTEN WORK
					$_WW_percentScore_MUSIC = ($written_word/$highest_ww) * 100;
					$_WW_percentScore_MUSIC = round($_WW_percentScore_MUSIC,2);
					$_WW_weightedScore_MUSIC = $_WW_percentScore_MUSIC * $writtenwork;
					$_TOTAL_WW_MUSIC = round($_WW_weightedScore_MUSIC,2);
					//////////////////////////////
					// PERFOMANCE TASK
					$_PT_percentScore_MUSIC = ($performance_task/$highest_pt) * 100;
					$_PT_percentScore_MUSIC = round($_PT_percentScore_MUSIC,2);
					$_PT_weightedScore_MUSIC = $_PT_percentScore_MUSIC * $perftask;
					$_TOTAL_PT_MUSIC = round($_PT_weightedScore_MUSIC,2);
					//////////////////////////////
					// PERIODICAL EXAM
					$_PE_percentScore_MUSIC = ($periodical_exam/$highest_pe) * 100;
					$_PE_percentScore_MUSIC = round($_PE_percentScore_MUSIC,2);
					$_PE_weightedScore_MUSIC = $_PE_percentScore_MUSIC * $periodical;
					$_TOTAL_PE_MUSIC = round($_PE_weightedScore_MUSIC,2);
					$_OVERALL_MUSIC = $_TOTAL_WW_MUSIC + $_TOTAL_PT_MUSIC + $_TOTAL_PE_MUSIC;

					//-----------PE-----------//
					//////////////////////////////
					// WRITTEN WORK
					$_WW_percentScore_PE = ($written_word_PE/$highest_ww_PE) * 100;
					$_WW_percentScore_PE = round($_WW_percentScore_PE,2);
					$_WW_weightedScore_PE = $_WW_percentScore_PE * $writtenwork;
					$_TOTAL_WW_PE = round($_WW_weightedScore_PE,2);
					//////////////////////////////
					// PERFOMANCE TASK
					$_PT_percentScore_PE = ($performance_task_PE/$highest_pt_PE) * 100;
					$_PT_percentScore_PE = round($_PT_percentScore_PE,2);
					$_PT_weightedScore_PE = $_PT_percentScore_PE * $perftask;
					$_TOTAL_PT_PE = round($_PT_weightedScore_PE,2);
					//////////////////////////////
					// PERIODICAL EXAM
					$_PE_percentScore_PE = ($periodical_exam_PE/$highest_pe_PE) * 100;
					$_PE_percentScore_PE = round($_PE_percentScore_PE,2);
					$_PE_weightedScore_PE = $_PE_percentScore_PE * $periodical;
					$_TOTAL_PE_PE = round($_PE_weightedScore_PE,2);
					$_OVERALL_PE = $_TOTAL_WW_PE + $_TOTAL_PT_PE + $_TOTAL_PE_PE;

					//-----------ARTS-----------//
					//////////////////////////////
					// WRITTEN WORK
					$_WW_percentScore_ARTS = ($written_word_ARTS/$highest_ww_ARTS) * 100;
					$_WW_percentScore_ARTS = round($_WW_percentScore_ARTS,2);
					$_WW_weightedScore_ARTS = $_WW_percentScore_ARTS * $writtenwork;
					$_TOTAL_WW_ARTS = round($_WW_weightedScore_ARTS,2);
					//////////////////////////////
					// PERFOMANCE TASK
					$_PT_percentScore_ARTS = ($performance_task_ARTS/$highest_pt_ARTS) * 100;
					$_PT_percentScore_ARTS = round($_PT_percentScore_ARTS,2);
					$_PT_weightedScore_ARTS = $_PT_percentScore_ARTS * $perftask;
					$_TOTAL_PT_ARTS= round($_PT_weightedScore_ARTS,2);
					//////////////////////////////
					// PERIODICAL EXAM
					$_PE_percentScore_ARTS = ($periodical_exam_ARTS/$highest_pe_ARTS) * 100;
					$_PE_percentScore_ARTS = round($_PE_percentScore_ARTS,2);
					$_PE_weightedScore_ARTS = $_PE_percentScore_ARTS * $periodical;
					$_TOTAL_PE_ARTS = round($_PE_weightedScore_ARTS,2);
					$_OVERALL_ARTS = $_TOTAL_WW_ARTS + $_TOTAL_PT_ARTS + $_TOTAL_PE_ARTS;

					//-----------HEALTH-----------//
					//////////////////////////////
					// WRITTEN WORK
					$_WW_percentScore_HEALTH = ($written_word_HEALTH/$highest_ww_HEALTH) * 100;
					$_WW_percentScore_HEALTH = round($_WW_percentScore_HEALTH,2);
					$_WW_weightedScore_HEALTH = $_WW_percentScore_HEALTH * $writtenwork;
					$_TOTAL_WW_HEALTH = round($_WW_weightedScore_HEALTH,2);
					//////////////////////////////
					// PERFOMANCE TASK
					$_PT_percentScore_HEALTH = ($performance_task_HEALTH/$highest_pt_HEALTH) * 100;
					$_PT_percentScore_HEALTH = round($_PT_percentScore_HEALTH,2);
					$_PT_weightedScore_HEALTH = $_PT_percentScore_HEALTH * $perftask;
					$_TOTAL_PT_HEALTH = round($_PT_weightedScore_HEALTH,2);
					//////////////////////////////
					// PERIODICAL EXAM
					$_PE_percentScore_HEALTH = ($periodical_exam_HEALTH/$highest_pe_HEALTH) * 100;
					$_PE_percentScore_HEALTH = round($_PE_percentScore_HEALTH,2);
					$_PE_weightedScore_HEALTH = $_PE_percentScore_HEALTH * $periodical;
					$_TOTAL_PE_HEALTH = round($_PE_weightedScore_HEALTH,2);
					$_OVERALL_HEALTH = $_TOTAL_WW_HEALTH + $_TOTAL_PT_HEALTH + $_TOTAL_PE_HEALTH;
					
					$_AVERAGE = round(($_OVERALL_MUSIC + $_OVERALL_ARTS + $_OVERALL_PE + $_OVERALL_HEALTH) / 4, 2);
					echo"
					<tr>
					<td>$pupil_lname, $pupil_fname(Grade $pupil_grade_lvl)</td>
					<td>$teacher_lname, $teacher_fname</td>
					<td>$subject_name</td>
					<td>$oldGrd</td>
					<td>$_AVERAGE</td>
					<td>
						<button data-toggle='modal' data-target='#gradeMOD$_ID' class='btn btn-xs btn-info'><i class='fa fa-list'></i></button>
						<button data-toggle='modal' data-target='#acceptMOD$_ID' class='btn btn-xs btn-info'><i class='fa fa-check'></i></button>
						<button data-toggle='modal' data-target='#delMod$_ID' class='btn btn-xs btn-danger'><i class='fa fa-times'></i></button>
					</td>
					</tr>
					";
				}else{
			$getSubjectType = mysqli_query($_CON, "SELECT subject_type FROM subjects_table WHERE subject_id='$subject_id'");
			$_row_subjType = mysqli_fetch_array($getSubjectType);
			$subject_type = $_row_subjType['subject_type'];
					
					if($subject_type == 1){
						$writtenwork = .30;
						$perftask = .50;
						$periodical = .20;
					}
					if($subject_type == 2){
						$writtenwork = .40;
						$perftask = .40;
						$periodical = .20;
					}
					if($subject_type == 3 || $subject_type == 4){
						$writtenwork = .20;
						$perftask = .60;
						$periodical = .20;
					}
					//////////////////////////////
					// WRITTEN WORK
					$_WW_percentScore = ($written_word/$highest_ww) * 100;
					$_WW_percentScore = round($_WW_percentScore,2);
					$_WW_weightedScore = $_WW_percentScore * $writtenwork;
					$_TOTAL_WW = round($_WW_weightedScore,2);
					//////////////////////////////
					// PERFOMANCE TASK
					$_PT_percentScore = ($performance_task/$highest_pt) * 100;
					$_PT_percentScore = round($_PT_percentScore,2);
					$_PT_weightedScore = $_PT_percentScore * $perftask;
					$_TOTAL_PT = round($_PT_weightedScore,2);
					//////////////////////////////
					// PERIODICAL EXAM
					$_PE_percentScore = ($periodical_exam/$highest_pe) * 100;
					$_PE_percentScore = round($_PE_percentScore,2);
					$_PE_weightedScore = $_PE_percentScore * $periodical;
					$_TOTAL_PE = round($_PE_weightedScore,2);
					$_OVERALL = $_TOTAL_WW + $_TOTAL_PT + $_TOTAL_PE;					
					echo"
					<tr>
					<td>$pupil_lname, $pupil_fname(Grade $pupil_grade_lvl)</td>
					<td>$teacher_lname, $teacher_fname</td>
					<td>$subject_name</td>
					<td>$oldGrd</td>
					<td>$_OVERALL</td>
					<td>
						<button data-toggle='modal' data-target='#gradeMOD$_ID' class='btn btn-xs btn-info'><i class='fa fa-list'></i></button>
						<button data-toggle='modal' data-target='#acceptMOD$_ID' class='btn btn-xs btn-info'><i class='fa fa-check'></i></button>
						<button data-toggle='modal' data-target='#delMod$_ID' class='btn btn-xs btn-danger'><i class='fa fa-times'></i></button>
					</td>
					</tr>
					";
				}
			}
		}else{
			echo"
			 <tr>
			  <td colspan='6'>No data yet. </td>
			 </tr>
			";
		}
	}
	

/////////////////////////////////////////////
//GET OLD GRADE
	function oldGrade($student_id,$teacher_id,$subject_id,$grading_period,$school_year,$isMAPEH){
		global $_CON;
		if($isMAPEH == 1){
			$sqlSearch = mysqli_query($_CON,"
			SELECT * 
			FROM
			grades_table
			WHERE
			student_id='$student_id'
			AND
			teacher_id='$teacher_id'
			AND
			subject_id='$subject_id'
			AND
			grading_period='$grading_period'
			AND
			school_year='$school_year'");
			$count = mysqli_num_rows($sqlSearch);
			if($count == 1){
					$row=mysqli_fetch_array($sqlSearch);
					$writtenwork = .20;
					$perftask = .60;
					$periodical = .20;
					//MUSIC
					$_ID = mysqli_real_escape_string($_CON, $row['grade_id']);
					$written_word = mysqli_real_escape_string($_CON, $row['written_word']);
					$highest_ww = mysqli_real_escape_string($_CON, $row['highest_ww']);
					$performance_task = mysqli_real_escape_string($_CON, $row['performance_task']);
					$highest_pt = mysqli_real_escape_string($_CON, $row['highest_pt']);
					$periodical_exam = mysqli_real_escape_string($_CON, $row['periodical_exam']);
					$highest_pe = mysqli_real_escape_string($_CON, $row['highest_pe']);
					$grading_period = mysqli_real_escape_string($_CON, $row['grading_period']);
					// ARTS
					$written_word_ARTS = mysqli_real_escape_string($_CON, $row['written_word_ARTS']);
					$highest_ww_ARTS = mysqli_real_escape_string($_CON, $row['highest_ww_ARTS']);
					$performance_task_ARTS = mysqli_real_escape_string($_CON, $row['performance_task_ARTS']);
					$highest_pt_ARTS = mysqli_real_escape_string($_CON, $row['highest_pt_ARTS']);
					$periodical_exam_ARTS = mysqli_real_escape_string($_CON, $row['periodical_exam_ARTS']);
					$highest_pe_ARTS = mysqli_real_escape_string($_CON, $row['highest_pe_ARTS']);
					// PE
					$written_word_PE = mysqli_real_escape_string($_CON, $row['written_word_PE']);
					$highest_ww_PE = mysqli_real_escape_string($_CON, $row['highest_ww_PE']);
					$performance_task_PE = mysqli_real_escape_string($_CON, $row['performance_task_PE']);
					$highest_pt_PE = mysqli_real_escape_string($_CON, $row['highest_pt_PE']);
					$periodical_exam_PE = mysqli_real_escape_string($_CON, $row['periodical_exam_PE']);
					$highest_pe_PE = mysqli_real_escape_string($_CON, $row['highest_pe_PE']);
					// HEALTH
					$written_word_HEALTH = mysqli_real_escape_string($_CON, $row['written_word_HEALTH']);
					$highest_ww_HEALTH = mysqli_real_escape_string($_CON, $row['highest_ww_HEALTH']);
					$performance_task_HEALTH = mysqli_real_escape_string($_CON, $row['performance_task_HEALTH']);
					$highest_pt_HEALTH = mysqli_real_escape_string($_CON, $row['highest_pt_HEALTH']);
					$periodical_exam_HEALTH = mysqli_real_escape_string($_CON, $row['periodical_exam_HEALTH']);
					$highest_pe_HEALTH = mysqli_real_escape_string($_CON, $row['highest_pe_HEALTH']);
					
					//-----------MUSIC----------//
					//////////////////////////////
					// WRITTEN WORK
					$_WW_percentScore_MUSIC = ($written_word/$highest_ww) * 100;
					$_WW_percentScore_MUSIC = round($_WW_percentScore_MUSIC,2);
					$_WW_weightedScore_MUSIC = $_WW_percentScore_MUSIC * $writtenwork;
					$_TOTAL_WW_MUSIC = round($_WW_weightedScore_MUSIC,2);
					//////////////////////////////
					// PERFOMANCE TASK
					$_PT_percentScore_MUSIC = ($performance_task/$highest_pt) * 100;
					$_PT_percentScore_MUSIC = round($_PT_percentScore_MUSIC,2);
					$_PT_weightedScore_MUSIC = $_PT_percentScore_MUSIC * $perftask;
					$_TOTAL_PT_MUSIC = round($_PT_weightedScore_MUSIC,2);
					//////////////////////////////
					// PERIODICAL EXAM
					$_PE_percentScore_MUSIC = ($periodical_exam/$highest_pe) * 100;
					$_PE_percentScore_MUSIC = round($_PE_percentScore_MUSIC,2);
					$_PE_weightedScore_MUSIC = $_PE_percentScore_MUSIC * $periodical;
					$_TOTAL_PE_MUSIC = round($_PE_weightedScore_MUSIC,2);
					$_OVERALL_MUSIC = $_TOTAL_WW_MUSIC + $_TOTAL_PT_MUSIC + $_TOTAL_PE_MUSIC;

					//-----------PE-----------//
					//////////////////////////////
					// WRITTEN WORK
					$_WW_percentScore_PE = ($written_word_PE/$highest_ww_PE) * 100;
					$_WW_percentScore_PE = round($_WW_percentScore_PE,2);
					$_WW_weightedScore_PE = $_WW_percentScore_PE * $writtenwork;
					$_TOTAL_WW_PE = round($_WW_weightedScore_PE,2);
					//////////////////////////////
					// PERFOMANCE TASK
					$_PT_percentScore_PE = ($performance_task_PE/$highest_pt_PE) * 100;
					$_PT_percentScore_PE = round($_PT_percentScore_PE,2);
					$_PT_weightedScore_PE = $_PT_percentScore_PE * $perftask;
					$_TOTAL_PT_PE = round($_PT_weightedScore_PE,2);
					//////////////////////////////
					// PERIODICAL EXAM
					$_PE_percentScore_PE = ($periodical_exam_PE/$highest_pe_PE) * 100;
					$_PE_percentScore_PE = round($_PE_percentScore_PE,2);
					$_PE_weightedScore_PE = $_PE_percentScore_PE * $periodical;
					$_TOTAL_PE_PE = round($_PE_weightedScore_PE,2);
					$_OVERALL_PE = $_TOTAL_WW_PE + $_TOTAL_PT_PE + $_TOTAL_PE_PE;

					//-----------ARTS-----------//
					//////////////////////////////
					// WRITTEN WORK
					$_WW_percentScore_ARTS = ($written_word_ARTS/$highest_ww_ARTS) * 100;
					$_WW_percentScore_ARTS = round($_WW_percentScore_ARTS,2);
					$_WW_weightedScore_ARTS = $_WW_percentScore_ARTS * $writtenwork;
					$_TOTAL_WW_ARTS = round($_WW_weightedScore_ARTS,2);
					//////////////////////////////
					// PERFOMANCE TASK
					$_PT_percentScore_ARTS = ($performance_task_ARTS/$highest_pt_ARTS) * 100;
					$_PT_percentScore_ARTS = round($_PT_percentScore_ARTS,2);
					$_PT_weightedScore_ARTS = $_PT_percentScore_ARTS * $perftask;
					$_TOTAL_PT_ARTS= round($_PT_weightedScore_ARTS,2);
					//////////////////////////////
					// PERIODICAL EXAM
					$_PE_percentScore_ARTS = ($periodical_exam_ARTS/$highest_pe_ARTS) * 100;
					$_PE_percentScore_ARTS = round($_PE_percentScore_ARTS,2);
					$_PE_weightedScore_ARTS = $_PE_percentScore_ARTS * $periodical;
					$_TOTAL_PE_ARTS = round($_PE_weightedScore_ARTS,2);
					$_OVERALL_ARTS = $_TOTAL_WW_ARTS + $_TOTAL_PT_ARTS + $_TOTAL_PE_ARTS;

					//-----------HEALTH-----------//
					//////////////////////////////
					// WRITTEN WORK
					$_WW_percentScore_HEALTH = ($written_word_HEALTH/$highest_ww_HEALTH) * 100;
					$_WW_percentScore_HEALTH = round($_WW_percentScore_HEALTH,2);
					$_WW_weightedScore_HEALTH = $_WW_percentScore_HEALTH * $writtenwork;
					$_TOTAL_WW_HEALTH = round($_WW_weightedScore_HEALTH,2);
					//////////////////////////////
					// PERFOMANCE TASK
					$_PT_percentScore_HEALTH = ($performance_task_HEALTH/$highest_pt_HEALTH) * 100;
					$_PT_percentScore_HEALTH = round($_PT_percentScore_HEALTH,2);
					$_PT_weightedScore_HEALTH = $_PT_percentScore_HEALTH * $perftask;
					$_TOTAL_PT_HEALTH = round($_PT_weightedScore_HEALTH,2);
					//////////////////////////////
					// PERIODICAL EXAM
					$_PE_percentScore_HEALTH = ($periodical_exam_HEALTH/$highest_pe_HEALTH) * 100;
					$_PE_percentScore_HEALTH = round($_PE_percentScore_HEALTH,2);
					$_PE_weightedScore_HEALTH = $_PE_percentScore_HEALTH * $periodical;
					$_TOTAL_PE_HEALTH = round($_PE_weightedScore_HEALTH,2);
					$_OVERALL_HEALTH = $_TOTAL_WW_HEALTH + $_TOTAL_PT_HEALTH + $_TOTAL_PE_HEALTH;
					
					$_AVERAGE = round(($_OVERALL_MUSIC + $_OVERALL_ARTS + $_OVERALL_PE + $_OVERALL_HEALTH) / 4, 2);
					return $_AVERAGE;
			}else{
				return "No Old Grade";
			}
		}else{
			if($isMAPEH == 0){
			$sqlSearch = mysqli_query($_CON,"
			SELECT * 
			FROM
			grades_table
			WHERE
			student_id='$student_id'
			AND
			teacher_id='$teacher_id'
			AND
			subject_id='$subject_id'
			AND
			grading_period='$grading_period'
			AND
			school_year='$school_year'");
			$count = mysqli_num_rows($sqlSearch);
			if($count == 1){
					$getSubjectType = mysqli_query($_CON, "SELECT subject_type FROM subjects_table WHERE subject_id='$subject_id'");
					$_row_subjType = mysqli_fetch_array($getSubjectType);
					$subject_type = $_row_subjType['subject_type'];
					if($subject_type == 1){
						$writtenwork = .30;
						$perftask = .50;
						$periodical = .20;
					}
					if($subject_type == 2){
						$writtenwork = .40;
						$perftask = .40;
						$periodical = .20;
					}
					if($subject_type == 3 || $subject_type == 4){
						$writtenwork = .20;
						$perftask = .60;
						$periodical = .20;
					}
					$row=mysqli_fetch_array($sqlSearch);
					$written_word = mysqli_real_escape_string($_CON, $row['written_word']);
					$highest_ww = mysqli_real_escape_string($_CON, $row['highest_ww']);
					$performance_task = mysqli_real_escape_string($_CON, $row['performance_task']);
					$highest_pt = mysqli_real_escape_string($_CON, $row['highest_pt']);
					$periodical_exam = mysqli_real_escape_string($_CON, $row['periodical_exam']);
					$highest_pe = mysqli_real_escape_string($_CON, $row['highest_pe']);
					$grading_period = mysqli_real_escape_string($_CON, $row['grading_period']);

					//////////////////////////////
					// WRITTEN WORK
					$_WW_percentScore = ($written_word/$highest_ww) * 100;
					$_WW_percentScore = round($_WW_percentScore,2);
					$_WW_weightedScore = $_WW_percentScore * $writtenwork;
					$_TOTAL_WW = round($_WW_weightedScore,2);
					//////////////////////////////
					// PERFOMANCE TASK
					$_PT_percentScore = ($performance_task/$highest_pt) * 100;
					$_PT_percentScore = round($_PT_percentScore,2);
					$_PT_weightedScore = $_PT_percentScore * $perftask;
					$_TOTAL_PT = round($_PT_weightedScore,2);
					//////////////////////////////
					// PERIODICAL EXAM
					$_PE_percentScore = ($periodical_exam/$highest_pe) * 100;
					$_PE_percentScore = round($_PE_percentScore,2);
					$_PE_weightedScore = $_PE_percentScore * $periodical;
					$_TOTAL_PE = round($_PE_weightedScore,2);
					$_OVERALL = $_TOTAL_WW + $_TOTAL_PT + $_TOTAL_PE;					
					return $_OVERALL;
				}else{
					return "No Old Grade";
				}
			}
		}
	}

/////////////////////////////////////////////
//VIEW GRADES VIEW
	function gradesMod(){
		global $_CON;
		$sqlSearch = mysqli_query($_CON, "
		SELECT *
		FROM
		change_grades_table");
		$count = mysqli_num_rows($sqlSearch);
		if($count > 0){
			while($row=mysqli_fetch_array($sqlSearch)){
				$_ID = mysqli_real_escape_string($_CON, $row['change_grade_id']);
				$student_id = mysqli_real_escape_string($_CON, $row['student_id']);
				////////////////////////////////////////
				//GET PUPIL NAME 
				$sqlStudent = mysqli_query($_CON,"SELECT 
				pupil_fname,
				pupil_lname
				FROM
				pupils_table
				WHERE
				pupil_id='$student_id'");
				$row_pupil = mysqli_fetch_array($sqlStudent);
				$pupil_fname = $row_pupil['pupil_fname'];
				$pupil_lname = $row_pupil['pupil_lname'];
				////////////////////////////////////////
				$teacher_id = mysqli_real_escape_string($_CON, $row['teacher_id']);
				////////////////////////////////////////
				//GET TEACHER NAME
				$sqlTeacher = mysqli_query($_CON,"SELECT 
				teacher_fname,
				teacher_lname
				FROM
				teachers_table
				WHERE
				teacher_id='$teacher_id'");
				$row_teacher = mysqli_fetch_array($sqlTeacher);
				$teacher_fname = $row_teacher['teacher_fname'];
				$teacher_lname = $row_teacher['teacher_lname'];
				////////////////////////////////////////
				$subject_id = mysqli_real_escape_string($_CON, $row['subject_id']);
				////////////////////////////////////////
				//GET SUBJECT NAME
				$sqlSubj = mysqli_query($_CON,"SELECT 
				subject_name
				FROM
				subjects_table 
				WHERE
				subject_id='$subject_id'");
				$row_subj = mysqli_fetch_array($sqlSubj);
				$subject_name = $row_subj['subject_name'];
				////////////////////////////////////////
				$grading_period = mysqli_real_escape_string($_CON, $row['grading_period']);
				$school_year = mysqli_real_escape_string($_CON, $row['school_year']);
				$isMAPEH = mysqli_real_escape_string($_CON, $row['isMAPEH']);
				$oldGrd = oldGradeView($student_id,$teacher_id,$subject_id,$grading_period,$school_year,$isMAPEH);
				$pupil_grade_lvl = mysqli_real_escape_string($_CON, $row['pupil_grade_lvl']);
				$section_name = mysqli_real_escape_string($_CON, $row['section_name']);
				$date_graded = mysqli_real_escape_string($_CON, $row['date_graded']);
				
				//MUSIC
				$written_word = mysqli_real_escape_string($_CON, $row['written_word']);
				$highest_ww = mysqli_real_escape_string($_CON, $row['highest_ww']);
				$performance_task = mysqli_real_escape_string($_CON, $row['performance_task']);
				$highest_pt = mysqli_real_escape_string($_CON, $row['highest_pt']);
				$periodical_exam = mysqli_real_escape_string($_CON, $row['periodical_exam']);
				$highest_pe = mysqli_real_escape_string($_CON, $row['highest_pe']);
				//ARTS
				$written_word_ARTS = mysqli_real_escape_string($_CON, $row['written_word_ARTS']);
				$highest_ww_ARTS = mysqli_real_escape_string($_CON, $row['highest_ww_ARTS']);
				$performance_task_ARTS = mysqli_real_escape_string($_CON, $row['performance_task_ARTS']);
				$highest_pt_ARTS = mysqli_real_escape_string($_CON, $row['highest_pt_ARTS']);
				$periodical_exam_ARTS = mysqli_real_escape_string($_CON, $row['periodical_exam_ARTS']);
				$highest_pe_ARTS = mysqli_real_escape_string($_CON, $row['highest_pe_ARTS']);
				//PE
				$written_word_PE = mysqli_real_escape_string($_CON, $row['written_word_PE']);
				$highest_ww_PE = mysqli_real_escape_string($_CON, $row['highest_ww_PE']);
				$performance_task_PE = mysqli_real_escape_string($_CON, $row['performance_task_PE']);
				$highest_pt_PE = mysqli_real_escape_string($_CON, $row['highest_pt_PE']);
				$periodical_exam_PE = mysqli_real_escape_string($_CON, $row['periodical_exam_PE']);
				$highest_pe_PE = mysqli_real_escape_string($_CON, $row['highest_pe_PE']);
				//HEALTH-----------//
				$written_word_HEALTH = mysqli_real_escape_string($_CON, $row['written_word_HEALTH']);
				$highest_ww_HEALTH = mysqli_real_escape_string($_CON, $row['highest_ww_HEALTH']);
				$performance_task_HEALTH = mysqli_real_escape_string($_CON, $row['performance_task_HEALTH']);
				$highest_pt_HEALTH = mysqli_real_escape_string($_CON, $row['highest_pt_HEALTH']);
				$periodical_exam_HEALTH = mysqli_real_escape_string($_CON, $row['periodical_exam_HEALTH']);
				$highest_pe_HEALTH = mysqli_real_escape_string($_CON, $row['highest_pe_HEALTH']);
				if($isMAPEH == 1){
					echo"
<!--Modal Start-->
<div class='modal fade' id='gradeMOD$_ID' tabindex='-1' role='dialog' aria-labelledby='myModalLabel' aria-hidden='true'>
	<div class='modal-dialog modal-lg'>
		<div class='modal-content'>
				<div class='modal-header'>
					<button type='button' class='close' data-dismiss='modal' aria-hidden='true'>&times;</button>
					<h4 class='modal-title'>$subject_name - GRADES INFORMATION</h4> </div>
					<div class='modal-body'>
					<div class='row'>
					<div class='col-md-6'>
					$oldGrd
					</div>
					<div class='col-md-6'>
					  <table class='table table-bordered'>
					   <tbody>
						  <tr>
							<th colspan='2'>NEW GRADES</th>
						  </tr>
						  <tr>
							<th colspan='2'>MUSIC</th>
						  </tr>
						  <tr>
							<td colspan='2'>WRITTEN WORK</td>
						  </tr>
						  <tr>
							<td>TOTAL SCORE</td>
							<td>HIGHEST SCORE</td>
						  </tr>
						  <tr>
							<td>$written_word</td>
							<td>$highest_ww</td>
						  </tr>
						  <tr>
							<td colspan='2'>PERFORMANCE TASK</td>
						  </tr>
						  <tr>
							<td>TOTAL SCORE</td>
							<td>HIGHEST SCORE</td>
						  </tr>
						  <tr>
							<td>$performance_task</td>
							<td>$highest_pt</td>
						  </tr>
						  <tr>
							<td colspan='2'>PERIODICAL EXAM</td>
						  </tr>
						  <tr>
							<td>TOTAL SCORE</td>
							<td>HIGHEST SCORE</td>
						  </tr>
						  <tr>
							<td>$periodical_exam</td>
							<td>$highest_pe</td>
						  </tr>
						  <tr>
							<th colspan='2'>ARTS</th>
						  </tr>
						  <tr>
							<td colspan='2'>WRITTEN WORK</td>
						  </tr>
						  <tr>
							<td>TOTAL SCORE</td>
							<td>HIGHEST SCORE</td>
						  </tr>
						  <tr>
							<td>$written_word_ARTS</td>
							<td>$highest_ww_ARTS</td>
						  </tr>
						  <tr>
							<td colspan='2'>PERFORMANCE TASK</td>
						  </tr>
						  <tr>
							<td>TOTAL SCORE</td>
							<td>HIGHEST SCORE</td>
						  </tr>
						  <tr>
							<td>$performance_task_ARTS</td>
							<td>$highest_pt_ARTS</td>
						  </tr>
						  <tr>
							<td colspan='2'>PERIODICAL EXAM</td>
						  </tr>
						  <tr>
							<td>TOTAL SCORE</td>
							<td>HIGHEST SCORE</td>
						  </tr>
						  <tr>
							<td>$periodical_exam_ARTS</td>
							<td>$highest_pe_ARTS</td>
						  </tr>
						  <tr>
							<th colspan='2'>PE</th>
						  </tr>
						  <tr>
							<td colspan='2'>WRITTEN WORK</td>
						  </tr>
						  <tr>
							<td>TOTAL SCORE</td>
							<td>HIGHEST SCORE</td>
						  </tr>
						  <tr>
							<td>$written_word_PE</td>
							<td>$highest_ww_PE</td>
						  </tr>
						  <tr>
							<td colspan='2'>PERFORMANCE TASK</td>
						  </tr>
						  <tr>
							<td>TOTAL SCORE</td>
							<td>HIGHEST SCORE</td>
						  </tr>
						  <tr>
							<td>$performance_task_PE</td>
							<td>$highest_pt_PE</td>
						  </tr>
						  <tr>
							<td colspan='2'>PERIODICAL EXAM</td>
						  </tr>
						  <tr>
							<td>TOTAL SCORE</td>
							<td>HIGHEST SCORE</td>
						  </tr>
						  <tr>
							<td>$periodical_exam_PE</td>
							<td>$highest_pe_PE</td>
						  </tr>
						  <tr>
							<th colspan='2'><strong>HEALTH</strong></th>
						  </tr>
						  <tr>
							<td colspan='2'>WRITTEN WORK</td>
						  </tr>
						  <tr>
							<td>TOTAL SCORE</td>
							<td>HIGHEST SCORE</td>
						  </tr>
						  <tr>
							<td>$written_word_HEALTH</td>
							<td>$highest_ww_HEALTH</td>
						  </tr>
						  <tr>
							<td colspan='2'>PERFORMANCE TASK</td>
						  </tr>
						  <tr>
							<td>TOTAL SCORE</td>
							<td>HIGHEST SCORE</td>
						  </tr>
						  <tr>
							<td>$performance_task_HEALTH</td>
							<td>$highest_pt_HEALTH</td>
						  </tr>
						  <tr>
							<td colspan='2'>PERIODICAL EXAM</td>
						  </tr>
						  <tr>
							<td>TOTAL SCORE</td>
							<td>HIGHEST SCORE</td>
						  </tr>
						  <tr>
							<td>$periodical_exam_HEALTH</td>
							<td>$highest_pe_HEALTH</td>
						  </tr>
					   </tbody>
					  </table>					
					</div>
					</div>
					</div>
					<div class='modal-footer'>
						<button type='button' class='btn btn-danger pull-right' data-dismiss='modal'>Close</button>
					</div>
				</div>
		</div>
	</div>
</div>					";
				}else{
					echo"
<!--Modal Start-->
<div class='modal fade' id='gradeMOD$_ID' tabindex='-1' role='dialog' aria-labelledby='myModalLabel' aria-hidden='true'>
	<div class='modal-dialog modal-lg'>
		<div class='modal-content'>
				<div class='modal-header'>
					<button type='button' class='close' data-dismiss='modal' aria-hidden='true'>&times;</button>
					<h4 class='modal-title'>$subject_name - GRADES INFORMATION</h4> </div>
					<div class='modal-body'>
					<div class='row'>
					<div class='col-md-6'>
					$oldGrd
					</div>
					<div class='col-md-6'>
					  <table class='table table-bordered'>
					   <tbody>
						  <tr>
							<th colspan='2'>NEW GRADES</th>
						  </tr>
						  <tr>
							<td colspan='2'>WRITTEN WORK</td>
						  </tr>
						  <tr>
							<td>TOTAL SCORE</td>
							<td>HIGHEST SCORE</td>
						  </tr>
						  <tr>
							<td>$written_word</td>
							<td>$highest_ww</td>
						  </tr>
						  <tr>
							<td colspan='2'>PERFORMANCE TASK</td>
						  </tr>
						  <tr>
							<td>TOTAL SCORE</td>
							<td>HIGHEST SCORE</td>
						  </tr>
						  <tr>
							<td>$performance_task</td>
							<td>$highest_pt</td>
						  </tr>
						  <tr>
							<td colspan='2'>PERIODICAL EXAM</td>
						  </tr>
						  <tr>
							<td>TOTAL SCORE</td>
							<td>HIGHEST SCORE</td>
						  </tr>
						  <tr>
							<td>$periodical_exam</td>
							<td>$highest_pe</td>
						  </tr>
					   </tbody>
					  </table>					
					</div>
					</div>
					</div>
					<div class='modal-footer'>
						<button type='button' class='btn btn-danger pull-right' data-dismiss='modal'>Close</button>
					</div>
				</div>
		</div>
	</div>
</div>
					";
				}
			}
		}
	}

/////////////////////////////////////////////
//GET OLD GRADE VIEW
	function oldGradeView($student_id,$teacher_id,$subject_id,$grading_period,$school_year,$isMAPEH){
		global $_CON;
		if($isMAPEH == 1){
			$sqlSearch = mysqli_query($_CON,"
			SELECT * 
			FROM
			grades_table
			WHERE
			student_id='$student_id'
			AND
			teacher_id='$teacher_id'
			AND
			subject_id='$subject_id'
			AND
			grading_period='$grading_period'
			AND
			school_year='$school_year'");
			$count = mysqli_num_rows($sqlSearch);
			if($count == 1){
					$row=mysqli_fetch_array($sqlSearch);
					$writtenwork = .20;
					$perftask = .60;
					$periodical = .20;
					//MUSIC
					$_ID = mysqli_real_escape_string($_CON, $row['grade_id']);
					$written_word = mysqli_real_escape_string($_CON, $row['written_word']);
					$highest_ww = mysqli_real_escape_string($_CON, $row['highest_ww']);
					$performance_task = mysqli_real_escape_string($_CON, $row['performance_task']);
					$highest_pt = mysqli_real_escape_string($_CON, $row['highest_pt']);
					$periodical_exam = mysqli_real_escape_string($_CON, $row['periodical_exam']);
					$highest_pe = mysqli_real_escape_string($_CON, $row['highest_pe']);
					$grading_period = mysqli_real_escape_string($_CON, $row['grading_period']);
					// ARTS
					$written_word_ARTS = mysqli_real_escape_string($_CON, $row['written_word_ARTS']);
					$highest_ww_ARTS = mysqli_real_escape_string($_CON, $row['highest_ww_ARTS']);
					$performance_task_ARTS = mysqli_real_escape_string($_CON, $row['performance_task_ARTS']);
					$highest_pt_ARTS = mysqli_real_escape_string($_CON, $row['highest_pt_ARTS']);
					$periodical_exam_ARTS = mysqli_real_escape_string($_CON, $row['periodical_exam_ARTS']);
					$highest_pe_ARTS = mysqli_real_escape_string($_CON, $row['highest_pe_ARTS']);
					// PE
					$written_word_PE = mysqli_real_escape_string($_CON, $row['written_word_PE']);
					$highest_ww_PE = mysqli_real_escape_string($_CON, $row['highest_ww_PE']);
					$performance_task_PE = mysqli_real_escape_string($_CON, $row['performance_task_PE']);
					$highest_pt_PE = mysqli_real_escape_string($_CON, $row['highest_pt_PE']);
					$periodical_exam_PE = mysqli_real_escape_string($_CON, $row['periodical_exam_PE']);
					$highest_pe_PE = mysqli_real_escape_string($_CON, $row['highest_pe_PE']);
					// HEALTH
					$written_word_HEALTH = mysqli_real_escape_string($_CON, $row['written_word_HEALTH']);
					$highest_ww_HEALTH = mysqli_real_escape_string($_CON, $row['highest_ww_HEALTH']);
					$performance_task_HEALTH = mysqli_real_escape_string($_CON, $row['performance_task_HEALTH']);
					$highest_pt_HEALTH = mysqli_real_escape_string($_CON, $row['highest_pt_HEALTH']);
					$periodical_exam_HEALTH = mysqli_real_escape_string($_CON, $row['periodical_exam_HEALTH']);
					$highest_pe_HEALTH = mysqli_real_escape_string($_CON, $row['highest_pe_HEALTH']);
					
					$myReturn = "
					  <table class='table table-bordered'>
					   <tbody>
						  <tr>
							<th colspan='2'>NEW GRADES</th>
						  </tr>
						  <tr>
							<th colspan='2'>MUSIC</th>
						  </tr>
						  <tr>
							<td colspan='2'>WRITTEN WORK</td>
						  </tr>
						  <tr>
							<td>TOTAL SCORE</td>
							<td>HIGHEST SCORE</td>
						  </tr>
						  <tr>
							<td>$written_word</td>
							<td>$highest_ww</td>
						  </tr>
						  <tr>
							<td colspan='2'>PERFORMANCE TASK</td>
						  </tr>
						  <tr>
							<td>TOTAL SCORE</td>
							<td>HIGHEST SCORE</td>
						  </tr>
						  <tr>
							<td>$performance_task</td>
							<td>$highest_pt</td>
						  </tr>
						  <tr>
							<td colspan='2'>PERIODICAL EXAM</td>
						  </tr>
						  <tr>
							<td>TOTAL SCORE</td>
							<td>HIGHEST SCORE</td>
						  </tr>
						  <tr>
							<td>$periodical_exam</td>
							<td>$highest_pe</td>
						  </tr>
						  <tr>
							<th colspan='2'>ARTS</th>
						  </tr>
						  <tr>
							<td colspan='2'>WRITTEN WORK</td>
						  </tr>
						  <tr>
							<td>TOTAL SCORE</td>
							<td>HIGHEST SCORE</td>
						  </tr>
						  <tr>
							<td>$written_word_ARTS</td>
							<td>$highest_ww_ARTS</td>
						  </tr>
						  <tr>
							<td colspan='2'>PERFORMANCE TASK</td>
						  </tr>
						  <tr>
							<td>TOTAL SCORE</td>
							<td>HIGHEST SCORE</td>
						  </tr>
						  <tr>
							<td>$performance_task_ARTS</td>
							<td>$highest_pt_ARTS</td>
						  </tr>
						  <tr>
							<td colspan='2'>PERIODICAL EXAM</td>
						  </tr>
						  <tr>
							<td>TOTAL SCORE</td>
							<td>HIGHEST SCORE</td>
						  </tr>
						  <tr>
							<td>$periodical_exam_ARTS</td>
							<td>$highest_pe_ARTS</td>
						  </tr>
						  <tr>
							<th colspan='2'>PE</th>
						  </tr>
						  <tr>
							<td colspan='2'>WRITTEN WORK</td>
						  </tr>
						  <tr>
							<td>TOTAL SCORE</td>
							<td>HIGHEST SCORE</td>
						  </tr>
						  <tr>
							<td>$written_word_PE</td>
							<td>$highest_ww_PE</td>
						  </tr>
						  <tr>
							<td colspan='2'>PERFORMANCE TASK</td>
						  </tr>
						  <tr>
							<td>TOTAL SCORE</td>
							<td>HIGHEST SCORE</td>
						  </tr>
						  <tr>
							<td>$performance_task_PE</td>
							<td>$highest_pt_PE</td>
						  </tr>
						  <tr>
							<td colspan='2'>PERIODICAL EXAM</td>
						  </tr>
						  <tr>
							<td>TOTAL SCORE</td>
							<td>HIGHEST SCORE</td>
						  </tr>
						  <tr>
							<td>$periodical_exam_PE</td>
							<td>$highest_pe_PE</td>
						  </tr>
						  <tr>
							<th colspan='2'><strong>HEALTH</strong></th>
						  </tr>
						  <tr>
							<td colspan='2'>WRITTEN WORK</td>
						  </tr>
						  <tr>
							<td>TOTAL SCORE</td>
							<td>HIGHEST SCORE</td>
						  </tr>
						  <tr>
							<td>$written_word_HEALTH</td>
							<td>$highest_ww_HEALTH</td>
						  </tr>
						  <tr>
							<td colspan='2'>PERFORMANCE TASK</td>
						  </tr>
						  <tr>
							<td>TOTAL SCORE</td>
							<td>HIGHEST SCORE</td>
						  </tr>
						  <tr>
							<td>$performance_task_HEALTH</td>
							<td>$highest_pt_HEALTH</td>
						  </tr>
						  <tr>
							<td colspan='2'>PERIODICAL EXAM</td>
						  </tr>
						  <tr>
							<td>TOTAL SCORE</td>
							<td>HIGHEST SCORE</td>
						  </tr>
						  <tr>
							<td>$periodical_exam_HEALTH</td>
							<td>$highest_pe_HEALTH</td>
						  </tr>
					   </tbody>
					  </table>					
					";
					return $myReturn;
			}else{
				return "No Old Grade";
			}
		}else{
			if($isMAPEH == 0){
			$sqlSearch = mysqli_query($_CON,"
			SELECT * 
			FROM
			grades_table
			WHERE
			student_id='$student_id'
			AND
			teacher_id='$teacher_id'
			AND
			subject_id='$subject_id'
			AND
			grading_period='$grading_period'
			AND
			school_year='$school_year'");
			$count = mysqli_num_rows($sqlSearch);
			if($count == 1){
					$row=mysqli_fetch_array($sqlSearch);
					$written_word = mysqli_real_escape_string($_CON, $row['written_word']);
					$highest_ww = mysqli_real_escape_string($_CON, $row['highest_ww']);
					$performance_task = mysqli_real_escape_string($_CON, $row['performance_task']);
					$highest_pt = mysqli_real_escape_string($_CON, $row['highest_pt']);
					$periodical_exam = mysqli_real_escape_string($_CON, $row['periodical_exam']);
					$highest_pe = mysqli_real_escape_string($_CON, $row['highest_pe']);
					$grading_period = mysqli_real_escape_string($_CON, $row['grading_period']);
					$myReturn = "
					  <table class='table table-bordered'>
					   <tbody>
						  <tr>
							<th colspan='2'>OLD GRADES</th>
						  </tr>
						  <tr>
							<td colspan='2'>WRITTEN WORK</td>
						  </tr>
						  <tr>
							<td>TOTAL SCORE</td>
							<td>HIGHEST SCORE</td>
						  </tr>
						  <tr>
							<td>$written_word</td>
							<td>$highest_ww</td>
						  </tr>
						  <tr>
							<td colspan='2'>PERFORMANCE TASK</td>
						  </tr>
						  <tr>
							<td>TOTAL SCORE</td>
							<td>HIGHEST SCORE</td>
						  </tr>
						  <tr>
							<td>$performance_task</td>
							<td>$highest_pt</td>
						  </tr>
						  <tr>
							<td colspan='2'>PERIODICAL EXAM</td>
						  </tr>
						  <tr>
							<td>TOTAL SCORE</td>
							<td>HIGHEST SCORE</td>
						  </tr>
						  <tr>
							<td>$periodical_exam</td>
							<td>$highest_pe</td>
						  </tr>
					   </tbody>
					  </table>
					";
					return $myReturn;
				}else{
					return "No Old Grade";
				}
			}
		}
	}
	
/////////////////////////////////////////////
//VIEW GRADES VIEW
	function grantMod(){
		global $_CON;
		$sqlSearch = mysqli_query($_CON, "
		SELECT *
		FROM
		change_grades_table");
		$count = mysqli_num_rows($sqlSearch);
		if($count > 0){
			while($row=mysqli_fetch_array($sqlSearch)){
				$_ID = mysqli_real_escape_string($_CON, $row['change_grade_id']);
				$student_id = mysqli_real_escape_string($_CON, $row['student_id']);
				////////////////////////////////////////
				//GET PUPIL NAME 
				$sqlStudent = mysqli_query($_CON,"SELECT 
				pupil_fname,
				pupil_lname
				FROM
				pupils_table
				WHERE
				pupil_id='$student_id'");
				$row_pupil = mysqli_fetch_array($sqlStudent);
				$pupil_fname = $row_pupil['pupil_fname'];
				$pupil_lname = $row_pupil['pupil_lname'];
				////////////////////////////////////////
				$teacher_id = mysqli_real_escape_string($_CON, $row['teacher_id']);
				////////////////////////////////////////
				//GET TEACHER NAME
				$sqlTeacher = mysqli_query($_CON,"SELECT 
				teacher_fname,
				teacher_lname
				FROM
				teachers_table
				WHERE
				teacher_id='$teacher_id'");
				$row_teacher = mysqli_fetch_array($sqlTeacher);
				$teacher_fname = $row_teacher['teacher_fname'];
				$teacher_lname = $row_teacher['teacher_lname'];
				////////////////////////////////////////
				$subject_id = mysqli_real_escape_string($_CON, $row['subject_id']);
				////////////////////////////////////////
				//GET SUBJECT NAME
				$sqlSubj = mysqli_query($_CON,"SELECT 
				subject_name
				FROM
				subjects_table 
				WHERE
				subject_id='$subject_id'");
				$row_subj = mysqli_fetch_array($sqlSubj);
				$subject_name = $row_subj['subject_name'];
				////////////////////////////////////////
				$grading_period = mysqli_real_escape_string($_CON, $row['grading_period']);
				$school_year = mysqli_real_escape_string($_CON, $row['school_year']);
				$isMAPEH = mysqli_real_escape_string($_CON, $row['isMAPEH']);
				$oldGrd = oldGrade($student_id,$teacher_id,$subject_id,$grading_period,$school_year,$isMAPEH);
				$pupil_grade_lvl = mysqli_real_escape_string($_CON, $row['pupil_grade_lvl']);
				$section_name = mysqli_real_escape_string($_CON, $row['section_name']);
				$date_graded = mysqli_real_escape_string($_CON, $row['date_graded']);
					echo"
				<!--Modal Start-->
				<div class='modal fade' id='acceptMOD$_ID' tabindex='-1' role='dialog' aria-labelledby='myModalLabel' aria-hidden='true'>
					<div class='modal-dialog modal-lg'>
						<div class='modal-content'>
							<form action='"; grantAction(); echo"' method='post'>
							<div class='modal-header'>
								<button type='button' class='close' data-dismiss='modal' aria-hidden='true'>&times;</button>
								<h4 class='modal-title'>Prompt</h4>
							</div>
							<div class='modal-body'>
								<h3>Are you sure you want to grant this request?</h3>
							</div>
							<div class='modal-footer'>
								<input type='hidden' name='DEL_ID' value='$_ID'>
								<input type='hidden' name='student_id' value='$student_id'>
								<input type='hidden' name='teacher_id' value='$teacher_id'>
								<input type='hidden' name='subject_id' value='$subject_id'>
								<input type='hidden' name='grading_period' value='$grading_period'>
								<input type='hidden' name='school_year' value='$school_year'>
								<input type='hidden' name='isMAPEH' value='$isMAPEH'>
								<button type='button' class='btn btn-danger pull-left' data-dismiss='modal'>Close</button>
								<button type='submit' name='btn_upd' class='btn btn-primary pull-right'>Grant</button>
							</div>
							</form>
						</div>
					</div>
				</div>";
			}
		}
	}
	
/////////////////////////////////////////////
//GET OLD GRADE VIEW
	function grantAction(){
		global $_CON;
		global $_NOW;
		if(isset($_POST['btn_upd'])){
			$_ID = mysqli_real_escape_string($_CON,$_POST['DEL_ID']);
			$student_id = mysqli_real_escape_string($_CON,$_POST['student_id']);
			$teacher_id = mysqli_real_escape_string($_CON,$_POST['teacher_id']);
			$subject_id = mysqli_real_escape_string($_CON,$_POST['subject_id']);
			$grading_period = mysqli_real_escape_string($_CON,$_POST['grading_period']);
			$school_year = mysqli_real_escape_string($_CON,$_POST['school_year']);
			$isMAPEH = mysqli_real_escape_string($_CON,$_POST['isMAPEH']);
			if($isMAPEH == 1){
				$sqlSearch = mysqli_query($_CON,"
				SELECT * 
				FROM
				change_grades_table
				WHERE
				student_id='$student_id'
				AND
				teacher_id='$teacher_id'
				AND
				subject_id='$subject_id'
				AND
				grading_period='$grading_period'
				AND
				school_year='$school_year'");
				$count = mysqli_num_rows($sqlSearch);
				if($count == 1){
						$row=mysqli_fetch_array($sqlSearch);
						//MUSIC
						$_ID = mysqli_real_escape_string($_CON, $row['change_grade_id']);
						$written_word = mysqli_real_escape_string($_CON, $row['written_word']);
						$highest_ww = mysqli_real_escape_string($_CON, $row['highest_ww']);
						$performance_task = mysqli_real_escape_string($_CON, $row['performance_task']);
						$highest_pt = mysqli_real_escape_string($_CON, $row['highest_pt']);
						$periodical_exam = mysqli_real_escape_string($_CON, $row['periodical_exam']);
						$highest_pe = mysqli_real_escape_string($_CON, $row['highest_pe']);
						$grading_period = mysqli_real_escape_string($_CON, $row['grading_period']);
						// ARTS
						$written_word_ARTS = mysqli_real_escape_string($_CON, $row['written_word_ARTS']);
						$highest_ww_ARTS = mysqli_real_escape_string($_CON, $row['highest_ww_ARTS']);
						$performance_task_ARTS = mysqli_real_escape_string($_CON, $row['performance_task_ARTS']);
						$highest_pt_ARTS = mysqli_real_escape_string($_CON, $row['highest_pt_ARTS']);
						$periodical_exam_ARTS = mysqli_real_escape_string($_CON, $row['periodical_exam_ARTS']);
						$highest_pe_ARTS = mysqli_real_escape_string($_CON, $row['highest_pe_ARTS']);
						// PE
						$written_word_PE = mysqli_real_escape_string($_CON, $row['written_word_PE']);
						$highest_ww_PE = mysqli_real_escape_string($_CON, $row['highest_ww_PE']);
						$performance_task_PE = mysqli_real_escape_string($_CON, $row['performance_task_PE']);
						$highest_pt_PE = mysqli_real_escape_string($_CON, $row['highest_pt_PE']);
						$periodical_exam_PE = mysqli_real_escape_string($_CON, $row['periodical_exam_PE']);
						$highest_pe_PE = mysqli_real_escape_string($_CON, $row['highest_pe_PE']);
						// HEALTH
						$written_word_HEALTH = mysqli_real_escape_string($_CON, $row['written_word_HEALTH']);
						$highest_ww_HEALTH = mysqli_real_escape_string($_CON, $row['highest_ww_HEALTH']);
						$performance_task_HEALTH = mysqli_real_escape_string($_CON, $row['performance_task_HEALTH']);
						$highest_pt_HEALTH = mysqli_real_escape_string($_CON, $row['highest_pt_HEALTH']);
						$periodical_exam_HEALTH = mysqli_real_escape_string($_CON, $row['periodical_exam_HEALTH']);
						$highest_pe_HEALTH = mysqli_real_escape_string($_CON, $row['highest_pe_HEALTH']);
						
						$sqlUpdate = mysqli_query($_CON,"
						UPDATE
						grades_table
						SET
						written_word='$written_word',
						highest_ww='$highest_ww',
						performance_task='$performance_task',
						highest_pt='$highest_pt',
						periodical_exam='$periodical_exam',
						highest_pe='$highest_pe',
						date_graded='$_NOW',
						written_word_ARTS='$written_word_ARTS',
						highest_ww_ARTS='$highest_ww_ARTS',
						performance_task_ARTS='$performance_task_ARTS',
						highest_pt_ARTS='$highest_pt_ARTS',
						periodical_exam_ARTS='$periodical_exam_ARTS',
						highest_pe_ARTS='$highest_pe_ARTS',
						written_word_PE='$written_word_PE',
						highest_ww_PE='$highest_ww_PE',
						performance_task_PE='$performance_task_PE',
						highest_pt_PE='$highest_pt_PE',
						periodical_exam_PE='$periodical_exam_PE',
						highest_pe_PE='$highest_pe_PE',
						written_word_HEALTH='$written_word_HEALTH',
						highest_ww_HEALTH='$highest_ww_HEALTH',
						performance_task_HEALTH='$performance_task_HEALTH',
						highest_pt_HEALTH='$highest_pt_HEALTH',
						periodical_exam_HEALTH='$periodical_exam_HEALTH',
						highest_pe_HEALTH='$highest_pe_HEALTH'
						WHERE
						student_id='$student_id'
						AND
						teacher_id='$teacher_id'
						AND
						subject_id='$subject_id'
						AND
						grading_period='$grading_period'
						AND
						school_year='$school_year'
						");
						$sqlDelete = mysqli_query($_CON,"DELETE FROM change_grades_table WHERE change_grade_id='$_ID'");
						header("location: grade.request.php?grade=changed");
						ob_end_clean();
						exit;
				}else{
					header("location: grade.request.php?grade=404");
					ob_end_clean();
					exit;
				}
			}else{
				if($isMAPEH == 0){
				$sqlSearch = mysqli_query($_CON,"
				SELECT * 
				FROM
				change_grades_table
				WHERE
				student_id='$student_id'
				AND
				teacher_id='$teacher_id'
				AND
				subject_id='$subject_id'
				AND
				grading_period='$grading_period'
				AND
				school_year='$school_year'");
				$count = mysqli_num_rows($sqlSearch);
				if($count == 1){
						$row=mysqli_fetch_array($sqlSearch);
						$written_word = mysqli_real_escape_string($_CON, $row['written_word']);
						$highest_ww = mysqli_real_escape_string($_CON, $row['highest_ww']);
						$performance_task = mysqli_real_escape_string($_CON, $row['performance_task']);
						$highest_pt = mysqli_real_escape_string($_CON, $row['highest_pt']);
						$periodical_exam = mysqli_real_escape_string($_CON, $row['periodical_exam']);
						$highest_pe = mysqli_real_escape_string($_CON, $row['highest_pe']);
						$grading_period = mysqli_real_escape_string($_CON, $row['grading_period']);
						$sqlUpdate = mysqli_query($_CON,"
						UPDATE
						grades_table
						SET
						written_word='$written_word',
						highest_ww='$highest_ww',
						performance_task='$performance_task',
						highest_pt='$highest_pt',
						periodical_exam='$periodical_exam',
						highest_pe='$highest_pe',
						date_graded='$_NOW'
						WHERE
						student_id='$student_id'
						AND
						teacher_id='$teacher_id'
						AND
						subject_id='$subject_id'
						AND
						grading_period='$grading_period'
						AND
						school_year='$school_year'
						");
						$sqlDelete = mysqli_query($_CON,"DELETE FROM change_grades_table WHERE change_grade_id='$_ID'");
						header("location: grade.request.php?grade=changed");
						ob_end_clean();
						exit;
					}
				}else{
					header("location: grade.request.php?grade=404");
					ob_end_clean();
					exit;
				}
			}
		}
	}
	
/////////////////////////////////////////////
//VIEW GRADES VIEW
	function delMod(){
		global $_CON;
		$sqlSearch = mysqli_query($_CON, "
		SELECT *
		FROM
		change_grades_table");
		$count = mysqli_num_rows($sqlSearch);
		if($count > 0){
			while($row=mysqli_fetch_array($sqlSearch)){
				$_ID = mysqli_real_escape_string($_CON, $row['change_grade_id']);
				$student_id = mysqli_real_escape_string($_CON, $row['student_id']);
				////////////////////////////////////////
				//GET PUPIL NAME 
				$sqlStudent = mysqli_query($_CON,"SELECT 
				pupil_fname,
				pupil_lname
				FROM
				pupils_table
				WHERE
				pupil_id='$student_id'");
				$row_pupil = mysqli_fetch_array($sqlStudent);
				$pupil_fname = $row_pupil['pupil_fname'];
				$pupil_lname = $row_pupil['pupil_lname'];
				////////////////////////////////////////
				$teacher_id = mysqli_real_escape_string($_CON, $row['teacher_id']);
				////////////////////////////////////////
				//GET TEACHER NAME
				$sqlTeacher = mysqli_query($_CON,"SELECT 
				teacher_fname,
				teacher_lname
				FROM
				teachers_table
				WHERE
				teacher_id='$teacher_id'");
				$row_teacher = mysqli_fetch_array($sqlTeacher);
				$teacher_fname = $row_teacher['teacher_fname'];
				$teacher_lname = $row_teacher['teacher_lname'];
				////////////////////////////////////////
				$subject_id = mysqli_real_escape_string($_CON, $row['subject_id']);
				////////////////////////////////////////
				//GET SUBJECT NAME
				$sqlSubj = mysqli_query($_CON,"SELECT 
				subject_name
				FROM
				subjects_table 
				WHERE
				subject_id='$subject_id'");
				$row_subj = mysqli_fetch_array($sqlSubj);
				$subject_name = $row_subj['subject_name'];
				////////////////////////////////////////
				$grading_period = mysqli_real_escape_string($_CON, $row['grading_period']);
				$school_year = mysqli_real_escape_string($_CON, $row['school_year']);
				$isMAPEH = mysqli_real_escape_string($_CON, $row['isMAPEH']);
				$oldGrd = oldGrade($student_id,$teacher_id,$subject_id,$grading_period,$school_year,$isMAPEH);
				$pupil_grade_lvl = mysqli_real_escape_string($_CON, $row['pupil_grade_lvl']);
				$section_name = mysqli_real_escape_string($_CON, $row['section_name']);
				$date_graded = mysqli_real_escape_string($_CON, $row['date_graded']);
					echo"
				<!--Modal Start-->
				<div class='modal fade' id='delMod$_ID' tabindex='-1' role='dialog' aria-labelledby='myModalLabel' aria-hidden='true'>
					<div class='modal-dialog modal-lg'>
						<div class='modal-content'>
							<form action='"; delAction(); echo"' method='post'>
							<div class='modal-header'>
								<button type='button' class='close' data-dismiss='modal' aria-hidden='true'>&times;</button>
								<h4 class='modal-title'>Prompt</h4>
							</div>
							<div class='modal-body'>
								<h3>Are you sure you want to delete this request?</h3>
							</div>
							<div class='modal-footer'>
								<input type='hidden' name='DEL_ID' value='$_ID'>
								<button type='button' class='btn btn-danger pull-left' data-dismiss='modal'>Close</button>
								<button name='del_btn' type='submit' class='btn btn-primary pull-right'>Delete</button>
							</div>
							</form>
						</div>
					</div>
				</div>";
			}
		}
	}
	
function delAction(){
	global $_CON;
	if(isset($_POST['del_btn'])){
		$_ID = mysqli_real_escape_string($_CON, $_POST['DEL_ID']);
		$sqlDelete = mysqli_query($_CON,"DELETE FROM change_grades_table WHERE change_grade_id='$_ID'");
		header("location: grade.request.php?del=true");
		ob_end_clean();
		exit;
	}
}