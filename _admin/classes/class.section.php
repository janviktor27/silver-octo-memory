<?php
/* Copyright (C) :JAMES DE LA CRUZ|EIJI DE LA CRUZ: - All Rights Reserved
 * Unauthorized copying of this file, via any medium is strictly prohibited
 * Proprietary and confidential
 * Written by JAMES DE LA CRUZ && EIJI DE LA CRUZ, OCTOBER 2016
 */
include_once('./../connect.php');

/////////////////////////////////////////////
//Add employee
	function add(){
		global $_CON;
		if(isset($_POST['btn_add'])){
			$inpSECT = mysqli_real_escape_string($_CON, $_POST['inpSECT']);
			$inpTEACHER = mysqli_real_escape_string($_CON, $_POST['inpTEACHER']);
			$inpTEACHER = mysqli_real_escape_string($_CON, $_POST['inpTEACHER']);
			$inpGRLVL = mysqli_real_escape_string($_CON, $_POST['inpGRLVL']);
			//CHECK IF EIN EXIST
			$sqlSearch = mysqli_query($_CON, "SELECT section_name FROM section_table WHERE section_name='$inpSECT' AND teacher_id='$inpTEACHER' AND gradelvl='$inpGRLVL' ");
			$count = mysqli_num_rows($sqlSearch);
			if($count > 0){
				ob_end_clean();
				header("location: sections.php?add=exist");
			}else{
				$sql_Search = mysqli_query($_CON, "SELECT teacher_id FROM section_table WHERE teacher_id='$inpTEACHER' AND gradelvl='$inpGRLVL'");
				$_count = mysqli_num_rows($sql_Search);
				if($_count == 1){
					ob_end_clean();
					header("location: sections.php?add=exist");
				}else{
					$sqlInsert = mysqli_query($_CON, "INSERT INTO section_table 
					(section_name, gradelvl, teacher_id)
					VALUES('$inpSECT','$inpGRLVL','$inpTEACHER')");
					ob_end_clean();
					header("location: sections.php?add=true");
				}
			}
		}
	}

/////////////////////////////////////////////
//SELECT OPTION
	function optTeacher(){
		global $_CON;
		$sqlSearch = mysqli_query($_CON, "SELECT * FROM teachers_table WHERE USER_TYPE='2' ");
		$count = mysqli_num_rows($sqlSearch);
		if($count > 0){
			while($row=mysqli_fetch_array($sqlSearch)){
				$_ID = mysqli_real_escape_string($_CON, $row['teacher_id']);
				$fname = mysqli_real_escape_string($_CON, $row['teacher_fname']);
				$lname = mysqli_real_escape_string($_CON, $row['teacher_lname']);
				echo"
				<option value='$_ID'>$lname, $fname</option>
				";
			}
		}else{
			echo"
			<option value=''>No teachers yet.</option>";
		}
	}
/////////////////////////////////////////////
//View employee
	function theview(){
		global $_CON;
		$sqlSearch = mysqli_query($_CON, "SELECT * FROM section_table");
		$count = mysqli_num_rows($sqlSearch);
		if($count > 0){
			while($row=mysqli_fetch_array($sqlSearch)){
				$_ID = mysqli_real_escape_string($_CON, $row['section_id']);
				$gradelvl = mysqli_real_escape_string($_CON, $row['gradelvl']);
				$sect_name = mysqli_real_escape_string($_CON, $row['section_name']);
				$teacher_id = mysqli_real_escape_string($_CON, $row['teacher_id']);
				//GET TEACHER INFO
				$sqlTeacher = mysqli_query($_CON,"SELECT
				teacher_fname,
				teacher_lname
				FROM teachers_table
				WHERE
				teacher_id='$teacher_id'");
				$_row = mysqli_fetch_array($sqlTeacher);
				$fname = $_row['teacher_fname'];
				$lname = $_row['teacher_lname'];
				echo"
				 <tr>
				  <td>$gradelvl - $sect_name</td>
				  <td>$fname $lname</td>
				  <td align='center'>
				   <!--button class='btn btn-info btn-xs' data-toggle='modal' data-target='#updMod$_ID'><i class='glyphicon glyphicon-edit'></i></button-->
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
		$sqlSearch = mysqli_query($_CON, "SELECT * FROM section_table");
		$count = mysqli_num_rows($sqlSearch);
		if($count > 0){
			while($row=mysqli_fetch_array($sqlSearch)){
				$_ID = mysqli_real_escape_string($_CON, $row['section_id']);
				$sect_name = mysqli_real_escape_string($_CON, $row['section_name']);
				$teacher_id = mysqli_real_escape_string($_CON, $row['teacher_id']);
				//GET TEACHER INFO
				$sqlTeacher = mysqli_query($_CON,"SELECT
				teacher_fname,
				teacher_lname
				FROM teachers_table
				WHERE
				teacher_id='$teacher_id'");
				$_row = mysqli_fetch_array($sqlTeacher);
				$fname = $_row['teacher_fname'];
				$lname = $_row['teacher_lname'];
				echo"
          <div class='modal fade modal-primary' id='updMod$_ID' tabindex='-1' role='dialog'>
          <div class='modal-dialog'>
            <div class='modal-content'>
              <div class='modal-header'>
                <button type='button' class='close' data-dismiss='modal' aria-label='Close'>
                  <span aria-hidden='true'>&times;</span></button>
                <h4 class='modal-title'>Edit Section </h4>
              </div>
			  <form class='form-horizontal' method='post' action='";updAction(); echo"'>
               <div class='modal-body'>
              <div class='box-body'>

 			   <div class='form-group'>
                  <label for='inpSECT' class='col-sm-3 control-label'>Section name</label>

                  <div class='col-sm-9'>
                    <input type='text' value='$sect_name' class='form-control' name='inpSECT' id='inpSECT' placeholder='Section name' required>
                  </div>
                </div>
                <div class='form-group'>
                  <label for='inpTEACHER' class='col-sm-3 control-label'>Adviser</label>
                  <div class='col-sm-9'>
					<select class='form-control' name='inpTEACHER' id='inpTEACHER' required>
					 <option default value='$teacher_id'>$lname, $fname</option>
					 "; optTeacher(); echo"
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
			$inpSECT = mysqli_real_escape_string($_CON, $_POST['inpSECT']);
			$inpTEACHER = mysqli_real_escape_string($_CON, $_POST['inpTEACHER']);

			//CHECK IF EIN ARE THE SAME FROM TEXTBOX AND DATABASE
			$sqlSearch = mysqli_query($_CON, "SELECT teacher_ein FROM teachers_table WHERE teacher_id='$_ID'");
			$_row = mysqli_fetch_array($sqlSearch);
			$_GETEIN = $_row['teacher_ein'];
			if($inputEIN == $_GETEIN){
				//UPDATE QUERY
				$sqlUpdate = mysqli_query($_CON,"UPDATE teachers_table SET
				teacher_fname='$inputFNAME',
				teacher_lname='$inputLNAME'
				WHERE teacher_id='$_ID' ");
				ob_end_clean();
				header("location: teachers.php?upd=true");
			}else{
				//CHECK IF EIN EXIST
				$sqlSearch = mysqli_query($_CON, "SELECT teacher_ein FROM teachers_table WHERE teacher_ein='$inputEIN' ");
				$count = mysqli_num_rows($sqlSearch);
				if($count == 1){
					ob_end_clean();
					header("location: teachers.php?upd=exist");
				}else{
					$sqlUpdate = mysqli_query($_CON,"UPDATE teachers_table SET
					teacher_ein='$inputEIN',
					teacher_fname='$inputFNAME',
					teacher_lname='$inputLNAME'
					WHERE teacher_id='$_ID' ");
					ob_end_clean();
					header("location: teachers.php?upd=true");
				}
			}
		}
	}
	
/////////////////////////////////////////////
//DELETE MODAL
	function delMod(){
		global $_CON;
		$sqlSearch = mysqli_query($_CON, "SELECT * FROM section_table");
		$count = mysqli_num_rows($sqlSearch);
		if($count > 0){
			while($row=mysqli_fetch_array($sqlSearch)){
				$_ID = mysqli_real_escape_string($_CON, $row['section_id']);
				$gradelvl = mysqli_real_escape_string($_CON, $row['gradelvl']);
				$sect_name = mysqli_real_escape_string($_CON, $row['section_name']);
				$teacher_id = mysqli_real_escape_string($_CON, $row['teacher_id']);
				//GET TEACHER INFO
				$sqlTeacher = mysqli_query($_CON,"SELECT
				teacher_fname,
				teacher_lname
				FROM teachers_table
				WHERE
				teacher_id='$teacher_id'");
				$_row = mysqli_fetch_array($sqlTeacher);
				$fname = $_row['teacher_fname'];
				$lname = $_row['teacher_lname'];
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
					Section Info <br />
					Grade/Section: $gradelvl - $sect_name <br />
					Adviser: $fname $lname
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
			$sqlDel = mysqli_query($_CON, "DELETE FROM section_table WHERE section_id='$_ID' ");
			if($sqlDel){
				ob_end_clean();
				header("location: sections.php?del=true");
			}else{
				ob_end_clean();
				header("location: sections.php?del=false");
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