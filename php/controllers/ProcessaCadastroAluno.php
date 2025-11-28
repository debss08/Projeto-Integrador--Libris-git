<?php
session_start();
require_once '../models/Aluno.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: ../../views/html/cadastro_aluno.php');
    exit();
}

$nome = trim($_POST['nome'] ?? '');
$cpf = trim($_POST['cpf'] ?? '');
$data_nascimento = $_POST['data_nascimento'] ?? '';
$matricula = trim($_POST['matricula'] ?? '');
$senha = $_POST['senha'] ?? '';

if (empty($nome) || empty($cpf) || empty($data_nascimento) || empty($matricula) || empty($senha)) {
    echo "<script>alert('Preencha todos os campos.'); history.back();</script>";
    exit();
}

$resultado = Aluno::cadastrar($nome, $cpf, $data_nascimento, $matricula, $senha);

if ($resultado === true) {
    echo "<script>alert('Cadastro realizado com sucesso! Faça seu login.'); window.location.href='../../views/html/login_aluno.php';</script>";
} else {
    if (strpos($resultado, '1062') !== false) { // 1062 = Erro de duplicidade
        echo "<script>alert('Erro: CPF ou Matrícula já cadastrados!'); history.back();</script>";
    } else {
        echo "<script>alert('Erro ao cadastrar: " . addslashes($resultado) . "'); history.back();</script>";
    }
}
?>