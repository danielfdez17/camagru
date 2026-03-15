<?php

class AuthController extends Controller
{
    private $userModel;

    public function __construct()
    {
        $this->userModel = $this->loadModel('User');
    }

    public function login()
    {
        if (SessionManager::isAuthenticated()) {
            header('Location: ' . BASE_URL . 'auth/profile');
            return;
        }

        $error = null;
        $identity = SessionManager::getCookie('last_login_identity', '');

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $identity = trim($_POST['identity'] ?? '');
            $password = $_POST['password'] ?? '';

            if ($identity === '' || $password === '') {
                $error = 'Username/email and password are required.';
                $this->renderView('Auth/Login', ['error' => $error, 'identity' => $identity], 'Login');
                return;
            }

            $authUser = $this->userModel->verifyCredentials($identity, $password);

            if ($authUser !== false) {
                SessionManager::login($authUser);
                SessionManager::setCookie('last_login_identity', $identity, time() + (60 * 60 * 24 * 30));
                SessionManager::flash('success', 'Welcome back, ' . $authUser['username'] . '.');
                header('Location: ' . BASE_URL . 'auth/profile');
                return;
            }

            $error = 'Invalid username/email or password.';
        }

        $this->renderView('Auth/Login', ['error' => $error, 'identity' => $identity], 'Login');
    }

    public function register()
    {
        if (SessionManager::isAuthenticated()) {
            header('Location: ' . BASE_URL . 'auth/profile');
            return;
        }

        $errors = [];
        $formData = [
            'username' => '',
            'email' => '',
        ];

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $formData['username'] = trim($_POST['username'] ?? '');
            $formData['email'] = trim($_POST['email'] ?? '');
            $password = $_POST['password'] ?? '';
            $passwordConfirm = $_POST['password_confirm'] ?? '';

            if ($formData['username'] === '' || $formData['email'] === '' || $password === '') {
                $errors[] = 'Username, email, and password are required.';
            }

            if ($formData['email'] !== '' && !filter_var($formData['email'], FILTER_VALIDATE_EMAIL)) {
                $errors[] = 'Please provide a valid email address.';
            }

            if ($password !== '' && strlen($password) < 8) {
                $errors[] = 'Password must be at least 8 characters.';
            }

            if ($password !== $passwordConfirm) {
                $errors[] = 'Password confirmation does not match.';
            }

            if ($formData['username'] !== '' && $this->userModel->usernameExists($formData['username'])) {
                $errors[] = 'Username is already taken.';
            }

            if ($formData['email'] !== '' && $this->userModel->emailExists($formData['email'])) {
                $errors[] = 'Email is already registered.';
            }

            if (empty($errors)) {
                $created = false;
                try {
                    $created = $this->userModel->createUser($formData['username'], $formData['email'], $password);
                } catch (Throwable $e) {
                    $errors[] = 'Registration failed. Please try again.';
                }

                if (!$created) {
                    $errors[] = 'Registration failed. Please try again.';
                }
            }

            if (empty($errors)) {
                $authUser = $this->userModel->findByUsernameOrEmail($formData['username']);

                if (!$authUser) {
                    $errors[] = 'Registration completed, but login initialization failed. Please login manually.';
                    $this->renderView('Auth/Register', ['errors' => $errors, 'formData' => $formData], 'Register');
                    return;
                }

                SessionManager::login($authUser);
                SessionManager::setCookie('last_login_identity', $formData['username'], time() + (60 * 60 * 24 * 30));
                SessionManager::flash('success', 'Your account has been created successfully.');
                header('Location: ' . BASE_URL . 'auth/profile');
                return;
            }
        }

        $this->renderView('Auth/Register', ['errors' => $errors, 'formData' => $formData], 'Register');
    }

    public function logout()
    {
        SessionManager::logout();
        header('Location: ' . BASE_URL . 'auth/login');
        return;
    }

    public function profile()
    {
        if (!SessionManager::isAuthenticated()) {
            SessionManager::flash('error', 'Please login to access your profile.');
            header('Location: ' . BASE_URL . 'auth/login');
            return;
        }

        $sessionUser = SessionManager::user();
        $user = $this->userModel->findById($sessionUser['id']);

        if (!$user) {
            SessionManager::logout();
            header('Location: ' . BASE_URL . 'auth/login');
            return;
        }

        $errors = [];

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $username = trim($_POST['username'] ?? '');
            $email = trim($_POST['email'] ?? '');
            $newPassword = $_POST['new_password'] ?? '';
            $newPasswordConfirm = $_POST['new_password_confirm'] ?? '';

            if ($username === '' || $email === '') {
                $errors[] = 'Username and email are required.';
            }

            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $errors[] = 'Please provide a valid email address.';
            }

            if ($this->userModel->usernameExists($username, $user['id'])) {
                $errors[] = 'Username is already taken.';
            }

            if ($this->userModel->emailExists($email, $user['id'])) {
                $errors[] = 'Email is already registered.';
            }

            if ($newPassword !== '' && strlen($newPassword) < 8) {
                $errors[] = 'New password must be at least 8 characters.';
            }

            if ($newPassword !== $newPasswordConfirm) {
                $errors[] = 'New password confirmation does not match.';
            }

            if (empty($errors)) {
                $this->userModel->updateProfile(
                    $user['id'],
                    $username,
                    $email,
                    $newPassword === '' ? null : $newPassword
                );

                SessionManager::login([
                    'id' => $user['id'],
                    'username' => $username,
                    'email' => $email,
                ]);

                SessionManager::flash('success', 'Profile updated successfully.');
                header('Location: ' . BASE_URL . 'auth/profile');
                return;
            }

            $user['username'] = $username;
            $user['email'] = $email;
        }

        $this->renderView('Auth/Profile', ['user' => $user, 'errors' => $errors], 'Profile');
    }
}

?>