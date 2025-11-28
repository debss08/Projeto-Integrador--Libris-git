<?php
session_start();
if (!isset($_SESSION['admin_id'])) { 
    header("Location: ./login_admin.html"); // Ajustado
    exit();
}
// Caminhos ajustados para a nova estrutura
require "../../php/models/Conexao.php"; 
require_once "../../php/models/Categoria.php";
$categorias = Categoria::listarTodas();
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <title>Cadastrar novo livro</title>
    <link rel="stylesheet" href="../style/css/global.css"> <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css"/>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="../js/global.js"></script>
</head>
<body class="fundoAzul">
    <aside>
        <nav id="navBar">
            <div class="infosUser-menu flexRow">
                <i class="fa-solid fa-user-gear"></i> <div class="flexColumn">
                    <p class="bolder">Admin: <?php echo htmlspecialchars($_SESSION['nome']);?></p>
                    <p>Nível: <?php echo htmlspecialchars(ucfirst($_SESSION['nivel']));?></p>
                </div>
            </div>
            <ul class="navBar-list">
                <li>
                    <a href="./inicio_admin.php" class="navBar-itemList">
                        <i class="fa-solid fa-house"></i>
                        <p>Início</p>
                    </a>
                </li>
                <li>
                    <a href="./gerenciar_usuarios.php" class="navBar-itemList">
                        <i class="fa-solid fa-users-gear"></i>
                        <p>Gerenciar Usuários</p>
                    </a>
                </li>
                <li>
                    <a href="./emprestimos.php" class="navBar-itemList">
                        <i class="fa-solid fa-cart-shopping"></i>
                        <p>Empréstimos</p>
                    </a>
                </li>
                <li>
                    <a href="./biblio.php" class="navBar-itemList">
                        <i class="fa-solid fa-book"></i>
                        <p>Acervo</p>
                    </a>
                </li>
            </ul>
            <a class="logout flexRow" type="button" href="../../php/util/logout.php">
                <i class="fa-solid fa-right-from-bracket"></i>
                <p>Logout</p>
            </a>
        </nav>
    </aside>
    <main id="content">
        <div class="item-book flexColumn">
            <div class="flexColumn">
                <h1>Novo livro</h1>
                <hr>
                <form action="../../php/controllers/ProcessaLivro.php" method="POST" enctype="multipart/form-data" class="flexColumn">
                    <label for="titulo">Título do livro</label>
                    <input type="text" id="titulo" name="titulo" class="input welcome" required>

                    <label for="autor">Autor</label>
                    <input type="text" id="autor" name="autor" class="input welcome" required>

                    <label for="resumo">Resumo</label>
                    <textarea id="resumo" name="resumo" class="input welcome" rows="4" required></textarea>

                    <label for="data_lancamento">Data de lançamento</label>
                    <input type="date" id="data_lancamento" name="data_lancamento" class="input welcome" required>

                    <label for="imagem">Imagem da capa</label>
                    <input type="file" id="imagem" name="imagem" accept="image/*" class="input welcome" required>

                    <label for="quantidade">Quantidade</label>
                    <input type="number" id="quantidade" name="quantidade" class="input welcome" required min="1">

                    <label for="categoria">Categoria</label> <button type="button" class="btn-add-categoria" id="btnAbrirModal" onclick="abrirModal()">+</button>
                    <select id="categoria" name="categoria" class="input welcome" required>
                        <option value="">Selecione uma categoria</option>
                        <?php foreach ($categorias as $c): ?>
                            <option value="<?= htmlspecialchars($c->getId(), ENT_QUOTES, 'UTF-8'); ?>">
                                <?= htmlspecialchars($c->getNome(), ENT_QUOTES, 'UTF-8'); ?>
                            </option>
                        <?php endforeach; ?>
                    </select>

                    <br>
                    <button type="submit" class="btn login">Registrar livro</button>
                </form>
            </div>
        </div>
    </main>

    <div id="modalCategoria" class="modal"> 

    </div>
</body>
</html>