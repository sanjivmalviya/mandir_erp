<?php 

    require_once('config/functions.php');
    require_once('config/session.php');
    
    if(isset($_POST['submit'])){

        $next_id = 'SELECT AUTO_INCREMENT as next_id FROM information_schema.TABLES WHERE TABLE_SCHEMA = "sarwamangal_fees_collection" AND TABLE_NAME = "schools"';
        $next_id = getRaw($next_id);
        $next_id = $next_id[0]['next_id'];

        $school_code = 'SCL'.sprintf('%04d',($next_id));
        
        // FILE DATA 
        $name = $_FILES['school_logo'];
        $allowed_extensions = array('jpg','jpeg','png','gif');
        $target_path = "uploads/school_logos/";
        $file_prefix = "logo_";
        $upload = file_upload($name,$allowed_extensions,$target_path,$file_prefix);

        if($upload['error'] == 1){
            
            // $status = 0;
            // $msg = "Failed to Upload Logo, try again later";

            $form_data = array(
                'school_code'=>$school_code,
                'school_name'=>$_POST['school_name'],
                'school_contact'=>$_POST['school_contact'],
                'school_username'=>$_POST['school_username'],
                'school_password'=> $_POST['school_password'],
                'school_address'=>$_POST['school_address']
            );

            if(insert('schools',$form_data)){
                $success = "School Added Successfully";
            }else{
                $error = "Failed to add School, try again later";
            }

        }else{

            foreach($upload['files'] as $rs){

                $form_data = array(
                    'school_code'=>$school_code,
                    'school_name'=>$_POST['school_name'],
                    'school_contact'=>$_POST['school_contact'],
                    'school_logo'=>$rs,
                    'school_username'=>$_POST['school_username'],
                    'school_password'=> $_POST['school_password'],
                    'school_address'=>$_POST['school_address']
                );
                
                if(insert('schools',$form_data)){
                    $success = "School Added Successfully";
                }else{
                    $error = "Failed to add School, try again later";
                }

            }
        }

    }

    if(isset($_GET['edit'])){

      $edit_id = $_GET['edit'];
      $edit_data = getWhere('schools','school_id',$edit_id);

      foreach($edit_data as $rs){
      
          $edit_school_id = $rs['school_id'];
          $edit_school_name = $rs['school_name'];
          $edit_school_contact = $rs['school_contact'];
          $edit_school_logo = $rs['school_logo'];
          $edit_school_username = $rs['school_username'];
          $edit_school_password = $rs['school_password'];
          $edit_school_address = $rs['school_address'];
      
        }
      
      }else{

          $edit_school_id = "";
          $edit_school_name = "";
          $edit_school_contact = "";
          $edit_school_logo = "";
          $edit_school_username = "";
          $edit_school_password = "";
          $edit_school_address = "";
    
    }


  if(isset($_POST['update'])){

        // FILE DATA 
        $name = $_FILES['school_logo'];
        $allowed_extensions = array('jpg','jpeg','png','gif');
        $target_path = "uploads/school_logos/";
        $file_prefix = "logo_";
        $upload = file_upload($name,$allowed_extensions,$target_path,$file_prefix);

        if($upload['error'] == 1){
            
            // $status = 0;
            // $msg = "Failed to Upload Logo, try again later";

            $form_data = array(
                'school_name'=>$_POST['school_name'],
                'school_contact'=>$_POST['school_contact'],
                'school_username'=>$_POST['school_username'],
                'school_password'=> $_POST['school_password'],
                'school_address'=>$_POST['school_address']
            );

            if(update('schools','school_id',$_GET['edit'],$form_data)){
                $success = "School Updated Successfully";
            }else{
                $error = "Failed to update School, try again later";
            }

        }else{

            foreach($upload['files'] as $rs){

                $form_data = array(
                    'school_name'=>$_POST['school_name'],
                    'school_contact'=>$_POST['school_contact'],
                    'school_logo'=>$rs,
                    'school_username'=>$_POST['school_username'],
                    'school_password'=> $_POST['school_password'],
                    'school_address'=>$_POST['school_address']
                );

                if(update('schools','school_id',$_GET['edit'],$form_data)){
                    $success = "School Updated Successfully";
                }else{
                    $error = "Failed to add School, try again later";
                }

            }
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
                                    <h4 class="page-title">Add School</h4>
                                    </div>
                                    <div class="col-md-6 text-right">
                                        <a href="schools.php" class="btn btn-primary btn-md">View Schools</a>
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

                        <form method="post" enctype="multipart/form-data">

                           <div class="col-md-12">
                               
                               <div class="form-group col-md-4">
                                   <label for="school_name">School Name <span class="text-danger">*</span></label>
                                   <input type="text" class="form-control" id="school_name" name="school_name" tabindex="1" placeholder="Enter School Name" required value="<?php echo $edit_school_name; ?>">
                               </div>

                               <div class="form-group col-md-4">
                                   <label for="school_contact">School Phone No.</label>
                                   <input type="number" class="form-control" id="school_contact" name="school_contact" placeholder="Enter School Phone Number" tabindex="2" value="<?php echo $edit_school_contact; ?>">
                               </div>

                               <div class="form-group col-md-4">
                                   <label for="school_logo">School Logo</label>
                                   <input type="file"  id="school_logo" name="school_logo" tabindex="3">
                                   <img src="<?php echo $edit_school_logo; ?>" style="width: 50px;" alt="">
                               </div>


                           </div>    

                           <div class="col-md-12">
                               
                               <div class="form-group col-md-4">
                                   <label for="school_username">School Username <span class="text-danger">*</span></label>
                                   <input type="text" class="form-control" id="school_username" name="school_username" placeholder="Enter School Username" required="" tabindex="4" value="<?php echo $edit_school_username; ?>">
                               </div>

                               <div class="form-group col-md-4">
                                   <label for="school_password">School Password <span class="text-danger">*</span></label><a class="btn btn-default btn-xs generate_password pull-right" tabindex="6"><i class="fa fa-refresh"></i></a>
                                   <input type="text" class="form-control" id="school_password" name="school_password" placeholder="Enter School Password" required="" tabindex="5" value="<?php echo $edit_school_password; ?>">
                               </div>

                               <div class="form-group col-md-4">
                                   <label for="school_address">School Address</label>
                                   <textarea class="form-control" id="school_address" name="school_address" placeholder="Enter School Address" tabindex="7"><?php echo $edit_school_address; ?></textarea>
                               </div>

                           </div>

                           <div class="col-md-12 text-right">
                                   
                                 <?php if(isset($_GET['edit'])){ ?>

                                   <button type="submit" tabindex="8" name="update" class="btn btn-danger"><i class="fa fa-floppy-o"></i> &nbsp;Update School</button>
                                
                                <?php }else{ ?>
                                
                                   <button type="submit" tabindex="8" name="submit" class="btn btn-primary"><i class="fa fa-floppy-o"></i> &nbsp;Save School</button>

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
            
            $('.generate_password').on('click keypress', function(){

                var password = generatePassword();
                $('#school_password').val(password);

            });

        </script>

    </body>
</html>