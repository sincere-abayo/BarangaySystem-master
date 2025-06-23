<?php

require_once 'Database.php';

class Announcement extends Database
{
    public function create_announcement()
    {
        if (isset($_POST['create_announce'])) {
            if (session_status() === PHP_SESSION_NONE) {
                session_start();
            }
            $event = trim($_POST['event'] ?? '');
            $start_date = $_POST['start_date'] ?? '';
            $addedby = $_POST['addedby'] ?? '';

            if ($event === '') {
                $_SESSION['announcement_error'] = "Announcement message cannot be empty.";
                header("Location: admn_announcement_crud.php");
                exit();
            }

            $connection = $this->openConn();
            $stmt = $connection->prepare("INSERT INTO tbl_announcement (event, start_date, addedby) VALUES (?, ?, ?)");

            if ($stmt->execute([$event, $start_date, $addedby])) {
                $_SESSION['announcement_success'] = "Announcement created successfully!";
            } else {
                $_SESSION['announcement_error'] = "Failed to create announcement.";
            }
            header("Location: admn_announcement_crud.php");
            exit();
        }
    }

    public function view_announcement()
    {
        $connection = $this->openConn();
        $stmt = $connection->prepare("SELECT * FROM tbl_announcement ORDER BY start_date DESC");
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function update_announcement()
    {
        if (isset($_POST['update_announcement'])) {
            $id_announcement = $_POST['id_announcement'];
            $event = $_POST['event'];

            $connection = $this->openConn();
            $stmt = $connection->prepare("UPDATE tbl_announcement SET event = ? WHERE id_announcement = ?");
            $stmt->execute([$event, $id_announcement]);
            echo '<script>alert("Announcement updated successfully!");</script>';
        }
    }

    public function delete_announcement()
    {
        if (isset($_POST['delete_announcement'])) {
            if (session_status() === PHP_SESSION_NONE) {
                session_start();
            }
            $id_announcement = $_POST['id_announcement'] ?? null;
            if (!$id_announcement) {
                $_SESSION['announcement_error'] = "Invalid announcement ID.";
                header("Location: admn_announcement_crud.php");
                exit();
            }
            $connection = $this->openConn();
            $stmt = $connection->prepare("DELETE FROM tbl_announcement WHERE id_announcement = ?");

            if ($stmt->execute([$id_announcement])) {
                $_SESSION['announcement_success'] = "Announcement deleted successfully!";
            } else {
                $_SESSION['announcement_error'] = "Failed to delete announcement.";
            }
            header("Location: admn_announcement_crud.php");
            exit();
        }
    }

    public function get_latest_announcement()
    {
        $connection = $this->openConn();
        $stmt = $connection->prepare("SELECT * FROM tbl_announcement ORDER BY start_date DESC LIMIT 1");
        $stmt->execute();
        return $stmt->fetch();
    }

    public function count_announcement()
    {
        $connection = $this->openConn();
        $stmt = $connection->prepare("SELECT COUNT(*) FROM tbl_announcement");
        $stmt->execute();
        return $stmt->fetchColumn();
    }
}