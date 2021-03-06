<?php include_once'includes/header.php';?>
<?php include_once'classes/class.pupils.php';?>
<div class="wrapper">
<?php
//<!-- Main Header -->
include_once'includes/top_menu.php';
//<!-- Left side column. contains the logo and sidebar -->
include_once'includes/side_bar.php';
?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Manage Pupils
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Manage</a></li>
        <li class="active">Pupils</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
	 <div class="row">
	  <div class="col-md-6">
          <!-- Horizontal Form -->
          <div class="box box-primary">
            <div class="box-header with-border">
              <h3 class="box-title">Add Pupil</h3>
            </div>
            <!-- /.box-header -->
            <!-- form start -->
            <form class="form-horizontal" method="post" action="<?php add(); ?>">
              <div class="box-body">
                <div class="form-group">
                  <label for="inpCIN" class="col-sm-2 control-label">Student #</label>

                  <div class="col-sm-10">
                    <input type="text" class="form-control" name="inpCIN" id="inpCIN" placeholder="Student Number" required>
                  </div>
                </div>
                <div class="form-group">
                  <label for="inpFNAME" class="col-sm-2 control-label">Firstname</label>

                  <div class="col-sm-10">
                    <input type="text" class="form-control" name="inpFNAME" id="inpFNAME" placeholder="Firstname" required>
                  </div>
                </div>
                <div class="form-group">
                  <label for="inpLNAME" class="col-sm-2 control-label">Lastname</label>

                  <div class="col-sm-10">
                    <input type="text" class="form-control" name="inpLNAME" id="inpLNAME" placeholder="Lastname" required>
                  </div>
                </div>
                <div class="form-group">
                  <label for="inpSECT" class="col-sm-2 control-label">Grade/Section</label>
                  <div class="col-sm-10">
					<select class="form-control" name="inpSECT" id="inpSECT" required>
					 <option default value="">Grade/Section</option>
					 <?php optSection(); ?>
					</select>
                  </div>
                </div>
                <div class="form-group">
                  <label for="inpSEX" class="col-sm-2 control-label">Gender</label>
                  <div class="col-sm-10">
					<select class="form-control" name="inpSEX" id="inpSEX" required>
					 <option default>Gender</option>
					 <option value="M">Male</option>
					 <option value="F">Female</option>
					</select>
                  </div>
                </div>
                <div class="form-group">
                  <label for="inpPWD" class="col-sm-2 control-label"></label>

                  <div class="col-sm-10">
					Default password is 123456
                  </div>
                </div>
              </div>
              <!-- /.box-body -->
              <div class="box-footer">
			  <?php addResponse();?>
                <button type="submit" name="btn_add" class="btn btn-info pull-right btn-flat"><i class="fa fa-plus-square"></i> Add</button>
              </div>
              <!-- /.box-footer -->
            </form>
          </div>
          <!-- /.box -->
	  </div>
	  <div class="col-md-6">
          <div class="box box-primary">
            <div class="box-header">
              <h3 class="box-title">All Students</h3>

            </div>
            <!-- /.box-header -->
            <div class="box-body table-responsive no-padding">
			<?php
			delResponse();
			updResponse();
			?>
              <table class="table table-hover">
               <thead>
				<tr>
                  <th>Student #</th>
                  <th>Name</th>
                  <th>Grade/Section</th>
                </tr>
			   </thead>
			   <tbody>
			    <?php theview(); ?>
			   </tbody>
              </table>
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->
	  </div>
	 </div>
    </section>
    <!-- /.content -->
  </div>
  <?php
  updMod();
  delMod();
  ?>
  <!-- /.content-wrapper -->
<?php
//<!-- Main Footer -->
include_once'includes/footer.php';
?>