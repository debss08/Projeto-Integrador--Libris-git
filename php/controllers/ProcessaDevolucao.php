<?php
session_start();
require '../models/Conexao.php';

if (!isset($_SESSION['admin_id'])) {
    die("Acesso negado.");
}

if (!isset($_GET['id_emprestimo'])) {
    die("ID do empréstimo não fornecido.");
}

$id_emprestimo = (int)$_GET['id_emprestimo'];
$data_hoje = date('Y-m-d');

$con = Conexao::getConexao();
$con->beginTransaction();

try {
    $stmtLivro = $con->prepare("SELECT id_livro FROM cad_emprestimos WHERE id = :id_emprestimo AND data_devolucao IS NULL");
    $stmtLivro->bindParam(':id_emprestimo', $id_emprestimo);
    $stmtLivro->execute();
    
    $emprestimo = $stmtLivro->fetch();
    if (!$emprestimo) {
        throw new Exception("Empréstimo já devolvido ou não encontrado.");
    }
    $id_livro = $emprestimo['id_livro'];

    $stmtDev = $con->prepare("UPDATE cad_emprestimos SET data_devolucao = :data_hoje WHERE id = :id_emprestimo");
    $stmtDev->bindParam(':data_hoje', $data_hoje);
    $stmtDev->bindParam(':id_emprestimo', $id_emprestimo);
    $stmtDev->execute();

    $stmtEstoque = $con->prepare("UPDATE cad_acervo SET quantidade_disponivel = quantidade_disponivel + 1 WHERE id_livro = :id_livro");
    $stmtEstoque->bindParam(':id_livro', $id_livro);
    $stmtEstoque->execute();

    $con->commit();

    echo "<script>alert('Devolução registrada com sucesso!'); window.location.href='../html/emprestimos.php';</script>";

} catch (Exception $e) {
    $con->rollBack();
    echo "<script>alert('Erro ao registrar devolução: " . addslashes($e->getMessage()) . "'); history.back();</script>";
}
?>