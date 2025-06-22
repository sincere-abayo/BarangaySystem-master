<?php
error_reporting(E_ALL ^ E_WARNING);
require('classes/Admin.php');
require('classes/Authentication.php');
$admin = new Admin();
$auth = new Authentication();
$admin->admin_changepass();
$userdetails = $auth->get_userdata();

$id_admin = $_GET['id_admin'];
$admin_data = $admin->get_single_admin($id_admin);

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <link href="css/sb-admin-2.min.css" rel="stylesheet">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>

    <div class="container-fluid">
        <div class="row">
            <div class="col-md-10">
                <form method="post">
                    <label> Old Password </label>
                    <input type="password" name="oldpassword" class="form-control"
                        value="<?= $admin_data['password']; ?>" readonly>

                    <label> New Password </label>
                    <input type="text" name="newpassword">

                    <label> Verify Password </label>
                    <input type="text" name="checkpassword">

                    <button class="btn btn-dark" type="submit" name="admin_changepass"> Change Password </button>
                </form>
            </div>
        </div>
    </div>




</body>

</html>