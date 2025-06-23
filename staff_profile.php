<?php
require('classes/Authentication.php');
require('classes/Staff.php');
include('dashboard_sidebar_start_staff.php');
$auth = new Authentication();
$staff_obj = new Staff();
$userdetails = $auth->get_userdata();
$id_user = $userdetails['id_user'];
$staff = $staff_obj->get_single_staff($id_user);

// Handle profile update
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update_profile'])) {
    $staff_obj->update_staff_profile($id_user);
    $staff = $staff_obj->get_single_staff($id_user); // Refresh data
    echo '<div class="alert alert-success text-center">Profile updated successfully!</div>';
}
// Handle password change
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['change_password'])) {
    // Use update_admin_password for password change
    $_SESSION['id_user'] = $id_user;
    $staff_obj->update_admin_password();
    echo '<div class="alert alert-info text-center">Password change requested.</div>';
}
?>
<div class="container mt-4">
    <h2 class="mb-4">My Profile</h2>
    <form method="POST" class="card p-4 mb-4 shadow">
        <div class="form-row">
            <div class="form-group col-md-6">
                <label>Email</label>
                <input type="email" class="form-control" name="email" value="<?= htmlspecialchars($staff['email']) ?>"
                    required>
            </div>
            <div class="form-group col-md-6">
                <label>Position</label>
                <input type="text" class="form-control" name="position"
                    value="<?= htmlspecialchars($staff['position']) ?>" required>
            </div>
        </div>
        <div class="form-row">
            <div class="form-group col-md-4">
                <label>Last Name</label>
                <input type="text" class="form-control" name="lname" value="<?= htmlspecialchars($staff['lname']) ?>"
                    required>
            </div>
            <div class="form-group col-md-4">
                <label>First Name</label>
                <input type="text" class="form-control" name="fname" value="<?= htmlspecialchars($staff['fname']) ?>"
                    required>
            </div>
            <div class="form-group col-md-4">
                <label>Middle Name</label>
                <input type="text" class="form-control" name="mi" value="<?= htmlspecialchars($staff['mi']) ?>">
            </div>
        </div>
        <div class="form-row">
            <div class="form-group col-md-2">
                <label>Age</label>
                <input type="number" class="form-control" name="age" value="<?= htmlspecialchars($staff['age']) ?>"
                    required>
            </div>
            <div class="form-group col-md-2">
                <label>Sex</label>
                <select class="form-control" name="sex" required>
                    <option value="Male" <?= $staff['sex'] == 'Male' ? 'selected' : '' ?>>Male</option>
                    <option value="Female" <?= $staff['sex'] == 'Female' ? 'selected' : '' ?>>Female</option>
                </select>
            </div>
            <div class="form-group col-md-4">
                <label>Contact</label>
                <input type="text" class="form-control" name="contact"
                    value="<?= htmlspecialchars($staff['contact']) ?>">
            </div>
            <div class="form-group col-md-4">
                <label>Address</label>
                <input type="text" class="form-control" name="address"
                    value="<?= htmlspecialchars($staff['address']) ?>">
            </div>
        </div>
        <button type="submit" name="update_profile" class="btn btn-success">Update Profile</button>
    </form>
    <div class="card p-4 shadow">
        <h5>Change Password</h5>
        <form method="POST">
            <div class="form-row">
                <div class="form-group col-md-4">
                    <label>Current Password</label>
                    <input type="password" class="form-control" name="current_password" required>
                </div>
                <div class="form-group col-md-4">
                    <label>New Password</label>
                    <input type="password" class="form-control" name="new_password" required>
                </div>
                <div class="form-group col-md-4">
                    <label>Confirm New Password</label>
                    <input type="password" class="form-control" name="confirm_password" required>
                </div>
            </div>
            <button type="submit" name="change_password" class="btn btn-primary">Change Password</button>
        </form>
    </div>
</div>
<?php include('dashboard_sidebar_end.php'); ?>