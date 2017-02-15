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
		$last_yr = $_YEAR - 1;
		$sy = $last_yr."-".$_YEAR;
		$student_id_Dec = returnID();
		$sqlSearch = mysqli_query($_CON, 
		"SELECT
		*
		FROM
		grades_table
		WHERE
		student_id='$student_id_Dec'
		AND	
		school_year='$sy'
		GROUP BY
		subject_id");
		$count = mysqli_num_rows($sqlSearch);
		if($count > 0){
			while($row=mysqli_fetch_array($sqlSearch)){
				$subject_id = $row['subject_id'];
				$getSubjectType = mysqli_query($_CON, "SELECT subject_name FROM subjects_table WHERE subject_id='$subject_id'");
				$_row_subjType = mysqli_fetch_array($getSubjectType);
				$subject_name = $_row_subjType['subject_name'];
				
				$teacher_id = $row['teacher_id'];
				$isMapeh = $row['isMAPEH'];
				$firstGrad = firstGrad($student_id_Dec,$teacher_id,$subject_id,$isMapeh,$sy);
				$secGrad = secGrad($student_id_Dec,$teacher_id,$subject_id,$isMapeh,$sy);
				$triGrad = triGrad($student_id_Dec,$teacher_id,$subject_id,$isMapeh,$sy);
				$fourGrad = fourGrad($student_id_Dec,$teacher_id,$subject_id,$isMapeh,$sy);
				$finalGrade = finalGrade($firstGrad,$secGrad,$triGrad,$fourGrad);
				$generalAve = genAve($finalGrade);
				echo"
				  <tr>
					<td>$subject_name</td>
					<td>$firstGrad</td>
					<td>$secGrad</td>
					<td>$triGrad</td>
					<td>$fourGrad</td>
					<td>$finalGrade</td>
				  </tr>
				";
			}
				echo"
			   <tfoot>
				  <tr>
					<td colspan='5' style='text-align:right;'>GENERAL AVERAGE</td>
					<td>$generalAve</td>
				  </tr>
			   </tfoot>";
		}else{
			echo"
				<tr>
				<td colspan='6'>No data</td>
				</tr>
			";
		}
	}
	
	function genAve($finalGrade){
		$generalAverage = array($finalGrade);
		//$generalAverage = array(85,90,83,86,91,90,81,85);
		if(in_array("",$generalAverage)){
			return "INC";
		}else{
			$sum = array_sum($generalAverage);
			$genAve = $sum/count($generalAverage);
			return round($genAve, 0, PHP_ROUND_HALF_UP);
		}
	}
	
	function finalGrade($firstGrad,$secGrad,$triGrad,$fourGrad){
		global $_CON;
		if(empty($firstGrad) || empty($secGrad) || empty($triGrad) || empty($fourGrad)){
			return "";
		}else{
			$ave = ($firstGrad + $secGrad + $triGrad + $fourGrad) / 4;
			$ave = round($ave, 0, PHP_ROUND_HALF_UP);
			return $ave;
		}
	}
	
	function firstGrad($student_id,$teacher_id,$subject_id,$isMapeh,$sy){
		global $_CON;
		if($isMapeh == 1){
			//MAPEH SUBJECT
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
			grading_period=1
			AND
			school_year='$sy'");
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
					$RoundedGrd = roundedGrd($_AVERAGE);
					return $RoundedGrd;
					
					//return $_AVERAGE;
			}else{
				return "";
			}
		}elseif($isMapeh == 0){
			///////////////////
			//REGULAR SUBJECTS
			$sqlSearch = mysqli_query($_CON,"
			SELECT
			* 
			FROM
			grades_table
			WHERE
			student_id='$student_id'
			AND
			teacher_id='$teacher_id'
			AND
			subject_id='$subject_id'
			AND
			grading_period=1
			AND
			school_year='$sy'");
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

				$RoundedGrd = roundedGrd($_OVERALL);
				return $RoundedGrd;
			}else{
				return "";
			}
		}
	}
	
	function secGrad($student_id,$teacher_id,$subject_id,$isMapeh,$sy){
		global $_CON;
		if($isMapeh == 1){
			//MAPEH SUBJECT
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
			grading_period=2
			AND
			school_year='$sy'");
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
					$RoundedGrd = roundedGrd($_AVERAGE);
					return $RoundedGrd;
					
					//return $_AVERAGE;
			}else{
				return "";
			}
		}elseif($isMapeh == 0){
			///////////////////
			//REGULAR SUBJECTS
			$sqlSearch = mysqli_query($_CON,"
			SELECT
			* 
			FROM
			grades_table
			WHERE
			student_id='$student_id'
			AND
			teacher_id='$teacher_id'
			AND
			subject_id='$subject_id'
			AND
			grading_period=2
			AND
			school_year='$sy'");
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
				
				$RoundedGrd = roundedGrd($_OVERALL);
				return $RoundedGrd;
			}else{
				return "";
			}
		}
	}
	
	function triGrad($student_id,$teacher_id,$subject_id,$isMapeh,$sy){
		global $_CON;
		if($isMapeh == 1){
			//MAPEH SUBJECT
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
			grading_period=3
			AND
			school_year='$sy'");
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
					$RoundedGrd = roundedGrd($_AVERAGE);
					return $RoundedGrd;
					
					//return $_AVERAGE;
			}else{
				return "";
			}
		}elseif($isMapeh == 0){
			///////////////////
			//REGULAR SUBJECTS
			$sqlSearch = mysqli_query($_CON,"
			SELECT
			* 
			FROM
			grades_table
			WHERE
			student_id='$student_id'
			AND
			teacher_id='$teacher_id'
			AND
			subject_id='$subject_id'
			AND
			grading_period=3
			AND
			school_year='$sy'");
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

				$RoundedGrd = roundedGrd($_OVERALL);
				return $RoundedGrd;
			}else{
				return "";
			}
		}
	}
	
	function fourGrad($student_id,$teacher_id,$subject_id,$isMapeh,$sy){
		global $_CON;
		if($isMapeh == 1){
			//MAPEH SUBJECT
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
			grading_period=4
			AND
			school_year='$sy'");
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
					$RoundedGrd = roundedGrd($_AVERAGE);
					return $RoundedGrd;
					
					//return $_AVERAGE;
			}else{
				return "";
			}
		}elseif($isMapeh == 0){
			///////////////////
			//REGULAR SUBJECTS
			$sqlSearch = mysqli_query($_CON,"
			SELECT
			* 
			FROM
			grades_table
			WHERE
			student_id='$student_id'
			AND
			teacher_id='$teacher_id'
			AND
			subject_id='$subject_id'
			AND
			grading_period=4
			AND
			school_year='$sy'");
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

				$RoundedGrd = roundedGrd($_OVERALL);
				return $RoundedGrd;
			}else{
				return "";
			}
		}
	}
	
	function roundedGrd($rndGrd){
		if($rndGrd >= 0 && $rndGrd <= 3.99){
			$roundedgrd = 60;
		}elseif($rndGrd >= 4.00 && $rndGrd <= 7.99){
			$roundedgrd = 61;
		}elseif($rndGrd >= 8.00 && $rndGrd <= 11.99){
			$roundedgrd = 62;
		}elseif($rndGrd >= 12.00 && $rndGrd <= 15.99){
			$roundedgrd = 63;
		}elseif($rndGrd >= 16.00 && $rndGrd <= 19.99){
			$roundedgrd = 64;
		}elseif($rndGrd >= 20.00 && $rndGrd <= 23.99){
			$roundedgrd = 65;
		}elseif($rndGrd >= 24.00 && $rndGrd <= 27.99){
			$roundedgrd = 66;
		}elseif($rndGrd >= 28.00 && $rndGrd <= 31.99){
			$roundedgrd = 67;
		}elseif($rndGrd >= 32.00 && $rndGrd <= 35.99){
			$roundedgrd = 68;
		}elseif($rndGrd >= 36.00 && $rndGrd <= 39.99){
			$roundedgrd = 69;
		}elseif($rndGrd >= 40.00 && $rndGrd <= 43.99){
			$roundedgrd = 70;
		}elseif($rndGrd >= 44.00 && $rndGrd <= 47.99){
			$roundedgrd = 71;
		}elseif($rndGrd >= 48.00 && $rndGrd <= 51.99){
			$roundedgrd = 72;
		}elseif($rndGrd >= 52.00 && $rndGrd <= 55.99){
			$roundedgrd = 73;
		}elseif($rndGrd >= 56.00 && $rndGrd <= 59.99){
			$roundedgrd = 74;
		}elseif($rndGrd >= 60.00 && $rndGrd <= 61.59){
			$roundedgrd = 75;
		}elseif($rndGrd >= 61.60 && $rndGrd <= 63.19){
			$roundedgrd = 76;
		}elseif($rndGrd >= 63.20 && $rndGrd <= 64.79){
			$roundedgrd = 77;
		}elseif($rndGrd >= 64.80 && $rndGrd <= 66.39){
			$roundedgrd = 78;
		}elseif($rndGrd >= 66.40 && $rndGrd <= 67.99){
			$roundedgrd = 79;
		}elseif($rndGrd >= 68.00 && $rndGrd <= 69.59){
			$roundedgrd = 80;
		}elseif($rndGrd >= 69.60 && $rndGrd <= 71.19){
			$roundedgrd = 81;
		}elseif($rndGrd >= 71.20 && $rndGrd <= 72.79){
			$roundedgrd = 82;
		}elseif($rndGrd >= 72.80 && $rndGrd <= 74.39){
			$roundedgrd = 83;
		}elseif($rndGrd >= 74.40 && $rndGrd <= 75.99){
			$roundedgrd = 84;
		}elseif($rndGrd >= 76.00 && $rndGrd <= 77.59){
			$roundedgrd = 85;
		}elseif($rndGrd >= 77.60 && $rndGrd <= 79.19){
			$roundedgrd = 86;
		}elseif($rndGrd >= 79.20 && $rndGrd <= 80.79){
			$roundedgrd = 87;
		}elseif($rndGrd >= 80.80 && $rndGrd <= 82.39){
			$roundedgrd = 88;
		}elseif($rndGrd >= 82.40 && $rndGrd <= 83.99){
			$roundedgrd = 89;
		}elseif($rndGrd >= 84.00 && $rndGrd <= 85.59){
			$roundedgrd = 90;
		}elseif($rndGrd >= 85.60 && $rndGrd <= 87.19){
			$roundedgrd = 91;
		}elseif($rndGrd >= 87.20 && $rndGrd <= 88.79){
			$roundedgrd = 92;
		}elseif($rndGrd >= 88.80 && $rndGrd <= 90.39){
			$roundedgrd = 93;
		}elseif($rndGrd >= 90.40 && $rndGrd <= 91.99){
			$roundedgrd = 94;
		}elseif($rndGrd >= 92.00 && $rndGrd <= 93.59){
			$roundedgrd = 95;
		}elseif($rndGrd >= 93.60 && $rndGrd <= 95.19){
			$roundedgrd = 96;
		}elseif($rndGrd >= 95.20 && $rndGrd <= 96.79){
			$roundedgrd = 97;
		}elseif($rndGrd >= 96.80 && $rndGrd <= 98.39){
			$roundedgrd = 98;
		}elseif($rndGrd >= 98.40 && $rndGrd <= 99.99){
			$roundedgrd = 99;
		}elseif($rndGrd >= 100 && $rndGrd <= 100){
			$roundedgrd = 100;
		}

		return $roundedgrd;
	}
	
	
	function returnID(){
		global $_CON;
		$_EIN = $_SESSION['parent_usr'];
		$sqlSearch = mysqli_query($_CON, "SELECT pupil_id FROM pupils_table WHERE pupil_cin='$_EIN'");
		$row = mysqli_fetch_array($sqlSearch);
		$_MYID = $row['pupil_id'];
		return $_MYID;
	}
	
	