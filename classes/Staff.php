<?php

require_once('Database.php');

class Staff extends Database
{

    //------------------------------------- CRUD FUNCTIONS FOR STAFF -----------------------------------------------

    public function create_staff()
    {
        if (isset($_POST['add_staff'])) {
            if (session_status() === PHP_SESSION_NONE) {
                session_start();
            }
            $email = $_POST['email'];
            $password = ($_POST['password']);
            $lname = $_POST['lname'];
            $fname = $_POST['fname'];
            $mi = $_POST['mi'];
            $age = $_POST['age'];
            $sex = $_POST['sex'];
            $address = $_POST['address'];
            $contact = $_POST['contact'];
            $position = $_POST['position'];
            $role = $_POST['role'];

            // Assuming addedby comes from the logged-in user's session
            $addedby = $_SESSION['fullname'];

            if ($this->check_staff_email($email) == 0) {
                $connection = $this->openConn();
                $stmt = $connection->prepare("INSERT INTO tbl_user (`email`,`password`,`lname`,`fname`,
                    `mi`, `age`, `sex`, `address`, `contact`, `position` , `role`, `addedby`) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");

                $stmt->Execute([
                    $email,
                    $password,
                    $lname,
                    $fname,
                    $mi,
                    $age,
                    $sex,
                    $address,
                    $contact,
                    $position,
                    $role,
                    $addedby
                ]);
                $_SESSION['staff_add_success'] = "New Staff Added";
                header('location: admn_staff_crud.php');
                exit();

            } else {
                $_SESSION['staff_add_error'] = "Email Account already exists";
                header('location: admn_staff_crud.php');
                exit();
            }
        }
    }


    public function view_staff()
    {
        $connection = $this->openConn();
        $stmt = $connection->prepare("SELECT * from tbl_user");
        $stmt->execute();
        $view = $stmt->fetchAll();
        return $view;
    }

    public function update_staff($id_user)
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        $lname = $_POST['lname'];
        $fname = $_POST['fname'];
        $mi = $_POST['mi'];
        $age = $_POST['age'];
        $email = $_POST['email'];
        $contact = $_POST['contact'];
        $position = $_POST['position'];
        // Concatenate address fields from the form
        $address = $_POST['houseno'] . ', ' . $_POST['street'] . ', ' . $_POST['brgy'];
        $role = $_POST['role'];
        $addedby = $_SESSION['userdata']['surname'] . ', ' . $_SESSION['userdata']['firstname'];

        $connection = $this->openConn();
        $stmt = $connection->prepare("UPDATE tbl_user SET 
                lname = ?, fname = ?, mi = ?, age = ?, email = ?, 
                contact = ?, position = ?, address = ?, `role` = ?, addedby = ? 
                WHERE id_user = ?");

        if ($stmt->execute([$lname, $fname, $mi, $age, $email, $contact, $position, $address, $role, $addedby, $id_user])) {
            $_SESSION['staff_update_success'] = "Staff account updated successfully.";
        } else {
            $_SESSION['staff_update_error'] = "Failed to update staff account.";
        }
        header("Location: staff_staff_crud.php?id_user=" . $id_user);
        exit();
    }

    public function delete_staff()
    {
        if (isset($_POST['delete_staff'])) {
            if (session_status() === PHP_SESSION_NONE) {
                session_start();
            }
            $id_user = $_POST['id_user'];
            $connection = $this->openConn();
            $stmt = $connection->prepare("DELETE FROM tbl_user where id_user = ?");
            $stmt->execute([$id_user]);

            $_SESSION['staff_delete_success'] = "Staff Account Deleted";
            header('location: admn_staff_crud.php');
            exit();
        }
    }

    //--------------------------------------------- EXTRA FUNCTIONS FOR STAFF -------------------------------------------------

    public function get_single_staff($id_user)
    {
        $connection = $this->openConn();
        $stmt = $connection->prepare("SELECT * FROM tbl_user where id_user = ?");
        $stmt->execute([$id_user]);
        $user = $stmt->fetch();
        return $user ? $user : false;
    }

    public function update_admin_profile()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        $auth = new Authentication();
        $id_user = $_SESSION['userdata']['id_user'];
        $fname = $_POST['fname'];
        $mi = $_POST['mi'];
        $lname = $_POST['lname'];
        $email = $_POST['email'];
        $contact = $_POST['contact'];

        $connection = $this->openConn();
        $stmt = $connection->prepare("UPDATE tbl_user SET fname = ?, mi = ?, lname = ?, email = ?, contact = ? WHERE id_user = ?");

        if ($stmt->execute([$fname, $mi, $lname, $email, $contact, $id_user])) {
            $_SESSION['profile_update_success'] = "Profile updated successfully.";
            // Fetch the updated data to refresh the session
            $updated_user_data = $this->get_single_staff($id_user);

            // Remap keys to match session structure
            $session_data = [
                'id_user' => $updated_user_data['id_user'],
                'firstname' => $updated_user_data['fname'],
                'mname' => $updated_user_data['mi'],
                'surname' => $updated_user_data['lname'],
                'email' => $updated_user_data['email'],
                'contact' => $updated_user_data['contact'],
                'role' => 'administrator' // Keep the role
            ];

            $auth->set_userdata($session_data);

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
        $id_user = $_SESSION['id_user'];
        $current_password = $_POST['current_password'];
        $new_password = $_POST['new_password'];
        $confirm_password = $_POST['confirm_password'];

        $connection = $this->openConn();
        $stmt = $connection->prepare("SELECT password FROM tbl_user WHERE id_user = ?");
        $stmt->execute([$id_user]);
        $user = $stmt->fetch();

        if ($user && $current_password == $user['password']) {
            if ($new_password === $confirm_password) {
                $stmt_update = $connection->prepare("UPDATE tbl_user SET password = ? WHERE id_user = ?");
                if ($stmt_update->execute([$new_password, $id_user])) {
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

    public function check_staff_email($email)
    {
        $connection = $this->openConn();
        $stmt = $connection->prepare("SELECT * FROM tbl_user WHERE email = ?");
        $stmt->Execute([$email]);
        $total = $stmt->rowCount();
        return $total;
    }

    public function count_staff()
    {
        $connection = $this->openConn();
        $stmt = $connection->prepare("SELECT COUNT(*) from tbl_user");
        $stmt->execute();
        $staffcount = $stmt->fetchColumn();
        return $staffcount;
    }

    public function count_mstaff()
    {
        $connection = $this->openConn();
        $stmt = $connection->prepare("SELECT COUNT(*) from tbl_user where sex = 'male'");
        $stmt->execute();
        $staffcount = $stmt->fetchColumn();
        return $staffcount;
    }

    public function count_fstaff()
    {
        $connection = $this->openConn();
        $stmt = $connection->prepare("SELECT COUNT(*) from tbl_user where sex = 'female'");
        $stmt->execute();
        $staffcount = $stmt->fetchColumn();
        return $staffcount;
    }

    public function view_staff_male()
    {
        $connection = $this->openConn();
        $stmt = $connection->prepare("SELECT * from tbl_user WHERE `sex` = 'Male'");
        $stmt->execute();
        $view = $stmt->fetchAll();
        return $view;
    }

    public function view_staff_female()
    {
        $connection = $this->openConn();
        $stmt = $connection->prepare("SELECT * from tbl_user WHERE `sex` = 'Female'");
        $stmt->execute();
        $view = $stmt->fetchAll();
        return $view;
    }

    public function update_staff_profile($id_user)
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        $lname = $_POST['lname'];
        $fname = $_POST['fname'];
        $mi = $_POST['mi'];
        $age = $_POST['age'];
        $sex = $_POST['sex'];
        $email = $_POST['email'];
        $contact = $_POST['contact'];
        $position = $_POST['position'];
        $address = $_POST['address'];

        $connection = $this->openConn();
        $stmt = $connection->prepare("UPDATE tbl_user SET lname = ?, fname = ?, mi = ?, age = ?, sex = ?, email = ?, contact = ?, position = ?, address = ? WHERE id_user = ?");
        $stmt->execute([$lname, $fname, $mi, $age, $sex, $email, $contact, $position, $address, $id_user]);
    }
}

?>