<?php

error_reporting(E_ALL ^ E_WARNING);
ini_set('display_errors', 0);
require('classes/Authentication.php');
require('classes/resident.class.php');
require('classes/Certificate.php');

$auth = new Authentication();
$resident = new Resident();
$certificate = new Certificate();

$auth->validate_admin();
$userdetails = $auth->get_userdata();

$certificate->delete_certofres();
$view = $certificate->view_certofres();
$id_resident = $_GET['id_resident'];
$resident_data = $certificate->get_single_certofres($id_resident);

?>

<?php
include('dashboard_sidebar_start.php');
?>

<style>
.input-icons i {
    position: absolute;
}

.input-icons {
    width: 30%;
    margin-bottom: 10px;
    margin-left: 34%;
}

.icon {
    padding: 10px;
    min-width: 40px;
}

.form-control {
    text-align: center;
}
</style>

<!-- Begin Page Content -->

<div class="container-fluid">

    <!-- Page Heading -->

    <div class="row">
        <div class="col text-center">
            <h1> Certificate of Residency Request</h1>
        </div>
    </div>

    <hr>
    <br><br>

    <div class="row">
        <div class="col">
            <form method="POST">
                <div class="input-icons">
                    <i class="fa fa-search icon"></i>
                    <input type="search" class="form-control" name="keyword" value="" required=""
                        style="border-radius: 30px;" />
                </div>
                <button class="btn btn-success" name="search_certofres"
                    style="width: 90px; font-size: 17px; border-radius:30px; margin-left:41.5%;">
                    Search
                </button>
                <a href="admn_certofres.php" class="btn btn-info"
                    style="width: 90px; font-size: 17px; border-radius:30px;">Reload</a>
            </form>
            <br>
        </div>
    </div>

    <br>

    <div class="row">
        <div class="col-md-12">
            <?php
            include('admn_table_certofres_search.php');
            ?>
        </div>
    </div>

    <!-- /.container-fluid -->

</div>
<!-- End of Main Content -->

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.0.0/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-modal/2.2.6/js/bootstrap-modalmanager.min.js"
    integrity="sha512-/HL24m2nmyI2+ccX+dSHphAHqLw60Oj5sK8jf59VWtFWZi9vx7jzoxbZmcBeeTeCUc7z1mTs3LfyXGuBU32t+w=="
    crossorigin="anonymous"></script>
<!-- responsive tags for screen compatibility -->
<meta name="viewport" content="width=device-width, initial-scale=1 shrink-to-fit=no">
<!-- custom css -->
<link href="customcss/regiformstyle.css" rel="stylesheet" type="text/css">
<!-- bootstrap css -->
<link href="bootstrap/css/bootstrap.css" rel="stylesheet" type="text/css">
<!-- fontawesome icons -->
<script src="https://kit.fontawesome.com/67a9b7069e.js" crossorigin="anonymous"></script>
<script src="bootstrap/js/bootstrap.bundle.js" type="text/javascript"> </script>

<script>
$(document).ready(function() {
    // Handle notification button clicks
    $('.notify-btn').on('click', function() {
        const button = $(this);
        const serviceType = button.data('service-type');
        const residentId = button.data('resident-id');
        const certificateId = button.data('certificate-id');

        // Disable button to prevent double-clicking
        button.prop('disabled', true).text('Sending...');

        // Send notification request
        $.ajax({
            url: 'notify_resident.php',
            type: 'POST',
            data: {
                service_type: serviceType,
                id_resident: residentId,
                certificate_id: certificateId
            },
            dataType: 'json',
            success: function(response) {
                if (response.success) {
                    button.removeClass('btn-info').addClass('btn-success').text('Notified');
                    alert('Notification sent successfully!\nEmail: ' + (response
                        .email_sent ? 'Yes' : 'No') + '\nSMS: ' + (response
                        .sms_sent ? 'Yes' : 'No'));
                } else {
                    button.prop('disabled', false).text('Notify');
                    alert('Error sending notification: ' + response.message);
                }
            },
            error: function() {
                button.prop('disabled', false).text('Notify');
                alert('Error sending notification. Please try again.');
            }
        });
    });
});
</script>

<?php
include('dashboard_sidebar_end.php');
?>