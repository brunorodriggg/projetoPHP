<?php
session_start();
if (!isset($_SESSION['usuario_id'])) {
    header("Location: index.php");
    exit();
}

require_once 'includes/conexao.php';

$usuario_id = $_SESSION['usuario_id'];
$login = "";

$sql = "SELECT login FROM usuarios WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $usuario_id);
$stmt->execute();
$stmt->bind_result($login);
$stmt->fetch();
?>

<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <title>Dashboard</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
  <div class="container mt-5">
    <div class="card p-4 shadow-sm">
      <h2 class="mb-4 text-center">Painel do Usuário</h2>
      <p class="text-center mb-4">Bem-vindo, <strong><?php echo htmlspecialchars($login); ?></strong>!</p>
      <div class="d-grid gap-3">
        <a href="novo_item.php" class="btn btn-primary btn-lg">Cadastrar novas tarefas</a>
        <a href="itens.php" class="btn btn-primary btn-lg">Ver minhas tarefas</a>
        <a href="logout.php" class="btn btn-primary btn-lg">Sair</a>
      </div>
    </div>
  </div>
</body>
</html>
