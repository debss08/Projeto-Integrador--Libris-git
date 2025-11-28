<?php
session_start();
require_once "../models/Conexao.php";
require_once "../models/Emprestimo.php";

// Se o aluno não estiver logado
if (!isset($_SESSION['aluno_id'])) {
    echo "<script>alert('Você precisa estar logado para retirar um livro.'); 
          window.location.href='../../views/html/login_aluno.php';</script>";
    exit();
}

// Verificar se o ID do livro foi passado
if (!isset($_GET['id_livro'])) {
    echo "<script>alert('Livro inválido.'); history.back();</script>";
    exit();
}

$id_livro = (int) $_GET['id_livro'];
$id_aluno = (int) $_SESSION['aluno_id'];

// Data da retirada: hoje
$data_retirada = date('Y-m-d');

// Data de devolução: 7 dias depois
$data_devolucao = date('Y-m-d', strtotime('+7 days'));

$resultado = Emprestimo::criar($id_livro, $id_aluno, $data_retirada, $data_devolucao);

// Se retornar TRUE → sucesso
if ($resultado === true) {
    echo "<script>
            alert('Empréstimo realizado com sucesso! Devolução até: $data_devolucao');
            window.location.href='../../views/html/area_aluno.php';
          </script>";
} else {
    // Se retornar texto → erro
    echo "<script>
            alert('Erro ao retirar livro: " . addslashes($resultado) . "');
            history.back();
          </script>";
}
?>
