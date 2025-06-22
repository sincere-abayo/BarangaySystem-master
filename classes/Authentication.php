<?php
require_once 'Database.php';

class Authentication extends Database
{
    public function login()
    {
        if (isset($_POST['login'])) {

            $email = $_POST['email'];
            $password = ($_POST['password']);

            $connection = $this->openConn();

            //unang i c capture admin
            $stmt = $connection->prepare("SELECT * FROM tbl_admin WHERE email = ? AND password = ?");
            $stmt->Execute([$email, $password]);
            $user = $stmt->fetch();


            //statement na mag ch check kung admin yung role
            if ($user && $user['role'] == 'administrator') {
                $this->set_userdata($user);
                header('Location: admn_dashboard.php');
                exit();
            }

            //kapag hindi admin ang role ng nag enter next na i c capture user login
            $stmt = $connection->prepare("SELECT * FROM tbl_user WHERE email = ? AND password = ?");
            $stmt->Execute([$email, $password]);
            $user = $stmt->fetch();

            //statement na mag ch check kung user yung role
            if ($user && $user['role'] == 'user') {
                $this->set_userdata($user);
                header('Location: staff_dashboard.php');
                exit();
            }

            $stmt = $connection->prepare("SELECT * FROM tbl_resident WHERE email = ? AND password = ?");
            $stmt->Execute([$email, $password]);
            $user = $stmt->fetch();

            if ($user && $user['role'] == 'resident') {
                $this->set_userdata($user);
                header('Location: resident_homepage.php');
                exit();
            }

            $message = "Invalid Email or Password";
            echo "<script type='text/javascript'>alert('$message');</script>";
        }
    }

    public function logout()
    {
        if (!isset($_SESSION)) {
            session_start();
        }
        $_SESSION['userdata'] = null;
        unset($_SESSION['userdata']);

    }

    public function get_userdata()
    {

        if (!isset($_SESSION)) {
            session_start();
        }

        if (isset($_SESSION['userdata'])) {
            return $_SESSION['userdata'];
        }

        return null;
    }

    public function set_userdata($array)
    {

        if (!isset($_SESSION)) {
            session_start();
        }

        $userdata = [
            "id_admin" => null,
            "id_resident" => null,
            "id_user" => null,
            "emailadd" => null,
            "password" => null,
            "surname" => null,
            "firstname" => null,
            "mname" => null,
            "age" => null,
            "sex" => null,
            "status" => null,
            "address" => null,
            "contact" => null,
            "bdate" => null,
            "bplace" => null,
            "nationality" => null,
            "family_role" => null,
            "role" => null,
            "houseno" => null,
            "street" => null,
            "brgy" => null,
            "municipal" => null
        ];

        foreach ($userdata as $key => $value) {
            if (isset($array[$key])) {
                $userdata[$key] = $array[$key];
            }
        }

        // Specific id population
        if (isset($array['id_admin']))
            $userdata['id_admin'] = $array['id_admin'];
        if (isset($array['id_resident']))
            $userdata['id_resident'] = $array['id_resident'];
        if (isset($array['id_user']))
            $userdata['id_user'] = $array['id_user'];
        if (isset($array['email']))
            $userdata['emailadd'] = $array['email'];


        $_SESSION['userdata'] = $userdata;
        return $_SESSION['userdata'];
    }

    public function validate_admin()
    {
        if (!isset($_SESSION)) {
            session_start();
        }
        if (!isset($_SESSION['userdata']) || $_SESSION['userdata']['role'] != 'administrator') {
            header('Location: index.php');
            exit();
        }
    }

    public function validate_staff()
    {
        if (!isset($_SESSION)) {
            session_start();
        }
        if (!isset($_SESSION['userdata']) || $_SESSION['userdata']['role'] != 'user') {
            header('Location: index.php');
            exit();
        }
    }

    public function get_admin_details($id_admin)
    {
        $connection = $this->openConn();
        $stmt = $connection->prepare("SELECT * FROM tbl_admin WHERE id_admin = ?");
        $stmt->execute([$id_admin]);
        $admin = $stmt->fetch();
        return $admin ? $admin : false;
    }

    public function update_admin_profile()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        $id_admin = $_SESSION['userdata']['id_admin'];
        $fname = $_POST['fname'];
        $mi = $_POST['mi'];
        $lname = $_POST['lname'];
        $email = $_POST['email'];

        $connection = $this->openConn();
        $stmt = $connection->prepare("UPDATE tbl_admin SET fname = ?, mi = ?, lname = ?, email = ? WHERE id_admin = ?");

        if ($stmt->execute([$fname, $mi, $lname, $email, $id_admin])) {
            $_SESSION['profile_update_success'] = "Profile updated successfully.";

            $updated_user_data = $this->get_admin_details($id_admin);
            $this->set_userdata($updated_user_data);

        } else {
            $_SESSION['profile_update_error'] = "Failed to update profile.";
        }
        header("Location: admin_profile.php");
        exit();
    }

    public function update_admin_password()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        $id_admin = $_SESSION['userdata']['id_admin'];
        $current_password = $_POST['current_password'];
        $new_password = $_POST['new_password'];
        $confirm_password = $_POST['confirm_password'];

        $connection = $this->openConn();
        $stmt = $connection->prepare("SELECT password FROM tbl_admin WHERE id_admin = ?");
        $stmt->execute([$id_admin]);
        $user = $stmt->fetch();

        if ($user && $current_password == $user['password']) {
            if ($new_password === $confirm_password) {
                $stmt_update = $connection->prepare("UPDATE tbl_admin SET password = ? WHERE id_admin = ?");
                if ($stmt_update->execute([$new_password, $id_admin])) {
                    $_SESSION['password_change_success'] = "Password changed successfully.";
                } else {
                    $_SESSION['password_change_error'] = "Failed to change password.";
                }
            } else {
                $_SESSION['password_change_error'] = "New passwords do not match.";
            }
        } else {
            $_SESSION['password_change_error'] = "Incorrect current password.";
        }
        header("Location: admin_profile.php");
        exit();
    }
}