<?php
session_start();
// ATENÇÃO: A sessão do admin é 'admin_id' e 'admin_nome'
if (!isset($_SESSION['admin_id'])) { 
    header("Location: ../html/login_admin.html");
    exit();
}

require_once "../php/conexao.php";
require_once "../php/livro.php"; // Chama a nova classe Livro

$livros = Livro::listarTodos();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Acervo</title>
    <link rel="stylesheet" href="../css/global.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css"/>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="../js/global.js"></script>
</head>
<body class="fundoAzul">
<aside>
    <nav id="navBar">
        <div class="infosUser-menu flexRow">
            <i class="fa-regular fa-user"></i>
            <div class="flexColumn">
                <p class="bolder"><?php echo htmlspecialchars($_SESSION['admin_nome']);?></p>
            </div>
        </div>
        <ul class="navBar-list">
            <li><a href="./inicio.php" class="navBar-itemList"><i class="fa-solid fa-house"></i><p>Início</p></a></li>
            <li><a href="./emprestimos.php" class="navBar-itemList"><i class="fa-solid fa-cart-shopping"></i><p>Empréstimos</p></a></li>
            <li><a href="./biblio.php" class="navBar-itemList"><i class="fa-solid fa-book"></i><p>Acervo</p></a></li>
        </ul>
        <a class="logout flexRow" type="button" href="../php/logout.php"> <i class="fa-solid fa-right-from-bracket"></i><p>Logout</p>
        </a>
    </nav>
</aside>
<main id="content">
    <div class="searchFor">
        <input type="text" name="searchFor-input" id="searchFor-input" placeholder="Buscar..." class="input search">
        <i class="fa-solid fa-magnifying-glass"></i>
    </div>

    <a class="new book" href="./novoLivro.php"> 
        <i class="fa-solid fa-plus"></i>
        <h2>Novo livro</h2>
    </a>

    <?php if (count($livros) > 0): ?>
        <?php foreach ($livros as $l):?>
            <div class="item-book flexRow"> 
                <img src="../<?php echo htmlspecialchars($l->imagem_capa ? $l->imagem_capa : 'imagens/capa-padrao.png'); ?>" alt="Capa de <?php echo htmlspecialchars($l->titulo); ?>">
                <div class="flexColumn">
                    <h3><?php echo htmlspecialchars($l->titulo); ?></h3>
                    <p>
                        Autor: <?php echo htmlspecialchars($l->autor); ?> <br>
                        Gênero: <?php echo htmlspecialchars($l->nome_categoria); ?> <br>
                        Data de lançamento: <?php echo date('d/m/Y', strtotime($l->data_lancamento)); ?> <br>
                        Estoque: <strong><?php echo htmlspecialchars($l->quantidade_disponivel); ?></strong> / <?php echo htmlspecialchars($l->quantidade_total); ?> <br>
                    </p>
                    <p class="resumo">
                        <strong>Resumo:</strong> <?php echo htmlspecialchars($l->resumo); ?>
                    </p>
                    <div class="flexRow" style="gap: 1rem; margin-top: 10px;">
                        <a href="#" class="btn signin" style="padding: 0.5rem 1rem;">Editar</a>
                        <a href="#" class="btn login" style="background-color: #dc3545; padding: 0.5rem 1rem;">Excluir</a>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    <?php else: ?>
        <p style="margin: 2rem; background: white; padding: 1rem; border-radius: 10px;">Nenhum livro cadastrado ainda.</p>
    <?php endif; ?>
    </main>
</body>
</html>