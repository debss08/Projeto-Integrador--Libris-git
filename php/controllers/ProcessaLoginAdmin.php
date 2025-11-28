<?php
session_start();
require '../models/Conexao.php'; 

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: ../../views/html/login_admin.html'); 
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

    if ($login && password_verify($senha, $login['senha_hash']) && $login['nivel'] == 'admin') {
        
        // Busca o nome completo do funcionário (Admin) na tabela de funcionários
        $stmtFunc = $con->prepare("SELECT nome FROM cad_funcionarios WHERE login_id = :login_id");
        $stmtFunc->bindParam(':login_id', $login['id']);
        $stmtFunc->execute();
        $funcionario = $stmtFunc->fetch();

        $_SESSION['admin_id'] = $login['id']; // CORRIGIDO: Agora usa 'id'
        $_SESSION['nome'] = $funcionario['nome'] ?? 'Admin'; // CORRIGIDO: Agora usa 'nome'
        $_SESSION['nivel'] = $login['nivel']; 

        // Redireciona para o painel principal
        header("Location: ../../views/html/inicio.php"); 
        exit();
    } else {
         // Se a falha for de credenciais ou nível incorreto
         echo "<script>alert('Matrícula ou senha incorretas, ou usuário não é administrador!'); history.back();</script>";
         exit();
    }
} catch (PDOException $e) {
    // Loga o erro real (para você ver no log do servidor) e exibe uma mensagem genérica.
    error_log("Erro no ProcessaLoginAdmin: " . $e->getMessage()); 
    echo "<script>alert('Erro no banco de dados. Tente novamente mais tarde.'); history.back();</script>";
    exit();
}
?>