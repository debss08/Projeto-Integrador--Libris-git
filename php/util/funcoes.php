<?php
session_start();

function check_admin_session() {
    if (!isset($_SESSION['admin_id']) || $_SESSION['nivel'] !== 'admin') {
        // Ajuste o caminho conforme sua estrutura
        header("Location: ../../views/html/login_admin.html"); 
        exit();
    }
}

function check_aluno_session() {
    if (!isset($_SESSION['aluno_id']) || $_SESSION['nivel'] !== 'usuario') {
        // Ajuste o caminho conforme sua estrutura
        header("Location: ../../views/html/login_aluno.php");
        exit();
    }
}
?>