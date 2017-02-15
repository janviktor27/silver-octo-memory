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
		$MY_ID = returnID();
		$CLASS_ID = SECT_ID();
		$CLASS_ID_DECODE = urldecode(base64_decode($CLASS_ID));
		//DECODE AND ENCODE AGAIN
		$_SUBJ_ID = urldecode(base64_decode(subj_ID()));
		$_SUB_ENC = urlencode(base64_encode($_SUBJ_ID));
		$sqlSearch = mysqli_query($_CON, "SELECT pupil_id, pupil_cin, pupil_fname, pupil_lname FROM pupils_table WHERE section_id='$CLASS_ID_DECODE' ");
		$count = mysqli_num_rows($sqlSearch);
		if($count > 0){
			$enc_1 = urlencode(base64_encode('1'));
			$enc_2 = urlencode(base64_encode('2'));
			$enc_3 = urlencode(base64_encode('3'));
			$enc_4 = urlencode(base64_encode('4'));
			while($row=mysqli_fetch_array($sqlSearch)){
				//
				$_ID = mysqli_real_escape_string($_CON, $row['pupil_id']);
				$pupil_cin = mysqli_real_escape_string($_CON, $row['pupil_cin']);
				$pupil_fname = mysqli_real_escape_string($_CON, $row['pupil_fname']);
				$pupil_lname = mysqli_real_escape_string($_CON, $row['pupil_lname']);
				$enc_pup_id = urlencode(base64_encode($_ID));
				/////////////////////////////////////////
				// GET SUBJECT TYPE 
				$sqlType = mysqli_query($_CON, "SELECT subject_type FROM subjects_table WHERE subject_id='$_SUBJ_ID' ");
				$rowType = mysqli_fetch_array($sqlType);
				$subject_type = $rowType['subject_type'];
				$enc_subj_type = urlencode(base64_encode($subject_type));
				// CHECK SWITCH
				$sqlSwitch = mysqli_query($_CON, "SELECT * FROM switch_table");
				while($row_ko=mysqli_fetch_array($sqlSwitch)){
					$name = $row_ko['name'];
					$status = $row_ko['status'];
					if($name == 'grading_1'){
						if($status == 1){
							$btn_1 = "<a class='btn btn-primary btn-xs' href='grade.php?period=$enc_1&this_subject=$_SUB_ENC&stud=$enc_pup_id&type=$enc_subj_type'>1</a>";
						}elseif($status == 0){
							$btn_1 = "<a class='btn btn-primary btn-xs disabled' href='#'>1</a>";
						}
					}if($name == 'grading_2'){
						if($status == 1){
							$btn_2 = "<a class='btn btn-primary btn-xs' href='grade.php?period=$enc_2&this_subject=$_SUB_ENC&stud=$enc_pup_id&type=$enc_subj_type'>2</a>";
						}elseif($status == 0){
							$btn_2 = "<a class='btn btn-primary btn-xs disabled' href='#'>2</a>";
						}
					}if($name == 'grading_3'){
						if($status == 1){
							$btn_3 = "<a class='btn btn-primary btn-xs' href='grade.php?period=$enc_3&this_subject=$_SUB_ENC&stud=$enc_pup_id&type=$enc_subj_type'>3</a>";
						}elseif($status == 0){
							$btn_3 = "<a class='btn btn-primary btn-xs disabled' href='#'>3</a>";
						}
					}if($name == 'grading_4'){
						if($status == 1){
							$btn_4 = "<a class='btn btn-primary btn-xs' href='grade.php?period=$enc_4&this_subject=$_SUB_ENC&stud=$enc_pup_id&type=$enc_subj_type'>4</a>";
						}elseif($status == 0){
							$btn_4 = "<a class='btn btn-primary btn-xs disabled' href='#'>4</a>";
						}
					}
				}
				echo"
				 <tr>
				  <td>$pupil_cin $subject_type</td>
				  <td>$pupil_lname, $pupil_fname</td>
				  <td>
					$btn_1 $btn_2 $btn_3 $btn_4 |&nbsp;
				   <a class='btn btn-warning btn-xs' href='this.pupil.php?period=$enc_4&this_subject=$_SUB_ENC&stud=$enc_pup_id&type=$enc_subj_type'><i class='fa fa-info-circle'></i></a>
				   <button data-toggle='modal' data-target='#requestMod' class='btn btn-primary btn-xs'><i class='fa fa-commenting'></i></button>
				  </td>
				 </tr>
				";
			}
		}else{
			header("location: myclass.php?errno=404");
			ob_end_clean();
		}
	}
////////////////////////////////
// CLEAN CLASS ID 
	function SECT_ID(){
		global $_CON;
		if(isset($_GET['this_sect'])){
			$_CLASSID = mysqli_real_escape_string($_CON, $_GET['this_sect']);
		return $_CLASSID;
		}
	}
////////////////////////////////
// CLEAN SUBJECT ID 
	function subj_ID(){
		global $_CON;
		if(isset($_GET['this_subject'])){
			$_ID = mysqli_real_escape_string($_CON, $_GET['this_subject']);
		return $_ID;
		}
	}
////////////////////////////////
// GET SUBJECT NAME
	function getSubj(){
		global $_CON;
		$_SUBJ_ID = urldecode(base64_decode(subj_ID())); 
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
// GET GRADE LEVEL AND SECTION NAME
	function getGRDLVL(){
		global $_CON;
		$_SEC_ID = urldecode(base64_decode(SECT_ID())); 
		$sqlSearch = mysqli_query($_CON,"SELECT section_name, gradelvl, teacher_id FROM section_table WHERE section_id='$_SEC_ID' ");
		$row = mysqli_fetch_array($sqlSearch);
		$grdlvl = $row['gradelvl'];
		$sec_name = $row['section_name'];
		return "Grade " . $grdlvl. " - " . $sec_name;
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
///////////////////////////
//Adding response
	function addResponse(){

	if(isset($_GET['add'])){
			$response = $_GET['add'];
			if($response == 'true'){
				echo"
              <div class='callout callout-info'>
                <h4>Saving Success!</h4>
                <p>Successfully graded your pupil.</p>
              </div>
				";
			}elseif($response == 'exist'){
				echo"
              <div class='callout callout-danger'>
                <h4>Saving Failed!</h4>
                <p>That pupil already had grade.</p>
              </div>
				";
			}
		}
	}
	
////////////////////////////////
// DYNAMIC FORM
	function dynamicForm($type_id){
		global $_CON;
		if($type_id == 3){
			echo"
            <!-- /.box-header -->
              <div class='box-body'>
				<div class='form-group'>
                  <label for='inpGradingPeriod' class='col-sm-3 control-label'>Grading Period</label>
                  <div class='col-sm-9'>
					<select class='form-control' name='inpGradingPeriod' id='inpGradingPeriod' required>
						<option value='' default>Select Grading Period</option>
						<option value='1' default>1st Grading</option>
						<option value='2' default>2nd Grading</option>
						<option value='3' default>3rd Grading</option>
						<option value='4' default>4th Grading</option>
					</select>
                  </div>
                </div>
            </div>
            <div class='box-header with-border'>
			  <h2>MUSIC</h2>
              <h3 class='box-title'>Written Work</h3>
            </div>
            <!-- /.box-header -->
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
			";			
		}else{
			echo"
            <div class='box-header with-border'>
              <h3 class='box-title'>Select Grading Period</h3>
            </div>
            <!-- /.box-header -->
              <div class='box-body'>
				<div class='form-group'>
                  <label for='inpGradingPeriod' class='col-sm-3 control-label'>Grading Period</label>
                  <div class='col-sm-9'>
					<select class='form-control' name='inpGradingPeriod' id='inpGradingPeriod' required>
						<option value='' default>Select Grading Period</option>
						<option value='1' default>1st Grading</option>
						<option value='2' default>2nd Grading</option>
						<option value='3' default>3rd Grading</option>
						<option value='4' default>4th Grading</option>
					</select>
                  </div>
                </div>
            </div>
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
              <!-- /.box-body -->";
		}
	}
	

	
/////////////////////////////////////////////
//View employee
	function requestModal(){
		global $_CON;
		//DECODE AND ENCODE AGAIN
		$teacher_id = returnID();
		$_SUBJ_ID = urldecode(base64_decode(subj_ID()));
		$_SUB_ENC = urlencode(base64_encode($_SUBJ_ID));
		$CLASS_ID = SECT_ID();
		$CLASS_ID_DECODE = urldecode(base64_decode($CLASS_ID));
		$sqlSearch = mysqli_query($_CON, "SELECT
		pupil_id,
		pupil_cin,
		pupil_fname,
		pupil_lname
		FROM
		pupils_table
		WHERE
		section_id='$CLASS_ID_DECODE'
		");
		$count = mysqli_num_rows($sqlSearch);
		if($count > 0){
			while($row=mysqli_fetch_array($sqlSearch)){
				//
				$_ID = mysqli_real_escape_string($_CON, $row['pupil_id']);
				$pupil_cin = mysqli_real_escape_string($_CON, $row['pupil_cin']);
				$pupil_fname = mysqli_real_escape_string($_CON, $row['pupil_fname']);
				$pupil_lname = mysqli_real_escape_string($_CON, $row['pupil_lname']);
				$enc_pup_id = urlencode(base64_encode($_ID));
				/////////////////////////////////////////
				// GET SUBJECT TYPE 
				$sqlType = mysqli_query($_CON, "SELECT subject_type FROM subjects_table WHERE subject_id='$_SUBJ_ID' ");
				$rowType = mysqli_fetch_array($sqlType);
				$subject_type = $rowType['subject_type'];
				$enc_subj_type = urlencode(base64_encode($subject_type));
				echo"
				<div class='modal fade' id='requestMod' tabindex='-1' role='dialog' aria-labelledby='myModalLabel'>
				  <div class='modal-dialog' role='document'>
					<div class='modal-content'>
					<form class='form-horizontal' method='post' action='"; requestGrade(); echo"'>
					  <div class='modal-header'>
						<button type='button' class='close' data-dismiss='modal' aria-label='Close'><span aria-hidden='true'>&times;</span></button>
						<h4 class='modal-title' id='myModalLabel'>Change Grade Request</h4>
					  </div>
					  <div class='modal-body'>";
						dynamicForm($subject_type);
				echo"  </div>
						  <div class='modal-footer'>
						    <input type='hidden' name='subject_type' value='$subject_type'>
						    <input type='hidden' name='inpTeacher_ID' value='$teacher_id'>
						    <input type='hidden' name='inpPUPIL_ID' value='$_ID'>
						    <input type='hidden' name='SUBJ_ID' value='$_SUBJ_ID'>
							<button type='button' class='btn btn-danger' data-dismiss='modal'>Close</button>
							<button type='submit' name='btn_req' class='btn btn-primary'>Request</button>
						  </div>
					</form>
						</div>
					  </div>
					</div>
				";
			}
		}else{
			header("location: myclass.php?errno=404");
			ob_end_clean();
		}
	}
	
/////////////////////////////////////////////
//Add pupils
	function requestGrade(){
		global $_CON;
		global $_NOW;
		global $_YEAR;
		if(isset($_POST['btn_req'])){
			$subject_type = $_POST['subject_type'];
			$inpTeacher_ID = $_POST['inpTeacher_ID'];
			$inpPUPIL_ID = $_POST['inpPUPIL_ID'];
			$SUBJ_ID = $_POST['SUBJ_ID'];
			//////////////////////////////
			//FOR MAPEH
			if($subject_type == 3){
			// IF SUBMITTED
					$last_year = $_YEAR - 1;
					$sy = $last_year."-".$_YEAR;
					// ENC THIS SUBJECT FOR URL AGAIN
					$_sub_jID = urlencode(base64_encode($SUBJ_ID));
					$inpGradingPeriod = mysqli_real_escape_string($_CON, $_POST['inpGradingPeriod']);
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
					$sqlSection = mysqli_query($_CON, "SELECT section_id FROM pupils_table WHERE pupil_id='$inpPUPIL_ID' ");
					$_row_sec = mysqli_fetch_array($sqlSection);
					$section_id = $_row_sec['section_id'];
					$_ENCSECTION = urlencode(base64_encode($section_id));
					//GET GRADE LEVEL AND SECTION NAME
					$sqlGradeLvl = mysqli_query($_CON, "SELECT gradelvl, section_name FROM section_table WHERE section_id='$section_id' ");
					$_row_grdlvl = mysqli_fetch_array($sqlGradeLvl);
					$gradelvl = $_row_grdlvl['gradelvl'];
					$section_name = $_row_grdlvl['section_name'];
					// CHECK IF THIS STUDENT ALREADY HAVE GRADE ON SPECIFIC SUBJECT
					$sqlSearch = mysqli_query($_CON, "SELECT * FROM change_grades_table
					WHERE
					student_id='$inpPUPIL_ID'
					AND
					teacher_id='$inpTeacher_ID'
					AND
					subject_id='$SUBJ_ID'
					AND
					grading_period='$inpGradingPeriod'
					AND
					school_year='$sy' ");
					$count = mysqli_num_rows($sqlSearch);
					if($count == 1){
						ob_end_clean();
						header("location: view-this-class.php?this_sect=$_ENCSECTION&this_subject=$_sub_jID&add=exist");
					}else{
						$sqlInsert = mysqli_query($_CON, "INSERT INTO change_grades_table 
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
						'$inpPUPIL_ID',
						'$inpTeacher_ID',
						'$SUBJ_ID',
						'$inpWWSTUDSCORE_MUSIC',
						'$inpWWHighest_MUSIC',
						'$inpPTSTUDSCORE_MUSIC',
						'$inpPTHighest_MUSIC',
						'$inpPESTUDSCORE_MUSIC',
						'$inpPEHighest_MUSIC',
						'$gradelvl',
						'$section_name',
						'$inpGradingPeriod',
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
						header("location: view-this-class.php?this_sect=$_ENCSECTION&this_subject=$_sub_jID&add=true");
					}
			}else{
			//////////////////////////////
			//FOR REGULAR SUBJECTS
			// IF SUBMITTED
					$last_year = $_YEAR - 1;
					$sy = $last_year."-".$_YEAR;
					$inpGradingPeriod = mysqli_real_escape_string($_CON, $_POST['inpGradingPeriod']);

					// ENC THIS SUBJECT FOR URL AGAIN
					$_sub_jID = urlencode(base64_encode($SUBJ_ID));
					
					$teacher_id = returnID();
					//POST METHOD
					$inpWWSTUDSCORE = mysqli_real_escape_string($_CON, $_POST['inpWWSTUDSCORE']);
					$inpWWHighest = mysqli_real_escape_string($_CON, $_POST['inpWWHighest']);
					$inpPTSTUDSCORE = mysqli_real_escape_string($_CON, $_POST['inpPTSTUDSCORE']);
					$inpPTHighest = mysqli_real_escape_string($_CON, $_POST['inpPTHighest']);
					$inpPESTUDSCORE = mysqli_real_escape_string($_CON, $_POST['inpPESTUDSCORE']);
					$inpPEHighest = mysqli_real_escape_string($_CON, $_POST['inpPEHighest']);
					//GET PUPIL SECTION
					$sqlSection = mysqli_query($_CON, "SELECT section_id FROM pupils_table WHERE pupil_id='$inpPUPIL_ID' ");
					$_row_sec = mysqli_fetch_array($sqlSection);
					$section_id = $_row_sec['section_id'];
					$_ENCSECTION = urlencode(base64_encode($section_id));
					//GET GRADE LEVEL AND SECTION NAME
					$sqlGradeLvl = mysqli_query($_CON, "SELECT gradelvl, section_name FROM section_table WHERE section_id='$section_id' ");
					$_row_grdlvl = mysqli_fetch_array($sqlGradeLvl);
					$gradelvl = $_row_grdlvl['gradelvl'];
					$section_name = $_row_grdlvl['section_name'];
					// CHECK IF THIS STUDENT ALREADY HAVE GRADE ON SPECIFIC SUBJECT
					$sqlSearch = mysqli_query($_CON, "SELECT * FROM change_grades_table
					WHERE
					student_id='$inpPUPIL_ID'
					AND
					teacher_id='$inpTeacher_ID'
					AND
					subject_id='$SUBJ_ID'
					AND
					grading_period='$inpGradingPeriod'
					AND
					school_year='$sy' ");
					$count = mysqli_num_rows($sqlSearch);
					if($count == 1){
						ob_end_clean();
						header("location: view-this-class.php?this_sect=$_ENCSECTION&this_subject=$_sub_jID&add=exist");
					}else{
						$sqlInsert = mysqli_query($_CON, "INSERT INTO change_grades_table 
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
						'$inpPUPIL_ID',
						'$inpTeacher_ID',
						'$SUBJ_ID',
						'$inpWWSTUDSCORE',
						'$inpWWHighest',
						'$inpPTSTUDSCORE',
						'$inpPTHighest',
						'$inpPESTUDSCORE',
						'$inpPEHighest',
						'$gradelvl',
						'$section_name',
						'$inpGradingPeriod',
						'$sy',
						'$_NOW')");
						ob_end_clean();
						header("location: view-this-class.php?this_sect=$_ENCSECTION&this_subject=$_sub_jID&add=true");
					}
			}
		}
	}