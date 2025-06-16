<?php
require_once 'includes/conexao.php';
session_start();

if (!isset($_SESSION['usuario_id'])) {
    header("Location: index.php");
    exit();
}

$usuario_id = $_SESSION['usuario_id'];

if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    echo "ID inválido.";
    exit();
}

$id = (int) $_GET['id'];

// Verifica se o item pertence ao usuário antes de excluir
$sql = "DELETE FROM itens WHERE id = ? AND usuario_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ii", $id, $usuario_id);

if ($stmt->execute()) {
    header("Location: itens.php");
    exit();
} else {
    echo "Erro ao excluir item.";
}
