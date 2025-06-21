<?php

require_once 'Database.php';

class Resident extends Database
{
    public function create_resident()
    {
        if (isset($_POST['add_resident'])) {
            // All the POST data from the form
            $photo = file_get_contents(addslashes($_FILES['res_photo']['tmp_name']));
            $lname = $_POST['lname'];
            $fname = $_POST['fname'];
            // ... all other fields from resident registration form
            $email = $_POST['email'];
            $password = $_POST['password'];
            $role = 'resident';

            $connection = $this->openConn();
            // check if email exists
            $stmt = $connection->prepare("SELECT * FROM tbl_resident WHERE email = ?");
            $stmt->execute([$email]);
            if ($stmt->rowCount() > 0) {
                echo '<script>alert("Email already exists!");</script>';
                return;
            }

            // Insert into tbl_resident
            $stmt = $connection->prepare("INSERT INTO tbl_resident (photo, lname, fname, ..., email, password, role) VALUES (?, ?, ?, ..., ?, ?, ?)");
            // bind parameters and execute
            echo '<script>alert("Resident added successfully!");</script>';
        }
    }

    public function get_single_resident($id_resident)
    {
        $connection = $this->openConn();
        $stmt = $connection->prepare("SELECT * FROM tbl_resident WHERE id_resident = ?");
        $stmt->execute([$id_resident]);
        $resident = $stmt->fetch();
        return $resident;
    }

    public function view_residents()
    {
        $connection = $this->openConn();
        $stmt = $connection->prepare("SELECT * FROM tbl_resident");
        $stmt->execute();
        $residents = $stmt->fetchAll();
        return $residents;
    }

    public function update_resident()
    {
        if (isset($_POST['update_resident'])) {
            $id_resident = $_GET['id_resident'];
            //... fields from update form

            $connection = $this->openConn();
            $stmt = $connection->prepare("UPDATE tbl_resident SET ... WHERE id_resident = ?");
            // bind and execute
            echo '<script>alert("Resident data updated successfully!");</script>';
        }
    }

    public function delete_resident()
    {
        if (isset($_POST['delete_resident'])) {
            $id_resident = $_POST['id_resident'];
            $connection = $this->openConn();
            $stmt = $connection->prepare("DELETE FROM tbl_resident WHERE id_resident = ?");
            $stmt->execute([$id_resident]);
            echo '<script>alert("Resident data has been removed!");</script>';
        }
    }

    public function resident_changepass()
    {
        if (isset($_POST['resident_changepass'])) {
            $id_resident = $_GET['id_resident'];
            $newpassword = $_POST['newpassword'];
            $checkpassword = $_POST['checkpassword'];

            if ($newpassword != $checkpassword) {
                echo "New Password and Verification Password does not Match";
            } else {
                $connection = $this->openConn();
                $stmt = $connection->prepare("UPDATE tbl_resident SET password = ? WHERE id_resident = ?");
                $stmt->execute([$newpassword, $id_resident]);

                echo "<script>alert('Password Updated');</script>";
            }
        }
    }
}