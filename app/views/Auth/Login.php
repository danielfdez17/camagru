<div class="container mt-5">
    <h1>Login</h1>

    <?php if (!empty($error)): ?>
        <div class="alert alert-danger" role="alert"><?= htmlspecialchars($error) ?></div>
    <?php endif; ?>

    <form class="mb-3" action="" method="post">
        <div>
            <label class="form-label" for="identity">Username or Email:</label>
            <input class="form-control" type="text" id="identity" name="identity" value="<?= htmlspecialchars($identity ?? '') ?>" required>
        </div>
        <div>
            <label class="form-label" for="password">Password:</label>
            <input class="form-control" type="password" id="password" name="password" required>
        </div>
        <button type="submit" class="btn btn-primary mt-3">Login</button>
    </form>
    <a href="<?= BASE_URL ?>auth/register">Create an account</a>
</div>