<?php

require_once 'Database.php';

class Certificate extends Database
{
    // Barangay ID
    public function create_brgyid()
    {
        if (isset($_POST['create_brgyid'])) {
            // ... form data
            $connection = $this->openConn();
            $stmt = $connection->prepare("INSERT INTO tbl_brgyid (...) VALUES (...)");
            $stmt->execute();
            echo '<script>alert("Barangay ID request added successfully!");</script>';
        }
    }
    public function view_brgyid()
    { /* ... */
    }
    public function delete_brgyid()
    { /* ... */
    }

    // Barangay Clearance
    public function create_brgyclearance()
    {
        if (isset($_POST['create_brgyclearance'])) {
            // ... form data
            $connection = $this->openConn();
            $stmt = $connection->prepare("INSERT INTO tbl_clearance (...) VALUES (...)");
            $stmt->execute();
            echo '<script>alert("Barangay Clearance request added successfully!");</script>';
        }
    }
    public function view_clearance()
    { /* ... */
    }
    public function delete_clearance()
    { /* ... */
    }

    // Certificate of Indigency
    public function create_certofindigency()
    {
        if (isset($_POST['create_certofindigency'])) {
            // ... form data
            $connection = $this->openConn();
            $stmt = $connection->prepare("INSERT INTO tbl_indigency (...) VALUES (...)");
            $stmt->execute();
            echo '<script>alert("Certificate of Indigency request added successfully!");</script>';
        }
    }
    public function view_certofindigency()
    { /* ... */
    }
    public function delete_certofindigency()
    { /* ... */
    }

    // Certificate of Residency
    public function create_certofres()
    {
        if (isset($_POST['create_certofres'])) {
            // ... form data
            $connection = $this->openConn();
            $stmt = $connection->prepare("INSERT INTO tbl_rescert (...) VALUES (...)");
            $stmt->execute();
            echo '<script>alert("Certificate of Residency request added successfully!");</script>';
        }
    }
    public function view_certofres()
    { /* ... */
    }
    public function delete_certofres()
    { /* ... */
    }
}