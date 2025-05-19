<?php
require 'config.php';

if (!isset($_SESSION['user_id'])) {
  header('Location: login.php');
  exit;
}

$user_id = $_SESSION['user_id'];

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['new_task'])) {
  $task = trim($_POST['new_task']);
  if (!empty($task)) {
    $stmt = $pdo->prepare("INSERT INTO tasks (user_id, title) VALUES (?, ?)");
    $stmt->execute([$user_id, $task]);
  }
  header('Location: tasks.php');
  exit;
}

if (isset($_GET['done'])) {
  $task_id = (int)$_GET['done'];
  $stmt = $pdo->prepare("UPDATE tasks SET is_done = NOT is_done WHERE id = ? AND user_id = ?");
  $stmt->execute([$task_id, $user_id]);
  header('Location: tasks.php');
  exit;
}

if (isset($_GET['delete'])) {
  $task_id = (int)$_GET['delete'];
  $stmt = $pdo->prepare("DELETE FROM tasks WHERE id = ? AND user_id = ?");
  $stmt->execute([$task_id, $user_id]);
  header('Location: tasks.php');
  exit;
}

$stmt = $pdo->prepare("SELECT * FROM tasks WHERE user_id = ? ORDER BY created_at DESC");
$stmt->execute([$user_id]);
$tasks = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html lang="ru">
<head>
  <meta charset="UTF-8">
  <title>Мои задачи</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
  <h2>Список задач</h2>

  <form method="post">
    <input type="text" name="new_task" placeholder="Новая задача" required>
    <button type="submit">Добавить</button>
  </form>

  <ul>
    <?php foreach ($tasks as $task): ?>
      <li>
        <span style="text-decoration: <?= $task['is_done'] ? 'line-through' : 'none' ?>">
          <?= htmlspecialchars($task['title']) ?>
        </span>
        <a href="?done=<?= $task['id'] ?>">Сделано</a>
        <a href="?delete=<?= $task['id'] ?>" onclick="return confirm('Удалить задачу?')">Удалить</a>
      </li>
    <?php endforeach; ?>
  </ul>

    <div class="links">
        <a href="profile.php">Профиль</a>
        <a href="logout.php">Выйти</a>
    </p>
    </div>
  </div>
</body>
</html>