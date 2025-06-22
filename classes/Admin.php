<?php

require_once 'Database.php';

class Admin extends Database
{
    public function create_admin()
    {
        if (isset($_POST['add_admin'])) {
            $email = $_POST['email'];
            $password = md5($_POST['password']);
            $lname = $_POST['lname'];
            $fname = $_POST['fname'];
            $mi = $_POST['mi'];
            $role = $_POST['role'];

            $connection = $this->openConn();
            $stmt = $connection->prepare("SELECT * FROM tbl_admin WHERE email = ?");
            $stmt->Execute([$email]);
            if ($stmt->rowCount() == 0) {
                $stmt = $connection->prepare("INSERT INTO tbl_admin (`email`,`password`,`lname`,`fname`, `mi`, `role` ) VALUES (?, ?, ?, ?, ?, ?)");
                $stmt->Execute([$email, $password, $lname, $fname, $mi, $role]);
                echo "<script>alert('Administrator account added.');</script>";
            } else {
                echo "<script>alert('Account already exists');</script>";
            }
        }
    }

    public function get_single_admin($id_admin)
    {
        $connection = $this->openConn();
        $stmt = $connection->prepare("SELECT * FROM tbl_admin where id_admin = ?");
        $stmt->execute([$id_admin]);
        $admin = $stmt->fetch();
        return $admin;
    }

    public function admin_changepass()
    {
        if (isset($_POST['admin_changepass'])) {
            $id_admin = $_GET['id_admin'];
            $newpassword = $_POST['newpassword'];
            $checkpassword = $_POST['checkpassword'];

            if ($newpassword != $checkpassword) {
                echo "New Password and Verification Password does not Match";
            } else {
                $connection = $this->openConn();
                $stmt = $connection->prepare("UPDATE tbl_admin SET password = ? WHERE id_admin = ?");
                $stmt->execute([md5($newpassword), $id_admin]);

                echo "<script>alert('Password Updated');</script>";
            }
        }
    }
}