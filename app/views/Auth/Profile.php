<div class="container mt-5">
    <h1>Edit Profile</h1>

    <?php if (!empty($errors)): ?>
        <div class="alert alert-danger" role="alert">
            <ul class="mb-0">
                <?php foreach ($errors as $error): ?>
                    <li><?= htmlspecialchars($error) ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
    <?php endif; ?>

    <form class="mb-3" action="" method="post">
        <div>
            <label class="form-label" for="username">Username:</label>
            <input class="form-control" type="text" id="username" name="username" value="<?= htmlspecialchars($user['username']) ?>" required>
        </div>
        <div>
            <label class="form-label" for="email">Email:</label>
            <input class="form-control" type="email" id="email" name="email" value="<?= htmlspecialchars($user['email']) ?>" required>
        </div>
        <div>
            <label class="form-label" for="new_password">New Password (optional):</label>
            <input class="form-control" type="password" id="new_password" name="new_password">
        </div>
        <div>
            <label class="form-label" for="new_password_confirm">Confirm New Password:</label>
            <input class="form-control" type="password" id="new_password_confirm" name="new_password_confirm">
        </div>
        <button type="submit" class="btn btn-primary mt-3">Save Profile</button>
    </form>
</div>
