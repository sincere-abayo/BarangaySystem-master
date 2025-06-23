<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
require('classes/Authentication.php');
require('classes/Certificate.php');
$auth = new Authentication();
$certificate = new Certificate();
$userdetails = $auth->get_userdata();
$certificate->create_certofres();
$requests = $certificate->view_certofres_by_resident($userdetails['id_resident']);
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Certificate of Residency Form</title>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.0.0/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-modal/2.2.6/js/bootstrap-modalmanager.min.js"
    integrity="sha512-/HL24m2nmyI2+ccX+dSHphAHqLw60Oj5sK8jf59VWtFWZi9vx7jzoxbZmcBeeTeCUc7z1mTs3LfyXGuBU32t+w=="
    crossorigin="anonymous"></script>
  <!-- responsive tags for screen compatibility -->
  <meta name="viewport" content="width=device-width, initial-scale=1"><!-- bootstrap css -->
  <link href="bootstrap/css/bootstrap.css" rel="stylesheet" type="text/css">
  <!-- fontawesome icons -->
  <script src="https://kit.fontawesome.com/67a9b7069e.js" crossorigin="anonymous"></script>
</head>

<body>
  <div class="container mt-5">
    <div class="card shadow-lg border-0">
      <div class="card-header bg-primary text-white">
        <h4 class="mb-0">Request Certificate of Residency</h4>
      </div>
      <div class="card-body">
        <form method="post" class="was-validated">
          <input type="hidden" name="id_resident" value="<?= htmlspecialchars($userdetails['id_resident']) ?>">
          <div class="row">
            <div class="col-md-4">
              <div class="form-group">
                <label>Last Name:</label>
                <input name="lname" type="text" class="form-control"
                  value="<?= htmlspecialchars($userdetails['surname'] ?? '') ?>" required>
              </div>
            </div>
            <div class="col-md-4">
              <div class="form-group">
                <label>First Name:</label>
                <input name="fname" type="text" class="form-control"
                  value="<?= htmlspecialchars($userdetails['firstname'] ?? '') ?>" required>
              </div>
            </div>
            <div class="col-md-4">
              <div class="form-group">
                <label>Middle Name:</label>
                <input name="mi" type="text" class="form-control"
                  value="<?= htmlspecialchars($userdetails['mname'] ?? '') ?>" required>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-md-3">
              <div class="form-group">
                <label>Age:</label>
                <input name="age" type="number" class="form-control"
                  value="<?= htmlspecialchars($userdetails['age'] ?? '') ?>" required>
              </div>
            </div>
            <div class="col-md-3">
              <div class="form-group">
                <label>Nationality:</label>
                <input name="nationality" type="text" class="form-control"
                  value="<?= htmlspecialchars($userdetails['nationality'] ?? '') ?>" required>
              </div>
            </div>
            <div class="col-md-2">
              <div class="form-group">
                <label>House No:</label>
                <input name="houseno" type="text" class="form-control"
                  value="<?= htmlspecialchars($userdetails['houseno'] ?? '') ?>" required>
              </div>
            </div>
            <div class="col-md-2">
              <div class="form-group">
                <label>Street:</label>
                <input name="street" type="text" class="form-control"
                  value="<?= htmlspecialchars($userdetails['street'] ?? '') ?>" required>
              </div>
            </div>
            <div class="col-md-2">
              <div class="form-group">
                <label>Barangay:</label>
                <input name="brgy" type="text" class="form-control"
                  value="<?= htmlspecialchars($userdetails['brgy'] ?? '') ?>" required>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-md-6">
              <div class="form-group">
                <label>Municipality:</label>
                <input name="municipal" type="text" class="form-control"
                  value="<?= htmlspecialchars($userdetails['municipal'] ?? '') ?>" required>
              </div>
            </div>
            <div class="col-md-3">
              <div class="form-group">
                <label>Date:</label>
                <input name="date" type="date" class="form-control" value="<?= date('Y-m-d') ?>" required>
              </div>
            </div>
            <div class="col-md-3">
              <div class="form-group">
                <label>Purpose:</label>
                <input name="purpose" type="text" class="form-control" placeholder="Enter Purpose" required>
              </div>
            </div>
          </div>
          <div class="text-right">
            <button name="create_certofres" type="submit" class="btn btn-primary">Submit Request</button>
          </div>
        </form>
      </div>
    </div>

    <!-- Table of submitted requests -->
    <?php if ($requests && count($requests) > 0): ?>
      <div class="card shadow-lg border-0 mt-5">
        <div class="card-header bg-success text-white">
          <h4 class="mb-0">Your Certificate of Residency Requests</h4>
        </div>
        <div class="card-body p-0">
          <div class="table-responsive">
            <table class="table table-hover mb-0">
              <thead class="thead-dark">
                <tr>
                  <th>Purpose</th>
                  <th>Date</th>
                  <th>Address</th>
                </tr>
              </thead>
              <tbody>
                <?php foreach ($requests as $req): ?>
                  <tr>
                    <td><?= htmlspecialchars($req['purpose']) ?></td>
                    <td><?= htmlspecialchars($req['date']) ?></td>
                    <td>
                      <?= htmlspecialchars($req['houseno']) ?>,
                      <?= htmlspecialchars($req['street']) ?>,
                      <?= htmlspecialchars($req['brgy']) ?>,
                      <?= htmlspecialchars($req['municipal']) ?>
                    </td>
                  </tr>
                <?php endforeach; ?>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    <?php else: ?>
      <div class="alert alert-info text-center mt-5" role="alert">
        <i class="fas fa-info-circle"></i> You have not submitted any Certificate of Residency requests yet.
      </div>
    <?php endif; ?>
  </div>
</body>

</html>