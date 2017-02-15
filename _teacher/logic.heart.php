			  <?php
			  include_once'../connect.php';
			  /*
			if($inpSUBJTYPE == 1){
				$writtenwork = .30;
				$perftask = .50;
				$quaterly = .20;
			}
			if($inpSUBJTYPE == 2){
				$writtenwork = .40;
				$perftask = .40;
				$quaterly = .20;
			}
			if($inpSUBJTYPE == 3){
				$writtenwork = .20;
				$perftask = .60;
				$quaterly = .20;
				
				MUSIC 78->ROUND OFF
				ARTS 90->ROUND OFF
				PE 88 ->ROUND OFF
				HEALTH 75 -> ROUND OFF				
				/ 4 = OFFICIAL GRADE
			}			  
			  */
			  //updResponse();
			  //delResponse();
			  ///////////////////////////
			  /*WRITTEN WORK
			  $inpSTUDSCORE = 145;
			  $inpHighest = 160;
			  $percentScore = ($inpSTUDSCORE/$inpHighest) * 100;
			  $percentScore = round($percentScore,2);
			  $weightedScore = $percentScore * .30;
			  $totalWrit = round($weightedScore,2);
			  echo round($weightedScore,2)."<BR />";
			  ///////////////////////////
			  //PERFORMANCE TASK
			  $inpPERFSTUDSCORE = 100;
			  $inpPERFHighest = 120;
			  $percentPERFScore = ($inpPERFSTUDSCORE/$inpPERFHighest) * 100;
			  $percentPERFScore = round($percentPERFScore,2);
			  $weightedPERFScore = $percentPERFScore * .50;
			  $totalPERF = round($weightedPERFScore,2);
			  echo round($weightedPERFScore,2)."<BR>";
			  ///////////////////////////
			  //FINAL EXAM
			  $inpFINSTUDSCORE = 40;
			  $inpFINHighest = 50;
			  $percentFINScore = ($inpFINSTUDSCORE/$inpFINHighest) * 100;
			  $percentFINScore = round($percentFINScore,2);
			  $weightedFINScore = $percentFINScore * .20;
			  $totalfin = round($weightedFINScore,2);
			  echo round($weightedFINScore,2);
			  
			  $gradeko = $totalWrit + $totalPERF + $totalfin;
			  echo "<br>".$gradeko;
			  */

			$sqlSwitch = mysqli_query($_CON, "SELECT * FROM switch_table");
			while($row_ko=mysqli_fetch_array($sqlSwitch)){
				$name = $row_ko['name'];
				$status = $row_ko['status'];

				if($name == 'grading_1'){
					if($status == 1){$btn_1 = "<a class='btn btn-primary btn-xs' href='grade.php?period=$enc_1&this_subject=$_SUB_ENC&stud=$enc_pup_id'>1</a>";}elseif($status == 0){$btn_1 = "<a class='btn btn-primary btn-xs disabled' href='#'>1</a>";}
				}elseif($name == 'grading_2'){
					if($status == 1){$btn_2 = "<a class='btn btn-primary btn-xs' href='grade.php?period=$enc_2&this_subject=$_SUB_ENC&stud=$enc_pup_id'>2</a>";}elseif($status == 0){$btn_2 = "<a class='btn btn-primary btn-xs disabled' href='#'>2</a>";}
				}elseif($name == 'grading_3'){
					if($status == 1){$btn_3 = "<a class='btn btn-primary btn-xs' href='grade.php?period=$enc_3&this_subject=$_SUB_ENC&stud=$enc_pup_id'>3</a>";}elseif($status == 0){$btn_3 = "<a class='btn btn-primary btn-xs disabled' href='#'>3</a>";}
				}elseif($name == 'grading_4'){
					if($status == 1){$btn_4 = "<a class='btn btn-primary btn-xs' href='grade.php?period=$enc_4&this_subject=$_SUB_ENC&stud=$enc_pup_id'>4</a>";}elseif($status == 0){$btn_4 = "<a class='btn btn-primary btn-xs disabled' href='#'>4</a>";}
				}
			}
				echo $btn_1 . "<br>" . $btn_2 . "<br>" . $btn_3 . "<br>" . $btn_4;
			  ?>