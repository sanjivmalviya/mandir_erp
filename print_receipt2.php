<?php require_once('config/functions.php'); ?>
<?php require_once('config/session.php'); ?>

<?php 
    
    $fee_id = $_GET['fee_id'];
    $fee_detail = getOne('fee','fee_id',$fee_id);
    $receipt_number = $fee_detail['fee_id'];
    $fee_amount = $fee_detail['amount'];

    $school = getOne('schools','school_id',$fee_detail['school_id']);
    $school_name = $school['school_name'];
    $school_description = $school['school_description'];
    $school_address = $school['school_address'];
    $school_contact = $school['school_contact'];

    $student = getOne('students','student_id',$fee_detail['student_id']);
    $student_name = $student['student_name'];
    $student_standard = $student['student_standard'];
    $student_stream = $student['student_stream'];

    if($fee_detail['payment_mode'] == 1){
        $mode = "<b>Cash</b>";
    }else{
       $mode = "Cheque from <b>".$fee_detail['bank_name']."</b>, ifsc : <b>".$fee_detail['ifsc']."</b>, Cheque Number :<b>".$fee_detail['cheque_number']."</b>";
    }
    
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title> Print Receipt </title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    
    <style>
    .box{
        height: 300px;
    }
        @media print
        {    
            .no-print, .no-print *
            {
                display: none !important;
            }
            .box{
                height: 350px;
            }
        }
    </style>


</head>
<body>
    
    <div class="container" style="margin-top: 50px;">
        
        <div class="col-md-3 col-sm-3 col-xs-3"></div>
        <div class="col-md-6 col-sm-12 col-xs-12 box" style="border: 1px solid;padding: 0;border-radius: 5px;">
            
            <div class="col-md-12 col-sm-12 col-xs-12" style="border-bottom:1px solid;height: auto;">
                <p class="text-center" style="font-size: 20px;padding-top: 10px;"><b><?php echo $school_name; ?></b></p>                
                <p class="text-center"><?php echo $school_description; ?></p>
            </div>

            <div class="col-md-12 col-sm-12 col-xs-12 text-center" style="border-bottom: 1px solid;font-size: 12px;">
                <span><?php echo $school_address; ?> , M. <?php echo $school_contact; ?></span>
            </div>

            <div class="col-md-12 col-sm-12 col-xs-12" style="padding: 0;">
                <div style="padding: 10px;" class="col-md-6 col-sm-12 col-xs-12">
                    Receipt No. : <?php echo $receipt_number; ?>
                </div>
                <div style="padding: 10px;" class="col-md-6 col-sm-12 col-xs-12 text-right">
                    Date. : <?php echo date('d-m-Y'); ?>
                </div>
                <div class="col-md-12 col-sm-12 col-xs-12" style="padding-left: 10px;padding-top: 10px;">
                    <p style="letter-spacing: 0.4px;line-height: 25px;">Received with thanks from <span style="font-weight: bold;"><?php echo $student_name; ?></span> the sum of Rupees <b><?php echo numberTowords($fee_amount); ?> Only</b> for Std. <?php echo "<b>".$standards[$student_standard]."</b>"; if($student_standard == 11 || $student_standard == 12){ echo " ".$streams[$student_stream]; } ?> in Payment by <?php echo $mode; ?> </p> 
                </div>
<?php die; ?>
                <div class="col-md-12 col-sm-12 col-xs-12" style="padding: 0;margin-top: 20px;">
                    <div class="col-md-6 col-xs-6 col-sm-6"  >
                        <span style="font-style: italic;border: 1px solid;padding:5px;font-size: 15px;border-radius: 20px;padding-left: 30px;padding-right: 30px; box-shadow: 1px 1px 1px 1px black;">Rs. <?php echo $fee_amount; ?> /-</span>
                    </div>
                    <div class="col-md-6 col-sm-6 col-xs-6 text-center" style="font-size: 17px;">
                        For <b><?php echo $school_name; ?></b>
                    </div>
                </div>
            </div>

        </div>
        <div class="col-md-3 col-sm-3 col-xs-3"></div>

        
    </div>
       
        <div class="row text-center" style="margin-top: 20px;">
            
        <button class="btn btn-primary no-print" onclick="window.print();"><i class="fa fa-print"></i> Print</button>
        </div>
    
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.0/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/js/bootstrap.min.js"></script>

    
</body>
</html>
