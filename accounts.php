<?php
// Подключение к базе данных
$host = 'localhost';
$db   = 'bufik_db';
$user = 'root';
$pass = '';
$charset = 'utf8mb4';

$dsn = "mysql:host=$host;dbname=$db;charset=$charset";
$opt = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES   => false,
];
$pdo = new PDO($dsn, $user, $pass, $opt);

// Функция для создания нового аккаунта
function createAccount($username, $password) {
    global $pdo;

    // Проверка на существующее имя пользователя
    $stmt = $pdo->prepare('SELECT * FROM accounts WHERE username = ?');
    $stmt->execute([$username]);
    $user = $stmt->fetch();

    if ($user) {
        return false; // Имя пользователя уже занято
    }

    // Хеширование пароля
    $passwordHash = password_hash($password, PASSWORD_DEFAULT);

    // Добавление нового аккаунта в базу данных
    $stmt = $pdo->prepare('INSERT INTO accounts (username, password) VALUES (?, ?)');
    $stmt->execute([$username, $passwordHash]);

    return true;
}

// Функция для проверки аккаунта
function checkAccount($username, $password) {
    global $pdo;

    // Получение аккаунта из базы данных
    $stmt = $pdo->prepare('SELECT * FROM accounts WHERE username = ?');
    $stmt->execute([$username]);
    $user = $stmt->fetch();

    if ($user && password_verify($password, $user['password'])) {
        return true; // Аутентификация успешна
    }

    return false; // Неверное имя пользователя или пароль
}
?>