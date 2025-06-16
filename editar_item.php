<?php
require_once 'includes/conexao.php';
require_once 'includes/funcoes.php';
session_start();

if (!isset($_SESSION['usuario_id'])) {
    header("Location: index.php");
    exit();
}

$usuario_id = $_SESSION['usuario_id'];
$mensagem = "";
$item = null;

if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    echo "ID inválido.";
    exit();
}

$id = (int) $_GET['id'];

$sql = "SELECT titulo, descricao FROM itens WHERE id = ? AND usuario_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ii", $id, $usuario_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    echo "Item não encontrado ou acesso negado.";
    exit();
}

$item = $result->fetch_assoc();

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $titulo = limparEntrada($_POST['titulo']);
    $descricao = limparEntrada($_POST['descricao']);

    if (!empty($titulo)) {
        $sql = "UPDATE itens SET titulo = ?, descricao = ? WHERE id = ? AND usuario_id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssii", $titulo, $descricao, $id, $usuario_id);
        if ($stmt->execute()) {
            $mensagem = "Item atualizado com sucesso.";
            $item['titulo'] = $titulo;
            $item['descricao'] = $descricao;
        } else {
            $mensagem = "Erro ao atualizar o item.";
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
  <title>Editar Item</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
  <div class="container mt-5">
    <div class="card p-4 shadow-sm">
      <h2 class="mb-3">Editar Item</h2>
      <?php if ($mensagem): ?>
        <div class="alert alert-info"><?php echo $mensagem; ?></div>
      <?php endif; ?>
      <form method="post">
        <div class="mb-3">
          <label class="form-label">Título:</label>
          <input type="text" name="titulo" class="form-control" value="<?php echo htmlspecialchars($item['titulo']); ?>" required>
        </div>
        <div class="mb-3">
          <label class="form-label">Descrição:</label>
          <textarea name="descricao" class="form-control"><?php echo htmlspecialchars($item['descricao']); ?></textarea>
        </div>
        <button type="submit" class="btn btn-primary">Atualizar</button>
        <a href="itens.php" class="btn btn-secondary">Voltar</a>
      </form>
    </div>
  </div>
</body>
</html>
