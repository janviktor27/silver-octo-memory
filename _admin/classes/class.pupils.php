<?php
/* Copyright (C) :JAMES DE LA CRUZ|EIJI DE LA CRUZ: - All Rights Reserved
 * Unauthorized copying of this file, via any medium is strictly prohibited
 * Proprietary and confidential
 * Written by JAMES DE LA CRUZ && EIJI DE LA CRUZ, OCTOBER 2016
 */
include_once('./../connect.php');

/////////////////////////////////////////////
//Add pupils
	function add(){
		global $_CON;
		if(isset($_POST['btn_add'])){
			$inpCIN = mysqli_real_escape_string($_CON, $_POST['inpCIN']);
			$inputFNAME = mysqli_real_escape_string($_CON, $_POST['inpFNAME']);
			$inputLNAME = mysqli_real_escape_string($_CON, $_POST['inpLNAME']);
			$inpSECT = mysqli_real_escape_string($_CON, $_POST['inpSECT']);
			$inpSEX = mysqli_real_escape_string($_CON, $_POST['inpSEX']);
			$default_pass = md5("123456");
			//CHECK IF EIN EXIST
			$sqlSearch = mysqli_query($_CON, "SELECT pupil_cin FROM pupils_table WHERE pupil_cin='$inputCIN' ");
			$count = mysqli_num_rows($sqlSearch);
			if($count > 0){
				ob_end_clean();
				header("location: pupils.php?add=exist");
			}else{
				$sqlInsert = mysqli_query($_CON, "INSERT INTO pupils_table 
				(pupil_cin,pupil_fname,pupil_lname,section_id,pupil_gender,pupil_pwd)
				VALUES('$inpCIN','$inputFNAME','$inputLNAME','$inpSECT','$inpSEX','$default_pass')");
				$sqlInsert2 = mysqli_query($_CON, "INSERT INTO parent_table (pupil_cin,parent_pwd)
				VALUES('$inpCIN','$default_pass')");
				header("location: pupils.php?add=true");
				ob_end_clean();
				exit;
			}
		}
	}

/////////////////////////////////////////////
//SELECT OPTION
	function optSection(){
		global $_CON;
		$sqlSearch = mysqli_query($_CON, "SELECT * FROM section_table");
		$count = mysqli_num_rows($sqlSearch);
		if($count > 0){
			while($row=mysqli_fetch_array($sqlSearch)){
				$_ID = mysqli_real_escape_string($_CON, $row['section_id']);
				$name = mysqli_real_escape_string($_CON, $row['section_name']);
				$gradelvl = mysqli_real_escape_string($_CON, $row['gradelvl']);
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
		$sqlSearch = mysqli_query($_CON, "SELECT * FROM pupils_table");
		$count = mysqli_num_rows($sqlSearch);
		if($count > 0){
			while($row=mysqli_fetch_array($sqlSearch)){
				$_ID = mysqli_real_escape_string($_CON, $row['pupil_id']);
				$_CIN = mysqli_real_escape_string($_CON, $row['pupil_cin']);
				$fname = mysqli_real_escape_string($_CON, $row['pupil_fname']);
				$lname = mysqli_real_escape_string($_CON, $row['pupil_lname']);
				$_SECID = mysqli_real_escape_string($_CON, $row['section_id']);
				$gender = mysqli_real_escape_string($_CON, $row['pupil_gender']);
				//GET SECTION INFO
				$sqlSect = mysqli_query($_CON,"SELECT section_name, gradelvl FROM section_table WHERE section_id='$_SECID' ");
				$_row = mysqli_fetch_array($sqlSect);
				$sec_name = $_row['section_name'];
				$gradelvl = $_row['gradelvl'];
				echo"
				 <tr>
				  <td>$_CIN</td>
				  <td>$fname $lname</td>
				  <td>$gradelvl - $sec_name</td>
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
		$sqlSearch = mysqli_query($_CON, "SELECT * FROM pupils_table");
		$count = mysqli_num_rows($sqlSearch);
		if($count > 0){
			while($row=mysqli_fetch_array($sqlSearch)){
				$_ID = mysqli_real_escape_string($_CON, $row['pupil_id']);
				$_CIN = mysqli_real_escape_string($_CON, $row['pupil_cin']);
				$fname = mysqli_real_escape_string($_CON, $row['pupil_fname']);
				$lname = mysqli_real_escape_string($_CON, $row['pupil_lname']);
				$_SECID = mysqli_real_escape_string($_CON, $row['section_id']);
				$gender = mysqli_real_escape_string($_CON, $row['pupil_gender']);
				if($gender == 'M'){$sex = 'Male';}else{$sex = 'Female';}
				//GET SECTION INFO
				$sqlSect = mysqli_query($_CON,"SELECT section_name,gradelvl FROM section_table WHERE section_id='$_SECID' ");
				$_row = mysqli_fetch_array($sqlSect);
				$sec_name = $_row['section_name'];
				$gradelvl = $_row['gradelvl'];
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
                  <label for='inpCIN' class='col-sm-2 control-label'>Student #</label>

                  <div class='col-sm-10'>
                    <input type='text' value='$_CIN' class='form-control' name='inpCIN' id='inpCIN' placeholder='Student Number' required>
                  </div>
                </div>
                <div class='form-group'>
                  <label for='inpFNAME' class='col-sm-2 control-label'>Firstname</label>

                  <div class='col-sm-10'>
                    <input type='text' value='$fname' class='form-control' name='inpFNAME' id='inpFNAME' placeholder='Firstname' required>
                  </div>
                </div>
                <div class='form-group'>
                  <label for='inpLNAME' class='col-sm-2 control-label'>Lastname</label>

                  <div class='col-sm-10'>
                    <input type='text' value='$lname' class='form-control' name='inpLNAME' id='inpLNAME' placeholder='Lastname' required>
                  </div>
                </div>
                <div class='form-group'>
                  <label for='inpSECT' class='col-sm-2 control-label'>Section</label>
                  <div class='col-sm-10'>
					<select class='form-control' name='inpSECT' id='inpSECT' required>
					 <option default value='$_SECID'>$gradelvl - $sec_name</option>
					 "; optSection(); echo"
					</select>
                  </div>
                </div>
                <div class='form-group'>
                  <label for='inpSEX' class='col-sm-2 control-label'>Gender</label>
                  <div class='col-sm-10'>
					<select class='form-control' name='inpSEX' id='inpSEX' required>
					 <option default value='$gender'>$sex</option>
					 <option value='M'>Male</option>
					 <option value='F'>Female</option>
					</select>
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
			$inpCIN = mysqli_real_escape_string($_CON, $_POST['inpCIN']);
			$inputFNAME = mysqli_real_escape_string($_CON, $_POST['inpFNAME']);
			$inputLNAME = mysqli_real_escape_string($_CON, $_POST['inpLNAME']);
			$inpSECT = mysqli_real_escape_string($_CON, $_POST['inpSECT']);
			$inpSEX = mysqli_real_escape_string($_CON, $_POST['inpSEX']);

			//CHECK IF PUPIL_CIN ARE THE SAME FROM TEXTBOX AND DATABASE
			$sqlSearch = mysqli_query($_CON, "SELECT pupil_cin FROM pupils_table WHERE pupil_id='$_ID' ");
			$_row = mysqli_fetch_array($sqlSearch);
			$_GETEIN = $_row['pupil_cin'];
			if($inpCIN == $_GETEIN){
				//UPDATE QUERY
				$sqlUpdate = mysqli_query($_CON,"UPDATE pupils_table SET
				pupil_fname='$inputFNAME',
				pupil_lname='$inputLNAME',
				section_id='$inpSECT',
				pupil_gender='$inpSEX'
				WHERE pupil_id='$_ID' ");
				ob_end_clean();
				header("location: pupils.php?upd=true");
				exit();
			}else{
				//CHECK IF EIN EXIST
				$sqlSearch = mysqli_query($_CON, "SELECT pupil_cin FROM pupils_table WHERE pupil_cin='$inpCIN' ");
				$count = mysqli_num_rows($sqlSearch);
				if($count == 1){
					ob_end_clean();
					header("location: pupils.php?upd=exist");
					exit();
				}else{
					$sqlUpdate = mysqli_query($_CON,"UPDATE pupils_table SET
					pupil_cin='$inpCIN',
					pupil_fname='$inputFNAME',
					pupil_lname='$inputLNAME',
					section_id='$inpSECT',
					pupil_gender='$inpSEX'
					WHERE pupil_id='$_ID' ");
					ob_end_clean();
					header("location: pupils.php?upd=true");
					exit();
				}
			}
		}
	}
	
/////////////////////////////////////////////
//DELETE MODAL
	function delMod(){
		global $_CON;
		$sqlSearch = mysqli_query($_CON, "SELECT * FROM pupils_table");
		$count = mysqli_num_rows($sqlSearch);
		if($count > 0){
			while($row=mysqli_fetch_array($sqlSearch)){
				$_ID = mysqli_real_escape_string($_CON, $row['pupil_id']);
				$_CIN = mysqli_real_escape_string($_CON, $row['pupil_cin']);
				$fname = mysqli_real_escape_string($_CON, $row['pupil_fname']);
				$lname = mysqli_real_escape_string($_CON, $row['pupil_lname']);
				$_SECID = mysqli_real_escape_string($_CON, $row['section_id']);
				$gender = mysqli_real_escape_string($_CON, $row['pupil_gender']);
				if($gender == 'M'){$sex = 'Male';}else{$sex = 'Female';}
				//GET SECTION INFO
				$sqlSect = mysqli_query($_CON,"SELECT section_name FROM section_table WHERE section_id='$_SECID' ");
				$_row = mysqli_fetch_array($sqlSect);
				$sec_name = $_row['section_name'];
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
					Pupil Info <br />
					$_CIN <br />
					$fname $lname : $sex<br />
					$gradelvl | $sec_name<br />
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
			$sqlDel = mysqli_query($_CON, "DELETE FROM pupils_table WHERE pupil_id='$_ID' ");
			if($sqlDel){
				ob_end_clean();
				header("location: pupils.php?del=true");
			}else{
				ob_end_clean();
				header("location: pupils.php?del=false");
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