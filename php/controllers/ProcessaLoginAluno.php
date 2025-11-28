<?php
session_start();
require_once '../models/Aluno.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: ../../views/html/login_aluno.php');
    exit();
}

$matricula = trim($_POST['matricula'] ?? '');
$senha = trim($_POST['senha'] ?? '');

if (empty($matricula) || empty($senha)) {
    echo "<script>alert('Preencha todos os campos.'); history.back();</script>";
    exit();
}

try {
    $aluno = Aluno::buscarPorMatricula($matricula);

    if ($aluno && password_verify($senha, $aluno['senha_hash'])) {
        // Criar a Sessão de ALUNO
        $_SESSION['aluno_id'] = $aluno['aluno_id']; // ID da tabela cad_alunos
        $_SESSION['aluno_login_id'] = $aluno['login_id']; // ID da tabela Login
        $_SESSION['aluno_nome'] = $aluno['nome'];
        $_SESSION['nivel'] = $aluno['nivel'];

        header("Location: ../../views/html/area_aluno.php"); // Redireciona para o dashboard do aluno
        exit();
    } else {
        echo "<script>alert('Matrícula ou senha incorretas!'); history.back();</script>";
    }
} catch (PDOException $e) {
    echo "<script>alert('Erro no banco de dados.'); history.back();</script>";
}
?>