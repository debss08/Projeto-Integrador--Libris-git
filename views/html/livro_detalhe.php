<?php
session_start();
include('php/conexao.php');

if (!isset($_GET['id'])) {
    header("Location: acervo.php");
    exit();
}

$id_livro = (int)$_GET['id'];

// Query com JOIN para pegar infos do livro, categoria e estoque
$sql = "SELECT l.*, c.nome_categoria, a.quantidade_disponivel 
        FROM cad_livros l
        JOIN cad_categorias c ON l.id_categoria = c.id
        LEFT JOIN cad_acervo a ON l.id = a.id_livro
        WHERE l.id = $id_livro";

$result = $conn->query($sql);

if ($result->num_rows == 0) {
    echo "Livro não encontrado.";
    exit();
}
$livro = $result->fetch_assoc();
$conn->close();
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title><?php echo htmlspecialchars($livro['titulo']); ?> - Libris</title>
    <link rel="stylesheet" href="css/global.css">
    <link rel="stylesheet" href="css/style.css">
    <style>
        .detalhe-container { display: flex; max-width: 1000px; margin: 2rem auto; gap: 2rem; }
        .detalhe-capa { width: 300px; }
        .detalhe-capa img { width: 100%; border-radius: 10px; }
        .detalhe-info { flex: 1; }
        .detalhe-info h1 { margin-top: 0; }
        .detalhe-info .disponivel { font-size: 1.2rem; font-weight: 600; color: #2dae7c; }
        .detalhe-info .indisponivel { font-size: 1.2rem; font-weight: 600; color: #dc3545; }
    </style>
</head>
<body>
    <header class="public-header">
        <a href="index.php" class="logo">Libris 📚</a>
        <nav class="public-nav">
            <a href="index.php">Início</a>
            <a href="acervo.php">Acervo</a>
            <?php if (isset($_SESSION['aluno_matricula'])): ?>
                <a href="area_aluno.php">Minha Conta</a>
                <a href="php/logout.php" class="btn-primary">Sair</a>
            <?php else: ?>
                <a href="login_aluno.php" class="btn-primary">Login Aluno</a>
            <?php endif; ?>
        </nav>
    </header>

    <main class="detalhe-container">
        <div class="detalhe-capa">
            <img src="<?php echo htmlspecialchars($livro['imagem_capa'] ? $livro['imagem_capa'] : 'images/capa-padrao.png'); ?>" alt="Capa de <?php echo htmlspecialchars($livro['titulo']); ?>">
        </div>
        <div class="detalhe-info">
            <h1><?php echo htmlspecialchars($livro['titulo']); ?></h1>
            <h3>por <?php echo htmlspecialchars($livro['autor']); ?></h3>
            <p><strong>Gênero:</strong> <?php echo htmlspecialchars($livro['nome_categoria']); ?></p>
            <p><strong>Lançamento:</strong> <?php echo date('d/m/Y', strtotime($livro['data_lancamento'])); ?></p>
            
            <p><?php echo nl2br(htmlspecialchars($livro['resumo'])); ?></p>
            
            <hr>

            <?php if ($livro['quantidade_disponivel'] > 0): ?>
                <p class="disponivel">Disponível (<?php echo $livro['quantidade_disponivel']; ?> em estoque)</p>
                
                <form action="php/processa_novo_emprestimo_aluno.php" method="POST">
                    <input type="hidden" name="id_livro" value="<?php echo $livro['id']; ?>">
                    <button type="submit" class="btn login">Pegar Emprestado</button>
                </form>

            <?php else: ?>
                <p class="indisponivel">Indisponível no momento</p>
            <?php endif; ?>

        </div>
    </main>
</body>
</html>