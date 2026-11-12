<?php
$host = "localhost";
$dbname = "db_votingks";
$username = "root";
$password = "";

try {
    $pdo = new PDO(
        "mysql:host=$host;dbname=$dbname;charset=utf8mb4",
        $username,
        $password,
        [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES => false
        ]
    );
} catch (PDOException $e) {
    die("Koneksi database gagal. Pastikan database db_votingks sudah di-import melalui phpMyAdmin.");
}
if (session_status() === PHP_SESSION_NONE) session_start();

function e($value) {
    return htmlspecialchars((string)$value, ENT_QUOTES, 'UTF-8');
}
function is_logged_in() {
    return isset($_SESSION['user']);
}
function require_login() {
    if (!is_logged_in()) {
        header("Location: " . (str_contains($_SERVER['SCRIPT_NAME'], '/admin/') || str_contains($_SERVER['SCRIPT_NAME'], '/pemilih/') ? '../login.php' : 'login.php'));
        exit;
    }
}
function require_role($role) {
    require_login();
    if ($_SESSION['user']['role'] !== $role) {
        header("Location: " . ($_SESSION['user']['role'] === 'admin' ? 'admin/dashboard.php' : 'pemilih/dashboard.php'));
        exit;
    }
}
