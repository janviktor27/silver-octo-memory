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
		if(isset($_POST['btn_add'])){
			$inpSUBJ = mysqli_real_escape_string($_CON, $_POST['inpSUBJ']);
			$inpSECT = mysqli_real_escape_string($_CON, $_POST['inpSECT']);
			$inpSTIME = mysqli_real_escape_string($_CON, $_POST['inpSTIME']);
			$inpETIME = mysqli_real_escape_string($_CON, $_POST['inpETIME']);
			$daylist = $_POST['daylist'];
			$daylist_IMP = '"'.implode(',', $daylist).'"';
			$_EIN = returnID();
			$year = date("Y");
			$previousyear = $year -1;
			$sy = "$previousyear-$year";
			//CHECK IF SAME SCHEDULE EXIST
			$sqlSearch = mysqli_query($_CON, "SELECT subject_id, teacher_id FROM schedule_table WHERE subject_id='$inpSUBJ' AND  teacher_id='$_EIN' AND start_time='$inpSTIME' AND end_time='$inpETIME' AND days='$daylist_IMP' ");
			$count = mysqli_num_rows($sqlSearch);
			if($count > 0){
				ob_end_clean();
				header("location: schedules.php?add=exist");
			}else{
				$sqlInsert = mysqli_query($_CON, "INSERT INTO schedule_table 
				(subject_id,section_id,teacher_id,days,start_time,end_time,school_year,date_added)
				VALUES('$inpSUBJ','$inpSECT','$_EIN','$daylist_IMP','$inpSTIME','$inpETIME','$sy','$_NOW')");
				ob_end_clean();
				header("location: schedules.php?add=true");
			}
		}
	}

/////////////////////////////////////////////
//SELECT OPTION
	function optSubj(){
		global $_CON;
		$sqlSearch = mysqli_query($_CON, "SELECT * FROM subjects_table ORDER BY subject_name ASC");
		$count = mysqli_num_rows($sqlSearch);
		if($count > 0){
			while($row=mysqli_fetch_array($sqlSearch)){
				$_ID = mysqli_real_escape_string($_CON, $row['subject_id']);
				$code = mysqli_real_escape_string($_CON, $row['subject_code']);
				$name = mysqli_real_escape_string($_CON, $row['subject_name']);
				
				echo"
				<option value='$_ID'>$name | $code</option>
				";
			}
		}else{
			echo"
			<option value=''>No subjects yet.</option>";
		}
	}

/////////////////////////////////////////////
//SELECT SECTION OPTION
	function optSect(){
		global $_CON;
		$sqlSearch = mysqli_query($_CON, "SELECT * FROM section_table ORDER BY section_name ASC");
		$count = mysqli_num_rows($sqlSearch);
		if($count > 0){
			while($row=mysqli_fetch_array($sqlSearch)){
				$_ID = mysqli_real_escape_string($_CON, $row['section_id']);
				$gradelvl = mysqli_real_escape_string($_CON, $row['gradelvl']);
				$name = mysqli_real_escape_string($_CON, $row['section_name']);
				
				echo"
				<option value='$_ID'>$gradelvl - $name</option>
				";
			}
		}else{
			echo"
			<option value=''>No sections yet.</option>";
		}
	}

/////////////////////////////////////////////
//View employee
	function theview(){
		global $_CON;
		global $_YEAR;
		$last_year = $_YEAR - 1;
		$sy = $last_year."-".$_YEAR;
		$MY_ID = returnID();
		$sqlSearch = mysqli_query($_CON, "SELECT * FROM schedule_table WHERE teacher_id='$MY_ID' AND school_year='$sy' ");
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
				echo"
				 <tr>
				  <td>$subj_code</td>
				  <td>$subj_name</td>
				  <td>$gradelvl - $section_name</td>
				  <td>$days | $startTime - $endTime</td>
				  <td align='center'>
				   <button class='btn btn-info btn-xs' data-toggle='modal' data-target='#updMod$_ID'><i class='glyphicon glyphicon-edit'></i></button>
				   <button class='btn btn-danger btn-xs' data-toggle='modal' data-target='#delMod$_ID'><i class='glyphicon glyphicon-trash'></i></button>
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

/////////////////////////////////////////////
//UPDATE MODAL
	function updMod(){
		global $_CON;
		$MY_ID = returnID();
		$sqlSearch = mysqli_query($_CON, "SELECT * FROM schedule_table WHERE teacher_id='$MY_ID' ");
		$count = mysqli_num_rows($sqlSearch);
		if($count > 0){
			while($row=mysqli_fetch_array($sqlSearch)){
				$_ID = mysqli_real_escape_string($_CON, $row['sched_id']);
				$SUBJ_ID = mysqli_real_escape_string($_CON, $row['subject_id']);
				$section_id = mysqli_real_escape_string($_CON, $row['section_id']);
				$days = $row['days'];
				$startTime = mysqli_real_escape_string($_CON, $row['start_time']);
				$endTime = mysqli_real_escape_string($_CON, $row['end_time']);
				//GET SUBJECT INFO
				$sqlSect = mysqli_query($_CON,"SELECT subject_code,subject_name FROM subjects_table WHERE subject_id='$SUBJ_ID' ");
				$_row = mysqli_fetch_array($sqlSect);
				$subj_name = $_row['subject_name'];
				$subj_code = $_row['subject_code'];
				//GET SECTION INFO
				$sqlSect = mysqli_query($_CON,"SELECT section_name, gradelvl FROM section_table WHERE section_id='$section_id' ");
				$r_ow = mysqli_fetch_array($sqlSect);
				$section_name = $r_ow['section_name'];
				$gradelvl = $r_ow['gradelvl'];
				//GET DAYS
				//MON
				if(strpos($days, 'Mon') !== false){
					$monday = "<input type='checkbox' name='daylist[]' value='Mon' class='flat-red' checked>";
				}else{
					$monday = "<input type='checkbox' name='daylist[]' value='Mon' class='flat-red'>";
				}
				//TUE
				if(strpos($days, 'Tue') !== false){
					$tuesday = "<input type='checkbox' name='daylist[]' value='Tue' class='flat-red' checked>";
				}else{
					$tuesday = "<input type='checkbox' name='daylist[]' value='Tue' class='flat-red'>";
				}
				//WED
				if(strpos($days, 'Wed') !== false){
					$wednesday = "<input type='checkbox' name='daylist[]' value='Wed' class='flat-red' checked>";
				}else{
					$wednesday = "<input type='checkbox' name='daylist[]' value='Wed' class='flat-red'>";
				}
				//THU
				if(strpos($days, 'Thu') !== false){
					$thursday = "<input type='checkbox' name='daylist[]' value='Thu' class='flat-red' checked>";
				}else{
					$thursday = "<input type='checkbox' name='daylist[]' value='Thu' class='flat-red'>";
				}
				//FRI
				if(strpos($days, 'Fri') !== false){
					$friday = "<input type='checkbox' name='daylist[]' value='Fri' class='flat-red' checked>";
				}else{
					$friday = "<input type='checkbox' name='daylist[]' value='Fri' class='flat-red'>";
				}
				//SAT
				if(strpos($days, 'Sat') !== false){
					$saturday = "<input type='checkbox' name='daylist[]' value='Sat' class='flat-red' checked>";
				}else{
					$saturday = "<input type='checkbox' name='daylist[]' value='Sat' class='flat-red'>";
				}
				//SUN
				if(strpos($days, 'Sun') !== false){
					$sunday = "<input type='checkbox' name='daylist[]' value='Sun' class='flat-red' checked>";
				}else{
					$sunday = "<input type='checkbox' name='daylist[]' value='Sun' class='flat-red'>";
				}
				$checkbox ="
					<label class='col-sm-1'>
						Mon
						$monday
					</label>
					<label class='col-sm-1'>
						Tue
						$tuesday
					</label>
					<label class='col-sm-1'>
						Wed
						$wednesday
					</label>
					<label class='col-sm-1'>
						Thu
						$thursday
					</label>
					<label class='col-sm-1'>
						Fri
						$friday
					</label>
					<label class='col-sm-1'>
						Sat
						$saturday
					</label>
					<label class='col-sm-1'>
						Sun
						$sunday
					</label>";

				echo"
          <div class='modal fade modal-primary' id='updMod$_ID' tabindex='-1' role='dialog'>
          <div class='modal-dialog'>
            <div class='modal-content'>
              <div class='modal-header'>
                <button type='button' class='close' data-dismiss='modal' aria-label='Close'>
                  <span aria-hidden='true'>&times;</span></button>
                <h4 class='modal-title'>Edit Pupil </h4>
              </div>
			  <form class='form-horizontal' method='post' action='";updAction(); echo"'>
               <div class='modal-body'>
              <div class='box-body'>
                <div class='form-group'>
                  <label for='inpSUBJ' class='col-sm-2 control-label'>Subject</label>
                  <div class='col-sm-10'>
					<select class='form-control' name='inpSUBJ' id='inpSUBJ' required>
					 <option default value='$SUBJ_ID'>$subj_name | $subj_code</option>
					 "; optSubj(); echo" 
					</select>
                  </div>
                </div>
                <div class='form-group'>
                  <label for='inpSECT' class='col-sm-2 control-label'>Grade/Section</label>
                  <div class='col-sm-10'>
					<select class='form-control' name='inpSECT' id='inpSECT' required>
					 <option default value='$section_id'>$gradelvl - $section_name</option>
					 ";optSect();echo" 
					</select>
                  </div>
                </div>
                <div class='form-group'>
                  <label for='daylist' class='col-sm-2 control-label'>Days</label>
				  $checkbox
                </div>
                <div class='form-group'>
                  <label for='inpSTIME' class='col-sm-2 control-label'>Start Time</label>

                  <div class='col-sm-10'>
                    <input type='time' value='$startTime' class='form-control' name='inpSTIME' id='inpSTIME' placeholder='Start time' required>
                  </div>
                </div>
                <div class='form-group'>
                  <label for='inpETIME' class='col-sm-2 control-label'>End Time</label>

                  <div class='col-sm-10'>
                    <input type='time' value='$endTime' class='form-control' name='inpETIME' id='inpETIME' placeholder='End Time' required>
                  </div>
                </div>

 			  </div>
              <!-- /.box-body -->
 			   </div>
               <div class='modal-footer'>
			     <input type='hidden' value='$_ID' name='UPD_ID'>
                 <button type='button' class='btn btn-danger  pull-left' data-dismiss='modal'>Close</button>
                 <button type='submit' name='btn_upd' class='btn btn-info'>Save changes</button>
               </div>
			  </form>
            </div>
            <!-- /.modal-content -->
          </div>
          <!-- /.modal-dialog -->
        </div>";
			}
		}
	}

/////////////////////////////////////////////
//UPDATE METHOD
	function updAction(){
		global $_CON;
		if(isset($_POST['btn_upd'])){
			$_ID = mysqli_real_escape_string($_CON, $_POST['UPD_ID']);
			$inpSUBJ = mysqli_real_escape_string($_CON, $_POST['inpSUBJ']);
			$inpSECT = mysqli_real_escape_string($_CON, $_POST['inpSECT']);
			$inpSTIME = mysqli_real_escape_string($_CON, $_POST['inpSTIME']);
			$inpETIME = mysqli_real_escape_string($_CON, $_POST['inpETIME']);
			$daylist = $_POST['daylist'];
			$daylist_IMP = '"'.implode(',', $daylist).'"';
			$_EIN = returnID();

			//CHECK IF SAME SCHEDULE EXIST
			$sqlSearch = mysqli_query($_CON, "SELECT subject_id, teacher_id FROM schedule_table WHERE subject_id='$inpSUBJ' AND  teacher_id='$_EIN' AND start_time='$inpSTIME' AND end_time='$inpETIME' AND days LIKE '%$daylist_IMP%' ");
			$count = mysqli_num_rows($sqlSearch);
			if($count == 1){
				ob_end_clean();
				header("location: schedules.php?upd=exist");
				exit();
			}else{
				$sqlUpdate = mysqli_query($_CON,"UPDATE schedule_table SET
				subject_id='$inpSUBJ',
				section_id='$inpSECT',
				days='$daylist_IMP',
				start_time='$inpSTIME',
				end_time='$inpETIME'
				WHERE sched_id='$_ID' ");
				ob_end_clean();
				header("location: schedules.php?upd=true");
				exit();
			}
		}
	}
	
/////////////////////////////////////////////
//DELETE MODAL
	function delMod(){
		global $_CON;
		$sqlSearch = mysqli_query($_CON, "SELECT * FROM schedule_table");
		$count = mysqli_num_rows($sqlSearch);
		if($count > 0){
			while($row=mysqli_fetch_array($sqlSearch)){
				$_ID = mysqli_real_escape_string($_CON, $row['sched_id']);
				$SUBJ_ID = mysqli_real_escape_string($_CON, $row['subject_id']);
				$days = $row['days'];
				$startTime = mysqli_real_escape_string($_CON, $row['start_time']);
				$endTime = mysqli_real_escape_string($_CON, $row['end_time']);
				$startTime = date('h:i:A', strtotime($startTime));
				$endTime = date('h:i:A', strtotime($endTime));
				//GET SUBJECT INFO
				$sqlSect = mysqli_query($_CON,"SELECT subject_code,subject_name FROM subjects_table WHERE subject_id='$SUBJ_ID' ");
				$_row = mysqli_fetch_array($sqlSect);
				$subj_name = $_row['subject_name'];
				$subj_code = $_row['subject_code'];
				echo"
<!--Modal Start-->
<div class='modal fade modal-danger' id='delMod$_ID' tabindex='-1' role='dialog' aria-labelledby='myModalLabel' aria-hidden='true'>
	<div class='modal-dialog'>
		<div class='modal-content'>
			<form class='form-horizontal' method='post' action='"; delAction(); echo"'>
				<div class='modal-header'>
					<button type='button' class='close' data-dismiss='modal' aria-hidden='true'>&times;</button>
					<h4 class='modal-title'>Are you sure you want to delete ?</h4> </div>
					<div class='modal-body'>
					Schedule Info <br />
					Subject: $subj_name <br />
					Code: $subj_code <br />
					Day/s: $days <br />
					Time: $startTime - $endTime <br />
					</div>
					<div class='modal-footer'>
						<input type='hidden' name='DEL_ID' value='$_ID'>
						<button type='button' class='btn btn-danger pull-left' data-dismiss='modal'>Close</button>
						<button type='submit' name='btn_del' class='btn btn-info'>Yes</button>
					</div>
			</form>
			</div>
		</div>
	</div>
</div>";
			}
		}
	}

/////////////////////////////////////////////
//DELETE MODAL
	function delAction(){
		global $_CON;
		if(isset($_POST['btn_del'])){
			$_ID = mysqli_real_escape_string($_CON, $_POST['DEL_ID']);
			$sqlDel = mysqli_query($_CON, "DELETE FROM schedule_table WHERE sched_id='$_ID' ");
			if($sqlDel){
				ob_end_clean();
				header("location: schedules.php?del=true");
			}else{
				ob_end_clean();
				header("location: schedules.php?del=false");
			}
		}
	}
	
///////////////////////////
//Updating response
	function updResponse(){

	if(isset($_GET['upd'])){
			$response = $_GET['upd'];
			if($response == 'true'){
				echo"
              <div class='callout callout-info'>
                <h4>Update Success!</h4>
                <p>Your data was successfully updated.</p>
              </div>
				";
			}elseif($response == 'exist'){
				echo"
              <div class='callout callout-warning'>
                <h4>Update Failed!</h4>
                <p>Your data wasn't updated due to Type Duplication.</p>
              </div>
				";
			}
		}
	}
///////////////////////////
//Delete response
	function delResponse(){

	if(isset($_GET['del'])){
			$response = $_GET['del'];
			if($response == 'true'){
				echo"
              <div class='callout callout-info'>
                <h4>Deleting Success!</h4>
                <p>Your data was successfully deleted.</p>
              </div>
				";
			}elseif($response == 'false'){
				echo"
              <div class='callout callout-danger'>
                <h4>Deleting Failed!</h4>
                <p>Your data wasn't deleted, Something went wrong.</p>
              </div>";
			}
		}
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
                <p>Your data was successfully added.</p>
              </div>
				";
			}elseif($response == 'exist'){
				echo"
              <div class='callout callout-danger'>
                <h4>Saving Failed!</h4>
                <p>Your data wasn't added due to Type Duplication.</p>
              </div>
				";
			}
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