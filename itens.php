<?php
require_once 'includes/conexao.php';
require_once 'includes/funcoes.php';
session_start();

if (!isset($_SESSION['usuario_id'])) {
    header("Location: index.php");
    exit();
}

$usuario_id = $_SESSION['usuario_id'];
$sql = "SELECT id, titulo, descricao, data_criacao FROM itens WHERE usuario_id = ? ORDER BY data_criacao DESC";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $usuario_id);
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <title>Meus Itens</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
  <div class="container mt-5">
    <div class="card p-4 shadow-sm">
      <h2 class="mb-4">Suas tarefas</h2>
      <a href="novo_item.php" class="btn btn-primary btn-lg">+ Nova tarefa</a>
      <table class="table table-striped">
        <thead>
          <tr>
            <th>Título</th>
            <th>Descrição</th>
            <th>Data</th>
            <th>Ações</th>
          </tr>
        </thead>
        <tbody>
          <?php while ($row = $result->fetch_assoc()): ?>
          <tr>
            <td><?php echo htmlspecialchars($row['titulo']); ?></td>
            <td><?php echo htmlspecialchars($row['descricao']); ?></td>
            <td><?php echo $row['data_criacao']; ?></td>
            <td>
              <a href="editar_item.php?id=<?php echo $row['id']; ?>" class="btn btn-sm btn-warning">Editar</a>
              <a href="excluir_item.php?id=<?php echo $row['id']; ?>" class="btn btn-sm btn-danger" onclick="return confirm('Deseja realmente excluir?');">Excluir</a>
            </td>
          </tr>
          <?php endwhile; ?>
        </tbody>
      </table>
      <a href="dashboard.php" class="btn btn-secondary">Voltar</a>
    </div>
  </div>
</body>
</html>
