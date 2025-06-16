<?php
require_once 'includes/conexao.php';
require_once 'includes/funcoes.php';
session_start();

$mensagem = "";

if (isset($_SERVER["REQUEST_METHOD"]) && $_SERVER["REQUEST_METHOD"] === "POST") {
    $login = limparEntrada($_POST['login']);
    $email = limparEntrada($_POST['email']);
    $senha = password_hash($_POST['senha'], PASSWORD_DEFAULT);

    // Verificar duplicidade
    $sql = "SELECT id FROM usuarios WHERE login = ? OR email = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ss", $login, $email);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        $mensagem = "Login ou e-mail já cadastrado.";
    } else {
        $sql = "INSERT INTO usuarios (login, senha, email) VALUES (?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sss", $login, $senha, $email);
        if ($stmt->execute()) {
            $mensagem = "Usuário cadastrado com sucesso. <a href='index.php'>Fazer login</a>";
        } else {
            $mensagem = "Erro ao cadastrar.";
        }
    }
}
?>

<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <title>Cadastro</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
  <div class="container mt-5">
    <div class="row justify-content-center">
      <div class="col-md-5">
        <div class="card shadow">
          <div class="card-body">
            <h2 class="text-center mb-4">Cadastro</h2>
            <?php if (!empty($mensagem)): ?>
              <div class="alert alert-info"><?php echo $mensagem; ?></div>
            <?php endif; ?>
            <form method="post">
              <div class="mb-3">
                <label class="form-label">Login:</label>
                <input type="text" name="login" class="form-control" required>
              </div>
              <div class="mb-3">
                <label class="form-label">Email:</label>
                <input type="email" name="email" class="form-control" required>
              </div>
              <div class="mb-3">
                <label class="form-label">Senha:</label>
                <input type="password" name="senha" class="form-control" required>
              </div>
              <button type="submit" class="btn btn-primary w-100">Cadastrar</button>
            </form>
            <p class="mt-3 text-center">
              <a href="index.php">Já tem conta? Fazer login</a>
            </p>
          </div>
        </div>
      </div>
    </div>
  </div>
</body>
</html>
