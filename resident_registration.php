<?php
require('classes/Authentication.php');
require('classes/resident.class.php');
$auth = new Authentication();
$resident = new Resident();
$resident->create_resident();
//$data = $bms->get_userdata();


?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Resident Registration</title>
    <link href="bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://kit.fontawesome.com/67a9b7069e.js" crossorigin="anonymous"></script>
    <style>
    body {
        background-color: #f8f9fa;
    }

    .registration-container {
        max-width: 900px;
        margin: 2rem auto;
        padding: 2rem;
        background-color: #fff;
        border-radius: 0.5rem;
        box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
    }

    .navbar-brand {
        font-weight: 600;
    }

    .form-section-title {
        margin-bottom: 1.5rem;
        color: #007bff;
        border-bottom: 2px solid #007bff;
        padding-bottom: 0.5rem;
    }

    .btn-custom {
        margin-top: 1rem;
    }
    </style>
</head>

<body>
    <nav class="navbar navbar-dark bg-primary sticky-top">
        <div class="container-fluid">
            <a class="navbar-brand">Nyarutarama Information & E-Services Management System</a>
        </div>
    </nav>

    <div class="container">
        <div class="registration-container">
            <h1 class="text-center mb-4">Resident Registration Form</h1>
            <form method="post" id="registrationForm" class="needs-validation" novalidate>

                <!-- Personal Information -->
                <h5 class="form-section-title">Personal Information</h5>
                <div class="row">
                    <div class="col-md-4 mb-3">
                        <label for="fname" class="form-label">First Name</label>
                        <input type="text" class="form-control" id="fname" name="fname" required>
                        <div class="invalid-feedback">First name is required.</div>
                    </div>
                    <div class="col-md-4 mb-3">
                        <label for="mi" class="form-label">Middle Name</label>
                        <input type="text" class="form-control" id="mi" name="mi" required>
                        <div class="invalid-feedback">Middle name is required.</div>
                    </div>
                    <div class="col-md-4 mb-3">
                        <label for="lname" class="form-label">Last Name</label>
                        <input type="text" class="form-control" id="lname" name="lname" required>
                        <div class="invalid-feedback">Last name is required.</div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-4 mb-3">
                        <label for="bdate" class="form-label">Birth Date</label>
                        <input type="date" class="form-control" id="bdate" name="bdate" required>
                        <div class="invalid-feedback">Birth date is required.</div>
                    </div>
                    <div class="col-md-2 mb-3">
                        <label for="age" class="form-label">Age</label>
                        <input type="number" class="form-control" id="age" name="age" readonly required>
                        <div class="invalid-feedback">Age is required.</div>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="bplace" class="form-label">Birth Place</label>
                        <input type="text" class="form-control" id="bplace" name="bplace" required>
                        <div class="invalid-feedback">Birth place is required.</div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-4 mb-3">
                        <label for="sex" class="form-label">Sex</label>
                        <select class="form-select" id="sex" name="sex" required>
                            <option selected disabled value="">Choose...</option>
                            <option>Male</option>
                            <option>Female</option>
                        </select>
                        <div class="invalid-feedback">Please select a sex.</div>
                    </div>
                    <div class="col-md-4 mb-3">
                        <label for="status" class="form-label">Civil Status</label>
                        <select class="form-select" id="status" name="status" required>
                            <option selected disabled value="">Choose...</option>
                            <option>Single</option>
                            <option>Married</option>
                            <option>Widowed</option>
                            <option>Divorced</option>
                        </select>
                        <div class="invalid-feedback">Please select a status.</div>
                    </div>
                    <div class="col-md-4 mb-3">
                        <label for="nationality" class="form-label">Nationality</label>
                        <input type="text" class="form-control" id="nationality" name="nationality" required>
                        <div class="invalid-feedback">Nationality is required.</div>
                    </div>
                </div>

                <!-- Address Information -->
                <h5 class="form-section-title mt-4">Address Information</h5>
                <div class="row">
                    <div class="col-md-3 mb-3">
                        <label for="houseno" class="form-label">House No.</label>
                        <input type="text" class="form-control" id="houseno" name="houseno" required>
                        <div class="invalid-feedback">House no. is required.</div>
                    </div>
                    <div class="col-md-5 mb-3">
                        <label for="street" class="form-label">Street</label>
                        <input type="text" class="form-control" id="street" name="street" required>
                        <div class="invalid-feedback">Street is required.</div>
                    </div>
                    <div class="col-md-4 mb-3">
                        <label for="brgy" class="form-label">Cell/Village</label>
                        <input type="text" class="form-control" id="brgy" name="brgy" required>
                        <div class="invalid-feedback">Cell/Village is required.</div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="municipal" class="form-label">Municipality</label>
                        <input type="text" class="form-control" id="municipal" name="municipal" required>
                        <div class="invalid-feedback">Municipality is required.</div>
                    </div>
                </div>

                <!-- Account Information -->
                <h5 class="form-section-title mt-4">Account Information</h5>
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" class="form-control" id="email" name="email" required>
                        <div class="invalid-feedback">Please enter a valid email.</div>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="contact" class="form-label">Contact Number</label>
                        <input type="tel" class="form-control" id="contact" name="contact" pattern="[0-9]{10,12}"
                            required>
                        <div class="invalid-feedback">Please enter a valid contact number (10-12 digits).</div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="password" class="form-label">Password</label>
                        <input type="password" class="form-control" id="password" name="password" required>
                        <div class="invalid-feedback">Password is required.</div>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="confirm_password" class="form-label">Confirm Password</label>
                        <input type="password" class="form-control" id="confirm_password" name="confirm_password"
                            required>
                        <div class="invalid-feedback">Passwords do not match.</div>
                    </div>
                </div>

                <!-- Other Information -->
                <h5 class="form-section-title mt-4">Other Information</h5>
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="voter" class="form-label">Are you a registered voter?</label>
                        <select class="form-select" id="voter" name="voter" required>
                            <option selected disabled value="">Choose...</option>
                            <option>Yes</option>
                            <option>No</option>
                        </select>
                        <div class="invalid-feedback">Please select an option.</div>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="family_role" class="form-label">Are you the head of the family?</label>
                        <select class="form-select" id="family_role" name="family_role" required>
                            <option selected disabled value="">Choose...</option>
                            <option>Yes</option>
                            <option>No</option>
                        </select>
                        <div class="invalid-feedback">Please select an option.</div>
                    </div>
                </div>

                <input type="hidden" name="role" value="resident">

                <hr class="my-4">

                <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                    <a class="btn btn-secondary btn-lg" href="index.php">Back to Login</a>
                    <button class="btn btn-primary btn-lg" type="submit" name="add_resident">Register</button>
                </div>
            </form>
        </div>
    </div>

    <footer class="bg-primary text-white text-center p-3 mt-5">
        <p class="mb-0">&copy;
            <script>
            document.write(new Date().getFullYear())
            </script> BI & ESMS | For Educational Purposes Only
        </p>
    </footer>

    <script src="bootstrap/js/bootstrap.bundle.min.js"></script>
    <script>
    // Age calculation
    document.getElementById('bdate').addEventListener('change', function() {
        const bdate = new Date(this.value);
        if (!isNaN(bdate)) {
            const ageDifMs = Date.now() - bdate.getTime();
            const ageDate = new Date(ageDifMs);
            const age = Math.abs(ageDate.getUTCFullYear() - 1970);
            document.getElementById('age').value = age;
        }
    });

    // Form validation
    (function() {
        'use strict'
        var forms = document.querySelectorAll('.needs-validation');
        var password = document.getElementById('password');
        var confirm_password = document.getElementById('confirm_password');

        function validatePasswords() {
            if (password.value !== confirm_password.value) {
                confirm_password.setCustomValidity("Passwords do not match.");
                confirm_password.reportValidity();
            } else {
                confirm_password.setCustomValidity("");
                confirm_password.reportValidity();
            }
        }
        password.addEventListener('change', validatePasswords);
        confirm_password.addEventListener('keyup', validatePasswords);

        Array.prototype.slice.call(forms)
            .forEach(function(form) {
                form.addEventListener('submit', function(event) {
                    validatePasswords();
                    if (!form.checkValidity()) {
                        event.preventDefault();
                        event.stopPropagation();
                    }
                    form.classList.add('was-validated');
                }, false);
            });
    })();
    </script>
</body>

</html>