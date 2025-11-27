<?php
    require_once "../../php/models/Conexao.php";
    require_once "../../php/models/Livro.php";
    $livros = Livro::listarTodos(); // Busca os livros
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Libris - Nosso Acervo</title>
    <link rel="stylesheet" href="../../css/global.css">
    <link rel="stylesheet" href="../../css/public.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css"/>
</head>
<body>

    <header class="public-header">
        <a href="index.php" class="logo">✦ libris</a>
        <nav class="public-nav">
            <a href="index.php">Início</a>
            <a href="acervo.php">Acervo</a>
            <a href="area_aluno.php">Meus empréstimos</a>
            <a href="login_aluno.php" class="btn-login">Login</a>
            <a href="cadastro_aluno.php" class="btn-cadastrar">Cadastrar</a>
        </nav>
    </header>

    <main class="acervo-container">
        <div class="acervo-header">
            <h1>Nosso acervo</h1>
            <div class="search-bar">
                <i class="fa-solid fa-magnifying-glass"></i>
                <input type="text" class="input-search" placeholder="Procure por título, autor...">
            </div>
        </div>

        <div class="acervo-grid">
            <?php foreach ($livros as $livro): ?>
                <div class="book-card">
                    <img src="../../<?php echo htmlspecialchars($livro->imagem_capa ? $livro->imagem_capa : 'imagens/capa-padrao.png'); ?>" alt="Capa de <?php echo htmlspecialchars($livro->titulo); ?>">
                    <h3><?php echo htmlspecialchars($livro->titulo); ?></h3>
                    <p>Autor: <?php echo htmlspecialchars($livro->autor); ?></p>
                    <p>Categorias: <?php echo htmlspecialchars($livro->nome_categoria); ?></p>
                    </div>
            <?php endforeach; ?>
        </div>
    </main>

    <footer class="public-footer">
        </footer>

</body>
</html>