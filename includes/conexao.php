<?php
$host = '127.0.0.1';
$user = 'root';
$senha = '';
$banco = 'projeto_php';
$conn = new mysqli($host, $user, $senha, $banco);
if ($conn->connect_error) { die('Erro: ' . $conn->connect_error); }
?>