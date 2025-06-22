<?php

require_once 'Database.php';

class Announcement extends Database
{
    public function create_announcement()
    {
        if (isset($_POST['create_announce'])) {
            $event = $_POST['event'];
            $start_date = $_POST['start_date'];
            $addedby = $_POST['addedby'];

            $connection = $this->openConn();
            $stmt = $connection->prepare("INSERT INTO tbl_announcement (event, start_date, addedby) VALUES (?, ?, ?)");
            $stmt->execute([$event, $start_date, $addedby]);
            echo '<script>alert("Announcement created successfully!");</script>';
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
            $id_announcement = $_POST['id_announcement'];
            $connection = $this->openConn();
            $stmt = $connection->prepare("DELETE FROM tbl_announcement WHERE id_announcement = ?");
            $stmt->execute([$id_announcement]);
            echo '<script>alert("Announcement deleted successfully!");</script>';
        }
    }

    public function count_announcement()
    {
        $connection = $this->openConn();
        $stmt = $connection->prepare("SELECT COUNT(*) FROM tbl_announcement");
        $stmt->execute();
        return $stmt->fetchColumn();
    }
}