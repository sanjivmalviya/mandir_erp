<?php require_once('config/functions.php'); ?>
<?php require_once('config/session.php'); ?>

<?php 
    
    // $students = getAllByOrder('students','created_at','DESC');
    
    $connect = connect();
    $school_id = $_SESSION['qcpt_mandir']['user_id'];
    $schools = getAll('schools');

    $students = getAllByOrder('fee','fee_id','DESC'); 

    if(isset($_POST['search'])){
        
        $search_school_id = $_POST['school_id'];
        
        if($search_school_id == 0){

             $students = getAllByOrder('fee','fee_id','DESC');  

        }else{
            
             $students = getWhere('fee','school_id',$search_school_id); 
             
        }

    }

    $total_students = count($students);

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
                        <!-- <div class="row">
                                                    <div class="col-xs-12">
                                                        <div class="page-title-box">
                                    <div class="col-md-6">
                                    <h4 class="page-title">Students</h4>
                                    </div>
                                    <div class="col-md-6 text-right">
                                        <a href="add_student.php" style="border-radius: 25px;" class="btn btn-primary btn-md"><i class="fa fa-plus"></i> Add Student</a>
                                    </div>
                                    <div class="clearfix"></div>
                                </div>
                                                    </div>
                                                </div> -->
                        <!-- end row -->

                        <div class="row" style="margin-top: 20px;">


                            <div class="col-md-12">

                                <form method="post">

                                <div class="col-md-3">

                                    <label for="school_id">Select School</label>
                                    
                                    <select name="school_id" id="school_id" class="select2">

                                        <option value="0">All</option>
                                    
                                        <?php if(isset($schools)){ ?>
                                    
                                            <?php foreach ($schools as $rs) { ?>

                                                <option <?php if(isset($_POST['school_id']) && $_POST['school_id'] == $rs['school_id']){ echo "selected"; } ?> value="<?php echo $rs['school_id']; ?>"><?php echo $rs['school_name']; ?></option>

                                            <?php } ?>
                                        
                                        <?php } ?>
                                    
                                    </select>

                                </div>

                                <div class="col-md-3">
                                    <br>
                                    <button style="margin-top: 8px;" type="submit" class="btn btn-primary" name="search"><i class="fa fa-search"></i> Search </button>
                                </div>

                                </form>

                            </div>
    
                            
                            <div class="col-md-12" style="margin-top: 10px;">

                            <hr>

                            <p style="font-size: 13px;" class="text-primary"> <?php echo $total_students; ?> Records Found for 
                                <?php if(isset($_POST['school_id']) && $_POST['school_id'] != 0){ 
                                    
                                    $this_school_name = getOne('schools','school_id',$_POST['school_id']);
                                    echo $this_school_name['school_name'];

                                 }else{ 

                                    echo "All"; 
                                } ?>
                            </p>

                            <table id="table_students" class="table table-striped table-responsive table-condensed table-bordered">
                                <thead>
                                    <tr>
                                        <th class="text-center">School</th>
                                        <th class="text-center">Student</th>
                                        <th class="text-right">Amount</th>
                                        <th class="text-right">Paid at</th>
                                    </tr>
                                </thead>

                                <tbody>
                                    <?php if(isset($students)){ ?>
                                        <?php $total_amount = 0; foreach($students as $rs){ ?>

                                            <tr>
                                                <td style="padding: 5px;" class="text-center">
                                                <?php 
                                                    $school_name = getOne('schools','school_id',$rs['school_id']);
                                                    echo $school_name = $school_name['school_name']; 
                                                    
                                                ?></td>
                                                <td style="padding: 5px;" class="text-center">
                                                <?php 
                                                    $student_name = getOne('students','student_id',$rs['student_id']);
                                                    echo $student_name = $student_name['student_name']; 
                                                    
                                                ?></td>
                                                <td style="padding: 5px;" class="text-right"><?php echo $rs['amount']; $total_amount += $rs['amount']; ?></td>
                                                <td class="text-right"><?php echo date('d-M-Y',strtotime($rs['created_at'])); ?></td>
                                            </tr>

                                        <?php } ?>
                                        <tr>
                                            <td></td>
                                            <td></td>
                                            <td class="text-right" style="font-weight: bold;"><?php echo $total_amount; ?></td>
                                            <td></td>
                                        </tr>
                                    <?php } ?>
                                </tbody>
                            </table>
                            </div>

                        </div>
                        




                    </div> <!-- container -->
                </div> <!-- content -->
            </div>


            <!-- ============================================================== -->
            <!-- End Right content here -->
            <!-- ============================================================== -->


           

        </div>

        <!-- Modals -->

        <div id="feeModal" class="modal fade" role="dialog">
          <div class="modal-dialog">

            <!-- Modal content-->
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Fee Details</h4>
              </div>
              <div class="modal-body">

                <table class="table table-striped table-condensed">
                    <tbody>
                            
                        <tr>
                            <td>Amount :</td>
                            <td><span class="data_fee_amount"></span></td>
                        </tr>
                        
                        <tr>
                            <td>Payment Mode : </td>
                            <td><span class="data_fee_payment_mode"></span></td>
                        </tr>
                        
                        <tr class="bank_details">
                            <td>Bank Name : </td>
                            <td><span class="data_fee_bank_name"></span></td>
                        </tr>
                        
                        <tr class="bank_details">
                            <td>Cheque Number : </td>
                            <td><span class="data_fee_cheque_number"></span></td>
                        </tr>
                        
                        <tr class="bank_details">
                            <td>IFSC : </td>
                            <td><span class="data_fee_ifsc"></span></td>
                        </tr>
                        
                        <tr>
                            <td>Paid at : </td>
                            <td><span class="data_fee_paid_at"></span></td>
                        </tr>
                    
                    </tbody>

                </table>
                
                
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-primary" data-dismiss="modal"><i class="fa fa-print"></i> Print Receipt</button>
                <!-- <button type="button" class="btn btn-default" data-dismiss="modal">Close</button> -->
              </div>
            </div>

          </div>
        </div>

        <!-- END wrapper -->
        <!-- START Footerscript -->
        <?php require_once('include/footerscript.php'); ?>

        <script>
            
            $('#table_students').dataTable({
                "order": [[ 0, "desc" ]]
            });

            $('.show-fee').on('click', function(){
                
                var data_fee_amount = $(this).attr('data-fee-amount');
                var data_fee_payment_mode = $(this).attr('data-fee-payment-mode');
                var data_fee_bank_name = $(this).attr('data-fee-bank-name');
                var data_fee_cheque_number = $(this).attr('data-fee-cheque-number');
                var data_fee_ifsc = $(this).attr('data-fee-ifsc');
                var data_fee_paid_at = $(this).attr('data-fee-paid-at');

                if(data_fee_payment_mode == 1){
                    $('.bank_details').hide();
                    var mode = "Cash";
                }else{
                    var mode = "Cheque";
                }
                $('.data_fee_amount').html(data_fee_amount);
                $('.data_fee_payment_mode').html(mode);
                $('.data_fee_bank_name').html(data_fee_bank_name);
                $('.data_fee_cheque_number').html(data_fee_cheque_number);
                $('.data_fee_ifsc').html(data_fee_ifsc);
                $('.data_fee_paid_at').html(data_fee_paid_at);


            });

        </script>

    </body>
</html>