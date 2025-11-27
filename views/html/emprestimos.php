<?php
session_start();
if (!isset($_SESSION['admin_id'])) {
    header("Location: ../html/login_admin.html");
    exit();
}
require_once "../php/conexao.php";

$con = Conexao::getConexao();

$sql_ativos = "SELECT 
                    e.id AS id_emprestimo,
                    l.titulo, 
                    a.nome AS nome_aluno,
                    e.data_retirada
                FROM cad_emprestimos e
                JOIN cad_livros l ON e.id_livro = l.id
                JOIN cad_alunos a ON e.id_aluno = a.id
                WHERE e.data_devolucao IS NULL
                ORDER BY e.data_retirada ASC";
$stmt_ativos = $con->query($sql_ativos);
$emprestimos_ativos = $stmt_ativos->fetchAll();

$sql_historico = "SELECT 
                    l.titulo, 
                    a.nome AS nome_aluno,
                    e.data_retirada,
                    e.data_devolucao
                FROM cad_emprestimos e
                JOIN cad_livros l ON e.id_livro = l.id
                JOIN cad_alunos a ON e.id_aluno = a.id
                WHERE e.data_devolucao IS NOT NULL
                ORDER BY e.data_devolucao DESC
                LIMIT 20";
$stmt_historico = $con->query($sql_historico);
$emprestimos_historico = $stmt_historico->fetchAll();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Empréstimos</title>
    <link rel="stylesheet" href="../css/global.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css"/>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="../js/global.js"></script>
</head>
<body class="fundoAzul">
<aside>
    </aside>
<main id="content">
    <a class="new book" href="./novoEmprestimo.php"> 
        <i class="fa-solid fa-plus"></i>
        <h2>Novo Empréstimo Manual</h2>
    </a>

    <div class="table-container">
        <h2>Empréstimos Ativos (Não Devolvidos)</h2>
        <table class="responsive-table">
            <thead>
                <tr>
                    <th>Aluno</th>
                    <th>Livro</th>
                    <th>Data da Retirada</th>
                    <th>Ação</th>
                </tr>
            </thead>
            <tbody>
                <?php if (count($emprestimos_ativos) > 0): ?>
                    <?php foreach ($emprestimos_ativos as $emp): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($emp['nome_aluno']); ?></td>
                        <td><?php echo htmlspecialchars($emp['titulo']); ?></td>
                        <td><?php echo date('d/m/Y', strtotime($emp['data_retirada'])); ?></td>
                        <td>
                            <a href="../php/processa_devolucao.php?id_emprestimo=<?php echo $emp['id_emprestimo']; ?>" 
                               class="btn-devolver" 
                               onclick="return confirm('Confirmar devolução deste livro?');">
                                <i class="fa-solid fa-check"></i> Registrar Devolução
                            </a>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr><td colspan="4">Nenhum empréstimo ativo no momento.</td></tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

    <div class="table-container">
        <h2>Histórico de Devoluções (Últimos 20)</h2>
        <table class="responsive-table">
            <thead>
                <tr>
                    <th>Aluno</th>
                    <th>Livro</th>
                    <th>Retirada</th>
                    <th>Devolução</th>
                </tr>
            </thead>
            <tbody>
                <?php if (count($emprestimos_historico) > 0): ?>
                    <?php foreach ($emprestimos_historico as $emp): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($emp['nome_aluno']); ?></td>
                        <td><?php echo htmlspecialchars($emp['titulo']); ?></td>
                        <td><?php echo date('d/m/Y', strtotime($emp['data_retirada'])); ?></td>
                        <td><?php echo date('d/m/Y', strtotime($emp['data_devolucao'])); ?></td>
                    </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr><td colspan="4">Nenhum livro foi devolvido ainda.</td></tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</main>
</body>
</html>