<div class="container mt-5">
    <h1>Register</h1>

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
            <input class="form-control" type="text" id="username" name="username" value="<?= htmlspecialchars($formData['username'] ?? '') ?>" required>
        </div>
        <div>
            <label class="form-label" for="email">Email:</label>
            <input class="form-control" type="email" id="email" name="email" value="<?= htmlspecialchars($formData['email'] ?? '') ?>" required>
        </div>
        <div>
            <label class="form-label" for="password">Password:</label>
            <input class="form-control" type="password" id="password" name="password" required>
        </div>
        <div>
            <label class="form-label" for="password_confirm">Confirm Password:</label>
            <input class="form-control" type="password" id="password_confirm" name="password_confirm" required>
        </div>
        <button type="submit" class="btn btn-primary mt-3">Register</button>
    </form>
    <a href="<?= BASE_URL ?>auth/login">Already have an account? Login</a>
</div>
