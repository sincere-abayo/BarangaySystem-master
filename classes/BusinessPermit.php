<?php

require_once 'Database.php';

class BusinessPermit extends Database
{
    public function create_bspermit()
    {
        if (isset($_POST['create_bspermit'])) {
            $id_resident = $_POST['id_resident'];
            $lname = $_POST['lname'];
            $fname = $_POST['fname'];
            $mi = $_POST['mi'];
            $bsname = $_POST['bsname'];
            $houseno = $_POST['houseno'];
            $street = $_POST['street'];
            $brgy = $_POST['brgy'];
            $municipal = $_POST['municipal'];
            $bsindustry = $_POST['bsindustry'];
            $aoe = $_POST['aoe'];

            $connection = $this->openConn();
            $stmt = $connection->prepare("INSERT INTO tbl_bspermit (id_resident, lname, fname, mi, bsname, houseno, street, brgy, municipal, bsindustry, aoe) VALUES (?,?,?,?,?,?,?,?,?,?,?)");
            $stmt->execute([$id_resident, $lname, $fname, $mi, $bsname, $houseno, $street, $brgy, $municipal, $bsindustry, $aoe]);
            echo '<script>alert("Business permit request added successfully!");</script>';
        }
    }

    public function get_single_bspermit($id_bspermit)
    {
        $connection = $this->openConn();
        $stmt = $connection->prepare("SELECT * FROM tbl_bspermit WHERE id_bspermit = ?");
        $stmt->execute([$id_bspermit]);
        $permit = $stmt->fetch();
        if ($stmt->rowCount() > 0) {
            return $permit;
        }
        return false;
    }

    public function view_bspermit()
    {
        $connection = $this->openConn();
        $stmt = $connection->prepare("SELECT * FROM tbl_bspermit");
        $stmt->execute();
        $permits = $stmt->fetchAll();
        return $permits;
    }

    public function delete_bspermit()
    {
        if (isset($_POST['delete_bspermit'])) {
            $id_bspermit = $_POST['id_bspermit'];
            $connection = $this->openConn();
            $stmt = $connection->prepare("DELETE FROM tbl_bspermit WHERE id_bspermit = ?");
            $stmt->execute([$id_bspermit]);
            echo '<script>alert("Business permit data has been removed!");</script>';
        }
    }

    public function update_bspermit()
    {
        if (isset($_POST['update_bspermit'])) {
            $id_bspermit = $_GET['id_bspermit'];
            $bsname = $_POST['bsname'];
            $bsindustry = $_POST['bsindustry'];
            $aoe = $_POST['aoe'];

            $connection = $this->openConn();
            $stmt = $connection->prepare("UPDATE tbl_bspermit SET bsname = ?, bsindustry = ?, aoe = ? WHERE id_bspermit = ?");
            if ($stmt->execute([$bsname, $bsindustry, $aoe, $id_bspermit])) {
                echo '<script>alert("Business permit data updated successfully!");</script>';
            } else {
                echo '<script>alert("Failed to update business permit data.");</script>';
            }
        }
    }
}