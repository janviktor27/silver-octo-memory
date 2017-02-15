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
//Add pupils
	function add(){
		global $_CON;
		global $_NOW;
		global $_YEAR;
		$_TYPE_ID = type_id();
		$_DEC_ID = urldecode(base64_decode($_TYPE_ID));
		//////////////////////////////
		//FOR MAPEH
		if($_DEC_ID == 3){
		// IF SUBMITTED
			if(isset($_POST['btn_add'])){
				$last_year = $_YEAR - 1;
				$sy = $last_year."-".$_YEAR;
				//GET DATA FROM URL
				$period_id = period_id();
				$grad_period = urldecode(base64_decode($period_id));
				$subj = subj_id();
				$this_subject = urldecode(base64_decode($subj));
				$stud_id = stud_id();
				$stud_ID = urldecode(base64_decode($stud_id));

					// ENC THIS SUBJECT FOR URL AGAIN
					$_sub_jID = urlencode(base64_encode($this_subject));
				
				$teacher_id = returnID();
				//MUSIC POST
				$inpWWSTUDSCORE_MUSIC = mysqli_real_escape_string($_CON, $_POST['inpWWSTUDSCORE_MUSIC']);
				$inpWWHighest_MUSIC = mysqli_real_escape_string($_CON, $_POST['inpWWHighest_MUSIC']);
				$inpPTSTUDSCORE_MUSIC = mysqli_real_escape_string($_CON, $_POST['inpPTSTUDSCORE_MUSIC']);
				$inpPTHighest_MUSIC = mysqli_real_escape_string($_CON, $_POST['inpPTHighest_MUSIC']);
				$inpPESTUDSCORE_MUSIC = mysqli_real_escape_string($_CON, $_POST['inpPESTUDSCORE_MUSIC']);
				$inpPEHighest_MUSIC = mysqli_real_escape_string($_CON, $_POST['inpPEHighest_MUSIC']);
				//ARTS POST
				$inpWWSTUDSCORE_ARTS = mysqli_real_escape_string($_CON, $_POST['inpWWSTUDSCORE_ARTS']);
				$inpWWHighest_ARTS = mysqli_real_escape_string($_CON, $_POST['inpWWHighest_ARTS']);
				$inpPTSTUDSCORE_ARTS = mysqli_real_escape_string($_CON, $_POST['inpPTSTUDSCORE_ARTS']);
				$inpPTHighest_ARTS = mysqli_real_escape_string($_CON, $_POST['inpPTHighest_ARTS']);
				$inpPESTUDSCORE_ARTS = mysqli_real_escape_string($_CON, $_POST['inpPESTUDSCORE_ARTS']);
				$inpPEHighest_ARTS = mysqli_real_escape_string($_CON, $_POST['inpPEHighest_ARTS']);
				//PE POST
				$inpWWSTUDSCORE_PE = mysqli_real_escape_string($_CON, $_POST['inpWWSTUDSCORE_PE']);
				$inpWWHighest_PE = mysqli_real_escape_string($_CON, $_POST['inpWWHighest_PE']);
				$inpPTSTUDSCORE_PE = mysqli_real_escape_string($_CON, $_POST['inpPTSTUDSCORE_PE']);
				$inpPTHighest_PE = mysqli_real_escape_string($_CON, $_POST['inpPTHighest_PE']);
				$inpPESTUDSCORE_PE = mysqli_real_escape_string($_CON, $_POST['inpPESTUDSCORE_PE']);
				$inpPEHighest_PE = mysqli_real_escape_string($_CON, $_POST['inpPEHighest_PE']);
				//HEALTH POST
				$inpWWSTUDSCORE_HELT = mysqli_real_escape_string($_CON, $_POST['inpWWSTUDSCORE_HELT']);
				$inpWWHighest_HELT = mysqli_real_escape_string($_CON, $_POST['inpWWHighest_HELT']);
				$inpPTSTUDSCORE_HELT = mysqli_real_escape_string($_CON, $_POST['inpPTSTUDSCORE_HELT']);
				$inpPTHighest_HELT = mysqli_real_escape_string($_CON, $_POST['inpPTHighest_HELT']);
				$inpPESTUDSCORE_HELT = mysqli_real_escape_string($_CON, $_POST['inpPESTUDSCORE_HELT']);
				$inpPEHighest_HELT = mysqli_real_escape_string($_CON, $_POST['inpPEHighest_HELT']);
				/////////////////////////////////////////////////////////////////////////////////////////
				//GET PUPIL SECTION
				$sqlSection = mysqli_query($_CON, "SELECT section_id FROM pupils_table WHERE pupil_id='$stud_ID' ");
				$_row_sec = mysqli_fetch_array($sqlSection);
				$section_id = $_row_sec['section_id'];
				$_ENCSECTION = urlencode(base64_encode($section_id));
				//GET GRADE LEVEL AND SECTION NAME
				$sqlGradeLvl = mysqli_query($_CON, "SELECT gradelvl, section_name FROM section_table WHERE section_id='$section_id' ");
				$_row_grdlvl = mysqli_fetch_array($sqlGradeLvl);
				$gradelvl = $_row_grdlvl['gradelvl'];
				$section_name = $_row_grdlvl['section_name'];
				// CHECK IF THIS STUDENT ALREADY HAVE GRADE ON SPECIFIC SUBJECT
				$sqlSearch = mysqli_query($_CON, "SELECT * FROM grades_table WHERE student_id='$stud_ID' AND teacher_id='$teacher_id' AND subject_id='$this_subject' AND grading_period='$grad_period' AND school_year='$sy'");
				$count = mysqli_num_rows($sqlSearch);
				if($count == 1){
					ob_end_clean();
					header("location: view-this-class.php?this_sect=$_ENCSECTION&this_subject=$_sub_jID&add=exist");
				}else{
					$sqlInsert = mysqli_query($_CON, "INSERT INTO grades_table 
					(student_id,
					teacher_id,
					subject_id,
					written_word,
					highest_ww,
					performance_task,
					highest_pt,
					periodical_exam,
					highest_pe,
					pupil_grade_lvl,
					section_name,
					grading_period,
					school_year,
					date_graded,
					isMAPEH,
					written_word_ARTS,
					highest_ww_ARTS,
					performance_task_ARTS,
					highest_pt_ARTS,
					periodical_exam_ARTS,
					highest_pe_ARTS,
					written_word_PE,
					highest_ww_PE,
					performance_task_PE,
					highest_pt_PE,
					periodical_exam_PE,
					highest_pe_PE,
					written_word_HEALTH,
					highest_ww_HEALTH,
					performance_task_HEALTH,
					highest_pt_HEALTH,
					periodical_exam_HEALTH,
					highest_pe_HEALTH)
					VALUES(
					'$stud_ID',
					'$teacher_id',
					'$this_subject',
					'$inpWWSTUDSCORE_MUSIC',
					'$inpWWHighest_MUSIC',
					'$inpPTSTUDSCORE_MUSIC',
					'$inpPTHighest_MUSIC',
					'$inpPESTUDSCORE_MUSIC',
					'$inpPEHighest_MUSIC',
					'$gradelvl',
					'$section_name',
					'$grad_period',
					'$sy',
					'$_NOW',
					'1',
					'$inpWWSTUDSCORE_ARTS',
					'$inpWWHighest_ARTS',
					'$inpPTSTUDSCORE_ARTS',
					'$inpPTHighest_ARTS',
					'$inpPESTUDSCORE_ARTS',
					'$inpPEHighest_ARTS',
					'$inpWWSTUDSCORE_PE',
					'$inpWWHighest_PE',
					'$inpPTSTUDSCORE_PE',
					'$inpPTHighest_PE',
					'$inpPESTUDSCORE_PE',
					'$inpPEHighest_PE',
					'$inpWWSTUDSCORE_HELT',
					'$inpWWHighest_HELT',
					'$inpPTSTUDSCORE_HELT',
					'$inpPTHighest_HELT',
					'$inpPESTUDSCORE_HELT',
					'$inpPEHighest_HELT')");
					ob_end_clean();
					header("location: view-this-class.php?this_sect=$_ENCSECTION&this_subject=$_sub_jID&add=true&type='Mapeh'");
				}
			}
		}else{
		//////////////////////////////
		//FOR REGULAR SUBJECTS
		// IF SUBMITTED
			if(isset($_POST['btn_add'])){
				$last_year = $_YEAR - 1;
				$sy = $last_year."-".$_YEAR;
				//GET DATA FROM URL
				$period_id = period_id();
				$grad_period = urldecode(base64_decode($period_id));
				$subj = subj_id();
				$this_subject = urldecode(base64_decode($subj));
				$stud_id = stud_id();
				$stud_ID = urldecode(base64_decode($stud_id));

					// ENC THIS SUBJECT FOR URL AGAIN
					$_sub_jID = urlencode(base64_encode($this_subject));
				
				$teacher_id = returnID();
				//POST METHOD
				$inpWWSTUDSCORE = mysqli_real_escape_string($_CON, $_POST['inpWWSTUDSCORE']);
				$inpWWHighest = mysqli_real_escape_string($_CON, $_POST['inpWWHighest']);
				$inpPTSTUDSCORE = mysqli_real_escape_string($_CON, $_POST['inpPTSTUDSCORE']);
				$inpPTHighest = mysqli_real_escape_string($_CON, $_POST['inpPTHighest']);
				$inpPESTUDSCORE = mysqli_real_escape_string($_CON, $_POST['inpPESTUDSCORE']);
				$inpPEHighest = mysqli_real_escape_string($_CON, $_POST['inpPEHighest']);
				//GET PUPIL SECTION
				$sqlSection = mysqli_query($_CON, "SELECT section_id FROM pupils_table WHERE pupil_id='$stud_ID' ");
				$_row_sec = mysqli_fetch_array($sqlSection);
				$section_id = $_row_sec['section_id'];
				$_ENCSECTION = urlencode(base64_encode($section_id));
				//GET GRADE LEVEL AND SECTION NAME
				$sqlGradeLvl = mysqli_query($_CON, "SELECT gradelvl, section_name FROM section_table WHERE section_id='$section_id' ");
				$_row_grdlvl = mysqli_fetch_array($sqlGradeLvl);
				$gradelvl = $_row_grdlvl['gradelvl'];
				$section_name = $_row_grdlvl['section_name'];
				// CHECK IF THIS STUDENT ALREADY HAVE GRADE ON SPECIFIC SUBJECT
				$sqlSearch = mysqli_query($_CON, "SELECT * FROM grades_table WHERE student_id='$stud_ID' AND teacher_id='$teacher_id' AND subject_id='$this_subject' AND grading_period='$grad_period' AND school_year='$sy'");
				$count = mysqli_num_rows($sqlSearch);
				if($count == 1){
					ob_end_clean();
					header("location: view-this-class.php?this_sect=$_ENCSECTION&this_subject=$_sub_jID&add=exist");
				}else{
					$sqlInsert = mysqli_query($_CON, "INSERT INTO grades_table 
					(student_id,
					teacher_id,
					subject_id,
					written_word,
					highest_ww,
					performance_task,
					highest_pt,
					periodical_exam,
					highest_pe,
					pupil_grade_lvl,
					section_name,
					grading_period,
					school_year,
					date_graded)
					VALUES(
					'$stud_ID',
					'$teacher_id',
					'$this_subject',
					'$inpWWSTUDSCORE',
					'$inpWWHighest',
					'$inpPTSTUDSCORE',
					'$inpPTHighest',
					'$inpPESTUDSCORE',
					'$inpPEHighest',
					'$gradelvl',
					'$section_name',
					'$grad_period',
					'$sy',
					'$_NOW')");
					ob_end_clean();
					header("location: view-this-class.php?this_sect=$_ENCSECTION&this_subject=$_sub_jID&add=true");
				}
			}
		}
	}
/////////////////////////////////////////////
//VIEW PUPIL GRADES
	function theview(){
		global $_CON;
		global $_YEAR;
		$last_year = $_YEAR - 1;
		$sy = $last_year."-".$_YEAR;
		$_TYPE_ID = type_id();
		$_TYPEDEC_ID = urldecode(base64_decode($_TYPE_ID));
		$subj = subj_id();
		$this_subject = urldecode(base64_decode($subj));
		$stud_id = stud_id();
		$stud_ID = urldecode(base64_decode($stud_id));
		//////////////////////////////
		//FOR MAPEH
		if($_TYPEDEC_ID == 3){
			$getSubjectType = mysqli_query($_CON, "SELECT subject_type FROM subjects_table WHERE subject_id='$this_subject'");
			$_row_subjType = mysqli_fetch_array($getSubjectType);
			$subject_type = $_row_subjType['subject_type'];
			$sqlSearch = mysqli_query($_CON, "SELECT
			grade_id,
			written_word,
			highest_ww,
			performance_task,
			highest_pt,
			periodical_exam,
			highest_pe,
			grading_period,
			
			written_word_ARTS,
			highest_ww_ARTS,
			performance_task_ARTS,
			highest_pt_ARTS,
			periodical_exam_ARTS,
			highest_pe_ARTS,
			
			written_word_PE,
			highest_ww_PE,
			performance_task_PE,
			highest_pt_PE,
			periodical_exam_PE,
			highest_pe_PE,
			
			written_word_HEALTH,
			highest_ww_HEALTH,
			performance_task_HEALTH,
			highest_pt_HEALTH,
			periodical_exam_HEALTH,
			highest_pe_HEALTH
			
			FROM
			grades_table
			WHERE
			student_id='$stud_ID'
			AND
			subject_id='$this_subject' 
			AND
			school_year='$sy' ");
			$count = mysqli_num_rows($sqlSearch);
			if($count > 0){
					$writtenwork = .20;
					$perftask = .60;
					$periodical = .20;
					while($row=mysqli_fetch_array($sqlSearch)){
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
					echo"
					 <tr>
					  <td>$grading_period</td>
					  <td>$_AVERAGE</td>
					  <td>"; echo roundedGrd($_AVERAGE); echo"</td>
					  <td><button data-toggle='modal' data-target='#gradeinfo$_ID' class='btn btn-xs btn-info'><i class='fa fa-info-circle'></i></button></td>
					 </tr>
					";
				}
			}else{
				echo"
				<tr>
				 <td colspan='2'>No data yet.</td>
				</tr>
				";
			}			
		}else{
		//////////////////////////////
		//FOR REGULAR SUBJECTS
			$getSubjectType = mysqli_query($_CON, "SELECT subject_type FROM subjects_table WHERE subject_id='$this_subject'");
			$_row_subjType = mysqli_fetch_array($getSubjectType);
			$subject_type = $_row_subjType['subject_type'];
			$sqlSearch = mysqli_query($_CON, "SELECT
			grade_id,
			written_word,
			highest_ww,
			performance_task,
			highest_pt,
			periodical_exam,
			highest_pe,
			grading_period
			FROM
			grades_table
			WHERE
			student_id='$stud_ID'
			AND
			subject_id='$this_subject' 
			AND
			school_year='$sy' ");
			$count = mysqli_num_rows($sqlSearch);
			if($count > 0){
				while($row=mysqli_fetch_array($sqlSearch)){
					$_ID = mysqli_real_escape_string($_CON, $row['grade_id']);
					$written_word = mysqli_real_escape_string($_CON, $row['written_word']);
					$highest_ww = mysqli_real_escape_string($_CON, $row['highest_ww']);
					$performance_task = mysqli_real_escape_string($_CON, $row['performance_task']);
					$highest_pt = mysqli_real_escape_string($_CON, $row['highest_pt']);
					$periodical_exam = mysqli_real_escape_string($_CON, $row['periodical_exam']);
					$highest_pe = mysqli_real_escape_string($_CON, $row['highest_pe']);
					$grading_period = mysqli_real_escape_string($_CON, $row['grading_period']);
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
					  <td>$grading_period</td>
					  <td>$_OVERALL</td>
					  <td>"; echo roundedGrd($_OVERALL); echo"</td>
					  <td><button data-toggle='modal' data-target='#gradeinfo$_ID' class='btn btn-xs btn-info'><i class='fa fa-info-circle'></i></button></td>
					 </tr>
					";
				}
			}else{
				echo"
				<tr>
				 <td colspan='2'>No data yet.</td>
				</tr>
				";
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
	
////////////////////////////////
// DYNAMIC FORM
	function dynamicForm(){
		global $_CON;
		$_ID = type_id();
		$DEC_ID = urldecode(base64_decode($_ID));
		if($DEC_ID == 3){
			echo"
            <form class='form-horizontal' method='post' action='"; add(); echo"'>
            <div class='box-header with-border'>
			  <h2>MUSIC</h2>
              <h3 class='box-title'>Written Work</h3>
            </div>
            <!-- /.box-header -->
              <div class='box-body'>
				<div class='form-group'>
                  <label for='inpWWSTUDSCORE_MUSIC' class='col-sm-3 control-label'>Total score</label>
                  <div class='col-sm-9'>
                    <input type='text' class='form-control' name='inpWWSTUDSCORE_MUSIC' id='inpWWSTUDSCORE_MUSIC' placeholder='Pupil total score' required>
                  </div>
                </div>
                <div class='form-group'>
                  <label for='inpWWHighest_MUSIC' class='col-sm-3 control-label'>Highest score</label>

                  <div class='col-sm-9'>
                    <input type='text' class='form-control' name='inpWWHighest_MUSIC' id='inpWWHighest_MUSIC' placeholder='Highest possible score' required>
                  </div>
                </div>
              </div>
              <!-- /.box-body -->
            <div class='box-header with-border'>
              <h3 class='box-title'>Performance Task</h3>
            </div>
            <!-- /.box-header -->
              <div class='box-body'>
				<div class='form-group'>
                  <label for='inpPTSTUDSCORE_MUSIC' class='col-sm-3 control-label'>Total score</label>
                  <div class='col-sm-9'>
                    <input type='text' class='form-control' name='inpPTSTUDSCORE_MUSIC' id='inpPTSTUDSCORE_MUSIC' placeholder='Pupil total score' required>
                  </div>
                </div>
                <div class='form-group'>
                  <label for='inpPTHighest_MUSIC' class='col-sm-3 control-label'>Highest score</label>

                  <div class='col-sm-9'>
                    <input type='text' class='form-control' name='inpPTHighest_MUSIC' id='inpPTHighest_MUSIC' placeholder='Highest possible score' required>
                  </div>
                </div>
              </div>
              <!-- /.box-body -->
            <div class='box-header with-border'>
              <h3 class='box-title'>Periodical Exam</h3>
            </div>
            <!-- /.box-header -->
              <div class='box-body'>
				<div class='form-group'>
                  <label for='inpPESTUDSCORE_MUSIC' class='col-sm-3 control-label'>Total score</label>
                  <div class='col-sm-9'>
                    <input type='text' class='form-control' name='inpPESTUDSCORE_MUSIC' id='inpPESTUDSCORE_MUSIC' placeholder='Pupil total score' required>
                  </div>
                </div>
                <div class='form-group'>
                  <label for='inpPEHighest_MUSIC' class='col-sm-3 control-label'>Highest score</label>

                  <div class='col-sm-9'>
                    <input type='text' class='form-control' name='inpPEHighest_MUSIC' id='inpPEHighest_MUSIC' placeholder='Highest possible score' required>
                  </div>
                </div>
              </div>
              <!-- /.box-body -->
            <div class='box-header with-border'>
			  <h2>ARTS</h2>
              <h3 class='box-title'>Written Work</h3>
            </div>
            <!-- /.box-header -->
              <div class='box-body'>
				<div class='form-group'>
                  <label for='inpWWSTUDSCORE_ARTS' class='col-sm-3 control-label'>Total score</label>
                  <div class='col-sm-9'>
                    <input type='text' class='form-control' name='inpWWSTUDSCORE_ARTS' id='inpWWSTUDSCORE_ARTS' placeholder='Pupil total score' required>
                  </div>
                </div>
                <div class='form-group'>
                  <label for='inpWWHighest_ARTS' class='col-sm-3 control-label'>Highest score</label>

                  <div class='col-sm-9'>
                    <input type='text' class='form-control' name='inpWWHighest_ARTS' id='inpWWHighest_ARTS' placeholder='Highest possible score' required>
                  </div>
                </div>
              </div>
              <!-- /.box-body -->
            <div class='box-header with-border'>
              <h3 class='box-title'>Performance Task</h3>
            </div>
            <!-- /.box-header -->
              <div class='box-body'>
				<div class='form-group'>
                  <label for='inpPTSTUDSCORE_ARTS' class='col-sm-3 control-label'>Total score</label>
                  <div class='col-sm-9'>
                    <input type='text' class='form-control' name='inpPTSTUDSCORE_ARTS' id='inpPTSTUDSCORE_ARTS' placeholder='Pupil total score' required>
                  </div>
                </div>
                <div class='form-group'>
                  <label for='inpPTHighest_ARTS' class='col-sm-3 control-label'>Highest score</label>

                  <div class='col-sm-9'>
                    <input type='text' class='form-control' name='inpPTHighest_ARTS' id='inpPTHighest_ARTS' placeholder='Highest possible score' required>
                  </div>
                </div>
              </div>
              <!-- /.box-body -->
            <div class='box-header with-border'>
              <h3 class='box-title'>Periodical Exam</h3>
            </div>
            <!-- /.box-header -->
              <div class='box-body'>
				<div class='form-group'>
                  <label for='inpPESTUDSCORE_ARTS' class='col-sm-3 control-label'>Total score</label>
                  <div class='col-sm-9'>
                    <input type='text' class='form-control' name='inpPESTUDSCORE_ARTS' id='inpPESTUDSCORE_ARTS' placeholder='Pupil total score' required>
                  </div>
                </div>
                <div class='form-group'>
                  <label for='inpPEHighest_ARTS' class='col-sm-3 control-label'>Highest score</label>

                  <div class='col-sm-9'>
                    <input type='text' class='form-control' name='inpPEHighest_ARTS' id='inpPEHighest_ARTS' placeholder='Highest possible score' required>
                  </div>
                </div>
              </div>
              <!-- /.box-body -->
            <div class='box-header with-border'>
			  <h2>PE</h2>
              <h3 class='box-title'>Written Work</h3>
            </div>
            <!-- /.box-header -->
              <div class='box-body'>
				<div class='form-group'>
                  <label for='inpWWSTUDSCORE_PE' class='col-sm-3 control-label'>Total score</label>
                  <div class='col-sm-9'>
                    <input type='text' class='form-control' name='inpWWSTUDSCORE_PE' id='inpWWSTUDSCORE_PE' placeholder='Pupil total score' required>
                  </div>
                </div>
                <div class='form-group'>
                  <label for='inpWWHighest_PE' class='col-sm-3 control-label'>Highest score</label>

                  <div class='col-sm-9'>
                    <input type='text' class='form-control' name='inpWWHighest_PE' id='inpWWHighest_PE' placeholder='Highest possible score' required>
                  </div>
                </div>
              </div>
              <!-- /.box-body -->
            <div class='box-header with-border'>
              <h3 class='box-title'>Performance Task</h3>
            </div>
            <!-- /.box-header -->
              <div class='box-body'>
				<div class='form-group'>
                  <label for='inpPTSTUDSCORE_PE' class='col-sm-3 control-label'>Total score</label>
                  <div class='col-sm-9'>
                    <input type='text' class='form-control' name='inpPTSTUDSCORE_PE' id='inpPTSTUDSCORE_PE' placeholder='Pupil total score' required>
                  </div>
                </div>
                <div class='form-group'>
                  <label for='inpPTHighest_PE' class='col-sm-3 control-label'>Highest score</label>

                  <div class='col-sm-9'>
                    <input type='text' class='form-control' name='inpPTHighest_PE' id='inpPTHighest_PE' placeholder='Highest possible score' required>
                  </div>
                </div>
              </div>
              <!-- /.box-body -->
            <div class='box-header with-border'>
              <h3 class='box-title'>Periodical Exam</h3>
            </div>
            <!-- /.box-header -->
              <div class='box-body'>
				<div class='form-group'>
                  <label for='inpPESTUDSCORE_PE' class='col-sm-3 control-label'>Total score</label>
                  <div class='col-sm-9'>
                    <input type='text' class='form-control' name='inpPESTUDSCORE_PE' id='inpPESTUDSCORE_PE' placeholder='Pupil total score' required>
                  </div>
                </div>
                <div class='form-group'>
                  <label for='inpPEHighest_PE' class='col-sm-3 control-label'>Highest score</label>

                  <div class='col-sm-9'>
                    <input type='text' class='form-control' name='inpPEHighest_PE' id='inpPEHighest_PE' placeholder='Highest possible score' required>
                  </div>
                </div>
              </div>
              <!-- /.box-body -->
            <div class='box-header with-border'>
			  <h2>HEALTH</h2>
              <h3 class='box-title'>Written Work</h3>
            </div>
            <!-- /.box-header -->
              <div class='box-body'>
				<div class='form-group'>
                  <label for='inpWWSTUDSCORE_HELT' class='col-sm-3 control-label'>Total score</label>
                  <div class='col-sm-9'>
                    <input type='text' class='form-control' name='inpWWSTUDSCORE_HELT' id='inpWWSTUDSCORE_HELT' placeholder='Pupil total score' required>
                  </div>
                </div>
                <div class='form-group'>
                  <label for='inpWWHighest_HELT' class='col-sm-3 control-label'>Highest score</label>

                  <div class='col-sm-9'>
                    <input type='text' class='form-control' name='inpWWHighest_HELT' id='inpWWHighest_HELT' placeholder='Highest possible score' required>
                  </div>
                </div>
              </div>
              <!-- /.box-body -->
            <div class='box-header with-border'>
              <h3 class='box-title'>Performance Task</h3>
            </div>
            <!-- /.box-header -->
              <div class='box-body'>
				<div class='form-group'>
                  <label for='inpPTSTUDSCORE_HELT' class='col-sm-3 control-label'>Total score</label>
                  <div class='col-sm-9'>
                    <input type='text' class='form-control' name='inpPTSTUDSCORE_HELT' id='inpPTSTUDSCORE_HELT' placeholder='Pupil total score' required>
                  </div>
                </div>
                <div class='form-group'>
                  <label for='inpPTHighest_HELT' class='col-sm-3 control-label'>Highest score</label>

                  <div class='col-sm-9'>
                    <input type='text' class='form-control' name='inpPTHighest_HELT' id='inpPTHighest_HELT' placeholder='Highest possible score' required>
                  </div>
                </div>
              </div>
              <!-- /.box-body -->
            <div class='box-header with-border'>
              <h3 class='box-title'>Periodical Exam</h3>
            </div>
            <!-- /.box-header -->
              <div class='box-body'>
				<div class='form-group'>
                  <label for='inpPESTUDSCORE_HELT' class='col-sm-3 control-label'>Total score</label>
                  <div class='col-sm-9'>
                    <input type='text' class='form-control' name='inpPESTUDSCORE_HELT' id='inpPESTUDSCORE_HELT' placeholder='Pupil total score' required>
                  </div>
                </div>
                <div class='form-group'>
                  <label for='inpPEHighest_HELT' class='col-sm-3 control-label'>Highest score</label>

                  <div class='col-sm-9'>
                    <input type='text' class='form-control' name='inpPEHighest_HELT' id='inpPEHighest_HELT' placeholder='Highest possible score' required>
                  </div>
                </div>
              </div>
              <!-- /.box-body -->
              <div class='box-footer'>
                <button type='submit' name='btn_add' class='btn btn-info pull-right btn-flat'><i class='fa fa-check'></i> Grade</button>
              </div>
              <!-- /.box-footer -->
            </form>
			";			
		}else{
			echo"
            <form class='form-horizontal' method='post' action='"; add(); echo"'>
            <div class='box-header with-border'>
              <h3 class='box-title'>Written Work</h3>
            </div>
            <!-- /.box-header -->
              <div class='box-body'>
				<div class='form-group'>
                  <label for='inpWWSTUDSCORE' class='col-sm-3 control-label'>Total score</label>
                  <div class='col-sm-9'>
                    <input type='text' class='form-control' name='inpWWSTUDSCORE' id='inpWWSTUDSCORE' placeholder='Pupil total score' required>
                  </div>
                </div>
                <div class='form-group'>
                  <label for='inpWWHighest' class='col-sm-3 control-label'>Highest score</label>

                  <div class='col-sm-9'>
                    <input type='text' class='form-control' name='inpWWHighest' id='inpWWHighest' placeholder='Highest possible score' required>
                  </div>
                </div>
              </div>
              <!-- /.box-body -->
            <div class='box-header with-border'>
              <h3 class='box-title'>Performance Task</h3>
            </div>
            <!-- /.box-header -->
              <div class='box-body'>
				<div class='form-group'>
                  <label for='inpPTSTUDSCORE' class='col-sm-3 control-label'>Total score</label>
                  <div class='col-sm-9'>
                    <input type='text' class='form-control' name='inpPTSTUDSCORE' id='inpPTSTUDSCORE' placeholder='Pupil total score' required>
                  </div>
                </div>
                <div class='form-group'>
                  <label for='inpPTHighest' class='col-sm-3 control-label'>Highest score</label>

                  <div class='col-sm-9'>
                    <input type='text' class='form-control' name='inpPTHighest' id='inpPTHighest' placeholder='Highest possible score' required>
                  </div>
                </div>
              </div>
              <!-- /.box-body -->
            <div class='box-header with-border'>
              <h3 class='box-title'>Periodical Exam</h3>
            </div>
            <!-- /.box-header -->
              <div class='box-body'>
				<div class='form-group'>
                  <label for='inpPESTUDSCORE' class='col-sm-3 control-label'>Total score</label>
                  <div class='col-sm-9'>
                    <input type='text' class='form-control' name='inpPESTUDSCORE' id='inpPESTUDSCORE' placeholder='Pupil total score' required>
                  </div>
                </div>
                <div class='form-group'>
                  <label for='inpPEHighest' class='col-sm-3 control-label'>Highest score</label>

                  <div class='col-sm-9'>
                    <input type='text' class='form-control' name='inpPEHighest' id='inpPEHighest' placeholder='Highest possible score' required>
                  </div>
                </div>
              </div>
              <!-- /.box-body -->
              <div class='box-footer'>
                <button type='submit' name='btn_add' class='btn btn-info pull-right btn-flat'><i class='fa fa-check'></i> Grade</button>
              </div>
              <!-- /.box-footer -->
            </form>";
		}
	}
////////////////////////////////
// RETURN CURRENT SESSION ID
	function returnID(){
		global $_CON;
		$_EIN = $_SESSION['teacher_usr'];
		$sqlSearch = mysqli_query($_CON, "SELECT teacher_id FROM teachers_table WHERE teacher_ein='$_EIN'");
		$row = mysqli_fetch_array($sqlSearch);
		$_MYID = $row['teacher_id'];
		return $_MYID;
	}
////////////////////////////////
// CLEAN TYPE ID 
	function type_id(){
		global $_CON;
		if(isset($_GET['type'])){
			$_ID = mysqli_real_escape_string($_CON, $_GET['type']);
		return $_ID;
		}
	}
////////////////////////////////
// CLEAN PERIOD ID 
	function period_id(){
		global $_CON;
		if(isset($_GET['period'])){
			$_ID = mysqli_real_escape_string($_CON, $_GET['period']);
		return $_ID;
		}
	}
////////////////////////////////
// CHECK IF THIS PERIOD IS OPEN
	function period_open(){
		global $_CON;
		$_ID = period_id();
		$_DEC_ID = urldecode(base64_decode($_ID));
		if($_DEC_ID == 1){$_NAME = "grading_1";}elseif($_DEC_ID == 2){$_NAME = "grading_2";}elseif($_DEC_ID == 3){$_NAME = "grading_3";}elseif($_DEC_ID == 4){$_NAME = "grading_4";}
		$sqlSearch = mysqli_query($_CON, "SELECT status FROM switch_table WHERE name='$_NAME'");
		$row = mysqli_fetch_array($sqlSearch);
		$stats = $row['status'];
		if($stats == 0){
			header("location: grade.php?errno=404");
		}
	}
////////////////////////////////
// CLEAN SUBJECT ID 
	function subj_id(){
		global $_CON;
		if(isset($_GET['this_subject'])){
			$_ID = mysqli_real_escape_string($_CON, $_GET['this_subject']);
		return $_ID;
		}
	}
////////////////////////////////
// CLEAN STUD ID 
	function stud_id(){
		global $_CON;
		if(isset($_GET['stud'])){
			$_ID = mysqli_real_escape_string($_CON, $_GET['stud']);
		return $_ID;
		}
	}
////////////////////////////////
// GET SUBJECT NAME
	function getSubj(){
		global $_CON;
		$_SUBJ_ID = urldecode(base64_decode(subj_id())); 
		$sqlSearch = mysqli_query($_CON,"SELECT subject_code, subject_name FROM subjects_table WHERE subject_id='$_SUBJ_ID' ");
		$count = mysqli_num_rows($sqlSearch);
		if($count > 0){
			$row = mysqli_fetch_array($sqlSearch);
			$subject_code = $row['subject_code'];
			$subject_name = $row['subject_name'];
			return "Subject: " . $subject_code. " - " . $subject_name;
		}else{
			header("location: myclass.php?errno=404");
			ob_end_clean();
		}
	}
////////////////////////////////
// GET STUDENT NAME
	function getPupName(){
		global $_CON;
		$_ID = urldecode(base64_decode(stud_id())); 
		$sqlSearch = mysqli_query($_CON,"SELECT pupil_cin, pupil_fname, pupil_lname FROM pupils_table WHERE pupil_id='$_ID'");
		$count = mysqli_num_rows($sqlSearch);
		if($count > 0){
			$row = mysqli_fetch_array($sqlSearch);
			$pupil_cin = $row['pupil_cin'];
			$pupil_fname = $row['pupil_fname'];
			$pupil_lname = $row['pupil_lname'];
			return $pupil_lname.", ".$pupil_fname." | CIN: ". $pupil_cin;
		}else{
			header("location: myclass.php?errno=404");
			ob_end_clean();
		}
	}
////////////////////////////////
// GET GRADING PERIOD
	function grdPeriod(){
		$_ID = urldecode(base64_decode(period_id())); 
		if($_ID == 1 ){
			echo "1st Grading Period";
		}elseif($_ID == 2){
			echo "2nd Grading Period";
		}elseif($_ID == 3){
			echo "3rd Grading Period";
		}elseif($_ID == 4){
			echo "4th Grading Period";
		}
	}
	
/////////////////////////////////////////////
//VIEW PUPIL GRADES
	function modMoreInfo(){
		global $_CON;
		global $_YEAR;
		$last_year = $_YEAR - 1;
		$sy = $last_year."-".$_YEAR;
		$_TYPE_ID = type_id();
		$_TYPEDEC_ID = urldecode(base64_decode($_TYPE_ID));
		$subj = subj_id();
		$this_subject = urldecode(base64_decode($subj));
		$stud_id = stud_id();
		$stud_ID = urldecode(base64_decode($stud_id));
		//////////////////////////////
		//FOR MAPEH
		if($_TYPEDEC_ID == 3){
			$getSubjectType = mysqli_query($_CON, "SELECT subject_type FROM subjects_table WHERE subject_id='$this_subject'");
			$_row_subjType = mysqli_fetch_array($getSubjectType);
			$subject_type = $_row_subjType['subject_type'];
			$sqlSearch = mysqli_query($_CON, "SELECT
			grade_id,
			written_word,
			highest_ww,
			performance_task,
			highest_pt,
			periodical_exam,
			highest_pe,
			grading_period,
			
			written_word_ARTS,
			highest_ww_ARTS,
			performance_task_ARTS,
			highest_pt_ARTS,
			periodical_exam_ARTS,
			highest_pe_ARTS,
			
			written_word_PE,
			highest_ww_PE,
			performance_task_PE,
			highest_pt_PE,
			periodical_exam_PE,
			highest_pe_PE,
			
			written_word_HEALTH,
			highest_ww_HEALTH,
			performance_task_HEALTH,
			highest_pt_HEALTH,
			periodical_exam_HEALTH,
			highest_pe_HEALTH
			
			FROM
			grades_table
			WHERE
			student_id='$stud_ID'
			AND
			subject_id='$this_subject' 
			AND
			school_year='$sy' ");
			$count = mysqli_num_rows($sqlSearch);
			if($count > 0){
					$writtenwork = .20;
					$perftask = .60;
					$periodical = .20;
					while($row=mysqli_fetch_array($sqlSearch)){

					//MUSIC
					$_ID = mysqli_real_escape_string($_CON, $row['grade_id']);
					
					$written_word = mysqli_real_escape_string($_CON, $row['written_word']);
					$highest_ww = mysqli_real_escape_string($_CON, $row['highest_ww']);
					$performance_task = mysqli_real_escape_string($_CON, $row['performance_task']);
					$highest_pt = mysqli_real_escape_string($_CON, $row['highest_pt']);
					$periodical_exam = mysqli_real_escape_string($_CON, $row['periodical_exam']);
					$highest_pe = mysqli_real_escape_string($_CON, $row['highest_pe']);
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
					
					echo"
		<div class='modal fade' id='gradeinfo$_ID' tabindex='-1' role='dialog' aria-labelledby='myModalLabel'>
		  <div class='modal-dialog modal-primary modal-lg' role='document'>
			<div class='modal-content'>
			  <div class='modal-header'>
				<button type='button' class='close' data-dismiss='modal' aria-label='Close'><span aria-hidden='true'>&times;</span></button>
				<h4 class='modal-title' id='myModalLabel'>Grade Info	</h4>
			  </div>
			  <div class='modal-body'>
				<table class='table table-bordered'>
					<thead>
					  <tr>
						<th colspan='6'>MUSIC</th>
						<th colspan='6'>ARTS</th>
						<th colspan='6'>PE</th>
						<th colspan='6'>HEALTH</th>
					  </tr>
					  <tr>
						<td colspan='2'>WW</td>
						<td colspan='2'>PT</td>
						<td colspan='2'>PE</td>
						<td colspan='2'>WW</td>
						<td colspan='2'>PT</td>
						<td colspan='2'>PE</td>
						<td colspan='2'>WW</td>
						<td colspan='2'>PT</td>
						<td colspan='2'>PE</td>
						<td colspan='2'>WW</td>
						<td colspan='2'>PT</td>
						<td colspan='2'>PE</td>
					  </tr>
					  <tr>
						<td>TS</td>
						<td>HS</td>
						<td>TS</td>
						<td>HS</td>
						<td>TS</td>
						<td>HS</td>
						<td>TS</td>
						<td>HS</td>
						<td>TS</td>
						<td>HS</td>
						<td>TS</td>
						<td>HS</td>
						<td>TS</td>
						<td>HS</td>
						<td>TS</td>
						<td>HS</td>
						<td>TS</td>
						<td>HS</td>
						<td>TS</td>
						<td>HS</td>
						<td>TS</td>
						<td>HS</td>
						<td>TS</td>
						<td>HS</td>
					  </tr>
					</thead>
					<tbody>
					  <tr>
						<td>$written_word</td>
						<td>$highest_ww</td>
						<td>$performance_task</td>
						<td>$highest_pt</td>
						<td>$periodical_exam</td>
						<td>$highest_pe</td>
						
						<td>$written_word_ARTS</td>
						<td>$highest_ww_ARTS</td>
						<td>$performance_task_ARTS</td>
						<td>$highest_pt_ARTS</td>
						<td>$periodical_exam_ARTS</td>
						<td>$highest_pe_ARTS</td>
						
						<td>$written_word_PE</td>
						<td>$highest_ww_PE</td>
						<td>$performance_task_PE</td>
						<td>$highest_pt_PE</td>
						<td>$periodical_exam_PE</td>
						<td>$highest_pe_PE</td>
						
						<td>$written_word_HEALTH</td>
						<td>$highest_ww_HEALTH</td>
						<td>$performance_task_HEALTH</td>
						<td>$highest_pt_HEALTH</td>
						<td>$periodical_exam_HEALTH</td>
						<td>$highest_pe_HEALTH</td>
					  </tr>
						</tbody>
					</table>
				  </div>
				  <div class='modal-footer'>
					<button type='button' class='btn btn-danger' data-dismiss='modal'>Close</button>
				  </div>
				</div>
			  </div>
			</div>";					
				}

			}			
		}else{
		//////////////////////////////
		//FOR REGULAR SUBJECTS
			$getSubjectType = mysqli_query($_CON, "SELECT subject_type FROM subjects_table WHERE subject_id='$this_subject'");
			$_row_subjType = mysqli_fetch_array($getSubjectType);
			$subject_type = $_row_subjType['subject_type'];
			$sqlSearch = mysqli_query($_CON, "SELECT
			grade_id,
			written_word,
			highest_ww,
			performance_task,
			highest_pt,
			periodical_exam,
			highest_pe,
			grading_period
			FROM
			grades_table
			WHERE
			student_id='$stud_ID'
			AND
			subject_id='$this_subject' 
			AND
			school_year='$sy' ");
			$count = mysqli_num_rows($sqlSearch);
			if($count > 0){
				while($row=mysqli_fetch_array($sqlSearch)){
					$_ID = mysqli_real_escape_string($_CON, $row['grade_id']);
					$written_word = mysqli_real_escape_string($_CON, $row['written_word']);
					$highest_ww = mysqli_real_escape_string($_CON, $row['highest_ww']);
					$performance_task = mysqli_real_escape_string($_CON, $row['performance_task']);
					$highest_pt = mysqli_real_escape_string($_CON, $row['highest_pt']);
					$periodical_exam = mysqli_real_escape_string($_CON, $row['periodical_exam']);
					$highest_pe = mysqli_real_escape_string($_CON, $row['highest_pe']);
					$grading_period = mysqli_real_escape_string($_CON, $row['grading_period']);

					echo"
		<div class='modal fade' id='gradeinfo$_ID' tabindex='-1' role='dialog' aria-labelledby='myModalLabel'>
		  <div class='modal-dialog modal-primary modal-lg' role='document'>
			<div class='modal-content'>
			  <div class='modal-header'>
				<button type='button' class='close' data-dismiss='modal' aria-label='Close'><span aria-hidden='true'>&times;</span></button>
				<h4 class='modal-title' id='myModalLabel'>Grade Info	</h4>
			  </div>
			  <div class='modal-body'>
				<table class='table table-bordered'>
					<thead>
					  <tr>
						<th colspan='2'>WRITTEN WORK</th>
						<th colspan='2'>PERFOMANCE TASK</th>
						<th colspan='2'>PERIODICAL EXAM</th>
					  </tr>
					  <tr>
						<td>Total Score</td>
						<td>Highest Score</td>
						<td>Total Score</td>
						<td>Highest Score</td>
						<td>Total Score</td>
						<td>Highest Score</td>
					  </tr>
					</thead>
					<tbody>
					  <tr>
						<td>$written_word</td>
						<td>$highest_ww</td>
						<td>$performance_task</td>
						<td>$highest_pt</td>
						<td>$periodical_exam</td>
						<td>$highest_pe</td>
					  </tr>
						</tbody>
					</table>
				  </div>
				  <div class='modal-footer'>
					<button type='button' class='btn btn-danger' data-dismiss='modal'>Close</button>
				  </div>
				</div>
			  </div>
			</div>";					
					
				}
			}
		}		
		
	}
