<?php

require_once 'Database.php';

class Blotter extends Database
{
    public function create_blotter()
    {
        if (isset($_POST['create_blotter'])) {
            $id_resident = $_POST['id_resident'];
            $lname = $_POST['lname'];
            $fname = $_POST['fname'];
            $mi = $_POST['mi'];
            $houseno = $_POST['houseno'];
            $street = $_POST['street'];
            $brgy = $_POST['brgy'];
            $municipal = $_POST['municipal'];
            $contact = $_POST['contact'];
            $narrative = $_POST['narrative'];
            $photo = file_get_contents(addslashes($_FILES['blot_photo']['tmp_name']));

            $connection = $this->openConn();
            $stmt = $connection->prepare("INSERT INTO tbl_blotter (id_resident, lname, fname, mi, houseno, street, brgy, municipal, blot_photo, contact, narrative) VALUES (?,?,?,?,?,?,?,?,?,?,?)");
            $stmt->execute([$id_resident, $lname, $fname, $mi, $houseno, $street, $brgy, $municipal, $photo, $contact, $narrative]);
            echo '<script>alert("Blotter report added successfully!");</script>';
        }
    }

    public function get_single_blotter($id_blotter)
    {
        $connection = $this->openConn();
        $stmt = $connection->prepare("SELECT * FROM tbl_blotter WHERE id_blotter = ?");
        $stmt->execute([$id_blotter]);
        $blotter = $stmt->fetch();
        if ($stmt->rowCount() > 0) {
            return $blotter;
        }
        return false;
    }

    public function view_blotter()
    {
        $connection = $this->openConn();
        $stmt = $connection->prepare("SELECT * FROM tbl_blotter");
        $stmt->execute();
        $blotters = $stmt->fetchAll();
        return $blotters;
    }

    public function delete_blotter()
    {
        if (isset($_POST['delete_blotter'])) {
            $id_blotter = $_POST['id_blotter'];
            $connection = $this->openConn();
            $stmt = $connection->prepare("DELETE FROM tbl_blotter WHERE id_blotter = ?");
            $stmt->execute([$id_blotter]);
            echo '<script>alert("Blotter data has been removed!");</script>';
        }
    }

    public function update_blotter()
    {
        if (isset($_POST['update_blotter'])) {
            $id_blotter = $_GET['id_blotter'];
            $narrative = $_POST['narrative'];

            $connection = $this->openConn();
            $stmt = $connection->prepare("UPDATE tbl_blotter SET narrative = ? WHERE id_blotter = ?");
            if ($stmt->execute([$narrative, $id_blotter])) {
                echo '<script>alert("Blotter data updated successfully!");</script>';
            } else {
                echo '<script>alert("Failed to update blotter data.");</script>';
            }
        }
    }
}