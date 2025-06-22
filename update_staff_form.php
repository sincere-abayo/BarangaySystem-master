<?php
// error_reporting(E_ALL ^ E_WARNING);
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
// ini_set('display_errors', 0);
require('classes/Authentication.php');
require('classes/staff.class.php');

$auth = new Authentication();
$staff = new Staff();

$userdetails = $auth->get_userdata();
//$auth->validate_admin();
$view = $staff->view_staff();
$staff->create_staff();
$upstaff = $staff->update_staff();
$staff->delete_staff();
$staffcount = $staff->count_staff();
$id_user = $_GET['id_user'];
$staff_data = $staff->get_single_staff($id_user);
?>

<?php
include('dashboard_sidebar_start.php');
?>

<!-- Begin Page Content -->

<div class="container-fluid">

    <!-- Page Heading -->

    <h1 class="mb-4 text-center">Barangay Staff Data</h1>

    <hr>
    <br>

    <div class="row">
        <div class="col-md-2"> </div>
        <div class="col-md-8">
            <div class="card">
                <div class="card-header bg-primary text-white"> Update Barangay Staff Data </div>
                <div class="card-body">
                    <form method="post">
                        <div class="row">
                            <div class="col">
                                <label class="form-group"> Last Name:</label>
                                <input type="text" class="form-control" name="lname" placeholder="Enter Last Name"
                                    value="<?= $staff_data['lname']; ?>">
                            </div>
                            <div class="col">
                                <label class="form-group">First Name: </label>
                                <input type="text" class="form-control" name="fname" placeholder="Enter First Name"
                                    value="<?= $staff_data['fname']; ?>">
                            </div>
                            <div class="col">
                                <label class="form-group"> Middle Name: </label>
                                <input type="text" class="form-control" name="mi" placeholder="Enter Middle Name"
                                    value="<?= $staff_data['mi']; ?>">
                            </div>
                        </div>

                        <div class="row" style="margin-top: 1.1em;">
                            <div class="col">
                                <label class="form-group">Email: </label>
                                <input type="email" class="form-control" name="email" placeholder="Enter Email"
                                    value="<?= $staff_data['email']; ?>">
                            </div>
                            <div class="col">
                                <label class="form-group">Contact Number:</label>
                                <input type="tel" class="form-control" name="contact" placeholder="Enter Contact Number"
                                    value="<?= $staff_data['contact']; ?>">
                            </div>
                            <div class="col">
                                <label class="form-group">Position: </label>
                                <input type="text" class="form-control" name="position" placeholder="Enter Position"
                                    value="<?= $staff_data['position']; ?>">
                            </div>
                        </div>

                        <div class="row" style="margin-top: 1.1em;">
                            <div class="col">
                                <div class="form-group">
                                    <label>Address:</label>
                                    <input class="form-control" type="text" name="address" placeholder="Enter Address"
                                        value="<?= $staff_data['address']; ?>">
                                </div>
                            </div>
                        </div>

                        <div class="row" style="margin-top: .5em;">
                            <div class="col">
                                <div class="form-group">
                                    <label>Age: </label>
                                    <input type="number" class="form-control" name="age" placeholder="Enter Age"
                                        value="<?= $staff_data['age']; ?>">
                                </div>
                            </div>
                            <div class="col">
                                <div class="form-group">
                                    <label> Gender: </label>
                                    <input type="text" class="form-control" name="gender" placeholder="Enter Gender"
                                        value="<?= $staff_data['sex']; ?>" required>
                                </div>
                            </div>
                        </div>

                        <input type="hidden" class="form-control" name="role" value="user">
                        <input type="hidden" class="form-control" name="addedby"
                            value="<?= $userdetails['surname'] ?>, <?= $userdetails['firstname'] ?>">
                        <br>
                        <hr>
                        <a href="admn_staff_crud.php" class="btn btn-danger"
                            style="width: 120px; font-size: 18px; border-radius:30px; margin-left:35%;"> Back </a>
                        <button class="btn btn-primary" type="submit" name="update_staff"
                            style="width: 120px; font-size: 18px; border-radius:30px;">
                            Update
                        </button>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-md-2"> </div>
    </div>

    <br>
</div>
<!-- /.container-fluid -->

<!-- End of Main Content -->

<?php
include('dashboard_sidebar_end.php');
?>