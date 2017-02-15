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
			$inputEIN = mysqli_real_escape_string($_CON, $_POST['inpEIN']);
			$inputFNAME = mysqli_real_escape_string($_CON, $_POST['inpFNAME']);
			$inputLNAME = mysqli_real_escape_string($_CON, $_POST['inpLNAME']);
			$default_pass = md5("123456");
			//CHECK IF EIN EXIST
			$sqlSearch = mysqli_query($_CON, "SELECT teacher_ein FROM teachers_table WHERE teacher_ein='$inputEIN' ");
			$count = mysqli_num_rows($sqlSearch);
			if($count > 0){
				ob_end_clean();
				header("location: teachers.php?add=exist");
			}else{
				$sqlInsert = mysqli_query($_CON, "INSERT INTO teachers_table 
				(teacher_ein,teacher_fname,teacher_lname,user_type,teacher_pwd)
				VALUES('$inputEIN','$inputFNAME','$inputLNAME','2','$default_pass')");
				ob_end_clean();
				header("location: teachers.php?add=true");
			}
		}
	}

/////////////////////////////////////////////
//View employee
	function theview(){
		global $_CON;
		$sqlSearch = mysqli_query($_CON, "SELECT * FROM teachers_table WHERE USER_TYPE='2' ");
		$count = mysqli_num_rows($sqlSearch);
		if($count > 0){
			while($row=mysqli_fetch_array($sqlSearch)){
				$_ID = mysqli_real_escape_string($_CON, $row['teacher_id']);
				$ein = mysqli_real_escape_string($_CON, $row['teacher_ein']);
				$fname = mysqli_real_escape_string($_CON, $row['teacher_fname']);
				$lname = mysqli_real_escape_string($_CON, $row['teacher_lname']);
				echo"
				 <tr>
				  <td>$ein</td>
				  <td>$fname $lname</td>
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
		$sqlSearch = mysqli_query($_CON, "SELECT * FROM teachers_table WHERE user_type='2' ");
		$count = mysqli_num_rows($sqlSearch);
		if($count > 0){
			while($row=mysqli_fetch_array($sqlSearch)){
				$_ID = mysqli_real_escape_string($_CON, $row['teacher_id']);
				$ein = mysqli_real_escape_string($_CON, $row['teacher_ein']);
				$fname = mysqli_real_escape_string($_CON, $row['teacher_fname']);
				$lname = mysqli_real_escape_string($_CON, $row['teacher_lname']);
				echo"
          <div class='modal fade modal-primary' id='updMod$_ID' tabindex='-1' role='dialog'>
          <div class='modal-dialog'>
            <div class='modal-content'>
              <div class='modal-header'>
                <button type='button' class='close' data-dismiss='modal' aria-label='Close'>
                  <span aria-hidden='true'>&times;</span></button>
                <h4 class='modal-title'>Edit Teacher </h4>
              </div>
			  <form class='form-horizontal' method='post' action='";updAction(); echo"'>
               <div class='modal-body'>
              <div class='box-body'>

				<div class='form-group'>
                  <label for='inpEIN' class='col-sm-3 control-label'>Employee #</label>

                  <div class='col-sm-9'>
                    <input type='text' value='$ein' class='form-control' name='inpEIN' id='inpEIN' placeholder='Employee Number' required>
                  </div>
                </div>
                <div class='form-group'>
                  <label for='inpFNAME' class='col-sm-3 control-label'>Firstname</label>

                  <div class='col-sm-9'>
                    <input type='text' value='$fname' class='form-control' name='inpFNAME' id='inpFNAME' placeholder='Firstname' required>
                  </div>
                </div>
                <div class='form-group'>
                  <label for='inpLNAME' class='col-sm-3 control-label'>Lastname</label>
                  <div class='col-sm-9'>
                    <input type='text' value='$lname' class='form-control' name='inpLNAME' id='inpLNAME' placeholder='Lastname' required>
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
			$inputEIN = mysqli_real_escape_string($_CON, $_POST['inpEIN']);
			$inputFNAME = mysqli_real_escape_string($_CON, $_POST['inpFNAME']);
			$inputLNAME = mysqli_real_escape_string($_CON, $_POST['inpLNAME']);

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
		$sqlSearch = mysqli_query($_CON, "SELECT * FROM teachers_table WHERE user_type='2' ");
		$count = mysqli_num_rows($sqlSearch);
		if($count > 0){
			while($row=mysqli_fetch_array($sqlSearch)){
				$_ID = mysqli_real_escape_string($_CON, $row['teacher_id']);
				$ein = mysqli_real_escape_string($_CON, $row['teacher_ein']);
				$fname = mysqli_real_escape_string($_CON, $row['teacher_fname']);
				$lname = mysqli_real_escape_string($_CON, $row['teacher_lname']);
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
					Teacher Info
					$ein <br />
					$fname $lname
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
			$sqlDel = mysqli_query($_CON, "DELETE FROM teachers_table WHERE teacher_id='$_ID' ");
			if($sqlDel){
				ob_end_clean();
				header("location: teachers.php?del=true");
			}else{
				ob_end_clean();
				header("location: teachers.php?del=false");
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