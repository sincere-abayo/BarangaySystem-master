<?php
require_once 'classes/Authentication.php';
require_once 'classes/Notification.php';

$auth = new Authentication();
$notification = new Notification();

// Check if resident is logged in
$userdetails = $auth->get_userdata();
if (empty($userdetails['id_resident'])) {
    echo json_encode(['success' => false, 'message' => 'Not authenticated']);
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $notification_id = $_POST['notification_id'] ?? '';

    if (empty($notification_id)) {
        echo json_encode(['success' => false, 'message' => 'Missing notification ID']);
        exit;
    }

    // Mark notification as read
    $result = $notification->markNotificationAsRead($notification_id);

    if ($result) {
        echo json_encode(['success' => true, 'message' => 'Notification marked as read']);
    } else {
        echo json_encode(['success' => false, 'message' => 'Failed to mark notification as read']);
    }
    exit;
}

// If not POST request, show error
echo json_encode(['success' => false, 'message' => 'Invalid request method']);
exit;
?>