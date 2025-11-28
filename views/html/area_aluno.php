<?php
session_start();
if (!isset($_SESSION['aluno_id']) || $_SESSION['nivel'] !== 'usuario') {
    header("Location: login_aluno.php");
    exit();
}

require_once "../../php/models/Conexao.php";
$con = Conexao::getConexao();
$id_aluno_logado = $_SESSION['aluno_id'];

// Query para Empréstimos ATIVOS
$sql_ativos = "SELECT l.titulo, l.imagem_capa, e.data_retirada
               FROM cad_emprestimos e
               JOIN cad_livros l ON e.id_livro = l.id
               WHERE e.id_aluno = :id_aluno AND e.data_devolucao IS NULL
               ORDER BY e.data_retirada DESC";
$stmt_ativos = $con->prepare($sql_ativos);
$stmt_ativos->bindParam(':id_aluno', $id_aluno_logado);
$stmt_ativos->execute();
$emprestimos_ativos = $stmt_ativos->fetchAll();

// Query para HISTÓRICO de Empréstimos
$sql_historico = "SELECT l.titulo, l.imagem_capa, e.data_retirada, e.data_devolucao
                  FROM cad_emprestimos e
                  JOIN cad_livros l ON e.id_livro = l.id
                  WHERE e.id_aluno = :id_aluno AND e.data_devolucao IS NOT NULL
                  ORDER BY e.data_devolucao DESC";
$stmt_historico = $con->prepare($sql_historico);
$stmt_historico->bindParam(':id_aluno', $id_aluno_logado);
$stmt_historico->execute();
$emprestimos_historico = $stmt_historico->fetchAll();
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Minha Conta - Libris</title>
    <link rel="stylesheet" href="../style/css/global.css">
    <link rel="stylesheet" href="../style/css/public.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css"/>
</head>
<body>
    <header class="public-header">
        <a href="index.php" class="logo">
            <img src="../style/imgs/logoLibris.svg" alt="">
        </a>
        <nav class="public-nav">
            <a href="index.php">Início</a>
            <a href="acervo.php">Nosso Acervo</a>
            <a href="../../php/util/logout.php" class="btn-primary">Sair</a> 
        </nav>
    </header>

    <main class="acervo-container">
        <h1>Olá, <?php echo htmlspecialchars($_SESSION['aluno_nome']); ?>!</h1>
        <p>Aqui está o status dos seus empréstimos.</p>

        <h2><i class="fa-solid fa-book"></i> Empréstimos Ativos</h2>
        <hr>
        <div class="acervo-grid">
            <?php if (count($emprestimos_ativos) > 0): ?>
                <?php foreach ($emprestimos_ativos as $livro): ?>
                    <div class="book-card">
                        <img src="<?php echo htmlspecialchars($livro['imagem_capa'] ? $livro['imagem_capa'] : 'imagens/capa-padrao.png'); ?>" alt="Capa">
                        <h3><?php echo htmlspecialchars($livro['titulo']); ?></h3>
                        <p>Retirado em: <?php echo date('d/m/Y', strtotime($livro['data_retirada'])); ?></p>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <p>Você não possui empréstimos ativos no momento.</p>
            <?php endif; ?>
        </div>

        <h2 style="margin-top: 3rem;"><i class="fa-solid fa-clock-rotate-left"></i> Histórico de Empréstimos</h2>
        <hr>
        <div class="acervo-grid">
             <?php if (count($emprestimos_historico) > 0): ?>
                <?php foreach ($emprestimos_historico as $livro): ?>
                    <div class="book-card" style="opacity: 0.7;"> <img src="../../<?php echo htmlspecialchars($livro['imagem_capa'] ? $livro['imagem_capa'] : 'imagens/capa-padrao.png'); ?>" alt="Capa">
                        <h3><?php echo htmlspecialchars($livro['titulo']); ?></h3>
                        <p>Devolver em: <?php echo date('d/m/Y', strtotime($livro['data_devolucao'])); ?></p>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <p>Você ainda não devolveu nenhum livro.</p>
            <?php endif; ?>
        </div>
    </main>
    <footer class="public-footer">
        <a href="index.php" class="logo">
            <img src="../style/imgs/logoLibris.svg" alt="">
        </a>
        <p>Copyright © IFSul 2025 | Desenvolvido por Débora de Oliveira e Vitória Pless</p>
        <nav class="footer-nav">
            <a href="acervo.php">Acervo</a>
            <a href="area_aluno.php">Meus empréstimos</a>
            <a href="login_admin.html">Painel administrativo</a>
        </nav>
    </footer>
</body>
</html>