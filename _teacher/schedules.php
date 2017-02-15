<?php include_once'includes/header.php';?>
<?php include_once'classes/class.schedules.php';?>
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
	  Manage Schedules
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Manage</a></li>
        <li class="active">Schedules</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
	 <div class="row">
	  <div class="col-md-6">
          <!-- Horizontal Form -->
          <div class="box box-primary">
            <div class="box-header with-border">
              <h3 class="box-title">Add Schedule</h3>
            </div>
            <!-- /.box-header -->
            <!-- form start -->
            <form class="form-horizontal" method="post" action="<?php add(); ?>">
              <div class="box-body">
                <div class="form-group">
                  <label for="inpSUBJ" class="col-sm-2 control-label">Subject</label>
                  <div class="col-sm-10">
					<select class="form-control" name="inpSUBJ" id="inpSUBJ" required>
					 <option default value="">Subject name</option>
					 <?php optSubj(); ?>
					</select>
                  </div>
                </div>
                <div class="form-group">
                  <label for="inpSECT" class="col-sm-2 control-label">Grade/Section</label>
                  <div class="col-sm-10">
					<select class="form-control" name="inpSECT" id="inpSECT" required>
					 <option default value="">Grade/Section</option>
					 <?php optSect(); ?>
					</select>
                  </div>
                </div>
                <div class="form-group">
                  <label for="daylist" class="col-sm-2 control-label">Days</label>
					<label class="col-sm-1">
						Mon
					  <input type="checkbox" name="daylist[]" value="Mon" class="flat-red">
					</label>
					<label class="col-sm-1">
						Tue
					  <input type="checkbox" name="daylist[]" value="Tue" class="flat-red">
					</label>
					<label class="col-sm-1">
						Wed
					  <input type="checkbox" name="daylist[]" value="Wed" class="flat-red">
					</label>
					<label class="col-sm-1">
						Thu
					  <input type="checkbox" name="daylist[]" value="Thu" class="flat-red">
					</label>
					<label class="col-sm-1">
						Fri
					  <input type="checkbox" name="daylist[]" value="Fri" class="flat-red">
					</label>
					<label class="col-sm-1">
						Sat
					  <input type="checkbox" name="daylist[]" value="Sat" class="flat-red">
					</label>
					<label class="col-sm-1">
						Sun
					  <input type="checkbox" name="daylist[]" value="Sun" class="flat-red">
					</label>
                </div>
                <div class="form-group">
                  <label for="inpSTIME" class="col-sm-2 control-label">Start Time</label>

                  <div class="col-sm-10">
                    <input type="time" class="form-control" name="inpSTIME" id="inpSTIME" placeholder="Start time" required>
                  </div>
                </div>
                <div class="form-group">
                  <label for="inpETIME" class="col-sm-2 control-label">End Time</label>

                  <div class="col-sm-10">
                    <input type="time" class="form-control" name="inpETIME" id="inpETIME" placeholder="End Time" required>
                  </div>
                </div>
              </div>
              <!-- /.box-body -->
              <div class="box-footer">
				<?php addResponse(); ?>
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
              <h3 class="box-title">All Schedules</h3>

            </div>
            <!-- /.box-header -->
            <div class="box-body table-responsive no-padding">
			  <?php
			  //updResponse();
			  //delResponse();?>
              <table class="table table-hover">
			   <thead>
                <tr>
                  <th>Code</th>
                  <th>Subject</th>
                  <th>Grade/Section</th>
                  <th>Day/s | Time</th>
                  <th></th>
                </tr>
			   </thead>
			   <tbody>
			   <?php theview();?>
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
  //Modals!
  updMod();
  delMod();
  ?>
  <!-- /.content-wrapper -->
<?php
//<!-- Main Footer -->
include_once'includes/footer.php';
?>