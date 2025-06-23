<?php

require_once 'Database.php';

class Certificate extends Database
{
    // Barangay ID
    public function create_brgyid()
    {
        if (isset($_POST['create_brgyid'])) {
            $id_resident = $_POST['id_resident'];
            $lname = $_POST['lname'];
            $fname = $_POST['fname'];
            $mi = $_POST['mi'];
            $houseno = $_POST['houseno'];
            $street = $_POST['street'];
            $brgy = $_POST['brgy'];
            $municipal = $_POST['municipal'];
            $bplace = $_POST['bplace'];
            $bdate = $_POST['bdate'];
            $inc_lname = $_POST['inc_lname'];
            $inc_fname = $_POST['inc_fname'];
            $inc_mi = $_POST['inc_mi'];
            $inc_contact = $_POST['inc_contact'];
            $inc_houseno = $_POST['inc_houseno'];
            $inc_street = $_POST['inc_street'];
            $inc_brgy = $_POST['inc_brgy'];
            $inc_municipal = $_POST['inc_municipal'];

            $connection = $this->openConn();
            $stmt = $connection->prepare("INSERT INTO tbl_brgyid (id_resident, lname, fname, mi, houseno, street, brgy, municipal, bplace, bdate, inc_lname, inc_fname, inc_mi, inc_contact, inc_houseno, inc_street, inc_brgy, inc_municipal) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)");
            $stmt->execute([$id_resident, $lname, $fname, $mi, $houseno, $street, $brgy, $municipal, $bplace, $bdate, $inc_lname, $inc_fname, $inc_mi, $inc_contact, $inc_houseno, $inc_street, $inc_brgy, $inc_municipal]);
            echo '<script>alert("Barangay ID request added successfully!");</script>';
        }
    }
    public function view_brgyid()
    {
        $connection = $this->openConn();
        $stmt = $connection->prepare("SELECT * FROM tbl_brgyid");
        $stmt->execute();
        return $stmt->fetchAll();
    }
    public function delete_brgyid()
    {
        if (isset($_POST['delete_brgyid'])) {
            $id_brgyid = $_POST['id_brgyid'];
            $connection = $this->openConn();
            $stmt = $connection->prepare("DELETE FROM tbl_brgyid WHERE id_brgyid = ?");
            $stmt->execute([$id_brgyid]);
            echo '<script>alert("Barangay ID data has been removed!");</script>';
        }
    }

    public function get_single_brgyid($id_resident)
    {
        $connection = $this->openConn();
        $stmt = $connection->prepare("SELECT * FROM tbl_brgyid WHERE id_resident = ?");
        $stmt->execute([$id_resident]);
        return $stmt->fetch();
    }

    // Barangay Clearance
    public function create_brgyclearance()
    {
        if (isset($_POST['create_brgyclearance'])) {
            $id_resident = $_POST['id_resident'];
            $lname = $_POST['lname'];
            $fname = $_POST['fname'];
            $mi = $_POST['mi'];
            $purpose = $_POST['purpose'];
            $houseno = $_POST['houseno'];
            $street = $_POST['street'];
            $brgy = $_POST['brgy'];
            $municipal = $_POST['municipal'];
            $status = $_POST['status'];
            $age = $_POST['age'];

            $connection = $this->openConn();
            $stmt = $connection->prepare("INSERT INTO tbl_clearance (id_resident, lname, fname, mi, purpose, houseno, street, brgy, municipal, status, age) VALUES (?,?,?,?,?,?,?,?,?,?,?)");
            $stmt->execute([$id_resident, $lname, $fname, $mi, $purpose, $houseno, $street, $brgy, $municipal, $status, $age]);
            echo '<script>alert("Barangay Clearance request added successfully!");</script>';
        }
    }
    public function view_clearance()
    {
        $connection = $this->openConn();
        $stmt = $connection->prepare("SELECT * FROM tbl_clearance");
        $stmt->execute();
        return $stmt->fetchAll();
    }
    public function delete_clearance()
    {
        if (isset($_POST['delete_clearance'])) {
            $id_clearance = $_POST['id_clearance'];
            $connection = $this->openConn();
            $stmt = $connection->prepare("DELETE FROM tbl_clearance WHERE id_clearance = ?");
            $stmt->execute([$id_clearance]);
            echo '<script>alert("Barangay Clearance data has been removed!");</script>';
        }
    }

    public function get_single_clearance($id_clearance)
    {
        $connection = $this->openConn();
        $stmt = $connection->prepare("SELECT * FROM tbl_clearance WHERE id_clearance = ?");
        $stmt->execute([$id_clearance]);
        return $stmt->fetch();
    }

    // Certificate of Indigency
    public function create_certofindigency()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['create_certofindigency'])) {
            try {
                $id_resident = $_POST['id_resident'];
                $fname = $_POST['fname'];
                $mi = $_POST['mi'];
                $lname = $_POST['lname'];
                $nationality = $_POST['nationality'];
                $houseno = $_POST['houseno'];
                $street = $_POST['street'];
                $brgy = $_POST['brgy'];
                $municipal = $_POST['municipal'];
                $purpose = $_POST['purpose'];
                $date = $_POST['date'];

                $connection = $this->openConn();
                $stmt = $connection->prepare("INSERT INTO tbl_indigency (id_resident, fname, mi, lname, nationality, houseno, street, brgy, municipal, purpose, date) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");

                $result = $stmt->execute([
                    $id_resident,
                    $fname,
                    $mi,
                    $lname,
                    $nationality,
                    $houseno,
                    $street,
                    $brgy,
                    $municipal,
                    $purpose,
                    $date
                ]);

                if ($result) {
                    echo "<script>alert('Your request has been sent successfully!'); window.location='resident_homepage.php';</script>";
                } else {
                    echo "<script>alert('Error submitting request. Please try again.');</script>";
                }

                $this->closeConn();
            } catch (PDOException $e) {
                error_log('Certificate Creation Error: ' . $e->getMessage());
                echo "<script>alert('An error occurred. Please try again.');</script>";
            }
        }
    }
    public function view_certofindigency()
    {
        $connection = $this->openConn();
        $stmt = $connection->prepare("SELECT * FROM tbl_indigency");
        $stmt->execute();
        return $stmt->fetchAll();
    }
    public function delete_certofindigency()
    {
        if (isset($_POST['delete_certofindigency'])) {
            $id_indigency = $_POST['id_indigency'];
            $connection = $this->openConn();
            $stmt = $connection->prepare("DELETE FROM tbl_indigency WHERE id_indigency = ?");
            $stmt->execute([$id_indigency]);
            echo '<script>alert("Certificate of Indigency data has been removed!");</script>';
        }
    }

    public function get_single_certofindigency($id_resident)
    {
        $connection = $this->openConn();
        $stmt = $connection->prepare("SELECT * FROM tbl_indigency WHERE id_resident = ?");
        $stmt->execute([$id_resident]);
        return $stmt->fetch();
    }

    // Certificate of Residency
    public function create_certofres()
    {
        if (isset($_POST['create_certofres'])) {
            $id_resident = $_POST['id_resident'];
            $lname = $_POST['lname'];
            $fname = $_POST['fname'];
            $mi = $_POST['mi'];
            $age = $_POST['age'];
            $nationality = $_POST['nationality'];
            $houseno = $_POST['houseno'];
            $street = $_POST['street'];
            $brgy = $_POST['brgy'];
            $municipal = $_POST['municipal'];
            $date = $_POST['date'];
            $purpose = $_POST['purpose'];

            $connection = $this->openConn();
            $stmt = $connection->prepare("INSERT INTO tbl_rescert (id_resident, lname, fname, mi, age, nationality, houseno, street, brgy, municipal, date, purpose) VALUES (?,?,?,?,?,?,?,?,?,?,?,?)");
            $stmt->execute([$id_resident, $lname, $fname, $mi, $age, $nationality, $houseno, $street, $brgy, $municipal, $date, $purpose]);
            echo '<script>alert("Certificate of Residency request added successfully!");</script>';
        }
    }
    public function view_certofres()
    {
        $connection = $this->openConn();
        $stmt = $connection->prepare("SELECT * FROM tbl_rescert");
        $stmt->execute();
        return $stmt->fetchAll();
    }
    public function delete_certofres()
    {
        if (isset($_POST['delete_certofres'])) {
            $id_rescert = $_POST['id_rescert'];
            $connection = $this->openConn();
            $stmt = $connection->prepare("DELETE FROM tbl_rescert WHERE id_rescert = ?");
            $stmt->execute([$id_rescert]);
            echo '<script>alert("Certificate of Residency data has been removed!");</script>';
        }
    }

    public function get_single_certofres($id_resident)
    {
        $connection = $this->openConn();
        $stmt = $connection->prepare("SELECT * FROM tbl_rescert WHERE id_resident = ?");
        $stmt->execute([$id_resident]);
        return $stmt->fetch();
    }

    public function view_certofres_by_resident($id_resident)
    {
        $connection = $this->openConn();
        $stmt = $connection->prepare("SELECT * FROM tbl_rescert WHERE id_resident = ?");
        $stmt->execute([$id_resident]);
        return $stmt->fetchAll();
    }
}