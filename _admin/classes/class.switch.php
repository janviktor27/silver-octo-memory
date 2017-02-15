<?php
/* Copyright (C) :JAMES DE LA CRUZ|EIJI DE LA CRUZ: - All Rights Reserved
 * Unauthorized copying of this file, via any medium is strictly prohibited
 * Proprietary and confidential
 * Written by JAMES DE LA CRUZ && EIJI DE LA CRUZ, OCTOBER 2016
 */
include_once('./../connect.php');

/////////////////////////////////////////////
//Add employee
	function update(){
		global $_CON;
		if(isset($_POST['btn_upd'])){
			$optGrad1 = mysqli_real_escape_string($_CON, $_POST['optGrad1']);
			$optGrad2 = mysqli_real_escape_string($_CON, $_POST['optGrad2']);
			$optGrad3 = mysqli_real_escape_string($_CON, $_POST['optGrad3']);
			$optGrad4 = mysqli_real_escape_string($_CON, $_POST['optGrad4']);
			$sqlSearch = mysqli_query($_CON, "SELECT name FROM switch_table");
			while($row=mysqli_fetch_array($sqlSearch)){
				$name = $row['name'];
				if($name = 'grading_1'){
					$sqlUpdate = mysqli_query($_CON, "UPDATE switch_table SET status='$optGrad1' WHERE name='$name'");
				}if($name = 'grading_2'){
					$sqlUpdate = mysqli_query($_CON, "UPDATE switch_table SET status='$optGrad2' WHERE name='$name'");
				}if($name = 'grading_3'){
					$sqlUpdate = mysqli_query($_CON, "UPDATE switch_table SET status='$optGrad3' WHERE name='$name'");
				}if($name = 'grading_4'){
					$sqlUpdate = mysqli_query($_CON, "UPDATE switch_table SET status='$optGrad4' WHERE name='$name'");
				}
				header("location: switch.php?update=true");
			}
		}
	}

/////////////////////////////////////////////
// FORM LOOP VIEW
	function gradSwitch(){
		global $_CON;
		$sqlSearch = mysqli_query($_CON, "SELECT * FROM switch_table");
		$count = mysqli_num_rows($sqlSearch);
		if($count > 0){
			while($row=mysqli_fetch_array($sqlSearch)){
				$_NAME = mysqli_real_escape_string($_CON, $row['name']);
				$_STATUS = mysqli_real_escape_string($_CON, $row['status']);
				if($_NAME == 'grading_1'){
					$switch_name = "Grading 1";
					if($_STATUS == 1){
						$my_opt = "
                    <label class='col-sm-3 control-label'>
						<input type='radio' name='optGrad1' id='optGrad1' value='1' checked>
                    On
					</label>
                    <label class='control-label'>
                      <input type='radio' name='optGrad1' id='optGrad1' value='0' >
                    Off
					</label>
						";
					}else{
						$my_opt = "
                    <label class='col-sm-3 control-label'>
						<input type='radio' name='optGrad1' id='optGrad1' value='1' >
                    On
					</label>
                    <label class='control-label'>
                      <input type='radio' name='optGrad1' id='optGrad1' value='0' checked>
                    Off
					</label>
						";
					}
				}
				if($_NAME == 'grading_2'){
					$switch_name = "Grading 2";
					if($_STATUS == 1){
						$my_opt = "
                    <label class='col-sm-3 control-label'>
						<input type='radio' name='optGrad2' id='optGrad2' value='1' checked>
                    On
					</label>
                    <label class='control-label'>
                      <input type='radio' name='optGrad2' id='optGrad2' value='0' >
                    Off
					</label>
						";
					}else{
						$my_opt = "
                    <label class='col-sm-3 control-label'>
						<input type='radio' name='optGrad2' id='optGrad2' value='1' >
                    On
					</label>
                    <label class='control-label'>
                      <input type='radio' name='optGrad2' id='optGrad2' value='0' checked>
                    Off
					</label>
						";
					}
				}
				if($_NAME == 'grading_3'){
					$switch_name = "Grading 3";
					if($_STATUS == 1){
						$my_opt = "
                    <label class='col-sm-3 control-label'>
						<input type='radio' name='optGrad3' id='optGrad3' value='1' checked>
                    On
					</label>
                    <label class='control-label'>
                      <input type='radio' name='optGrad3' id='optGrad3' value='0' >
                    Off
					</label>
						";
					}else{
						$my_opt = "
                    <label class='col-sm-3 control-label'>
						<input type='radio' name='optGrad3' id='optGrad3' value='1' >
                    On
					</label>
                    <label class='control-label'>
                      <input type='radio' name='optGrad3' id='optGrad3' value='0' checked>
                    Off
					</label>
						";
					}
				}
				if($_NAME == 'grading_4'){
					$switch_name = "Grading 4";
					if($_STATUS == 1){
						$my_opt = "
                    <label class='col-sm-3 control-label'>
						<input type='radio' name='optGrad4' id='optGrad4' value='1' checked>
                    On
					</label>
                    <label class='control-label'>
                      <input type='radio' name='optGrad4' id='optGrad4' value='0' >
                    Off
					</label>
						";
					}else{
						$my_opt = "
                    <label class='col-sm-3 control-label'>
						<input type='radio' name='optGrad4' id='optGrad4' value='1' >
                    On
					</label>
                    <label class='control-label'>
                      <input type='radio' name='optGrad4' id='optGrad4' value='0' checked>
                    Off
					</label>
						";
					}
				}
				echo"
                <div class='form-group'>
                  <label for='inpSECT' class='col-sm-3 control-label'>$switch_name</label>
                  <div class='radio'>
					$my_opt
                  </div>
                </div>				
				";
			}
		}
	}
///////////////////////////
//Adding response
	function updResponse(){
	if(isset($_GET['update'])){
			$response = $_GET['update'];
			if($response == 'true'){
				echo"
              <div class='callout callout-info'>
                <h4>Update Success!</h4>
                <p>Your data was successfully updated.</p>
              </div>
				";
			}
		}
	}
