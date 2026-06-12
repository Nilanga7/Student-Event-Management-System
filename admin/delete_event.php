<?php 
require_once '../php/auth_check.php';
require_once '../php/db_connect.php';
requireAdmin();

$event_id = isset($_GET['id']) ? intval($_GET['id']) : 0;

if ($event_id > 0) {
    // Delete event
    $stmt = $pdo->prepare("DELETE FROM events WHERE event_id = ?");
    
    if ($stmt->execute([$event_id])) {
        $_SESSION['success'] = 'Event deleted successfully!';
    } else {
        $_SESSION['error'] = 'Failed to delete event.';
    }
} else {
    $_SESSION['error'] = 'Invalid event ID.';
}

header('Location: dashboard.php');
exit();
?>