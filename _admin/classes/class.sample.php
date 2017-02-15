<?php
/* Copyright (C) :ANA GRACE ESPIRITU|KRISTEIN HEINRICH DUMAPAY: - All Rights Reserved
 * Unauthorized copying of this file, via any medium is strictly prohibited
 * Proprietary and confidential
 * Written by ANA GRACE ESPIRITU && KRISTEIN HEINRICH DUMAPAY, OCTOBER 2016
 */
include_once('./../connect.php');

/////////////////////////////////////////////
//Add employee
	function add(){
		global $_CON;
		if(isset($_POST['btn_add'])){
			$inputEIN = mysqli_real_escape_string($_CON, $_POST['inputEIN']);
			$inputFNAME = mysqli_real_escape_string($_CON, $_POST['inputFNAME']);
			$inputLNAME = mysqli_real_escape_string($_CON, $_POST['inputLNAME']);
			$inputCURJOB = mysqli_real_escape_string($_CON, $_POST['inputCURJOB']);
			$inputPREJOB = mysqli_real_escape_string($_CON, $_POST['inputPREJOB']);
			$default_pass = md5("123456");
			//CHECK IF EIN EXIST
			$sqlSearch = mysqli_query($_CON, "SELECT EMP_EIN FROM employee_table WHERE EMP_EIN='$inputEIN' ");
			$count = mysqli_num_rows($sqlSearch);
			if($count > 0){
				ob_end_clean();
				header("location: employee.php?add=exist");
			}else{
				$sqlInsert = mysqli_query($_CON, "INSERT INTO employee_table 
				(EMP_EIN, EMP_FNAME, EMP_LNAME, EMP_CUR_JOB, EMP_PREV_JOB, USER_TYPE, EMP_PASSWORD)
				VALUES('$inputEIN','$inputFNAME','$inputLNAME','$inputCURJOB','$inputPREJOB','2','$default_pass')");
				ob_end_clean();
				header("location: employee.php?add=true");
			}
		}
	}

/////////////////////////////////////////////
//View employee
	function theview(){
		global $_CON;
		$sqlSearch = mysqli_query($_CON, "SELECT * FROM employee_table WHERE USER_TYPE='2' ");
		$count = mysqli_num_rows($sqlSearch);
		if($count > 0){
			while($row=mysqli_fetch_array($sqlSearch)){
				$_ID = mysqli_real_escape_string($_CON, $row['EMP_ID']);
				$ein = mysqli_real_escape_string($_CON, $row['EMP_EIN']);
				$fname = mysqli_real_escape_string($_CON, $row['EMP_FNAME']);
				$lname = mysqli_real_escape_string($_CON, $row['EMP_LNAME']);
				$curjob = mysqli_real_escape_string($_CON, $row['EMP_CUR_JOB']);
				$prejob = mysqli_real_escape_string($_CON, $row['EMP_PREV_JOB']);
				echo"
				 <tr>
				  <td>$ein</td>
				  <td>$fname $lname</td>
				  <td>$curjob</td>
				  <td>$prejob</td>
				  <td align='center'>
				   <button class='btn btn-info btn-xs' data-toggle='modal' data-target='#updMod$_ID'><i class='glyph-icon icon-edit'></i></button>
				   <button class='btn btn-danger btn-xs' data-toggle='modal' data-target='#delMod$_ID'><i class='glyph-icon icon-trash-o'></i></button>
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
		$sqlSearch = mysqli_query($_CON, "SELECT * FROM employee_table WHERE USER_TYPE='2' ");
		$count = mysqli_num_rows($sqlSearch);
		if($count > 0){
			while($row=mysqli_fetch_array($sqlSearch)){
				$_ID = mysqli_real_escape_string($_CON, $row['EMP_ID']);
				$ein = mysqli_real_escape_string($_CON, $row['EMP_EIN']);
				$fname = mysqli_real_escape_string($_CON, $row['EMP_FNAME']);
				$lname = mysqli_real_escape_string($_CON, $row['EMP_LNAME']);
				$curjob = mysqli_real_escape_string($_CON, $row['EMP_CUR_JOB']);
				$prejob = mysqli_real_escape_string($_CON, $row['EMP_PREV_JOB']);
				echo"
<!--Modal Start-->
<div class='modal fade' id='updMod$_ID' tabindex='-1' role='dialog' aria-labelledby='myModalLabel' aria-hidden='true'>
	<div class='modal-dialog'>
		<div class='modal-content'>
			<form class='form-horizontal' method='post' action='"; updAction(); echo"'>
				<div class='modal-header'>
					<button type='button' class='close' data-dismiss='modal' aria-hidden='true'>&times;</button>
					<h4 class='modal-title'>Update Employee</h4> </div>
				<div class='modal-body'>
					<div class='form-group'>
						<label for='inputEIN' class='col-sm-3 control-label'>Employee #</label>
						<div class='col-sm-9'>
							<input value='$ein' type='text' class='form-control' name='inputEIN' id='inputEIN' placeholder='Employee number' required> </div>
					</div>
					<div class='form-group'>
						<label for='inputFNAME' class='col-sm-3 control-label'>First name</label>
						<div class='col-sm-9'>
							<input value='$fname' type='text' class='form-control' name='inputFNAME' id='inputFNAME' placeholder='First name' required> </div>
					</div>
					<div class='form-group'>
						<label for='inputLNAME' class='col-sm-3 control-label'>Last name</label>
						<div class='col-sm-9'>
							<input value='$lname' type='text' class='form-control' name='inputLNAME' id='inputLNAME' placeholder='Last name' required> </div>
					</div>
					<div class='form-group'>
						<label for='inputCURJOB' class='col-sm-3 control-label'>Current Job</label>
						<div class='col-sm-9'>
							<input value='$curjob' type='text' class='form-control' name='inputCURJOB' id='inputCURJOB' placeholder='Current Job' required> </div>
					</div>
					<div class='form-group'>
						<label for='inputPREJOB' class='col-sm-3 control-label'>Previous Job</label>
						<div class='col-sm-9'>
							<input value='$prejob' type='text' class='form-control' name='inputPREJOB' id='inputPREJOB' placeholder='Previous Job (optional)'> </div>
					</div>
					<div class='modal-footer'>
						<input type='hidden' name='UPD_ID' value='$_ID'>
						<button type='button' class='btn btn-danger pull-left' data-dismiss='modal'>Close</button>
						<button type='submit' name='btn_upd' class='btn btn-info'>Update</button>
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
//UPDATE METHOD
	function updAction(){
		global $_CON;
		if(isset($_POST['btn_upd'])){
			$_ID = mysqli_real_escape_string($_CON, $_POST['UPD_ID']);
			$inputEIN = mysqli_real_escape_string($_CON, $_POST['inputEIN']);
			$inputFNAME = mysqli_real_escape_string($_CON, $_POST['inputFNAME']);
			$inputLNAME = mysqli_real_escape_string($_CON, $_POST['inputLNAME']);
			$inputCURJOB = mysqli_real_escape_string($_CON, $_POST['inputCURJOB']);
			$inputPREJOB = mysqli_real_escape_string($_CON, $_POST['inputPREJOB']);

			//CHECK IF EIN ARE THE SAME FROM TEXTBOX AND DATABASE
			$sqlSearch = mysqli_query($_CON, "SELECT EMP_EIN FROM employee_table WHERE EMP_ID='$_ID'");
			$_row = mysqli_fetch_array($sqlSearch);
			$_GETEIN = $_row['EMP_EIN'];
			if($inputEIN == $_GETEIN){
				//UPDATE QUERY
				$sqlUpdate = mysqli_query($_CON,"UPDATE employee_table SET
				EMP_FNAME='$inputFNAME', EMP_LNAME='$inputLNAME', EMP_CUR_JOB='$inputCURJOB', EMP_PREV_JOB='$inputPREJOB' WHERE EMP_ID='$_ID' ");
				ob_end_clean();
				header("location: employee.php?upd=true");
			}else{
				//CHECK IF EIN EXIST
				$sqlSearch = mysqli_query($_CON, "SELECT EMP_EIN FROM employee_table WHERE EMP_EIN='$inputEIN' ");
				$count = mysqli_num_rows($sqlSearch);
				if($count == 1){
					ob_end_clean();
					header("location: employee.php?upd=exist");
				}else{
					$sqlUpdate = mysqli_query($_CON,"UPDATE employee_table SET
					EMP_EIN='$inputEIN', EMP_FNAME='$inputFNAME', EMP_LNAME='$inputLNAME', EMP_CUR_JOB='$inputCURJOB', EMP_PREV_JOB='$inputPREJOB' WHERE EMP_ID='$_ID' ");
					ob_end_clean();
					header("location: employee.php?upd=true");
				}
			}
		}
	}
	
/////////////////////////////////////////////
//DELETE MODAL
	function delMod(){
		global $_CON;
		$sqlSearch = mysqli_query($_CON, "SELECT * FROM employee_table WHERE USER_TYPE='2' ");
		$count = mysqli_num_rows($sqlSearch);
		if($count > 0){
			while($row=mysqli_fetch_array($sqlSearch)){
				$_ID = mysqli_real_escape_string($_CON, $row['EMP_ID']);
				$ein = mysqli_real_escape_string($_CON, $row['EMP_EIN']);
				$fname = mysqli_real_escape_string($_CON, $row['EMP_FNAME']);
				$lname = mysqli_real_escape_string($_CON, $row['EMP_LNAME']);
				$curjob = mysqli_real_escape_string($_CON, $row['EMP_CUR_JOB']);
				$prejob = mysqli_real_escape_string($_CON, $row['EMP_PREV_JOB']);
				echo"
<!--Modal Start-->
<div class='modal fade' id='delMod$_ID' tabindex='-1' role='dialog' aria-labelledby='myModalLabel' aria-hidden='true'>
	<div class='modal-dialog'>
		<div class='modal-content'>
			<form class='form-horizontal' method='post' action='"; delAction(); echo"'>
				<div class='modal-header'>
					<button type='button' class='close' data-dismiss='modal' aria-hidden='true'>&times;</button>
					<h4 class='modal-title'>Are you sure you want to delete ?</h4> </div>
					<div class='modal-body'>
					$ein <br />
					$fname $lname <br />
					$curjob <br />
					$prejob
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
			$sqlDel = mysqli_query($_CON, "DELETE FROM employee_table WHERE EMP_ID='$_ID' ");
			if($sqlDel){
				ob_end_clean();
				header("location: employee.php?del=true");
			}else{
				ob_end_clean();
				header("location: employee.php?del=false");
			}
		}
	}
	
///////////////////////////////////////////
//ADD RESPONSE
	function addRes(){
		if(isset($_GET['add'])){
			$_RES = $_GET['add'];
			if($_RES == 'true'){
				echo"
								<div class='alert alert-notice'>
									<div class='bg-blue alert-icon'>
										<i class='glyph-icon icon-info'></i>
									</div>
									<div class='alert-content'>
										<h4 class='alert-title'>Adding Success</h4>
										<p>Successfully added your new employee. </p>
									</div>
								</div>";
			}
			if($_RES == 'exist'){
				echo"
								<div class='alert alert-danger'>
									<div class='bg-red alert-icon'>
										<i class='glyph-icon icon-times'></i>
									</div>
									<div class='alert-content'>
										<h4 class='alert-title'>Adding Failed</h4>
										<p>Failed adding new employee due to <code>Employee Number</code> repetition.</p>
									</div>
								</div>";
			}
		}
	}
///////////////////////////////////////////
//UPDATE RESPONSE
	function updRes(){
		if(isset($_GET['upd'])){
			$_RES = $_GET['upd'];
			if($_RES == 'true'){
				echo"
								<div class='alert alert-notice'>
									<div class='bg-blue alert-icon'>
										<i class='glyph-icon icon-info'></i>
									</div>
									<div class='alert-content'>
										<h4 class='alert-title'>Updating Success</h4>
										<p>Successfully updated your employee. </p>
									</div>
								</div>";
				}
			if($_RES == 'exist'){
				echo"
								<div class='alert alert-danger'>
									<div class='bg-red alert-icon'>
										<i class='glyph-icon icon-times'></i>
									</div>
									<div class='alert-content'>
										<h4 class='alert-title'>Updating Failed</h4>
										<p>Failed to update employee due to <code>Employee Number</code> repetition.</p>
									</div>
								</div>";
			}
		}
	}
///////////////////////////////////////////
//DELETE RESPONSE
	function delRes(){
		if(isset($_GET['del'])){
			$_RES = $_GET['del'];
			if($_RES == 'true'){
				echo"
								<div class='alert alert-notice'>
									<div class='bg-blue alert-icon'>
										<i class='glyph-icon icon-info'></i>
									</div>
									<div class='alert-content'>
										<h4 class='alert-title'>Deleting Success</h4>
										<p>Successfully deleted your employee. </p>
									</div>
								</div>";
				}
			if($_RES == 'false'){
				echo"
								<div class='alert alert-danger'>
									<div class='bg-red alert-icon'>
										<i class='glyph-icon icon-times'></i>
									</div>
									<div class='alert-content'>
										<h4 class='alert-title'>Deleting Failed</h4>
										<p>Deleting failed due to repetitive action.</p>
									</div>
								</div>";
			}
		}
	}