<?php 
require_once '../php/auth_check.php';
require_once '../php/db_connect.php';
requireAdmin();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];
    
    // Server-side validation
    if (empty($name) || empty($email) || empty($password)) {
        $_SESSION['error'] = 'All fields are required.';
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $_SESSION['error'] = 'Invalid email format.';
    } elseif (strlen($password) < 6) {
        $_SESSION['error'] = 'Password must be at least 6 characters.';
    } elseif ($password !== $confirm_password) {
        $_SESSION['error'] = 'Passwords do not match.';
    } else {
        // Check if email already exists
        $stmt = $pdo->prepare("SELECT user_id FROM users WHERE email = ?");
        $stmt->execute([$email]);
        
        if ($stmt->rowCount() > 0) {
            $_SESSION['error'] = 'Email already registered.';
        } else {
            // Hash password and insert admin user
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);
            
            $stmt = $pdo->prepare("INSERT INTO users (name, email, password, role) VALUES (?, ?, ?, 'admin')");
            
            if ($stmt->execute([$name, $email, $hashed_password])) {
                $_SESSION['success'] = 'New admin created successfully!';
                header('Location: dashboard.php');
                exit();
            } else {
                $_SESSION['error'] = 'Failed to create admin account.';
            }
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create New Admin - Event Management</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="../css/styles.css" rel="stylesheet">
</head>
<body>
    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
        <div class="container">
            <a class="navbar-brand" href="../index.php">🎓 Event Management</a>
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
                        <a class="nav-link" href="dashboard.php">Dashboard</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="../php/logout_user.php">Logout (<?php echo htmlspecialchars($_SESSION['name']); ?>)</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container my-5">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card shadow">
                    <div class="card-header bg-danger text-white">
                        <h4 class="mb-0">👤 Create New Administrator</h4>
                    </div>
                    <div class="card-body p-4">
                        <div class="alert alert-warning">
                            <strong>⚠️ Important:</strong> You are creating an administrator account with full system access. This user will be able to:
                            <ul class="mb-0 mt-2">
                                <li>Create, edit, and delete events</li>
                                <li>View all registrations</li>
                                <li>Access the admin dashboard</li>
                                <li>Create other admin accounts</li>
                            </ul>
                        </div>

                        <?php if (isset($_SESSION['error'])): ?>
                            <div class="alert alert-danger alert-dismissible fade show">
                                <?php 
                                echo htmlspecialchars($_SESSION['error']); 
                                unset($_SESSION['error']);
                                ?>
                                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                            </div>
                        <?php endif; ?>
                        
                        <form id="createAdminForm" action="create_admin.php" method="POST" novalidate>
                            <div class="mb-3">
                                <label for="name" class="form-label">Full Name *</label>
                                <input type="text" class="form-control" id="name" name="name" required>
                                <div class="invalid-feedback">Please enter the full name.</div>
                            </div>
                            
                            <div class="mb-3">
                                <label for="email" class="form-label">Email Address *</label>
                                <input type="email" class="form-control" id="email" name="email" required>
                                <div class="invalid-feedback">Please enter a valid email address.</div>
                                <small class="form-text text-muted">This will be used for login.</small>
                            </div>
                            
                            <div class="mb-3">
                                <label for="password" class="form-label">Password *</label>
                                <input type="password" class="form-control" id="password" name="password" required>
                                <div class="invalid-feedback">Password must be at least 6 characters.</div>
                                <small class="form-text text-muted">Minimum 6 characters required.</small>
                            </div>
                            
                            <div class="mb-3">
                                <label for="confirm_password" class="form-label">Confirm Password *</label>
                                <input type="password" class="form-control" id="confirm_password" name="confirm_password" required>
                                <div class="invalid-feedback">Passwords do not match.</div>
                            </div>

                            <div class="mb-3">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="confirmCreate" required>
                                    <label class="form-check-label" for="confirmCreate">
                                        I confirm that I want to create a new administrator account
                                    </label>
                                </div>
                            </div>
                            
                            <div class="d-flex gap-2">
                                <button type="submit" class="btn btn-danger">
                                    <strong>🔐 Create Admin Account</strong>
                                </button>
                                <a href="dashboard.php" class="btn btn-secondary">Cancel</a>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- Info Card -->
                <div class="card mt-4 border-info">
                    <div class="card-body">
                        <h6 class="card-title text-info">ℹ️ Admin Account Guidelines</h6>
                        <ul class="mb-0 small">
                            <li>Only create admin accounts for trusted individuals</li>
                            <li>Use strong passwords (mix of letters, numbers, and symbols)</li>
                            <li>The new admin will be able to log in immediately after creation</li>
                            <li>Consider notifying the new admin via email separately</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="../js/validate.js"></script>
    <script>
        // Additional validation for the confirmation checkbox
        document.getElementById('createAdminForm').addEventListener('submit', function(e) {
            const checkbox = document.getElementById('confirmCreate');
            if (!checkbox.checked) {
                e.preventDefault();
                alert('Please confirm that you want to create a new admin account.');
                checkbox.focus();
            }
        });
    </script>
</body>
</html>