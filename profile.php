<?php
require 'config.php';

// Проверка авторизации
if (!isset($_SESSION['user_id'])) {
  header('Location: login.php');
  exit;
}

// Получение данных пользователя
$user_id = $_SESSION['user_id'];
$stmt = $pdo->prepare("SELECT * FROM users WHERE id = ?");
$stmt->execute([$user_id]);
$user = $stmt->fetch();
?>

<!DOCTYPE html>
<html lang="ru">
<head>
  <meta charset="UTF-8">
  <title>Профиль</title>
  <link rel="stylesheet" href="style.css">
</head>
<body>
  <div class="container">
    <h2>Профиль</h2>

    <p><strong>ID:</strong> <?= $user['id'] ?></p>
    <p><strong>Email:</strong> <?= htmlspecialchars($user['email']) ?></p>
    <p><strong>Дата регистрации:</strong> <?= $user['created_at'] ?></p>

    <div class="links">
      <a href="tasks.php">Назад к задачам</a>
      <a href="logout.php">Выйти</a>
    </div>
  </div>
</body>
</html>