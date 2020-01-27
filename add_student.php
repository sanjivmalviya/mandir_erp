<?php 
    
    require_once('config/functions.php'); 
    require_once('config/session.php'); 

    $schools = getAll('schools');    

    if(isset($_POST['submit'])){
      
      if($_POST['student_standard'] == '11' || $_POST['student_standard'] == '12'){
        $student_stream = $_POST['student_stream'];
      }else{
        $student_stream = "";
      }

      if($_POST['student_stream'] == '2'){
        $student_subject = $_POST['student_subject'];
      }else{
        $student_subject = "";
      }

      $form_data = array(
          'school_id'=>$_POST['school_id'],
          'student_teacher'=>$_POST['student_teacher'],
          'student_name'=>$_POST['student_name'],
          'student_medium'=>$_POST['student_medium'],
          'student_standard'=>$_POST['student_standard'],
          'student_stream'=>$student_stream,
          'student_subject'=>$student_subject,
          'student_contact'=>$_POST['student_contact'],
          'student_parent_contact'=> $_POST['student_parent_contact'],
          'student_address'=>$_POST['student_address']
      );

      if(insert('students',$form_data)){
          $success = "Student Added Successfully";

          $last_id = last_id('students','student_id');
          header('location:fee.php?student_id='.$last_id);  
          
      }else{
          $error = "Failed to add student, try again later";
      }
  }

  if(isset($_GET['edit'])){

      $edit_id = $_GET['edit'];
      $edit_data = getWhere('students','student_id',$edit_id);
        
      foreach($edit_data as $rs){
        $edit_school_id = $rs['school_id'];
        $edit_student_name = $rs['student_name'];
        $edit_student_standard = $rs['student_standard'];
        $edit_student_stream = $rs['student_stream'];
        $edit_student_subject = $rs['student_subject'];
        $edit_student_medium = $rs['student_medium'];
        $edit_student_contact = $rs['student_contact'];
        $edit_student_parent_contact = $rs['student_parent_contact'];
        $edit_student_address = $rs['student_address'];
      }
  }else{
      $edit_school_id = "";
      $edit_student_name = "";
      $edit_student_standard = "";
      $edit_student_stream = "";
      $edit_student_subject = "";
      $edit_student_medium = "";
      $edit_student_contact = "";
      $edit_student_parent_contact = "";
      $edit_student_address = "";
  }

  if(isset($_POST['update'])){

      if($_POST['student_standard'] == '11' || $_POST['student_standard'] == '12'){
        $student_stream = $_POST['student_stream'];
      }else{
        $student_stream = "";
      }

      if($_POST['student_stream'] == '2'){
        $student_subject = $_POST['student_subject'];
      }else{
        $student_subject = "";
      }

      $form_data = array(
          'school_id'=>$_POST['school_id'],
          'student_name'=>$_POST['student_name'],
          'student_medium'=>$_POST['student_medium'],
          'student_standard'=>$_POST['student_standard'],
          'student_stream'=>$student_stream,
          'student_subject'=>$student_subject,
          'student_contact'=>$_POST['student_contact'],
          'student_parent_contact'=> $_POST['student_parent_contact'],
          'student_address'=>$_POST['student_address']
      );

      if(update('students','student_id',$_GET['edit'],$form_data)){
          $success = "Student Updated Successfully";
      }else{
          $error = "Failed to updated student, try again later";
      }
  }

?>
<!DOCTYPE html>
<html>
<?php require_once('include/headerscript.php'); ?>
<body class="fixed-left">
        <!-- Begin page -->
        <div id="wrapper">

            <!-- Top Bar Start -->
            <?php require_once('include/topbar.php'); ?>
            <!-- Top Bar End -->

            <!-- ========== Left Sidebar Start ========== -->
            <?php require_once('include/sidebar.php'); ?>
            <!-- Left Sidebar End -->            

            <!-- ============================================================== -->
            <!-- Start right Content here -->
            <!-- ============================================================== -->
            <div class="content-page">
                <!-- Start content -->
                <div class="content">
                    <div class="container">
                        <div class="row">
							<div class="col-xs-12">
								<div class="page-title-box">
                                    <div class="col-md-6">
                                    <h4 class="page-title">Student Enrollment</h4>
                                    </div>
                                    <div class="col-md-6 text-right">
                                        <a href="students.php" class="btn btn-primary btn-md">View Students</a>
                                    </div>
                                    <div class="clearfix"></div>
                                </div>
							</div>
						</div>
                        <!-- end row -->

                        <div class="row">

                            <div class="col-md-12">
                                <?php if(isset($success)){ ?>
                                    <div class="alert alert-success"><?php echo $success; ?></div>
                                <?php }else if(isset($error)){ ?>
                                    <div class="alert alert-danger"><?php echo $error; ?></div>
                                <?php }else if(isset($warning)){ ?>
                                    <div class="alert alert-warning"><?php echo $warning; ?></div>
                                <?php }else if(isset($info)){ ?>
                                    <div class="alert alert-info"><?php echo $info; ?></div>
                                <?php } ?>
                            </div>

                        <form method="post">

                          <div class="col-md-12">
                            <div class="form-group col-md-3">
                                   <label for="school_id">School</label>
                                   <select class="select2" id="school_id" name="school_id">
                                    <?php if(isset($schools)){ ?>
                                      <?php foreach ($schools as $rs) { ?>

                                          <option <?php if(isset($edit_school_id) && $edit_school_id == $rs['school_id']){ echo "selected"; }else if($_SESSION['qcpt_mandir']['user_id'] == $rs['school_id']){ echo "selected"; } ?> value="<?php echo $rs['school_id']; ?>"><?php echo $rs['school_name']; ?></option>
                                        
                                      <?php } ?>
                                    <?php } ?>
                                   </select>
                               </div>

                               <div class="form-group col-md-3">
                                   <label for="student_teacher">Teacher <span class="text-danger">*</span></label>
                                   <select class="form-control" id="student_teacher" name="student_teacher" tabindex="1" required="">
                                    <?php if(isset($teachers)){ ?>
                                      <?php foreach ($teachers as $value) { ?>

                                          <option <?php if($value == $edit_student_teacher){ echo "selected"; } ?> value="<?php echo $value; ?>"><?php echo $value; ?></option>
                                        
                                      <?php } ?>
                                    <?php } ?>
                                   </select>
                               </div>




                          </div>

                           <div class="col-md-12">
                          <hr>
                               
                               <div class="form-group col-md-3">
                                   <label for="student_name">Student Name <span class="text-danger">*</span></label>
                                   <input type="text" class="form-control" id="student_name" name="student_name" tabindex="2" placeholder="Enter Student Name" required value="<?php echo $edit_student_name; ?>">
                               </div>

                               <div class="form-group col-md-3">
                                   <label for="student_medium">Medium <span class="text-danger">*</span></label>
                                   <select class="form-control" id="student_medium" name="student_medium" tabindex="3" required="">
                                     <option <?php if(isset($edit_student_medium) && $edit_student_medium == "1"){ echo "selected"; } ?> value="1">Gujarati</option>
                                     <option <?php if(isset($edit_student_medium) && $edit_student_medium == "2"){ echo "selected"; } ?> value="2">English</option>
                                   </select>
                               </div>

                               <div class="form-group col-md-2">
                                   <label for="student_standard">Std. <span class="text-danger">*</span></label>
                                   <select class="form-control" id="student_standard" name="student_standard" tabindex="4" required="">
                                    <?php if(isset($standards)){ ?>
                                      <?php foreach ($standards as $key => $value) { ?>

                                          <option <?php if($key == $edit_student_standard){ echo "selected"; } ?> value="<?php echo $key; ?>"><?php echo $value; ?></option>
                                        
                                      <?php } ?>
                                    <?php } ?>
                                   </select>
                               </div>

                               <?php if($edit_student_standard == '11' || $edit_student_standard == '12'){ ?>
                                 <div class="form-group col-md-2 student_stream">
                                     <label for="student_stream">Stream</label>
                                     <select class="form-control" id="student_stream" name="student_stream" tabindex="5">
                                       <option <?php if(isset($edit_student_stream) && $edit_student_stream == "1"){ echo "selected"; } ?> value="1">Commerce</option>
                                       <option <?php if(isset($edit_student_stream) && $edit_student_stream == "2"){ echo "selected"; } ?> value="2">Science</option>
                                     </select>
                                 </div>
                               <?php }else{ ?>
                                   <div class="form-group col-md-2 student_stream" style="display: none;">
                                     <label for="student_stream">Stream</label>
                                     <select class="form-control" id="student_stream" name="student_stream" tabindex="5">
                                       <option value="1">Commerce</option>
                                       <option value="2">Science</option>
                                     </select>
                                 </div>

                               <?php } ?>

                               <?php if($edit_student_stream == '2'){ ?>
                                 <div class="form-group col-md-2 student_subject">
                                     <label for="student_subject">Subject</label>
                                     <select class="form-control" id="student_subject" name="student_subject" tabindex="6">
                                       <option <?php if(isset($edit_student_subject) && $edit_student_subject == "1"){ echo "selected"; } ?> value="1">Maths</option>
                                       <option <?php if(isset($edit_student_subject) && $edit_student_subject == "2"){ echo "selected"; } ?> value="2">Bio</option>
                                     </select>
                                 </div>
                               <?php }else{ ?>
                                   <div class="form-group col-md-2 student_subject" style="display: none;">
                                     <label for="student_subject">Stream</label>
                                     <select class="form-control" id="student_subject" name="student_subject" tabindex="6">
                                       <option value="1">Maths</option>
                                       <option value="2">Bio</option>
                                     </select>
                                 </div>

                               <?php } ?>
    

                           </div>    

                           <div class="col-md-12">
                               
                               <div class="form-group col-md-3">
                                   <label for="student_contact">Student Phone</label>
                                   <input type="number" class="form-control" id="student_contact" name="student_contact" placeholder="Enter Phone Number" tabindex="7" value="<?php echo $edit_student_contact; ?>">
                               </div>

                               <div class="form-group col-md-3">
                                   <label for="student_parent_contact">Parent Phone</label>
                                   <input type="number" class="form-control" id="student_parent_contact" name="student_parent_contact" placeholder="Enter Parent's Phone Number" tabindex="8" value="<?php echo $edit_student_parent_contact; ?>">
                               </div>

                               <div class="form-group col-md-6">
                                   <label for="student_address">Address</label>
                                   <textarea class="form-control" id="student_address" name="student_address" placeholder="Enter student Address" tabindex="9" rows="2"><?php echo $edit_student_address; ?></textarea>
                               </div>

                           </div>

                           <div class="col-md-12 ">

                                <?php if(isset($_GET['edit'])){ ?>

                                   <button type="submit" tabindex="10" name="update" class="btn btn-danger"><i class="fa fa-floppy-o"></i> &nbsp;Update Student</button>
                                
                                <?php }else{ ?>
                                
                                   <button type="submit" tabindex="10" name="submit" class="btn btn-primary"><i class="fa fa-floppy-o"></i> &nbsp;Save Student</button>

                                <?php } ?>
                                   

                             </div>

                            </form>

                           </div>    

                        </div>
                        




                    </div> <!-- container -->
                </div> <!-- content -->
            </div>


            <!-- ============================================================== -->
            <!-- End Right content here -->
            <!-- ============================================================== -->


           

        </div>
        <!-- END wrapper -->
        <!-- START Footerscript -->
        <?php require_once('include/footerscript.php'); ?>
        <script src="custom.js"></script>

        <script>

            $(document).on('ready', function(){
                
                $('#student_teacher').focus();

            });          

            $('#student_standard').on('change', function(){

                if($(this).val() == 11 || $(this).val() == 12){
                  $('.student_stream').show();
                }else{
                  $('.student_stream').hide();
                  $('.student_subject').hide();
                }
            });

            $('#student_stream').on('change', function(){

                if($(this).val() == 2){
                  $('.student_subject').show();
                }else{
                  $('.student_subject').hide();
                }
            });


        </script>

    </body>
</html>