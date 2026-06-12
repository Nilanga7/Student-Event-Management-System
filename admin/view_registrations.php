<?php 
require_once '../php/auth_check.php';
require_once '../php/db_connect.php';
requireAdmin();

$event_id = isset($_GET['event_id']) ? intval($_GET['event_id']) : 0;

if ($event_id > 0) {
    // Get specific event registrations
    $stmt = $pdo->prepare("SELECT e.title, e.date, e.venue, u.name, u.email, r.timestamp 
                           FROM registrations r 
                           JOIN users u ON r.user_id = u.user_id 
                           JOIN events e ON r.event_id = e.event_id 
                           WHERE r.event_id = ? 
                           ORDER BY r.timestamp DESC");
    $stmt->execute([$event_id]);
    $registrations = $stmt->fetchAll();
    
    $stmt = $pdo->prepare("SELECT title FROM events WHERE event_id = ?");
    $stmt->execute([$event_id]);
    $event = $stmt->fetch();
    $pageTitle = $event ? 'Registrations for: ' . $event['title'] : 'Event Registrations';
} else {
    // Get all registrations
    $stmt = $pdo->query("SELECT e.title, e.date, e.venue, u.name, u.email, r.timestamp 
                         FROM registrations r 
                         JOIN users u ON r.user_id = u.user_id 
                         JOIN events e ON r.event_id = e.event_id 
                         ORDER BY r.timestamp DESC");
    $registrations = $stmt->fetchAll();
    $pageTitle = 'All Event Registrations';
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Registrations - Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="../css/styles.css" rel="stylesheet">
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
        <div class="container">
            <a class="navbar-brand" href="../index.php">StudentSphere</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="../index.php">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="dashboard.php">Dashboard</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="../php/logout_user.php">Logout</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container my-5">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1><?php echo htmlspecialchars($pageTitle); ?></h1>
            <a href="dashboard.php" class="btn btn-secondary">Back to Dashboard</a>
        </div>
        
        <?php if (count($registrations) > 0): ?>
            <div class="card shadow">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover table-striped">
                            <thead class="table-primary">
                                <tr>
                                    <th>Event Title</th>
                                    <th>Student Name</th>
                                    <th>Email</th>
                                    <th>Event Date</th>
                                    <th>Venue</th>
                                    <th>Registered On</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($registrations as $reg): ?>
                                    <tr>
                                        <td><?php echo htmlspecialchars($reg['title']); ?></td>
                                        <td><?php echo htmlspecialchars($reg['name']); ?></td>
                                        <td><?php echo htmlspecialchars($reg['email']); ?></td>
                                        <td><?php echo date('M d, Y', strtotime($reg['date'])); ?></td>
                                        <td><?php echo htmlspecialchars($reg['venue']); ?></td>
                                        <td><?php echo date('M d, Y H:i', strtotime($reg['timestamp'])); ?></td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                    <div class="mt-3">
                        <p class="text-muted"><strong>Total Registrations:</strong> <?php echo count($registrations); ?></p>
                    </div>
                </div>
            </div>
        <?php else: ?>
            <div class="alert alert-info">
                No registrations found for this event.
            </div>
        <?php endif; ?>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>