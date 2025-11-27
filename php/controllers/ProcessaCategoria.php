<?php
session_start();
require_once "../models/Conexao.php";
header('Content-Type: application/json'); // Informa que a resposta é JSON

// Proteção: Apenas Admins
if (!isset($_SESSION['admin_id'])) {
    echo json_encode(['success' => false, 'message' => 'Acesso negado.']);
    exit();
}

if (isset($_POST['nome_categoria'])) {
    $nome = trim($_POST['nome_categoria']);
    if (empty($nome)) {
        echo json_encode(['success' => false, 'message' => 'O nome não pode ser vazio.']);
        exit();
    }

    try {
        $con = Conexao::getConexao();
        
        // Verifica se já existe
        $stmtCheck = $con->prepare("SELECT id FROM cad_categorias WHERE nome_categoria = :nome");
        $stmtCheck->bindParam(':nome', $nome);
        $stmtCheck->execute();
        if ($stmtCheck->rowCount() > 0) {
            echo json_encode(['success' => false, 'message' => 'Esta categoria já existe.']);
            exit();
        }
        
        // Insere a nova categoria
        $stmt = $con->prepare("INSERT INTO cad_categorias (nome_categoria) VALUES (:nome)");
        $stmt->bindParam(':nome', $nome);
        $stmt->execute();
        
        $novoId = $con->lastInsertId();
        
        // Retorna sucesso e os dados da nova categoria
        echo json_encode([
            'success' => true, 
            'message' => 'Categoria adicionada!',
            'id' => $novoId,
            'nome' => $nome
        ]);

    } catch (PDOException $e) {
        echo json_encode(['success' => false, 'message' => 'Erro de banco de dados: ' . $e->getMessage()]);
    }
    
} else {
    echo json_encode(['success' => false, 'message' => 'Dados inválidos.']);
}
?>