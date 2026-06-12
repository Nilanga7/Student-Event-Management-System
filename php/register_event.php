<?php
session_start();
require_once 'db_connect.php';
require_once 'auth_check.php';

requireLogin();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $event_id = intval($_POST['event_id']);
    $user_id = $_SESSION['user_id'];
    
    // Check if already registered
    $stmt = $pdo->prepare("SELECT reg_id FROM registrations WHERE user_id = ? AND event_id = ?");
    $stmt->execute([$user_id, $event_id]);
    
    if ($stmt->rowCount() > 0) {
        $_SESSION['error'] = 'You are already registered for this event.';
        header('Location: ../events.php');
        exit();
    }
    
    // Register for event
    $stmt = $pdo->prepare("INSERT INTO registrations (user_id, event_id) VALUES (?, ?)");
    
    if ($stmt->execute([$user_id, $event_id])) {
        $_SESSION['success'] = 'Successfully registered for the event!';
    } else {
        $_SESSION['error'] = 'Registration failed. Please try again.';
    }
    
    header('Location: ../events.php');
    exit();
}
?>