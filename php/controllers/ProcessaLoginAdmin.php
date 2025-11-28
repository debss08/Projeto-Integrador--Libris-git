<?php
session_start();
require_once '../models/Conexao.php'; // Caminho ajustado

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: ../../views/html/login_admin.html'); // Caminho ajustado
    exit();
}

$matricula = trim($_POST['matricula'] ?? '');
$senha = trim($_POST['senha'] ?? '');

if ($matricula === '' || $senha === '') {
    echo "<script>alert('Preencha todos os campos.'); history.back();</script>";
    exit();
}

try {
    $con = Conexao::getConexao();
    $stmt = $con->prepare("SELECT * FROM Login WHERE matricula = :matricula");
    $stmt->bindParam(':matricula', $matricula);
    $stmt->execute();
    $login = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($login && password_verify($senha, $login['senha_hash']) && $login['nivel'] === 'admin') {
        $stmtFunc = $con->prepare("SELECT nome FROM cad_funcionarios WHERE login_id = :login_id");
        $stmtFunc->bindParam(':login_id', $login['id']);
        $stmtFunc->execute();
        $funcionario = $stmtFunc->fetch();

        $_SESSION['admin_id'] = $login['id'];
        $_SESSION['admin_nome'] = $funcionario['nome'] ?? 'Admin';
        $_SESSION['nivel'] = $login['nivel'];

        header("Location: ../../views/html/inicio.php"); // Caminho ajustado
        exit();
    } else {
        echo "<script>alert('Matrícula ou senha incorretas!'); history.back();</script>";
    }
} catch (PDOException $e) {
    echo "<script>alert('Erro no banco de dados.'); history.back();</script>";
}
?>