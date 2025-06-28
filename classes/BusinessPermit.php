<?php

require_once 'Database.php';

class BusinessPermit extends Database
{
    public function create_bspermit()
    {
        if (isset($_POST['create_bspermit'])) {
            try {
                $id_resident = $_POST['id_resident'];
                if (empty($id_resident)) {
                    echo '<div style="color:red;">Error: Resident ID is missing. Please log in again.</div>';
                    return;
                }
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
                if (!is_numeric($aoe) || intval($aoe) <= 0) {
                    echo '<div style="color:red;">Error: Area of Establishment (AOE) must be a positive number.</div>';
                    return;
                }
                $aoe = intval($aoe);

                $connection = $this->openConn();
                $stmt = $connection->prepare("INSERT INTO tbl_bspermit (id_resident, lname, fname, mi, bsname, houseno, street, brgy, municipal, bsindustry, aoe) VALUES (?,?,?,?,?,?,?,?,?,?,?)");
                $stmt->execute([$id_resident, $lname, $fname, $mi, $bsname, $houseno, $street, $brgy, $municipal, $bsindustry, $aoe]);
                echo '<script>alert("Business permit request added successfully!");</script>';
            } catch (PDOException $e) {
                echo '<div style="color:red;">Database Error: ' . htmlspecialchars($e->getMessage()) . '</div>';
            } catch (Exception $e) {
                echo '<div style="color:red;">General Error: ' . htmlspecialchars($e->getMessage()) . '</div>';
            }
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

    public function view_bspermit_by_resident($id_resident)
    {
        $connection = $this->openConn();
        $stmt = $connection->prepare("SELECT *, 
            CASE 
                WHEN notification_sent = 1 THEN 'Generated'
                ELSE 'Pending'
            END as status,
            generated_date,
            generated_by
            FROM tbl_bspermit WHERE id_resident = ? ORDER BY id_bspermit DESC");
        $stmt->execute([$id_resident]);
        return $stmt->fetchAll();
    }
}