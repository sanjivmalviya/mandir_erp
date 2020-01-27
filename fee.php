<?php 
  
    require_once('config/functions.php'); 
    require_once('config/session.php'); 

    $schools = getAll('schools');    

    if(isset($_POST['submit'])){
      
      if($_POST['payment_mode'] == '2'){
        $cheque_number = $_POST['cheque_number'];
        $bank_name = $_POST['bank_name'];
        $ifsc = $_POST['ifsc'];
      }else{
        $cheque_number = "";
        $bank_name = "";
        $ifsc = "";
      }

      $form_data = array(
          'school_id'=>$_POST['school_id'],
          'payment_mode'=>$_POST['payment_mode'],
          'student_id'=>$_POST['student_id'],
          'amount'=>$_POST['amount'],
          'cheque_number'=>$cheque_number,
          'bank_name'=>$bank_name,
          'ifsc'=>$ifsc
      );

      if(insert('fee',$form_data)){
          $success = "Fee Paid Successfully";
          
          $last_id = last_id('fee','fee_id');
          header('location:print_receipt.php?fee_id='.$last_id);

      }else{
          $error = "Failed to pay fee, try again later";
      }
  }

  $students = getWhere('students','school_id',$_SESSION['qcpt_mandir']['user_id']);

  if(isset($_GET['student_id'])){
        
        $edit_data = getOne('students','student_id',$_GET['student_id']);
        $edit_school_id = $edit_data['school_id'];
        $edit_student_id = $edit_data['student_id'];

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
                                    <h4 class="page-title">Pay Student Fee</h4>
                                    </div>
                                  <!--   <div class="col-md-6 text-right">
                                        <a href="students.php" class="btn btn-primary btn-md">View Students</a>
                                    </div> -->
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
                                   <label for="school_id">School <span class="text-danger">*</span></label>
                                   <select class="select2" id="school_id" name="school_id">
                                    <?php if(isset($schools)){ ?>
                                      <?php foreach ($schools as $rs) { ?>

                                          <option <?php if(isset($edit_school_id) && $edit_school_id == $rs['school_id']){ echo "selected"; }else if($_SESSION['qcpt_mandir']['user_id'] == $rs['school_id']){ echo "selected"; } ?> value="<?php echo $rs['school_id']; ?>"><?php echo $rs['school_name']; ?></option>
                                        
                                      <?php } ?>
                                    <?php } ?>
                                   </select>
                               </div>

                          </div>

                           <div class="col-md-12">
                          <hr>
                               
                               <div class="form-group col-md-3">
                                   <label for="student_id">Select Student <span class="text-danger">*</span></label>
                                   <select class="select2" id="student_id" name="student_id" required="">
                                    <?php if(isset($students)){ ?>
                                      <?php foreach ($students as $rs) { ?>

                                          <option <?php if(isset($edit_student_id) && $edit_student_id == $rs['student_id']){ echo "selected"; } ?> value="<?php echo $rs['student_id']; ?>"><?php echo $rs['student_name']; ?></option>
                                        
                                      <?php } ?>
                                    <?php } ?>
                                   </select>
                               </div>

                                <div class="form-group col-md-3">
                                   <label for="amount">Amount</label>
                                   <input type="number" class="form-control" id="amount" name="amount" placeholder="Enter Fee Amount" tabindex="2" required="">
                               </div>
                               
                             
                                   <div class="form-group col-md-3 payment_mode">
                                     <label for="payment_mode">Stream</label>
                                     <select class="form-control" id="payment_mode" name="payment_mode" tabindex="3" required="">
                                     <?php if(isset($payment_modes)){ ?>
                                      <?php foreach ($payment_modes as $key => $value) { ?>
                                        <option value="<?php echo $key; ?>"><?php echo $value; ?></option>
                                        <?php } ?>
                                     <?php } ?>
                                     </select>
                                 </div>

    

                           </div>    

                           <div class="col-md-12 bank_section" style="display: none;">                               

                               <div class="form-group col-md-3">
                                   <label for="cheque_number">Cheque Number</label>
                                   <input type="text" class="form-control" id="cheque_number" name="cheque_number" placeholder="Enter Cheque Number" tabindex="4">
                               </div>
                              
                               <div class="form-group col-md-3">
                                   <label for="bank_name">Bank Name</label>
                                   <input type="text" class="form-control" id="bank_name" name="bank_name" placeholder="Enter Bank Name" tabindex="5">
                               </div>

                               <div class="form-group col-md-3">
                                   <label for="ifsc">IFSC</label>
                                   <input type="text" class="form-control" id="ifsc" name="ifsc" placeholder="Enter IFSC" tabindex="6">
                               </div>

                           </div>

                           <div class="col-md-12" style="margin-top: 20px;">

                            <div class="col-md-12">
                                
                                   <button type="submit" tabindex="7" name="submit" class="btn btn-primary"><i class="fa fa-rupee"></i> &nbsp;Pay Now</button>

                            </div>
                                   

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
                
                $('#student_id').focus();

            });
          

            $('#payment_mode').on('change', function(){

                if($(this).val() == 2){
                  $('.bank_section').show();
                }else{
                  $('.bank_section').hide();
                }
            });


        </script>

    </body>
</html>