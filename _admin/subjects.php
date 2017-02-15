<?php include_once'includes/header.php';?>
<?php include_once'classes/class.subjects.php';?>
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
	  Set Subjects
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Set</a></li>
        <li class="active">Subjects</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
	 <div class="row">
	  <div class="col-md-6">
          <!-- Horizontal Form -->
          <div class="box box-primary">
            <div class="box-header with-border">
              <h3 class="box-title">Add Subject</h3>
            </div>
            <!-- /.box-header -->
            <!-- form start -->
            <form class="form-horizontal" method="post" action="<?php add(); ?>">
              <div class="box-body">
                <div class="form-group">
                  <label for="inpCODE" class="col-sm-3 control-label">Subject Code</label>

                  <div class="col-sm-9">
                    <input type="text" class="form-control" name="inpCODE" id="inpCODE" placeholder="Subject code" required>
                  </div>
                </div>
                <div class="form-group">
                  <label for="inpSNAME" class="col-sm-3 control-label">Subject Name</label>

                  <div class="col-sm-9">
                    <input type="text" class="form-control" name="inpSNAME" id="inpSNAME" placeholder="Subject Name" required>
                  </div>
                </div>
                <div class="form-group">
                  <label for="inpSUBJTYPE" class="col-sm-3 control-label">Subject Type</label>

                  <div class="col-sm-9">
					<select class="form-control" name="inpSUBJTYPE" id="inpSUBJTYPE" required>
					 <option default value="">Subject type (for weighthed score)</option>
					 <option value="1">Languages/AP/EsP</option>
					 <option value="2">Science/Math</option>
					 <option value="3">Mapeh</option>
					 <option value="4">EPP/TLE</option>
					</select>
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
              <h3 class="box-title">All Subject</h3>

            </div>
            <!-- /.box-header -->
            <div class="box-body table-responsive no-padding">
			  <?php
			  updResponse();
			  delResponse();?>
              <table class="table table-hover">
			   <thead>
                <tr>
                  <th>Code</th>
                  <th>Name</th>
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
  delMod()
  ?>
  <!-- /.content-wrapper -->
<?php
//<!-- Main Footer -->
include_once'includes/footer.php';
?>