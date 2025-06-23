<?php

error_reporting(E_ALL ^ E_WARNING);
ini_set('display_errors', 0);
require('classes/Authentication.php');
require('classes/resident.class.php');

$auth = new Authentication();
$resident = new Resident();

$auth->validate_admin();
$userdetails = $auth->get_userdata();

$view = $resident->view_resident();
$resident->create_resident();
$resident->update_resident();
$resident->delete_resident();

$rescount = $resident->count_resident();
$rescountm = $resident->count_male_resident();
$rescountf = $resident->count_female_resident();
$rescountfh = $resident->count_head_resident();
$rescountfm = $resident->count_member_resident();

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
            <h1> Nyarutarama Resident Table</h1>
        </div>
    </div>

    <hr>
    <br>
    <br>

    <div class="row">
        <div class="col">
            <form method="POST" action="">
                <div class="input-icons">
                    <i class="fa fa-search icon"></i>
                    <input type="search" class="form-control" name="keyword" style="border-radius: 30px;" value=""
                        required="" />
                </div>
                <button class="btn btn-success" name="search_totalres"
                    style="width: 90px; font-size: 18px; border-radius:30px; margin-left:41.5%;">Search</button>
                <a href="admn_table_totalres.php" class="btn btn-info"
                    style="width: 90px; font-size: 18px; border-radius:30px;">Reload</a>
            </form>

            <br>
            <br>

            <?php
            include('admn_table_totalres_search.php');
            ?>
        </div>
    </div>

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

<?php
include('dashboard_sidebar_end.php');
?>