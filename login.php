<?php
require 'config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $email = trim($_POST['email']);
  $password = $_POST['password'];

  $stmt = $pdo->prepare("SELECT * FROM users WHERE email = ?");
  $stmt->execute([$email]);
  $user = $stmt->fetch();

  if ($user && password_verify($password, $user['password'])) {
    $_SESSION['user_id'] = $user['id'];
    header('Location: tasks.php');
    exit;
  } else {
    $error = "Неверный email или пароль";
  }
}
?>

<!DOCTYPE html>
<html lang="ru">
<head>
  <meta charset="UTF-8">
  <title>Вход</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="style.css">
</head>
<body>
  <div class="container">
    <h2>Вход</h2>
    <form class="form-reg" method="post">
      <input type="email" name="email" placeholder="Email" required>
      <input type="password" name="password" placeholder="Пароль" required>
      <button class="btn-reg" type="submit">Войти</button>
      <?php if (!empty($error)) echo "<p>$error</p>"; ?>
    </form>
    <div class="links-reg">
      <p>Нет аккаунта? <a href="register.php">Зарегистрироваться</a></p>
    </div>
  </div>
</body>
</html>