<?php
require('classes/Authentication.php');

$auth = new Authentication();

// Check if the user is an admin
$auth->validate_admin();

// Get user data
$userdetails = $auth->get_userdata();
$admin_details = $auth->get_admin_details($userdetails['id_admin']);

// Handle profile update
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update_profile'])) {
    $auth->update_admin_profile();
}

// Handle password change
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['change_password'])) {
    $auth->update_admin_password();
}
?>

<?php include('dashboard_sidebar_start.php'); ?>

<div class="container-fluid">
    <h1 class="h3 mb-4 text-gray-800">Admin Profile</h1>
    <div class="row">
        <!-- Profile Information -->
        <div class="col-lg-6">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Profile Information</h6>
                </div>
                <div class="card-body">
                    <?php if (isset($_SESSION['profile_update_success'])): ?>
                        <div class="alert alert-success">
                            <?= $_SESSION['profile_update_success'];
                            unset($_SESSION['profile_update_success']); ?>
                        </div>
                    <?php endif; ?>
                    <?php if (isset($_SESSION['profile_update_error'])): ?>
                        <div class="alert alert-danger">
                            <?= $_SESSION['profile_update_error'];
                            unset($_SESSION['profile_update_error']); ?>
                        </div>
                    <?php endif; ?>

                    <form method="POST">
                        <div class="form-group">
                            <label>First Name</label>
                            <input type="text" name="fname" class="form-control"
                                value="<?= htmlspecialchars($admin_details['fname']) ?>" required>
                        </div>
                        <div class="form-group">
                            <label>Middle Name</label>
                            <input type="text" name="mi" class="form-control"
                                value="<?= htmlspecialchars($admin_details['mi']) ?>" required>
                        </div>
                        <div class="form-group">
                            <label>Last Name</label>
                            <input type="text" name="lname" class="form-control"
                                value="<?= htmlspecialchars($admin_details['lname']) ?>" required>
                        </div>
                        <div class="form-group">
                            <label>Email Address</label>
                            <input type="email" name="email" class="form-control"
                                value="<?= htmlspecialchars($admin_details['email']) ?>" required>
                        </div>
                        <button type="submit" name="update_profile" class="btn btn-primary">Update Profile</button>
                    </form>
                </div>
            </div>
        </div>

        <!-- Change Password -->
        <div class="col-lg-6">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Change Password</h6>
                </div>
                <div class="card-body">
                    <?php if (isset($_SESSION['password_change_success'])): ?>
                        <div class="alert alert-success">
                            <?= $_SESSION['password_change_success'];
                            unset($_SESSION['password_change_success']); ?>
                        </div>
                    <?php endif; ?>
                    <?php if (isset($_SESSION['password_change_error'])): ?>
                        <div class="alert alert-danger">
                            <?= $_SESSION['password_change_error'];
                            unset($_SESSION['password_change_error']); ?>
                        </div>
                    <?php endif; ?>

                    <form method="POST">
                        <div class="form-group">
                            <label>Current Password</label>
                            <input type="password" name="current_password" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label>New Password</label>
                            <input type="password" name="new_password" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label>Confirm New Password</label>
                            <input type="password" name="confirm_password" class="form-control" required>
                        </div>
                        <button type="submit" name="change_password" class="btn btn-primary">Change Password</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include('dashboard_sidebar_end.php'); ?>