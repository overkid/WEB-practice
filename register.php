<?php
require 'config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $email = trim($_POST['email']);
  $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

  $stmt = $pdo->prepare("INSERT INTO users (email, password) VALUES (?, ?)");

  try {
    $stmt->execute([$email, $password]);
    header('Location: login.php');
    exit;
  } catch (PDOException $e) {
    $error = "Пользователь с таким email уже существует.";
  }
}
?>

<!DOCTYPE html>
<html lang="ru">
<head>
  <meta charset="UTF-8">
  <title>Регистрация</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="style.css">
</head>
<body>
  <div class="container">
  <h2>Регистрация</h2>
  <form method="post">
    <input type="email" name="email" placeholder="Email" required>
    <input type="password" name="password" placeholder="Пароль" required>
    <button type="submit">Зарегистрироваться</button>
    <?php if (!empty($error)) echo "<p>$error</p>"; ?>
  </form>
  <div class="links">
    <p>Уже есть аккаунт? <a href="login.php">Войти</a></p>
  </div>
  </div>
</body>
</html>