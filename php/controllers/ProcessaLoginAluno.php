<?php
session_start();
require '../models/Conexao.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: ../login_aluno.php');
    exit();
}

$matricula = $_POST['matricula'] ?? '';
$senha = $_POST['senha'] ?? '';

if ($matricula === '' || $senha === '') {
    echo "<script>alert('Preencha todos os campos.'); history.back();</script>";
    exit();
}

try {
    $con = Conexao::getConexao();

    // 1. Encontrar o login pela matrícula
    $stmt = $con->prepare("SELECT * FROM Login WHERE matricula = :matricula");
    $stmt->bindParam(':matricula', $matricula);
    $stmt->execute();
    $login = $stmt->fetch(PDO::FETCH_ASSOC);

    // 2. Verificar senha E nível de acesso
    if ($login && password_verify($senha, $login['senha_hash']) && $login['nivel'] === 'usuario') {
        
        // 3. Buscar nome e ID do aluno na tabela 'cad_alunos'
        $stmtAluno = $con->prepare("SELECT id, nome FROM cad_alunos WHERE login_id = :login_id");
        $stmtAluno->bindParam(':login_id', $login['id']);
        $stmtAluno->execute();
        $aluno = $stmtAluno->fetch();

        if (!$aluno) {
             echo "<script>alert('Erro: Conta de usuário não encontrada. Contate o admin.'); history.back();</script>";
             exit;
        }

        // 4. Criar a Sessão de ALUNO
        $_SESSION['aluno_id'] = $aluno['id']; // ID da tabela cad_alunos (ESSENCIAL p/ empréstimos)
        $_SESSION['aluno_nome'] = $aluno['nome'];
        $_SESSION['nivel'] = $login['nivel'];

        header("Location: ../area_aluno.php"); // Redireciona para o dashboard do aluno
        exit();
    } else {
        echo "<script>alert('Matrícula ou senha incorretas!'); history.back();</script>";
    }
} catch (PDOException $e) {
    echo "<script>alert('Erro no banco de dados.'); history.back();</script>";
}
?>