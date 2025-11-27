<?php
session_start();
require '../models/Conexao.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: ../views/html/cadastro.html');
    exit();
}

$nome = trim($_POST['nome'] ?? '');
$cpf = trim($_POST['cpf'] ?? '');
$data_nascimento = $_POST['data_nascimento'] ?? '';
$matricula = trim($_POST['matricula'] ?? '');
$senha = $_POST['senha'] ?? '';

if ($nome === '' || $cpf === '' || $data_nascimento === '' || $matricula === '' || $senha === '') {
    echo "<script>alert('Preencha todos os campos.'); history.back();</script>";
    exit();
}

$hash = password_hash($senha, PASSWORD_DEFAULT);
$nivel = 'usuario'; 

$con = Conexao::getConexao();

$stmtCheck = $con->prepare("SELECT id FROM Login WHERE cpf = :cpf OR matricula = :matricula");
$stmtCheck->bindParam(':cpf', $cpf);
$stmtCheck->bindParam(':matricula', $matricula);
$stmtCheck->execute();

if ($stmtCheck->rowCount() > 0) {
    echo "<script>alert('CPF ou matrícula já cadastrados!'); history.back();</script>";
    exit();
}

$stmt = $con->prepare("INSERT INTO Login (nome, cpf, data_nascimento, matricula, senha_hash, nivel)
                       VALUES (:nome, :cpf, :data_nascimento, :matricula, :senha, :nivel)");
$stmt->bindParam(':nome', $nome);
$stmt->bindParam(':cpf', $cpf);
$stmt->bindParam(':data_nascimento', $data_nascimento);
$stmt->bindParam(':matricula', $matricula);
$stmt->bindParam(':senha', $hash);
$stmt->bindParam(':nivel', $nivel);

if ($stmt->execute()) {
    echo "<script>alert('Cadastro realizado com sucesso!'); window.location.href='../html/login.html';</script>";
} else {
    echo "<script>alert('Erro ao cadastrar usuário.'); history.back();</script>";
}
?>
