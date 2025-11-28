<?php
session_start();
require '../models/Conexao.php';

// Proteção: Apenas Admins podem usar este formulário
if (!isset($_SESSION['admin_id'])) {
    echo "<script>alert('Acesso negado.'); window.location.href='../html/login_admin.html';</script>";
    exit();
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $id_livro = (int)$_POST['id_livro'];
    $id_aluno = (int)$_POST['id_aluno'];
    $data_retirada = $_POST['data_retirada'];
    $data_devolucao = $_POST['data_devolucao']
    if (empty($id_livro) || empty($id_aluno) || empty($data_retirada) || empty($data_devolucao)) {
        echo "<script>alert('Preencha todos os campos obrigatórios.'); history.back();</script>";
        exit;
    }

    $con = Conexao::getConexao();
    $con->beginTransaction();

    try {
        // 1. Verificar se o aluno existe
        $stmtAluno = $con->prepare("SELECT id FROM cad_alunos WHERE id = :id_aluno");
        $stmtAluno->bindParam(':id_aluno', $id_aluno);
        $stmtAluno->execute();
        if ($stmtAluno->rowCount() == 0) {
            throw new Exception("ID do Aluno não encontrado.");
        }

        // 2. Verificar estoque do livro
        $stmtEstoque = $con->prepare("SELECT quantidade_disponivel FROM cad_acervo WHERE id_livro = :id_livro FOR UPDATE");
        $stmtEstoque->bindParam(':id_livro', $id_livro);
        $stmtEstoque->execute();
        
        if ($stmtEstoque->rowCount() == 0) {
            throw new Exception("ID do Livro não encontrado no acervo.");
        }
        
        $estoque = $stmtEstoque->fetch();

        if ($estoque['quantidade_disponivel'] <= 0) {
            throw new Exception("Livro indisponível no momento.");
        }

        // 3. Registrar o empréstimo
        $sql = "INSERT INTO cad_emprestimos (id_livro, id_aluno, data_retirada, data_devolucao)
                VALUES (:id_livro, :id_aluno, :data_retirada, :data_devolucao)";
        $stmt = $con->prepare($sql);
        $stmt->bindParam(':id_livro', $id_livro);
        $stmt->bindParam(':id_aluno', $id_aluno);
        $stmt->bindParam(':data_retirada', $data_retirada);
        $stmt->bindParam(':data_devolucao', $data_devolucao);
        $stmt->execute();

        $stmtUpdate = $con->prepare("UPDATE cad_acervo SET quantidade_disponivel = quantidade_disponivel - 1 WHERE id_livro = :id_livro");
        $stmtUpdate->bindParam(':id_livro', $id_livro);
        $stmtUpdate->execute();

        $con->commit();

        echo "<script>alert('Empréstimo registrado com sucesso!'); window.location.href='../html/emprestimos.php';</script>";
    
    } catch (Exception $e) {
        $con->rollBack();
        echo "<script>alert('Erro ao registrar empréstimo: " . addslashes($e->getMessage()) . "'); history.back();</script>";
    }
}
?>