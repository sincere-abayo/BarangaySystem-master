<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

require('classes/Authentication.php');
require('classes/Announcement.php');

$auth = new Authentication();
$announcement = new Announcement();
$auth->validate_staff();
$userdetails = $auth->get_userdata();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['create_announce'])) {
        $announcement->create_announcement();
    }
    if (isset($_POST['delete_announcement'])) {
        $announcement->delete_announcement();
    }
}

$announcements = $announcement->view_announcement();
$latest_announcement = $announcement->get_latest_announcement();
$dt = new DateTime("now", new DateTimeZone('Asia/Manila'));
$cdate = $dt->format('Y/m/d');
?>

<?php include('dashboard_sidebar_start_staff.php'); ?>

<div class="container-fluid">
    <h1 class="h3 mb-4 text-gray-800">Event Announcements</h1>

    <?php if (isset($_SESSION['announcement_success'])): ?>
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <?= $_SESSION['announcement_success']; ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        <?php unset($_SESSION['announcement_success']); ?>
    <?php endif; ?>
    <?php if (isset($_SESSION['announcement_error'])): ?>
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <?= $_SESSION['announcement_error']; ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        <?php unset($_SESSION['announcement_error']); ?>
    <?php endif; ?>

    <div class="row">
        <div class="col-lg-6">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Create New Announcement</h6>
                </div>
                <div class="card-body">
                    <form method="post">
                        <div class="mb-3">
                            <label for="event" class="form-label"><i class="fas fa-bullhorn"></i> Announcement
                                Message</label>
                            <textarea name="event" id="event" class="form-control" rows="6"
                                placeholder="Enter Message Here" required></textarea>
                        </div>
                        <input type="hidden" name="start_date" value="<?= $cdate ?>">
                        <input name="addedby" type="hidden"
                            value="<?= htmlspecialchars($userdetails['surname'] . ', ' . $userdetails['firstname']) ?>">
                        <button type="submit" name="create_announce" class="btn btn-primary">Submit
                            Announcement</button>
                    </form>
                </div>
            </div>

            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Current Announcement</h6>
                </div>
                <div class="card-body">
                    <?php if ($latest_announcement): ?>
                        <div class="alert alert-info" role="alert">
                            <h4 class="alert-heading">ANNOUNCEMENT!</h4>
                            <hr>
                            <p class="mb-0"><?= htmlspecialchars($latest_announcement['event']); ?></p>
                        </div>
                    <?php else: ?>
                        <p>No announcements found.</p>
                    <?php endif; ?>
                </div>
            </div>
        </div>

        <div class="col-lg-6">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Posted Announcements</h6>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th>Announcement</th>
                                    <th>Date Posted</th>
                                    <th>Added By</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if ($announcements): ?>
                                    <?php foreach ($announcements as $row): ?>
                                        <tr>
                                            <td><?= htmlspecialchars($row['event']); ?></td>
                                            <td><?= htmlspecialchars($row['start_date']); ?></td>
                                            <td><?= htmlspecialchars($row['addedby']); ?></td>
                                            <td>
                                                <form method="post"
                                                    onsubmit="return confirm('Are you sure you want to delete this announcement?');">
                                                    <input type="hidden" name="id_announcement"
                                                        value="<?= $row['id_announcement']; ?>">
                                                    <button class="btn btn-danger btn-sm" type="submit"
                                                        name="delete_announcement">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </form>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include('dashboard_sidebar_end.php'); ?>