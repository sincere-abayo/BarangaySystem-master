<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

require('classes/Authentication.php');
require('classes/Staff.php');

$auth = new Authentication();
$staff = new Staff();
$userdetails = $auth->get_userdata();
$auth->validate_staff(); // Ensures only logged-in staff can access

$view = false;
if (isset($_GET['id_user'])) {
    $id_user = $_GET['id_user'];
    $view = $staff->get_single_staff($id_user);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update_staff'])) {
    if ($id_user) {
        $staff->update_staff($id_user);
    }
}
?>

<?php include('dashboard_sidebar_start_staff.php'); ?>

<!-- Begin Page Content -->
<div class="container-fluid">
    <h1 class="h3 mb-4 text-gray-800">Staff Profile</h1>

    <?php if (!$view): ?>
        <div class="alert alert-danger">Error: Staff member not found or ID is missing.</div>
    <?php else: ?>
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Staff Credentials</h6>
            </div>
            <div class="card-body">
                <?php if (isset($_SESSION['staff_update_success'])): ?>
                    <div class="alert alert-success">
                        <?= $_SESSION['staff_update_success'];
                        unset($_SESSION['staff_update_success']); ?>
                    </div>
                <?php endif; ?>
                <?php if (isset($_SESSION['staff_update_error'])): ?>
                    <div class="alert alert-danger">
                        <?= $_SESSION['staff_update_error'];
                        unset($_SESSION['staff_update_error']); ?>
                    </div>
                <?php endif; ?>

                <form method="post">
                    <?php
                    // Split the address for form display
                    $address_parts = explode(', ', $view['address']);
                    $houseno = $address_parts[0] ?? '';
                    $street = $address_parts[1] ?? '';
                    $brgy = $address_parts[2] ?? '';
                    ?>
                    <div class="row mb-3">
                        <div class="col-md-4">
                            <label class="form-label">Last Name</label>
                            <input type="text" class="form-control" name="lname"
                                value="<?= htmlspecialchars($view['lname']); ?>">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">First Name</label>
                            <input type="text" class="form-control" name="fname"
                                value="<?= htmlspecialchars($view['fname']); ?>">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Middle Initial</label>
                            <input type="text" class="form-control" name="mi" value="<?= htmlspecialchars($view['mi']); ?>">
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-4">
                            <label class="form-label">House No:</label>
                            <input class="form-control" type="text" name="houseno"
                                value="<?= htmlspecialchars($houseno); ?>">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Street:</label>
                            <input class="form-control" type="text" name="street" value="<?= htmlspecialchars($street); ?>">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Village:</label>
                            <input class="form-control" type="text" name="brgy" value="<?= htmlspecialchars($brgy); ?>">
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-4">
                            <label class="form-label">Email</label>
                            <input type="email" class="form-control" name="email"
                                value="<?= htmlspecialchars($view['email']); ?>">
                        </div>
                        <div class="col-md-3">
                            <label class="form-label">Contact Number</label>
                            <input type="tel" class="form-control" name="contact"
                                value="<?= htmlspecialchars($view['contact']); ?>">
                        </div>
                        <div class="col-md-3">
                            <label class="form-label">Position</label>
                            <input type="text" class="form-control" name="position"
                                value="<?= htmlspecialchars($view['position']); ?>">
                        </div>
                        <div class="col-md-2">
                            <label class="form-label">Age</label>
                            <input type="number" class="form-control" name="age"
                                value="<?= htmlspecialchars($view['age']); ?>">
                        </div>
                    </div>

                    <input type="hidden" name="role" value="user">
                    <input type="hidden" name="addedby"
                        value="<?= htmlspecialchars($userdetails['surname'] . ', ' . $userdetails['firstname']); ?>">

                    <hr class="my-4">

                    <button class="btn btn-primary" type="submit" name="update_staff">Update Profile</button>
                </form>
            </div>
        </div>
    <?php endif; ?>
</div>
<!-- /.container-fluid -->

<?php include('dashboard_sidebar_end.php'); ?>