<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title; ?></title>
    <!-- <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous"> -->
    <link rel="stylesheet" href="/bootstrap.min.css">
</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container">
            <a class="navbar-brand" href="<?= BASE_URL ?>">Home</a>
            <div class="navbar-nav">
                <a class="nav-link" href="<?= BASE_URL ?>books">Books</a>
            </div>
            <div class="navbar-nav">
                <?php if ($isAuthenticated): ?>
                    <a href="<?= BASE_URL ?>auth/profile" class="nav-link">Profile</a>
                    <a href="<?= BASE_URL ?>auth/logout" class="nav-link">Logout</a>
                <?php else: ?>
                    <a href="<?= BASE_URL ?>auth/login" class="nav-link">Login</a>
                    <a href="<?= BASE_URL ?>auth/register" class="nav-link">Register</a>
                <?php endif; ?>
            </div>
        </div>
    </nav>
    <div class="container mt-3">
        <?php if (!empty($flashSuccess)): ?>
            <div class="alert alert-success" role="alert"><?= htmlspecialchars($flashSuccess) ?></div>
        <?php endif; ?>

        <?php if (!empty($flashError)): ?>
            <div class="alert alert-danger" role="alert"><?= htmlspecialchars($flashError) ?></div>
        <?php endif; ?>
    </div>
    <!-- This line includes the PHP file located at '../app/views/' followed by the value of the $viewPath variable and '.php' extension. -->
    <?php require_once '../app/views/' . $viewPath . '.php'; ?>
</body>

</html>