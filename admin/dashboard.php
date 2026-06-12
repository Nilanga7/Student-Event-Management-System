<?php
require_once '../php/auth_check.php';
require_once '../php/db_connect.php';
requireAdmin();

// Get statistics
$stmt = $pdo->query("SELECT COUNT(*) as total FROM events");
$totalEvents = $stmt->fetch()['total'];

$stmt = $pdo->query("SELECT COUNT(*) as total FROM users WHERE role = 'student'");
$totalStudents = $stmt->fetch()['total'];

$stmt = $pdo->query("SELECT COUNT(*) as total FROM registrations");
$totalRegistrations = $stmt->fetch()['total'];

// Get recent events
$stmt = $pdo->query("SELECT * FROM events ORDER BY created_at DESC LIMIT 5");
$recentEvents = $stmt->fetchAll();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - Event Management</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="../css/styles.css" rel="stylesheet">
</head>
<body>
    <!-- Navigation -->
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
                        <a class="nav-link" href="../events.php">Events</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" href="dashboard.php">Dashboard</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="../php/logout_user.php">Logout (<?php echo htmlspecialchars($_SESSION['name']); ?>)</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container my-5">
        <h1 class="mb-4">Admin Dashboard</h1>

        <?php if (isset($_SESSION['success'])): ?>
            <div class="alert alert-success alert-dismissible fade show">
                <?php
                echo htmlspecialchars($_SESSION['success']);
                unset($_SESSION['success']);
                ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        <?php endif; ?>

        <!-- Statistics Cards -->
        <div class="row mb-4">
            <div class="col-md-4">
                <div class="card stat-card text-white bg-primary">
                    <div class="card-body">
                        <h5 class="card-title">Total Events</h5>
                        <h2 class="display-4"><?php echo $totalEvents; ?></h2>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card stat-card text-white bg-success">
                    <div class="card-body">
                        <h5 class="card-title">Total Students</h5>
                        <h2 class="display-4"><?php echo $totalStudents; ?></h2>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card stat-card text-white bg-info">
                    <div class="card-body">
                        <h5 class="card-title">Total Registrations</h5>
                        <h2 class="display-4"><?php echo $totalRegistrations; ?></h2>
                    </div>
                </div>
            </div>
        </div>

        <!-- Quick Actions -->

	<div class="card mb-4 quick-actions-card">
        <div class="card-header text-white quick-actions-header">
            <h5 class="mb-0 quick-actions-title">Quick Actions</h5>
        </div>
        <div class="card-body quick-actions-body">
            <a href="add_event.php" class="btn btn-success me-2 mb-2 action-btn action-add">➕ Add New Event</a>
            <a href="view_registrations.php" class="btn btn-info me-2 mb-2 action-btn action-view">📋 View All Registrations</a>
            <a href="create_admin.php" class="btn btn-danger me-2 mb-2 action-btn action-create">👤 Create New Admin</a>
            <a href="../events.php" class="btn btn-secondary mb-2 action-btn action-public">👁️ View Public Events Page</a>
        </div>
    </div>

        <!-- Recent Events Table -->
        <div class="card recent-events-card">
            <div class="card-header text-white recent-events-header">
                <h5 class="mb-0 recent-events-title">Recent Events</h5>
            </div>
            <div class="card-body recent-events-body">
                <div class="table-responsive recent-events-table-wrapper">
                    <table class="table table-hover recent-events-table">
                        <thead class="recent-events-thead">
                            <tr>
                                <th>Title</th>
                                <th>Date</th>
                                <th>Venue</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody class="recent-events-tbody">
                            <?php foreach ($recentEvents as $event): ?>
                                <tr class="recent-event-row">
                                    <td><?php echo htmlspecialchars($event['title']); ?></td>
                                    <td><?php echo date('M d, Y', strtotime($event['date'])); ?></td>
                                    <td><?php echo htmlspecialchars($event['venue']); ?></td>
                                    <td class="event-actions">
                                        <a href="edit_event.php?id=<?php echo $event['event_id']; ?>" class="btn btn-sm action-btn action-edit">Edit</a>
                                        <a href="view_registrations.php?event_id=<?php echo $event['event_id']; ?>" class="btn btn-sm action-btn action-view-reg">Registrations</a>
                                        <a href="delete_event.php?id=<?php echo $event['event_id']; ?>" class="btn btn-sm action-btn action-delete" onclick="return confirm('Are you sure you want to delete this event?')">Delete</a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>