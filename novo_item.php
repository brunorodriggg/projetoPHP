<?php
require_once 'includes/conexao.php';
require_once 'includes/funcoes.php';
session_start();

if (!isset($_SESSION['usuario_id'])) {
    header("Location: index.php");
    exit();
}

$mensagem = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $titulo = limparEntrada($_POST['titulo']);
    $descricao = limparEntrada($_POST['descricao']);
    $usuario_id = $_SESSION['usuario_id'];

    if (!empty($titulo)) {
        $sql = "INSERT INTO itens (usuario_id, titulo, descricao) VALUES (?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("iss", $usuario_id, $titulo, $descricao);
        if ($stmt->execute()) {
            $mensagem = "Item cadastrado com sucesso.";
        } else {
            $mensagem = "Erro ao cadastrar o item.";
        }
    } else {
        $mensagem = "O título é obrigatório.";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <title>Novo Item</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
  <div class="container mt-5">
    <div class="card p-4 shadow-sm">
      <h2 class="mb-3">Gerenciador de tarefas</h2>
      <?php if ($mensagem): ?>
        <div class="alert alert-info"><?php echo $mensagem; ?></div>
      <?php endif; ?>
      <form method="post">
        <div class="mb-3">
          <label class="form-label">Título:</label>
          <input type="text" name="titulo" class="form-control" required>
        </div>
         <div class="mb-3">
          <label class="form-label">Descrição:</label>
          <textarea name="descricao" class="form-control"></textarea>
        </div>
        <button type="submit" class="btn btn-primary">Salvar</button>
        <a href="dashboard.php" class="btn btn-secondary">Voltar</a>
      </form>
    </div>
  </div>
</body>
</html>
